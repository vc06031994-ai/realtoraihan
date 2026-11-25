<?php
/**
 * One-click demo content: the six approved articles, their images and the
 * About page defaults. Run from Tools > Demo content.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'admin_menu',
	function () {
		add_management_page(
			__( 'Realtor Raihan demo content', 'realtor-raihan' ),
			__( 'Realtor Raihan demo', 'realtor-raihan' ),
			'manage_options',
			'rr-demo',
			'rr_demo_screen'
		);
	}
);

/**
 * The articles shipped with the theme.
 *
 * @return array
 */
function rr_demo_posts() {
	$body_visa = <<<'HTML'
<p class="po-lede">Property is one of the routes to a UAE Golden Visa, and it is the one most buyers ask about. The headline is simple; the conditions are where people get stuck. This is general guidance, not legal advice.</p>
<h2>The headline</h2>
<p>A property investment at or above the current threshold can support a renewable residency. The threshold and the qualifying conditions are set by the authorities and do change, so confirm the number in force on the day you buy, with the authority or a licensed professional.</p>
<h2>Ownership conditions that trip people up</h2>
<ul>
<li><strong>Off-plan usually does not count.</strong> The investment generally needs to be completed and registered, not a reservation on a future building.</li>
<li><strong>Mortgaged property.</strong> Where a bank is involved, the qualifying value is usually the equity, not the headline price. Confirm before you structure.</li>
<li><strong>Joint ownership.</strong> Shared title deeds may need each share to qualify, or a specific structure. Check before you split a purchase.</li>
</ul>
<blockquote>Buy the property because it is a good property. Let the visa be a consequence, not the reason.</blockquote>
<h2>The paperwork that stalls applications</h2>
<p>Title deed in the right name, valuation where required, and a clean translation of any document not in Arabic or English. Most delays are administrative, not substantive.</p>
<h2>What I do and do not do</h2>
<p>I handle the property side: sourcing, negotiating, the DLD process and the handover. For immigration advice I will point you to a licensed professional. Anyone who promises you a visa outcome without that is guessing.</p>
HTML;

	$body_service = <<<'HTML'
<p class="po-lede">Two buildings on the same street can carry service charges that differ by 40%. That number decides your net yield, so it is worth reading properly before you sign.</p>
<h2>What is actually inside the number</h2>
<p>Service charge is a budget, not a fee. It covers the running of the building: security, cleaning, lifts, pool and gym, chiller where centralised, insurance, and the reserve fund. Each line is budgeted per square foot of your unit, then reconciled against actual spend.</p>
<h2>Why the same street differs</h2>
<ul>
<li><strong>Chiller.</strong> District cooling contracts can add a large line some buildings do not have.</li>
<li><strong>Amenities.</strong> A pool deck and a concierge cost money every month, whether you use them or not.</li>
<li><strong>Building age.</strong> Older towers spend more on maintenance and repairs.</li>
<li><strong>Occupancy.</strong> A building with many short lets wears faster.</li>
</ul>
<blockquote>Ask for three years of statements, not one. A single year hides the spike.</blockquote>
<h2>How I check it for you</h2>
<p>I pull the last three service charge statements, compare the per square foot rate with neighbouring buildings, and flag anything unusual in the reserve fund. If the number looks high, we ask why before we offer.</p>
HTML;

	$body_offplan = <<<'HTML'
<p class="po-lede">A 60/40 and an 80/20 plan are not the same deal, even when the headline price is. Read the payment plan as a cash flow, not a discount.</p>
<h2>What the percentages mean</h2>
<p>The first number is what you pay before handover, the second what you pay after. A 60/40 plan asks for 60% during construction; an 80/20 asks for 80%. The higher the pre-handover share, the more of your money is at risk for longer, and the less you have left to furnish or rent the place.</p>
<h2>Clauses worth negotiating</h2>
<ul>
<li><strong>Handover delay compensation.</strong> Ask what happens if the developer is late, and get it in writing.</li>
<li><strong>Post-handover instalments.</strong> Usually quarterly, usually with a fixed schedule. Check whether they carry a fee.</li>
<li><strong>Early payment discount.</strong> Sometimes a real saving, sometimes a trap that empties your reserve.</li>
<li><strong>Resale during construction.</strong> Check whether the developer allows it and at what fee.</li>
</ul>
<blockquote>Model the worst case: handover six months late and a tenant arriving three months after that.</blockquote>
<h2>My rule of thumb</h2>
<p>Keep at least 10% of the purchase price aside for DLD fees, agency, furnishing and the gap before rent starts. If the payment plan leaves no room for that, the plan is too aggressive for you.</p>
HTML;

	$body_yield = <<<'HTML'
<p class="po-lede">Gross yield is the number on the brochure. Net yield is the number in your bank account. The gap is service charge, management, vacancy and chiller.</p>
<h2>The arithmetic</h2>
<p>Gross yield is annual rent divided by purchase price. Net yield subtracts the costs of owning: service charge, property management if you use it, chiller, insurance, and an allowance for the weeks the unit sits empty.</p>
<h2>A Business Bay example</h2>
<p>A studio bought at AED 1.1 million renting at AED 75,000 a year shows a 6.8% gross yield. Take out a AED 14,000 service charge, 5% management, an 8% vacancy allowance and chiller, and the net figure lands nearer 4.6%. Still respectable, but it is a different number from the one that sold you the deal.</p>
<blockquote>Ask for the net figure in writing before you reserve.</blockquote>
<h2>Where the spread is widest</h2>
<p>Buildings with heavy amenities, district cooling and short-let neighbours carry the biggest gap between gross and net. Older, simpler buildings often look duller on paper and pay better in practice.</p>
HTML;

	$body_pricing = <<<'HTML'
<p class="po-lede">Overpricing costs more than a lower asking price. A listing that sits for three months tells buyers something, and it is not flattering.</p>
<h2>Start from transactions, not asking prices</h2>
<p>Asking prices are opinions. Registered transactions are facts. I pull comparable sales from the last six months in your building and the two nearest, adjust for floor, view, condition and furnishing, and land on a range.</p>
<h2>The cost of waiting</h2>
<ul>
<li><strong>Days on market.</strong> After about six weeks, enquiries drop sharply.</li>
<li><strong>Price cuts.</strong> Buyers assume a second cut is coming and wait.</li>
<li><strong>Carrying costs.</strong> Service charge, mortgage and lost rent keep running.</li>
</ul>
<blockquote>Price to the market, present it properly, and let competition do the work.</blockquote>
<h2>What actually moves a sale</h2>
<p>Correct pricing, good photographs, a clear floor plan, service charge transparency and a seller who can move quickly on paperwork. That is most of it.</p>
HTML;

	$body_community = <<<'HTML'
<p class="po-lede">Choosing a community matters more than choosing a building. You can renovate an apartment; you cannot move the school run.</p>
<h2>Start with the daily routine</h2>
<p>Where do you work, where do the children go to school, and how often do you leave the city? A 25 minute commute and a 55 minute one are different lives, and the difference usually shows up in the price.</p>
<h2>The five questions I ask every buyer</h2>
<ul>
<li><strong>Budget, including fees.</strong> Not just the price.</li>
<li><strong>Timeline.</strong> Ready now, or is 2028 acceptable?</li>
<li><strong>Use.</strong> Live in it, rent it long term, or short let it?</li>
<li><strong>Exit.</strong> Who will buy this from you in five years?</li>
<li><strong>Non-negotiables.</strong> View, floor, parking, school, pet policy.</li>
</ul>
<blockquote>If a community fails two of the five, it is not your community, however good the photos look.</blockquote>
<h2>Where I would look first</h2>
<p>For a first home in Dubai I usually start with Business Bay, JVC or Dubai Hills depending on budget and school needs. For yield I look harder at Arjan, Dubai South and JVC. For capital preservation, established waterfront and Downtown still hold.</p>
HTML;

	return array(
		array(
			'title'    => 'Golden Visa through property: what qualifies',
			'slug'     => 'golden-visa',
			'category' => 'Investing',
			'date'     => '2026-01-30 09:00:00',
			'excerpt'  => 'Property is one of the routes to a UAE Golden Visa, and it is the one most buyers ask about. The headline is simple; the conditions are where people get stuck.',
			'image'    => 'skyline-sunset-wide.webp',
			'body'     => $body_visa,
		),
		array(
			'title'    => 'What a Dubai service charge actually pays for',
			'slug'     => 'service-charge',
			'category' => 'Buying',
			'date'     => '2026-03-12 09:00:00',
			'excerpt'  => 'Two buildings on the same street can carry charges that differ by 40%. Here is what sits inside that number, and how to read the statement before you sign.',
			'image'    => 'gen-marina-night.webp',
			'body'     => $body_service,
		),
		array(
			'title'    => 'Off-plan payment plans, read line by line',
			'slug'     => 'off-plan-payment-plans',
			'category' => 'Buying',
			'date'     => '2026-02-24 09:00:00',
			'excerpt'  => 'A 60/40 and an 80/20 plan are not the same deal. What the post-handover percentage really costs you, and the clauses worth negotiating.',
			'image'    => 'penthouse-terrace-dusk.webp',
			'body'     => $body_offplan,
		),
		array(
			'title'    => 'Gross yield is a sales number. Net yield is the real one',
			'slug'     => 'gross-vs-net-yield',
			'category' => 'Investing',
			'date'     => '2026-03-04 09:00:00',
			'excerpt'  => 'The gap between the two is service charge, management, vacancy and chiller. On a Business Bay studio that spread is wider than most buyers expect.',
			'image'    => 'gen-wcm-villa.webp',
			'body'     => $body_yield,
		),
		array(
			'title'    => 'Pricing a listing so it sells, not so it sits',
			'slug'     => 'pricing-a-listing',
			'category' => 'Selling',
			'date'     => '2026-02-16 09:00:00',
			'excerpt'  => 'Overpricing costs more than a lower asking price. How I set a number from comparable transactions rather than from hope.',
			'image'    => 'gen-office-dusk.webp',
			'body'     => $body_pricing,
		),
		array(
			'title'    => 'Choosing a community before you choose a building',
			'slug'     => 'choosing-a-community',
			'category' => 'Living in Dubai',
			'date'     => '2026-02-02 09:00:00',
			'excerpt'  => 'You can renovate an apartment, you cannot move the school run. The five questions I ask before we look at a single listing.',
			'image'    => 'downtown-walk.webp',
			'body'     => $body_community,
		),
	);
}

