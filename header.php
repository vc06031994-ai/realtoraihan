<?php
/**
 * Document head and opening body, the shared header bar and mobile menu.
 *
 * @package RealtorRaihan
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<link rel="preload" href="<?php echo esc_url( RR_URI . '/assets/fonts/vend-sans-latin.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?php echo esc_url( RR_URI . '/assets/fonts/zalando-sans-latin.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php get_template_part( 'parts/header' ); ?>
