<?php
/**
 * Section 2: introduction + stats bar.
 *
 * @package RealtorRaihan
 */

$stats = array(
	array( rr_h( 'stat1_n' ), rr_h( 'stat1_t' ), rr_h( 'stat1_s' ) ),
	array( rr_h( 'stat2_n' ), rr_h( 'stat2_t' ), rr_h( 'stat2_s' ) ),
	array( rr_h( 'stat3_n' ), rr_h( 'stat3_t' ), rr_h( 'stat3_s' ) ),
	array( rr_h( 'stat4_n' ), rr_h( 'stat4_t' ), rr_h( 'stat4_s' ) ),
);
$founder = rr_img( get_theme_mod( 'rr_founder_img', get_option( 'rr_home_intro_img', '' ) ), 'founder-raihan.webp' );
?>
<section class="s2" id="intro" aria-labelledby="s2-title">
  <span class="s2__edge" aria-hidden="true"></span>

  <div class="sec__wrap s2__inner home-mobile-spacing">

    <div class="s2__meta">
      <p class="tag"><?php echo esc_html( rr_h( 'intro_tag' ) ); ?></p>
    </div>

    <div class="s2__head">
      <div>
        <?php rr_head_lines( rr_h( 'intro_title' ), 's2-title', 'h2', 'd2' ); ?>
      </div>
      <div class="s2__aside rv">
        <p><?php echo wp_kses_post( rr_h( 'intro_aside' ) ); ?></p>
      </div>
    </div>

    <div class="s2__body">
      <div class="s2__copy">
        <p class="rv"><?php echo wp_kses_post( rr_h( 'intro_p1' ) ); ?></p>
        <p class="rv"><?php echo wp_kses_post( rr_h( 'intro_p2' ) ); ?></p>

        <blockquote class="s2__pull"><?php echo wp_kses_post( rr_h( 'intro_quote' ) ); ?></blockquote>

        <div class="s2__cta rv">
          <a class="pill pill--navy" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>"><?php echo esc_html( rr_h( 'intro_cta' ) ); ?>
            <?php echo rr_arrow(); // phpcs:ignore ?>
          </a>
        </div>
      </div>

      <figure class="s2__media">
        <div class="s2__shot">
          <div class="s2__tilt">
            <img src="<?php echo esc_url( $founder ); ?>" width="1440" height="1087"
                 alt="<?php echo esc_attr( get_post_meta( (int) get_theme_mod( 'rr_founder_img', 0 ), '_wp_attachment_image_alt', true ) ); ?>"
                 loading="lazy" decoding="async">
          </div>
          <span class="s2__sheen" aria-hidden="true"></span>
        </div>
        <div class="s2__badge">
          <strong><?php echo esc_html( rr_h( 'intro_badge_n' ) ); ?></strong>
          <span><?php echo esc_html( rr_h( 'intro_badge_t' ) ); ?></span>
        </div>
        <figcaption class="s2__cap">
          <b><?php echo esc_html( rr_h( 'intro_cap_b' ) ); ?></b>
          <span><?php echo esc_html( rr_h( 'intro_cap_s' ) ); ?></span>
        </figcaption>
      </figure>
    </div>

  </div>

  <div class="s2__stats">
    <div class="sec__wrap">
      <ul class="s2__statsGrid">
        <?php foreach ( $stats as $stat ) : ?>
          <li class="stat2">
            <span class="stat2__num"><?php echo esc_html( $stat[0] ); ?></span>
            <span class="stat2__label"><b><?php echo esc_html( $stat[1] ); ?></b><span><?php echo nl2br( esc_html( str_replace( '\n', "\n", $stat[2] ) ) ); ?></span></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

</section>
