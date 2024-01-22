<?php
class Global_Checkout_Gateway extends WC_Payment_Gateway
{

  // Constructor method
  public function __construct()
  {
    $this->id = 'global_checkout_gateway';
    $this->method_title = __('Global Checkout', 'global-checkout-gateway');
    $this->method_description = __('Accept payments through Global Checkout', 'global-checkout-gateway');


    $this->has_fields = false;
    $this->method_title = __('Global Checkout', 'global-checkout-gateway');
    $this->method_description = __('Accept payments through Global Checkout', 'global-checkout-gateway');

    $this->title = $this->get_option('title');
    $this->description = $this->get_option('description');
    $this->instructions = $this->get_option('instructions', $this->description);

    // Other initialization code goes here

    $this->init_form_fields();
    $this->init_settings();

    add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
  }

  public function init_form_fields()
  {
    $this->form_fields = apply_filters(
      'global_checkout_fields',
      array(
        'enabled' => array(
          'title' => __('Enable/Disable', 'global-checkout-gateway'),
          'type' => 'checkbox',
          'label' => __('Enable or Disable Global Checkout', 'global-checkout-gateway'),
          'default' => 'no'
        ),
        'title' => array(
          'title' => __('Global Checkout Gateway', 'global-checkout-gateway'),
          'type' => 'text',
          'default' => __('Global Checkout Gateway', 'global-checkout-gateway'),
          'desc_tip' => true,
          'description' => __('Add a new title for the Global Checkout Gateway that customers will see when they are in the checkout page.', 'global-checkout-gateway')
        ),
        'description' => array(
          'title' => __('Global Checkout Gateway Description', 'global-checkout-gateway'),
          'type' => 'textarea',
          'default' => __('Please remit your payment to the shop to allow for the delivery to be made', 'global-checkout-gateway'),
          'desc_tip' => true,
          'description' => __('Add a new title for the Global Checkout Gateway that customers will see when they are in the checkout page.', 'global-checkout-gateway')
        ),
        'instructions' => array(
          'title' => __('Instructions', 'global-checkout-gateway'),
          'type' => 'textarea',
          'default' => __('Default instructions', 'global-checkout-gateway'),
          'desc_tip' => true,
          'description' => __('Instructions that will be added to the thank you page and odrer email', 'global-checkout-gateway')
        ),
        // 'enable_for_virtual' => array(
        //     'title'   => __( 'Accept for virtual orders', 'woocommerce' ),
        //     'label'   => __( 'Accept COD if the order is virtual', 'woocommerce' ),
        //     'type'    => 'checkbox',
        //     'default' => 'yes',
        // ),
      )
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