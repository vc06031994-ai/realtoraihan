<?php
/**
 * Section 4: services bento grid. The first row can be a full photo card.
 *
 * @package RealtorRaihan
 */

$rows = array_values(
	array_filter(
		rr_h_rows( 'services' ),
	static function ( $row ) {
		$row = (array) $row;
		return '' !== trim( (string) ( $row['title'] ?? '' ) )
			&& '' !== trim( (string) ( $row['text'] ?? '' ) );
	}
	)
);

$service_images = array(
	'sell'       => 'gen-villa-evening.webp',
	'buy'        => 'penthouse-living-sunset.webp',
	'rent'       => 'marina-daylight.webp',
	'commercial' => 'gen-office-dusk.webp',
	'mortgage'   => 'penthouse-terrace-dusk.webp',
	'visa'       => 'skyline-sunset-wide.webp',
	'business'   => 'downtown-walk.webp',
	'bank'       => 'gen-faq-balcony.webp',
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
      foreach ( $rows as $row ) :
          $service_key = sanitize_key( $row['icon'] ?? '' );
          if ( ! isset( $service_images[ $service_key ] ) ) {
              $service_key = 'sell';
          }
          $classes = 'bento';
          ?>
          <div class="<?php echo esc_attr( $classes ); ?>">
            <div class="bento__body">
              <div class="bento__image-box">
                <img src="<?php echo esc_url( rr_img( ! empty( $row['photo'] ) ? $row['photo'] : '', $service_images[ $service_key ] ) ); ?>" alt="" loading="lazy" decoding="async">
              </div>
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
