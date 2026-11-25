<?php
/**
 * Shared footer, identical on every page.
 *
 * @package RealtorRaihan
 */

$keywords = rr_lines( rr_mod( 'rr_footer_keywords', '' ) );
if ( ! $keywords ) {
	$keywords = rr_default_keywords();
}
$disc = rr_mod( 'rr_footer_disc', '' );
if ( ! $disc ) {
	$disc = 'Information on this website is general guidance, not financial, tax, or legal advice. Property prices, payment plans, rental yields, and visa requirements change and must be verified independently before you commit.';
}
$copyright = get_theme_mod( 'rr_footer_copyright', '' );
?>
<footer class="ft" id="footer" aria-labelledby="ft-title">

  <div class="ft__bg" aria-hidden="true">
    <picture>
      <source media="(max-width:640px)" srcset="<?php echo esc_url( get_theme_mod( 'rr_ft_bg_sm', RR_URI . '/assets/img/ft-bg-sm.webp' ) ); ?>">
      <source media="(max-width:1100px)" srcset="<?php echo esc_url( get_theme_mod( 'rr_ft_bg_md', RR_URI . '/assets/img/ft-bg-md.webp' ) ); ?>">
      <img src="<?php echo esc_url( get_theme_mod( 'rr_ft_bg', RR_URI . '/assets/img/ft-bg.webp' ) ); ?>" width="2000" height="869" alt="" loading="lazy" decoding="async">
    </picture>
  </div>

  <div class="ft__wrap">

    <div class="ft__panel">

      <!-- brand column -->
      <div class="rv">
        <a class="ft__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( rr_site_name() ); ?>">
          <img class="ft__brandLogo" src="<?php echo esc_url( rr_logo_lockup() ); ?>" width="225" height="48" alt="<?php echo esc_attr( rr_site_name() ); ?>" loading="lazy" decoding="async" id="ft-title">
        </a>

        <p class="ft__follow"><?php esc_html_e( 'Follow Me:', 'realtor-raihan' ); ?></p>
        <div class="ft__socials">
          <?php
          if ( function_exists( 'rr_render_social_icons' ) ) {
              rr_render_social_icons();
          }
          ?>
        </div>

        <a class="ft__google-review" href="https://maps.app.goo.gl/caBcLA7vskEZXWCq7" target="_blank" rel="noopener noreferrer" aria-label="Read Google reviews">
          <span class="ft__google-reviewTop"><span class="ft__google-mark">G</span><span>Google Reviews</span></span>
          <span class="ft__google-reviewBottom">Read client reviews on Google <span aria-hidden="true">↗</span></span>
        </a>

      </div>

      <!-- link columns -->
      <div class="ft__cols">
        <?php
        $columns = array(
          'Quick Links' => array(
            array( 'Home', home_url( '/' ) ),
            array( 'About Me', rr_link( 'about' ) ),
            array( 'Blog', rr_blog_url() ),
            array( 'Properties', rr_anchor( 'properties' ) ),
            array( 'Contact', rr_anchor( 'contact' ) ),
          ),
          'Services'    => array(
            array( 'Buy Property', rr_anchor( 'services' ) ),
            array( 'Sell Property', rr_anchor( 'services' ) ),
            array( 'Rent Property', rr_anchor( 'services' ) ),
            array( 'Mortgage Guidance', rr_anchor( 'services' ) ),
            array( 'Golden Visa Guidance', rr_anchor( 'services' ) ),
          ),
          'Explore'     => array(
            array( 'Why Invest in Dubai', get_permalink( 126 ) ),
            array( 'Investment Snapshot', rr_anchor( 'snapshot' ) ),
            array( 'Client Feedback', rr_anchor( 'testimonials' ) ),
            array( 'FAQs', rr_anchor( 'faq' ) ),
          ),
        );

        foreach ( $columns as $title => $links ) :
            ?>
            <div class="rv">
              <p class="ft__h"><?php echo esc_html( $title ); ?></p>
              <ul class="ft__list">
                <?php foreach ( $links as $link ) : ?>
                  <li><a href="<?php echo esc_url( $link[1] ); ?>"><?php echo esc_html( $link[0] ); ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
            <?php
        endforeach;
        ?>

        <div class="rv">
          <p class="ft__h"><?php esc_html_e( 'Get in Touch', 'realtor-raihan' ); ?></p>
          <ul class="ft__list" style="gap:clamp(10px,1.2vw,14px)">
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'Phone', 'realtor-raihan' ); ?></span>
              <a href="<?php echo esc_attr( rr_phone_href() ); ?>"><?php echo esc_html( rr_phone() ); ?></a>
            </li>
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'Email', 'realtor-raihan' ); ?></span>
              <a href="mailto:<?php echo esc_attr( rr_email() ); ?>"><?php echo esc_html( rr_email() ); ?></a>
            </li>
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'WhatsApp', 'realtor-raihan' ); ?></span>
              <a href="<?php echo esc_url( rr_whatsapp() ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Chat on WhatsApp', 'realtor-raihan' ); ?></a>
            </li>
            <li class="ft__row">
              <span class="ft__rowK"><?php esc_html_e( 'Based in', 'realtor-raihan' ); ?></span>
              <p><?php echo esc_html( rr_area() ); ?></p>
            </li>
          </ul>
        </div>

      </div>
    </div>

    <div class="ft__foot">
      <p class="ft__disc rv"><?php echo wp_kses_post( $disc ); ?></p>

      <div class="ft__keys rv">
        <p class="ft__keysTitle"><?php echo esc_html( rr_mod( 'rr_keywords_title', 'Service locations' ) ); ?></p>
        <p class="ft__keysTx"><?php echo esc_html( implode( ' | ', $keywords ) ); ?></p>
      </div>

      <div class="ft__language-switcher" style="position:fixed!important;left:20px!important;right:auto!important;top:auto!important;bottom:20px!important;margin:0!important;padding:0!important;width:max-content!important;max-width:calc(100vw - 40px)!important;z-index:999999!important;display:block!important;transform:none!important;">
  <?php echo do_shortcode( '[gtranslate]' ); ?>
