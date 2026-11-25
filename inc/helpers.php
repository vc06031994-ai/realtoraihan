<?php
/**
 * Small helpers used by the templates.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme mod with a default, and "empty string means use the default" behaviour
 * so a client can clear a field in the Customizer and still get a working site.
 *
 * @param string $key     Setting key.
 * @param string $default Default value.
 * @return string
 */
function rr_mod( $key, $default = '' ) {
	$val = get_theme_mod( $key, $default );
	if ( '' === $val || null === $val ) {
		return $default;
	}
	return $val;
}

/** Phone number in international format, digits only for wa.me links. */
function rr_phone() {
	return rr_mod( 'rr_phone', '+971 52 102 7252' );
}
function rr_phone_href() {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', rr_phone() );
}
function rr_whatsapp() {
	$num = preg_replace( '/[^0-9]/', '', rr_mod( 'rr_whatsapp', '971521027252' ) );
	return 'https://wa.me/' . $num;
}
function rr_email() {
	return rr_mod( 'rr_email', 'hello@realtorraihan.com' );
}
function rr_area() {
	return rr_mod( 'rr_area', 'Dubai, UAE' );
}
function rr_site_name() {
	return rr_mod( 'rr_brand_name', 'Realtor Raihan' );
}
function rr_brand_sub() {
	return rr_mod( 'rr_brand_sub', 'Dubai, UAE' );
}
function rr_logo_mark() {
	return rr_mod( 'rr_logo_mark', RR_URI . '/assets/img/logo-emblem.png' );
}
function rr_logo_lockup() {
	return rr_mod( 'rr_logo_lockup', RR_URI . '/assets/img/logo-lockup.png' );
}

/**
 * A link to a page, falling back to the home page section anchor.
 *
 * @param string $slug Page slug.
 * @param string $hash Section id on the home page.
 * @return string
 */
function rr_link( $slug = '', $hash = '' ) {
	if ( $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			return get_permalink( $page );
		}
	}
	$home = home_url( '/' );
	return $hash ? $home . '#' . ltrim( $hash, '#' ) : $home;
}

/**
 * One place that knows where the contact page lives.
 *
 * @return string
 */
function rr_contact_url() {
	$page = get_page_by_path( 'contact' );
	if ( $page ) {
		return get_permalink( $page );
	}
	return home_url( '/contact/' );
}

/**
 * Home page anchor or dedicated page link.
 *
 * @param string $id Section id.
 * @return string
 */
function rr_anchor( $id ) {
	$id = ltrim( $id, '#' );
	if ( 'contact' === $id ) {
		return rr_contact_url();
	}
	if ( is_front_page() ) {
		return '#' . $id;
	}
	return home_url( '/' ) . '#' . $id;
}

/**
 * Image helper: accept an attachment id, a URL, or nothing and fall back.
 *
 * @param mixed  $value   Attachment ID or URL.
 * @param string $fallback Fallback file name in assets/img.
 * @param string $size    Image size.
 * @return string URL
 */
function rr_img( $value, $fallback = '', $size = 'full' ) {
	if ( is_numeric( $value ) && (int) $value > 0 ) {
		$url = wp_get_attachment_image_url( (int) $value, $size );
		if ( $url ) {
			return $url;
		}
	}
	if ( is_string( $value ) && '' !== trim( $value ) ) {
		$value = trim( $value );
		// A bare file name means "ship this image with the theme".
		if ( false === strpos( $value, '/' ) && preg_match( '/\.(webp|jpe?g|png|svg|gif)$/i', $value ) ) {
			return RR_URI . '/assets/img/' . $value;
		}
		return $value;
	}
	if ( $fallback ) {
		return RR_URI . '/assets/img/' . $fallback;
	}
	return '';
}

/**
 * Attachment alt text when we have an ID, otherwise empty (decorative).
 *
 * @param mixed $id Attachment id.
 * @return string
 */
function rr_alt( $id ) {
	if ( is_numeric( $id ) && (int) $id > 0 ) {
		$alt = get_post_meta( (int) $id, '_wp_attachment_image_alt', true );
		return $alt ? $alt : '';
	}
	return '';
}

/**
 * Print an image tag for a repeater row value.
 *
 * @param mixed  $value    ID or URL.
 * @param string $fallback Fallback file.
 * @param string $class    CSS class.
 * @param string $loading  loading attribute.
 * @param array  $attrs    Extra attributes.
 */
