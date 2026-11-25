<?php
/**
 * Menu walker that prints plain anchors, because the design's header and mobile
 * menu are not list based. Keeps the client free to use any menu structure.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flat anchor walker.
 */
class RR_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Start a menu level: nothing to open.
	 *
	 * @param string $output Output buffer.
	 * @param int    $depth  Depth.
	 * @param array  $args   Args.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {}

	/**
	 * Close a menu level.
	 *
	 * @param string $output Output buffer.
	 * @param int    $depth  Depth.
	 * @param array  $args   Args.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {}

	/**
	 * One anchor.
	 *
	 * @param string $output Output buffer.
	 * @param object $item   Menu item.
	 * @param int    $depth  Depth.
	 * @param array  $args   Args.
	 * @param int    $id     Item id.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$current = '';

		if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true ) ) {
			$current = ' aria-current="page"';
		}

		$style = '';
		if ( isset( $args->rr_index ) ) {
			$style = ' style="--i:' . (int) $args->rr_index . '"';
		}

		$output .= sprintf(
			'<a href="%1$s"%2$s%3$s>%4$s</a>',
			esc_url( $item->url ),
			$style,
			$current,
			esc_html( $item->title )
		);
	}

	/**
	 * Nothing to close.
	 *
	 * @param string $output Output buffer.
	 * @param object $item   Menu item.
	 * @param int    $depth  Depth.
	 * @param array  $args   Args.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}
