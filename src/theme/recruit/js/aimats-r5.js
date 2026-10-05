(function () {
  'use strict';

  window.dataLayer = window.dataLayer || [];

  function pageType() {
    var p = window.location.pathname.replace(/\/+$/, '') || '/';
    if (p === '/aimats') return 'top';
    if (p === '/aimats/feature') return 'feature';
    if (p === '/aimats/function') return 'function';
    if (p === '/aimats/price') return 'price';
    if (p === '/aimats/faq') return 'faq';
    if (p.indexOf('/aimats/case') === 0) return 'case';
    if (p === '/lp/aimats') return 'lp';
    if (p === '/newcontact') return 'form';
    return 'other';
  }

  function classifyHref(href) {
    if (!href) return null;
    var h = href.toLowerCase();

    if (h.indexOf('/aimats/trial') >= 0 || (h.indexOf('/newcontact/') >= 0 && h.indexOf('mi_type=lv1') >= 0)) {
      return 'trial';
    }
    if (h.indexOf('/aimats/download') >= 0 || (h.indexOf('/newcontact/') >= 0 && h.indexOf('mi_type=lv2') >= 0)) {
      return 'download';
    }
    if (h.indexOf('/aimats/contact') >= 0 || (h.indexOf('/newcontact/') >= 0 && h.indexOf('type=1') >= 0)) {
      return 'contact';
    }
    if (h.indexOf('/aimats/function') >= 0) return 'function';
    if (h.indexOf('/aimats/feature') >= 0) return 'feature';
    if (h.indexOf('/aimats/faq') >= 0) return 'faq';
    if (h.indexOf('/aimats/case') >= 0) return 'case';

    return null;
  }

  function pushEvent(name, params) {
    var payload = params || {};
    payload.event = name;
    window.dataLayer.push(payload);
  }

  document.addEventListener('DOMContentLoaded', function () {
    var pType = pageType();

    pushEvent('aimats_page_view', {
      aimats_page_type: pType,
      aimats_path: window.location.pathname
    });

    document.addEventListener('click', function (event) {
      var link = event.target.closest ? event.target.closest('a[href]') : null;
      if (!link) return;

      var href = link.getAttribute('href') || '';
      var ctaType = classifyHref(href);
      if (!ctaType) return;

      pushEvent('aimats_cta_click', {
        aimats_page_type: pType,
        aimats_cta_type: ctaType,
        aimats_destination: href.split('?')[0]
      });
    }, true);
  });
})();
