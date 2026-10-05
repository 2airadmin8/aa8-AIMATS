<?php
// Product-site routing used by the shared product header.
$url = $_SERVER["REQUEST_URI"];
$product_name = "";

// IMPORTANT: aimats must be checked before ats because "aimats" contains "ats".
if (strstr($url, "aimats")) {
    $product_name = "aimats";
} elseif (strstr($url, "ats")) {
    $product_name = "ats";
} elseif (strstr($url, "erp")) {
    $product_name = "erp";
} elseif (strstr($url, "edi")) {
    $product_name = "edi";
} elseif (strstr($url, "sfa-crm")) {
    $product_name = "sfa-crm";
} elseif (strstr($url, "assets-management")) {
    $product_name = "assets-management";
} elseif (strstr($url, "ai-fas")) {
    $product_name = "ai-fas";
} elseif (strstr($url, "ai-meeting")) {
    $product_name = "ai-meeting";
} elseif (strstr($url, "legal")) {
    $product_name = "legal";
}

$case_path = $product_name === "aimats" ? "case" : "voice";
$faq_path = $product_name === "aimats" ? "faq" : "questions";
$contact_path = $product_name === "aimats" ? "/aimats/contact" : "/newcontact/?type=1";
?>
<header id="header" class="header header_origin header_front">
          <div class="header__inner">
            <div class="header-left">
              <div class="header-logo">
                <a
                  href="https://www.air-admin8.co.jp"
                  class="header-logo__link"
                >
                  <div class="header-logo__img-wrapper">
                    <img
                      src="images/header-logo.png"
                      alt="Air Admin8"
                      class="header-logo__img"
                    />
                  </div>
                </a>
              </div>
              <nav class="header-nav">
                <ul class="header-nav__list" style="display: flex">
                  <li class="header-nav__item">
                    <a
                      href="/<?php echo $product_name ?>/"
                      class="header-nav__link"
                    >
                      TOP
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a
                            href="/<?php echo $product_name ?>/feature"
                      class="header-nav__link"
                    >
                      特徴
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a
                            href="/<?php echo $product_name ?>/function"
                      class="header-nav__link"
                    >
                      機能
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a
                            href="/<?php echo $product_name ?>/<?php echo $case_path ?>"
                      class="header-nav__link"
                    >
                        導入事例
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a
                            href="/<?php echo $product_name ?>/price"
                      class="header-nav__link"
                    >
                      料金プラン
                    </a>
                  </li>
                  <li class="header-nav__item">
                    <a
                            href="/<?php echo $product_name ?>/<?php echo $faq_path ?>"
                      class="header-nav__link"
                    >
                      よくあるご質問
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="header-right">
              <div class="header-contact">
                <a
                  href="<?php echo $contact_path ?>"
                  class="header-contact__link lg"
                >
                  <dl>
                    <dt>お問い合わせ</dt>
					  	<dd>
							<div class="time">受付時間 10:00～17:00（土日祝祭日を除く）</div>
						</dd>
                  </dl>
                </a>
              </div>
            </div>

            <div class="header-hum-btn">
              <div class="header-hum-btn__box">
                <div class="header-hum-btn__bar header-hum-btn__bar_top"></div>
                <div
                  class="header-hum-btn__bar header-hum-btn__bar_middle"
                ></div>
                <div
                  class="header-hum-btn__bar header-hum-btn__bar_bottom"
                ></div>
              </div>
            </div>
          </div>
        </header>
<script>
    var cnGetUrlParam = function cnGetUrlParam( parameter ) {
        var pageURL = window.location.search.substring( 1 ),
            urlVars = pageURL.split( '&' ),
            parameterName,
            i;

        for ( i = 0; i < urlVars.length; i ++ ) {
            parameterName = urlVars[i].split( '=' );

            if ( parameterName[0] === parameter )
                return typeof parameterName[1] === undefined ? true : decodeURIComponent( parameterName[1] );
        }

        return false;
    };

    jQuery( document ).ready( function() {
        var welcome = false;
        welcome = cnGetUrlParam( 'target' );
        console.info(welcome )
        if ( welcome ) {
            var scroll_offset = jQuery("#"+welcome).offset();
            console.info(scroll_offset);
                jQuery("body,html").animate({ scrollTop: scroll_offset.top  }, 500);
            return false;
        }
    } );
</script>

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-NJQ86LN');
  </script>
  <!-- End Google Tag Manager -->
	
	<!-- Google tag (gtag.js) -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=G-8LRJCNSE0K"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8LRJCNSE0K');
</script>
