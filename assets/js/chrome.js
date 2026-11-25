/* shared chrome: fixed bar, mobile menu, footer reveal, back-to-top FAB.
   Lives on every page so the header and footer behave the same way everywhere. */
(function(){
  /* ---- fixed bar: transparent over a hero photo, navy glass once scrolled. ---- */
  var bar = document.querySelector('.hero__bar');
  if (bar) {
    var onScrollBar = function(){
      bar.classList.toggle('is-stuck', window.scrollY > 12);
    };
    window.addEventListener('scroll', onScrollBar, { passive:true });
    onScrollBar();
  }

  /* ---- mobile menu: the burger lives in the bar, the dialog is right after it ---- */
  var burger = document.querySelector('.burger');
  var mmenu  = document.getElementById('mmenu');
  var mx     = mmenu ? mmenu.querySelector('.mmenu__x') : null;
  if (burger && mmenu) {
    var openMenu = function(){
      mmenu.classList.add('is-open');
      burger.setAttribute('aria-expanded','true');
      document.body.style.overflow = 'hidden';
      if (mx) mx.focus();
    };
    var closeMenu = function(){
      mmenu.classList.remove('is-open');
      burger.setAttribute('aria-expanded','false');
      document.body.style.overflow = '';
    };
    burger.addEventListener('click', openMenu);
    if (mx) mx.addEventListener('click', closeMenu);
    mmenu.addEventListener('click', function(e){
      if (e.target === mmenu || e.target.tagName === 'A') closeMenu();
    });
    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape') closeMenu();
    });
  }

  /* ---- reveal on scroll for anything marked .rv outside the footer ---- */
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var revs = [].slice.call(document.querySelectorAll('.rv'));
  if (revs.length) {
    if (reduce || !('IntersectionObserver' in window)) {
      revs.forEach(function(el){ el.classList.add('is-in'); });
    } else {
      var io = new IntersectionObserver(function(entries){
        entries.forEach(function(entry){
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-in');
          io.unobserve(entry.target);
        });
      }, { threshold:.1, rootMargin:'0px 0px -5% 0px' });
      revs.forEach(function(el, i){
        el.style.transitionDelay = (i % 4) * 60 + 'ms';
        io.observe(el);
      });
      /* anything already on screen at load should not wait for a scroll */
      setTimeout(function(){
        revs.forEach(function(el){
          var r = el.getBoundingClientRect();
          if (r.top < window.innerHeight && r.bottom > 0) el.classList.add('is-in');
        });
      }, 400);
    }
  }

  /* ---- back to top: appears once the reader is deep enough to want it ---- */
  var fab = document.getElementById('ftFab');
  var toggleFab = function(){
    if (!fab) return;
    var visible = window.scrollY > window.innerHeight * 1.1;
    fab.classList.toggle('is-shown', visible);
    fab.setAttribute('aria-hidden', visible ? 'false' : 'true');
    fab.tabIndex = visible ? 0 : -1;
  };
  if (fab) {
    var ticking = false;
    window.addEventListener('scroll', function(){
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function(){ ticking = false; toggleFab(); });
    }, { passive:true });
    toggleFab();
  }

  /* ---- floating contact speed-dial (WhatsApp & Call) ---- */
  var speedDial = document.getElementById('rrSpeedDial');
  var speedDialBtn = document.getElementById('rrSpeedDialBtn');
  var speedDialActions = document.getElementById('rrSpeedDialActions');
  if (speedDial && speedDialBtn && speedDialActions) {
    var actionLinks = [].slice.call(speedDialActions.querySelectorAll('a'));
    var toggleSpeedDial = function(open){
      var isOpen = typeof open === 'boolean' ? open : !speedDial.classList.contains('is-open');
      speedDial.classList.toggle('is-open', isOpen);
      speedDialBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      speedDialActions.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
      actionLinks.forEach(function(a){ a.tabIndex = isOpen ? 0 : -1; });
    };

    speedDialBtn.addEventListener('click', function(e){
      e.stopPropagation();
      toggleSpeedDial();
    });

    // Close when clicking outside
    document.addEventListener('click', function(e){
      if (!speedDial.contains(e.target) && speedDial.classList.contains('is-open')) {
        toggleSpeedDial(false);
      }
    });

    // Close on Escape
    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape' && speedDial.classList.contains('is-open')) {
        toggleSpeedDial(false);
        speedDialBtn.focus();
      }
    });
  }
})();
