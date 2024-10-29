<?php

/* Don't allow direct access to plugin file */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* Setup admin area subpage under Woocommerce menu */
function aucfwc_admin_subpage_register() {
    add_submenu_page(
        'woocommerce',
        'Auto Coupon for WooCommerce',
        'Auto Coupon',
        'manage_woocommerce',
        'woo-auto-coupon',
        'aucfwc_admin_subpage_contents' 
    );
}
add_action('admin_menu', 'aucfwc_admin_subpage_register');

/* This function includes admin page contents */
function aucfwc_admin_subpage_contents() {

?>

<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()); ?></h1>

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="couname"><?php esc_html_e( 'Coupon prefix', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="couname" type="text" id="couname" value="<?php esc_attr_e( 'coupon-', 'auto-coupons-woo' ) ?>" class="regular-text">
                    <p class="description" id="tagline-description"><?php esc_html_e( 'Optional prefix that comes before unique code.', 'auto-coupons-woo' ) ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="expiry"><?php esc_html_e( 'Coupon expiry date', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="expiry" type="date" id="expiry">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="coutype"><?php esc_html_e( 'Discount type', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <select name="coutype" id="coutype">
                        <option value="1"><?php esc_html_e( 'Fixed Cart', 'auto-coupons-woo' ) ?></option>
                        <option value="2"><?php esc_html_e( 'Percentage', 'auto-coupons-woo' ) ?></option>
                        <option value="3"><?php esc_html_e( 'Fixed Product', 'auto-coupons-woo' ) ?></option>
                    </select>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="couamount"><?php esc_html_e( 'Coupon amount', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="couamount" type="number" id="couamount" value="1" class="small-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="discount"><?php esc_html_e( 'Value of coupon', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="discount" type="number" id="discount" value="1" class="small-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="ulimit"><?php esc_html_e( 'Usage limit per coupon', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="ulimit" type="number" id="ulimit" value="1" class="small-text">
                    <p class="description" id="tagline-description"><?php esc_html_e( 'How many times this coupon can be used before it is void.', 'auto-coupons-woo' ) ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="ulimitperu"><?php esc_html_e( 'Usage limit per user', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="ulimitperu" type="number" id="ulimitperu" value="1" class="small-text">
                    <p class="description" id="tagline-description"><?php esc_html_e( 'How many times this coupon can be used by an individual user. Uses billing email for guests, and user ID for logged in users.', 'auto-coupons-woo' ) ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="minamount"><?php esc_html_e( 'Minimum spend', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="minamount" type="number" id="minamount" value="1" class="small-text">
                    <p class="description" id="tagline-description"><?php esc_html_e( 'This field allows you to set the minimum spend (subtotal) allowed to use the coupon.', 'auto-coupons-woo' ) ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="maxamount"><?php esc_html_e( 'Maximum spend', 'auto-coupons-woo' ) ?></label>
                </th>
                <td>
                    <input name="maxamount" type="number" id="maxamount" value="1" class="small-text">
                    <p class="description" id="tagline-description"><?php esc_html_e( 'This field allows you to set the maximum spend (subtotal) allowed when using the coupon.', 'auto-coupons-woo' ) ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php esc_html_e( 'Individual use', 'auto-coupons-woo' ) ?></th>
                <td>
                    <fieldset>
                        <label for="individ">
                            <input name="individ" type="checkbox" id="individ" value="1"><?php esc_html_e( ' Check this box if the coupon cannot be used in conjunction with other coupons.', 'auto-coupons-woo' ) ?></label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php esc_html_e( 'Allow free shipping', 'auto-coupons-woo' ) ?></th>
                <td>
                    <fieldset>
                        <label for="friship"><input name="friship" type="checkbox" id="friship" value="1"><?php esc_html_e( ' Check this box if the coupon grants free shipping. A free shipping method must be enabled in your shipping zone and be set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).', 'auto-coupons-woo' ) ?></label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row"><?php esc_html_e( 'Exclude sale items', 'auto-coupons-woo' ) ?></th>
                <td>
                    <fieldset>
                        <label for="exsale">
                            <input name="exsale" type="checkbox" id="exsale" value="1"><?php esc_html_e( 'Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.', 'auto-coupons-woo' ) ?></label>
                    </fieldset>
                </td>
            </tr>

        </tbody>
    </table>

    <p class="submit">
        <input type="submit" name="submit" id="coucreate" class="button button-primary" value="<?php esc_attr_e( 'Create', 'auto-coupons-woo' ) ?>">
        <b id="cou-done" style="padding-left: 10px; display: none;"><?php esc_html_e( 'Done!', 'auto-coupons-woo' ) ?></b>
    </p>
</div>

<script>
    (function($) {
        'use strict';

        $("#coucreate").click(function(e) {
            e.preventDefault();

            var couamount = $("#couamount").val();
            var couname = $("#couname").val();
            var discount = $("#discount").val();
            var ulimit = $("#ulimit").val();
            var ulimitperu = $("#ulimitperu").val();
            var minamount = $("#minamount").val();
            var coutype = $("#coutype").val();
            var expiry = $("#expiry").val();
            var maxamount = $("#maxamount").val();
            var friship = $('#friship:checked').val();
            var individ = $('#individ:checked').val();
            var exsale = $('#exsale:checked').val();

            var crtAgain = "<?php esc_html_e( 'Create again', 'auto-coupons-woo' ) ?>";
            var plsWait = "<?php esc_html_e( 'Please wait...', 'auto-coupons-woo' ) ?>";
            var nonceVal = "<?php echo wp_create_nonce( "aucfwc_run_nonce" ); ?>";

            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'aucfwc_run_gen',
                    security: nonceVal,
                    couamount: couamount,
                    couname: couname,
                    discount: discount,
                    ulimit: ulimit,
                    ulimitperu: ulimitperu,
                    minamount: minamount,
                    coutype: coutype,
                    friship: friship,
                    individ: individ,
                    expiry: expiry,
                    exsale: exsale,
                    maxamount: maxamount
                },
                type: 'POST',
                beforeSend: function() {
                    $("#coucreate").val(plsWait).attr("disabled", true);
                },
                success: function(data, status) {
                    $("#cou-done").show();
                    $("#coucreate").val(crtAgain).attr("disabled", false);
                }
            });

        });
    })(jQuery);

</script>

<?php
}
