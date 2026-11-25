<?php
/**
 * The Home page editor.
 *
 * One admin screen ("Home Page") holds every editable piece of the home page:
 * headings, paragraphs, images, list rows (service cards, testimonials, FAQ,
 * process steps) and the section on/off switches. The page templates render
 * from these values, and the defaults below are the finished copy, so a fresh
 * install looks exactly like the approved design.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default content for every home section.
 *
 * @return array
 */
function rr_home_defaults() {
	$defaults = array(
		/* ------------- hero ------------- */
		'hero_tag'      => 'Property Consultant · Dubai',
		'hero_title_l1' => 'Raihan Shaikh,',
		'hero_title_l2' => 'Property Consultant',
		'hero_title_l3' => 'Dubai',
		'hero_say'      => 'Turning your keys into earnings, <b>because you deserve nothing less.</b>',
		'hero_lede'     => "I'm a professional property consultant in Dubai who helps people buy, sell, rent and invest with confidence. You get straight answers, real numbers, and someone who picks up the phone.",
		'hero_cta1'     => 'Book a Free Consultation',
		'hero_cta2'     => 'About Me',
		'hero_s1'       => '',
		'hero_s2'       => '',
		'hero_s3'       => '',
		'hero_s4'       => '',

		/* ------------- intro + stats ------------- */
		'intro_tag'   => 'Introduction',
		'intro_title' => "Turning Your Dubai Property\nGoals into Smart <em>Real Estate</em>\n<em>Investments</em>",
		'intro_aside' => 'Working with a Dubai real estate agent should feel clear and honest. Buy, sell, or rent with personal guidance from the first call to handover.',
		'intro_p1'    => "Dubai moves fast. If you're buying here for the first time, the choices can feel endless. Prices change from one community to the next, paperwork has its own rules, and not every listing is as good as the photos suggest.",
		'intro_p2'    => "That's where I come in. As a real estate agent in Dubai, I work with investors, families, and business owners to find properties that fit their budget and their goals. Then I stay with them through negotiation, financing, and handover. Tell me what you're after, and I'll tell you honestly what makes sense.",
		'intro_quote' => 'Straight answers, real numbers, and someone who picks up the phone.',
		'intro_cta'   => 'Contact Me',
		'intro_img'   => '',
		'intro_badge_n' => '5+',
		'intro_badge_t' => 'YEARS IN DUBAI PROPERTY',
		'intro_cap_b'   => 'Raihan Shaikh',
		'intro_cap_s'   => 'Founder & Property Consultant',
		'stat1_n' => '5+', 'stat1_t' => 'Years of Experience', 'stat1_s' => "Hands-on knowledge of\nthe Dubai market",
		'stat2_n' => '100+', 'stat2_t' => 'Satisfied Clients', 'stat2_s' => "Buyers, sellers, landlords,\nand investors",
		'stat3_n' => '10', 'stat3_t' => 'Locations Covered', 'stat3_s' => "Popular communities\nacross Dubai",
		'stat4_n' => '24/7', 'stat4_t' => 'Continuous Support & Guidance', 'stat4_s' => "Help before, during,\nand after the deal",

		/* ------------- why invest ------------- */
		'wi_tag'   => 'Why Invest',
		'wi_title' => "Why Are Smart Investors\nLooking at <em>Dubai</em> for Their\nNext Property <em>Investment?</em>",
		'wi_aside' => 'People from all over the world invest in Dubai property for practical reasons. Here are the ones I explain to my clients most often.',
		'wi_num'   => '13',
		'wi_num_tx' => 'reasons clients ask about, in plain English',

		/* ------------- services ------------- */
		'sv_tag'   => 'What I Offer',
		'sv_title' => "Property Consulting\nServices in <em>Dubai</em>",
		'sv_aside' => "Whether you want to buy, sell, rent, or invest in commercial real estate, I offer property consulting services in Dubai built around your situation. Here's how I can help.",

		/* ------------- testimonials ------------- */
		'ts_title' => 'What My <em>Clients Say</em>',
		'ts_lede'  => 'Building trust through honest advice, personalized service, and successful property journeys in Dubai.',
		'ts_note'  => 'Names and identities are withheld until written consent is on file.',

		/* ------------- why choose me ------------- */
		'wc_meta'  => 'Why Choose Me',
		'wc_title' => "Why Choose Me as Your\nReal Estate Agent <em>in Dubai?</em>",
		'wc_cta'   => 'Contact Me',

		/* ------------- faq ------------- */
		'fq_eyebrow' => 'Frequently Asked Questions',
		'fq_title'   => "Questions? I'm\nHere To Help.",
		'fq_lede'    => 'The things buyers, sellers and investors ask me most often about Dubai property, answered straight, with no sales gloss.',
		'fq_cta'     => 'Ask me directly',

		/* ------------- contact ------------- */
		'ct_eyebrow' => 'Get In Touch',
		'ct_title'   => "Let's Talk About\nYour Property <em>Goals.</em>",
		'ct_lede'    => "Tell me what you're planning and I'll come back with honest options, no pressure, no jargon. If you'd rather talk it through, call or message me directly.",
		'ct_form_h'  => 'Send an enquiry',
		'ct_form_p'  => "Fill this in and I'll reply personally, usually the same day.",
	);

	// Repeaters live in one option each so they are easy to loop.
	$defaults['services'] = array(
		array( 'title' => 'Sell Property', 'text' => "Thinking of selling your property in Dubai? I'll help you set a realistic price, present the home well, and reach serious buyers. I handle viewings, negotiate offers, and guide the paperwork through to closing.", 'url' => '', 'icon' => 'sell', 'photo' => '', 'featured' => '1' ),
		array( 'title' => 'Buy Property', 'text' => 'I start with your budget, goals and timeline, then shortlist homes and investments that fit, share honest market insight and negotiate for you.', 'url' => '', 'icon' => 'buy', 'photo' => '', 'featured' => '0' ),
		array( 'title' => 'Rent Property', 'text' => 'I match tenants with suitable places and landlords with reliable tenants, and help with rental pricing, lease terms and the practical details.', 'url' => '', 'icon' => 'rent', 'photo' => '', 'featured' => '0' ),
		array( 'title' => 'Commercial', 'text' => 'Offices, retail and industrial units need a different approach. I help owners and investors find space that fits, then negotiate protective terms.', 'url' => '', 'icon' => 'commercial', 'photo' => '', 'featured' => '0' ),
		array( 'title' => 'Mortgage Guidance', 'text' => 'Dubai mortgages have their own rules for expats and non-residents. I explain your options, connect you with lenders and help you compare offers.', 'url' => '', 'icon' => 'mortgage', 'photo' => '', 'featured' => '0' ),
		array( 'title' => 'Golden Visa Guidance', 'text' => 'I explain how property investment can support a Golden Visa application and check the property meets current requirements.', 'url' => '', 'icon' => 'visa', 'photo' => '', 'featured' => '0' ),
		array( 'title' => 'Business Setup', 'text' => 'I explain the general process, point you to trusted setup partners and help you find the right office or commercial space.', 'url' => '', 'icon' => 'business', 'photo' => '', 'featured' => '0' ),
		array( 'title' => 'Bank Account Support', 'text' => 'Opening a bank account is often the first hurdle for new investors in Dubai. I guide you through what banks usually ask for and introduce you to the right contacts, so your payments and transfers run smoothly.', 'url' => '', 'icon' => 'bank', 'photo' => '', 'featured' => '0' ),
	);

	$defaults['why_invest'] = array(
		array( 'title' => 'Strategic Location', 'text' => 'Dubai sits where Europe, Asia, and Africa meet, and its airports connect to cities across the globe. That reach draws buyers, tenants, and businesses from everywhere, which keeps demand for homes and offices active.', 'photo' => 'skyline-sunset-wide.webp' ),
		array( 'title' => 'Stable Economy', 'text' => 'The city earns from trade, tourism, aviation, finance, and logistics, not from one industry alone. A mixed economy gives property owners a steadier base than markets that depend on a single sector.', 'photo' => 'gen-office-dusk.webp' ),
		array( 'title' => 'Tax-Free Environment', 'text' => 'The UAE has no personal income tax, so rental income and property gains are not taxed in your personal hands. Business activity can bring corporate tax or VAT into the picture, so I always suggest a quick word with a tax adviser.', 'photo' => 'penthouse-living-sunset.webp' ),
		array( 'title' => 'Thriving Rental Market', 'text' => "Dubai has a large tenant population of professionals, families and newcomers. Rental yields are often higher than in many major global cities, though they vary by area and property type. I'll show you real figures for the community you're considering.", 'photo' => 'gen-marina-night.webp' ),
		array( 'title' => 'Infrastructure Development', 'text' => 'Metro lines, new roads, airports, hospitals, and schools keep expanding. When a neighbourhood gets better connected, it usually becomes more attractive to live in and rent out.', 'photo' => 'marina-daylight.webp' ),
		array( 'title' => 'World-Class Lifestyle', 'text' => 'Beaches, schools, healthcare, dining and entertainment sit within a short drive of most communities. That quality of life is what keeps tenants renewing and buyers arriving.', 'photo' => 'gen-villa-evening.webp' ),
		array( 'title' => 'Freehold Ownership', 'text' => 'Foreign buyers can own freehold property outright in designated areas, with title registered at the Dubai Land Department. No local sponsor is needed for those homes.', 'photo' => 'villa-pool-terrace.webp' ),
		array( 'title' => 'Residency Through Property', 'text' => 'A qualifying property investment can support a renewable residency. The thresholds change, so we confirm the current rule before you commit.', 'photo' => 'penthouse-terrace-dusk.webp' ),
		array( 'title' => 'Strong Developer Track Record', 'text' => 'Dubai\'s major developers deliver on schedule more often than not, and their escrow rules protect off-plan buyers. I only bring you developers I have seen hand over.', 'photo' => 'downtown-walk.webp' ),
		array( 'title' => 'Currency Advantage', 'text' => 'The dirham is pegged to the US dollar, which removes one layer of exchange risk for many international buyers and makes rental income easier to plan.', 'photo' => 'skyline-dusk-wide.webp' ),
		array( 'title' => 'Transparent Regulation', 'text' => 'RERA licensing, escrow accounts and a public transaction register make Dubai one of the easier markets to verify. You can check almost everything I tell you.', 'photo' => 'gen-office-dusk.webp' ),
		array( 'title' => 'Population Growth', 'text' => 'The city keeps adding residents, and each new arrival needs a home. Supply is catching up in some areas, which is exactly why community choice matters.', 'photo' => 'gen-marina-night.webp' ),
		array( 'title' => 'Golden Visa Pathway', 'text' => 'Property is one of the routes to long-term residency, and it is the one most of my clients ask about first. We go through the conditions honestly.', 'photo' => 'skyline-sunset-wide.webp' ),
	);

	$defaults['testimonials'] = array(
		array( 'quote' => 'Raihan made the entire property-buying process smooth and stress-free. He understood exactly what I was looking for and guided me through every step. His communication and professional approach made a real difference.', 'name' => 'Client Name', 'role' => 'Property Buyer · Dubai, UAE' ),
		array( 'quote' => 'Working with Raihan was a great experience. He provided valuable insights into the Dubai property market and helped me explore investment opportunities that matched my goals. Highly professional and supportive.', 'name' => 'Client Name', 'role' => 'Property Investor · Dubai, UAE' ),
		array( 'quote' => 'Raihan was helpful, responsive, and transparent throughout the selling process. He kept me informed at every stage and made the overall experience much easier than I expected.', 'name' => 'Client Name', 'role' => 'Property Seller · Dubai, UAE' ),
		array( 'quote' => 'As a first-time buyer I had a hundred questions. Raihan answered all of them, including the ones that did not help his commission. That is why I have already sent him two friends.', 'name' => 'Client Name', 'role' => 'First-Time Buyer · Dubai, UAE' ),
	);

	$defaults['why_choose'] = array(
		array( 'title' => 'Market Expertise', 'text' => "I follow Dubai's communities, developers, and price movements closely. When you ask whether a price is fair, you get a straight answer backed by comparable sales and current listings." ),
		array( 'title' => 'Tailored Investment Strategies', 'text' => 'A first-time buyer, a landlord, and a business owner want different things. I build a plan around your goals: rental income, long-term growth, or a home you will live in.' ),
		array( 'title' => 'Access to Off-Market Deals', 'text' => "Some of the best opportunities never reach public portals. Through my network, I can often tell you about properties before they're widely advertised." ),
		array( 'title' => 'Proactive Research & Due Diligence', 'text' => "I check the title, the service charges, the developer's record, and the surrounding area before you commit. If something looks wrong, I'll say so, even when it costs me a sale." ),
		array( 'title' => 'Transparent Communication', 'text' => "You'll always know where your deal stands. I explain fees upfront, answer questions quickly, and keep supporting you after the keys are in your hand." ),
		array( 'title' => 'Commitment to Confidentiality', 'text' => 'Your finances and plans stay between us. I never share your details without your permission.' ),
	);

	$defaults['faq'] = array(
		array(
			'q' => 'Who is the best property consultant in Dubai?',
			'a' => "The best property consultant is Raihan Shaikh, who is licensed, understands the community you're targeting, and is transparent about costs. Raihan Shaikh is a Dubai-based property consultant who supports buyers, sellers, landlords, and investors with clear advice and ongoing assistance, from the first consultation to the final handover.",
		),
		array(
			'q' => 'What does a property consultant in Dubai do?',
			'a' => 'A property consultant helps you make informed decisions about buying, selling, renting, or investing. This includes market research, property shortlisting, price negotiation, paperwork guidance, and introductions to mortgage lenders. Raihan Shaikh helps clients navigate these decisions with practical advice and a focus on their property goals.',
		),
		array(
			'q' => 'How can I buy property in Dubai as a foreigner?',
			'a' => 'Foreigners can buy freehold property in designated areas of Dubai. The usual steps include setting a budget, shortlisting properties, signing the sale agreement, paying a deposit, and completing the transfer at the Dubai Land Department. Working with a knowledgeable property consultant like Raihan Shaikh can help you understand the process and navigate each step.',
		),
		array(
			'q' => 'What extra costs should I expect when buying property in Dubai?',
			'a' => "Beyond the purchase price, expect the Dubai Land Department transfer fee, usually 4% of the price, plus agency fees, trustee office fees, and mortgage charges if you're financing. Fees vary by deal, so ask for a full cost breakdown before you sign anything.",
		),
		array(
			'q' => 'What is the difference between a real estate agent, an agency, and a consultant in Dubai?',
			'a' => 'A real estate agent is a licensed individual who handles transactions. A real estate agency or company is the firm that employs agents. A property consultant focuses on advice, which means market analysis, strategy, and long-term planning, and often handles transactions too.',
		),
		array(
			'q' => 'Can non-residents get a mortgage in Dubai?',
			'a' => 'Yes, many UAE banks lend to non-residents, though they often ask for a larger down payment than they do for residents. Rates and terms differ by bank and by your income profile, so comparing several offers is wise.',
		),
		array(
			'q' => 'Can I get a Golden Visa by buying property in Dubai?',
			'a' => 'Qualifying property investors can apply for a long-term UAE residency, and the minimum property value has been AED 2 million. Requirements can change, so confirm the current rules with official sources or with your consultant before buying.',
		),
		array(
			'q' => 'Is buying property in Dubai a good investment right now?',
			'a' => 'It can be, depending on the area, property type, and your goals. Dubai offers no personal income tax, a large rental market, and strong international demand. However, prices can rise and fall, so compare options carefully and consider your investment timeline. Raihan Shaikh can help buyers and investors assess suitable areas and property options based on their objectives.',
		),
		array(
			'q' => 'Should I choose off-plan or ready property in Dubai?',
			'a' => 'Off-plan properties usually cost less upfront and offer staged payment plans, but you wait for completion and rely on the developer. Ready properties let you move in or start renting right away. The better choice depends on your budget, timeline, and risk comfort.',
		),
		array(
			'q' => 'How do I contact Raihan Shaikh, and what happens in the first consultation?',
			'a' => "Call +971 52 102 7252, email hello@realtorraihan.com, or use the form on this page. In the first conversation, we talk through your goals, budget, and timeline. Then I outline realistic options, and there's no pressure to commit.",
		),
	);

	// Section order + switches, used by the home template and the admin screen.
	$defaults['sections'] = array(
		'hero'         => array( 'Hero banner', '1' ),
		'intro'        => array( 'Introduction and stats', '1' ),
		'why-invest'   => array( 'Why invest in Dubai', '1' ),
		'services'     => array( 'Services', '1' ),
		'testimonials' => array( 'Client testimonials', '1' ),
		'why-choose'   => array( 'Why choose me', '1' ),
		'faq'          => array( 'FAQ', '1' ),
		'contact'      => array( 'Contact', '1' ),
	);

	return $defaults;
}

