/* 08-testimonials */
(function(){
  var sec   = document.getElementById('testimonials');
  var track = document.getElementById('tsTrack');
  if (!sec || !track) return;
  var cards = [].slice.call(track.querySelectorAll('.tcard'));
  if (!cards.length) return;
  var dots  = [].slice.call(document.querySelectorAll('.ts__dot'));
  var prev  = document.getElementById('tsPrev');
  var next  = document.getElementById('tsNext');
  var reduce= window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var n = cards.length;
  var cur = 0;
  var autoplayId = null;
  var sizingFrame = 0;

  function layout(){
    cards.forEach(function(card, i){
      var d = i - cur;
      // Wrap to shortest path in the carousel ring.
      if (d > n/2) d -= n;
      if (d < -n/2) d += n;
      var pos;
      if (d === 0) pos = '0';
      else if (Math.abs(d) === 1) pos = String(d);
      else if (Math.abs(d) === 2) pos = String(d);
      else pos = 'far';
      card.dataset.pos = pos;
      card.setAttribute('aria-hidden', d === 0 ? 'false' : 'true');
      card.setAttribute('aria-label', (i+1) + ' of ' + n);
    });
    dots.forEach(function(d, i){
      d.setAttribute('aria-current', i === cur ? 'true' : 'false');
    });
  }

  function go(k){
    cur = (k + n) % n;
    layout();
    cards.forEach(function(c){ if(c._checkReview) c._checkReview(); });
    sizeActiveCard();
    restart();
  }

  function restart(){
    if (reduce) return;
    clearInterval(autoplayId);
    autoplayId = setInterval(function(){ go(cur+1); }, 7000);
  }

  if (prev) prev.addEventListener('click', function(){ go(cur-1); });
  if (next) next.addEventListener('click', function(){ go(cur+1); });
  dots.forEach(function(d,i){ d.addEventListener('click', function(){ go(i); }); });

  // Measure every desktop slide's full content height and apply the same
  // height to all cards, so short reviews never render as shorter cards.
  function sizeActiveCard(){
    var stage = track.closest('.ts__stage');
    if (!stage) return;

    // First measure the natural four-line collapsed cards.
    cards.forEach(function(card){
      card.style.height = 'auto';
      card.style.minHeight = '0';
      card.style.boxSizing = 'border-box';
    });
    track.style.height = 'auto';
    track.style.minHeight = '0';
    stage.style.minHeight = '';

    var baseHeight = 1;
    cards.forEach(function(card){
      var quote = card.querySelector('.tcard__quote');
      if (quote) quote.classList.remove('is-expanded');
      baseHeight = Math.max(baseHeight, Math.ceil(card.getBoundingClientRect().height));
    });

    // Keep every collapsed card identical in height. Only the card whose
    // Read more control is open is allowed to grow to show its full review.
    cards.forEach(function(card){
      card.style.height = baseHeight + 'px';
      card.style.minHeight = baseHeight + 'px';
    });

    var expandedCard = cards.find(function(card){
      var quote = card.querySelector('.tcard__quote');
      return quote && quote.dataset.expanded === 'true';
    });
    var finalHeight = baseHeight;

    if (expandedCard) {
      var expandedQuote = expandedCard.querySelector('.tcard__quote');
      expandedQuote.classList.add('is-expanded');
      var expandedHeight = Math.ceil(expandedCard.scrollHeight);
      expandedCard.style.height = expandedHeight + 'px';
      expandedCard.style.minHeight = expandedHeight + 'px';
      finalHeight = Math.max(baseHeight, expandedHeight);
    }

    track.style.height = finalHeight + 'px';
    track.style.minHeight = finalHeight + 'px';
    if (window.matchMedia('(min-width:1025px)').matches) {
      stage.style.minHeight = Math.max(finalHeight, 380) + 'px';
    } else {
      stage.style.minHeight = finalHeight + 'px';
    }
  }

  function scheduleSizing(){
    cancelAnimationFrame(sizingFrame);
    sizingFrame = requestAnimationFrame(sizeActiveCard);
  }

  cards.forEach(function(card){
    var quote = card.querySelector('.tcard__quote');
    var more  = card.querySelector('.tcard__readmore');
    if (!quote || !more) return;

    function checkLong(){
      quote.classList.remove('is-expanded');
      quote.dataset.expanded = 'false';
      more.hidden = true;
      more.setAttribute('aria-expanded','false');
      more.textContent = 'Read more';
      // Show Read more only when the review exceeds the four-line preview.
      more.hidden = quote.scrollHeight <= quote.clientHeight + 3;
    }

    more.addEventListener('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      var expanded = quote.classList.toggle('is-expanded');
      quote.dataset.expanded = expanded ? 'true' : 'false';
      more.setAttribute('aria-expanded', expanded ? 'true' : 'false');
      more.textContent = expanded ? 'Read less' : 'Read more';
      scheduleSizing();
    });

    card._checkReview = checkLong;
    checkLong();
  });

  window.addEventListener('resize', function(){
    cards.forEach(function(c){ if(c._checkReview) c._checkReview(); });
    scheduleSizing();
  });

  cards.forEach(function(card, i){
    card.addEventListener('click', function(){ if (i !== cur) go(i); });
    card.addEventListener('keydown', function(e){
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); go(i); }
    });
  });

  document.addEventListener('keydown', function(e){
    if (!sec.contains(document.activeElement)) return;
    if (e.key === 'ArrowLeft') go(cur-1);
    if (e.key === 'ArrowRight') go(cur+1);
  });

  // Swipe navigation.
  var sx = 0, sy = 0, swiping = false;
  track.addEventListener('touchstart', function(e){
    sx = e.touches[0].clientX;
    sy = e.touches[0].clientY;
    swiping = true;
  }, {passive:true});
  track.addEventListener('touchend', function(e){
    if (!swiping) return;
    swiping = false;
    var dx = e.changedTouches[0].clientX - sx;
    var dy = e.changedTouches[0].clientY - sy;
    if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) go(dx < 0 ? cur+1 : cur-1);
  }, {passive:true});

  // Pause autoplay while the user interacts with the carousel.
  sec.addEventListener('pointerenter', function(){ clearInterval(autoplayId); });
  sec.addEventListener('pointerleave', restart);
  sec.addEventListener('focusin', function(){ clearInterval(autoplayId); });

  // Reveal animations.
  var lines = [].slice.call(sec.querySelectorAll('.ln'));
  var revs  = [].slice.call(sec.querySelectorAll('.rv'));
  if (reduce || !('IntersectionObserver' in window)){
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    layout();
  } else {
    new IntersectionObserver(function(es,o){
      es.forEach(function(e){
        if(!e.isIntersecting) return;
        lines.forEach(function(l,n){ setTimeout(function(){ l.classList.add('is-in'); }, 80+n*100); });
        o.disconnect();
      });
    },{threshold:.12}).observe(sec);
    var revIO = new IntersectionObserver(function(es){
      es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target); } });
    },{threshold:.2});
    revs.forEach(function(r){ revIO.observe(r); });
    layout();
  }

  cards.forEach(function(c){ if(c._checkReview) c._checkReview(); });
  scheduleSizing();
  if (document.fonts && document.fonts.ready){
    document.fonts.ready.then(scheduleSizing);
  }
  window.addEventListener('load', scheduleSizing, {once:true});
  restart();
})();