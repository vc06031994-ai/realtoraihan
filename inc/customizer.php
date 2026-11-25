<?php
/**
 * Customizer: everything global that appears on more than one page.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'customize_register',
	function ( $wp_customize ) {

		$wp_customize->add_panel(
			'rr_brand',
			array(
				'title'       => __( 'Realtor Raihan · Site settings', 'realtor-raihan' ),
				'priority'    => 20,
				'description' => __( 'Brand, contact details, header buttons, footer text and the service-location keywords.', 'realtor-raihan' ),
			)
		);

		/* ---------------- brand ---------------- */
		$wp_customize->add_section(
			'rr_brand_section',
			array(
				'title' => __( '1. Brand and logo', 'realtor-raihan' ),
				'panel' => 'rr_brand',
			)
		);

		$fields = array(
			'rr_brand_name' => array( 'Brand name', 'Realtor Raihan', 'text' ),
			'rr_brand_sub'  => array( 'Small line under the brand name', 'Business Bay, Dubai', 'text' ),
		);
		foreach ( $fields as $key => $f ) {
			$wp_customize->add_setting( $key, array( 'default' => $f[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
			$wp_customize->add_control( $key, array( 'label' => $f[0], 'section' => 'rr_brand_section', 'type' => $f[2] ) );
		}

		foreach ( array( 'rr_logo_mark' => 'Header logo mark (small emblem)', 'rr_logo_lockup' => 'Footer logo lockup' ) as $key => $label ) {
			$wp_customize->add_setting( $key, array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					$key,
					array(
						'label'       => $label,
						'section'     => 'rr_brand_section',
						'description' => __( 'Leave empty to use the logo shipped with the theme.', 'realtor-raihan' ),
					)
				)
			);
		}

		/* ---------------- contact ---------------- */
		$wp_customize->add_section(
			'rr_contact_section',
			array(
				'title'       => __( '2. Contact details', 'realtor-raihan' ),
				'panel'       => 'rr_brand',
				'description' => __( 'Used by the header, the contact section, the footer and every call to action.', 'realtor-raihan' ),
			)
		);
		$contact = array(
			'rr_phone'     => array( 'Phone number (as shown)', '+971 52 102 7252' ),
			'rr_whatsapp'  => array( 'WhatsApp number (digits only, with country code)', '971521027252' ),
			'rr_email'     => array( 'Email address', 'hello@realtorraihan.com' ),
			'rr_area'      => array( 'Based in (shown in footer)', 'Business Bay, Dubai, UAE' ),
			'rr_agency'    => array( 'Agency line (used on articles)', 'Homes 4 Life Real Estate' ),
			'rr_social_ig' => array( 'Instagram URL (optional)', '' ),
			'rr_social_fb' => array( 'Facebook URL (optional)', '' ),
			'rr_social_li' => array( 'LinkedIn URL (optional)', '' ),
		);
		foreach ( $contact as $key => $f ) {
			$wp_customize->add_setting( $key, array( 'default' => $f[1], 'sanitize_callback' => 'sanitize_text_field' ) );
			$wp_customize->add_control( $key, array( 'label' => $f[0], 'section' => 'rr_contact_section', 'type' => 'text' ) );
		}

		/* ---------------- header ---------------- */
		$wp_customize->add_section(
			'rr_header_section',
			array(
				'title' => __( '3. Header buttons', 'realtor-raihan' ),
				'panel' => 'rr_brand',
			)
		);
		$head = array(
			'rr_call_label' => array( 'Small text above the phone number', 'Talk to me' ),
			'rr_cta_label'  => array( 'Gold button text', 'Book a Free Consultation' ),
			'rr_cta_url'    => array( 'Gold button link (empty = contact section)', '' ),
		);
		foreach ( $head as $key => $f ) {
			$wp_customize->add_setting( $key, array( 'default' => $f[1], 'sanitize_callback' => 'sanitize_text_field' ) );
			$wp_customize->add_control( $key, array( 'label' => $f[0], 'section' => 'rr_header_section', 'type' => 'text' ) );
		}

		/* ---------------- footer ---------------- */
		$wp_customize->add_section(
			'rr_footer_section',
			array(
				'title'       => __( '4. Footer', 'realtor-raihan' ),
				'panel'       => 'rr_brand',
				'description' => __( 'The footer is the same on every page. The link columns are fixed to match the approved design; the disclaimer, the new copyright line and the service locations are editable here.', 'realtor-raihan' ),
			)
		);
		$wp_customize->add_setting( 'rr_footer_disc', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
		$wp_customize->add_control(
			'rr_footer_disc',
			array(
				'label'   => __( 'Disclaimer line (leave empty for the default text)', 'realtor-raihan' ),
				'section' => 'rr_footer_section',
				'type'    => 'textarea',
			)
		);
		$wp_customize->add_setting( 'rr_footer_keywords', array( 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ) );
		$wp_customize->add_control(
			'rr_footer_keywords',
			array(
				'label'       => __( 'Service locations (one phrase per line, shown as small text in the footer)', 'realtor-raihan' ),
				'section'     => 'rr_footer_section',
				'type'        => 'textarea',
				'description' => __( 'Leave empty to use the built-in list of Dubai locations.', 'realtor-raihan' ),
			)
		);
		$wp_customize->add_setting( 'rr_footer_copyright', array( 'default' => '', 'sanitize_callback' => 'wp_kses_post' ) );
		$wp_customize->add_control(
			'rr_footer_copyright',
			array(
				'label'   => __( 'Copyright line', 'realtor-raihan' ),
				'section' => 'rr_footer_section',
				'type'    => 'text',
			)
		);

		/* ---------------- seo ---------------- */
		$wp_customize->add_section(
			'rr_seo_section',
			array(
				'title'       => __( '5. Home page search description', 'realtor-raihan' ),
				'panel'       => 'rr_brand',
				'description' => __( 'Shown by Google under the page title. WordPress SEO plugins can override this.', 'realtor-raihan' ),
			)
		);
		$wp_customize->add_setting( 'rr_meta_desc', array( 'default' => 'Raihan Shaikh is a property consultant in Dubai helping buyers, sellers and investors with honest numbers, clear advice and support from first call to handover.', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( 'rr_meta_desc', array( 'label' => __( 'Home meta description', 'realtor-raihan' ), 'section' => 'rr_seo_section', 'type' => 'textarea' ) );
	}
);
