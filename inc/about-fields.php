<?php
/**
 * The About page editor. Content lives in one option array so the whole page is
 * editable from a single admin screen.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default About page content.
 *
 * @return array
 */
function rr_about_defaults() {
	return array(
		'eyebrow'    => 'About me',
		'title'      => 'Raihan <em>Shaikh</em>',
		'hero_img'   => 'gen-office-dusk.webp',
		'tag'        => 'About us',
		'h2'         => 'You are not buying a listing. You are buying a <em>decision.</em>',
		'photo'      => 'raihan-beach.webp',
		'p1'         => 'I am Raihan Shaikh, a senior property consultant in Dubai with Homes 4 Life Real Estate. Five years in this market has taught me one thing: the deal is easy, the decision is hard. So I work the decision first. What the service charge actually costs, what the rental cheques really look like, what resale looks like four years out.',
		'p2'         => 'Most of my clients start in Business Bay, Downtown or Dubai Marina and end up somewhere they did not expect: JVC, Arjan, a villa in Damac Hills. That is fine. My job is not to sell you a building. It is to make sure the one you pick still makes sense to you in 2030, not just on the day you sign.',
		'quote'      => 'If a deal is not right for you, I will say so. There is always another one.',
		'btn'        => 'More about us',
		'why_tag'    => 'Why choose us',
		'why_h2'     => "What you get that a portal<br>page cannot give you.",
		'why_photo'  => 'villa-pool-terrace.webp',
		'badge_b'    => '5+ years',
		'badge_s'    => 'in the Dubai market, from Business Bay to Damac Hills.',
		'features'   => array(
			array( 'icon' => 'shield', 'title' => 'Trusted property experts', 'text' => 'Five years, one market, real transactions. Every number I quote can be checked against the DLD register. I would rather you verify me than take my word for it.' ),
			array( 'icon' => 'building', 'title' => 'Access before the portal', 'text' => 'Off-plan launches, resale units and negotiated prices often move before an advert goes live. You hear about them from me first, with the payment plan attached.' ),
			array( 'icon' => 'process', 'title' => 'A process with no surprises', 'text' => 'Reservation, DLD fees, NOC, trustee transfer, snagging. You get the full checklist up front with the costs written next to each line, not after the deposit.' ),
			array( 'icon' => 'phone', 'title' => 'One number that answers', 'text' => 'No call centre, no rotating agents. You deal with me from the first WhatsApp to the handover, and after it, when the tenant or the resale question comes up.' ),
		),
		'close_tag'  => "Let's talk",
		'close_h2'   => "Tell me what you're after and I'll tell you <em>honestly.</em>",
		'close_p'    => 'One call, no pitch. Bring your budget and your timeline. I will bring the numbers.',
		'close_btn'  => 'Book a free consultation',
		'close_wa'   => 'WhatsApp me',
		'license_image' => home_url( '/wp-content/uploads/2026/11/WhatsApp-Image-2026-11-20-at-6.03.08-PM-1-scaled.png' ),
	);
}

/**
 * Read the About content, merged over the defaults.
 *
 * @return array
 */
function rr_about() {
	$saved = get_option( 'rr_about_page', array() );
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	$data = array_merge( rr_about_defaults(), $saved );
	// Use the supplied local media URL when no license image has been saved yet.
	if ( empty( $data['license_image'] ) ) {
		$data['license_image'] = home_url( '/wp-content/uploads/2026/11/WhatsApp-Image-2026-11-20-at-6.03.08-PM-1-scaled.png' );
	}

	if ( empty( $data['features'] ) || ! is_array( $data['features'] ) ) {
		$d                  = rr_about_defaults();
		$data['features']   = $d['features'];
	}
	return $data;
}


/** Load the WordPress Media Library only on the About page editor. */
add_action(
	'admin_enqueue_scripts',
	function () {
		if ( isset( $_GET['page'] ) && 'rr-about' === sanitize_key( wp_unslash( $_GET['page'] ) ) ) { // phpcs:ignore
			wp_enqueue_media();
		}
	}
);

