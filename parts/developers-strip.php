<?php
$rr_developers = array(
 array('name'=>'Ellington Properties','domain'=>'ellingtonproperties.ae'),
 array('name'=>'Sobha','domain'=>'sobha.com'),
 array('name'=>'Beyond','domain'=>'beyond.omniyat.com'),
 array('name'=>'Object 1','domain'=>'object1.com'),
 array('name'=>'MAF','domain'=>'maf.com'),
 array('name'=>'Alef','domain'=>'alefgroup.ae'),
 array('name'=>'Reportage','domain'=>'reportageuae.com'),
 array('name'=>'Binghatti','domain'=>'binghatti.com'),
 array('name'=>'Nshama','domain'=>'nshama.ae'),
 array('name'=>'Dubai South','domain'=>'dubaisouth.ae'),
 array('name'=>'BNW','domain'=>'bnw.ae'),
 array('name'=>'Al Hamra','domain'=>'alhamra.ae'),
 array('name'=>'Arada','domain'=>'arada.com'),
 array('name'=>'Tiger','domain'=>'tigergroup.ae')
);
?>
<section class="dev-marquee" aria-label="Developers I work with">
 <div class="dev-marquee__head"><p class="tag">TRUSTED DEVELOPER NETWORK</p><h2>Developers I Work With</h2></div>
 <div class="dev-marquee__viewport"><div class="dev-marquee__track">
 <?php for($rr_copy=0;$rr_copy<2;$rr_copy++): foreach($rr_developers as $rr_dev): ?>
 <div class="dev-marquee__item" <?php echo $rr_copy ? 'aria-hidden="true"' : ''; ?>>
 <img src="<?php echo esc_url( ! empty( $rr_dev['logo'] ) ? $rr_dev['logo'] : 'https://www.google.com/s2/favicons?domain=' . rawurlencode( $rr_dev['domain'] ) . '&sz=128' ); ?>" alt="" loading="lazy" decoding="async">
 <span><?php echo esc_html($rr_dev['name']); ?></span></div>
 <?php endforeach; endfor; ?>
 </div></div>
</section>