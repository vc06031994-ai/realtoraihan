<?php
/**
 * Section 4: services bento grid. The first row can be a full photo card.
 *
 * @package RealtorRaihan
 */

$rows = rr_h_rows( 'services' );

/**
 * Line icons keyed by the value typed in the admin screen.
 */
$icons = array(
	'sell'       => '<path d="M3 21h18"/><path d="M6 21V8l6-4 6 4v13"/><path d="M10 21v-5h4v5"/><path d="M9 11h.01M15 11h.01"/>',
	'buy'        => '<path d="M3 10.5 12 4l9 6.5"/><path d="M5 10v10h14V10"/><path d="M9.5 20v-6h5v6"/>',
	'rent'       => '<circle cx="8" cy="8" r="3.2"/><path d="M2.5 20a5.5 5.5 0 0 1 11 0"/><path d="M15 5.2a3.2 3.2 0 0 1 0 5.6"/><path d="M17.5 20a5.5 5.5 0 0 0-2.6-4.6"/>',
	'commercial' => '<path d="M3 21h18"/><path d="M5 21V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v16"/><path d="M15 21V11h4v10"/><path d="M8 7h.01M11 7h.01M8 11h.01M11 11h.01M8 15h.01M11 15h.01"/>',
	'mortgage'   => '<path d="M12 2v20"/><path d="M17 6.5H9.8a3.3 3.3 0 0 0 0 6.6h4.4a3.3 3.3 0 0 1 0 6.6H6.5"/>',
	'visa'       => '<path d="M12 3.5 14.6 9l6 .8-4.4 4.2 1.1 6-5.3-2.9L6.7 20l1.1-6L3.4 9.8l6-.8z"/>',
	'business'   => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/><path d="M3 12h18"/>',
	'bank'       => '<path d="M3 10 12 4l9 6"/><path d="M5 10v9M19 10v9"/><path d="M9 10v9M15 10v9"/><path d="M3 21h18"/>',
);
?>


<section class="sv" id="services" aria-labelledby="sv-title">

  <div class="sv__wrap">

    <div class="sv__meta">
      <p class="tag"><?php echo esc_html( rr_h( 'sv_tag' ) ); ?></p>
    </div>

    <div class="sv__head">
      <?php rr_head_lines( rr_h( 'sv_title' ), 'sv-title' ); ?>
      <div class="sv__aside rv">
        <p><?php echo wp_kses_post( rr_h( 'sv_aside' ) ); ?></p>
      </div>
    </div>

    <div class="sv__bento sv__slider" data-services-slider>
      <div class="sv__slider-viewport">
        <div class="sv__slider-track">
      <?php
      $total_rows = count( $rows );
      foreach ( $rows as $i => $row ) :
          $featured = false;
          $is_wide  = false;
          $url      = ! empty( $row['url'] ) ? $row['url'] : '';
          $icon_key = isset( $icons[ $row['icon'] ] ) ? $row['icon'] : 'sell';
          $classes  = 'bento';
          if ( $featured ) {
              $classes .= ' bento--feat';
          } elseif ( $is_wide ) {
              $classes .= ' bento--wide';
          }
          ?>
          <div class="<?php echo esc_attr( $classes ); ?>">

            <?php if ( $featured ) : ?>
              <div class="bento__art bento__art--photo" aria-hidden="true">
                <img src="<?php echo esc_url( rr_img( isset( $row['photo'] ) ? $row['photo'] : '', 'gen-villa-evening.webp' ) ); ?>" alt="" loading="lazy" decoding="async">
                <span class="bento__artVeil"></span>
              </div>
            <?php endif; ?>
            <div class="bento__body">
              <span class="bento__ico" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $icons[ $icon_key ]; // phpcs:ignore ?></svg></span>
              <h3><?php echo esc_html( $row['title'] ); ?></h3>
              <p><?php echo wp_kses_post( $row['text'] ); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
      <div class="sv__slider-controls" aria-label="Services slider controls">
        <button class="sv__slider-btn sv__slider-prev" type="button" aria-label="Previous services"><span aria-hidden="true">←</span></button>
        <div class="sv__slider-dots" aria-label="Choose services slide"></div>
        <button class="sv__slider-btn sv__slider-next" type="button" aria-label="Next services"><span aria-hidden="true">→</span></button>
      </div>
    </div>
  </div>
</section>
