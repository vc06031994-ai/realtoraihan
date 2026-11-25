<?php
/**
 * Section 9: why choose me (sticky photo stack + six points).
 *
 * @package RealtorRaihan
 */

$rows  = rr_h_rows( 'why_choose' );
$shots = array(
	array( 'gen-wcm-villa.webp', 900, 1200 ),
	array( 'skyline-dusk-wide.webp', 1200, 750 ),
	array( 'penthouse-living-sunset.webp', 900, 600 ),
	array( 'marina-daylight.webp', 900, 600 ),
	array( 'penthouse-terrace-dusk.webp', 900, 600 ),
	array( 'gen-marina-night.webp', 900, 600 ),
);
?>
<section class="wc" id="why-choose" aria-labelledby="wc-title">
  <div class="wc__wrap">

    <div class="wc__meta">
      <span class="wc__metaDot" aria-hidden="true"></span>
      <p class="wc__metaTx"><?php echo esc_html( rr_h( 'wc_meta' ) ); ?></p>
    </div>

    <div class="wc__head">
      <?php rr_head_lines( rr_h( 'wc_title' ), 'wc-title' ); ?>
      <a class="pill pill--gold wc__cta rv" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>">
        <?php echo esc_html( rr_h( 'wc_cta' ) ); ?>
        <?php echo rr_arrow(); // phpcs:ignore ?>
      </a>
    </div>

    <div class="wc__grid" id="wcGrid">

      <!-- left: sticky photograph stack -->
      <div class="wc__media rv" aria-hidden="true">
        <?php foreach ( $shots as $i => $shot ) : ?>
          <?php
          // The requested photo is the permanent visible image in this section.
          $image_url = 0 === $i
            ? 'http://localhost/realtorraihan/wp-content/uploads/2026/11/Confident-Executive-at-Sunset-1-2-Photoroom.webp'
            : get_theme_mod( 'rr_wc_shot_' . ( $i + 1 ), RR_URI . '/assets/img/' . $shot[0] );
          ?>
          <figure class="wc__shot<?php echo 0 === $i ? ' is-on' : ''; ?>" data-shot="<?php echo (int) $i; ?>">
            <img src="<?php echo esc_url( $image_url ); ?>" alt="" width="<?php echo (int) $shot[1]; ?>" height="<?php echo (int) $shot[2]; ?>" loading="lazy" decoding="async">
          </figure>
        <?php endforeach; ?>

        <span class="wc__rail"><span class="wc__railFill" id="wcRail"></span></span>

        <div class="wc__cap">
          <div class="wc__capTx">
            <span class="wc__capNum" id="wcNum">01</span>
            <p class="wc__capLbl" id="wcLbl"><?php echo esc_html( isset( $rows[0]['title'] ) ? $rows[0]['title'] : '' ); ?></p>
          </div>
        </div>
      </div>

      <!-- right: the points -->
      <div class="wc__list" id="wcList">
        <?php foreach ( $rows as $i => $row ) : ?>
          <div class="wcr<?php echo 0 === $i ? ' is-active' : ''; ?>" role="button" tabindex="0" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>" data-i="<?php echo (int) $i; ?>" data-lbl="<?php echo esc_attr( $row['title'] ); ?>">
            <div class="wcr__main">
              <h3><?php echo esc_html( $row['title'] ); ?></h3>
              <p style="font-size:16px!important;line-height:1.65!important"><?php echo wp_kses_post( $row['text'] ); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
