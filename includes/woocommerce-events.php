<?php
if (!defined('ABSPATH')) exit;

add_action('woocommerce_thankyou', 'Purchase_Event');
//function
function Purchase_Event($order_id) {

    global $wpdb;
     //create the payload
    $table_name = $wpdb->prefix . 'fbpt_event_logs';
    $event_name = 'Purchase';
    $event_date = current_time('Y-m-d');
    //
    //insert the data
      $wpdb->insert(
        $table_name,
        [
            'event_name' => $event_name,
            'order_id'   => $order_id,
            'event_date' => $event_date
        ]
    );
    //
    $pixel_id = esc_attr(get_option('Pixel_Id'));
    if (!$pixel_id || !$order_id) return;

    $order = wc_get_order($order_id);
    $total = $order->get_total();
    $currency = get_woocommerce_currency();

    $items = array();
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        $items[] = array(
            'id' => $product->get_id(),
            'name' => $product->get_name(),
            'quantity' => $item->get_quantity(),
            'price' => $product->get_price()
        );
    }

    $items_json = json_encode($items);
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof fbq !== 'undefined') {
                fbq('track', 'Purchase', {
                    value: <?php echo esc_js($total); ?>,
                    currency: '<?php echo esc_js($currency); ?>',
                    contents: <?php echo $items_json; ?>,
                    content_type: 'product'
                });
            }
        });
    </script>
    <?php
}
