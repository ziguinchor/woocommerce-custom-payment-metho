<?php
class Global_Checkout_Gateway extends WC_Payment_Gateway
{

  // Constructor method
  public function __construct()
  {
    $this->id = 'global_checkout_gateway';
    $this->method_title = __('Global Checkout', 'global-checkout-gateway');
    $this->method_description = __('Accept payments through Global Checkout', 'global-checkout-gateway');

    // Other initialization code goes here

    $this->init_form_fields();
    $this->init_settings();

    add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
  }

  public function init_form_fields()
  {
    $this->form_fields = array(
      'enabled' => array(
        'title' => __('Enable/Disable', 'global-checkout-gateway'),
        'type' => 'checkbox',
        'label' => __('Enable Global Checkout Gateway', 'global-checkout-gateway'),
        'default' => 'yes',
      ),
      // Add more settings fields as needed
    );
  }

  // Process the payment
  public function process_payment($order_id)
  {
    $order = wc_get_order($order_id);

    // Implement your payment processing logic here

    // Mark the order as processed
    $order->payment_complete();

    // Redirect to the thank you page
    return array(
      'result' => 'success',
      'redirect' => $this->get_return_url($order),
    );
  }

}
?>