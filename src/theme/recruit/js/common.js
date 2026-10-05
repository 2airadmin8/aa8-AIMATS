/*★★★★★★★★★★★★★★★★★★★★★★★★

 フォーム要素にkeyupイベントを設定する

★★★★★★★★★★★★★★★★★★★★★★★★*/

jQuery(document).ready(function () {
  jQuery("input,textarea").keyup(function () {
    jQuery(this).css("background-color", "#fffbd7");
  });
  //new contact
  // body > div > main > section > div.rightside > ul > li:nth-child(2)
  var ins=jQuery(".rightside >ul>li:nth-child(2)>a");
  //jQuery(ins).attr("href");
  jQuery(ins).attr("href",jQuery(ins).attr("href")+"&mi_type=lv2");

  console.info(ins);

});

/*★★★★★★★★★★★★★★★★★★★★★★★★

 ヘッダー・FV高さ調整

★★★★★★★★★★★★★★★★★★★★★★★★*/
const setHeaderHeight = () => {
  //初期化
  jQuery(":root").css("--header-height", "auto");

  //header高さ取得
  const headerHeight = jQuery(".header").innerHeight();

  //CSS変数定義
  jQuery(":root").css("--header-height", headerHeight + "px");
};

jQuery(window).on("load resize", function () {
  let width = jQuery(window).width();

  jQuery(window).resize(function () {
    if (width === jQuery(window).width()) {
      // 画面の横幅にサイズ変動がないので処理を終える
      return;
    }

    // 画面の横幅のサイズ変動があった時のみ高さを再計算する
    width = jQuery(window).width();
    setHeaderHeight();
  });

  // 初期化
  setHeaderHeight();
});

/*★★★★★★★★★★★★★★★★★★★★★★★★

 ヘッダーバー sticky

★★★★★★★★★★★★★★★★★★★★★★★★*/

jQuery(".header")
  .clone()
  .addClass("header_sticky")
  .removeClass("header_origin")
  .appendTo(".main");
var showClass = "header_sticky_show";

jQuery(window).on("load scroll", function () {
  var value = jQuery(this).scrollTop();
  if (value > 600) {
    jQuery(".header_sticky").addClass(showClass);
    jQuery(".pagetop").addClass("pagetop_show");
  } else {
    jQuery(".header_sticky").removeClass(showClass);
    jQuery(".pagetop").removeClass("pagetop_show");
  }
});

/*★★★★★★★★★★★★★★★★★★★★★★★★

 slick

★★★★★★★★★★★★★★★★★★★★★★★★*/
jQuery(window).on("load", function () {
  // jQuery('.front-logo__list').slick({
  //     infinite: true,
  //     slidesToShow: 6,
  //     slidesToScroll: 6,
  //     autoplay: true,
  //     autoplaySpeed: 0,//隣あう画像のスライドするまでの間隔時間
  //     speed: 30000,
  //     arrows: false,
  //     pauseOnFocus: false,
  //     pauseOnHover: false,
  //     adaptiveHeight: true,
  //     cssEase: 'linear',//開始から終了まで一定に変化する
  //     variableWidth: true
  // });

  jQuery(".front-fv-right__list").slick({
    arrows: false,
    centerMode: true,
    autoplay: true,
    autoplaySpeed: 3000,
    speed: 2000,
    infinite: true,
    dots: false,
    slidesToShow: "1",
    variableWidth: false,
    fade: true,
    centerPadding: "0",
  });

  jQuery(".front-fv-right__list").on(
    "beforeChange",
    function (event, slick, currentSlide, nextSlide) {
      if (nextSlide > 0) {
        //スライド1枚目以外
        jQuery(".front-fv-right__list").slick(
          "slickSetOption",
          "autoplaySpeed",
          2000,
          true
        );
      } else {
        //2周目以降のスライド1枚目
        jQuery(".front-fv-right__list").slick(
          "slickSetOption",
          "autoplaySpeed",
          2000,
          true
        );
      }
    }
  );
  jQuery(".front-case-bottom__list").slick({
    arrows: false,
    centerMode: true,
    autoplay: true,
    autoplaySpeed: 4000,
    infinite: true,
    dots: false,
    variableWidth: true,
    swipe: true,
  });
  jQuery(".front-column__list").slick({
    arrows: false,
    centerMode: false,
    autoplay: true,
    autoplaySpeed: 4000,
    infinite: true,
    dots: false,

    variableWidth: true,

    responsive: [
      {
        breakpoint: 768, //399px以下のサイズに適用
        settings: {
          centerMode: true,
        },
      },
    ],
  });
});

