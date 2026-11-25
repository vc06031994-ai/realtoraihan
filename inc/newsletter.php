<?php
/**
 * Newsletter signup handling: stores subscribers, tells the client by email.
 * No third party service required.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_post_nopriv_rr_newsletter', 'rr_handle_newsletter' );
add_action( 'admin_post_rr_newsletter', 'rr_handle_newsletter' );

/**
 * Store one subscriber.
 */
function rr_handle_newsletter() {
	$back = wp_get_referer() ? wp_get_referer() : rr_blog_url();

	$nonce = isset( $_POST['rr_newsletter_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['rr_newsletter_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'rr_newsletter' ) ) {
		wp_safe_redirect( $back );
		exit;
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		wp_safe_redirect( $back );
		exit;
	}

	$list = (array) get_option( 'rr_subscribers', array() );
	if ( ! in_array( $email, $list, true ) ) {
		$list[] = $email;
		update_option( 'rr_subscribers', $list );
		wp_mail(
			rr_email(),
			'New newsletter subscriber',
			"A new subscriber joined from the blog page:\n\n{$email}\n\n" . current_time( 'mysql' ),
			array( 'Content-Type: text/plain; charset=UTF-8' )
		);
	}

	wp_safe_redirect( add_query_arg( 'newsletter', 'sent', $back ) . '#blForm' );
	exit;
}
