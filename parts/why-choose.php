<?php
/**
 * Section 9: why choose me (sticky photo stack + six points).
 *
 * @package RealtorRaihan
 */

$rows = rr_h_rows( 'why_choose' );
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

      <!-- left: fixed uploaded photograph -->
      <div class="wc__media rv" aria-hidden="true">
        <figure class="wc__shot is-on">
          <img src="<?php echo esc_url( RR_URI . '/assets/img/raihan-office.webp' ); ?>" alt="" width="960" height="1920" loading="lazy" decoding="async">
        </figure>
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
