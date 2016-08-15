<?php
/**
 * Plugin Name: PayPal Button Shortcode
 * Plugin URI: shannongold@gmail.com
 * Description: Paypal shortcode with Attributes
 * Version: 1.0.0
 * Author: Shannon Gold
 * Author URI: http://shannongold.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /lang
 * Text Domain: paypal-button-shortcode
 */

// Generates the markup for the shortcode on the public site.


function paypal_button_shortcode( $atts ) {
        $options = get_option( 'paypal_button_options' );
        $atts = shortcode_atts(
            array(
                'amount' => '0',
                'event' => 'Event',
                'currency' => 'USD',
            ),
            $atts
        );
        extract( $atts );
    
        return 'Pay Here Using PayPal
                <form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="image" src="' . plugins_url( 'images/paypal_btn.png', __FILE__ ) . '" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                <input type="hidden" name="add" value="1">
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="business" value="' . $options['paypal_user_id'] . '">
                                <input type="hidden" name="item_name" value="' . $event . '">
                                <input type="hidden" name="amount" value="' . $amount . '">
                                <input type="hidden" name="no_shipping" value="0">
                                <input type="hidden" name="logo_custom" value="http://www.manhattanhomesinc.com/WTCI/page1/files/page0_8.gif">
                                <input type="hidden" name="no_note" value="1">
                                <input type="hidden" name="currency_code" value="USD">
                                <input type="hidden" name="lc" value="US">
                                <input type="hidden" name="bn" value="PP-ShopCartBF">
                </form>';
}
add_shortcode( 'paypal', 'paypal_button_shortcode' );



// Generates the markup for the PayPal user id.

function paypal_button_user_id() {
 
    $options = get_option( 'paypal_button_options' );
 
    echo "<input name='paypal_button_options[paypal_user_id]' type='email' value='{$options['paypal_user_id']}'/>";
}


// Registers settings page and fields.

function paypal_button_register_settings() {
 
    register_setting( 'paypal_button_settings', 'paypal_button_options' );
 
    add_settings_section( 'paypal_button_section', '', null, __FILE__ );
 
    add_settings_field( 'paypal_user_id', __( 'PayPal Id', 'paypal-buy-now-button-shortcode' ),'paypal_button_user_id', __FILE__, 'paypal_button_section' );
}

add_action( 'admin_init', 'paypal_button_register_settings' );


// Generates the markup for the options page.

function paypal_button_options_page() {
 
    ?>
    <div class="wrap">
        <h2><?php _e( 'PayPal Button Shortcode Settings', 'paypal-button-shortcode' ); ?></h2>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
 
            settings_fields( 'paypal_button_settings' );
 
            do_settings_sections( __FILE__ );
 
            ?>
            <p class="submit">
                <input type="submit" class="button-primary" name="submit" value="<?php _e( 'Save Changes', 'paypal-button-shortcode' ); ?>">
            </p>
        </form>
    </div>
    <?php
 
}

//  Adds menu item to the settings.

function paypal_button_add_settings_menu() {
 
    $title = __( 'PayPal Button Shortcode', 'paypal-button-shortcode' );
 
    add_options_page( $title, $title, 'administrator', __FILE__, 'paypal_button_options_page');
}
 
add_action( 'admin_menu', 'paypal_button_add_settings_menu' );
