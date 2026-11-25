/* 10-faq */
(function(){
  var sec   = document.getElementById('faq');
  if (!sec) return;
  var list  = document.getElementById('fqList');
  if (!list) return;
  var cards = [].slice.call(list.querySelectorAll('.fqi'));
  if (!cards.length) return;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var open = 0; /* index of the open card — 01 is open on load */

  /* open exactly one card */
  function setOpen(i){
    open = Math.max(0, Math.min(cards.length - 1, i));
    cards.forEach(function(c, n){
      var on = n === open;
      c.classList.toggle('is-open', on);
      c.classList.toggle('is-past', n < open);
      c.querySelector('.fqi__btn').setAttribute('aria-expanded', on ? 'true' : 'false');
    });
  }

  /* Accordion selection changes content only. It does not move the document;
     page position remains under the visitor's control. */
  function goTo(i){
    setOpen(i);
  }


  cards.forEach(function(c, n){
    var btn = c.querySelector('.fqi__btn');
    btn.addEventListener('click', function(){
      /* clicking the open card closes it — the stack stays reachable */
      if (n === open) {
        c.classList.remove('is-open');
        c.querySelector('.fqi__btn').setAttribute('aria-expanded', 'false');
        c.classList.add('is-closed-by-user');
        return;
      }
      c.classList.remove('is-closed-by-user');
      goTo(n);
    });

    if (reduce || !window.matchMedia('(hover:hover)').matches) return;
    c.addEventListener('pointerenter', function(){ c.classList.add('is-host'); });
    c.addEventListener('pointerleave', function(){ c.classList.remove('is-host'); });
    c.addEventListener('pointermove', function(e){
      var b = c.getBoundingClientRect();
      c.style.setProperty('--mx', (e.clientX - b.left).toFixed(0) + 'px');
      c.style.setProperty('--my', (e.clientY - b.top).toFixed(0) + 'px');
    });
  });

  list.addEventListener('keydown', function(e){
    if (e.key === 'ArrowDown'){ e.preventDefault(); goTo(open + 1); }
    if (e.key === 'ArrowUp'){ e.preventDefault(); goTo(open - 1); }
  });

  /* ---------------- entry reveals ---------------- */
  var lines = [].slice.call(sec.querySelectorAll('.ln'));
  var revs  = [].slice.call(sec.querySelectorAll('.rv'));

  if (reduce || !('IntersectionObserver' in window)) {
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    cards.forEach(function(c){ c.classList.add('is-in'); });
  } else {
    new IntersectionObserver(function(es, o){
      es.forEach(function(e){
        if (!e.isIntersecting) return;
        lines.forEach(function(l, n){ setTimeout(function(){ l.classList.add('is-in'); }, 70 + n * 100); });
        o.disconnect();
      });
    }, { threshold:.12 }).observe(sec);

    var revIO = new IntersectionObserver(function(es){
      es.forEach(function(e){ if (e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target); } });
    }, { threshold:.2 });
    revs.forEach(function(r){ revIO.observe(r); });

    var cardIO = new IntersectionObserver(function(es){
      es.forEach(function(e){
        if (!e.isIntersecting) return;
        cardIO.unobserve(e.target);
        setTimeout(function(){ e.target.classList.add('is-in'); },
                   cards.indexOf(e.target) * 55);
      });
    }, { threshold:.08 });
    cards.forEach(function(c){ cardIO.observe(c); });
  }

  /* ---------------- scroll wiring ---------------- */
  var ticking = false;
  window.addEventListener('scroll', function(){
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(function(){
      ticking = false;
      if (reduce) return;
      var bg = sec.querySelector('.fq__bg img');
      if (!bg) return;
      var r = sec.getBoundingClientRect();
      if (r.bottom < -200 || r.top > window.innerHeight + 200) return;
      var p = (window.innerHeight - r.top) / (window.innerHeight + r.height);
      bg.style.transform = 'scale(1.08) translateY(' + ((p - .5) * -3).toFixed(2) + '%)';
    });
  }, { passive:true });

  setOpen(0);
})();
