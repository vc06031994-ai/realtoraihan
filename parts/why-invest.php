<?php
/** Short homepage introduction linking to the full 13-reason article. */
$investment_url = get_permalink( 126 );
?>
<section class="wi wi--teaser" id="why-invest" aria-labelledby="wi-title">
  <div class="wi__spot" aria-hidden="true"></div>
  <div class="wi__gridTex" aria-hidden="true"></div>
  <div class="wi__wrap">
    <div class="wi__meta"><p class="tag">Why Invest</p></div>
    <div class="wi__teaserInner">
      <div class="wi__teaserCopy">
        <h2 id="wi-title">13 Reasons to Invest in Dubai</h2>
        <p>Discover the key reasons why Dubai continues to attract property buyers and investors from around the world.</p>
      </div>
      <a class="pill pill--gold wi__teaserCta" href="<?php echo esc_url( $investment_url ); ?>">Explore All 13 Reasons <span aria-hidden="true">→</span></a>
    </div>
  </div>
</section>