add_action(
	'admin_menu',
	function () {
		add_submenu_page(
			'rr-home',
			__( 'About page', 'realtor-raihan' ),
			__( 'About page', 'realtor-raihan' ),
			'edit_pages',
			'rr-about',
			'rr_about_admin_screen'
		);
	}
);

add_action(
	'admin_post_rr_about_save',
	function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'realtor-raihan' ) );
		}
		check_admin_referer( 'rr_about_save' );

		$defaults = rr_about_defaults();
		$posted   = isset( $_POST['rr'] ) && is_array( $_POST['rr'] ) ? wp_unslash( $_POST['rr'] ) : array(); // phpcs:ignore
		$clean    = array();

		foreach ( $defaults as $key => $default ) {
			if ( 'features' === $key ) {
				continue;
			}
			if ( in_array( $key, array( 'photo', 'license_image' ), true ) ) {
				$photo_value   = isset( $posted[ $key ] ) ? trim( (string) $posted[ $key ] ) : '';
				$clean[ $key ] = ctype_digit( $photo_value ) ? absint( $photo_value ) : esc_url_raw( $photo_value );
			} else {
				$clean[ $key ] = isset( $posted[ $key ] ) ? wp_kses_post( trim( (string) $posted[ $key ] ) ) : '';
			}
		}

		$features = array();
		if ( isset( $_POST['rrf'] ) && is_array( $_POST['rrf'] ) ) { // phpcs:ignore
			foreach ( wp_unslash( $_POST['rrf'] ) as $row ) { // phpcs:ignore
				$row = array_map(
					static function ( $v ) {
						return wp_kses_post( trim( (string) $v ) );
					},
					(array) $row
				);
				if ( array_filter( $row ) ) {
					$features[] = $row;
				}
			}
		}
		$clean['features'] = $features;

		update_option( 'rr_about_page', $clean );
		wp_safe_redirect( add_query_arg( 'rr_saved', '1', admin_url( 'admin.php?page=rr-about' ) ) );
		exit;
	}
);

/**
 * The About admin screen.
 */
