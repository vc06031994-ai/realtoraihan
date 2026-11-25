<?php
/**
 * Section 1: hero.
 *
 * @package RealtorRaihan
 */

$slides = array(
	'rr_hero_img_1' => 'hero-1-downtown.webp',
	'rr_hero_img_2' => 'hero-2-marina.webp',
	'rr_hero_img_3' => 'hero-3-villa.webp',
	'rr_hero_img_4' => 'hero-4-sunset.webp',
);
$slide_urls = array();
foreach ( $slides as $mod => $fallback ) {
	$slide_urls[] = rr_img( get_theme_mod( $mod, '' ), $fallback, 'full' );
}
?>
<div id="top" aria-hidden="true"></div>
<section class="hero" id="hero" aria-labelledby="hero-title">
  <div class="hero__bg" aria-hidden="true">
    <?php foreach ( $slide_urls as $i => $url ) : ?>
      <figure class="hero__slide<?php echo 0 === $i ? ' is-on' : ''; ?>">
        <img src="<?php echo esc_url( $url ); ?>" width="2000" height="1125" alt=""
          <?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?> decoding="async">
      </figure>
    <?php endforeach; ?>
  </div>
  <div class="hero__scrim" aria-hidden="true"></div>
  <div class="hero__grain" aria-hidden="true"></div>

  <div class="hero__main">
    <div class="hero__inner">
      <p class="hero__tag rv"><?php echo esc_html( rr_h( 'hero_tag' ) ); ?></p>

      <h1 id="hero-title" class="rv-head">
        <span class="ln"><span><?php echo esc_html( rr_h( 'hero_title_l1' ) ); ?></span></span>
        <span class="ln"><span><?php echo esc_html( rr_h( 'hero_title_l2' ) ); ?></span></span>
        <span class="ln"><span><em><?php echo esc_html( rr_h( 'hero_title_l3' ) ); ?></em></span></span>
      </h1>

      <p class="hero__say rv"><?php echo wp_kses_post( rr_h( 'hero_say' ) ); ?></p>

      <p class="hero__lede rv"><?php echo wp_kses_post( rr_h( 'hero_lede' ) ); ?></p>

      <div class="hero__cta rv">
        <a class="pill pill--cream" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>"><?php echo esc_html( rr_h( 'hero_cta1' ) ); ?></a>
        <a class="pill pill--gold-line" href="<?php echo esc_url( rr_link( 'about' ) ); ?>"><?php echo esc_html( rr_h( 'hero_cta2' ) ); ?></a>
      </div>
    </div>
  </div>
</section>
