<?php

if (!defined('ABSPATH')) {
    exit;
}

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;
use Automattic\WooCommerce\Blocks\Payments\PaymentMethodTypeInterface;

final class HAM3INFO_OxaPay_Payments_Block extends AbstractPaymentMethodType {

    private $gateway;
    public $name = HAM3INFO_OxaPay_GID;

    public function initialize() {
        $trns = [__("Proceed to OxaPay", "ham3da-integration-for-oxapay-in-woocommerce"), __("OxaPay", "ham3da-integration-for-oxapay-in-woocommerce"), __("Payment via OxaPay", "ham3da-integration-for-oxapay-in-woocommerce")];
        $this->gateway = new HAM3INFO_OxaPay_Gateway();
        $this->settings = get_option('woocommerce_' . HAM3INFO_OxaPay_GID . '_settings');
    }

    public function is_active() {
        return $this->gateway->is_available();
    }

    public function get_payment_method_script_handles() {

        wp_register_script(
                'HAM3INFO_OxaPay_PAYMENTS_BLOCKS_INTEGRATION',
                plugins_url('assets/block.js', HAM3INFO_OxaPay_PLUGIN_FILE),
                array('wc-blocks-registry', 'wc-settings', 'wp-element'),
                HAM3INFO_OxaPay_PLUGIN_VER,
                true
        );

        return ['OxaPay_PAYMENTS_BLOCKS_INTEGRATION'];
    }

    public function get_payment_method_data() {
        return array(
            'id' => $this->gateway->id,
            'title' => $this->gateway->title,
            'description' => $this->gateway->description,
            'icon'=>  $this->gateway->icon,
            'OrderButtonLabel'=> $this->gateway->order_button_text,
            'enabled' => $this->gateway->is_available(),
            'pluginUrl' => HAM3INFO_OxaPay_PLUGIN_URL,
            'supports' => $this->get_supported_features(),
        );
    }
}