<?php
/**
 * The Blog page editor. Content lives in one option array so the whole page is
 * editable from a single admin screen as well as the WordPress page editor.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Blog page content.
 *
 * @return array
 */
function rr_blog_defaults() {
	return array(
		'eyebrow'          => 'Property notes',
		'title'            => "Dubai property,\nexplained <em>properly.</em>",
		'lede'             => 'Service charges, yields, payment plans, handover snags and the paperwork nobody warns you about. These are the notes I would send a friend before they buy. Short, specific, and written from deals I have actually closed.',
		'hero_img'         => 'skyline-dusk-wide.webp',
		'list_tag'         => 'Blog',
		'list_title'       => "Discover our latest Dubai\nproperty <em>insights.</em>",
		'filter_all'       => 'All',
		'read_more'        => 'Read the note',
		'empty_msg'        => 'No articles yet. Add your first one under Posts.',
		'news_title'       => "One note a month,\n<em>no noise.</em>",
		'news_text'        => 'A short email with what actually moved in the Dubai market, plus one thing worth knowing before your next viewing. Unsubscribe any time.',
		'news_placeholder' => 'you@example.com',
		'news_btn'         => 'Subscribe',
		'news_note'        => 'One email a month. Unsubscribe any time.',
	);
}

/**
 * Read the Blog content, merged over defaults and existing theme_mods.
 *
 * @return array
 */
function rr_blog() {
	$saved = get_option( 'rr_blog_page', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	$fallbacks = array();
	$theme_mod_eyebrow    = get_theme_mod( 'rr_blog_eyebrow', '' );
	$theme_mod_title      = get_theme_mod( 'rr_blog_title', '' );
	$theme_mod_lede       = get_theme_mod( 'rr_blog_lede', '' );
	$theme_mod_hero       = get_theme_mod( 'rr_blog_hero', '' );
	$theme_mod_list_title = get_theme_mod( 'rr_blog_list_title', '' );
	$theme_mod_news_title = get_theme_mod( 'rr_news_title', '' );
	$theme_mod_news_text  = get_theme_mod( 'rr_news_text', '' );

	if ( $theme_mod_eyebrow )    { $fallbacks['eyebrow'] = $theme_mod_eyebrow; }
	if ( $theme_mod_title )      { $fallbacks['title'] = $theme_mod_title; }
	if ( $theme_mod_lede )       { $fallbacks['lede'] = $theme_mod_lede; }
	if ( $theme_mod_hero )       { $fallbacks['hero_img'] = $theme_mod_hero; }
	if ( $theme_mod_list_title ) { $fallbacks['list_title'] = $theme_mod_list_title; }
	if ( $theme_mod_news_title ) { $fallbacks['news_title'] = $theme_mod_news_title; }
	if ( $theme_mod_news_text )  { $fallbacks['news_text'] = $theme_mod_news_text; }

	return array_merge( rr_blog_defaults(), $fallbacks, $saved );
}

add_action(
	'admin_menu',
	function () {
		add_submenu_page(
			'rr-home',
			__( 'Blog page', 'realtor-raihan' ),
			__( 'Blog page', 'realtor-raihan' ),
			'edit_pages',
			'rr-blog',
			'rr_blog_admin_screen'
		);
	}
);

add_action(
	'admin_post_rr_blog_save',
	function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'realtor-raihan' ) );
		}
		check_admin_referer( 'rr_blog_save' );

		$defaults = rr_blog_defaults();
		$posted   = isset( $_POST['rr'] ) && is_array( $_POST['rr'] ) ? wp_unslash( $_POST['rr'] ) : array(); // phpcs:ignore
		$clean    = array();

		foreach ( $defaults as $key => $default ) {
			$clean[ $key ] = isset( $posted[ $key ] ) ? wp_kses_post( trim( (string) $posted[ $key ] ) ) : '';
		}

		update_option( 'rr_blog_page', $clean );

		// Sync back to theme mods so customizer and other consumers stay 100% in sync
		if ( ! empty( $clean['eyebrow'] ) )    { set_theme_mod( 'rr_blog_eyebrow', $clean['eyebrow'] ); }
		if ( ! empty( $clean['title'] ) )      { set_theme_mod( 'rr_blog_title', $clean['title'] ); }
		if ( ! empty( $clean['lede'] ) )       { set_theme_mod( 'rr_blog_lede', $clean['lede'] ); }
		if ( ! empty( $clean['hero_img'] ) )   { set_theme_mod( 'rr_blog_hero', $clean['hero_img'] ); }
		if ( ! empty( $clean['list_title'] ) ) { set_theme_mod( 'rr_blog_list_title', $clean['list_title'] ); }
		if ( ! empty( $clean['news_title'] ) ) { set_theme_mod( 'rr_news_title', $clean['news_title'] ); }
		if ( ! empty( $clean['news_text'] ) )  { set_theme_mod( 'rr_news_text', $clean['news_text'] ); }

		if ( function_exists( 'rr_sync_page_body' ) ) {
			rr_sync_page_body( 'blog' );
		}

		wp_safe_redirect( add_query_arg( 'rr_saved', '1', admin_url( 'admin.php?page=rr-blog' ) ) );
		exit;
	}
);

