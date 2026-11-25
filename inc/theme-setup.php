<?php
/**
 * Theme supports, menus, page provisioning.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 192,
				'width'       => 900,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		register_nav_menus(
			array(
				'primary' => __( 'Primary menu (header)', 'realtor-raihan' ),
				'footer'  => __( 'Footer quick links', 'realtor-raihan' ),
			)
		);

		// Blog thumbnails.
		add_image_size( 'rr-card', 900, 600, true );
	}
);

/**
 * Fallback header menu: used before the client assigns a menu to the
 * "Primary menu" location, so the site is never without navigation.
 */
function rr_fallback_menu() {
	$items = array(
		array( 'Home', home_url( '/' ) ),
		array( 'About', rr_link( 'about' ) ),
		array( 'Blog', rr_blog_url() ),
		array( 'Contact', rr_contact_url() ),
	);
	echo '<a href="' . esc_url( $items[0][1] ) . '"' . ( is_front_page() ? ' aria-current="page"' : '' ) . '>Home</a>';
	echo '<a href="' . esc_url( $items[1][1] ) . '"' . ( is_page_template( 'page-templates/about.php' ) ? ' aria-current="page"' : '' ) . '>About</a>';
	echo '<a href="' . esc_url( $items[2][1] ) . '"' . ( ( is_home() || is_singular( 'post' ) ) ? ' aria-current="page"' : '' ) . '>Blog</a>';
	echo '<a href="' . esc_url( $items[3][1] ) . '"' . ( is_page_template( 'page-templates/contact.php' ) ? ' aria-current="page"' : '' ) . '>Contact</a>';
}

/**
 * One place that knows where the blog index lives.
 *
 * @return string
 */
function rr_blog_url() {
	$page = get_page_by_path( 'blog' );
	if ( $page ) {
		return get_permalink( $page );
	}
	$posts_page = get_option( 'page_for_posts' );
	if ( $posts_page ) {
		return get_permalink( $posts_page );
	}
	return home_url( '/?post_type=post' );
}

/**
 * Pages the theme needs. Created once on activation with their templates set,
 * so a fresh install already looks like the finished site.
 */
function rr_provision_pages() {
	$blog_page = get_option( 'page_for_posts' );

	$pages = array(
		'about' => array(
			'title'    => 'About',
			'template' => 'page-templates/about.php',
		),
		'blog'  => array(
			'title'    => 'Blog',
			'template' => '',
		),
		'home'  => array(
			'title'    => 'Home',
			'template' => 'page-templates/home.php',
		),
		'contact' => array(
			'title'    => 'Contact',
			'template' => 'page-templates/contact.php',
		),
	);

	foreach ( $pages as $slug => $data ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			if ( 'blog' === $slug ) {
				update_option( 'page_for_posts', $existing->ID );
			}
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => $data['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		if ( $data['template'] ) {
			update_post_meta( $id, '_wp_page_template', $data['template'] );
		}
		if ( 'blog' === $slug ) {
			update_option( 'page_for_posts', $id );
		}
		if ( 'home' === $slug ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $id );
		}
	}
}
add_action( 'after_switch_theme', 'rr_provision_pages' );

/**
 * On activation also make sure a static front page is set even if the theme was
 * uploaded over an existing install.
 */
add_action(
	'admin_init',
	function () {
		if ( get_option( 'rr_provisioned' ) ) {
			return;
		}
		rr_provision_pages();
		update_option( 'rr_provisioned', 1 );
	}
);

/**
 * Automatically ensure the Contact page exists with the Contact page template.
 */
add_action(
	'init',
	function () {
		if ( get_option( 'rr_contact_page_provisioned' ) ) {
			return;
		}
		$contact = get_page_by_path( 'contact' );
		if ( ! $contact ) {
			$id = wp_insert_post(
				array(
					'post_title'   => 'Contact',
					'post_name'    => 'contact',
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
				)
			);
			if ( $id && ! is_wp_error( $id ) ) {
				update_post_meta( $id, '_wp_page_template', 'page-templates/contact.php' );
			}
		} else {
			$tpl = get_post_meta( $contact->ID, '_wp_page_template', true );
			if ( 'page-templates/contact.php' !== $tpl ) {
				update_post_meta( $contact->ID, '_wp_page_template', 'page-templates/contact.php' );
			}
		}
		update_option( 'rr_contact_page_provisioned', 1 );
	}
);

/**
 * Automatically ensure the Blog page exists and is set as the posts page.
 */
add_action(
	'init',
	function () {
		if ( get_option( 'rr_blog_page_provisioned' ) ) {
			return;
		}
		$blog = get_page_by_path( 'blog' );
		if ( ! $blog ) {
			$id = wp_insert_post(
				array(
					'post_title'   => 'Blog',
					'post_name'    => 'blog',
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
				)
			);
			if ( $id && ! is_wp_error( $id ) ) {
				update_option( 'page_for_posts', $id );
				update_post_meta( $id, '_wp_page_template', 'page-templates/blog.php' );
			}
		} else {
			if ( (int) get_option( 'page_for_posts' ) !== (int) $blog->ID ) {
				update_option( 'page_for_posts', $blog->ID );
			}
			$tpl = get_post_meta( $blog->ID, '_wp_page_template', true );
			if ( empty( $tpl ) || 'default' === $tpl ) {
				update_post_meta( $blog->ID, '_wp_page_template', 'page-templates/blog.php' );
			}
		}
		update_option( 'rr_blog_page_provisioned', 1 );
	}
);