/**
 * Import the approved demo articles.
 */
function rr_import_demo_posts() {
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	foreach ( rr_demo_posts() as $demo ) {
		$existing = get_page_by_path( $demo['slug'], OBJECT, 'post' );
		if ( $existing ) {
			continue;
		}
		$post_id = wp_insert_post(
			array(
				'post_title'    => $demo['title'],
				'post_name'     => $demo['slug'],
				'post_content'  => $demo['body'],
				'post_excerpt'  => $demo['excerpt'],
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'post_date'     => $demo['date'],
				'post_category' => array( rr_demo_category( $demo['category'] ) ),
			)
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		// Featured image from the theme's own assets.
		$file = RR_DIR . '/assets/img/' . $demo['image'];
		if ( file_exists( $file ) ) {
			$tmp = wp_tempnam( $demo['image'] );
			copy( $file, $tmp );
			$attachment_id = media_handle_sideload(
				array(
					'name'     => $demo['image'],
					'tmp_name' => $tmp,
				),
				$post_id,
				$demo['title']
			);
			if ( ! is_wp_error( $attachment_id ) ) {
				set_post_thumbnail( $post_id, $attachment_id );
			}
		}
	}
}

add_action(
	'admin_post_rr_demo_import',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Not allowed.', 'realtor-raihan' ) );
		}
		check_admin_referer( 'rr_demo_import' );

		rr_import_demo_posts();

		// Provision the About page image defaults as well.
		if ( ! get_option( 'rr_about_page' ) ) {
			update_option( 'rr_about_page', rr_about_defaults() );
		}

		wp_safe_redirect( add_query_arg( 'rr_demo', '1', admin_url( 'tools.php?page=rr-demo' ) ) );
		exit;
	}
);