</div>

<div class="ft__legal-row">
        <p class="ft__copy">
          <?php printf( esc_html__( 'Copyright © %s Realtor Raihan. All rights reserved.', 'realtor-raihan' ), esc_html( gmdate( 'Y' ) ) ); ?>
        </p>
        <p class="ft__credit"><?php esc_html_e( 'Designed and Developed by', 'realtor-raihan' ); ?> <a href="https://chameleogfxstudio.com/" target="_blank" rel="noopener noreferrer">Chameleo GFX Studio</a></p>
      </div>
    </div>

  </div>
<script>
(function(){
  function pinGTranslate(){
    var el=document.querySelector('.ft__language-switcher');
    if(!el) return;
    if(el.parentNode!==document.body){document.body.appendChild(el);}
    el.style.setProperty('position','fixed','important');
    el.style.setProperty('left','20px','important');
    el.style.setProperty('right','auto','important');
    el.style.setProperty('top','auto','important');
    el.style.setProperty('bottom','20px','important');
    el.style.setProperty('z-index','999999','important');
    el.style.setProperty('margin','0','important');
    el.style.setProperty('transform','none','important');
    el.style.setProperty('display','block','important');
  }
  if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',pinGTranslate);}else{pinGTranslate();}
  window.addEventListener('load',pinGTranslate);
})();
</script>
<style>
@media(max-width:767px){.ft__language-switcher{left:10px!important;bottom:10px!important}}
</style>
</footer>

<a class="ft__fab" id="ftFab" href="#top" aria-label="<?php esc_attr_e( 'Back to top', 'realtor-raihan' ); ?>">
  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</a>

<!-- Floating Contact Speed Dial (WhatsApp & Phone) -->
<div class="rr-speed-dial" id="rrSpeedDial" role="region" aria-label="<?php esc_attr_e( 'Quick contact options', 'realtor-raihan' ); ?>">
  <!-- Actions List -->
  <div class="rr-speed-dial__actions" id="rrSpeedDialActions" aria-hidden="true">
    <!-- Call / Phone Option -->
    <a class="rr-speed-dial__action rr-speed-dial__action--phone" href="<?php echo esc_attr( rr_phone_href() ); ?>" aria-label="<?php esc_attr_e( 'Call Raihan Shaikh', 'realtor-raihan' ); ?>" tabindex="-1">
      <span class="rr-speed-dial__label"><?php esc_html_e( 'Phone', 'realtor-raihan' ); ?></span>
      <span class="rr-speed-dial__icon" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
          <path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/>
        </svg>
      </span>
    </a>

    <!-- WhatsApp Option -->
    <a class="rr-speed-dial__action rr-speed-dial__action--wa" href="<?php echo esc_url( rr_whatsapp() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'realtor-raihan' ); ?>" tabindex="-1">
      <span class="rr-speed-dial__label"><?php esc_html_e( 'WhatsApp', 'realtor-raihan' ); ?></span>
      <span class="rr-speed-dial__icon" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm0 18.15c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 012.41 5.83c.02 4.54-3.68 8.23-8.22 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.17-.25.25-.42.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.06 0 1.21.89 2.39 1.01 2.56.12.17 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.53.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.15-1.18-.07-.1-.23-.17-.48-.29z"/>
        </svg>
      </span>
    </a>
  </div>

  <!-- Main Trigger Button -->
  <button class="rr-speed-dial__btn" id="rrSpeedDialBtn" type="button" aria-expanded="false" aria-controls="rrSpeedDialActions" aria-label="<?php esc_attr_e( 'Contact Raihan Shaikh on WhatsApp or Phone', 'realtor-raihan' ); ?>">
    <!-- Chat Icon (Default) -->
    <span class="rr-speed-dial__msg-ico" aria-hidden="true">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
      </svg>
    </span>
    <!-- Close Icon (When open) -->
    <span class="rr-speed-dial__close-ico" aria-hidden="true">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </span>
  </button>
</div>


