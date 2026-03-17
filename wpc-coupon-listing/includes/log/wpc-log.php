<?php
defined( 'ABSPATH' ) || exit;

register_activation_hook( defined( 'WPCCL_LITE' ) ? WPCCL_LITE : WPCCL_FILE, 'wpccl_activate' );
register_deactivation_hook( defined( 'WPCCL_LITE' ) ? WPCCL_LITE : WPCCL_FILE, 'wpccl_deactivate' );
add_action( 'admin_init', 'wpccl_check_version' );

function wpccl_check_version() {
	if ( ! empty( get_option( 'wpccl_version' ) ) && ( get_option( 'wpccl_version' ) < WPCCL_VERSION ) ) {
		wpc_log( 'wpccl', 'upgraded' );
		update_option( 'wpccl_version', WPCCL_VERSION, false );
	}
}

function wpccl_activate() {
	wpc_log( 'wpccl', 'installed' );
	update_option( 'wpccl_version', WPCCL_VERSION, false );
}

function wpccl_deactivate() {
	wpc_log( 'wpccl', 'deactivated' );
}

if ( ! function_exists( 'wpc_log' ) ) {
	function wpc_log( $prefix, $action ) {
		$logs = get_option( 'wpc_logs', [] );
		$user = wp_get_current_user();

		if ( ! isset( $logs[ $prefix ] ) ) {
			$logs[ $prefix ] = [];
		}

		$logs[ $prefix ][] = [
			'time'   => current_time( 'mysql' ),
			'user'   => $user->display_name . ' (ID: ' . $user->ID . ')',
			'action' => $action
		];

		update_option( 'wpc_logs', $logs, false );
	}
}