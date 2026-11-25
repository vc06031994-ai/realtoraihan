<?php
/**
 * The blog index: hero, topic filter, dynamic post grid, newsletter band.
 * Posts come dynamically from WordPress, so any article added under Posts
 * automatically appears here.
 *
 * @package RealtorRaihan
 */

get_header();

$b = function_exists( 'rr_blog' ) ? rr_blog() : array();

// WordPress can expose the archive page number through either query var,
 // depending on whether Blog is configured as the Posts page or a page template.
$paged = max(
	1,
	absint( get_query_var( 'paged' ) ),
	absint( get_query_var( 'page' ) )
);

// Show every published blog post on one page (pagination is disabled).
$posts_per_page = -1;

$blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'paged'               => $paged,
		'posts_per_page'      => $posts_per_page,
		'ignore_sticky_posts' => 0,
	)
);

$terms = get_terms(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
	)
);

$hero_img = ! empty( $b['hero_img'] ) ? $b['hero_img'] : get_theme_mod( 'rr_blog_hero', 'skyline-dusk-wide.webp' );
?>
<div id="top" aria-hidden="true"></div>

<!-- hero -->
<section class="bl-hero" id="top-blog" aria-labelledby="bl-title">
  <div class="bl-hero__bg" aria-hidden="true">
    <img src="<?php echo esc_url( rr_img( $hero_img, 'skyline-dusk-wide.webp' ) ); ?>" alt="" loading="eager" decoding="async">
  </div>
  <div class="bl-hero__wrap">
    <p class="bl-meta-eyebrow"><i aria-hidden="true"></i><span><?php echo esc_html( isset( $b['eyebrow'] ) ? $b['eyebrow'] : rr_mod( 'rr_blog_eyebrow', 'Property notes' ) ); ?></span></p>
    <h1 id="bl-title"><?php echo rr_rich( isset( $b['title'] ) ? nl2br( $b['title'] ) : rr_mod( 'rr_blog_title', 'Dubai property,<br>explained <em>properly.</em>' ) ); ?></h1>
    <p class="bl-hero__lede"><?php echo esc_html( isset( $b['lede'] ) ? $b['lede'] : rr_mod( 'rr_blog_lede', 'Service charges, yields, payment plans, handover snags and the paperwork nobody warns you about. These are the notes I would send a friend before they buy. Short, specific, and written from deals I have actually closed.' ) ); ?></p>
    <nav class="bl-crumb" aria-label="Breadcrumb">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
      <i aria-hidden="true"></i>
      <span aria-current="page">Blog</span>
    </nav>
  </div>
</section>

<!-- intro -->
<section class="bl-titles" aria-labelledby="bl-list-title">
  <div class="bl-titles__wrap">
    <p class="tag tag--center"><?php echo esc_html( isset( $b['list_tag'] ) ? $b['list_tag'] : 'Blog' ); ?></p>
    <h2 id="bl-list-title"><?php echo rr_rich( isset( $b['list_title'] ) ? nl2br( $b['list_title'] ) : rr_mod( 'rr_blog_list_title', 'Discover our latest Dubai<br>property <em>insights.</em>' ) ); ?></h2>
  </div>
</section>

