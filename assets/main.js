/* Vertrieb im Handwerk - kleine Helfer, kein Framework. */
(function () {
  'use strict';

  /* --- Mobiles Menue --- */
  var toggle = document.getElementById('navToggle');
  var nav = document.getElementById('nav');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Menue schliessen' : 'Menue oeffnen');
    });

    nav.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* --- Schatten unter der Kopfzeile, sobald gescrollt wird --- */
  var header = document.getElementById('header');
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

  /* --- Aktiver Navigationspunkt --- */
  var links = document.querySelectorAll('.nav a[href^="#"]');
  var targets = [];
  Array.prototype.forEach.call(links, function (link) {
    var el = document.querySelector(link.getAttribute('href'));
    if (el) { targets.push({ link: link, el: el }); }
  });

  if (targets.length && 'IntersectionObserver' in window) {
    var spy = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        var match = targets.filter(function (t) { return t.el === entry.target; })[0];
        if (!match) { return; }
        if (entry.isIntersecting) {
          targets.forEach(function (t) { t.link.classList.remove('is-active'); });
          match.link.classList.add('is-active');
        }
      });
    }, { rootMargin: '-45% 0px -50% 0px' });
    targets.forEach(function (t) { spy.observe(t.el); });
  }

  /* --- Kontaktformular: baut in der Vorschau eine mailto-Nachricht --- */
  var form = document.getElementById('kontaktForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      var get = function (name) {
        var f = form.elements[name];
        return f && f.value ? f.value.trim() : '';
      };

      var betreff = 'Anfrage ueber die Website - ' + (get('betrieb') || get('name') || 'Kontakt');
      var body = [
        'Name: ' + get('name'),
        'Betrieb: ' + get('betrieb'),
        'E-Mail: ' + get('email'),
        'Telefon: ' + get('telefon'),
        '',
        'Nachricht:',
        get('nachricht')
      ].join('\n');

      window.location.href =
        'mailto:kontakt@example.de' +
        '?subject=' + encodeURIComponent(betreff) +
        '&body=' + encodeURIComponent(body);
    });
  }
})();
