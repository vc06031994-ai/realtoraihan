=== Realtor Raihan ===
Contributors: Realtor Raihan
Requires at least: WordPress 6.0
Tested up to: 7.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A custom WordPress theme for Raihan Shaikh, property consultant in Business Bay, Dubai.

== What this theme is ==

This is a purpose-built theme, not a page builder. The design, the fonts, the
photos and the copy that were approved are all inside the theme, and the client
can change every piece of text and every photo from the normal WordPress
dashboard.

== Install ==

1. WordPress dashboard > Appearance > Themes > Add New > Upload Theme.
2. Choose realtor-raihan.zip and click Install, then Activate.
3. On activation the theme creates the pages it needs (Home, About, Blog,
   Contact) and sets Home as the front page and Blog as the posts page.
4. Go to Tools > Realtor Raihan demo and click "Import demo articles" to load
   the six approved blog articles with their images.
5. Check Settings > Reading: Front page shows "Home", Posts page shows "Blog".

== Editing Home and About from the page itself ==

Open Pages > Home > Edit (or About > Edit) and the page opens on the classic
screen with a "Content of this page" box holding every field of that page,
grouped in the same order as the website: hero, introduction, stats, services,
testimonials, FAQ, contact, and for About: banner, sections, points, closing.

Change any box and press Update. The website changes immediately, and a
"Page content saved" notice confirms it with a link to the result.

Repeatable cards (service cards, testimonials, FAQ, the About points) are edited
as text blocks: "Title | the rest of the text". Leave a block empty to delete
that card. Photos, links, section switches and card order live in the full
screen editor, linked at the top of the box and in the left menu.

The page body itself is kept in sync as readable text, so the page is never
empty when opened, and the Blog page explains that it lists posts automatically.

== Where to edit what ==

* Home Page (left menu)
  Every heading, paragraph, button label, stat, service card, testimonial,
  FAQ and section on/off switch. Clear a field to go back to the approved copy.

* Home Page > About page
  The whole About page: banner title, both paragraphs, pull quote, the four
  points, photo badge and the closing call to action.

* Appearance > Customize > Realtor Raihan - Site settings
  1. Brand and logo (name, sub line, header mark, footer lockup)
  2. Contact details (phone, WhatsApp, email, area, agency, social links)
  3. Header buttons (the small label, the gold button text and link)
  4. Footer (disclaimer, copyright line, service locations list)
  5. Home page search description

* Posts
  Add or edit blog articles. The featured image becomes the article's hero.

* Pages
  Add a new page for anything else (Privacy Policy, Terms). It renders inside
  the same header and footer.

* Appearance > Menus
  Create a menu and assign it to "Primary menu (header)" to replace the default
  Home / About / Blog / Contact menu. Until then the default menu is used.

== Contact form and newsletter ==

The contact form and the newsletter box post to WordPress itself; no plugin is
needed. Each enquiry is:

  1. emailed to the address in Customizer > Contact details, and
  2. stored under Home Page > Enquiries, with an "Emailed" column.

If the host has not enabled PHP mail yet, the message is still stored and the
Emailed column shows a dash. Enabling PHP mail, or installing any SMTP plugin,
is enough to start delivering them. Newsletter signups are stored in the
"rr_subscribers" option and emailed to the same address.

== Editing the code yourself (HTML / CSS / JS) ==

You do not need PHP to change this theme. See EXAMPLES.md for the long version.

  assets/css/custom.css   your CSS, loaded last on every page, wins over the theme
  assets/js/custom.js     your JavaScript, loaded last on every page
  assets/css/*.css        the design itself, one file per section
  assets/js/*.js          one script per section (slider, accordion, filters...)
  parts/*.php             the HTML of each section with a few PHP print calls

Colours, fonts and corner radius are CSS variables in base.css, so most design
changes are one line inside custom.css:

  :root{ --gold: #C9A227; }

== Photos ==

All photos ship inside the theme (assets/img) so the site works straight away.
To swap one, upload your own under Media, copy its URL, and paste it into the
matching field (Home Page, About page or the Customizer). Bare file names such
as "skyline-dusk-wide.webp" also work and point at the bundled image.

== Type ==

Vend Sans (display) and Zalando Sans (body) are embedded in the theme, so no
Google Fonts request is made and nothing depends on a third party service.
