<?php
/**
 * Editing Home and About from inside the page itself.
 *
 * Those two pages are built from theme sections, so the normal WordPress editor
 * has nothing to show and nothing it can change. Rather than explain that away,
 * this file puts the real content into the page editor:
 *
 *   - opening Home or About in the editor now lists every field of that page,
 *     grouped by section, with the live value already in the box,
 *   - saving the page saves those fields (the page form is reused, so the usual
 *     Update button just works, including Quick Edit and the bulk editor),
 *   - the page body stays in sync, so someone who opens the block editor sees
 *     the whole content as readable text instead of an empty canvas,
 *   - repeatable rows (service cards, testimonials, FAQ, the About points) are
 *     edited as blocks of text in a meta box.
 *
 * The "Home Page" screen in the left menu still exists and stays the fastest
 * way to work. Both routes write the same options, so they never disagree.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Which managed page is this? Returns the slug or ''.
 *
 * @param int $post_id Post id.
 * @return string
 */
function rr_managed_slug( $post_id ) {
	$slug = get_post_field( 'post_name', $post_id );
	if ( in_array( $slug, array( 'home', 'about', 'contact', 'blog' ), true ) ) {
		return $slug;
	}
	$page_for_posts = (int) get_option( 'page_for_posts' );
	if ( $page_for_posts && (int) $post_id === $page_for_posts ) {
		return 'blog';
	}
	return '';
}

/**
 * The settings screens that own this page, by slug.
 *
 * @return array
 */
function rr_page_owner() {
	return array(
		'home'    => array(
			'action' => 'rr_home_save',
			'label'  => __( 'Home Page', 'realtor-raihan' ),
			'url'    => 'admin.php?page=rr-home',
		),
		'about'   => array(
			'action' => 'rr_about_save',
			'label'  => __( 'About page', 'realtor-raihan' ),
			'url'    => 'admin.php?page=rr-about',
		),
		'contact' => array(
			'action' => 'rr_contact_save',
			'label'  => __( 'Contact page', 'realtor-raihan' ),
			'url'    => 'admin.php?page=rr-contact',
		),
		'blog'    => array(
			'action' => 'rr_blog_save',
			'label'  => __( 'Blog page', 'realtor-raihan' ),
			'url'    => 'admin.php?page=rr-blog',
		),
	);
}

/**
 * Human label for a field key: hero_title_l1 -> Hero: title line 1.
 *
 * @param string $key Field key.
 * @return string
 */