/** Read one home value. */
function rr_h( $key ) {
	$d = rr_home_defaults();
	$val = get_option( 'rr_home_' . $key, null );
	if ( null === $val || '' === $val ) {
		return isset( $d[ $key ] ) ? $d[ $key ] : '';
	}
	return $val;
}

/** Read a repeater. */
function rr_h_rows( $key ) {
	$d    = rr_home_defaults();
	$rows = get_option( 'rr_home_' . $key, null );
	if ( ! is_array( $rows ) || ! $rows ) {
		return isset( $d[ $key ] ) ? $d[ $key ] : array();
	}
	// Merge with defaults so a row saved by an older version still has every key.
	if ( isset( $d[ $key ][0] ) ) {
		$template = $d[ $key ][0];
		foreach ( $rows as $i => $row ) {
			$rows[ $i ] = array_merge( $template, (array) $row );
		}
	}
	return $rows;
}

/** Is a section switched on? */
function rr_h_section( $key ) {
	$d = rr_home_defaults();
	if ( ! isset( $d['sections'][ $key ] ) ) {
		return true;
	}
	return '0' !== (string) get_option( 'rr_home_on_' . $key, '1' );
}

/**
 * Register the admin screen.
 */
add_action(
	'admin_menu',
	function () {
		add_menu_page(
			__( 'Home Page', 'realtor-raihan' ),
			__( 'Home Page', 'realtor-raihan' ),
			'edit_pages',
			'rr-home',
			'rr_home_admin_screen',
			'dashicons-admin-home',
			3
		);
	}
);

