/* 04-services */
(function(){
  var sec    = document.getElementById('services');
  if (!sec) return;
  var cards  = [].slice.call(sec.querySelectorAll('.bento'));
  var lines  = [].slice.call(sec.querySelectorAll('.ln'));
  var revs   = [].slice.call(sec.querySelectorAll('.rv'));
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduce || !('IntersectionObserver' in window)) {
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    cards.forEach(function(c){ c.classList.add('is-in'); });
    return;
  }

  new IntersectionObserver(function(es,o){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      lines.forEach(function(l,n){ setTimeout(function(){ l.classList.add('is-in'); }, 70+n*95); });
      o.disconnect();
    });
  },{threshold:.12}).observe(sec);

  var revIO = new IntersectionObserver(function(es){
    es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target);} });
  },{threshold:.2});
  revs.forEach(function(r){ revIO.observe(r); });

  var cardIO = new IntersectionObserver(function(es){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      var n = cards.indexOf(e.target);
      setTimeout(function(){ e.target.classList.add('is-in'); }, n*70);
      cardIO.unobserve(e.target);
    });
  },{threshold:.12,rootMargin:'0px 0px -4% 0px'});
  cards.forEach(function(c){ cardIO.observe(c); });

  /* Accessible horizontal services slider */
  var slider = sec.querySelector("[data-services-slider]");
  if (slider) {
    var track = slider.querySelector(".sv__slider-track");
    var viewport = slider.querySelector(".sv__slider-viewport");
    var prev = slider.querySelector(".sv__slider-prev");
    var next = slider.querySelector(".sv__slider-next");
    var dotsWrap = slider.querySelector(".sv__slider-dots");
    if (track && viewport && prev && next && dotsWrap && cards.length) {
    var index = 0;
    var perView = function(){ return window.matchMedia("(max-width:560px)").matches ? 1 : (window.matchMedia("(max-width:1024px)").matches ? 2 : 3); };
    var maxIndex = function(){ return Math.max(0, cards.length - perView()); };
    var gap = function(){ return parseFloat(window.getComputedStyle(track).gap) || 0; };
    var step = function(){ return cards.length ? cards[0].getBoundingClientRect().width + gap() : 0; };
    var renderDots = function(){ dotsWrap.innerHTML=""; var total=maxIndex()+1; for(var d=0;d<total;d++){ (function(n){ var b=document.createElement("button"); b.type="button"; b.className="sv__slider-dot"+(n===index?" is-active":""); b.setAttribute("aria-label","Go to services position "+(n+1)); b.addEventListener("click",function(){index=n;update();}); dotsWrap.appendChild(b); })(d); } };
    var update = function(){ index=Math.max(0,Math.min(index,maxIndex())); track.style.transform="translate3d("+(-index*step())+"px,0,0)"; prev.disabled=index===0; next.disabled=index===maxIndex(); Array.prototype.forEach.call(dotsWrap.children,function(dot,n){dot.classList.toggle("is-active",n===index);}); };
    prev.addEventListener("click",function(){index--;update();});
    next.addEventListener("click",function(){index++;update();});
    var resizeTimer; window.addEventListener("resize",function(){window.clearTimeout(resizeTimer);resizeTimer=window.setTimeout(function(){renderDots();update();},120);});
    renderDots(); update();
    var autoTimer = window.setInterval(function(){ if (document.hidden || slider.matches(":hover") || slider.contains(document.activeElement)) return; index = (index >= maxIndex()) ? 0 : index + 1; update(); }, 4500);
    slider.addEventListener("mouseenter",function(){ window.clearInterval(autoTimer); });
    slider.addEventListener("mouseleave",function(){ window.clearInterval(autoTimer); autoTimer=window.setInterval(function(){ if(document.hidden || slider.contains(document.activeElement)) return; index=(index>=maxIndex())?0:index+1; update(); },4500); });
    slider.addEventListener("focusin",function(){ window.clearInterval(autoTimer); });
    slider.addEventListener("focusout",function(){ if(!slider.contains(document.activeElement)){ window.clearInterval(autoTimer); autoTimer=window.setInterval(function(){ if(document.hidden || slider.matches(":hover")) return; index=(index>=maxIndex())?0:index+1; update(); },4500); } });
    }
  }

  /* slow drift on the background photo so the band feels alive */
  if (!reduce) {
    var bg = sec.querySelector('.sv__bg img');
    if (!bg) return;
    var ticking = false;
    window.addEventListener('scroll', function(){
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function(){
        ticking = false;
        var r = sec.getBoundingClientRect();
        if (r.bottom < -200 || r.top > window.innerHeight + 200) return;
        var p = (window.innerHeight - r.top) / (window.innerHeight + r.height);
        bg.style.transform = 'scale(1.08) translateY(' + ((p - .5) * -3.2).toFixed(2) + '%)';
      });
    }, {passive:true});
  }
})();