function rr_field_label( $key ) {
	static $map = array(
		'hero_tag'      => 'Small line above the headline',
		'hero_title_l1' => 'Headline: line 1',
		'hero_title_l2' => 'Headline: line 2',
		'hero_title_l3' => 'Headline: line 3 (gold)',
		'hero_say'      => 'Strapline',
		'hero_lede'     => 'Intro paragraph',
		'hero_cta1'     => 'First button text',
		'hero_cta2'     => 'Second button text',
		'intro_tag'     => 'Introduction: small label',
		'intro_title'   => 'Introduction: heading',
		'intro_aside'   => 'Introduction: short paragraph beside the heading',
		'intro_p1'      => 'Introduction: paragraph 1',
		'intro_p2'      => 'Introduction: paragraph 2',
		'intro_quote'   => 'Introduction: highlighted quote',
		'intro_cta'     => 'Introduction: button text',
		'intro_img'     => 'Introduction: photo',
		'intro_badge_n' => 'Photo badge: big number',
		'intro_badge_t' => 'Photo badge: small text',
		'intro_cap_b'   => 'Photo caption: name',
		'intro_cap_s'   => 'Photo caption: role',
		'wi_tag'        => 'Why invest: small label',
		'wi_title'      => 'Why invest: heading',
		'wi_aside'      => 'Why invest: short paragraph beside the heading',
		'wi_num'        => 'Why invest: big number',
		'wi_num_tx'     => 'Why invest: text beside the big number',
		'sv_tag'        => 'Services: small label',
		'sv_title'      => 'Services: heading',
		'sv_aside'      => 'Services: short paragraph beside the heading',
		'ts_title'      => 'Testimonials: heading',
		'ts_lede'       => 'Testimonials: paragraph under the heading',
		'ts_note'       => 'Testimonials: small note',
		'wc_meta'       => 'Why choose me: small label',
		'wc_title'      => 'Why choose me: heading',
		'wc_cta'        => 'Why choose me: button text',
		'fq_eyebrow'    => 'FAQ: small label',
		'fq_title'      => 'FAQ: heading',
		'fq_lede'       => 'FAQ: paragraph under the heading',
		'fq_cta'        => 'FAQ: button text',
		'ct_eyebrow'    => 'Contact: small label',
		'ct_title'      => 'Contact: heading',
		'ct_lede'       => 'Contact: paragraph under the heading',
		'ct_form_h'     => 'Contact: form heading',
		'ct_form_p'     => 'Contact: form sub text',
		'eyebrow'       => 'Banner: small label',
		'title'         => 'Banner: page title',
		'tag'           => 'About section: small label',
		'h2'            => 'About section: heading',
		'p1'            => 'About section: first paragraph',
		'p2'            => 'About section: second paragraph',
		'quote'         => 'About section: pull quote',
		'btn'           => 'About section: button text',
		'why_tag'       => 'Why choose us: small label',
		'why_h2'        => 'Why choose us: heading',
		'badge_b'       => 'Badge: headline',
		'badge_s'       => 'Badge: sentence',
		'close_tag'     => 'Closing: small label',
		'close_h2'      => 'Closing: heading',
		'close_p'       => 'Closing: sentence',
		'close_btn'     => 'Closing: gold button text',
		'close_wa'      => 'Closing: WhatsApp button text',
		'phone'         => 'Phone number',
		'call_lbl'      => 'Phone button label (e.g. Call me)',
		'whatsapp'      => 'WhatsApp number (with country code, digits only)',
		'wa_lbl'        => 'WhatsApp button label (e.g. WhatsApp)',
		'wa_sub'        => 'WhatsApp button subtext (e.g. Message me)',
		'email'         => 'Email address',
		'email_lbl'     => 'Email button label (e.g. Email)',
		'area'          => 'Office location / Based in',
		'area_lbl'      => 'Office location label (e.g. Based in)',
		'form_h'        => 'Contact form heading',
		'form_p'        => 'Contact form subtitle',
		'btn_text'      => 'Submit button text',
		'fine_text'     => 'Privacy fine print under button',
		'done_h'        => 'Confirmation heading (after submit)',
		'done_p'        => 'Confirmation message (after submit)',
		'hero_img'      => 'Hero background photo',
		'list_tag'      => 'Articles section: small label',
		'list_title'    => 'Articles section: heading',
		'filter_all'    => 'Filter "All" button label',
		'read_more'     => 'Article card: button text',
		'empty_msg'     => 'No articles message',
		'news_title'    => 'Newsletter: heading',
		'news_text'     => 'Newsletter: description',
		'news_placeholder' => 'Newsletter: email placeholder',
		'news_btn'      => 'Newsletter: button text',
		'news_note'     => 'Newsletter: disclaimer note',
	);
	if ( isset( $map[ $key ] ) ) {
		return $map[ $key ];
	}
	// stat1_n, intro_img ... fall back to something readable.
	if ( preg_match( '/^stat(\d)_(n|t|s)$/', $key, $m ) ) {
		$part = array( 'n' => 'number', 't' => 'title', 's' => 'small text' );
		return sprintf( 'Stat %s: %s', $m[1], $part[ $m[2] ] );
	}
	return ucfirst( str_replace( '_', ' ', $key ) );
}

/**
 * Which control a home field wants, and any help text. Mirrors the labels used
 * on the "Home Page" screen so both editors look and behave the same.
 *
 * @return array key => array( type, help )
 */
function rr_home_field_types() {
	$lines = array( 'intro_title', 'wi_title', 'sv_title', 'ts_title', 'wc_title', 'fq_title', 'ct_title' );
	$area  = array( 'hero_say', 'hero_lede', 'intro_aside', 'intro_p1', 'intro_p2', 'wi_aside', 'sv_aside', 'ts_lede', 'ts_note', 'fq_lede', 'ct_lede' );
	$types = array();
	foreach ( rr_home_defaults() as $key => $default ) {
		if ( ! is_scalar( $default ) ) {
			continue;
		}
		$type = 'text';
		if ( in_array( $key, $lines, true ) ) {
			$type = 'lines';
		} elseif ( in_array( $key, $area, true ) ) {
			$type = 'area';
		}
		$types[ $key ] = array( $type, '' );
	}
	return $types;
}

/**
 * Keys that should be edited in a textarea rather than a one line input.
 *
 * @param string $key  Field key.
 * @param string $type Control type from the settings screen (text|area|lines).
 * @return bool
 */
function rr_field_is_long( $key, $type ) {
	if ( in_array( $type, array( 'area', 'lines' ), true ) ) {
		return true;
	}
	return (bool) preg_match( '/(_title|_h2|_lede|_aside|_say|_quote|_p\d?|_tx|p1|p2|quote|badge_s|close_p|badge_t)$/', $key );
}

/**
 * All simple fields of a managed page: key => array( value, type, help ).
 *
 * @param string $slug home|about.
 * @return array
 */