function rr_img_tag( $value, $fallback, $class = '', $loading = 'lazy', $attrs = array() ) {
	$src = rr_img( $value, $fallback );
	if ( ! $src ) {
		return;
	}
	$out = '<img src="' . esc_url( $src ) . '"';
	if ( $class ) {
		$out .= ' class="' . esc_attr( $class ) . '"';
	}
	foreach ( $attrs as $k => $v ) {
		$out .= ' ' . esc_attr( $k ) . '="' . esc_attr( $v ) . '"';
	}
	$out .= ' alt="' . esc_attr( rr_alt( $value ) ) . '" loading="' . esc_attr( $loading ) . '" decoding="async">';
	echo $out; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Split a textarea into one item per line.
 *
 * @param string $text Raw textarea.
 * @return array
 */
function rr_lines( $text ) {
	$text  = str_replace( '\n', "\n", (string) $text );
	$lines = preg_split( '/\r\n|\r|\n/', $text );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

/** Escape helper for headings that carry <em> and <br>. */
function rr_rich( $html ) {
	return wp_kses( $html, array( 'em' => array(), 'br' => array(), 'strong' => array(), 'span' => array( 'class' => array() ) ) );
}

/**
 * The arrow icon used on pills and cards.
 *
 * @param bool $aria Hidden from assistive tech.
 * @return string
 */
function rr_arrow( $aria = true ) {
	return '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . ( $aria ? ' aria-hidden="true"' : '' ) . '><path d="M7 17 17 7M9 7h8v8"/></svg>';
}

/** Chequered section number, two digits. */
function rr_num( $i ) {
	return str_pad( (string) $i, 2, '0', STR_PAD_LEFT );
}

/**
 * Print a heading as masked lines. Each newline in the field becomes one line
 * with its own reveal animation, exactly like the approved design. <em> is kept
 * so a word can be set in gold.
 *
 * @param string $text   Field value, one line per newline.
 * @param string $prefix Optional id for the heading.
 * @param string $tag    Heading tag.
 */
function rr_head_lines( $text, $prefix = '', $tag = 'h2', $class = '' ) {
	$lines = rr_lines( $text );
	if ( ! $lines ) {
		return;
	}
	printf(
		'<%1$s%2$s%3$s>',
		esc_attr( $tag ),
		$prefix ? ' id="' . esc_attr( $prefix ) . '"' : '',
		$class ? ' class="' . esc_attr( $class ) . '"' : ''
	); // phpcs:ignore
	foreach ( $lines as $line ) {
		echo '<span class="ln"><span>' . rr_rich( $line ) . '</span></span>';
	}
	printf( '</%s>', esc_attr( $tag ) ); // phpcs:ignore
}

/**
 * Heading text as a single line of plain text, for aria labels and titles.
 *
 * @param string $text Field value.
 * @return string
 */
function rr_head_plain( $text ) {
	return trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( str_replace( "\n", ' ', (string) $text ) ) ) );
}

/**
 * "6 min read" computed from the post content, so it stays honest as the client
 * edits an article.
 *
 * @param int $post_id Post id.
 * @return string
 */
function rr_reading_time( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$words   = str_word_count( wp_strip_all_tags( (string) get_post_field( 'post_content', $post_id ) ) );
	$minutes = max( 1, (int) ceil( $words / 200 ) );
	/* translators: %d minutes */
	return sprintf( __( '%d min read', 'realtor-raihan' ), $minutes );
}

/**
 * Print every home section that is switched on, in the order set in the admin.
 */
function rr_render_home_sections() {
	$defaults = rr_home_defaults();
	$keys     = array_keys( $defaults['sections'] );
	$sections = array();

	foreach ( $keys as $index => $key ) {
		if ( ! rr_h_section( $key ) ) {
			continue;
		}
		$order            = (int) get_option( 'rr_home_order_' . $key, 0 );
		$sections[ $key ] = $order > 0 ? $order : 100 + $index;
	}
	asort( $sections );

	foreach ( $sections as $key => $order ) {
		$slug = 'parts/' . str_replace( '_', '-', $key );
		if ( file_exists( RR_DIR . '/' . $slug . '.php' ) ) {
			get_template_part( $slug );
			if ( 'services' === $key ) {
				get_template_part( 'parts/developers-strip' );
			}
		}
	}
}
