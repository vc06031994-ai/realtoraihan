<?php
/**
 * Shared site header: fixed bar + mobile menu.
 *
 * @package RealtorRaihan
 */
?>
<header class="hero__bar rr-bar">
  <div class="hero__barInner">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( rr_site_name() . ' home' ); ?>">
      <img class="brand__logo" src="<?php echo esc_url( rr_logo_lockup() ); ?>" width="225" height="48" alt="<?php echo esc_attr( rr_site_name() ); ?>">
    </a>

    <nav class="nav" aria-label="<?php esc_attr_e( 'Primary', 'realtor-raihan' ); ?>">
      <?php rr_primary_menu(); ?>
    </nav>

    <div class="hero__actions">
      <a class="hero__call" href="<?php echo esc_attr( rr_phone_href() ); ?>" aria-label="<?php echo esc_attr( ( rr_mod( 'rr_call_label', 'Talk to me' ) ) . ': ' . rr_phone() ); ?>">
        <i aria-hidden="true"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg></i>
        <span class="hero__callTx">
          <small><?php echo esc_html( rr_mod( 'rr_call_label', 'Talk to me' ) ); ?></small>
          <span><?php echo esc_html( rr_phone() ); ?></span>
        </span>
      </a>

      <?php $cta = rr_mod( 'rr_cta_url', '' ); ?>
      <a class="pill pill--gold" href="<?php echo esc_url( $cta ? $cta : rr_anchor( 'contact' ) ); ?>">
        <?php echo esc_html( rr_mod( 'rr_cta_label', 'Book A Free Consultation' ) ); ?>
        <?php echo rr_arrow(); // phpcs:ignore ?>
      </a>

      <button class="burger" type="button" aria-label="<?php esc_attr_e( 'Open menu', 'realtor-raihan' ); ?>" aria-expanded="false" aria-controls="mmenu">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
      </button>
    </div>
  </div>
</header>

<div class="mmenu" id="mmenu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menu', 'realtor-raihan' ); ?>">
  <button class="mmenu__x" type="button" aria-label="<?php esc_attr_e( 'Close menu', 'realtor-raihan' ); ?>">
    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
  </button>
  <?php
  // The mobile menu mirrors the header menu with staggered entrance timing.
  if ( has_nav_menu( 'primary' ) ) {
      rr_primary_menu( 0 );
  } else {
      printf( '<a href="%s" style="--i:0"%s>Home</a>', esc_url( home_url( '/' ) ), is_front_page() ? ' aria-current="page"' : '' ); // phpcs:ignore
      printf( '<a href="%s" style="--i:1"%s>About</a>', esc_url( rr_link( 'about' ) ), is_page_template( 'page-templates/about.php' ) ? ' aria-current="page"' : '' ); // phpcs:ignore
      printf( '<a href="%s" style="--i:2"%s>Blog</a>', esc_url( rr_blog_url() ), ( is_home() || is_singular( 'post' ) ) ? ' aria-current="page"' : '' ); // phpcs:ignore
      printf( '<a href="%s" style="--i:3"%s>Contact</a>', esc_url( rr_contact_url() ), is_page_template( 'page-templates/contact.php' ) ? ' aria-current="page"' : '' ); // phpcs:ignore
  }
  ?>
  <div class="mmenu__ctaWrap">
    <a class="pill pill--gold" href="<?php echo esc_url( $cta ? $cta : rr_anchor( 'contact' ) ); ?>">
      <?php echo esc_html( rr_mod( 'rr_cta_label', 'Book a Free Consultation' ) ); ?>
      <?php echo rr_arrow(); // phpcs:ignore ?>
    </a>
  </div>
  <div class="mmenu__foot">
    <span><?php echo esc_html( rr_area() ); ?></span>
    <a href="<?php echo esc_attr( rr_phone_href() ); ?>"><?php echo esc_html( rr_phone() ); ?></a>
    <a href="mailto:<?php echo esc_attr( rr_email() ); ?>"><?php echo esc_html( rr_email() ); ?></a>
  </div>
</div>
