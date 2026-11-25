/* 01-hero */
(function(){
  var hero = document.getElementById('hero');
  if (!hero) return;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var items = [].slice.call(hero.querySelectorAll('.rv, .rv-head'));

  function show(){
    hero.classList.add('is-loaded');
    items.forEach(function(el, i){
      el.style.transitionDelay = (120 + i * 95) + 'ms';
      el.classList.add('is-in');
    });
  }
  if (reduce) {
    hero.classList.add('is-loaded');
    items.forEach(function(el){ el.classList.add('is-in'); });
  } else if (document.readyState === 'complete') {
    requestAnimationFrame(show);
  } else {
    window.addEventListener('load', function(){ requestAnimationFrame(show); });
  }

  /* ---------------- background slideshow ---------------- */
  /* four photos cross-fade on a 6.5s beat; the active tick fills with gold
     while the slide is on screen, so the timing is legible, not guessed. */
  var slides = [].slice.call(hero.querySelectorAll('.hero__slide'));
  var DUR = 6500, currentSlide = 0, slideTimer = null, pageVisible = !document.hidden;

  function showSlide(index){
    if (!slides.length) return;
    currentSlide = (index + slides.length) % slides.length;
    slides.forEach(function(slide, i){
      var active = i === currentSlide;
      slide.classList.toggle('is-on', active);
      if (active) {
        var image = slide.querySelector('img');
        if (image) {
          image.style.animation = 'none';
          void image.offsetWidth;
          image.style.animation = '';
        }
      }
    });
    scheduleSlide();
  }

  function scheduleSlide(){
    window.clearTimeout(slideTimer);
    if (reduce || !pageVisible || slides.length < 2) return;
    slideTimer = window.setTimeout(function(){ showSlide(currentSlide + 1); }, DUR);
  }

  if (reduce) {
    slides.forEach(function(slide, i){ slide.classList.toggle('is-on', i === 0); });
  } else {
    document.addEventListener('visibilitychange', function(){
      pageVisible = !document.hidden;
      if (pageVisible) scheduleSlide();
      else window.clearTimeout(slideTimer);
    });
    scheduleSlide();
  }

  /* Header, navigation and mobile-menu behaviour are owned by chrome.js.
     Keeping one shared controller prevents duplicate listeners on the homepage. */
})();