function rr_page_fields( $slug ) {
	$fields = array();
	if ( 'home' === $slug ) {
		$defaults = rr_home_defaults();
		$types    = function_exists( 'rr_home_field_types' ) ? rr_home_field_types() : array();
		foreach ( $defaults as $key => $default ) {
			if ( ! is_scalar( $default ) ) {
				continue; // sections, repeaters: handled elsewhere.
			}
			if ( preg_match( '/^hero_s\d$/', $key ) ) {
				continue; // reserved, not shown anywhere.
			}
			$value = get_option( 'rr_home_' . $key, '' );
			if ( '' === $value ) {
				$value = (string) $default;
			}
			$fields[ $key ] = array(
				'value' => $value,
				'type'  => isset( $types[ $key ][0] ) ? $types[ $key ][0] : 'text',
				'help'  => isset( $types[ $key ][1] ) ? $types[ $key ][1] : '',
			);
		}
		return $fields;
	}

	if ( 'contact' === $slug ) {
		$data     = rr_contact();
		$defaults = rr_contact_defaults();
		foreach ( $defaults as $key => $default ) {
			$fields[ $key ] = array(
				'value' => isset( $data[ $key ] ) ? (string) $data[ $key ] : (string) $default,
				'type'  => in_array( $key, array( 'title', 'lede', 'form_p', 'fine_text', 'done_p' ), true ) ? 'area' : 'text',
				'help'  => '',
			);
		}
		return $fields;
	}

	if ( 'blog' === $slug ) {
		$data     = rr_blog();
		$defaults = rr_blog_defaults();
		foreach ( $defaults as $key => $default ) {
			$fields[ $key ] = array(
				'value' => isset( $data[ $key ] ) ? (string) $data[ $key ] : (string) $default,
				'type'  => in_array( $key, array( 'title', 'lede', 'list_title', 'news_title', 'news_text' ), true ) ? 'area' : 'text',
				'help'  => '',
			);
		}
		return $fields;
	}

	$data     = rr_about();
	$defaults = rr_about_defaults();
	foreach ( $defaults as $key => $default ) {
		if ( ! is_scalar( $default ) ) {
			continue; // features repeater.
		}
		$fields[ $key ] = array(
			'value' => isset( $data[ $key ] ) ? (string) $data[ $key ] : (string) $default,
			'type'  => in_array( $key, array( 'p1', 'p2', 'quote', 'badge_s', 'close_p', 'h2', 'why_h2', 'close_h2', 'title' ), true ) ? 'area' : 'text',
			'help'  => '',
		);
	}
	return $fields;
}

/**
 * Section headings, so the fields arrive in the same order as the page.
 *
 * @param string $slug home|about.
 * @return array prefix => heading
 */
function rr_page_groups( $slug ) {
	if ( 'contact' === $slug ) {
		return array(
			'eyebrow|title|lede' => __( 'Heading & Introduction', 'realtor-raihan' ),
			'phone|call_lbl|whatsapp|wa_lbl|wa_sub|email|email_lbl|area|area_lbl' => __( 'Direct Channels & Office Details', 'realtor-raihan' ),
			'form_h|form_p|btn_text|fine_text|done_h|done_p' => __( 'Enquiry Form & Confirmation', 'realtor-raihan' ),
		);
	}
	if ( 'blog' === $slug ) {
		return array(
			'eyebrow|title|lede|hero_img' => __( 'Hero Banner', 'realtor-raihan' ),
			'list_tag|list_title|filter_all|read_more|empty_msg' => __( 'Articles List & Filter', 'realtor-raihan' ),
			'news_title|news_text|news_placeholder|news_btn|news_note' => __( 'Newsletter Band', 'realtor-raihan' ),
		);
	}
	if ( 'about' === $slug ) {
		return array(
			''       => __( 'Page banner', 'realtor-raihan' ),
			'tag|h2|p1|p2|quote|btn|photo' => __( 'About section', 'realtor-raihan' ),
			'why_'   => __( 'Why choose us', 'realtor-raihan' ),
			'badge_' => __( 'Badge on the photo', 'realtor-raihan' ),
			'close_' => __( 'Closing call to action', 'realtor-raihan' ),
		);
	}
	return array(
		'hero_'  => __( 'Hero (top of the page)', 'realtor-raihan' ),
		'intro_' => __( 'Introduction and stats', 'realtor-raihan' ),
		'stat'   => __( 'The four stats', 'realtor-raihan' ),
		'wi_'    => __( 'Why invest in Dubai', 'realtor-raihan' ),
		'sv_'    => __( 'Services', 'realtor-raihan' ),
		'ts_'    => __( 'Client testimonials', 'realtor-raihan' ),
		'wc_'    => __( 'Why choose me', 'realtor-raihan' ),
		'fq_'    => __( 'FAQ', 'realtor-raihan' ),
		'ct_'    => __( 'Contact', 'realtor-raihan' ),
	);
}

