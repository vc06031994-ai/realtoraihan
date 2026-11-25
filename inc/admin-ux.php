<?php
/**
 * Keeping the dashboard understandable.
 *
 * The Home and About pages are built from the theme's own sections, which live
 * under "Home Page" in the left menu. WordPress still offers its block editor
 * for those pages, which used to open empty and look broken. This file:
 *
 *   1. puts a short explanation inside those two pages, so the editor is never
 *      a blank canvas,
 *   2. shows a notice on the editor screen with a button to the right place,
 *   3. swaps the "Edit" row action for "Edit content" and points it at the
 *      screen where the content actually lives,
 *   4. renames nothing else, so every other page works like a normal page.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The pages whose content comes from a theme screen.
 *
 * @return array slug => array( screen slug, label )
 */
function rr_managed_pages() {
	return array(
		'home'  => array( 'rr-home', __( 'Home Page', 'realtor-raihan' ) ),
		'about' => array( 'rr-about', __( 'Home Page > About page', 'realtor-raihan' ) ),
	);
}

/**
 * The note stored in those pages, so the block editor explains itself.
 *
 * @param string $screen_label Where the content really is.
 * @return string
 */
function rr_editor_note( $screen_label ) {
	return sprintf(
		/* translators: %s: admin screen name */
		__( 'This page is built by the theme. Its headings, photos and cards are edited under "%s" in the left hand menu. You do not need to add anything here: whatever you type in this editor is not shown on the website.', 'realtor-raihan' ),
		$screen_label
	);
}

/**
 * Keep the body of the two managed pages in step with their settings, so anyone
 * who opens the block editor sees the real content rather than an empty canvas.
 * Runs once per version and again after every save (see inc/page-editor.php).
 */
add_action(
	'wp_loaded',
	function () {
		if ( get_option( 'rr_editor_notes' ) === RR_VERSION ) {
			return;
		}
		if ( function_exists( 'rr_sync_page_body' ) ) {
			rr_sync_page_body( 'home' );
			rr_sync_page_body( 'about' );
		}
		update_option( 'rr_editor_notes', RR_VERSION );
	}
);

/**
 * Notice on the editor screen of a managed page.
 */
add_action(
	'admin_notices',
	function () {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'post' !== $screen->base ) {
			return;
		}
		$post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore
		if ( ! $post_id ) {
			return;
		}
		$slug = get_post_field( 'post_name', $post_id );
		if ( 'blog' === $slug ) {
			printf(
				'<div class="notice notice-info" style="border-left-color:#C8A34D"><p><strong>%s</strong> %s</p><p><a class="button button-primary" href="%s">%s</a> <a class="button" href="%s">%s</a></p></div>',
				esc_html__( 'This page lists your articles automatically.', 'realtor-raihan' ),
				esc_html__( 'Anything typed here is not shown. The page always shows your published posts, newest first. To publish a new article use Posts, and the featured image becomes its photo.', 'realtor-raihan' ),
				esc_url( admin_url( 'post-new.php' ) ),
				esc_html__( 'Add a new article', 'realtor-raihan' ),
				esc_url( get_permalink( $post_id ) ),
				esc_html__( 'View the blog', 'realtor-raihan' )
			);
			return;
		}
		$map = rr_managed_pages();
		if ( ! isset( $map[ $slug ] ) ) {
			return;
		}
		$url = admin_url( 'admin.php?page=' . $map[ $slug ][0] );
		?>
		<div class="notice notice-info" style="border-left-color:#C8A34D">
			<p style="font-size:14px;margin:8px 0">
				<strong><?php esc_html_e( 'This page is built by the theme.', 'realtor-raihan' ); ?></strong>
				<?php
				printf(
					/* translators: %s: admin screen name */
					esc_html__( 'Every heading, paragraph and card of this page is in the "Content of this page" box below. Change the boxes there and press Update to publish. The page itself needs no other editing.', 'realtor-raihan' ),
					esc_html( $map[ $slug ][1] )
				);
				?>
			</p>
			<p style="margin:8px 0 12px">
				<a class="button" href="<?php echo esc_url( $url ); ?>">
					<?php
					printf(
						/* translators: %s: admin screen name */
						esc_html__( 'Open the full screen editor (%s)', 'realtor-raihan' ),
						esc_html( $map[ $slug ][1] )
					);
					?>
				</a>
				<a class="button" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" target="_blank" rel="noopener">
					<?php esc_html_e( 'View the page', 'realtor-raihan' ); ?>
				</a>
			</p>
		</div>
		<?php
	}
);

