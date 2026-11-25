<?php
/**
 * A normal page: the content the client writes in the editor, inside the
 * site chrome, with the same type scale as the rest of the site.
 *
 * @package RealtorRaihan
 */

get_header();
$rr_is_faq = is_page( 'dubai-real-estate-faqs' );
$rr_faq_blog = function_exists( 'rr_blog' ) ? rr_blog() : array();
$rr_faq_hero_img = ! empty( $rr_faq_blog['hero_img'] ) ? $rr_faq_blog['hero_img'] : get_theme_mod( 'rr_blog_hero', 'skyline-dusk-wide.webp' );
?>
<div id="top" aria-hidden="true"></div>
<main class="rr-page" id="content">
	<?php if ( $rr_is_faq ) : ?>
		<section class="rr-faq-hero" aria-labelledby="rr-faq-title">
			<div class="rr-faq-hero__bg" aria-hidden="true">
				<img src="<?php echo esc_url( rr_img( $rr_faq_hero_img, 'skyline-dusk-wide.webp' ) ); ?>" alt="" loading="eager" decoding="async">
			</div>
			<div class="rr-faq-hero__inner">
				<p class="rr-faq-hero__eyebrow"><i aria-hidden="true"></i>Frequently Asked Questions</p>
				<h1 id="rr-faq-title"><?php the_title(); ?></h1>
				<p class="rr-faq-hero__lede">Clear answers on buying costs, off-plan payments, visas and buyer protection in Dubai.</p>
				<nav class="rr-faq-hero__crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><i aria-hidden="true"></i><span aria-current="page">FAQs</span></nav>
			</div>
		</section>
	<?php else : ?>
		<header class="rr-page__head">
			<div class="sec__wrap">
				<p class="tag"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
				<h1><?php the_title(); ?></h1>
			</div>
		</header>
	<?php endif; ?>
	<div class="sec__wrap rr-page__body">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();
