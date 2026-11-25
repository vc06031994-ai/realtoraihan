/* blog listing: topic filter over the WordPress categories, and the newsletter
   note. The newsletter form itself posts to WordPress, so nothing here blocks it. */
(function(){
  var chips = [].slice.call(document.querySelectorAll('.bl-chip'));
  var cards = [].slice.call(document.querySelectorAll('.bl-card'));

  if (!chips.length || !cards.length) return;

  chips.forEach(function(chip){
    chip.addEventListener('click', function(){
      chips.forEach(function(c){ c.classList.remove('is-on'); });
      chip.classList.add('is-on');
      var cat = chip.dataset.cat;
      cards.forEach(function(card){
        var cardCats = (card.dataset.cat || '').trim().split(/\s+/);
        var show = cat === 'all' || cardCats.indexOf(cat) !== -1;
        card.style.display = show ? '' : 'none';
      });
    });
  });
})();
