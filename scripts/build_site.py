from __future__ import annotations

import html
import json
import os
import posixpath
import re
import shutil
import subprocess
import sys
import time
import urllib.request
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SITE = ROOT / "_site"
THEME = ROOT / "src" / "theme"
CANONICAL_BASE = "https://aimats.air-admin8.co.jp/"
PRODUCTION = os.environ.get("AIMATS_PUBLIC", "0") == "1"

PAGES = [
    ("/aimats/", "", "index.html"),
    ("/aimats/feature", "feature", "feature/index.html"),
    ("/aimats/function", "function", "function/index.html"),
    ("/aimats/case/", "case", "case/index.html"),
    ("/aimats/price", "price", "price/index.html"),
    ("/aimats/faq", "faq", "faq/index.html"),
    ("/lp/aimats/", "lp", "lp/index.html"),
]

FORM_URLS = {
    "/aimats/trial": "https://www.air-admin8.co.jp/newcontact/?mi_type=lv1&cat=%E8%A3%BD%E5%93%81%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6&product=ATS&brand=aimats",
    "/aimats/download": "https://www.air-admin8.co.jp/newcontact/?mi_type=lv2&cat=%E8%A3%BD%E5%93%81%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6&product=ATS&brand=aimats",
    "/aimats/contact": "https://www.air-admin8.co.jp/newcontact/?type=1&cat=%E8%A3%BD%E5%93%81%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6&product=ATS&brand=aimats",
}

CORPORATE_PATHS = (
    "/security/",
    "/isms/",
    "/case/",
    "/privacy-policy/",
    "/security-policy/",
    "/terms/",
    "/msa/",
    "/antisocial/",
    "/support/",
    "/company/",
    "/recruit/",
    "/products/",
    "/column/",
)

ROUTE_MAP = {
    "/aimats/": "",
    "/aimats": "",
    "/aimats/feature": "feature",
    "/aimats/function": "function",
    "/aimats/case/": "case",
    "/aimats/case": "case",
    "/aimats/price": "price",
    "/aimats/faq": "faq",
    "/lp/aimats/": "lp",
    "/lp/aimats": "lp",
}


def relative_route(current: str, target: str) -> str:
    cur_dir = current or "."
    target_dir = target or "."
    rel = posixpath.relpath(target_dir, cur_dir)
    if rel == ".":
        return "./"
    return rel.rstrip("/") + "/"


def asset_prefix(current: str) -> str:
    return "" if not current else "../"


