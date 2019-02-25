<?php
add_filter('uwp_get_settings_uninstall','uwp_social_uninstall_options');

function uwp_social_uninstall_options( $settings ){

    $settings[] = array(
        'name'     => __( 'UsersWP - Social', 'uwp-social' ),
        'desc'     => __( 'Remove all data when deleted?', 'uwp-social' ),
        'id'       => 'uwp_uninstall_social_data',
        'type'     => 'checkbox',
    );

    return $settings;
}