<?php
/**
* Plugin Name: Auto Coupons for WooCommerce
* Description: Generate unique coupon codes for Woocommerce automatically.
* Version:     1.0
* Author:      ahuseyn
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: auto-coupons-woo
*/

/* Don't allow direct access to plugin file */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* Load plugin page after WordPress fully loaded */
add_action( 'wp_loaded', 'aucfwc_check_woo_and_start' );

function aucfwc_check_woo_and_start() {

    /* Check if WooCommerce installed and activated */
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

        /* Get admin subpage */
        require_once( plugin_dir_path( __FILE__ ) . 'admin.php' );
        
        add_action( 'wp_ajax_aucfwc_run_gen', 'aucfwc_run_gen' );

        function aucfwc_run_gen() {

            check_ajax_referer( 'aucfwc_run_nonce', 'security' );

            $couname = sanitize_text_field( $_POST["couname"] );
            $couamount = intval( $_POST["couamount"] );
            $discount = intval( $_POST["discount"] );
            $ulimit = intval( $_POST["ulimit"] );
            $ulimitperu = intval( $_POST["ulimitperu"] );
            $minamount = intval( $_POST["minamount"] );
            $maxamount = intval( $_POST["maxamount"] );
            $expiry = preg_replace("([^0-9-])", "", $_POST["expiry"]);

            if ( isset( $_POST["friship"] ) ) {
                $friship = 'yes';
            } else {
                $friship = 'no';
            }

            if ( isset( $_POST["individ"] ) ) {
                $individ = 'yes';
            } else {
                $individ = 'no';
            }

            if ( isset( $_POST["exsale"] ) ) {
                $exsale = 'yes';
            } else {
                $exsale = 'no';
            }

            if ( $_POST["coutype"] == 1 ) {
                $coutype = 'fixed_cart';
            } elseif ( $_POST["coutype"] == 2 ) {
                $coutype = 'percent';
            } else {
                $coutype = 'fixed_product';
            }
            
            $uniquenom = uniqid($couname);

            $x = 0;

            while ( $x < $couamount ) {

                $coupon = array(
                    'post_title' => $uniquenom,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_type'		=> 'shop_coupon'
                );

                $new_coupon_id = wp_insert_post( $coupon );

                update_post_meta( $new_coupon_id, 'discount_type', $coutype );
                update_post_meta( $new_coupon_id, 'coupon_amount', $discount );
                update_post_meta( $new_coupon_id, 'usage_limit', $ulimit );
                update_post_meta( $new_coupon_id, 'usage_limit_per_user', $ulimitperu );
                update_post_meta( $new_coupon_id, 'minimum_amount', $minamount );	
                update_post_meta( $new_coupon_id, 'expiry_date', $expiry );
                update_post_meta( $new_coupon_id, 'individual_use', $individ );
                update_post_meta( $new_coupon_id, 'free_shipping', $friship );
                update_post_meta( $new_coupon_id, 'exclude_sale_items', $exsale );
                update_post_meta( $new_coupon_id, 'maximum_amount', $maxamount );

                $x++;

            }

            wp_die(); // this is required to terminate immediately and return a proper response
        }
        
    } else {
        
        /* Post notification on admin dashboard if WooCommerce not found */
        function aucfwc_woo_err_notice() {

            $note = __( 'WooCommerce Not Found! Auto Coupons for WooCommerce cannot run without WooCommerce.', 'auto-coupons-woo' );
            
            printf( '<div class="notice notice-error"><p>%1$s</p></div>', esc_html( $note ) ); 
        
        }
        add_action( 'admin_notices', 'aucfwc_woo_err_notice' );
    }
}