/**
 * One repeater group per page, rendered as plain text blocks the client can read.
 *
 * @param string $slug home|about.
 * @return array key => array( heading, group, columns, help )
 */
function rr_page_repeaters( $slug ) {
	if ( in_array( $slug, array( 'contact', 'blog' ), true ) ) {
		return array();
	}
	if ( 'about' === $slug ) {
		return array(
			'features' => array(
				'heading' => __( 'The four points on the About page', 'realtor-raihan' ),
				'group'   => 'features',
				'columns' => array( 'icon' => 'Icon', 'title' => 'Title', 'text' => 'Text' ),
				'help'    => __( 'One point per block. Leave a block empty to remove that point.', 'realtor-raihan' ),
			),
		);
	}
	return array(
		'services'     => array(
			'heading' => __( 'Service cards', 'realtor-raihan' ),
			'group'   => 'services',
			'columns' => array( 'title' => 'Title', 'text' => 'Text', 'url' => 'Link', 'photo' => 'Photo file name' ),
			'help'    => __( 'One card per block: title, then the text, then the link.', 'realtor-raihan' ),
		),
		'testimonials' => array(
			'heading' => __( 'Testimonials', 'realtor-raihan' ),
			'group'   => 'testimonials',
			'columns' => array( 'title' => 'Name or label', 'text' => 'Quote', 'meta' => 'Meta line' ),
			'help'    => __( 'One testimonial per block.', 'realtor-raihan' ),
		),
		'faq'          => array(
			'heading' => __( 'FAQ questions and answers', 'realtor-raihan' ),
			'group'   => 'faq',
			'columns' => array( 'q' => 'Question', 'a' => 'Answer' ),
			'help'    => __( 'One question per block: the question on the first line, the answer under it.', 'realtor-raihan' ),
		),
	);
}

/**
 * Read the repeater rows of a managed page.
 *
 * @param string $slug page slug.
 * @return array group => rows.
 */
function rr_page_repeater_rows( $slug ) {
	if ( in_array( $slug, array( 'contact', 'blog' ), true ) ) {
		return array();
	}
	if ( 'about' === $slug ) {
		$data = rr_about();
		return array( 'features' => isset( $data['features'] ) ? (array) $data['features'] : array() );
	}
	global $rr_repeater_rows_cache;
	if ( isset( $rr_repeater_rows_cache ) ) {
		return $rr_repeater_rows_cache;
	}
	$rows = array();
	foreach ( array( 'services', 'testimonials', 'faq' ) as $group ) {
		$rows[ $group ] = rr_h_rows( $group );
	}
	$rr_repeater_rows_cache = $rows;
	return $rows;
}

/**
 * The value of a repeater row: first non-empty column.
 *
 * @param array $row     Row.
 * @param array $columns Column map.
 * @return string
 */
function rr_row_text( $row, $columns ) {
	$parts = array();
	foreach ( $columns as $col => $label ) {
		$val = isset( $row[ $col ] ) ? trim( (string) $row[ $col ] ) : '';
		if ( '' === $val ) {
			continue;
		}
		if ( in_array( $col, array( 'title', 'q', 'name' ), true ) ) {
			$parts[] = $val . ' | ' . implode( ' ', array_filter( array( isset( $row['text'] ) ? $row['text'] : '', isset( $row['a'] ) ? $row['a'] : '' ) ) );
			break;
		}
		$parts[] = $val;
	}
	return implode( ' | ', $parts );
}

/**
 * Render one row as a text block: "Title | text".
 *
 * @param array $row     Row.
 * @param array $columns Columns.
 * @return string
 */
function rr_row_to_text( $row, $columns ) {
	$cells = array();
	foreach ( array_keys( $columns ) as $col ) {
		if ( in_array( $col, array( 'photo', 'icon', 'url', 'meta' ), true ) ) {
			continue;
		}
		$cells[] = isset( $row[ $col ] ) ? trim( (string) $row[ $col ] ) : '';
	}
	if ( count( $cells ) > 1 ) {
		return $cells[0] . ' | ' . implode( ' ', array_slice( $cells, 1 ) );
	}
	return isset( $cells[0] ) ? $cells[0] : '';
}

/**
 * Parse one text block back into a row.
 *
 * @param string $block   Text block.
 * @param array  $columns Columns.
 * @return array
 */
