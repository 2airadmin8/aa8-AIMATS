<?php
$url_para = $_SERVER["REQUEST_URI"];
$is_aimats_page = strpos($url_para, "/aimats") !== false;
$ats_footer_url = $is_aimats_page
  ? "https://www.air-admin8.co.jp/aimats/"
  : "https://www.air-admin8.co.jp/ats/";
$ats_footer_label = $is_aimats_page
  ? "AIマッチング採用管理"
  : "ATS(採用管理)・AIマッチング";

if (strstr($url_para, "/legal")) {
?>
<style>
  .footer {
    background: #F8F8F3 !important;
  }
</style>
<?php } ?>

<footer class="footer aa8-product-footer">
  <div class="aa8-product-footer__panel">
    <div class="aa8-product-footer__main">
      <div class="aa8-product-footer__brand">
        <a href="https://www.air-admin8.co.jp" class="aa8-product-footer__logo-link">
          <img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/assets/img/common/footer/footer-nav-top-left__logo.png" alt="Air Admin8" class="aa8-product-footer__logo">
        </a>
		  
        <p class="aa8-product-footer__company">株式会社AirAdmin8</p>
        <p class="aa8-product-footer__address">
          〒100-0004<br>
          東京都千代田区大手町一丁目9番2号<br>
          大手町フィナンシャルシティ グランキューブ18階
        </p>

        <ul class="aa8-product-footer__sns-list">
          <li class="aa8-product-footer__sns-item">
            <a href="https://www.youtube.com/channel/UC4fhdH9R4zNmvK99sDdQEQg" class="aa8-product-footer__sns-link" target="_blank" rel="noopener noreferrer">
              <img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/assets/img/common/footer/footer-sns__img01.png" alt="YouTube" class="aa8-product-footer__sns-img">
            </a>
          </li>
          <li class="aa8-product-footer__sns-item">
            <a href="https://www.instagram.com/airadmin8/" class="aa8-product-footer__sns-link" target="_blank" rel="noopener noreferrer">
              <img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/assets/img/common/footer/footer-sns__img02.png" alt="Instagram" class="aa8-product-footer__sns-img">
            </a>
          </li>
          <li class="aa8-product-footer__sns-item">
            <a href="https://twitter.com/_AirAdmi8" class="aa8-product-footer__sns-link" target="_blank" rel="noopener noreferrer">
              <img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/assets/img/common/footer/footer-sns__img03.png" alt="X" class="aa8-product-footer__sns-img">
            </a>
          </li>
          <li class="aa8-product-footer__sns-item">
            <a href="https://www.facebook.com/people/Air-Admin8/61551464017951/" class="aa8-product-footer__sns-link" target="_blank" rel="noopener noreferrer">
              <img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/assets/img/common/footer/facebook_logo.png" alt="Facebook" class="aa8-product-footer__sns-img">
            </a>
          </li>
        </ul>

        <div class="aa8-product-footer__isms-box">
          <p class="aa8-product-footer__isms-title">ISMS/ISO27001 認証取得</p>
          <div class="aa8-product-footer__isms-body">
            <img src="https://www.air-admin8.co.jp/aa82022/wp-content/themes/AirAdmin8/assets/img/common/footer/footer-nav-top-left__number-img02.png" alt="ISMS/ISO27001" class="aa8-product-footer__isms-img">
            <div class="aa8-product-footer__isms-text">
              <p>登録番号：IS247</p>
              <p>JIS Q 27001:2023</p>
              <p>ISO/IEC 27001:2022</p>
            </div>
          </div>
        </div>
      </div>

      <nav class="aa8-product-footer__nav">
        <div class="aa8-product-footer__col">
          <p class="aa8-product-footer__heading">サービス</p>
          <ul>
            <li><a href="https://www.air-admin8.co.jp/edi/" target="_blank" rel="noopener noreferrer">電子帳票EDI</a></li>
            <li><a href="<?php echo $ats_footer_url; ?>" target="_blank" rel="noopener noreferrer"><?php echo $ats_footer_label; ?></a></li>
            <li><a href="https://www.air-admin8.co.jp/erp/" target="_blank" rel="noopener noreferrer">クラウドERP(基幹システム)</a></li>
            <li><a href="https://www.air-admin8.co.jp/sfa-crm/">SFA・CRM営業支援</a></li>
            <li><a href="https://www.air-admin8.co.jp/assets-management/">資産管理</a></li>
            <li><a href="https://www.air-admin8.co.jp/ai-meeting/">WEB会議サービス「AImeeting」</a></li>
            <li><a href="https://www.air-admin8.co.jp/ai-fas/">AI顔認証勤怠管理</a></li>
            <li><a href="https://www.air-admin8.co.jp/legal/">弁護士向け基幹システム</a></li>
          </ul>
        </div>

        <div class="aa8-product-footer__col">
          <p class="aa8-product-footer__heading">導入・事例</p>
          <ul>
            <li><a href="https://www.air-admin8.co.jp/products">製品一覧</a></li>
            <li><a href="https://www.air-admin8.co.jp/case">導入事例</a></li>
            <li><a href="https://www.air-admin8.co.jp/column">コラム</a></li>
          </ul>
        </div>

        <div class="aa8-product-footer__col">
          <p class="aa8-product-footer__heading">サポート・セキュリティ</p>
          <ul>
            <li><a href="https://www.air-admin8.co.jp/security">セキュリティへの取り組み</a></li>
            <li><a href="https://www.air-admin8.co.jp/support">サポートサービス</a></li>
            <li><a href="https://www.air-admin8.co.jp/newcontact">お問い合わせ</a></li>
          </ul>
        </div>

        <div class="aa8-product-footer__col">
          <p class="aa8-product-footer__heading">会社情報</p>
          <ul>
            <li><a href="https://www.air-admin8.co.jp/company">会社概要</a></li>
            <li><a href="https://www.air-admin8.co.jp/company#access">アクセス</a></li>
            <li><a href="https://www.air-admin8.co.jp/recruit">採用情報</a></li>
          </ul>
        </div>
      </nav>
    </div>

    <nav class="aa8-product-footer__legal">
      <ul>
        <li><a href="https://www.air-admin8.co.jp/msa">MSA契約条項</a></li>
        <li><a href="https://www.air-admin8.co.jp/privacy-policy">プライバシーポリシー</a></li>
        <li><a href="https://www.air-admin8.co.jp/security-policy">セキュリティポリシー</a></li>
        <li><a href="https://www.air-admin8.co.jp/terms">利用規約</a></li>
        <li><a href="https://www.air-admin8.co.jp/isms">ISMS</a></li>
        <li><a href="https://www.air-admin8.co.jp/antisocial">反社会的勢力による被害の防止のための基本方針</a></li>
      </ul>
    </nav>

    <div class="aa8-product-footer__copyright">
      <p>© AirAdmin8 Co., Ltd. All Rights Reserved.</p>
    </div>
  </div>
</footer>

<div class="totop" id="totopdiv"><p>TOP</p></div>