/**
 * Notice on the Pages list: where does the home page content live.
 */
add_action(
	'admin_notices',
	function () {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'edit-page' !== $screen->id ) {
			return;
		}
		?>
		<div class="notice notice-info is-dismissible" style="border-left-color:#C8A34D">
			<p>
				<strong><?php esc_html_e( 'Home and About are built by the theme.', 'realtor-raihan' ); ?></strong>
				<?php esc_html_e( 'Their text, photos and cards are edited under "Home Page" in the left menu. Every other page and every blog post is edited normally by clicking it.', 'realtor-raihan' ); ?>
				<a class="button button-primary" style="margin-left:8px" href="<?php echo esc_url( admin_url( 'admin.php?page=rr-home' ) ); ?>"><?php esc_html_e( 'Open Home Page content', 'realtor-raihan' ); ?></a>
			</p>
		</div>
		<?php
	}
);

/**
 * In the Pages list, send "Edit" to the screen that actually holds the content.
 *
 * @param array  $actions Row actions.
 * @param WP_Post $post    The post.
 * @return array
 */
add_filter(
	'page_row_actions',
	function ( $actions, $post ) {
		$map = rr_managed_pages();
		if ( ! isset( $map[ $post->post_name ] ) ) {
			return $actions;
		}
		$label   = $map[ $post->post_name ][1];
		$new     = array();
		$new['rr_editor'] = sprintf(
			'<a href="%1$s"><strong>%2$s</strong></a>',
			esc_url( get_edit_post_link( $post->ID ) ),
			esc_html__( 'Edit', 'realtor-raihan' )
		);
		$new['rr_content'] = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( admin_url( 'admin.php?page=' . $map[ $post->post_name ][0] ) ),
			esc_html( sprintf( __( 'Full screen editor (%s)', 'realtor-raihan' ), $label ) )
		);
		foreach ( $actions as $key => $value ) {
			if ( 'edit' === $key || 'inline hide-if-no-js' === $key || 'trash' === $key || 'view' === $key ) {
				continue;
			}
			$new[ $key ] = $value;
		}
		if ( isset( $actions['view'] ) ) {
			$new['view'] = $actions['view'];
		}
		return $new;
	},
	10,
	2
);

/**
 * A dashboard widget so the client sees how to edit the site on the first
 * screen after logging in, instead of guessing.
 */
add_action(
	'wp_dashboard_setup',
	function () {
		wp_add_dashboard_widget(
			'rr_quick_edit',
			__( 'Editing this website', 'realtor-raihan' ),
			function () {
				?>
				<p><?php esc_html_e( 'The home page is built from sections. Edit them here, not inside the page itself:', 'realtor-raihan' ); ?></p>
				<p>
					<a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=rr-home' ) ); ?>"><?php esc_html_e( 'Home Page content', 'realtor-raihan' ); ?></a>
					<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=rr-about' ) ); ?>"><?php esc_html_e( 'About page', 'realtor-raihan' ); ?></a>
					<a class="button" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Logo, phone, footer', 'realtor-raihan' ); ?></a>
				</p>
				<p class="description"><?php esc_html_e( 'Blog articles are normal WordPress posts: Posts > Add New. Featured image becomes the article photo.', 'realtor-raihan' ); ?></p>
				<?php
			}
		);
	}
);
