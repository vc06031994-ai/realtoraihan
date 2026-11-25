<?php
/**
 * Custom Post Types: Testimonials & Social Media Icons.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register CPTs: testimonial and social_icon.
 */
function rr_register_post_types() {
	// 1. Testimonials CPT
	$labels_testimonial = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'realtor-raihan' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'realtor-raihan' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'realtor-raihan' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'realtor-raihan' ),
		'add_new'            => _x( 'Add New', 'testimonial', 'realtor-raihan' ),
		'add_new_item'       => __( 'Add New Testimonial', 'realtor-raihan' ),
		'new_item'           => __( 'New Testimonial', 'realtor-raihan' ),
		'edit_item'          => __( 'Edit Testimonial', 'realtor-raihan' ),
		'view_item'          => __( 'View Testimonial', 'realtor-raihan' ),
		'all_items'          => __( 'All Testimonials', 'realtor-raihan' ),
		'search_items'       => __( 'Search Testimonials', 'realtor-raihan' ),
		'not_found'          => __( 'No testimonials found.', 'realtor-raihan' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'realtor-raihan' ),
	);

	$args_testimonial = array(
		'labels'             => $labels_testimonial,
		'description'        => __( 'Client reviews and testimonials.', 'realtor-raihan' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-testimonial',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'testimonial', $args_testimonial );

	// 2. Social Media Icons CPT
	$labels_social = array(
		'name'               => _x( 'Social Icons', 'post type general name', 'realtor-raihan' ),
		'singular_name'      => _x( 'Social Icon', 'post type singular name', 'realtor-raihan' ),
		'menu_name'          => _x( 'Social Icons', 'admin menu', 'realtor-raihan' ),
		'name_admin_bar'     => _x( 'Social Icon', 'add new on admin bar', 'realtor-raihan' ),
		'add_new'            => _x( 'Add New', 'social icon', 'realtor-raihan' ),
		'add_new_item'       => __( 'Add New Social Icon', 'realtor-raihan' ),
		'new_item'           => __( 'New Social Icon', 'realtor-raihan' ),
		'edit_item'          => __( 'Edit Social Icon', 'realtor-raihan' ),
		'view_item'          => __( 'View Social Icon', 'realtor-raihan' ),
		'all_items'          => __( 'All Social Icons', 'realtor-raihan' ),
		'search_items'       => __( 'Search Social Icons', 'realtor-raihan' ),
		'not_found'          => __( 'No social icons found.', 'realtor-raihan' ),
		'not_found_in_trash' => __( 'No social icons found in Trash.', 'realtor-raihan' ),
	);

	$args_social = array(
		'labels'             => $labels_social,
		'description'        => __( 'Social media profile links and footer icons.', 'realtor-raihan' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-share',
		'supports'           => array( 'title', 'page-attributes' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'social_icon', $args_social );
}
add_action( 'init', 'rr_register_post_types' );

/**
 * Register Meta Boxes.
 */
function rr_add_cpt_meta_boxes() {
	// Testimonial Meta Box
	add_meta_box(
		'rr_testimonial_meta',
		__( 'Testimonial Details', 'realtor-raihan' ),
		'rr_render_testimonial_meta_box',
		'testimonial',
		'normal',
		'high'
	);

	// Social Icon Meta Box
	add_meta_box(
		'rr_social_meta',
		__( 'Social Link Details', 'realtor-raihan' ),
		'rr_render_social_meta_box',
		'social_icon',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'rr_add_cpt_meta_boxes' );

/**
 * Render Testimonial Meta Box.
 *
 * @param WP_Post $post Current post.
 */
function rr_render_testimonial_meta_box( $post ) {
	wp_nonce_field( 'rr_save_testimonial_meta', 'rr_testimonial_nonce' );

	$role   = get_post_meta( $post->ID, '_rr_client_role', true );
	$rating = get_post_meta( $post->ID, '_rr_client_rating', true );
	if ( '' === $rating ) {
		$rating = 5;
	}
	?>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label for="rr_client_role"><?php esc_html_e( 'Client Role / Location', 'realtor-raihan' ); ?></label></th>
				<td>
					<input type="text" id="rr_client_role" name="rr_client_role" value="<?php echo esc_attr( $role ); ?>" class="large-text" placeholder="e.g. PROPERTY BUYER · DUBAI, UAE">
					<p class="description"><?php esc_html_e( 'Appears under the client name in all caps.', 'realtor-raihan' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="rr_client_rating"><?php esc_html_e( 'Star Rating', 'realtor-raihan' ); ?></label></th>
				<td>
					<select id="rr_client_rating" name="rr_client_rating">
						<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
							<option value="<?php echo (int) $i; ?>" <?php selected( (int) $rating, $i ); ?>>
								<?php echo esc_html( str_repeat( '★', $i ) . ' (' . $i . '/5)' ); ?>
							</option>
						<?php endfor; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

/**
 * Render Social Icon Meta Box.
 *
 * @param WP_Post $post Current post.
 */
function rr_render_social_meta_box( $post ) {
	wp_nonce_field( 'rr_save_social_meta', 'rr_social_nonce' );

	$platform   = get_post_meta( $post->ID, '_rr_social_platform', true );
	$url        = get_post_meta( $post->ID, '_rr_social_url', true );
	$target     = get_post_meta( $post->ID, '_rr_social_target', true );
	$custom_svg = get_post_meta( $post->ID, '_rr_social_svg', true );

	$platforms = array(
		'whatsapp'  => 'WhatsApp',
		'instagram' => 'Instagram',
		'facebook'  => 'Facebook',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
		'x'         => 'X / Twitter',
		'tiktok'    => 'TikTok',
		'telegram'  => 'Telegram',
		'email'     => 'Email (mailto:)',
		'phone'     => 'Phone (tel:)',
		'contact'   => 'Contact / Enquiry Form',
		'custom'    => 'Custom SVG Icon',
	);
	?>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><label for="rr_social_platform"><?php esc_html_e( 'Platform / Icon', 'realtor-raihan' ); ?></label></th>
				<td>
					<select id="rr_social_platform" name="rr_social_platform" class="regular-text">
						<?php foreach ( $platforms as $key => $lbl ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $platform, $key ); ?>><?php echo esc_html( $lbl ); ?></option>
						<?php endforeach; ?>
					</select>
					<p class="description"><?php esc_html_e( 'Select the platform to automatically display its official branded SVG icon.', 'realtor-raihan' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="rr_social_url"><?php esc_html_e( 'Target URL / Link', 'realtor-raihan' ); ?></label></th>
				<td>
					<input type="text" id="rr_social_url" name="rr_social_url" value="<?php echo esc_attr( $url ); ?>" class="large-text" placeholder="https://instagram.com/... or mailto:... or tel:...">
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Open in New Tab', 'realtor-raihan' ); ?></th>
				<td>
					<label for="rr_social_target">
						<input type="checkbox" id="rr_social_target" name="rr_social_target" value="_blank" <?php checked( $target, '_blank' ); ?>>
						<?php esc_html_e( 'Open link in a new window/tab (target="_blank")', 'realtor-raihan' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="rr_social_svg"><?php esc_html_e( 'Custom SVG (Optional)', 'realtor-raihan' ); ?></label></th>
				<td>
					<textarea id="rr_social_svg" name="rr_social_svg" rows="4" class="large-text code" placeholder="<svg ...>...</svg>"><?php echo esc_textarea( $custom_svg ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Optional: paste raw SVG markup to override the default platform icon.', 'realtor-raihan' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

/**
 * Save CPT Meta Data.
 *
 * @param int $post_id Current post id.
 */
function rr_save_cpt_meta_data( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// 1. Save Testimonial Meta
	if ( isset( $_POST['rr_testimonial_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['rr_testimonial_nonce'] ), 'rr_save_testimonial_meta' ) ) {
		if ( current_user_can( 'edit_post', $post_id ) ) {
			if ( isset( $_POST['rr_client_role'] ) ) {
				update_post_meta( $post_id, '_rr_client_role', sanitize_text_field( wp_unslash( $_POST['rr_client_role'] ) ) );
			}
			if ( isset( $_POST['rr_client_rating'] ) ) {
				update_post_meta( $post_id, '_rr_client_rating', (int) $_POST['rr_client_rating'] );
			}
		}
	}

	// 2. Save Social Icon Meta
	if ( isset( $_POST['rr_social_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['rr_social_nonce'] ), 'rr_save_social_meta' ) ) {
		if ( current_user_can( 'edit_post', $post_id ) ) {
			if ( isset( $_POST['rr_social_platform'] ) ) {
				update_post_meta( $post_id, '_rr_social_platform', sanitize_key( wp_unslash( $_POST['rr_social_platform'] ) ) );
			}
			if ( isset( $_POST['rr_social_url'] ) ) {
				update_post_meta( $post_id, '_rr_social_url', esc_url_raw( wp_unslash( $_POST['rr_social_url'] ), array( 'http', 'https', 'mailto', 'tel' ) ) );
			}
			$target = isset( $_POST['rr_social_target'] ) ? '_blank' : '';
			update_post_meta( $post_id, '_rr_social_target', $target );

			if ( isset( $_POST['rr_social_svg'] ) ) {
				// Allow only safe SVG markup
				update_post_meta( $post_id, '_rr_social_svg', wp_kses( wp_unslash( $_POST['rr_social_svg'] ), array(
					'svg'   => array( 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'class' => true, 'aria-hidden' => true ),
					'path'  => array( 'd' => true, 'fill' => true, 'stroke' => true ),
					'rect'  => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true ),
					'circle'=> array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true ),
					'line'  => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true ),
				) ) );
			}
		}
	}
}
add_action( 'save_post', 'rr_save_cpt_meta_data' );

/**
 * Custom Columns for Testimonials Admin List.
 */
function rr_testimonial_columns( $cols ) {
	$new = array();
	foreach ( $cols as $key => $val ) {
		$new[ $key ] = $val;
		if ( 'title' === $key ) {
			$new['rr_role']   = __( 'Client Role', 'realtor-raihan' );
			$new['rr_rating'] = __( 'Rating', 'realtor-raihan' );
			$new['rr_order']  = __( 'Order', 'realtor-raihan' );
		}
	}
	return $new;
}
add_filter( 'manage_testimonial_posts_columns', 'rr_testimonial_columns' );

function rr_testimonial_custom_column( $col, $post_id ) {
	if ( 'rr_role' === $col ) {
		$role = get_post_meta( $post_id, '_rr_client_role', true );
		echo esc_html( $role ? $role : '—' );
	} elseif ( 'rr_rating' === $col ) {
		$rating = (int) get_post_meta( $post_id, '_rr_client_rating', true );
		if ( ! $rating ) {
			$rating = 5;
		}
		echo '<span style="color:#C8A34D;font-size:1.1em">' . esc_html( str_repeat( '★', $rating ) ) . '</span>';
	} elseif ( 'rr_order' === $col ) {
		$post = get_post( $post_id );
		echo (int) $post->menu_order;
	}
}
add_action( 'manage_testimonial_posts_custom_column', 'rr_testimonial_custom_column', 10, 2 );

/**
 * Custom Columns for Social Icons Admin List.
 */
function rr_social_columns( $cols ) {
	$new = array();
	foreach ( $cols as $key => $val ) {
		$new[ $key ] = $val;
		if ( 'title' === $key ) {
			$new['rr_platform'] = __( 'Platform / Icon', 'realtor-raihan' );
			$new['rr_url']      = __( 'Link URL', 'realtor-raihan' );
			$new['rr_order']    = __( 'Order', 'realtor-raihan' );
		}
	}
	return $new;
}
add_filter( 'manage_social_icon_posts_columns', 'rr_social_columns' );

function rr_social_custom_column( $col, $post_id ) {
	if ( 'rr_platform' === $col ) {
		$platform = get_post_meta( $post_id, '_rr_social_platform', true );
		$svg = rr_get_social_svg( $platform, get_post_meta( $post_id, '_rr_social_svg', true ) );
		echo '<span style="display:inline-flex;align-items:center;gap:8px;">';
		echo '<span style="display:inline-flex;width:24px;height:24px;color:#0B1F3A;">' . $svg . '</span>'; // phpcs:ignore
		echo '<strong>' . esc_html( ucfirst( $platform ? $platform : 'link' ) ) . '</strong>';
		echo '</span>';
	} elseif ( 'rr_url' === $col ) {
		$url = get_post_meta( $post_id, '_rr_social_url', true );
		if ( $url ) {
			echo '<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html( $url ) . '</a>';
		} else {
			echo '—';
		}
	} elseif ( 'rr_order' === $col ) {
		$post = get_post( $post_id );
		echo (int) $post->menu_order;
	}
}
add_action( 'manage_social_icon_posts_custom_column', 'rr_social_custom_column', 10, 2 );

/**
 * Returns SVG code for a social platform.
 *
 * @param string $platform Platform key.
 * @param string $custom_svg Optional custom SVG override.
 * @return string Safe SVG markup.
 */
function rr_get_social_svg( $platform, $custom_svg = '' ) {
	if ( ! empty( $custom_svg ) ) {
		return $custom_svg;
	}

	switch ( strtolower( (string) $platform ) ) {
		case 'whatsapp':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 1.8a8.2 8.2 0 0 1 0 16.4 8.1 8.1 0 0 1-4.2-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 0 1 12 3.8Zm-3 4c-.2 0-.5.1-.7.3-.3.3-.8.8-.8 1.9s.8 2.1 1 2.2c.1.2 1.6 2.4 3.9 3.4 1.9.8 2.3.7 2.7.6.5 0 1.2-.5 1.4-1 .2-.5.2-.9.1-1l-.5-.3-1.4-.7c-.2-.1-.4-.1-.5.1l-.6.8c-.1.2-.3.2-.5.1-.2-.1-.9-.3-1.7-1a6.3 6.3 0 0 1-1.2-1.5c-.1-.2 0-.3.1-.4l.3-.4.2-.4v-.4l-.7-1.6c-.2-.4-.4-.4-.5-.4h-.5Z"/></svg>';

		case 'instagram':
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>';

		case 'facebook':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>';

		case 'linkedin':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.64 1.64 0 1 0 0-3.28 1.64 1.64 0 0 0 0 3.28m1.37 9.74v-8.37H5.09v8.37h2.74z"/></svg>';

		case 'youtube':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.55 9.376.55 9.376.55s7.505 0 9.377-.55a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';

		case 'x':
		case 'twitter':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';

		case 'tiktok':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>';

		case 'telegram':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l-.313 4.674c.459 0 .661-.21.917-.46l2.203-2.14 4.58 3.385c.844.465 1.452.226 1.662-.782l3.007-14.166c.308-1.233-.472-1.793-1.272-1.478z"/></svg>';

		case 'email':
		case 'mail':
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="4.5" width="19" height="15" rx="2.5"/><path d="m3 6.5 9 6 9-6"/></svg>';

		case 'phone':
		case 'call':
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>';

		case 'contact':
		case 'form':
		case 'chat':
		default:
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>';
	}
}

/**
 * Get dynamic testimonials list with fallback to theme defaults.
 *
 * @return array
 */
function rr_get_dynamic_testimonials() {
	$posts = get_posts( array(
		'post_type'      => 'testimonial',
		'post_status'    => 'publish',
		'posts_per_page' => 20,
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
	) );

	if ( ! empty( $posts ) ) {
		$items = array();
		foreach ( $posts as $p ) {
			$role = get_post_meta( $p->ID, '_rr_client_role', true );
			if ( ! $role ) {
				$role = __( 'Property Client · Dubai, UAE', 'realtor-raihan' );
			}
			$rating = (int) get_post_meta( $p->ID, '_rr_client_rating', true );
			if ( ! $rating ) {
				$rating = 5;
			}
			$avatar_url = get_the_post_thumbnail_url( $p->ID, 'thumbnail' );

			$items[] = array(
				'name'   => get_the_title( $p ),
				'role'   => $role,
				'quote'  => apply_filters( 'the_content', $p->post_content ),
				'rating' => $rating,
				'avatar' => $avatar_url ? $avatar_url : '',
			);
		}
		return $items;
	}

	// Fallback to home fields default testimonials
	$fallback = rr_h_rows( 'testimonials' );
	$items = array();
	foreach ( $fallback as $row ) {
		$items[] = array(
			'name'   => $row['name'],
			'role'   => $row['role'],
			'quote'  => $row['quote'],
			'rating' => 5,
			'avatar' => '',
		);
	}
	return $items;
}

/**
 * Render dynamic social media icons in footer.
 */
function rr_render_social_icons() {
	$posts = get_posts( array(
		'post_type'      => 'social_icon',
		'post_status'    => 'publish',
		'posts_per_page' => 20,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	) );

	if ( ! empty( $posts ) ) {
		foreach ( $posts as $p ) {
			$platform   = get_post_meta( $p->ID, '_rr_social_platform', true );
			$url        = get_post_meta( $p->ID, '_rr_social_url', true );
			$target     = get_post_meta( $p->ID, '_rr_social_target', true );
			$custom_svg = get_post_meta( $p->ID, '_rr_social_svg', true );
			$label      = get_the_title( $p );

			if ( empty( $url ) ) {
				$url = '#';
			}
			$svg = rr_get_social_svg( $platform, $custom_svg );
			?>
			<a class="ft__soc" href="<?php echo esc_url( $url ); ?>"<?php echo '_blank' === $target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?> aria-label="<?php echo esc_attr( $label ); ?>">
				<?php echo $svg; // phpcs:ignore ?>
			</a>
			<?php
		}
		return;
	}

	// Fallback to default footer 4 icons if no CPT posts yet
	?>
	<a class="ft__soc" href="<?php echo esc_url( rr_whatsapp() ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
		<?php echo rr_get_social_svg( 'whatsapp' ); // phpcs:ignore ?>
	</a>
	<a class="ft__soc" href="mailto:<?php echo esc_attr( rr_email() ); ?>" aria-label="Email">
		<?php echo rr_get_social_svg( 'email' ); // phpcs:ignore ?>
	</a>
	<a class="ft__soc" href="<?php echo esc_attr( rr_phone_href() ); ?>" aria-label="Call">
		<?php echo rr_get_social_svg( 'phone' ); // phpcs:ignore ?>
	</a>
	<a class="ft__soc" href="<?php echo esc_url( rr_anchor( 'contact' ) ); ?>" aria-label="<?php esc_attr_e( 'Enquiry form', 'realtor-raihan' ); ?>">
		<?php echo rr_get_social_svg( 'contact' ); // phpcs:ignore ?>
	</a>
	<?php
}

/**
 * Seed default testimonials and social icons on first load so user immediately sees them in WP admin.
 */
function rr_seed_default_cpts() {
	if ( get_option( 'rr_cpt_seeded_v1' ) ) {
		return;
	}

	// 1. Seed Testimonials
	$existing_testimonials = get_posts( array(
		'post_type'      => 'testimonial',
		'post_status'    => 'any',
		'posts_per_page' => 1,
	) );

	if ( empty( $existing_testimonials ) ) {
		$defaults = rr_h_rows( 'testimonials' );
		foreach ( $defaults as $i => $row ) {
			$post_id = wp_insert_post( array(
				'post_title'   => $row['name'],
				'post_content' => $row['quote'],
				'post_status'  => 'publish',
				'post_type'    => 'testimonial',
				'menu_order'   => $i + 1,
			) );

			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_rr_client_role', $row['role'] );
				update_post_meta( $post_id, '_rr_client_rating', 5 );
			}
		}
	}

	// 2. Seed Social Icons
	$existing_social = get_posts( array(
		'post_type'      => 'social_icon',
		'post_status'    => 'any',
		'posts_per_page' => 1,
	) );

	if ( empty( $existing_social ) ) {
		$social_defaults = array(
			array(
				'title'    => 'WhatsApp',
				'platform' => 'whatsapp',
				'url'      => rr_whatsapp(),
				'target'   => '_blank',
			),
			array(
				'title'    => 'Email',
				'platform' => 'email',
				'url'      => 'mailto:' . rr_email(),
				'target'   => '',
			),
			array(
				'title'    => 'Phone',
				'platform' => 'phone',
				'url'      => rr_phone_href(),
				'target'   => '',
			),
			array(
				'title'    => 'Enquiry Form',
				'platform' => 'contact',
				'url'      => rr_anchor( 'contact' ),
				'target'   => '',
			),
		);

		foreach ( $social_defaults as $i => $soc ) {
			$post_id = wp_insert_post( array(
				'post_title'  => $soc['title'],
				'post_status' => 'publish',
				'post_type'   => 'social_icon',
				'menu_order'  => $i + 1,
			) );

			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, '_rr_social_platform', $soc['platform'] );
				update_post_meta( $post_id, '_rr_social_url', $soc['url'] );
				update_post_meta( $post_id, '_rr_social_target', $soc['target'] );
			}
		}
	}

	update_option( 'rr_cpt_seeded_v1', 1 );
}
add_action( 'init', 'rr_seed_default_cpts', 20 );

/**
 * Sync FAQ rows so get_option('rr_home_faq') always reflects updated questions.
 */
function rr_sync_faq_rows_v2() {
	if ( ! get_option( 'rr_faq_updated_v2' ) ) {
		$d = rr_home_defaults();
		if ( ! empty( $d['faq'] ) ) {
			update_option( 'rr_home_faq', $d['faq'] );
		}
		update_option( 'rr_faq_updated_v2', 1 );
	}
}
add_action( 'init', 'rr_sync_faq_rows_v2', 25 );
