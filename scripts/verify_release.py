from __future__ import annotations

import re
import sys
from pathlib import Path
from urllib.parse import urlparse

ROOT = Path(__file__).resolve().parents[1]
SITE = ROOT / "_site"
BASE = "https://aimats.air-admin8.co.jp/"

PAGES = {
    "top": ("index.html", BASE),
    "feature": ("feature/index.html", BASE + "feature/"),
    "function": ("function/index.html", BASE + "function/"),
    "case": ("case/index.html", BASE + "case/"),
    "price": ("price/index.html", BASE + "price/"),
    "faq": ("faq/index.html", BASE + "faq/"),
    "lp": ("lp/index.html", BASE + "lp/"),
}

errors: list[str] = []


def read(rel: str) -> str:
    path = SITE / rel
    if not path.exists():
        errors.append(f"missing page: {rel}")
        return ""
    return path.read_text(encoding="utf-8", errors="replace")


def resolve_local(page_rel: str, ref: str) -> Path | None:
    if not ref or ref.startswith(("#", "mailto:", "tel:", "javascript:", "data:")):
        return None
    if ref.startswith(("http://", "https://", "//")):
        return None
    clean = ref.split("?", 1)[0].split("#", 1)[0]
    if not clean:
        return None
    base = (SITE / page_rel).parent
    return (base / clean).resolve()


for name, (rel, canonical_expected) in PAGES.items():
    text = read(rel)
    if not text:
        continue

    title = re.findall(r"<title[^>]*>(.*?)</title>", text, re.I | re.S)
    if len(title) != 1 or not re.sub(r"\s+", " ", title[0]).strip():
        errors.append(f"{name}: title missing or duplicated")

    h1s = re.findall(r"<h1[^>]*>(.*?)</h1>", text, re.I | re.S)
    h1_texts = [re.sub(r"<[^>]+>", " ", h) for h in h1s]
    h1_texts = [re.sub(r"\s+", " ", h).strip() for h in h1_texts]
    if len(h1s) != 1 or not h1_texts[0]:
        errors.append(f"{name}: exactly one non-empty H1 required, got {len(h1s)}")

    descriptions = re.findall(
        r'<meta[^>]+name=["\']description["\'][^>]+content=["\']([^"\']+)["\']',
        text,
        re.I,
    )
    if len(descriptions) != 1:
        errors.append(f"{name}: meta description count={len(descriptions)}")

    canonicals = re.findall(
        r'<link[^>]+rel=["\']canonical["\'][^>]+href=["\']([^"\']+)["\']',
        text,
        re.I,
    )
    if canonicals != [canonical_expected]:
        errors.append(f"{name}: canonical={canonicals!r}, expected={canonical_expected}")

    for prop in ("og:title", "og:description", "og:url"):
        if text.count(f'property="{prop}"') != 1:
            errors.append(f"{name}: {prop} must exist once")

    if name == "faq" and "FAQPage" not in text:
        errors.append("faq: FAQPage schema missing")

    if "ATS採用管理システム" in re.sub(r"<script[\s\S]*?</script>", "", text, flags=re.I):
        errors.append(f"{name}: legacy ATS public label remains")

    for token in ("窶", "譁", "繝", "縺", "蜿", "\ufffd"):
        if token in text:
            errors.append(f"{name}: mojibake token {token}")

    for legacy in (
        'href="/aimats',
        "href='/aimats",
        'href="/lp/aimats',
        "href='/lp/aimats",
        "https://www.air-admin8.co.jp/aimats/",
        "https://www.air-admin8.co.jp/lp/aimats/",
    ):
        if legacy in text:
            errors.append(f"{name}: legacy public route remains: {legacy}")

    for forbidden in ("40,000", "80,000", "120,000", "4万円", "8万円", "12万円", "15日間", "30日間"):
        if forbidden in text:
            errors.append(f"{name}: unapproved commercial claim remains: {forbidden}")

    hrefs = re.findall(r'(?:href|src)=["\']([^"\']+)["\']', text, re.I)
    for ref in hrefs:
        local = resolve_local(rel, ref)
        if local is not None and SITE.resolve() in local.parents and not local.exists():
            errors.append(f"{name}: missing local asset/link target: {ref}")

top = read("index.html")
for expected in (
    "brand=aimats",
    "mi_type=lv1",
    "mi_type=lv2",
    "type=1",
):
    if expected not in top:
        errors.append(f"top: form migration marker missing: {expected}")

tracking = read("assets/js/aimats-r5.js")
for event in ("aimats_page_view", "aimats_cta_click"):
    if event not in tracking:
        errors.append(f"tracking: missing event {event}")
for pii in ("your-name", "c-name", "email", "tell", "phone", "telephone"):
    if pii in tracking.lower():
        errors.append(f"tracking: PII token referenced: {pii}")

for required in ("robots.txt", "sitemap.xml", "deploy-meta.json", ".nojekyll"):
    if not (SITE / required).exists():
        errors.append(f"missing release file: {required}")

if errors:
    print("AIMATS GitHub Pages release verification: FAILED")
    for error in errors:
        print("- " + error)
    sys.exit(1)

print("AIMATS GitHub Pages release verification: PASS")
print(f"- pages={len(PAGES)}")
print("- staging=noindex")
print("- form_backend=WADAX transition")
print("- seo_llmo=metadata+schema+sitemap+robots")
