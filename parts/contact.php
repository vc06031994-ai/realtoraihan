<?php
/**
 * Section 11: contact.
 *
 * The form posts to admin-post.php and the theme emails the enquiry, so the
 * client genuinely receives messages (no plugin needed). A honeypot field keeps
 * most spam out. All text is fully editable in WordPress.
 *
 * @package RealtorRaihan
 */

$sent  = isset( $_GET['enquiry'] ) && 'sent' === $_GET['enquiry']; // phpcs:ignore
$error = isset( $_GET['enquiry'] ) && 'error' === $_GET['enquiry']; // phpcs:ignore
$c     = rr_contact();
$phone_clean = preg_replace( '/[^0-9+]/', '', $c['phone'] );
$wa_clean    = preg_replace( '/[^0-9]/', '', $c['whatsapp'] );
?>
<section class="ct" id="contact" aria-labelledby="ct-title">
  <div class="ct__wrap">

    <!-- left -->
    <div class="ct__left">
      <p class="ct__eyebrow rv"><?php echo esc_html( $c['eyebrow'] ); ?></p>

      <?php rr_head_lines( $c['title'], 'ct-title' ); ?>

      <p class="ct__lede rv"><?php echo wp_kses_post( $c['lede'] ); ?></p>

      <div class="ct__rows rv">
        <a class="ct__row" href="tel:<?php echo esc_attr( $phone_clean ); ?>">
          <span class="ct__rowIco" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
          </span>
          <span class="ct__rowTx">
            <small><?php echo esc_html( $c['call_lbl'] ); ?></small>
            <span><?php echo esc_html( $c['phone'] ); ?></span>
          </span>
          <span class="ct__rowGo" aria-hidden="true"><?php echo rr_arrow(); // phpcs:ignore ?></span>
        </a>

        <a class="ct__row" href="https://wa.me/<?php echo esc_attr( $wa_clean ); ?>" target="_blank" rel="noopener">
          <span class="ct__rowIco" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 1.8a8.2 8.2 0 0 1 0 16.4 8.1 8.1 0 0 1-4.2-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 0 1 12 3.8Zm-3 4c-.2 0-.5.1-.7.3-.3.3-.8.8-.8 1.9s.8 2.1 1 2.2c.1.2 1.6 2.4 3.9 3.4 1.9.8 2.3.7 2.7.6.5 0 1.2-.5 1.4-1 .2-.5.2-.9.1-1l-.5-.3-1.4-.7c-.2-.1-.4-.1-.5.1l-.6.8c-.1.2-.3.2-.5.1-.2-.1-.9-.3-1.7-1a6.3 6.3 0 0 1-1.2-1.5c-.1-.2 0-.3.1-.4l.3-.4.2-.4v-.4l-.7-1.6c-.2-.4-.4-.4-.5-.4h-.5Z"/></svg>
          </span>
          <span class="ct__rowTx">
            <small><?php echo esc_html( $c['wa_lbl'] ); ?></small>
            <span><?php echo esc_html( $c['wa_sub'] ); ?></span>
          </span>
          <span class="ct__rowGo" aria-hidden="true"><?php echo rr_arrow(); // phpcs:ignore ?></span>
        </a>

        <a class="ct__row" href="mailto:<?php echo esc_attr( $c['email'] ); ?>">
          <span class="ct__rowIco" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="4.5" width="19" height="15" rx="2.5"/><path d="m3 6.5 9 6 9-6"/></svg>
          </span>
          <span class="ct__rowTx">
            <small><?php echo esc_html( $c['email_lbl'] ); ?></small>
            <span><?php echo esc_html( $c['email'] ); ?></span>
          </span>
          <span class="ct__rowGo" aria-hidden="true"><?php echo rr_arrow(); // phpcs:ignore ?></span>
        </a>

        
      </div>
    </div>

    <!-- right: form -->
    <div class="ct__card rv">
      <div class="ct__formHead">
        <h3><?php echo esc_html( $c['form_h'] ); ?></h3>
        <p><?php echo esc_html( $c['form_p'] ); ?></p>
      </div>

      <?php echo do_shortcode( '[contact-form-7 id="68" title="Contact form 1" html_id="ctForm" html_class="ct__form"]' ); ?>
    </div>

  </div>
</section>