/*★★★★★★★★★★★★★★★★★★★★★★★★

ハンバーガーメニュー

★★★★★★★★★★★★★★★★★★★★★★★★*/

jQuery(".header_origin .header-hum-btn").on("click", function () {
  jQuery(".header_origin .header-hum-btn__bar_top").toggleClass(
    "header-hum-btn__bar_top_open"
  );
  jQuery(".header_origin .header-hum-btn__bar_middle").toggleClass(
    "header-hum-btn__bar_middle_open"
  );
  jQuery(".header_origin .header-hum-btn__bar_bottom").toggleClass(
    "header-hum-btn__bar_bottom_open"
  );

  jQuery(".header_origin .header-nav").toggleClass("header-nav_open");
  jQuery(".body").toggleClass("body_header-nav-open");
});
jQuery(".header_sticky .header-hum-btn").on("click", function () {
  jQuery(".header_sticky .header-hum-btn__bar_top").toggleClass(
    "header-hum-btn__bar_top_open"
  );
  jQuery(".header_sticky .header-hum-btn__bar_middle").toggleClass(
    "header-hum-btn__bar_middle_open"
  );
  jQuery(".header_sticky .header-hum-btn__bar_bottom").toggleClass(
    "header-hum-btn__bar_bottom_open"
  );

  jQuery(".header_sticky .header-nav").toggleClass("header-nav_open");
  jQuery(".body").toggleClass("body_header-nav-open");
});

jQuery(window).on("load", function () {
  jQuery(".header-nav__link").click(function (e) {
    jQuery(".header-hum-btn__bar_top").removeClass(
      "header-hum-btn__bar_top_open"
    );
    jQuery(".header-hum-btn__bar_middle").removeClass(
      "header-hum-btn__bar_middle_open"
    );
    jQuery(".header-hum-btn__bar_bottom").removeClass(
      "header-hum-btn__bar_bottom_open"
    );

    jQuery(".header-nav").removeClass("header-nav_open");
    jQuery(".body").removeClass("body_header-nav-open");
  });
});

jQuery(window).on("load", function () {
  jQuery("body").removeClass("preload");
});
new WOW({
  mobile: false,
}).init();

