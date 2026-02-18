<?php

/**
 * Plugin Name:       Growla core
 * Plugin URI:        https://themeforest.net/user/gfxpartner
 * Description:       Additional functionality for the growla premium wordpress theme.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            GFXPARTNER
 * Author URI:        https://themeforest.net/user/gfxpartner
 * License:           GNU General Public License v2+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       growla-core
 */

/**
 * exit if accessed out of wordpress
 */
if ( !function_exists( 'add_action' ) ) {
    exit;  
}

/**
 * misc. code
 */
require_once( plugin_dir_path( __FILE__ ) . 'helper/misc.php' );

/**
 * cpt
 */
require_once( plugin_dir_path( __FILE__ ) . 'cpt/cpt-register.php' );

/**
 * widgets
 */
require_once( plugin_dir_path( __FILE__ ) . 'widgets/widgets-init.php' );

/**
 * shortcodes
 */
require_once( plugin_dir_path( __FILE__ ) . 'shortcodes/cf7.php' );

add_action('init', function () {
    load_plugin_textdomain('growla-core', false, dirname(plugin_basename(__FILE__)) . '/languages');
});

add_action('after_setup_theme', function () {
    /**
     * require Redux config
     */
    if (
        !isset( $growla_opt ) && 
        file_exists( plugin_dir_path( __FILE__ ) . 'options/config/config.php' ) ) {
        require_once( plugin_dir_path( __FILE__ ) . 'options/config/config.php');
    }
});