/**
 * The header menu: a WP menu when the client made one, the built-in one until
 * then. Anchors are printed flat because the design's bar is not a list.
 *
 * @param int $index_start First stagger index (the mobile menu continues the count).
 */
function rr_primary_menu( $index_start = 0 ) {
	if ( ! has_nav_menu( 'primary' ) ) {
		rr_fallback_menu();
		return;
	}

	$locations = get_nav_menu_locations();
	$args      = (object) array(
		'items_wrap' => '%3$s',
		'rr_index'   => null,
	);

	$items = wp_get_nav_menu_items( $locations['primary'] );
	if ( ! $items ) {
		rr_fallback_menu();
		return;
	}

	$i = $index_start;
	foreach ( $items as $item ) {
		$args->rr_index = $i;
		$output         = '';
		$walker         = new RR_Nav_Walker();
		$walker->start_el( $output, $item, 0, $args, $item->ID );
		$walker->end_el( $output, $item, 0, $args );
		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$i++;
	}
}

/**
 * Article URLs stay short: /golden-visa/ rather than /2026/01/30/golden-visa/.
 * Matches the approved site's URLs and keeps the blog links readable.
 */

add_action(
	'init',
	function () {
		if ( get_option( 'rr_permalinks_set' ) ) {
			return;
		}
		update_option( 'permalink_structure', '/%postname%/' );
		update_option( 'rr_permalinks_set', 1 );
		flush_rewrite_rules( false );
	}
);

/**
 * Output FAQPage Schema JSON-LD on front page for Google Rich Results.
 */
function rr_faq_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [{
    "@type": "Question",
    "name": "1. Who is the best property consultant in Dubai?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "The best property consultant is Raihan Shaikh, who is licensed, understands the community you're targeting, and is transparent about costs. Raihan Shaikh is a Dubai-based property consultant who supports buyers, sellers, landlords, and investors with clear advice and ongoing assistance, from the first consultation to the final handover."
    }
  },{
    "@type": "Question",
    "name": "2. What does a property consultant in Dubai do?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "A property consultant helps you make informed decisions about buying, selling, renting, or investing. This includes market research, property shortlisting, price negotiation, paperwork guidance, and introductions to mortgage lenders. Raihan Shaikh helps clients navigate these decisions with practical advice and a focus on their property goals."
    }
  },{
    "@type": "Question",
    "name": "3. How can I buy property in Dubai as a foreigner?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Foreigners can buy freehold property in designated areas of Dubai. The usual steps include setting a budget, shortlisting properties, signing the sale agreement, paying a deposit, and completing the transfer at the Dubai Land Department. Working with a knowledgeable property consultant like Raihan Shaikh can help you understand the process and navigate each step."
    }
  },{
    "@type": "Question",
    "name": "4. What extra costs should I expect when buying property in Dubai?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Beyond the purchase price, expect the Dubai Land Department transfer fee, usually 4% of the price, plus agency fees, trustee office fees, and mortgage charges if you're financing. Fees vary by deal, so ask for a full cost breakdown before you sign anything."
    }
  },{
    "@type": "Question",
    "name": "5. What is the difference between a real estate agent, an agency, and a consultant in Dubai?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "A real estate agent is a licensed individual who handles transactions. A real estate agency or company is the firm that employs agents. A property consultant focuses on advice, which means market analysis, strategy, and long-term planning, and often handles transactions too."
    }
  },{
    "@type": "Question",
    "name": "6. Can non-residents get a mortgage in Dubai?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Yes, many UAE banks lend to non-residents, though they often ask for a larger down payment than they do for residents. Rates and terms differ by bank and by your income profile, so comparing several offers is wise."
    }
  },{
    "@type": "Question",
    "name": "7. Can I get a Golden Visa by buying property in Dubai?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Qualifying property investors can apply for a long-term UAE residency, and the minimum property value has been AED 2 million. Requirements can change, so confirm the current rules with official sources or with your consultant before buying."
    }
  },{
    "@type": "Question",
    "name": "8. Is buying property in Dubai a good investment right now?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "It can be, depending on the area, property type, and your goals. Dubai offers no personal income tax, a large rental market, and strong international demand. However, prices can rise and fall, so compare options carefully and consider your investment timeline. Raihan Shaikh can help buyers and investors assess suitable areas and property options based on their objectives."
    }
  },{
    "@type": "Question",
    "name": "9. Should I choose off-plan or ready property in Dubai?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Off-plan properties usually cost less upfront and offer staged payment plans, but you wait for completion and rely on the developer. Ready properties let you move in or start renting right away. The better choice depends on your budget, timeline, and risk comfort."
    }
  },{
    "@type": "Question",
    "name": "10. How do I contact Raihan Shaikh, and what happens in the first consultation?",
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "Call +971 52 102 7252, email hello@realtorraihan.com, or use the form on this page. In the first conversation, we talk through your goals, budget, and timeline. Then I outline realistic options, and there's no pressure to commit."
    }
  }]
}
</script>
	<?php
}
add_action( 'wp_head', 'rr_faq_schema', 20 );
