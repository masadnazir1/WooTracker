<?php
if (!defined('ABSPATH')) exit;

//

function fbpt_render_event_log_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'fbpt_event_logs';

    // Get date filter from input
    $filter_date = isset($_GET['filter_date']) ? sanitize_text_field($_GET['filter_date']) : '';

    // Query with or without date filter
    if ($filter_date) {
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT event_date, COUNT(*) as total 
             FROM $table_name 
             WHERE event_date = %s 
             GROUP BY event_date 
             ORDER BY event_date DESC",
            $filter_date
        ));
    } else {
        $results = $wpdb->get_results("
            SELECT event_date, COUNT(*) as total 
            FROM $table_name 
            GROUP BY event_date 
            ORDER BY event_date DESC
        ");
    }

    echo '<div class="wrap">';
    echo '<h2>FB Pixel Event Logs</h2>';

    // Date Filter Form
    echo '<form method="get" style="margin-bottom: 20px;">';
    echo '<input type="hidden" name="page" value="fbpt-logs" />';
    echo '<label for="filter_date">Filter by Date: </label>';
    echo '<input type="date" id="filter_date" name="filter_date" value="' . esc_attr($filter_date) . '" />';
    echo '<input type="submit" class="button" value="Filter" />';
    echo ' <a href="' . admin_url('options-general.php?page=fbpt-logs') . '" class="button-secondary">Reset</a>';
    echo '</form>';

    // Table
    echo '<table class="widefat"><thead><tr><th>Date</th><th>Total Purchases</th></tr></thead><tbody>';

    if ($results) {
        foreach ($results as $row) {
            echo "<tr><td>{$row->event_date}</td><td>{$row->total}</td></tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No events logged" . ($filter_date ? " for {$filter_date}" : '') . ".</td></tr>";
    }

    echo '</tbody></table></div>';
}


function fbpt_add_event_log_menu() {
    add_submenu_page(
        'options-general.php',
        'FB Pixel Logs',
        'FB Pixel Logs',
        'manage_options',
        'fbpt-logs',
        'fbpt_render_event_log_page'
    );
}


//

// Add menu
add_action('admin_menu', 'fbpt_create_menu');
function fbpt_create_menu() {
    add_options_page(
        'FB Pixel Tracker Settings',
        'FB Pixel Tracker',
        'manage_options',
        'fbpt-settings',
        'fbpt_settings_page'
    );

    fbpt_add_event_log_menu();
}

//
wp_enqueue_style(
    'fbpt_admin_css',
    plugin_dir_url(__FILE__) . '../css/admin-style.css',
    array(),
    '1.0'
);


// Register setting
add_action('admin_init', 'fbpt_register_settings');
function fbpt_register_settings() {
    register_setting('fbpt_settings_group', 'Pixel_Id');
}

// Settings Page UI
function fbpt_settings_page() {
    ?>
    <div class="wrap">
        <span>
             <h1>Facebook Pixel Tracker</h1>
              <p>By</p>
            <img src="https://www.galaxydev.pk/assets/images/logo.svg" alt="Galaxydev.pk" class="DevLogo"/>
        </span>

         
        
       
        <form method="post" action="options.php">
            <?php settings_fields('fbpt_settings_group'); ?>
            <?php do_settings_sections('fbpt_settings_group'); ?>
            <table class="form-table">
              
                    <td class="BoxInput">
                        <label>Please enter you facebook pixel ID below</label>
                        <input type="text" name="Pixel_Id" value="<?php echo esc_attr(get_option('Pixel_Id')); ?>" style="width: 300px;" />
                    </td>
              
            </table>
            <?php submit_button('Save Your Pixel'); ?>
        </form>
    </div>
    <?php
}