add_action(
	'admin_init',
	function () {
		register_setting( 'rr_home_group', 'rr_home_form' );
	}
);

/**
 * Save handler: one form, all fields.
 */
add_action(
	'admin_post_rr_home_save',
	function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'realtor-raihan' ) );
		}
		check_admin_referer( 'rr_home_save' );

		$defaults = rr_home_defaults();
		$text     = isset( $_POST['rr'] ) && is_array( $_POST['rr'] ) ? wp_unslash( $_POST['rr'] ) : array(); // phpcs:ignore
		$repeats  = isset( $_POST['rrr'] ) && is_array( $_POST['rrr'] ) ? wp_unslash( $_POST['rrr'] ) : array(); // phpcs:ignore

		foreach ( $text as $key => $value ) {
			$key = sanitize_key( $key );
			if ( in_array( $key, array( 'services', 'why_invest', 'testimonials', 'why_choose', 'faq', 'sections' ), true ) ) {
				continue;
			}
			update_option( 'rr_home_' . $key, wp_kses_post( trim( (string) $value ) ) );
		}

		foreach ( $repeats as $group => $rows ) {
			$group = sanitize_key( $group );
			$clean = array();
			if ( is_array( $rows ) ) {
				foreach ( $rows as $row ) {
					$row = array_map(
						static function ( $v ) {
							return wp_kses_post( trim( (string) $v ) );
						},
						(array) $row
					);
					// skip fully empty rows
					if ( ! array_filter( $row ) ) {
						continue;
					}
					$clean[] = $row;
				}
			}
			update_option( 'rr_home_' . $group, $clean );
		}

		// order numbers
		$order = isset( $_POST['rr_order'] ) && is_array( $_POST['rr_order'] ) ? wp_unslash( $_POST['rr_order'] ) : array(); // phpcs:ignore
		foreach ( $order as $key => $num ) {
			$key = sanitize_key( $key );
			update_option( 'rr_home_order_' . $key, max( 0, (int) $num ) );
		}

		// section switches
		foreach ( $defaults['sections'] as $key => $meta ) {
			$on = isset( $_POST['rr_on'][ $key ] ) ? '1' : '0'; // phpcs:ignore
			update_option( 'rr_home_on_' . $key, $on );
		}

		wp_safe_redirect( add_query_arg( 'rr_saved', '1', admin_url( 'admin.php?page=rr-home' ) ) );
		exit;
	}
);