jQuery(window).on("load", function () {
  jQuery('a[href^="#"]').click(function () {
    var adjust = 0;
    var speed = 400;
    var href = jQuery(this).attr("href");
    var target = jQuery(href == "#" || href == "" ? "html" : href);
    var position = target.offset().top + adjust;
    jQuery("body,html").animate({ scrollTop: position }, speed, "swing");
    return false;
  });

  jQuery(".company-nav__link ").on("click", function () {
    jQuery(".company-nav__link").removeClass("company-nav__link_active");
    jQuery(this).addClass("company-nav__link_active");
  });

  jQuery(".front-news-tab__item").click(function () {
    var index = jQuery(".front-news-tab__item").index(this);
    jQuery(".front-news-tab__item, .front-news-category__item").removeClass(
      "active"
    );
    jQuery(this).addClass("active");
    jQuery(".front-news-category__item").eq(index).addClass("active");
  });

  jQuery(".aboutqa li .down").click(function () {
    jQuery(this).toggleClass("on");
    jQuery(this).parent().next("dd").slideToggle();
  });
  jQuery(".totop").click(function () {
    jQuery("body,html").animate({ scrollTop: 0 }, 500);
    return false;
  });
  jQuery(".usetop .d .tabtitle > li .box").click(function () {
    jQuery(this).next(".down").slideDown();
  });
  jQuery(".usetop .d .tabtitle > li .down .close").click(function () {
    jQuery(this).parent().slideUp();
  });

  jQuery(window).bind("scroll", function () {
    var sTop = jQuery(window).scrollTop();
    var sTop = parseInt(sTop);
    if (sTop >= 300) {
      jQuery(".totop").show();
    } else {
      jQuery(".totop").hide();
    }
  });
  jQuery(".rightside .close").click(function () {
    jQuery(".rightside").hide();
    var now = Date.parse(new Date);
    // var pass_time = Number(localStorage.getItem("pass_time"));
    // if (pass_time <= now){
      window.localStorage.setItem('pass_time',(now + 1500000));
    // }
  });
  // jQuery(".newpagetwo .bd ul li").click(function () {
  //   jQuery(".mask").show();
  // });
  jQuery(".mask .close").click(function () {
    jQuery(".mask").hide();
    // jQuery(".mask video").trigger("pause");
  });
  jQuery(".guanbi").click(function () {
    jQuery(".mask").hide();
    // jQuery(".mask video").trigger("pause");
  });
  jQuery(".videobtn").click(function () {
    jQuery(".mask").show();
  });


  jQuery("#btn1").click(function () {
    jQuery("#mask1").show();
  });
  jQuery("#btn2").click(function () {
    jQuery("#mask2").show();
  });
  jQuery("#btn3").click(function () {
    jQuery("#mask3").show();
  });
  jQuery("#btn4").click(function () {
    jQuery("#mask4").show();
  });
  jQuery("#btn5").click(function () {
    jQuery("#mask5").show();
  });
  jQuery("#btn6").click(function () {
    jQuery("#mask6").show();
  });
  jQuery("#btn7").click(function () {
    jQuery("#mask7").show();
  });
  jQuery("#btn8").click(function () {
    jQuery("#mask8").show();
  });
  jQuery("#btn9").click(function () {
    jQuery("#mask9").show();
  });
  jQuery("#btn10").click(function () {
    jQuery("#mask10").show();
  });
  jQuery("#btn11").click(function () {
    jQuery("#mask11").show();
  });
  jQuery("#btn12").click(function () {
    jQuery("#mask12").show();
  });
  jQuery("#btn13").click(function () {
    jQuery("#mask13").show();
  });
  jQuery("#btn14").click(function () {
    jQuery("#mask14").show();
  });
  jQuery("#btn15").click(function () {
    jQuery("#mask15").show();
  });
  jQuery("#btn16").click(function () {
    jQuery("#mask16").show();
  });
  jQuery("#btn17").click(function () {
    jQuery("#mask17").show();
  });
  jQuery("#btn18").click(function () {
    jQuery("#mask18").show();
  });
  jQuery("#btn19").click(function () {
    jQuery("#mask19").show();
  });
  jQuery("#btn20").click(function () {
    jQuery("#mask20").show();
  });
  jQuery("#btn21").click(function () {
    jQuery("#mask21").show();
  });
  jQuery("#btn22").click(function () {
    jQuery("#mask22").show();
  });
  jQuery("#btn23").click(function () {
    jQuery("#mask23").show();
  });
  jQuery("#btn24").click(function () {
    jQuery("#mask24").show();
  });
  jQuery("#btn25").click(function () {
    jQuery("#mask25").show();
  });
  jQuery("#btn26").click(function () {
    jQuery("#mask26").show();
  });
  jQuery("#btn27").click(function () {
    jQuery("#mask27").show();
  });
  jQuery("#btn28").click(function () {
    jQuery("#mask28").show();
  });
  jQuery("#btn29").click(function () {
    jQuery("#mask29").show();
  });
  jQuery("#btn30").click(function () {
    jQuery("#mask30").show();
  });

});
