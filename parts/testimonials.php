<?php
/**
 * Section 8: testimonial carousel.
 *
 * @package RealtorRaihan
 */

$rows = function_exists( 'rr_get_dynamic_testimonials' ) ? rr_get_dynamic_testimonials() : rr_h_rows( 'testimonials' );
$star = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3 6.6 7 .9-5.1 4.8 1.3 7L12 17.9 5.8 21.3l1.3-7L2 9.5l7-.9z"/></svg>';
$n    = count( $rows );
?>
<section class="ts" id="testimonials" aria-labelledby="ts-title">
  <span class="ts__bloomA" aria-hidden="true"></span>
  <span class="ts__bloomB" aria-hidden="true"></span>

  <div class="ts__wrap">

    <div class="ts__head">
      <?php rr_head_lines( rr_h( 'ts_title' ), 'ts-title' ); ?>
      <p class="ts__lede rv"><?php echo wp_kses_post( rr_h( 'ts_lede' ) ); ?></p>
    </div>

    <div class="ts__stage rv">
      <button class="ts__arrow ts__arrow--prev" type="button" id="tsPrev" aria-label="<?php esc_attr_e( 'Previous testimonial', 'realtor-raihan' ); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button class="ts__arrow ts__arrow--next" type="button" id="tsNext" aria-label="<?php esc_attr_e( 'Next testimonial', 'realtor-raihan' ); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
      </button>

      <div class="ts__track" id="tsTrack" role="region" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Client testimonials', 'realtor-raihan' ); ?>">
        <?php
        foreach ( $rows as $i => $row ) :
            $rating = isset( $row['rating'] ) ? (int) $row['rating'] : 5;
            if ( $rating < 1 || $rating > 5 ) {
                $rating = 5;
            }
            ?>
          <div class="tcard" data-pos="<?php echo (int) $i; ?>" tabindex="0" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' of ' . $n ); ?>">
            <div class="tcard__top">
              <span class="tcard__stars" role="img" aria-label="<?php printf( esc_attr__( 'Rated %d out of 5', 'realtor-raihan' ), (int) $rating ); ?>"><?php echo str_repeat( $star, $rating ); // phpcs:ignore ?></span>
              <span class="tcard__no"><?php echo esc_html( rr_num( $i + 1 ) ); ?></span>
            </div>
            <blockquote class="tcard__quote"><?php echo esc_html( wp_strip_all_tags( $row['quote'] ) ); ?></blockquote>
            <button class="tcard__readmore" type="button" aria-expanded="false">Read more</button>
            <div class="tcard__foot">
              <?php if ( ! empty( $row['avatar'] ) ) : ?>
                <img class="tcard__av" src="<?php echo esc_url( $row['avatar'] ); ?>" alt="<?php echo esc_attr( $row['name'] ); ?>" width="38" height="38" loading="lazy" decoding="async" style="object-fit:cover;border-radius:50%">
              <?php else : ?>
                <span class="tcard__av" aria-hidden="true"><?php echo esc_html( mb_substr( $row['name'], 0, 1 ) ); ?></span>
              <?php endif; ?>
              <div>
                <div class="tcard__nm"><?php echo esc_html( $row['name'] ); ?></div>
                
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="ts__note rv"><?php echo esc_html( rr_h( 'ts_note' ) ); ?></p>

  </div>
</section>
