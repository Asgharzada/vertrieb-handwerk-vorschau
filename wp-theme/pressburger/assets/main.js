/* Pressburger Consulting - kleine Helfer, kein Framework.
   Menue, Formular und Logo uebernimmt WordPress selbst. */
(function () {
  'use strict';

  /* --- Schatten unter der Kopfzeile, sobald gescrollt wird --- */
  var header = document.querySelector('.site-header');
  if (header) {
    var onScroll = function () {
      header.classList.toggle('is-stuck', window.scrollY > 8);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* --- Abschnitte beim Scrollen einblenden --- */
  var items = document.querySelectorAll('.reveal');
  if (!('IntersectionObserver' in window)) {
    Array.prototype.forEach.call(items, function (el) { el.classList.add('is-visible'); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    Array.prototype.forEach.call(items, function (el) { io.observe(el); });
  }

  /* --- Aktiver Navigationspunkt (nur auf der Startseite sinnvoll) --- */
  var links = document.querySelectorAll('.site-header .wp-block-navigation-item__content[href*="#"]');
  var targets = [];
  Array.prototype.forEach.call(links, function (link) {
    var hash = link.getAttribute('href').split('#')[1];
    var el = hash ? document.getElementById(hash) : null;
    if (el) { targets.push({ item: link.closest('.wp-block-navigation-item'), el: el }); }
  });

  if (targets.length && 'IntersectionObserver' in window) {
    var spy = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        var match = targets.filter(function (t) { return t.el === entry.target; })[0];
        if (match && entry.isIntersecting) {
          targets.forEach(function (t) { t.item.classList.remove('is-active'); });
          match.item.classList.add('is-active');
        }
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    targets.forEach(function (t) { spy.observe(t.el); });
  }
})();
