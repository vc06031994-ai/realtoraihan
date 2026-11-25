<?php
/**
 * The Contact page editor. Content lives in one option array so the whole page is
 * editable from a single admin screen as well as the WordPress page editor.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default Contact page content.
 *
 * @return array
 */
function rr_contact_defaults() {
	return array(
		'banner_title' => 'Contact',
		'banner_image' => 'gen-office-dusk.webp',
		'eyebrow'   => 'Get In Touch',
		'title'     => "Let's Talk About\nYour Property <em>Goals.</em>",
		'lede'      => "Tell me what you're planning and I'll come back with honest options, no pressure, no jargon. If you'd rather talk it through, call or message me directly.",
		'phone'     => '+971 52 102 7252',
		'call_lbl'  => 'Call me',
		'whatsapp'  => '971521027252',
		'wa_lbl'    => 'WhatsApp',
		'wa_sub'    => 'Message me',
		'email'     => 'hello@realtorraihan.com',
		'email_lbl' => 'Email',
		'area'      => 'Business Bay, Dubai, UAE',
		'area_lbl'  => 'Based in',
		'form_h'    => 'Send an enquiry',
		'form_p'    => "Fill this in and I'll reply personally, usually the same day.",
		'btn_text'  => 'Send Enquiry',
		'fine_text' => 'Your details stay between us, I never share them without permission.',
		'done_h'    => 'Thank you, your enquiry is on its way',
		'done_p'    => 'I will reply personally, usually the same day. If you would rather talk now, call or message me on WhatsApp.',
	);
}

/**
 * Read the Contact content, merged over defaults and home options.
 *
 * @return array
 */
function rr_contact() {
	$saved = get_option( 'rr_contact_page', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	$fallbacks = array();
	$home_eyebrow = get_option( 'rr_home_ct_eyebrow', '' );
	$home_title   = get_option( 'rr_home_ct_title', '' );
	$home_lede    = get_option( 'rr_home_ct_lede', '' );
	$home_form_h  = get_option( 'rr_home_ct_form_h', '' );
	$home_form_p  = get_option( 'rr_home_ct_form_p', '' );

	if ( $home_eyebrow ) { $fallbacks['eyebrow'] = $home_eyebrow; }
	if ( $home_title )   { $fallbacks['title']   = $home_title; }
	if ( $home_lede )    { $fallbacks['lede']    = $home_lede; }
	if ( $home_form_h )  { $fallbacks['form_h']  = $home_form_h; }
	if ( $home_form_p )  { $fallbacks['form_p']  = $home_form_p; }

	$fallbacks['phone']    = rr_phone();
	$fallbacks['whatsapp'] = get_theme_mod( 'rr_whatsapp', '971521027252' );
	$fallbacks['email']    = rr_email();
	$fallbacks['area']     = rr_area();

	return array_merge( rr_contact_defaults(), $fallbacks, $saved );
}

add_action(
	'admin_menu',
	function () {
		add_submenu_page(
			'rr-home',
			__( 'Contact page', 'realtor-raihan' ),
			__( 'Contact page', 'realtor-raihan' ),
			'edit_pages',
			'rr-contact',
			'rr_contact_admin_screen'
		);
	}
);

add_action(
	'admin_post_rr_contact_save',
	function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'realtor-raihan' ) );
		}
		check_admin_referer( 'rr_contact_save' );

		$defaults = rr_contact_defaults();
		$posted   = isset( $_POST['rr'] ) && is_array( $_POST['rr'] ) ? wp_unslash( $_POST['rr'] ) : array(); // phpcs:ignore
		$clean    = array();

		foreach ( $defaults as $key => $default ) {
			$clean[ $key ] = isset( $posted[ $key ] ) ? wp_kses_post( trim( (string) $posted[ $key ] ) ) : '';
		}

		update_option( 'rr_contact_page', $clean );

		// Sync back to home options and theme mods so everything stays in lockstep
		if ( ! empty( $clean['eyebrow'] ) ) { update_option( 'rr_home_ct_eyebrow', $clean['eyebrow'] ); }
		if ( ! empty( $clean['title'] ) )   { update_option( 'rr_home_ct_title', $clean['title'] ); }
		if ( ! empty( $clean['lede'] ) )    { update_option( 'rr_home_ct_lede', $clean['lede'] ); }
		if ( ! empty( $clean['form_h'] ) )  { update_option( 'rr_home_ct_form_h', $clean['form_h'] ); }
		if ( ! empty( $clean['form_p'] ) )  { update_option( 'rr_home_ct_form_p', $clean['form_p'] ); }
		if ( ! empty( $clean['phone'] ) )   { set_theme_mod( 'rr_phone', $clean['phone'] ); }
		if ( ! empty( $clean['whatsapp'] ) ){ set_theme_mod( 'rr_whatsapp', $clean['whatsapp'] ); }
		if ( ! empty( $clean['email'] ) )   { set_theme_mod( 'rr_email', $clean['email'] ); }
		if ( ! empty( $clean['area'] ) )    { set_theme_mod( 'rr_area', $clean['area'] ); }

		wp_safe_redirect( add_query_arg( 'rr_saved', '1', admin_url( 'admin.php?page=rr-contact' ) ) );
		exit;
	}
);

