<?php
/**
 * Small amount of CSS for the WordPress-only surfaces (page template, article
 * body produced by the editor, pagination and the newsletter note). It reuses
 * the theme tokens so a page written in the editor still looks like the site.
 *
 * @package RealtorRaihan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rr_inline_css() {
	$css = <<<'CSS'
body.rr-wp{background:var(--cream)}
/* keep the fixed bar from covering the top of non-hero pages */
.rr-page{padding-top:calc(var(--barh,0px) + clamp(40px,6vw,80px));padding-bottom:clamp(50px,7vw,90px)}
.rr-page__head{padding-bottom:clamp(26px,3vw,40px)}
.rr-page__head h1{font-family:var(--display);font-size:clamp(2rem,4.4vw,3.4rem);
  line-height:1.06;letter-spacing:-.03em;color:var(--navy);margin:14px 0 0;max-width:22ch}
.rr-page__body{color:var(--ink);font-size:1.02rem;line-height:1.75;max-width:760px}
.rr-page__body h2,.rr-page__body h3,.rr-page__body h4{font-family:var(--display);
  color:var(--navy);letter-spacing:-.02em;line-height:1.15;margin:1.6em 0 .5em}
.rr-page__body h2{font-size:clamp(1.4rem,2.4vw,1.9rem)}
.rr-page__body h3{font-size:clamp(1.15rem,1.9vw,1.4rem)}
.rr-page__body p{margin:0 0 1.1em}
.rr-page__body a{color:var(--navy);text-decoration:underline;text-underline-offset:3px}
.rr-page__body a:hover{color:var(--gold)}
.rr-page__body img{border-radius:var(--r-lg);height:auto;max-width:100%}
.rr-page__body blockquote{border-left:3px solid var(--gold);margin:1.6em 0;padding:4px 0 4px 20px;
  font-family:var(--display);font-size:1.15rem;color:var(--navy)}
.rr-page__body ul,.rr-page__body ol{padding-left:1.2em;margin:0 0 1.1em}
.rr-page__body li{margin:.35em 0}
.rr-fallback-h{font-family:var(--display);color:var(--navy)}

/* FAQ page: expand the reading column */\nbody.page-id-138 .rr-page__body{max-width:1400px!important;width:100%!important}\nbody.page-id-138 .rr-page__body > *{max-width:100%}\n/* article body written in the editor */
.rr-article .po-body__wrap{font-size:1.02rem;color:var(--ink)}
.rr-article .po-body__wrap h2{font-family:var(--display);color:var(--navy);
  font-size:clamp(1.35rem,2.3vw,1.8rem);letter-spacing:-.02em;margin:1.7em 0 .5em}
.rr-article .po-body__wrap h3{font-family:var(--display);color:var(--navy);
  font-size:clamp(1.12rem,1.8vw,1.3rem);margin:1.4em 0 .4em}
.rr-article .po-body__wrap p{margin:0 0 1.1em;line-height:1.78}
.rr-article .po-body__wrap a{color:white;text-decoration:underline;text-underline-offset:3px}
.rr-article .po-body__wrap img{border-radius:16px;height:auto;max-width:100%;margin:1.2em 0}
.rr-article .po-body__wrap blockquote{font-family:var(--display);font-size:1.24rem;line-height:1.4;
  color:var(--navy);border-left:3px solid var(--gold);padding:6px 0 6px 22px;margin:1.7em 0}
.rr-article .po-body__wrap ul,
.rr-article .po-body__wrap ol{padding-left:1.15em;margin:0 0 1.15em}
.rr-article .po-body__wrap li{margin:.4em 0;line-height:1.7}
.rr-article .po-body__wrap strong{color:var(--navy)}
.po-pages{margin:26px 0;display:flex;gap:10px;font-family:var(--display)}

/* pagination */
.bl-pager .nav-links{display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:clamp(30px,4vw,50px)}
.bl-pager .page-numbers{padding:9px 15px;border-radius:999px;border:1px solid rgba(11,31,58,.18);
  color:var(--navy);text-decoration:none;font-size:.84rem;transition:background .3s,color .3s}
.bl-pager .page-numbers.current,.bl-pager .page-numbers:hover{background:var(--navy);color:#fff;border-color:var(--navy)}

/* newsletter note */
#blNote.is-done{color:var(--gold)}
CSS;
	return $css;
}
add_action(
	'wp_head',
	function () {
		echo "<style id=\"rr-inline-css\">\n" . rr_inline_css() . "\n</style>\n"; // phpcs:ignore
	},
	20
);
