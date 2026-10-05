/*!
 * hScroll.js
 * Author: Mr. Huang
 *
 */ (function () {
  function hScroll(options) {
    var self = this;
    //$.extend(defaults, options);
    self = Object.assign(
      self,
      {
        nav1: "", //导航栏
        nav2: "", //需要监听的内容
        check: "", //选中样式
      },
      options
    );
    self.init();
  }

  hScroll.prototype = {
    init: function () {
      var self = this,
        arr = [],
        kdiv = jQuery(self.nav2);
      for (var i = 0; i < kdiv.length; i++) {
        arr.push(jQuery(kdiv[i]).offset().top);
      }
      self.sctopFun(arr);
      jQuery(window).scroll(function (e) {
        self.sctopFun(arr);
      });
      jQuery(self.nav1).click(function (e) {
        jQuery("body,html").animate({
          scrollTop: arr[jQuery(this).index()] + "px",
        });
      });
    },
    sctopFun: function (arr) {
      var self = this;
      var scrollTop =
        document.body.scrollTop ||
        document.documentElement.scrollTop ||
        window.pageYOffset;
      var keys = 0,
        flag = true;
      for (var i = 0; i < arr.length; i++) {
        keys++;
        if (flag) {
          if (scrollTop >= arr[arr.length - keys] - 300) {
            jQuery(self.nav1)
              .eq(arr.length - keys)
              .addClass(self.checkClass)
              .siblings()
              .removeClass(self.checkClass);
            flag = false;
          } else {
            flag = true;
          }
        }
      }
    },
  };
  window.hScroll = hScroll;
})();
