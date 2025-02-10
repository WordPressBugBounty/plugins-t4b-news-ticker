<?php
// if uninstall.php is not called by WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Load WordPress database access
global $wpdb;

// Retrieve user preference for data deletion.
$t4bnt_general = get_option( 't4bnt_general', array() ); // Ensure it's an array
$t4bnt_delall  = isset( $t4bnt_general['t4bnt_delall'] ) ? sanitize_text_field( $t4bnt_general['t4bnt_delall'] ) : 'off';

// If the user has chosen to delete all plugin data, proceed.
if ( 'on' === $t4bnt_delall ) {
    // List of plugin options to be deleted.
    $option_names = array(
        't4bnt_review_nt',
        't4bnt_activation_time',
        't4bnt_plugin_version',
        't4bnt_general',
        't4bnt_content',
        't4bnt_advance',
    );

    // Delete plugin options from the database.
    foreach ( $option_names as $option ) {
        delete_option( $option );
        delete_site_option( $option ); // Ensures deletion in a multisite setup.
    }
}