# AirAdmin8 AIMATS

AIマッチング採用管理 AIMATS のGitHub-native製品サイトです。

## Architecture

- Source SSOT: GitHub
- Static hosting: GitHub Pages
- Target domain: https://aimats.air-admin8.co.jp/
- Build: PHP templates -> static HTML
- CI/CD: GitHub Actions
- SEO/LLMO: metadata / Schema.org / sitemap / robots をCIで検証
- Form: 移行初期は既存WADAXフォームへ接続。後続でAPI/GASへ分離予定。

## Release phases

1. GitHub Pages staging (github.io) / noindex
2. Visual + Form routing QA
3. Custom domain aimats.air-admin8.co.jp
4. Public index enable
5. Existing www.air-admin8.co.jp/aimats/ -> 301 migration

## Source baseline

- Upstream repo: 2airadmin8/air-admin8.co.jp
- Branch: feat/aimats-r5-integration
- Baseline SHA: eff2ba89e9b3caff00b6ae6e4f93bd481ce0077e
