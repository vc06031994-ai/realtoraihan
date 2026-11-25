/* about page: staggered reveal on the page sections (the header reveal is handled
   by the shared chrome script, which runs on every page) */
(function(){
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var root = document.querySelector('.ab-head, .ab-us');
  if (!root) return;
  var items = [].slice.call(document.querySelectorAll('.ab-head .rv, .ab-us .rv, .ab-why .rv, .ab-close .rv'));
  function show(){
    items.forEach(function(el, i){
      el.style.transitionDelay = (80 + i * 70) + 'ms';
      el.classList.add('is-in');
    });
  }
  if (reduce) { show(); return; }
  window.addEventListener('load', function(){ setTimeout(show, 120); });
  setTimeout(show, 900);
})();
