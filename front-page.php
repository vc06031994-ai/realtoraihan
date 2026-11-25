<?php
/**
 * Front page. Uses the same renderer as the "Home page" template so there is
 * exactly one place that decides the section order.
 *
 * @package RealtorRaihan
 */

get_header();

rr_render_home_sections();

get_footer();