def rewrite_html(raw: str, current: str) -> str:
    prefix = asset_prefix(current)

    # Canonical / OGP / structured URLs: old production path -> future subdomain.
    replacements = [
        ("https://www.air-admin8.co.jp/lp/aimats/", CANONICAL_BASE + "lp/"),
        ("https://www.air-admin8.co.jp/aimats/feature", CANONICAL_BASE + "feature/"),
        ("https://www.air-admin8.co.jp/aimats/function", CANONICAL_BASE + "function/"),
        ("https://www.air-admin8.co.jp/aimats/case/", CANONICAL_BASE + "case/"),
        ("https://www.air-admin8.co.jp/aimats/case", CANONICAL_BASE + "case/"),
        ("https://www.air-admin8.co.jp/aimats/price", CANONICAL_BASE + "price/"),
        ("https://www.air-admin8.co.jp/aimats/faq", CANONICAL_BASE + "faq/"),
        ("https://www.air-admin8.co.jp/aimats/", CANONICAL_BASE),
    ]
    for old, new in replacements:
        raw = raw.replace(old, new)

    # Forms remain on the existing WADAX form backend during migration.
    for old, new in FORM_URLS.items():
        raw = raw.replace(f'href="{old}"', f'href="{new}"')
        raw = raw.replace(f"href='{old}'", f"href='{new}'")

    # Product-site navigation becomes relative so both github.io staging and custom domain work.
    for old, target in sorted(ROUTE_MAP.items(), key=lambda item: len(item[0]), reverse=True):
        new = relative_route(current, target)
        raw = raw.replace(f'href="{old}"', f'href="{new}"')
        raw = raw.replace(f"href='{old}'", f"href='{new}'")

    # Root links inside AIMATS source mean product home in the new standalone site.
    raw = raw.replace('href="/"', f'href="{relative_route(current, "")}"')

    # Corporate-only paths stay on the corporate domain.
    for corp in CORPORATE_PATHS:
        raw = raw.replace(f'href="{corp}"', f'href="https://www.air-admin8.co.jp{corp}"')
        raw = raw.replace(f"href='{corp}'", f"href='https://www.air-admin8.co.jp{corp}'")

    # Local AIMATS assets.
    raw = re.sub(r'(?P<attr>href|src)=(?P<q>["\'])css/', rf'\g<attr>=\g<q>{prefix}assets/css/', raw)
    raw = re.sub(r'(?P<attr>href|src)=(?P<q>["\'])js/', rf'\g<attr>=\g<q>{prefix}assets/js/', raw)
    raw = re.sub(r'(?P<attr>href|src)=(?P<q>["\'])images/', rf'\g<attr>=\g<q>{prefix}assets/images/', raw)

    theme_base = "https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/"
    raw = raw.replace(theme_base + "favicon.png", prefix + "assets/favicon.png")
    raw = raw.replace(theme_base + "libs/slick/", prefix + "assets/vendor/slick/")
    raw = raw.replace(theme_base + "libs/wow/", prefix + "assets/vendor/wow/")
    raw = raw.replace(theme_base + "landpage/ats/static/", prefix + "assets/lp/static/")
    raw = raw.replace(theme_base + "recruit/images/", prefix + "assets/images/")
    raw = raw.replace(theme_base + "recruit/js/aimats-r5.js", prefix + "assets/js/aimats-r5.js")
    raw = raw.replace(theme_base + "assets/img/common/footer/", prefix + "assets/corporate/footer/")

    # Staging is explicitly noindex until custom-domain cutover.
    if not PRODUCTION and 'name="robots"' not in raw.lower():
        marker = '<meta name="viewport" content="width=device-width, initial-scale=1">'
        marker2 = '<meta name="viewport" content="width=device-width,initial-scale=1">'
        robots = '<meta name="robots" content="noindex,nofollow,noarchive">'
        if marker in raw:
            raw = raw.replace(marker, marker + "\n  " + robots, 1)
        elif marker2 in raw:
            raw = raw.replace(marker2, marker2 + "\n  " + robots, 1)
        else:
            raw = raw.replace("<head>", "<head>\n  " + robots, 1)

    return raw


def patch_tracking_js() -> None:
    path = SITE / "assets" / "js" / "aimats-r5.js"
    if not path.exists():
        raise SystemExit("tracking JS missing")
    text = path.read_text(encoding="utf-8")
    old = """    if (p === '/aimats') return 'top';
    if (p === '/aimats/feature') return 'feature';
    if (p === '/aimats/function') return 'function';
    if (p === '/aimats/price') return 'price';
    if (p === '/aimats/faq') return 'faq';
    if (p.indexOf('/aimats/case') === 0) return 'case';
    if (p === '/lp/aimats') return 'lp';
    if (p === '/newcontact') return 'form';
"""
    new = """    if (p === '/' || /\\/aa8-AIMATS$/i.test(p)) return 'top';
    if (/\\/feature$/i.test(p)) return 'feature';
    if (/\\/function$/i.test(p)) return 'function';
    if (/\\/price$/i.test(p)) return 'price';
    if (/\\/faq$/i.test(p)) return 'faq';
    if (/\\/case$/i.test(p)) return 'case';
    if (/\\/lp$/i.test(p)) return 'lp';
    if (p.indexOf('/newcontact') >= 0) return 'form';
"""
    if old not in text:
        raise SystemExit("tracking pageType contract changed")
    text = text.replace(old, new)

    text = text.replace("if (h.indexOf('/aimats/function') >= 0) return 'function';", "if (/function\\/?(?:[?#].*)?$/.test(h)) return 'function';")
    text = text.replace("if (h.indexOf('/aimats/feature') >= 0) return 'feature';", "if (/feature\\/?(?:[?#].*)?$/.test(h)) return 'feature';")
    text = text.replace("if (h.indexOf('/aimats/faq') >= 0) return 'faq';", "if (/faq\\/?(?:[?#].*)?$/.test(h)) return 'faq';")
    text = text.replace("if (h.indexOf('/aimats/case') >= 0) return 'case';", "if (/case\\/?(?:[?#].*)?$/.test(h)) return 'case';")
    path.write_text(text, encoding="utf-8")


