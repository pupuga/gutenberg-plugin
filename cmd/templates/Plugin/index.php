<?php
/**
 * Plugin Name:       {{name}}
 * Description:       {{description}}
 * Requires at least: {{wordpress}}
 * Requires PHP:      {{php}}
 * Version:           {{version}}
 * Author:            {{author}}
 * License:           {{license}}
 * License URI:       {{licenseLink}}
 * Text Domain:       {{slug}}
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} else {
	add_action( 'init',  function () {
		require_once __DIR__ . "/vendor/autoload.php";
		{{namespace}}\Init\Init::app();
    }, 10000);
}
