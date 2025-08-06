<?php
if (!defined('ABSPATH')) exit;

add_action('wp_head', 'fbpt_add_pixel_code');
function fbpt_add_pixel_code() {
    $pixel_id = esc_attr(get_option('Pixel_Id'));
    if (!$pixel_id) return;
    ?>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src='https://connect.facebook.net/en_US/fbevents.js';
        s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script');

        fbq('init', '<?php echo $pixel_id; ?>');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id=<?php echo $pixel_id; ?>&ev=PageView&noscript=1"/>
    </noscript>
    <?php
}