def copy_assets() -> None:
    shutil.copytree(THEME / "recruit" / "css", SITE / "assets" / "css", dirs_exist_ok=True)
    shutil.copytree(THEME / "recruit" / "js", SITE / "assets" / "js", dirs_exist_ok=True)
    shutil.copytree(THEME / "recruit" / "images", SITE / "assets" / "images", dirs_exist_ok=True)
    shutil.copytree(THEME / "landpage" / "ats" / "static", SITE / "assets" / "lp" / "static", dirs_exist_ok=True)
    shutil.copytree(THEME / "libs" / "slick", SITE / "assets" / "vendor" / "slick", dirs_exist_ok=True)
    shutil.copytree(THEME / "libs" / "wow", SITE / "assets" / "vendor" / "wow", dirs_exist_ok=True)
    shutil.copytree(
        THEME / "assets" / "img" / "common" / "footer",
        SITE / "assets" / "corporate" / "footer",
        dirs_exist_ok=True,
    )
    shutil.copy2(THEME / "favicon.png", SITE / "assets" / "favicon.png")


def fetch(url: str) -> str:
    with urllib.request.urlopen(url, timeout=30) as response:
        if response.status >= 400:
            raise RuntimeError(f"{url}: HTTP {response.status}")
        return response.read().decode("utf-8")


def write_seo_files() -> None:
    urls = [
        CANONICAL_BASE,
        CANONICAL_BASE + "feature/",
        CANONICAL_BASE + "function/",
        CANONICAL_BASE + "case/",
        CANONICAL_BASE + "price/",
        CANONICAL_BASE + "faq/",
        CANONICAL_BASE + "lp/",
    ]
    sitemap = [
        '<?xml version="1.0" encoding="UTF-8"?>',
        '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
    ]
    sitemap.extend(f"  <url><loc>{html.escape(url)}</loc></url>" for url in urls)
    sitemap.append("</urlset>")
    (SITE / "sitemap.xml").write_text("\n".join(sitemap) + "\n", encoding="utf-8")

    if PRODUCTION:
        robots = f"User-agent: *\nAllow: /\nSitemap: {CANONICAL_BASE}sitemap.xml\n"
    else:
        robots = "User-agent: *\nDisallow: /\n"
    (SITE / "robots.txt").write_text(robots, encoding="utf-8")


def write_deploy_meta() -> None:
    data = {
        "source": "2airadmin8/air-admin8.co.jp#feat/aimats-r5-integration",
        "source_sha": "eff2ba89e9b3caff00b6ae6e4f93bd481ce0077e",
        "site_repo": os.environ.get("GITHUB_REPOSITORY", "2airadmin8/aa8-AIMATS"),
        "site_sha": os.environ.get("GITHUB_SHA", "local"),
        "run_id": os.environ.get("GITHUB_RUN_ID", "local"),
        "mode": "production" if PRODUCTION else "staging-noindex",
    }
    (SITE / "deploy-meta.json").write_text(json.dumps(data, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")


def main() -> None:
    if SITE.exists():
        shutil.rmtree(SITE)
    SITE.mkdir(parents=True)
    copy_assets()

    proc = subprocess.Popen(
        ["php", "-S", "127.0.0.1:8787", "scripts/preview-router.php"],
        cwd=ROOT,
        stdout=subprocess.DEVNULL,
        stderr=subprocess.DEVNULL,
    )
    try:
        for _ in range(30):
            try:
                fetch("http://127.0.0.1:8787/aimats/")
                break
            except Exception:
                time.sleep(0.5)
        else:
            raise RuntimeError("PHP preview server did not start")

        for source_path, current, output_rel in PAGES:
            raw = fetch("http://127.0.0.1:8787" + source_path)
            output = SITE / output_rel
            output.parent.mkdir(parents=True, exist_ok=True)
            output.write_text(rewrite_html(raw, current), encoding="utf-8")
    finally:
        proc.terminate()
        try:
            proc.wait(timeout=5)
        except subprocess.TimeoutExpired:
            proc.kill()

    patch_tracking_js()
    write_seo_files()
    write_deploy_meta()
    (SITE / ".nojekyll").write_text("", encoding="utf-8")
    print(f"Built {len(PAGES)} AIMATS pages into {SITE}")


if __name__ == "__main__":
    main()
