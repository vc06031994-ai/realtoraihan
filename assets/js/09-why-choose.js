/* 09-why-choose */
(function () {
  var sec = document.getElementById('why-choose');
  if (!sec) return;

  var rows = Array.prototype.slice.call(sec.querySelectorAll('.wcr'));
  if (!rows.length) return;

  function activate(index) {
    rows.forEach(function (row, rowIndex) {
      var active = rowIndex === index;
      row.classList.toggle('is-active', active);
      row.setAttribute('aria-expanded', active ? 'true' : 'false');
    });
  }

  rows.forEach(function (row, index) {
    row.addEventListener('pointerenter', function (event) {
      if (window.matchMedia('(min-width:1025px) and (hover: hover)').matches && event.pointerType !== 'touch') {
        activate(index);
      }
    });
    row.addEventListener('focus', function () { activate(index); });
    row.addEventListener('click', function () { activate(index); });
    row.addEventListener('keydown', function (event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        activate(index);
      }
    });
  });

  var lines = Array.prototype.slice.call(sec.querySelectorAll('.ln'));
  var revealItems = Array.prototype.slice.call(sec.querySelectorAll('.rv'));
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduceMotion || !('IntersectionObserver' in window)) {
    lines.concat(revealItems, rows).forEach(function (item) { item.classList.add('is-in'); });
    return;
  }

  var revealObserver = new IntersectionObserver(function (entries, observer) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-in');
      observer.unobserve(entry.target);
    });
  }, { threshold: 0.2 });

  lines.concat(revealItems, rows).forEach(function (item) { revealObserver.observe(item); });
})();
