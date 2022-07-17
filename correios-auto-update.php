<?php

//Correios auto updater bootstrap file

defined('ABSPATH') || die();

//Fail fast: verifies if woocommerce exists and is active and the Brazilian correios for WC
require_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (!is_plugin_active('woocommerce/woocommerce.php') && !is_plugin_active('woocommerce-correios/woocommerce-correios.php')) {
    return;
}

//autoload
require_once wp_normalize_path(plugin_dir_path(__FILE__) . '/vendor/autoload.php');

//version
require_once wp_normalize_path(plugin_dir_path(__FILE__) . '/src/CauDefines.php');

/**
* Correios auto updater
*
* @package           correios auto update
* @author            Rodrigo Vieira Del Bem
* @copyright         2021 Rodrigo Vieira Del Bem
* @license           GPL-2.0-or-later
*
* @wordpress-plugin
* Plugin Name:       Correios auto updater
* Plugin URI:        https://delbem.net/cau
* Description:       It will auto update your sales by checking if correios have already finished shipping the item.
* Version:           1.0.0
* Requires at least: 5.5
* Requires PHP:      7.4
* Author:            Rodrigo Vieira Del Bem
* Author URI:        https://delbem.net
* Text Domain:       correios-auto-updater
* License:           GPL v2 or later
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt/
*/

if (!class_exists('CauCorreiosAutoUpdater')) {
    add_action('plugins_loaded', [new Cau\CauCorreiosAutoUpdater(), 'init']);
}