/**
 * The Blog admin screen.
 */
function rr_blog_admin_screen() {
	$data  = rr_blog();
	$saved = isset( $_GET['rr_saved'] ); // phpcs:ignore
	$long  = array( 'title', 'lede', 'list_title', 'news_title', 'news_text' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Blog page content', 'realtor-raihan' ); ?></h1>
		<?php if ( $saved ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Blog page saved.', 'realtor-raihan' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="rr_blog_save">
			<?php wp_nonce_field( 'rr_blog_save' ); ?>

			<h2><?php esc_html_e( 'Hero banner', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$fields_hero = array(
					'eyebrow'  => 'Small label above heading',
					'title'    => 'Headline (use <em>...</em> for gold italic, or new line for break)',
					'lede'     => 'Introductory paragraph',
					'hero_img' => 'Hero background photo (filename in assets/img or full media URL)',
				);
				foreach ( $fields_hero as $k => $label ) {
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td>';
					if ( in_array( $k, $long, true ) ) {
						echo '<textarea class="large-text" rows="3" name="rr[' . esc_attr( $k ) . ']">' . esc_textarea( $data[ $k ] ) . '</textarea>';
					} else {
						echo '<input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '">';
					}
					echo '</td></tr>';
				}
				?>
			</tbody></table>

			<h2><?php esc_html_e( 'Articles section & filter', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$fields_list = array(
					'list_tag'   => 'Articles section: small tag (e.g. Blog)',
					'list_title' => 'Articles section: heading (use <em>...</em> for gold italic)',
					'filter_all' => 'Filter "All" button label',
					'read_more'  => 'Article card read link text (e.g. Read the note)',
					'empty_msg'  => 'Message when no articles are published yet',
				);
				foreach ( $fields_list as $k => $label ) {
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td>';
					if ( in_array( $k, $long, true ) ) {
						echo '<textarea class="large-text" rows="3" name="rr[' . esc_attr( $k ) . ']">' . esc_textarea( $data[ $k ] ) . '</textarea>';
					} else {
						echo '<input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '">';
					}
					echo '</td></tr>';
				}
				?>
			</tbody></table>

			<h2><?php esc_html_e( 'Newsletter band', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$fields_news = array(
					'news_title'       => 'Newsletter heading (use <em>...</em> for gold italic)',
					'news_text'        => 'Newsletter description paragraph',
					'news_placeholder' => 'Email input placeholder (e.g. you@example.com)',
					'news_btn'         => 'Subscribe button text',
					'news_note'        => 'Note below button (e.g. One email a month. Unsubscribe any time.)',
				);
				foreach ( $fields_news as $k => $label ) {
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td>';
					if ( in_array( $k, $long, true ) ) {
						echo '<textarea class="large-text" rows="3" name="rr[' . esc_attr( $k ) . ']">' . esc_textarea( $data[ $k ] ) . '</textarea>';
					} else {
						echo '<input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '">';
					}
					echo '</td></tr>';
				}
				?>
			</tbody></table>

			<?php submit_button( __( 'Save Blog Page', 'realtor-raihan' ) ); ?>
		</form>
	</div>
	<?php
}