/**
 * The Contact admin screen.
 */
function rr_contact_admin_screen() {
	$data  = rr_contact();
	$saved = isset( $_GET['rr_saved'] ); // phpcs:ignore
	$long  = array( 'title', 'lede', 'form_p', 'fine_text', 'done_p' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Contact page content', 'realtor-raihan' ); ?></h1>
		<?php if ( $saved ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Contact page saved.', 'realtor-raihan' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="rr_contact_save">
			<?php wp_nonce_field( 'rr_contact_save' ); ?>

			<h2><?php esc_html_e( 'Page banner (below header)', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<tr><th scope="row"><label><?php esc_html_e( 'Banner heading', 'realtor-raihan' ); ?></label></th><td><input type="text" class="large-text" name="rr[banner_title]" value="<?php echo esc_attr( $data['banner_title'] ); ?>"></td></tr>
				<tr><th scope="row"><label><?php esc_html_e( 'Banner background image filename', 'realtor-raihan' ); ?></label></th><td><input type="text" class="large-text" name="rr[banner_image]" value="<?php echo esc_attr( $data['banner_image'] ); ?>"><p class="description">Use an existing theme image filename.</p></td></tr>
			</tbody></table>
			<h2><?php esc_html_e( 'Heading and introduction', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$fields_intro = array(
					'eyebrow' => 'Small label (above heading)',
					'title'   => 'Heading (use <em>...</em> for gold word)',
					'lede'    => 'Introductory paragraph',
				);
				foreach ( $fields_intro as $k => $label ) {
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

			<h2><?php esc_html_e( 'Direct channels & office details', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$fields_channels = array(
					'phone'     => 'Phone number',
					'call_lbl'  => 'Phone label (e.g. Call me)',
					'whatsapp'  => 'WhatsApp number (digits with country code, e.g. 971521027252)',
					'wa_lbl'    => 'WhatsApp label (e.g. WhatsApp)',
					'wa_sub'    => 'WhatsApp subtext (e.g. Message me)',
					'email'     => 'Email address',
					'email_lbl' => 'Email label (e.g. Email)',
					'area'      => 'Office location / Based in',
					'area_lbl'  => 'Office label (e.g. Based in)',
				);
				foreach ( $fields_channels as $k => $label ) {
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td>';
					echo '<input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '">';
					echo '</td></tr>';
				}
				?>
			</tbody></table>

			<h2><?php esc_html_e( 'Enquiry form', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$fields_form = array(
					'form_h'    => 'Form heading',
					'form_p'    => 'Form subtitle / instruction',
					'btn_text'  => 'Submit button text',
					'fine_text' => 'Privacy statement / Fine print below button',
					'done_h'    => 'Success heading (after form submit)',
					'done_p'    => 'Success message (after form submit)',
				);
				foreach ( $fields_form as $k => $label ) {
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

			<?php submit_button( __( 'Save Contact Page', 'realtor-raihan' ) ); ?>
		</form>
	</div>
	<?php
}
