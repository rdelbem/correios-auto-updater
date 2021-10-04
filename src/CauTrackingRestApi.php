<?php

namespace Cau;

defined('ABSPATH') || die();

use Cau\CauCorreiosAutoUpdater;

/**
 * This class cares for the external api calls and update the tracking
 * history of each processing item, that has a tracking number
 */
class CauTrackingRestApi extends CauCorreiosAutoUpdater
{

    /**
     * Initiate class through an add_action and a hook
     *
     * @return void
     */
    public function init()
    {
        add_action('woocommerce_after_register_post_type', [$this, 'callApi'], 13);
    }

    /**
     * Calls correios api
     *
     * @return void
     */
    public function callApi()
    {
        $trackingNumbers = $this->getTrackingNumbers();
        $response = [];

        foreach ($trackingNumbers as $id => $trackingNumber) {
            $call = wp_remote_get(CORREIOS_URL . $trackingNumber);
            $call = json_decode($call['body']);

            if (isset($call->objetos[0]->eventos)) {
                //last log entry of the shipping history
                $response[$id] = $call->objetos[0]->eventos[0]->descricao;
            }
        }

        $this->setOrdersAndTrackings($response);
    }

    /**
     * Orders and trackings setter
     *
     * @param array $arrOrdersAndTracking
     * @return array
     */
    public function setOrdersAndTrackings($arrOrdersAndTracking)
    {
        return self::$ordersAndTracking = $arrOrdersAndTracking;
    }
}
