<?php
/**
 * Contact form handling: emails the enquiry to the site admin.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_nopriv_rr_enquiry', 'rr_handle_enquiry' );
add_action( 'admin_post_rr_enquiry', 'rr_handle_enquiry' );

/**
 * Validate and email one enquiry, then send the visitor back to the form.
 */
function rr_handle_enquiry() {
	$redirect = isset( $_POST['rr_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['rr_redirect'] ) ) : home_url( '/#contact' );
	// A bare fragment cannot be used as a redirect target, so anchor it to home.
	if ( '' === $redirect || '#' === $redirect[0] ) {
		$redirect = home_url( '/#contact' );
	}

	// Honeypot: a filled hidden field is a bot. Pretend it worked.
	if ( ! empty( $_POST['rr_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $redirect ) );
		exit;
	}

	$nonce = isset( $_POST['rr_enquiry_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['rr_enquiry_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'rr_enquiry' ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'error', $redirect ) );
		exit;
	}

	$name   = isset( $_POST['firstName'] ) ? sanitize_text_field( wp_unslash( $_POST['firstName'] ) ) : '';
	$email  = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone  = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$reason = isset( $_POST['reason'] ) ? sanitize_text_field( wp_unslash( $_POST['reason'] ) ) : '';
	$msg    = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $reason || ! $msg ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'error', $redirect ) );
		exit;
	}

	$to      = apply_filters( 'rr_enquiry_recipient', rr_email() );
	$subject = sprintf( 'Website enquiry from %s (%s)', $name, $reason );
	$body    = "New enquiry from the website\n\n"
		. "Name: {$name}\n"
		. "Email: {$email}\n"
		. "Phone: {$phone}\n"
		. "Reason: {$reason}\n\n"
		. "Message:\n{$msg}\n\n"
		. 'Sent: ' . current_time( 'mysql' ) . "\n"
		. 'Page: ' . home_url( '/' );

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = (bool) wp_mail( $to, $subject, $body, $headers );

	// Keep a copy in the database so nothing is lost if email is not configured yet.
	$log   = get_option( 'rr_enquiries', array() );
	$log[] = array(
		'time'    => current_time( 'mysql' ),
		'name'    => $name,
		'email'   => $email,
		'phone'   => $phone,
		'reason'  => $reason,
		'message' => $msg,
		'mailed'  => $sent ? 1 : 0,
	);
	update_option( 'rr_enquiries', array_slice( $log, -200 ) );

	/*
	 * The visitor is thanked either way: the enquiry is stored in the dashboard
	 * (Enquiries), so nothing is lost if the host has not configured email yet.
	 * The Emailed column on that screen shows whether the copy went out.
	 */
	$target = remove_query_arg( 'enquiry', preg_replace( '/#.*$/', '', $redirect ) );
	wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $target ) . '#contact' );
	exit;
}

/**
 * A small admin screen listing stored enquiries, so the client can always read
 * messages even if the host blocks outgoing mail.
 */
add_action(
	'admin_menu',
	function () {
		add_submenu_page(
			'rr-home',
			__( 'Enquiries', 'realtor-raihan' ),
			__( 'Enquiries', 'realtor-raihan' ),
			'edit_pages',
			'rr-enquiries',
			'rr_enquiries_screen'
		);
	}
);

/**
 * Enquiries table.
 */
function rr_enquiries_screen() {
	$log = array_reverse( (array) get_option( 'rr_enquiries', array() ) );
	echo '<div class="wrap"><h1>' . esc_html__( 'Website enquiries', 'realtor-raihan' ) . '</h1>';
	echo '<p>' . esc_html( sprintf( __( 'Every message is stored here and also emailed to %s.', 'realtor-raihan' ), rr_email() ) ) . '</p>';
	echo '<p class="description">' . esc_html__( 'If the Emailed column shows a dash, your hosting is not sending mail yet: the message is still saved here. Ask your host to enable PHP mail or install an SMTP plugin.', 'realtor-raihan' ) . '</p>';
	if ( ! $log ) {
		echo '<p><em>' . esc_html__( 'No enquiries yet.', 'realtor-raihan' ) . '</em></p></div>';
		return;
	}
	echo '<table class="widefat striped"><thead><tr>';
	foreach ( array( 'Date', 'Name', 'Email', 'Phone', 'Reason', 'Message', 'Emailed' ) as $h ) {
		echo '<th>' . esc_html( $h ) . '</th>';
	}
	echo '</tr></thead><tbody>';
	foreach ( $log as $row ) {
		echo '<tr>';
		echo '<td>' . esc_html( $row['time'] ) . '</td>';
		echo '<td>' . esc_html( $row['name'] ) . '</td>';
		echo '<td><a href="mailto:' . esc_attr( $row['email'] ) . '">' . esc_html( $row['email'] ) . '</a></td>';
		echo '<td>' . esc_html( $row['phone'] ) . '</td>';
		echo '<td>' . esc_html( $row['reason'] ) . '</td>';
		echo '<td>' . nl2br( esc_html( $row['message'] ) ) . '</td>';
		echo '<td>' . ( $row['mailed'] ? '&#10003;' : '&#8212;' ) . '</td>';
		echo '</tr>';
	}
	echo '</tbody></table></div>';
}


/**
 * Keep a dashboard copy of Contact Form 7 enquiries, as the old custom form did.
 */
add_action(
	'wpcf7_before_send_mail',
	function ( $contact_form, $abort, $submission ) {
		if ( ! $contact_form || 68 !== (int) $contact_form->id() || ! $submission ) {
			return;
		}
		$data = $submission->get_posted_data();
		$log = (array) get_option( 'rr_enquiries', array() );
		$log[] = array(
			'time'    => current_time( 'mysql' ),
			'name'    => sanitize_text_field( $data['first-name'] ?? '' ),
			'email'   => sanitize_email( $data['email-address'] ?? '' ),
			'phone'   => sanitize_text_field( $data['phone-number'] ?? '' ),
			'reason'  => sanitize_text_field( $data['inquiry-reason'] ?? '' ),
			'message' => sanitize_textarea_field( $data['inquiry-message'] ?? '' ),
			'mailed'  => 0,
		);
		update_option( 'rr_enquiries', array_slice( $log, -200 ) );
	},
	10,
	3
);

add_action(
	'wpcf7_mail_sent',
	function ( $contact_form ) {
		if ( ! $contact_form || 68 !== (int) $contact_form->id() ) {
			return;
		}
		$log = (array) get_option( 'rr_enquiries', array() );
		if ( $log ) {
			$last = count( $log ) - 1;
			$log[ $last ]['mailed'] = 1;
			update_option( 'rr_enquiries', $log );
		}
	}
);
