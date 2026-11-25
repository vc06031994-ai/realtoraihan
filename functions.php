<?php
/**
 * Realtor Raihan theme bootstrap.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RR_VERSION', '1.1.12' );
define( 'RR_DIR', get_template_directory() );
define( 'RR_URI', get_template_directory_uri() );

require_once RR_DIR . '/inc/helpers.php';
require_once RR_DIR . '/inc/keywords.php';
require_once RR_DIR . '/inc/customizer.php';
require_once RR_DIR . '/inc/home-fields.php';
require_once RR_DIR . '/inc/about-fields.php';
require_once RR_DIR . '/inc/contact-fields.php';
require_once RR_DIR . '/inc/blog-fields.php';
require_once RR_DIR . '/inc/contact.php';
require_once RR_DIR . '/inc/nav-walker.php';
require_once RR_DIR . '/inc/theme-setup.php';
require_once RR_DIR . '/inc/page-css.php';
require_once RR_DIR . '/inc/demo-content.php';
require_once RR_DIR . '/inc/newsletter.php';
require_once RR_DIR . '/inc/admin-ux.php';
require_once RR_DIR . '/inc/page-editor.php';
require_once RR_DIR . '/inc/post-types.php';

/**
 * Assets.
 */
function rr_assets() {
	$css = array(
		'rr-fonts'    => 'fonts.css',
		'rr-base'     => 'base.css',
		'rr-chrome'   => 'chrome.css',
		'rr-footer'   => 'footer.css',
	);

	if ( is_front_page() ) {
		$css['rr-home-hero']       = 'home-01-hero.css';
		$css['rr-home-intro']      = 'home-02-intro.css';
		$css['rr-home-why-invest'] = 'home-03-why-invest.css';
		$css['rr-home-services']   = 'home-04-services.css';
		$css['rr-home-developers'] = 'home-12-developers.css';
		$css['rr-home-testi']      = 'home-08-testimonials.css';
		$css['rr-home-why-choose'] = 'home-09-why-choose.css';
		$css['rr-home-faq']        = 'home-10-faq.css';
		$css['rr-home-contact']    = 'home-11-contact.css';
	}
	if ( is_page( 'dubai-real-estate-faqs' ) ) {
		$css['rr-faq-page'] = 'faq-page.css';
	}
	if ( is_page_template( 'page-templates/about.php' ) ) {
		$css['rr-about'] = 'about.css';
	}
	$is_contact = is_page( 'contact' )
		|| is_page_template( 'page-templates/contact.php' )
		|| is_page_template( 'page-contact.php' );
	if ( $is_contact ) {
		$css['rr-about-banner'] = 'about.css';
		$css['rr-home-contact'] = 'home-11-contact.css';
		$css['rr-contact']      = 'contact.css';
	}
	$is_blog = is_home()
		|| is_archive()
		|| is_search()
		|| is_page( 'blog' )
		|| is_page_template( 'page-templates/blog.php' );
	if ( $is_blog ) {
		$css['rr-blog'] = 'blog.css';
	}
	if ( is_singular( 'post' ) ) {
		$css['rr-post'] = 'post.css';
	}

	// custom.css and custom.js load last, so the client's own CSS/JS wins.
	$css['rr-custom'] = 'custom.css';
	$css['rr-home-mobile-spacing'] = 'home-mobile-spacing.css';

	$i = 0;
	foreach ( $css as $handle => $file ) {
		wp_enqueue_style( $handle, RR_URI . '/assets/css/' . $file, array(), RR_VERSION );
		$i++;
	}

	wp_enqueue_script( 'rr-chrome', RR_URI . '/assets/js/chrome.js', array(), RR_VERSION, true );
	wp_enqueue_script( 'rr-custom', RR_URI . '/assets/js/custom.js', array(), RR_VERSION, true );

	if ( is_front_page() ) {
		$js = array(
			'rr-hero'        => '01-hero.js',
			'rr-intro'       => '02-intro.js',
			'rr-why-invest'  => '03-why-invest.js',
			'rr-services'    => '04-services.js',
			'rr-testi'       => '08-testimonials.js',
			'rr-why-choose'  => '09-why-choose.js',
			'rr-faq'         => '10-faq.js',
			'rr-contact-js'  => '11-contact.js',
		);
		foreach ( $js as $handle => $file ) {
			wp_enqueue_script( $handle, RR_URI . '/assets/js/' . $file, array(), RR_VERSION, true );
		}
	}
	if ( is_page( 'dubai-real-estate-faqs' ) ) {
		$css['rr-faq-page'] = 'faq-page.css';
	}
	if ( is_page_template( 'page-templates/about.php' ) ) {
		wp_enqueue_script( 'rr-about', RR_URI . '/assets/js/about.js', array(), RR_VERSION, true );
	}
	if ( $is_contact ) {
		wp_enqueue_script( 'rr-about', RR_URI . '/assets/js/about.js', array(), RR_VERSION, true );
		wp_enqueue_script( 'rr-contact-js', RR_URI . '/assets/js/11-contact.js', array(), RR_VERSION, true );
	}
	if ( $is_blog ) {
		wp_enqueue_script( 'rr-blog', RR_URI . '/assets/js/blog.js', array(), RR_VERSION, true );
	}

	// Let the visitor (and the client) see the contact form result messages.
	wp_localize_script(
		'rr-chrome',
		'rrData',
		array(
			'contactSent' => isset( $_GET['enquiry'] ) && 'sent' === $_GET['enquiry'] ? '1' : '0',
			'isWP'        => '1',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'rr_assets' );

/**
 * Body classes that let the CSS know where we are.
 */
function rr_body_class( $classes ) {
	$classes[] = 'rr-wp';
	if ( is_front_page() ) {
		$classes[] = 'rr-home';
	}
	if ( is_page( 'contact' ) || is_page_template( 'page-templates/contact.php' ) || is_page_template( 'page-contact.php' ) ) {
		$classes[] = 'page-contact';
		$classes[] = 'page-template-contact';
	}
	return $classes;
}
add_filter( 'body_class', 'rr_body_class' );

/**
 * Pages the theme needs (About with its template, Blog as the posts page, Home
 * as the static front page). Run once, and again if something is missing.
 */
add_action(
	'wp_loaded',
	function () {
		if ( get_option( 'rr_provisioned' ) ) {
			return;
		}
		rr_provision_pages();
		update_option( 'rr_provisioned', 1 );
	}
);
/* Editable About page gallery admin */
add_action('admin_menu', function () { add_submenu_page('rr-home', 'About Gallery', 'About Gallery', 'edit_pages', 'rr-about-gallery', 'rr_about_gallery_admin_page'); });
add_action('admin_enqueue_scripts', function ($hook) { if (isset($_GET['page']) && 'rr-about-gallery' === sanitize_key($_GET['page'])) { wp_enqueue_media(); } });
add_action('admin_post_rr_gallery_save', function () {
 if (!current_user_can('edit_pages')) { wp_die('Not allowed.'); } check_admin_referer('rr_gallery_save');
 $images = isset($_POST['gallery_image']) ? (array) wp_unslash($_POST['gallery_image']) : array();
 $captions = isset($_POST['gallery_caption']) ? (array) wp_unslash($_POST['gallery_caption']) : array(); $items = array();
 foreach ($images as $i => $image) { $image = esc_url_raw($image); $caption = isset($captions[$i]) ? sanitize_text_field($captions[$i]) : ''; if ($image) { $items[] = array('image'=>$image,'caption'=>$caption); } }
 update_option('rr_about_gallery_items', $items, false); wp_safe_redirect(add_query_arg('saved','1',admin_url('admin.php?page=rr-about-gallery'))); exit;
});
function rr_about_gallery_admin_page() {
 if (!current_user_can('edit_pages')) { return; }
 $items = get_option('rr_about_gallery_items', array());
 if (!is_array($items) || empty($items)) { $items = array(
 array('image'=>'https://images.unsplash.com/photo-1531058020387-3be344556be6?auto=format&fit=crop&w=900&q=85','caption'=>'Awards & Recognition'),
 array('image'=>'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=900&q=85','caption'=>'Certificates & Achievements'),
 array('image'=>'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=900&q=85','caption'=>'Industry Events'),
 array('image'=>'https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=900&q=85','caption'=>'Professional Networking'),
 array('image'=>'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=900&q=85','caption'=>'Speaking Engagements'),
 array('image'=>'https://images.unsplash.com/photo-1503428593586-e225b39bddfe?auto=format&fit=crop&w=900&q=85','caption'=>'Business Gatherings')); }
 echo '<div class="wrap"><h1>About Gallery</h1><p>Add, replace, remove and caption your awards, achievements and event photos. Save changes to update the About page.</p>';
 if (isset($_GET['saved'])) { echo '<div class="notice notice-success"><p>Gallery saved.</p></div>'; }
 echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="rr_gallery_save">'; wp_nonce_field('rr_gallery_save'); echo '<div id="rr-gallery-admin-rows">';
 foreach ($items as $item) { echo '<div class="rr-gallery-admin-row" style="display:flex;gap:16px;align-items:center;background:#fff;border:1px solid #ccd0d4;padding:14px;margin:12px 0;max-width:900px"><div style="width:160px"><img class="rr-gallery-admin-preview" src="'.esc_url($item['image']).'" style="width:150px;height:100px;object-fit:cover;display:block;margin-bottom:8px"><input type="hidden" name="gallery_image[]" value="'.esc_url($item['image']).'"><button type="button" class="button rr-gallery-admin-choose">Choose image</button></div><div style="flex:1"><label>Caption<br><input class="large-text" type="text" name="gallery_caption[]" value="'.esc_attr($item['caption']).'"></label></div><button type="button" class="button-link-delete rr-gallery-admin-remove">Remove</button></div>'; }
 echo '</div><p><button type="button" class="button" id="rr-gallery-admin-add">Add image</button></p>'; submit_button('Save gallery'); echo '</form></div>'; ?>
 <script>jQuery(function($){function bindRow(r){r.find('.rr-gallery-admin-choose').on('click',function(e){e.preventDefault();var f=wp.media({title:'Choose gallery image',button:{text:'Use image'},multiple:false});f.on('select',function(){var a=f.state().get('selection').first().toJSON();r.find('input[name="gallery_image[]"]').val(a.url);r.find('.rr-gallery-admin-preview').attr('src',a.url);});f.open();});r.find('.rr-gallery-admin-remove').on('click',function(){r.remove();});}$('#rr-gallery-admin-rows .rr-gallery-admin-row').each(function(){bindRow($(this));});$('#rr-gallery-admin-add').on('click',function(){var r=$('<div class="rr-gallery-admin-row" style="display:flex;gap:16px;align-items:center;background:#fff;border:1px solid #ccd0d4;padding:14px;margin:12px 0;max-width:900px"><div style="width:160px"><img class="rr-gallery-admin-preview" src="" style="width:150px;height:100px;object-fit:cover;display:block;margin-bottom:8px"><input type="hidden" name="gallery_image[]" value=""><button type="button" class="button rr-gallery-admin-choose">Choose image</button></div><div style="flex:1"><label>Caption<br><input class="large-text" type="text" name="gallery_caption[]" value=""></label></div><button type="button" class="button-link-delete rr-gallery-admin-remove">Remove</button></div>');$('#rr-gallery-admin-rows').append(r);bindRow(r);});});</script><?php
}


/* Editable developer logo marquee settings */
add_action('admin_menu', function () { add_submenu_page('rr-home', 'Developer Logos', 'Developer Logos', 'edit_pages', 'rr-developer-logos', 'rr_developer_logos_admin_page'); });
add_action('admin_post_rr_developer_logos_save', function () { if (!current_user_can('edit_pages')) { wp_die('Not allowed.'); } check_admin_referer('rr_developer_logos_save'); $raw = isset($_POST['developer_logos']) ? wp_unslash($_POST['developer_logos']) : ''; $rows = preg_split('/\r\n|\r|\n/', $raw); $items = array(); foreach ($rows as $row) { $parts = array_map('trim', explode('|', $row)); $name = sanitize_text_field($parts[0] ?? ''); $domain = sanitize_text_field($parts[1] ?? ''); $logo = isset($parts[2]) ? esc_url_raw($parts[2]) : ''; if ($name && $domain) { $items[] = array('name'=>$name,'domain'=>$domain,'logo'=>$logo); } } update_option('rr_developer_logos', $items, false); wp_safe_redirect(add_query_arg('saved','1',admin_url('admin.php?page=rr-developer-logos'))); exit; });
function rr_developer_logos_admin_page() { if (!current_user_can('edit_pages')) { return; } $items = get_option('rr_developer_logos', array()); if (empty($items)) { $items = array(array('name'=>'Nakheel','domain'=>'nakheel.com'),array('name'=>'Emaar','domain'=>'emaar.com'),array('name'=>'Modon','domain'=>'modon.ae'),array('name'=>'Aldar','domain'=>'aldar.com'),array('name'=>'DAMAC','domain'=>'damacproperties.com'),array('name'=>'Danube','domain'=>'danubeproperties.com'),array('name'=>'Azizi','domain'=>'azizidevelopments.com'),array('name'=>'Imtiaz','domain'=>'imtiazdevelopments.com'),array('name'=>'Samana','domain'=>'samanadevelopers.com'),array('name'=>'Omniyat','domain'=>'omniyat.com'),array('name'=>'Meraas','domain'=>'meraas.com'),array('name'=>'Dubai Properties','domain'=>'dp.ae'),array('name'=>'Expo City Developer','domain'=>'expocitydubai.com')); } $lines = array(); foreach ($items as $item) { $lines[] = $item['name'].'|'.$item['domain'].'|'.($item['logo'] ?? ''); } echo '<div class="wrap"><h1>Developer Logos</h1><p>One developer per line: <code>Name|website-domain|optional-logo-image-URL</code>. Leave the image URL blank to use the website favicon. Save to update the homepage running slider.</p>'; if (isset($_GET['saved'])) { echo '<div class="notice notice-success"><p>Developer logos saved.</p></div>'; } echo '<form method="post" action="'.esc_url(admin_url('admin-post.php')).'"><input type="hidden" name="action" value="rr_developer_logos_save">'; wp_nonce_field('rr_developer_logos_save'); echo '<textarea name="developer_logos" rows="16" class="large-text code">'.esc_textarea(implode("\n", $lines)).'</textarea>'; submit_button('Save developer logos'); echo '</form></div>'; }



// Clear the complete WP Rocket page cache.
if ( function_exists( 'rocket_clean_domain' ) ) {
    rocket_clean_domain();
}

// Clear generated minified CSS and JS files.
if ( function_exists( 'rocket_clean_minify' ) ) {
    rocket_clean_minify();
}