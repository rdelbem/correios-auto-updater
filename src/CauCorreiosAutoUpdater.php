<?php

namespace Cau;

defined('ABSPATH') || die();

use Cau\CauWoocommerceSettings;
use Cau\CauGetAllShippingIds;
use Cau\CauTrackingRestApi;
use Cau\CauUpdateOrders;

/**
 * Main class, it instantiate and load the vatious classes that make this plugin work
 */
class CauCorreiosAutoUpdater
{

    /**
     * Array containing all the tracking numbers
     *
     * @var array
     */
    public static $trackingNumbers;

    /**
     * Array containing all the orders Ids and its corresponding tracking status
     *
     * @var array
     */
    public static $ordersAndTracking;

    /**
     * Woocommerce settings for this plugin
     *
     * @var object
     */
    public $cauAdminPainel;

    /**
     * This variable instantiates the class
     * CauGetAllShippingIds
     *
     * @var object
     */
    public $cauGetAllShippingIds;

    /**
     * This variable instantiates the class
     * CauTrackingRestApi
     *
     * @var object
     */
    public $cauTrackingRestApi;

    /**
     * Initiate all core features
     *
     * @return void
     */
    public function init()
    {
        $this->cauAdminPainel = new CauWoocommerceSettings();
        $this->cauAdminPainel->init();

        $this->verifyPluginPermission();

        //Are we allowed to run?
        if (!$this->verifyPluginPermission()) {
            return;
        }

        //It will run only at noon
        //In this way, we avoid overloading the site with api calls
        if (date('H') !== '12') {
            return;
        }

        $this->cauGetAllShippingIds = new CauGetAllShippingIds();
        $this->cauGetAllShippingIds->init();
        //This method must be called at this time, or it wont return the correct array of data
        add_action('woocommerce_after_register_post_type', [$this, 'getTrackingNumbers'], 12);

        $this->cauTrackingRestApi = new CauTrackingRestApi();
        $this->cauTrackingRestApi->init();
        //This method must be called at this time, or it wont return the correct array of data
        add_action('woocommerce_after_register_post_type', [$this, 'getOrdersAndTracking'], 14);

        add_action('woocommerce_after_register_post_type', function () {
            $updater = new CauUpdateOrders();
            $updater->update();
        }, 15);
    }

    /**
     * Verify if plugin is allowed to run
     *
     * @return void
     */
    public function verifyPluginPermission()
    {
        $permission = get_option('correios_auto_updater_title', false) === 'yes' ? true : false;
        return $permission;
    }

    /**
     * Tracking numbers getter
     *
     * @return array
     */
    public function getTrackingNumbers()
    {
        return self::$trackingNumbers;
    }

    /**
     * Orders and tracking numbers getter
     *
     * @return array
     */
    public function getOrdersAndTracking()
    {
        return self::$ordersAndTracking;
    }
}