<!-- list -->
<section class="bl-list" id="notes">
  <div class="bl-list__wrap">
    <div class="bl-list__head">
      <div class="bl-filter" role="group" aria-label="<?php esc_attr_e( 'Filter by topic', 'realtor-raihan' ); ?>">
        <button class="bl-chip is-on" type="button" data-cat="all"><?php echo esc_html( isset( $b['filter_all'] ) ? $b['filter_all'] : 'All' ); ?></button>
        <?php
        if ( $terms && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                printf(
                    '<button class="bl-chip" type="button" data-cat="%1$s">%2$s</button>',
                    esc_attr( $term->slug ),
                    esc_html( $term->name )
                );
            }
        }
        ?>
      </div>
    </div>

    <div class="bl-grid" id="blGrid">
      <?php
      if ( $blog_query->have_posts() ) :
          while ( $blog_query->have_posts() ) :
              $blog_query->the_post();
              $cats       = get_the_category();
              $cat_slugs  = array();
              $cat_names  = array();
              if ( $cats && ! is_wp_error( $cats ) ) {
                  foreach ( $cats as $c ) {
                      $cat_slugs[] = $c->slug;
                      $cat_names[] = $c->name;
                  }
              }
              $cat_slug_attr = ! empty( $cat_slugs ) ? implode( ' ', $cat_slugs ) : '';
              $primary_cat   = ! empty( $cat_names ) ? $cat_names[0] : '';
              ?>
              <a class="bl-card" href="<?php the_permalink(); ?>" data-cat="<?php echo esc_attr( $cat_slug_attr ); ?>">
                <div class="bl-card__img">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'rr-card', array( 'loading' => 'lazy' ) ); ?>
                  <?php else : ?>
                    <img src="<?php echo esc_url( RR_URI . '/assets/img/gen-marina-night.webp' ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" decoding="async">
                  <?php endif; ?>
                </div>
                <div class="bl-card__body">
                  <p class="bl-card__date">
                    <span><?php echo esc_html( get_the_date() ); ?></span>
                    <?php if ( $primary_cat ) : ?>
                      <i aria-hidden="true"></i><span><?php echo esc_html( $primary_cat ); ?></span>
                    <?php endif; ?>
                    <i aria-hidden="true"></i><span><?php echo esc_html( rr_reading_time() ); ?></span>
                  </p>
                  <h3><?php the_title(); ?></h3>
                  <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
                  <span class="bl-more"><?php echo esc_html( isset( $b['read_more'] ) ? $b['read_more'] : 'Read the note' ); ?>
                    <?php echo rr_arrow(); // phpcs:ignore ?>
                  </span>
                </div>
              </a>
              <?php
          endwhile;
      else :
          ?>
          <p><?php echo esc_html( isset( $b['empty_msg'] ) ? $b['empty_msg'] : 'No articles yet. Add your first one under Posts.' ); ?></p>
      <?php endif; ?>
    </div>
    <?php wp_reset_postdata(); ?>
  </div>
</section>

<!-- newsletter -->
<section class="bl-new" aria-labelledby="bl-new-title">
  <div class="bl-new__wrap">
    <div>
      <h2 id="bl-new-title"><?php echo rr_rich( isset( $b['news_title'] ) ? nl2br( $b['news_title'] ) : rr_mod( 'rr_news_title', 'One note a month,<br><em>no noise.</em>' ) ); ?></h2>
      <p><?php echo esc_html( isset( $b['news_text'] ) ? $b['news_text'] : rr_mod( 'rr_news_text', 'A short email with what actually moved in the Dubai market, plus one thing worth knowing before your next viewing. Unsubscribe any time.' ) ); ?></p>
    </div>
    <form id="blForm" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" novalidate>
      <input type="hidden" name="action" value="rr_newsletter">
      <?php wp_nonce_field( 'rr_newsletter', 'rr_newsletter_nonce' ); ?>
      <input type="email" id="blEmail" name="email" placeholder="<?php echo esc_attr( isset( $b['news_placeholder'] ) ? $b['news_placeholder'] : 'you@example.com' ); ?>" aria-label="<?php esc_attr_e( 'Email address', 'realtor-raihan' ); ?>" required>
      <button class="pill pill--gold" type="submit"><?php echo esc_html( isset( $b['news_btn'] ) ? $b['news_btn'] : 'Subscribe' ); ?>
        <?php echo rr_arrow(); // phpcs:ignore ?>
      </button>
      <small id="blNote"><?php echo isset( $_GET['newsletter'] ) && 'sent' === $_GET['newsletter'] ? esc_html__( 'Thank you, you are on the list.', 'realtor-raihan' ) : esc_html( isset( $b['news_note'] ) ? $b['news_note'] : 'One email a month. Unsubscribe any time.' ); ?></small>
    </form>
  </div>
</section>

<?php
get_footer();