/**
 * The admin screen.
 */
function rr_home_admin_screen() {
	$defaults = rr_home_defaults();
	$saved    = isset( $_GET['rr_saved'] ); // phpcs:ignore
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Home Page content', 'realtor-raihan' ); ?></h1>
		<p style="max-width:900px">
			<?php esc_html_e( 'Everything below appears on the home page. Clear a field and save to fall back to the original approved copy. To switch a whole section on or off use the switches at the bottom.', 'realtor-raihan' ); ?>
		</p>
		<?php if ( $saved ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Home page saved.', 'realtor-raihan' ); ?></p></div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="rr_home_save">
			<?php wp_nonce_field( 'rr_home_save' ); ?>

			<?php
			// label, control (text | area | lines), help text
			$groups = array(
				__( 'Hero', 'realtor-raihan' ) => array(
					'hero_tag'      => array( 'Small line above the headline', 'text' ),
					'hero_title_l1' => array( 'Headline line 1', 'text' ),
					'hero_title_l2' => array( 'Headline line 2', 'text' ),
					'hero_title_l3' => array( 'Headline line 3 (shown in gold)', 'text' ),
					'hero_say'      => array( 'Strapline', 'area', 'Use &lt;b&gt; to bold part of the sentence.' ),
					'hero_lede'     => array( 'Intro paragraph', 'area' ),
					'hero_cta1'     => array( 'First button text', 'text' ),
					'hero_cta2'     => array( 'Second button text', 'text' ),
				),
				__( 'Introduction and stats', 'realtor-raihan' ) => array(
					'intro_tag'     => array( 'Small label', 'text' ),
					'intro_title'   => array( 'Heading', 'lines', 'One line per line break. Wrap a word in &lt;em&gt;...&lt;/em&gt; to set it in gold.' ),
					'intro_aside'   => array( 'Short paragraph beside the heading', 'area' ),
					'intro_p1'      => array( 'Paragraph 1', 'area' ),
					'intro_p2'      => array( 'Paragraph 2', 'area' ),
					'intro_quote'   => array( 'Highlighted quote', 'text' ),
					'intro_cta'     => array( 'Button text', 'text' ),
					'intro_badge_n' => array( 'Photo badge: big number', 'text' ),
					'intro_badge_t' => array( 'Photo badge: small text', 'text' ),
					'intro_cap_b'   => array( 'Photo caption: name', 'text' ),
					'intro_cap_s'   => array( 'Photo caption: role', 'text' ),
					'stat1_n'       => array( 'Stat 1: number', 'text' ),
					'stat1_t'       => array( 'Stat 1: title', 'text' ),
					'stat1_s'       => array( 'Stat 1: small text', 'text' ),
					'stat2_n'       => array( 'Stat 2: number', 'text' ),
					'stat2_t'       => array( 'Stat 2: title', 'text' ),
					'stat2_s'       => array( 'Stat 2: small text', 'text' ),
					'stat3_n'       => array( 'Stat 3: number', 'text' ),
					'stat3_t'       => array( 'Stat 3: title', 'text' ),
					'stat3_s'       => array( 'Stat 3: small text', 'text' ),
					'stat4_n'       => array( 'Stat 4: number', 'text' ),
					'stat4_t'       => array( 'Stat 4: title', 'text' ),
					'stat4_s'       => array( 'Stat 4: small text', 'text' ),
				),
				__( 'Why invest in Dubai', 'realtor-raihan' ) => array(
					'wi_tag'    => array( 'Small label', 'text' ),
					'wi_title'  => array( 'Heading', 'lines', 'One line per line break. &lt;em&gt;...&lt;/em&gt; for gold.' ),
					'wi_aside'  => array( 'Short paragraph beside the heading', 'area' ),
					'wi_num'    => array( 'Big number', 'text' ),
					'wi_num_tx' => array( 'Text beside the big number', 'text' ),
				),
				__( 'Services', 'realtor-raihan' ) => array(
					'sv_tag'   => array( 'Small label', 'text' ),
					'sv_title' => array( 'Heading', 'lines', 'One line per line break. &lt;em&gt;...&lt;/em&gt; for gold.' ),
					'sv_aside' => array( 'Short paragraph beside the heading', 'area' ),
				),
				__( 'Client testimonials', 'realtor-raihan' ) => array(
					'ts_title' => array( 'Heading', 'lines', 'One line per line break. &lt;em&gt;...&lt;/em&gt; for gold.' ),
					'ts_lede'  => array( 'Paragraph under the heading', 'area' ),
					'ts_note'  => array( 'Small note under the carousel', 'area' ),
				),
				__( 'Why choose me', 'realtor-raihan' ) => array(
					'wc_meta'  => array( 'Small label', 'text' ),
					'wc_title' => array( 'Heading', 'lines', 'One line per line break. &lt;em&gt;...&lt;/em&gt; for gold.' ),
					'wc_cta'   => array( 'Button text', 'text' ),
				),
				__( 'FAQ', 'realtor-raihan' ) => array(
					'fq_eyebrow' => array( 'Small label', 'text' ),
					'fq_title'   => array( 'Heading', 'lines', 'One line per line break.' ),
					'fq_lede'    => array( 'Paragraph under the heading', 'area' ),
					'fq_cta'     => array( 'Button text', 'text' ),
				),
				__( 'Contact', 'realtor-raihan' ) => array(
					'ct_eyebrow' => array( 'Small label', 'text' ),
					'ct_title'   => array( 'Heading', 'lines', 'One line per line break. &lt;em&gt;...&lt;/em&gt; for gold.' ),
					'ct_lede'    => array( 'Paragraph under the heading', 'area' ),
					'ct_form_h'  => array( 'Form heading', 'text' ),
					'ct_form_p'  => array( 'Form sub text', 'text' ),
				),
			);

			foreach ( $groups as $title => $fields ) {
				echo '<h2 style="margin-top:28px">' . esc_html( $title ) . '</h2>';
				echo '<table class="form-table" role="presentation"><tbody>';
				foreach ( $fields as $key => $meta ) {
					$label = $meta[0];
					$type  = $meta[1];
					$help  = isset( $meta[2] ) ? $meta[2] : '';
					$value = get_option( 'rr_home_' . $key, '' );
					if ( '' === $value ) {
						$value = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
					}
					echo '<tr><th scope="row"><label for="rr_' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
					if ( 'area' === $type ) {
						echo '<textarea class="large-text" rows="3" id="rr_' . esc_attr( $key ) . '" name="rr[' . esc_attr( $key ) . ']">' . esc_textarea( $value ) . '</textarea>';
					} elseif ( 'lines' === $type ) {
						echo '<textarea class="large-text" rows="4" id="rr_' . esc_attr( $key ) . '" name="rr[' . esc_attr( $key ) . ']">' . esc_textarea( $value ) . '</textarea>';
					} else {
						echo '<input type="text" class="regular-text" id="rr_' . esc_attr( $key ) . '" name="rr[' . esc_attr( $key ) . ']" value="' . esc_attr( $value ) . '">';
					}
					if ( $help ) {
						echo '<p class="description">' . wp_kses_post( $help ) . '</p>';
					}
					echo '</td></tr>';
				}
				echo '</tbody></table>';
			}

			// ---- repeaters ----
			$repeater_labels = array(
				'why_invest'   => array( __( 'Why invest cards', 'realtor-raihan' ), array( 'title' => 'Title', 'text' => 'Text', 'photo' => 'Image file name or URL' ) ),
				'services'     => array( __( 'Service cards', 'realtor-raihan' ), array( 'title' => 'Title', 'text' => 'Text', 'url' => 'Link (empty = contact section)', 'icon' => 'Icon: sell, buy, rent, commercial, mortgage, visa, business, bank', 'photo' => 'Photo file name or URL (featured card only)', 'featured' => 'Featured (1 = large photo card)' ) ),
				'testimonials' => array( __( 'Testimonials', 'realtor-raihan' ), array( 'quote' => 'Quote', 'name' => 'Client name', 'role' => 'Client role' ) ),
				'why_choose'   => array( __( 'Why choose me points', 'realtor-raihan' ), array( 'title' => 'Title', 'text' => 'Text' ) ),
				'faq'          => array( __( 'FAQ questions', 'realtor-raihan' ), array( 'q' => 'Question', 'a' => 'Answer' ) ),
			);

			foreach ( $repeater_labels as $group => $meta ) {
				list( $title, $cols ) = $meta;
				$rows = rr_h_rows( $group );
				echo '<h2 style="margin-top:34px">' . esc_html( $title ) . '</h2>';
				echo '<p class="description">' . esc_html__( 'Leave a row empty to remove it. To add a row, fill the blank row at the bottom.', 'realtor-raihan' ) . '</p>';
				$rows[] = array_fill_keys( array_keys( $cols ), '' );
				foreach ( $rows as $i => $row ) {
					echo '<fieldset style="border:1px solid #dcdcde;padding:12px 16px;margin:0 0 10px;border-radius:6px;background:#fff">';
					echo '<legend style="font-weight:600;padding:0 6px">' . esc_html( sprintf( __( '%1$s %2$d', 'realtor-raihan' ), $title, $i + 1 ) ) . '</legend>';
					foreach ( $cols as $col => $clabel ) {
						$val  = isset( $row[ $col ] ) ? $row[ $col ] : '';
						$long = in_array( $col, array( 'text', 'quote', 'a' ), true );
						echo '<p style="margin:6px 0"><label style="display:block;font-weight:600;margin-bottom:3px">' . esc_html( $clabel ) . '</label>';
						if ( $long ) {
							echo '<textarea class="large-text" rows="3" name="rrr[' . esc_attr( $group ) . '][' . (int) $i . '][' . esc_attr( $col ) . ']">' . esc_textarea( $val ) . '</textarea>';
						} else {
							echo '<input type="text" class="regular-text" name="rrr[' . esc_attr( $group ) . '][' . (int) $i . '][' . esc_attr( $col ) . ']" value="' . esc_attr( $val ) . '">';
						}
						echo '</p>';
					}
					echo '</fieldset>';
				}
			}
			?>

			<h2 style="margin-top:34px"><?php esc_html_e( 'Section switches and order', 'realtor-raihan' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Untick a section to hide it. Order is controlled by the numbers below: lower numbers appear first.', 'realtor-raihan' ); ?></p>
			<table class="form-table" role="presentation"><tbody>
			<?php
			foreach ( $defaults['sections'] as $key => $meta ) {
				$on    = '0' !== (string) get_option( 'rr_home_on_' . $key, '1' );
				$order = get_option( 'rr_home_order_' . $key, '' );
				echo '<tr><th scope="row">' . esc_html( $meta[0] ) . '</th><td>';
				echo '<label><input type="checkbox" name="rr_on[' . esc_attr( $key ) . ']" value="1" ' . checked( $on, true, false ) . '> ' . esc_html__( 'Show on the home page', 'realtor-raihan' ) . '</label>';
				echo '<div style="margin-top:6px"><label>' . esc_html__( 'Position', 'realtor-raihan' ) . ' <input type="number" min="1" max="20" style="width:70px" name="rr_order[' . esc_attr( $key ) . ']" value="' . esc_attr( $order ) . '"></label></div>';
				echo '</td></tr>';
			}
			?>
			</tbody></table>

			<?php submit_button( __( 'Save home page', 'realtor-raihan' ) ); ?>
		</form>
	</div>
	<?php
}