function rr_text_to_row( $block, $columns ) {
	$block = trim( $block );
	$row   = array();
	$keys  = array_keys( $columns );
	$data  = array_diff( $keys, array( 'photo', 'icon', 'url', 'meta' ) );
	$data  = array_values( $data );
	if ( ! $data ) {
		return $row;
	}
	if ( count( $data ) === 1 ) {
		$row[ $data[0] ] = $block;
		return $row;
	}
	$parts = array_map( 'trim', explode( '|', $block, 2 ) );
	$row[ $data[0] ] = $parts[0];
	$row[ $data[1] ] = isset( $parts[1] ) ? $parts[1] : '';
	return $row;
}

/**
 * Use the classic screen for these two pages.
 *
 * The block editor hides classic fields behind a collapsed drawer and shows a
 * mostly empty canvas, which is exactly the confusion this file removes. With
 * the classic screen the fields sit right under the title and Update saves them.
 *
 * @param bool    $use  Whether to use the block editor.
 * @param WP_Post $post Post.
 * @return bool
 */
add_filter(
	'use_block_editor_for_post',
	function ( $use, $post ) {
		if ( $post && isset( $post->ID ) && rr_managed_slug( $post->ID ) ) {
			return false;
		}
		return $use;
	},
	10,
	2
);

/**
 * The block editor's read only copy of the page text is not needed on the
 * classic screen, so hide that box and say why.
 */
add_action(
	'admin_head',
	function () {
		$post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore
		if ( ! $post_id || ! rr_managed_slug( $post_id ) ) {
			return;
		}
		?>
		<style>
			#postdivrich{ display:none !important }
		</style>
		<?php
	}
);

/**
 * Add the meta box.
 */
add_action(
	'add_meta_boxes',
	function () {
		add_meta_box(
			'rr_page_content',
			__( 'Content of this page', 'realtor-raihan' ),
			'rr_page_content_box',
			'page',
			'normal',
			'high',
			array( '__block_editor_compatible_meta_box' => true )
		);
	}
);

/**
 * Draw the meta box: every field of the page, grouped by section.
 *
 * @param WP_Post $post Post.
 */
