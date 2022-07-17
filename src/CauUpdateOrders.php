<?php

namespace Cau;

defined('ABSPATH') || die();

use Cau\CauCorreiosAutoUpdater;

/**
 * It cares for the updating of delivered parcels
 */
class CauUpdateOrders extends CauCorreiosAutoUpdater
{
    /**
     * This method updates the post_status of each delivered item
     *
     * @return void
     */
    public function update()
    {
        if (!isset(self::$ordersAndTracking)) {
            return;
        }

        foreach (self::$ordersAndTracking as $id => $status) {
            if (isset($status) && $status === DELIVERED) {
                $order = wc_get_order($id);
                if ($order->get_status() === 'processing') {
                    $order->update_status('completed');
                }
            }
        }
    }
}
