<?php
/**
 * Fallback template. WordPress needs this file in every theme; the site itself
 * routes Blog to home.php / single.php.
 *
 * @package RealtorRaihan
 */

get_header();
?>
<main class="rr-main" style="padding-top:var(--barh,0px)">
	<div class="sec__wrap" style="padding-block:clamp(90px,10vw,140px)">
		<?php if ( have_posts() ) : ?>
			<h1 class="rr-fallback-h"><?php echo esc_html( wp_get_document_title() ); ?></h1>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?> style="margin-bottom:40px">
					<h2 style="margin-bottom:10px"><a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
				<?php
			endwhile;
			the_posts_pagination();
		else :
			?>
			<p><?php esc_html_e( 'Nothing found here yet.', 'realtor-raihan' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