function rr_about_admin_screen() {
	$data  = rr_about();
	$saved = isset( $_GET['rr_saved'] ); // phpcs:ignore
	$long  = array( 'p1', 'p2', 'quote', 'badge_s', 'close_p' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'About page content', 'realtor-raihan' ); ?></h1>
		<?php if ( $saved ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'About page saved.', 'realtor-raihan' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="rr_about_save">
			<?php wp_nonce_field( 'rr_about_save' ); ?>

			<h2><?php esc_html_e( 'Page banner', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				foreach ( array( 'eyebrow' => 'Small label', 'title' => 'Page title (use <em> to set a word in gold)' ) as $k => $label ) {
					$label = ucfirst( $label );
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td><input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '"></td></tr>';
				}
				?>
			</tbody></table>

			<h2><?php esc_html_e( 'About section', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<tr>
					<th scope="row"><label for="rr-about-photo"><?php esc_html_e( 'About profile image', 'realtor-raihan' ); ?></label></th>
					<td>
						<?php $photo_preview = rr_img( $data['photo'], 'raihan-beach.webp' ); ?>
						<input type="hidden" id="rr-about-photo" name="rr[photo]" value="<?php echo esc_attr( $data['photo'] ); ?>">
						<img id="rr-about-photo-preview" src="<?php echo esc_url( $photo_preview ); ?>" alt="" style="display:block;width:220px;height:180px;object-fit:cover;border:1px solid #dcdcde;border-radius:6px;margin:0 0 10px;">
						<button type="button" class="button" id="rr-about-photo-select"><?php esc_html_e( 'Choose / Replace Image', 'realtor-raihan' ); ?></button>
						<button type="button" class="button" id="rr-about-photo-remove"><?php esc_html_e( 'Use Default Image', 'realtor-raihan' ); ?></button>
						<p class="description"><?php esc_html_e( 'Select the image from the WordPress Media Library. It will appear in the About page profile section.', 'realtor-raihan' ); ?></p>
					</td>
				</tr>
				<?php
				$fields = array(
					'tag'   => 'Small label',
					'h2'    => 'Heading',
					'p1'    => 'First paragraph',
					'p2'    => 'Second paragraph',
					'quote' => 'Pull quote',
					'btn'   => 'Button text',
				);
				foreach ( $fields as $k => $label ) {
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td>';
					if ( in_array( $k, $long, true ) ) {
						echo '<textarea class="large-text" rows="4" name="rr[' . esc_attr( $k ) . ']">' . esc_textarea( $data[ $k ] ) . '</textarea>';
					} else {
						echo '<input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '">';
					}
					echo '</td></tr>';
				}
				?>
			</tbody></table>

			<h2><?php esc_html_e( 'Dubai Real Estate License', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<tr>
					<th scope="row"><label for="rr-license-image"><?php esc_html_e( 'License image', 'realtor-raihan' ); ?></label></th>
					<td>
						<?php $license_preview = rr_img( $data['license_image'] ); ?>
						<input type="hidden" id="rr-license-image" name="rr[license_image]" value="<?php echo esc_attr( $data['license_image'] ); ?>">
						<img id="rr-license-image-preview" src="<?php echo esc_url( $license_preview ); ?>" alt="" style="display:block;width:260px;height:auto;max-height:220px;object-fit:contain;border:1px solid #dcdcde;border-radius:6px;background:#fff;padding:6px;margin:0 0 10px;">
						<button type="button" class="button" id="rr-license-image-select"><?php esc_html_e( 'Choose / Replace License Image', 'realtor-raihan' ); ?></button>
						<button type="button" class="button" id="rr-license-image-remove"><?php esc_html_e( 'Use Default Image', 'realtor-raihan' ); ?></button>
						<p class="description"><?php esc_html_e( 'This image appears directly below the Dubai Real Estate License heading on the public About page.', 'realtor-raihan' ); ?></p>
					</td>
				</tr>
			</tbody></table>

			<h2><?php esc_html_e( 'Why choose us section', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				foreach ( array( 'why_tag' => 'Small label', 'why_h2' => 'Heading (use &lt;br&gt; for a line break)', 'badge_b' => 'Badge headline', 'badge_s' => 'Badge sentence' ) as $k => $label ) {
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td>';
					if ( 'badge_s' === $k ) {
						echo '<textarea class="large-text" rows="3" name="rr[' . esc_attr( $k ) . ']">' . esc_textarea( $data[ $k ] ) . '</textarea>';
					} else {
						echo '<input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '">';
					}
					echo '</td></tr>';
				}
				?>
			</tbody></table>

			<h3><?php esc_html_e( 'Editable points', 'realtor-raihan' ); ?></h3>
			<p class="description"><?php esc_html_e( 'Leave a row empty to remove it. Icon options: shield, chart, phone, home, key, star.', 'realtor-raihan' ); ?></p>
			<?php
			$rows   = $data['features'];
			$rows[] = array( 'icon' => '', 'title' => '', 'text' => '' );
			foreach ( $rows as $i => $row ) :
				?>
				<fieldset style="border:1px solid #dcdcde;padding:12px 16px;margin:0 0 10px;border-radius:6px;background:#fff">
					<legend style="font-weight:600;padding:0 6px"><?php echo esc_html( sprintf( __( 'Point %d', 'realtor-raihan' ), $i + 1 ) ); ?></legend>
					<p style="margin:6px 0"><label style="display:block;font-weight:600"><?php esc_html_e( 'Icon', 'realtor-raihan' ); ?></label>
						<input type="text" class="regular-text" name="rrf[<?php echo (int) $i; ?>][icon]" value="<?php echo esc_attr( $row['icon'] ); ?>"></p>
					<p style="margin:6px 0"><label style="display:block;font-weight:600"><?php esc_html_e( 'Title', 'realtor-raihan' ); ?></label>
						<input type="text" class="regular-text" name="rrf[<?php echo (int) $i; ?>][title]" value="<?php echo esc_attr( $row['title'] ); ?>"></p>
					<p style="margin:6px 0"><label style="display:block;font-weight:600"><?php esc_html_e( 'Text', 'realtor-raihan' ); ?></label>
						<textarea class="large-text" rows="3" name="rrf[<?php echo (int) $i; ?>][text]"><?php echo esc_textarea( $row['text'] ); ?></textarea></p>
				</fieldset>
			<?php endforeach; ?>

			<h2><?php esc_html_e( 'Closing call to action', 'realtor-raihan' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				foreach ( array( 'close_tag' => 'Small label', 'close_h2' => 'Heading', 'close_p' => 'Sentence', 'close_btn' => 'Gold button text', 'close_wa' => 'WhatsApp button text' ) as $k => $label ) {
					echo '<tr><th scope="row"><label>' . esc_html( $label ) . '</label></th><td>';
					if ( 'close_p' === $k ) {
						echo '<textarea class="large-text" rows="3" name="rr[' . esc_attr( $k ) . ']">' . esc_textarea( $data[ $k ] ) . '</textarea>';
					} else {
						echo '<input type="text" class="large-text" name="rr[' . esc_attr( $k ) . ']" value="' . esc_attr( $data[ $k ] ) . '">';
					}
					echo '</td></tr>';
				}
				?>
			</tbody></table>

			<?php submit_button( __( 'Save About page', 'realtor-raihan' ) ); ?>
		</form>

		<script>
		jQuery(function ($) {
			var frame;
			$('#rr-about-photo-select').on('click', function (event) {
				event.preventDefault();
				if (frame) { frame.open(); return; }
				frame = wp.media({
					title: '<?php echo esc_js( __( 'Choose About profile image', 'realtor-raihan' ) ); ?>',
					button: { text: '<?php echo esc_js( __( 'Use this image', 'realtor-raihan' ) ); ?>' },
					library: { type: 'image' },
					multiple: false
				});
				frame.on('select', function () {
					var attachment = frame.state().get('selection').first().toJSON();
					$('#rr-about-photo').val(attachment.id);
					$('#rr-about-photo-preview').attr('src', attachment.url);
				});
				frame.open();
			});
			var licenseFrame;
			$('#rr-license-image-select').on('click', function (event) {
				event.preventDefault();
				if (licenseFrame) { licenseFrame.open(); return; }
				licenseFrame = wp.media({
					title: '<?php echo esc_js( __( 'Choose Dubai real estate license image', 'realtor-raihan' ) ); ?>',
					button: { text: '<?php echo esc_js( __( 'Use this license image', 'realtor-raihan' ) ); ?>' },
					library: { type: 'image' },
					multiple: false
				});
				licenseFrame.on('select', function () {
					var attachment = licenseFrame.state().get('selection').first().toJSON();
					$('#rr-license-image').val(attachment.id);
					$('#rr-license-image-preview').attr('src', attachment.url);
				});
				licenseFrame.open();
			});
			$('#rr-license-image-remove').on('click', function () {
				$('#rr-license-image').val('');
				$('#rr-license-image-preview').attr('src', '<?php echo esc_js( home_url( '/wp-content/uploads/2026/11/WhatsApp-Image-2026-11-20-at-6.03.08-PM-1-scaled.png' ) ); ?>');
			});
			$('#rr-about-photo-remove').on('click', function () {
				$('#rr-about-photo').val('');
				$('#rr-about-photo-preview').attr('src', '<?php echo esc_js( RR_URI . '/assets/img/raihan-beach.webp' ); ?>');
			});
		});
		</script>
	</div>
	<?php
}
