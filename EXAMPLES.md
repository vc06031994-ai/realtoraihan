# Customising this theme with plain HTML, CSS and JS

You do **not** need to be a PHP developer to work on this theme. The design is
plain HTML + CSS + JavaScript. PHP is only used as the "glue" that reads what the
client typed in WordPress and drops it into the HTML. There is no page builder, no
framework and no compiled step: what you edit is what the browser receives.

## Where each language lives

| Folder / file | Language | What it is |
|---|---|---|
| `assets/css/*.css` | **CSS** | The whole design. `base.css` holds colours, fonts and shared classes, `chrome.css` the header/footer, `home-*.css` one file per home section, `about.css`, `blog.css`, `post.css`. |
| `assets/js/*.js` | **JavaScript** | Sliders, accordion, carousel, filters, reveal animations. One file per section. |
| `parts/*.php` | **HTML + a little PHP** | The markup of each section. Roughly half of every file is untouched HTML; the PHP bits only print text coming from the dashboard, e.g. `<?php echo esc_html( rr_h( 'hero_tag' ) ); ?>`. |
| `page-templates/*.php`, `home.php`, `single.php` | HTML + little PHP | Page shells that pull the parts together. |
| `inc/*.php` | PHP only | Admin screens, Customizer fields, form handling. This is the only "WordPress plumbing". |

## The two files you will actually use

* **`assets/css/custom.css`** - loads **last** on every page. Any CSS you write
  here overrides the theme. Colours, fonts and corner radius are CSS variables,
  so most design changes are one line:

  ```css
  :root{
    --gold: #C9A227;        /* new accent colour, site-wide */
    --navy: #0A1B33;        /* new dark colour, site-wide    */
  }
  .hero h1{ font-size: clamp(2.6rem, 7.6vw, 6.8rem); }
  .ft__keys{ display: none; }   /* hide the footer keyword block */
  ```

* **`assets/js/custom.js`** - loads **last** on every page. Any script.
  The main `.js` files are never touched, so an update cannot wipe your work.

## Editing a section's HTML

Open `parts/services.php`. It looks like this (shortened):

```php
<a class="bento" href="<?php echo esc_url( $url ); ?>">
  <span class="bento__ghost"><?php echo esc_html( rr_num( $i + 1 ) ); ?></span>
  <div class="bento__body">
    <h3><?php echo esc_html( $row['title'] ); ?></h3>
    <p><?php echo wp_kses_post( $row['text'] ); ?></p>
  </div>
</a>
```

If you want fixed text instead of dashboard text, just write ordinary HTML:

```html
<a class="bento" href="#contact">
  <div class="bento__body">
    <h3>Sell Property</h3>
    <p>My own words, hard-coded.</p>
  </div>
</a>
```

The CSS class names are what style it. Keep them and the design keeps working.

## The only PHP you need to know

Four small functions cover almost everything:

| Function | What it does |
|---|---|
| `rr_h( 'key' )` | Prints a field from the Home Page admin screen |
| `rr_img( $value, 'fallback.webp' )` | Returns an image URL (dashboard image, or a file in `assets/img`) |
| `esc_html( ... )` | Safely prints text |
| `esc_url( ... )` | Safely prints a link |

Example you can copy: `<img src="<?php echo esc_url( rr_img( $row['photo'], 'gen-villa-evening.webp' ) ); ?>" alt="">`

## Adding a brand new page with your own HTML/CSS

1. Create `page-templates/landing.php`:

   ```php
   <?php
   /* Template Name: My landing page */
   get_header(); ?>
   <section class="my-landing">
     <h1>Anything you want</h1>
   </section>
   <?php get_footer();
   ```

2. Style it in `assets/css/custom.css`:

   ```css
   .my-landing{ padding: 120px 24px; background: var(--cream); }
   .my-landing h1{ font-family: var(--display); color: var(--navy); }
   ```

3. In WordPress: Pages > Add New > in the right sidebar pick **My landing page**
   as the template > Publish.

## Fonts and images

* Fonts are embedded files in `assets/fonts` (no Google Fonts request).
* Images ship in `assets/img`. Drop a new file there and use its name, or upload
  it in Media and paste the URL into the matching admin field.

## Rules of thumb

1. Style changes go in `custom.css`. Never edit the section CSS unless you want
   to change the design for good.
2. Scripts go in `custom.js`.
3. Markup changes go in `parts/*.php`; keep the `class` names.
4. Never edit `inc/*.php` unless you are adding an admin field.
