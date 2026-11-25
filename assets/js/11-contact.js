/* Contact section reveal behaviour. Contact Form 7 handles validation and submission. */
(function(){
  var sec = document.getElementById('contact');
  if (!sec) return;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var lines = [].slice.call(sec.querySelectorAll('.ln'));
  var revs = [].slice.call(sec.querySelectorAll('.rv'));
  if (reduce || !('IntersectionObserver' in window)) {
    lines.forEach(function(el){ el.classList.add('is-in'); });
    revs.forEach(function(el){ el.classList.add('is-in'); });
    return;
  }
  new IntersectionObserver(function(entries, observer){
    entries.forEach(function(entry){
      if (!entry.isIntersecting) return;
      lines.forEach(function(el, index){
        window.setTimeout(function(){ el.classList.add('is-in'); }, 70 + index * 100);
      });
      observer.disconnect();
    });
  }, {threshold:.12}).observe(sec);
  var revealObserver = new IntersectionObserver(function(entries){
    entries.forEach(function(entry){
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-in');
      revealObserver.unobserve(entry.target);
    });
  }, {threshold:.15});
  revs.forEach(function(el){ revealObserver.observe(el); });
})();