function rr_page_content_box( $post ) {
	$slug = rr_managed_slug( $post->ID );
	if ( ! $slug ) {
		echo '<p>' . esc_html__( 'This page has no theme fields.', 'realtor-raihan' ) . '</p>';
		return;
	}
	$owner    = rr_page_owner()[ $slug ];
	$fields   = rr_page_fields( $slug );
	$groups   = rr_page_groups( $slug );
	$repeats  = rr_page_repeaters( $slug );
	$rows     = rr_page_repeater_rows( $slug );
	$admin    = admin_url( $owner['url'] );
	wp_nonce_field( 'rr_page_save_' . $slug, '_rr_page_nonce' );

	echo '<div class="rr-pe">';
	printf(
		'<p class="rr-pe__intro"><strong>%s</strong> %s <a href="%s">%s</a></p>',
		esc_html__( 'This is the real content of the page.', 'realtor-raihan' ),
		esc_html__( 'Change any box below and press Update. Everything on the page is here, grouped in the same order it appears on the website.', 'realtor-raihan' ),
		esc_url( $admin ),
		esc_html__( 'Open the old full screen editor', 'realtor-raihan' )
	);

	$used = array();
	foreach ( $groups as $prefix => $heading ) {
		$part = array();
		foreach ( $fields as $key => $f ) {
			if ( '' === $prefix ) {
				if ( in_array( $key, array( 'eyebrow', 'title' ), true ) ) {
					$part[ $key ] = $f;
				}
				continue;
			}
			if ( strpos( $prefix, '|' ) !== false ) {
				if ( in_array( $key, explode( '|', $prefix ), true ) ) {
					$part[ $key ] = $f;
				}
				continue;
			}
			if ( str_starts_with( $key, $prefix ) ) {
				$part[ $key ] = $f;
			}
		}
		if ( ! $part ) {
			continue;
		}
		$used = array_merge( $used, array_keys( $part ) );
		echo '<h3 class="rr-pe__h">' . esc_html( $heading ) . '</h3><table class="form-table" role="presentation"><tbody>';
		foreach ( $part as $key => $f ) {
			$long  = rr_field_is_long( $key, $f['type'] );
			$id    = 'rrp_' . $key;
			$label = rr_field_label( $key );
			printf( '<tr><th scope="row"><label for="%s">%s</label></th><td>', esc_attr( $id ), esc_html( $label ) );
			if ( $long ) {
				printf(
					'<textarea class="large-text" rows="%d" id="%s" name="rr[%s]">%s</textarea>',
					substr_count( $f['value'], "\n" ) > 1 ? 5 : 3,
					esc_attr( $id ),
					esc_attr( $key ),
					esc_textarea( $f['value'] )
				);
			} else {
				printf(
					'<input type="text" class="large-text" id="%s" name="rr[%s]" value="%s">',
					esc_attr( $id ),
					esc_attr( $key ),
					esc_attr( $f['value'] )
				);
			}
			if ( 'photo' === substr( $key, -5 ) || 'img' === substr( $key, -3 ) ) {
				echo '<p class="description">' . esc_html__( 'A file name from the theme images folder, or a full image URL from Media.', 'realtor-raihan' ) . '</p>';
			}
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}

	// Anything not covered by a group, so nothing is ever hidden.
	$rest = array_diff_key( $fields, array_flip( $used ) );
	if ( $rest ) {
		echo '<h3 class="rr-pe__h">' . esc_html__( 'More', 'realtor-raihan' ) . '</h3><table class="form-table" role="presentation"><tbody>';
		foreach ( $rest as $key => $f ) {
			printf(
				'<tr><th scope="row"><label for="rrp_%1$s">%2$s</label></th><td><input type="text" class="large-text" id="rrp_%1$s" name="rr[%3$s]" value="%4$s"></td></tr>',
				esc_attr( $key ),
				esc_html( rr_field_label( $key ) ),
				esc_attr( $key ),
				esc_attr( $f['value'] )
			);
		}
		echo '</tbody></table>';
	}

	foreach ( $repeats as $key => $rep ) {
		echo '<h3 class="rr-pe__h">' . esc_html( $rep['heading'] ) . '</h3>';
		echo '<p class="description">' . esc_html( $rep['help'] ) . '</p>';
		$list = isset( $rows[ $key ] ) ? (array) $rows[ $key ] : array();
		$list[] = array(); // one empty block, to add a row.
		$i      = 0;
		foreach ( $list as $row ) {
			printf( '<p><textarea class="large-text" rows="3" name="rrr[%s][%d]">%s</textarea></p>', esc_attr( $key ), (int) $i, esc_textarea( rr_row_to_text( (array) $row, $rep['columns'] ) ) );
			$i++;
		}
	}

	echo '<p class="description">' . esc_html__( 'Section on and off switches, card order and the images on the cards live in the old full screen editor, linked above.', 'realtor-raihan' ) . '</p>';
	echo '</div>';
}

/**
 * Keep the page body readable: every field and card as plain text.
 *
 * @param string $slug Page slug.
 * @return string
 */
function rr_page_body_text( $slug ) {
	$fields = rr_page_fields( $slug );
	$groups = rr_page_groups( $slug );
	$rows   = rr_page_repeater_rows( $slug );
	$reps   = rr_page_repeaters( $slug );
	$owner  = rr_page_owner()[ $slug ];
	$out    = array();

	$out[] = '<!-- wp:paragraph --><p><em>' . esc_html( sprintf( __( 'This page is built by the theme. The text below is the live content, refreshed every time you save. You can read it here, but the safe place to change it is the boxes in "Content of this page" below (or %s in the left menu).', 'realtor-raihan' ), $owner['label'] ) ) . '</em></p><!-- /wp:paragraph -->';

	$used = array();
	foreach ( $groups as $prefix => $heading ) {
		$lines = array();
		foreach ( $fields as $key => $f ) {
			$match = false;
			if ( '' === $prefix ) {
				$match = in_array( $key, array( 'eyebrow', 'title' ), true );
			} elseif ( strpos( $prefix, '|' ) !== false ) {
				$match = in_array( $key, explode( '|', $prefix ), true );
			} else {
				$match = str_starts_with( $key, $prefix );
			}
			if ( ! $match || '' === trim( $f['value'] ) ) {
				continue;
			}
			$used[] = $key;
			// Headings get their own block so the outline reads properly.
			$is_head = (bool) preg_match( '/(^title$|^h2$|_title$|_h2$|close_h2|why_h2)/', $key );
			$text    = wp_kses_post( nl2br( $f['value'] ) );
			$lines[] = $is_head
				? '<!-- wp:heading --><h2>' . wp_strip_all_tags( $f['value'] ) . '</h2><!-- /wp:heading -->'
				: '<!-- wp:paragraph --><p>' . $text . '</p><!-- /wp:paragraph -->';
		}
		if ( ! $lines ) {
			continue;
		}
		$out[] = '<!-- wp:heading {"level":3} --><h3>' . esc_html( $heading ) . '</h3><!-- /wp:heading -->';
		$out   = array_merge( $out, $lines );
	}

	foreach ( $reps as $key => $rep ) {
		$list = isset( $rows[ $key ] ) ? (array) $rows[ $key ] : array();
		$items = array();
		foreach ( $list as $row ) {
			$text = rr_row_to_text( (array) $row, $rep['columns'] );
			if ( '' === trim( $text ) ) {
				continue;
			}
			$items[] = '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
		}
		if ( $items ) {
			$out[] = '<!-- wp:heading {"level":3} --><h3>' . esc_html( $rep['heading'] ) . '</h3><!-- /wp:heading -->';
			$out   = array_merge( $out, $items );
		}
	}

	return implode( "\n\n", $out );
}

/**
 * Write the page body back in sync after a save.
 *
 * @param string $slug Page slug.
 */
function rr_sync_page_body( $slug ) {
	$page = get_page_by_path( $slug );
	if ( ! $page && 'blog' === $slug ) {
		$page_for_posts = (int) get_option( 'page_for_posts' );
		if ( $page_for_posts ) {
			$page = get_post( $page_for_posts );
		}
	}
	if ( ! $page ) {
		return;
	}
	$body = rr_page_body_text( $slug );
	if ( trim( (string) $page->post_content ) === trim( $body ) ) {
		return;
	}
	remove_action( 'save_post_page', 'rr_managed_page_save', 10 );
	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => $body,
		)
	);
	add_action( 'save_post_page', 'rr_managed_page_save', 10, 2 );
	update_option( 'rr_editor_notes', 1 );
}

