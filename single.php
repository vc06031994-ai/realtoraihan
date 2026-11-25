<?php
/**
 * A single blog article, in the approved article design.
 *
 * @package RealtorRaihan
 */

get_header();

while ( have_posts() ) :
	the_post();

	$cats       = get_the_category();
	$cat_name   = $cats ? $cats[0]->name : '';
	$hero       = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : RR_URI . '/assets/img/skyline-sunset-wide.webp';
	$author_img = get_theme_mod( 'rr_author_img', RR_URI . '/assets/img/raihan-beach.webp' );
	$related    = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'        => 3,
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => true,
		)
	);
	?>
	<div id="top" aria-hidden="true"></div>

	<article <?php post_class( 'rr-article' ); ?>>
		<header class="po-hero" id="article-top">
			<div class="po-hero__bg" aria-hidden="true">
				<img src="<?php echo esc_url( $hero ); ?>" alt="" loading="eager" decoding="async">
			</div>
			<div class="po-hero__wrap">
				<p class="po-crumb">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'realtor-raihan' ); ?></a><i aria-hidden="true"></i>
					<a href="<?php echo esc_url( rr_blog_url() ); ?>"><?php esc_html_e( 'Blog', 'realtor-raihan' ); ?></a><i aria-hidden="true"></i>
					<span><?php echo esc_html( $cat_name ); ?></span>
				</p>
				<p class="po-meta">
					<span class="po-cat"><?php echo esc_html( $cat_name ); ?></span><i aria-hidden="true"></i>
					<span><?php echo esc_html( get_the_date() ); ?></span><i aria-hidden="true"></i>
					<span><?php echo esc_html( rr_reading_time() ); ?></span>
				</p>
				<h1><?php the_title(); ?></h1>
			</div>
		</header>

		<div class="po-body sec">
			<div class="po-body__wrap">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="po-pages">',
						'after'  => '</div>',
					)
				);
				?>

				<div class="po-foot">
					<div class="po-foot__who">
						<img src="<?php echo esc_url( $author_img ); ?>" alt="<?php echo esc_attr( get_theme_mod( 'rr_author_name', 'Raihan Shaikh' ) ); ?>">
						<div>
							<b><?php echo esc_html( get_theme_mod( 'rr_author_name', 'Raihan Shaikh' ) ); ?></b>
							<small><?php echo esc_html( rr_mod( 'rr_author_role', 'Senior Property Consultant' ) . ' · ' . rr_mod( 'rr_agency', 'Homes 4 Life Real Estate' ) ); ?></small>
						</div>
					</div>
					<a class="pill pill--navy" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>"><?php esc_html_e( 'Ask me about this', 'realtor-raihan' ); ?>
						<?php echo rr_arrow(); // phpcs:ignore ?>
					</a>
				</div>

				<p class="po-disc"><?php echo esc_html( rr_mod( 'rr_footer_disc', 'Information on this website is general guidance, not financial, tax, or legal advice. Property prices, payment plans, rental yields, and visa requirements change and must be verified independently before you commit.' ) ); ?></p>
			</div>
		</div>

		<?php if ( $related->have_posts() ) : ?>
			<section class="po-next sec" aria-labelledby="po-next-h">
				<div class="sec__wrap">
					<div class="po-next__head">
						<h2 id="po-next-h"><?php esc_html_e( 'Read next', 'realtor-raihan' ); ?></h2>
						<a class="pill pill--outline pill--sm" href="<?php echo esc_url( rr_blog_url() ); ?>"><?php esc_html_e( 'All notes', 'realtor-raihan' ); ?></a>
					</div>
					<div class="po-next__grid">
						<?php
						while ( $related->have_posts() ) :
							$related->the_post();
							$thumb = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'rr-card' ) : RR_URI . '/assets/img/gen-marina-night.webp';
							?>
							<a class="po-card" href="<?php the_permalink(); ?>">
								<div class="po-card__img"><img src="<?php echo esc_url( $thumb ); ?>" alt="" loading="lazy" decoding="async"></div>
								<div class="po-card__body">
									<h3><?php the_title(); ?></h3>
									<p><?php echo esc_html( ( $cats ? $cats[0]->name : '' ) . ' · ' . rr_reading_time() ); ?></p>
								</div>
							</a>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</article>
	<?php
endwhile;

get_footer();
