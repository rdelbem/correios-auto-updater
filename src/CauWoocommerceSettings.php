<?php

namespace Cau;

defined('ABSPATH') || die();

/**
 * This class adds some basic settings to allow users to turn this class features on or off
 */
class CauWoocommerceSettings
{
    /**
     * It connects this class methods to WP hooks
     *
     * @return void
     */
    public function init()
    {
        add_filter('woocommerce_settings_tabs_array', [$this, 'addSettingsTab'], 50);
        add_action('woocommerce_settings_tabs_correios_auto_updater', [$this, 'settingsTab']);
        add_action('woocommerce_update_options_correios_auto_updater', [$this, 'updateSettings']);
    }

    /**
     * It adds the correios auto updater to the settings tabs array
     *
     * @param array $settingsTabs
     * @return array $settingsTabs
     */
    public function addSettingsTab(array $settingsTabs)
    {
        $settingsTabs['correios_auto_updater'] = __('Correios Auto Updater', 'correios-auto-updater');
        return $settingsTabs;
    }

    /**
     * It adds correios auto updater settings to the settings array,
     * associated with correios auto updater tab
     *
     * @return void
     */
    public function settingsTab()
    {
        woocommerce_admin_fields($this->getSettings());
    }

    /**
     * Updates all settings passed
     *
     * @return void
     */
    public function updateSettings()
    {
        woocommerce_update_options($this->getSettings());
    }

    /**
     * Correios auto updater settings
     *
     * @return function apply_filters
     */
    public function getSettings()
    {

        $settings = array(
            'section_title' => [
                'name'      => __('Correios Auto Updater', 'correios-auto-updater'),
                'type'      => 'title',
                'desc'      => '',
                'id'        => 'correios_auto_updater_section_title'
            ],
            'title'    => [
                'name' => __('Permission check', 'correios-auto-updater'),
                'type' => 'checkbox',
                'desc' => __('Do you allow this plugin to auto update your sales statuses based on shipping delivery?', 'correios-auto-updater'),
                'id'   => 'correios_auto_updater_title'
            ],
            'section_end' => [
                 'type'   => 'sectionend',
                 'id'     => 'correios_auto_updater_section_end'
            ]
        );

        return apply_filters('correios_auto_updater_settings', $settings);
    }
}