/**
 * Auto-provision articles if there are no posts published yet.
 */
add_action(
	'init',
	function () {
		if ( get_option( 'rr_demo_posts_auto_checked' ) ) {
			return;
		}
		$counts    = wp_count_posts( 'post' );
		$published = isset( $counts->publish ) ? (int) $counts->publish : 0;
		if ( $published < 2 ) {
			rr_import_demo_posts();
		}
		update_option( 'rr_demo_posts_auto_checked', 1 );
	}
);

/**
 * Create (or find) a category.
 *
 * @param string $name Category name.
 * @return int Term id.
 */
function rr_demo_category( $name ) {
	$term = get_term_by( 'name', $name, 'category' );
	if ( $term ) {
		return (int) $term->term_id;
	}
	$new = wp_insert_term( $name, 'category' );
	return is_wp_error( $new ) ? 1 : (int) $new['term_id'];
}

/**
 * Demo screen.
 */
function rr_demo_screen() {
	$done = isset( $_GET['rr_demo'] ); // phpcs:ignore
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Realtor Raihan demo content', 'realtor-raihan' ); ?></h1>
		<?php if ( $done ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Demo articles imported. Existing articles with the same slug were left alone.', 'realtor-raihan' ); ?></p></div>
		<?php endif; ?>
		<p style="max-width:760px">
			<?php esc_html_e( 'This imports the six approved blog articles with their featured images and categories, and fills the About page with the approved copy. It is safe to run twice: nothing is duplicated.', 'realtor-raihan' ); ?>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="rr_demo_import">
			<?php wp_nonce_field( 'rr_demo_import' ); ?>
			<?php submit_button( __( 'Import demo articles', 'realtor-raihan' ) ); ?>
		</form>
	</div>
	<?php
}
