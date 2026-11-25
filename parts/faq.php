<?php
/**
 * Section 10: FAQ accordion.
 *
 * @package RealtorRaihan
 */

$rows = rr_h_rows( 'faq' );
?>
<section class="fq" id="faq" aria-labelledby="fq-title">

  <div class="fq__bg" aria-hidden="true">
    <img src="<?php echo esc_url( get_theme_mod( 'rr_faq_bg', RR_URI . '/assets/img/gen-faq-balcony.webp' ) ); ?>" width="1800" height="1013" alt="" loading="lazy" decoding="async">
  </div>

  <div class="fq__wrap">

    <div class="fq__left">
      <p class="fq__eyebrow rv"><?php echo esc_html( rr_h( 'fq_eyebrow' ) ); ?></p>

      <?php rr_head_lines( rr_h( 'fq_title' ), 'fq-title' ); ?>

      <p class="fq__lede rv"><?php echo wp_kses_post( rr_h( 'fq_lede' ) ); ?></p>

      <a class="pill pill--gold fq__cta rv fq__cta--desktop" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>">
        <?php echo esc_html( rr_h( 'fq_cta' ) ); ?>
        <?php echo rr_arrow(); // phpcs:ignore ?>
      </a>
    </div>

    <div class="fq__list" id="fqList">
      <?php foreach ( $rows as $i => $row ) : ?>
        <article class="fqi">
          <span class="fqi__no" aria-hidden="true"><?php echo esc_html( rr_num( $i + 1 ) ); ?></span>
          <div class="fqi__main">
            <button class="fqi__btn" type="button" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
              <span class="fqi__q"><?php echo esc_html( $row['q'] ); ?></span>
              <span class="fqi__x" aria-hidden="true"></span>
            </button>
            <div class="fqi__panel"><div class="fqi__inner">
              <p class="fqi__a"><?php echo wp_kses_post( $row['a'] ); ?></p>
            </div></div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <a class="pill pill--gold fq__cta fq__cta--after-list" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>">
      <?php echo esc_html( rr_h( 'fq_cta' ) ); ?>
      <?php echo rr_arrow(); // phpcs:ignore ?>
    </a>

  </div>
</section>
