/* 02-intro */
(function(){
  var sec   = document.getElementById('intro');
  if (!sec) return;
  var media = sec.querySelector('.s2__media');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var lines  = [].slice.call(sec.querySelectorAll('.ln'));
  var revs   = [].slice.call(sec.querySelectorAll('.rv'));
  var stats  = [].slice.call(sec.querySelectorAll('.stat2'));
  var pull   = sec.querySelector('.s2__pull');

  /* ---------- count-up ---------- */
  function countUp(el){
    var target = +el.dataset.count; if (!target) return;
    var suf = el.dataset.suffix || '';
    var dur = 1200, t0 = performance.now();
    function tick(t){
      var p = Math.min((t - t0) / dur, 1);
      var e = 1 - Math.pow(1 - p, 3);
      el.innerHTML = Math.round(target * e) + (suf ? '<small>' + suf + '</small>' : '');
      if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  /* ---------- reduced motion / no IO ---------- */
  if (reduce || !('IntersectionObserver' in window)) {
    sec.classList.add('is-live');
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    stats.forEach(function(s){ s.classList.add('is-in'); });
    if (pull) pull.classList.add('is-in');
    if (media) media.classList.add('is-in');
    return;
  }

  /* ---------- staggered line + block reveals ---------- */
  var secIO = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (!e.isIntersecting) return;
      sec.classList.add('is-live');
      lines.forEach(function(l, i){
        setTimeout(function(){ l.classList.add('is-in'); }, 90 + i * 105);
      });
      secIO.unobserve(sec);
    });
  }, {threshold:.12});
  secIO.observe(sec);

  var blockIO = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (!e.isIntersecting) return;
      var el = e.target, d = +el.dataset.d || 0;
      setTimeout(function(){ el.classList.add('is-in'); }, d);
      blockIO.unobserve(el);
    });
  }, {threshold:.15, rootMargin:'0px 0px -6% 0px'});

  revs.forEach(function(r, i){
    r.dataset.d = Math.min(i, 6) * 90;
    blockIO.observe(r);
  });
  if (pull) blockIO.observe(pull);
  if (media) blockIO.observe(media);

  /* ---------- stats: dividers + counters ---------- */
  var statIO = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (!e.isIntersecting) return;
      e.target.classList.add('is-in');
      statIO.unobserve(e.target);
    });
  }, {threshold:.4});
  stats.forEach(function(s){ statIO.observe(s); });

  var numIO = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if (!e.isIntersecting) return;
      countUp(e.target);
      numIO.unobserve(e.target);
    });
  }, {threshold:.6});
  [].slice.call(sec.querySelectorAll('[data-count]')).forEach(function(n){ numIO.observe(n); });

  /* ---------- scroll parallax on the image ---------- */
  var ticking = false;
  function onScroll(){
    if (ticking || !media) return;
    ticking = true;
    requestAnimationFrame(function(){
      var r = media.getBoundingClientRect();
      var vh = window.innerHeight;
      if (r.bottom > 0 && r.top < vh) {
        var progress = (r.top + r.height / 2 - vh / 2) / vh;  /* -1 .. 1 */
        media.style.setProperty('--py', (progress * -26).toFixed(2) + 'px');
      }
      ticking = false;
    });
  }
  window.addEventListener('scroll', onScroll, {passive:true});
  window.addEventListener('resize', onScroll);
  onScroll();

  /* ---------- pointer tilt (desktop only) ---------- */
  var tilt = media && media.querySelector('.s2__tilt');
  if (tilt && window.matchMedia('(hover:hover) and (min-width:900px)').matches) {
    media.addEventListener('pointermove', function(e){
      var r = media.getBoundingClientRect();
      var x = (e.clientX - r.left) / r.width  - .5;
      var y = (e.clientY - r.top ) / r.height - .5;
      tilt.style.setProperty('--ry', (x * 7).toFixed(2) + 'deg');
      tilt.style.setProperty('--rx', (-y * 7).toFixed(2) + 'deg');
      tilt.style.transition = 'transform .18s linear';
    });
    media.addEventListener('pointerleave', function(){
      tilt.style.setProperty('--ry','0deg');
      tilt.style.setProperty('--rx','0deg');
      tilt.style.transition = 'transform .6s cubic-bezier(.16,1,.3,1)';
    });
  }
})();
