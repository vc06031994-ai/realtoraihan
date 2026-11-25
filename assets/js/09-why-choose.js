/* 09-why-choose */
(function(){
  var sec   = document.getElementById('why-choose');
  if (!sec) return;
  var grid  = document.getElementById('wcGrid');
  var rows  = [].slice.call(document.querySelectorAll('.wcr'));
  var shots = [].slice.call(document.querySelectorAll('.wc__shot'));
  var num   = document.getElementById('wcNum');
  var lbl   = document.getElementById('wcLbl');
  var rail  = document.getElementById('wcRail');
  if (!rows.length || !shots.length || !num || !lbl || !rail) return;
  var reduce= window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var cur = 0, swapToken = 0;

  // Keep the first theme-provided photo visible; hide unused photo stack entries.
  shots.forEach(function(s,n){
    if (n !== 0) { s.hidden = true; return; }
    s.classList.add('is-on');
  });

  function pad(n){ return String(n).padStart(2,'0'); }

  function set(i, fromUser){
    if (i === cur) return;
    cur = i;

    rows.forEach(function(r,n){
      r.classList.toggle('is-active', n === i);
      r.setAttribute('aria-expanded', n === i ? 'true' : 'false');
    });
    // Keep one permanent photograph; selecting a benefit only updates its text.

    positionRail();

    // Caption swap with a small fade and a token guard.
    var token = ++swapToken;
    lbl.classList.add('swap');
    setTimeout(function(){
      if (token !== swapToken) return;
      lbl.textContent = rows[i].dataset.lbl;
      lbl.classList.remove('swap');
    }, reduce ? 0 : 180);
  }

  function positionRail(){
    var slot = 100/rows.length;
    num.textContent = pad(cur+1);
    rail.style.height = slot + '%';
    rail.style.top = (slot*cur) + '%';
    rail.style.transition = 'top .5s var(--ease-io),height .5s var(--ease-io)';
  }

  rows.forEach(function(r,n){
    r.addEventListener('pointerenter', function(e){ if (window.matchMedia('(min-width:1025px) and (hover: hover)').matches && e.pointerType !== 'touch') set(n, true); });
    r.addEventListener('focus', function(){ set(n, true); });
    r.addEventListener('click', function(){ set(n, true); });
    r.addEventListener('keydown', function(e){
      if(e.key === 'Enter' || e.key === ' '){e.preventDefault();set(n, true);}
    });
  });

  positionRail();

  var lines = [].slice.call(sec.querySelectorAll('.ln'));
  var revs  = [].slice.call(sec.querySelectorAll('.rv'));

  if (reduce || !('IntersectionObserver' in window)) {
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    rows.forEach(function(r){ r.classList.add('is-in'); });
    return;
  }

  new IntersectionObserver(function(es,o){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      lines.forEach(function(l,n){ setTimeout(function(){ l.classList.add('is-in'); }, 70+n*100); });
      o.disconnect();
    });
  },{threshold:.12}).observe(sec);

  var revIO = new IntersectionObserver(function(es){
    es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target);} });
  },{threshold:.2});
  revs.forEach(function(r){ revIO.observe(r); });

  var rowIO = new IntersectionObserver(function(es){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      var n = rows.indexOf(e.target);
      setTimeout(function(){ e.target.classList.add('is-in'); }, n*90);
      rowIO.unobserve(e.target);
    });
  },{threshold:.2});
  rows.forEach(function(r){ rowIO.observe(r); });
})();
