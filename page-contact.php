<?php
/**
 * Contact page template with editable page banner.
 * @package RealtorRaihan
 */
get_header();
$c = rr_contact();
?>
<main id="content" class="ct-page-main">
  <section class="ab-head ct-page-head" aria-labelledby="ct-page-title">
    <div class="ab-head__bg" aria-hidden="true"><img src="<?php echo esc_url( rr_img( $c['banner_image'], 'gen-office-dusk.webp' ) ); ?>" alt="" loading="eager" decoding="async"></div>
    <div class="ab-head__in">
      <p class="ab-head__dot rv">Get in touch</p>
      <h1 class="rv" id="ct-page-title"><?php echo esc_html( $c['banner_title'] ); ?></h1>
      <nav class="ab-head__crumb rv" aria-label="<?php esc_attr_e( 'Breadcrumb', 'realtor-raihan' ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><i aria-hidden="true"></i><span>Contact</span></nav>
    </div>
  </section>
  <?php get_template_part( 'parts/contact' ); ?>
</main>
<?php get_footer(); ?>