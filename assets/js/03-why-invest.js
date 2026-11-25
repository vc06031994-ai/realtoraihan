/* 03-why-invest */
(function(){
  var sec   = document.getElementById('why-invest');
  if (!sec) return;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var lines = [].slice.call(sec.querySelectorAll('.ln'));
  var revs  = [].slice.call(sec.querySelectorAll('.rv'));
  var cards = [].slice.call(sec.querySelectorAll('.card'));

  if (reduce || !('IntersectionObserver' in window)) {
    sec.classList.add('is-live');
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    cards.forEach(function(c){ c.classList.add('is-in'); });
    return;
  }

  var headIO = new IntersectionObserver(function(es){
    es.forEach(function(e){
      if (!e.isIntersecting) return;
      sec.classList.add('is-live');
      lines.forEach(function(l,i){ setTimeout(function(){ l.classList.add('is-in'); }, 80+i*95); });
      headIO.unobserve(sec);
    });
  }, {threshold:.08});
  headIO.observe(sec);

  var revIO = new IntersectionObserver(function(es){
    es.forEach(function(e){ if (e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target); } });
  }, {threshold:.2, rootMargin:'0px 0px -6% 0px'});
  revs.forEach(function(r){ revIO.observe(r); });

  var cardIO = new IntersectionObserver(function(es){
    es.forEach(function(e){
      if (!e.isIntersecting) return;
      var el = e.target, i = cards.indexOf(el);
      setTimeout(function(){ el.classList.add('is-in'); }, (i % 3) * 90 + Math.floor(i/3) * 40);
      cardIO.unobserve(el);
    });
  }, {threshold:.2, rootMargin:'0px 0px -5% 0px'});
  cards.forEach(function(c){ cardIO.observe(c); });

  /* count 13 */
  var numEl = sec.querySelector('[data-count]');
  if (numEl) {
    new IntersectionObserver(function(es, o){
      es.forEach(function(e){
        if (!e.isIntersecting) return;
        var t0 = performance.now(), dur = 900;
        (function tick(t){
          var p = Math.min((t-t0)/dur, 1);
          numEl.textContent = Math.round(13 * (1 - Math.pow(1-p,3)));
          if (p < 1) requestAnimationFrame(tick);
        })(performance.now());
        o.disconnect();
      });
    }, {threshold:.6}).observe(numEl);
  }

  /* pointer spotlight */
  if (window.matchMedia('(hover:hover) and (min-width:900px)').matches) {
    var spot = sec.querySelector('.wi__spot');
    if (spot) {
      sec.addEventListener('pointermove', function(e){
        var r = sec.getBoundingClientRect();
        spot.style.setProperty('--mx', ((e.clientX-r.left)/r.width*100).toFixed(1)+'%');
        spot.style.setProperty('--my', ((e.clientY-r.top)/r.height*100).toFixed(1)+'%');
      });
    }
  }

  /* 3D tilt on each card (desktop) */
  if (!reduce && window.matchMedia('(hover:hover) and (min-width:900px)').matches) {
    cards.forEach(function(card){
      card.addEventListener('pointermove', function(e){
        var r = card.getBoundingClientRect();
        var x = (e.clientX-r.left)/r.width - .5;
        var y = (e.clientY-r.top)/r.height - .5;
        card.style.transform =
          'perspective(900px) rotateY('+(x*7).toFixed(2)+'deg) rotateX('+(-y*7).toFixed(2)+'deg) translateY(-4px)';
      });
      card.addEventListener('pointerleave', function(){
        card.style.transform = '';
      });
    });
  }

  /* tap-to-open the description on touch devices */
  if (window.matchMedia('(hover:none)').matches) {
    cards.forEach(function(card){
      card.addEventListener('click', function(e){
        if (card.dataset.open === 'true') return;
        e.preventDefault();
        cards.forEach(function(c){ c.dataset.open = 'false'; });
        card.dataset.open = 'true';
      });
    });
  }
})();