/**
 * Save the fields when the page is saved from the editor, Quick Edit or bulk edit.
 *
 * @param int     $post_id Post id.
 * @param WP_Post $post    Post.
 */
function rr_managed_page_save( $post_id, $post ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	$slug = rr_managed_slug( $post_id );
	if ( ! $slug ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$did_save = false;

	if ( isset( $_POST['_rr_page_nonce'], $_POST['rr'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_rr_page_nonce'] ) ), 'rr_page_save_' . $slug ) ) {
		$text    = (array) wp_unslash( $_POST['rr'] ); // phpcs:ignore
		$repeats = isset( $_POST['rrr'] ) && is_array( $_POST['rrr'] ) ? (array) wp_unslash( $_POST['rrr'] ) : array(); // phpcs:ignore

		if ( 'home' === $slug ) {
			$skip = array( 'services', 'why_invest', 'testimonials', 'why_choose', 'faq', 'sections' );
			foreach ( $text as $key => $value ) {
				$key = sanitize_key( $key );
				if ( in_array( $key, $skip, true ) ) {
					continue;
				}
				update_option( 'rr_home_' . $key, wp_kses_post( trim( (string) $value ) ) );
			}
			foreach ( $repeats as $group => $blocks ) {
				$group = sanitize_key( $group );
				if ( ! in_array( $group, array( 'services', 'testimonials', 'faq', 'why_invest', 'why_choose' ), true ) ) {
					continue;
				}
				$columns = isset( rr_page_repeaters( 'home' )[ $group ] ) ? rr_page_repeaters( 'home' )[ $group ]['columns'] : array( 'title' => 'Title', 'text' => 'Text' );
				$old     = rr_h_rows( $group );
				$rows    = array();
				foreach ( (array) $blocks as $i => $block ) {
					$block = trim( (string) $block );
					if ( '' === $block ) {
						continue;
					}
					$row = rr_text_to_row( $block, $columns );
					// Keep the non text columns (photo, icon, link) of the row that was there.
					if ( isset( $old[ count( $rows ) ] ) ) {
						$row = array_merge( (array) $old[ count( $rows ) ], $row );
					}
					$rows[] = $row;
				}
				update_option( 'rr_home_' . $group, $rows );
			}
			$did_save = true;
		} elseif ( 'contact' === $slug ) {
			$clean = array();
			$data  = rr_contact();
			foreach ( $text as $key => $value ) {
				$key           = sanitize_key( $key );
				$clean[ $key ] = wp_kses_post( trim( (string) $value ) );
			}
			$merged = array_merge( $data, $clean );
			update_option( 'rr_contact_page', $merged );

			// Sync with home options and theme_mods
			if ( ! empty( $clean['eyebrow'] ) ) { update_option( 'rr_home_ct_eyebrow', $clean['eyebrow'] ); }
			if ( ! empty( $clean['title'] ) )   { update_option( 'rr_home_ct_title', $clean['title'] ); }
			if ( ! empty( $clean['lede'] ) )    { update_option( 'rr_home_ct_lede', $clean['lede'] ); }
			if ( ! empty( $clean['form_h'] ) )  { update_option( 'rr_home_ct_form_h', $clean['form_h'] ); }
			if ( ! empty( $clean['form_p'] ) )  { update_option( 'rr_home_ct_form_p', $clean['form_p'] ); }
			if ( ! empty( $clean['phone'] ) )   { set_theme_mod( 'rr_phone', $clean['phone'] ); }
			if ( ! empty( $clean['whatsapp'] ) ){ set_theme_mod( 'rr_whatsapp', $clean['whatsapp'] ); }
			if ( ! empty( $clean['email'] ) )   { set_theme_mod( 'rr_email', $clean['email'] ); }
			if ( ! empty( $clean['area'] ) )    { set_theme_mod( 'rr_area', $clean['area'] ); }

			$did_save = true;
		} elseif ( 'blog' === $slug ) {
			$clean = array();
			$data  = rr_blog();
			foreach ( $text as $key => $value ) {
				$key           = sanitize_key( $key );
				$clean[ $key ] = wp_kses_post( trim( (string) $value ) );
			}
			$merged = array_merge( $data, $clean );
			update_option( 'rr_blog_page', $merged );

			// Sync with theme mods
			if ( ! empty( $clean['eyebrow'] ) )    { set_theme_mod( 'rr_blog_eyebrow', $clean['eyebrow'] ); }
			if ( ! empty( $clean['title'] ) )      { set_theme_mod( 'rr_blog_title', $clean['title'] ); }
			if ( ! empty( $clean['lede'] ) )       { set_theme_mod( 'rr_blog_lede', $clean['lede'] ); }
			if ( ! empty( $clean['hero_img'] ) )   { set_theme_mod( 'rr_blog_hero', $clean['hero_img'] ); }
			if ( ! empty( $clean['list_title'] ) ) { set_theme_mod( 'rr_blog_list_title', $clean['list_title'] ); }
			if ( ! empty( $clean['news_title'] ) ) { set_theme_mod( 'rr_news_title', $clean['news_title'] ); }
			if ( ! empty( $clean['news_text'] ) )  { set_theme_mod( 'rr_news_text', $clean['news_text'] ); }

			$did_save = true;
		} else {
			$clean = array();
			$data  = rr_about();
			foreach ( $text as $key => $value ) {
				$key           = sanitize_key( $key );
				$clean[ $key ] = wp_kses_post( trim( (string) $value ) );
			}
			$merged = array_merge( $data, $clean );
			if ( isset( $repeats['features'] ) ) {
				$features = array();
				foreach ( (array) $repeats['features'] as $block ) {
					$block = trim( (string) $block );
					if ( '' === $block ) {
						continue;
					}
					$old  = isset( $data['features'][ count( $features ) ] ) ? $data['features'][ count( $features ) ] : array();
					$row  = rr_text_to_row( $block, array( 'title' => 'Title', 'text' => 'Text' ) );
					$row  = array_merge( (array) $old, $row );
					$features[] = $row;
				}
				$merged['features'] = $features;
			}
			update_option( 'rr_about_page', $merged );
			$did_save = true;
		}
	}

	// Whatever was saved, the body follows the settings.
	rr_sync_page_body( $slug );

	if ( $did_save ) {
		set_transient( 'rr_page_saved_' . $post_id, 1, 60 );
	}
}
add_action( 'save_post_page', 'rr_managed_page_save', 10, 2 );

/**
 * "Page updated" style confirmation, with a link to see the result.
 */
add_action(
	'admin_notices',
	function () {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'post' !== $screen->base ) {
			return;
		}
		$post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore
		if ( ! $post_id || ! get_transient( 'rr_page_saved_' . $post_id ) ) {
			return;
		}
		delete_transient( 'rr_page_saved_' . $post_id );
		printf(
			'<div class="notice notice-success is-dismissible"><p><strong>%s</strong> %s <a href="%s" target="_blank" rel="noopener">%s</a></p></div>',
			esc_html__( 'Page content saved.', 'realtor-raihan' ),
			esc_html__( 'Your changes are live.', 'realtor-raihan' ),
			esc_url( get_permalink( $post_id ) ),
			esc_html__( 'View the page', 'realtor-raihan' )
		);
	}
);

/**
 * Small styles for the meta box, inline so there is no extra request.
 */
add_action(
	'admin_head',
	function () {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'post' !== $screen->base ) {
			return;
		}
		?>
		<style>
			#rr_page_content .inside{ padding-top:4px }
			.rr-pe__intro{ background:#F6F5F0; border-left:3px solid #C8A34D; padding:10px 14px; margin:0 0 18px; font-size:13px; max-width:900px }
			.rr-pe__h{ font-size:14px; text-transform:uppercase; letter-spacing:.04em; color:#0B1F3A; border-bottom:1px solid #e3e0d7; padding-bottom:6px; margin:26px 0 4px }
			.rr-pe .form-table th{ width:230px; font-weight:600; font-size:13px; color:#3c434a; padding:10px 10px 10px 0 }
			.rr-pe .form-table td{ padding:6px 10px 6px 0 }
			.rr-pe textarea{ font-size:13px; line-height:1.5 }
			#rr_page_content .description{ font-size:12px; color:#646970 }
		</style>
		<?php
	}
);
