<?php

namespace Cau;

use Cau\CauCorreiosAutoUpdater;

class CauGetAllShippingIds extends CauCorreiosAutoUpdater
{

    public $arrOrders;

    public function init()
    {
        add_action('woocommerce_after_register_post_type', [$this, 'getAllProcessingOrders'], 10);
        add_action('woocommerce_after_register_post_type', [$this, 'setTrackingNumbers'], 11);
    }

    public function getAllProcessingOrders()
    {
        $args = [
        'post_type'      => 'shop_order',
        'post_status'    => 'wc-processing',
        'posts_per_page' => -1
          ];
          $orders = new \WP_Query($args);

          $arr = [];

        while ($orders->have_posts()) {
            $orders->the_post();

            $order = get_post(get_the_ID());

            if ($order->post_status === 'wc-processing') {
                $arr[] = get_the_ID();
            }
        }

        $this->arrOrders = $arr;
    }

    public function setTrackingNumbers()
    {
        foreach ($this->arrOrders as $orderID) {
            if (!empty(get_post_meta($orderID, '_correios_tracking_code')[0])) {
                self::$trackingNumbers[$orderID] = get_post_meta($orderID, '_correios_tracking_code')[0];
            }
        }
    }
}
