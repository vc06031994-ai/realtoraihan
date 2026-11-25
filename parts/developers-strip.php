<?php
/**
 * Two opposing developer-logo marquee lanes.
 *
 * @package RealtorRaihan
 */
$rr_developer_lanes = array(
	array(
		'class' => '',
		'label' => 'Developers, first group',
		'items' => array(
			array( 'name' => 'Ellington Properties', 'domain' => 'ellingtonproperties.ae' ),
			array( 'name' => 'Sobha', 'domain' => 'sobha.com' ),
			array( 'name' => 'Beyond', 'domain' => 'beyond.omniyat.com' ),
			array( 'name' => 'Object 1', 'domain' => 'object1.com' ),
			array( 'name' => 'MAF', 'domain' => 'maf.com' ),
			array( 'name' => 'Alef', 'domain' => 'alefgroup.ae' ),
			array( 'name' => 'Reportage', 'domain' => 'reportageuae.com' ),
			array( 'name' => 'Binghatti', 'domain' => 'binghatti.com' ),
			array( 'name' => 'Nshama', 'domain' => 'nshama.ae' ),
			array( 'name' => 'Dubai South', 'domain' => 'dubaisouth.ae' ),
			array( 'name' => 'BNW', 'domain' => 'bnw.ae' ),
			array( 'name' => 'Al Hamra', 'domain' => 'alhamra.ae' ),
			array( 'name' => 'Arada', 'domain' => 'arada.com' ),
			array( 'name' => 'Tiger', 'domain' => 'tigergroup.ae' ),
		),
	),
	array(
		'class' => 'dev-marquee__track--reverse',
		'label' => 'Developers, second group',
		'items' => array(
			array( 'name' => 'Nakheel', 'domain' => 'nakheel.com' ),
			array( 'name' => 'Emaar', 'domain' => 'emaar.com' ),
			array( 'name' => 'Modon', 'domain' => 'modon.com' ),
			array( 'name' => 'Aldar', 'domain' => 'aldar.com' ),
			array( 'name' => 'DAMAC', 'domain' => 'damacproperties.com' ),
			array( 'name' => 'Danube', 'domain' => 'danubeproperties.com' ),
			array( 'name' => 'Azizi', 'domain' => 'azizidevelopments.com' ),
			array( 'name' => 'Imtiaz', 'domain' => 'imtiazdevelopments.com' ),
			array( 'name' => 'Samana', 'domain' => 'samanadevelopers.com' ),
			array( 'name' => 'Omniyat', 'domain' => 'omniyat.com' ),
			array( 'name' => 'Meraas', 'domain' => 'meraas.com' ),
			array( 'name' => 'Dubai Properties', 'domain' => 'dp.ae' ),
			array( 'name' => 'Expo City Developer', 'domain' => 'expocitydubai.com' ),
		),
	),
);
?>
<section class="dev-marquee" aria-label="Developers I work with">
  <div class="dev-marquee__head">
    <p class="tag">TRUSTED DEVELOPER NETWORK</p>
    <h2>Developers I Work With</h2>
  </div>
  <div class="dev-marquee__rows">
    <?php foreach ( $rr_developer_lanes as $rr_lane ) : ?>
      <div class="dev-marquee__viewport" aria-label="<?php echo esc_attr( $rr_lane['label'] ); ?>">
        <div class="dev-marquee__track <?php echo esc_attr( $rr_lane['class'] ); ?>">
          <?php for ( $rr_copy = 0; $rr_copy < 2; $rr_copy++ ) : ?>
            <?php foreach ( $rr_lane['items'] as $rr_dev ) : ?>
              <div class="dev-marquee__item" <?php echo $rr_copy ? 'aria-hidden="true"' : ''; ?>>
                <img src="<?php echo esc_url( 'https://www.google.com/s2/favicons?domain=' . rawurlencode( $rr_dev['domain'] ) . '&sz=128' ); ?>" alt="" loading="lazy" decoding="async">
                <span><?php echo esc_html( $rr_dev['name'] ); ?></span>
              </div>
            <?php endforeach; ?>
          <?php endfor; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
