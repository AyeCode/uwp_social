<?php
add_filter('uwp_display_form_title', 'uwp_social_display_form_title', 10, 3);
function uwp_social_display_form_title($title, $page, $active_tab) {
    if ($page == 'uwp_social' && $active_tab == 'main') {
        $title = __('Social Settings', 'uwp-social');
    }
    return $title;
}

add_action('uwp_social_settings_main_tab_content', 'uwp_social_main_tab_content', 10, 1);
add_action('uwp_social_settings_google_tab_content', 'uwp_social_main_tab_content', 10, 1);
add_action('uwp_social_settings_facebook_tab_content', 'uwp_social_main_tab_content', 10, 1);
add_action('uwp_social_settings_twitter_tab_content', 'uwp_social_main_tab_content', 10, 1);
add_action('uwp_social_settings_linkedin_tab_content', 'uwp_social_main_tab_content', 10, 1);
add_action('uwp_social_settings_yahoo_tab_content', 'uwp_social_main_tab_content', 10, 1);
function uwp_social_main_tab_content($form) {
    echo $form;
}

add_action('uwp_admin_sub_menus', 'uwp_add_admin_social_sub_menu', 10, 1);
function uwp_add_admin_social_sub_menu($settings_page) {

    add_submenu_page(
        "uwp",
        "Social Login",
        "Social Login",
        'manage_options',
        'uwp_social',
        $settings_page
    );

}

add_filter('uwp_settings_tabs', 'uwp_add_social_tab');
function uwp_add_social_tab($tabs) {
    $tabs['uwp_social'] = array(
        'main' => __( 'General', 'uwp-social' ),
        'google' => __( 'Google', 'uwp-social' ),
        'facebook' => __( 'Facebook', 'uwp-social' ),
        'twitter' => __( 'Twitter', 'uwp-social' ),
        'linkedin' => __( 'LinkedIn', 'uwp-social' ),
        'yahoo' => __( 'Yahoo', 'uwp-social' ),
    );
    return $tabs;
}

add_filter('uwp_registered_settings', 'uwp_add_social_settings');
function uwp_add_social_settings($uwp_settings) {

    $options = array(
        'disable_uwp_social' => array(
            'id'   => 'disable_uwp_social',
            'name' => 'Disable Social',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
    );

    $google_options = array(
        'enable_uwp_social_google' => array(
            'id'   => 'enable_uwp_social_google',
            'name' => 'Enable Google',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_google_id' => array(
            'id' => 'uwp_social_google_id',
            'name' => __( 'Google APP ID', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Google APP ID', 'uwp' )
        ),
        'uwp_social_google_secret' => array(
            'id' => 'uwp_social_google_secret',
            'name' => __( 'Google APP Secret', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Google APP Secret', 'uwp' )
        ),
    );

    $facebook_options = array(
        'enable_uwp_social_facebook' => array(
            'id'   => 'enable_uwp_social_facebook',
            'name' => 'Enable Facebook',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_facebook_key' => array(
            'id' => 'uwp_social_facebook_key',
            'name' => __( 'Facebook API Key', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Facebook API Key', 'uwp' )
        ),
        'uwp_social_facebook_secret' => array(
            'id' => 'uwp_social_facebook_secret',
            'name' => __( 'Facebook API Secret', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Facebook API Secret', 'uwp' )
        ),
    );

    $twitter_options = array(
        'enable_uwp_social_twitter' => array(
            'id'   => 'enable_uwp_social_twitter',
            'name' => 'Enable Twitter',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_twitter_key' => array(
            'id' => 'uwp_social_twitter_key',
            'name' => __( 'Twitter API Key', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Twitter API Key', 'uwp' )
        ),
        'uwp_social_twitter_secret' => array(
            'id' => 'uwp_social_twitter_secret',
            'name' => __( 'Twitter API Secret', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Twitter API Secret', 'uwp' )
        ),
    );

    $linkedin_options = array(
        'enable_uwp_social_linkedin' => array(
            'id'   => 'enable_uwp_social_linkedin',
            'name' => 'Enable LinkedIn',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_linkedin_key' => array(
            'id' => 'uwp_social_linkedin_key',
            'name' => __( 'LinkedIn API Key', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter LinkedIn API Key', 'uwp' )
        ),
        'uwp_social_linkedin_secret' => array(
            'id' => 'uwp_social_linkedin_secret',
            'name' => __( 'LinkedIn API Secret', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter LinkedIn API Secret', 'uwp' )
        ),
    );

    $yahoo_options = array(
        'enable_uwp_social_yahoo' => array(
            'id'   => 'enable_uwp_social_yahoo',
            'name' => 'Enable Yahoo',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_yahoo_key' => array(
            'id' => 'uwp_social_yahoo_key',
            'name' => __( 'Yahoo API Key', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Yahoo API Key', 'uwp' )
        ),
        'uwp_social_yahoo_secret' => array(
            'id' => 'uwp_social_yahoo_secret',
            'name' => __( 'Yahoo API Secret', 'uwp' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Yahoo API Secret', 'uwp' )
        ),
    );


    $uwp_settings['uwp_social'] = array(
        'main' => apply_filters( 'uwp_settings_social', $options),
        'google' => apply_filters( 'uwp_settings_social_google', $google_options),
        'facebook' => apply_filters( 'uwp_settings_social_facebook', $facebook_options),
        'twitter' => apply_filters( 'uwp_settings_social_twitter', $twitter_options),
        'linkedin' => apply_filters( 'uwp_settings_social_linkedin', $linkedin_options),
        'yahoo' => apply_filters( 'uwp_settings_social_yahoo', $yahoo_options),
    );

    return $uwp_settings;
}

//add_action('uwp_social_settings_networks_tab_content', 'uwp_social_settings_networks_tab_content');
//function uwp_social_settings_networks_tab_content() {
//    $subtab = 'google';
//
//    if (isset($_GET['subtab'])) {
//        $subtab = $_GET['subtab'];
//    }
//    ?>
<!--    <div class="item-list-sub-tabs">-->
<!--        <ul class="item-list-sub-tabs-ul">-->
<!--            <li class="--><?php //if ($subtab == 'google') { echo "current selected"; } ?><!--">-->
<!--                <a href="--><?php //echo add_query_arg(array('tab' => 'networks', 'subtab' => 'google')); ?><!--">--><?php //echo __( 'Google', 'uwp' ); ?><!--</a>-->
<!--            </li>-->
<!--            <li class="--><?php //if ($subtab == 'facebook') { echo "current selected"; } ?><!--">-->
<!--                <a href="--><?php //echo add_query_arg(array('tab' => 'networks', 'subtab' => 'facebook')); ?><!--">--><?php //echo __( 'Facebook', 'uwp' ); ?><!--</a>-->
<!--            </li>-->
<!--            <li class="--><?php //if ($subtab == 'twitter') { echo "current selected"; } ?><!--">-->
<!--                <a href="--><?php //echo add_query_arg(array('tab' => 'networks', 'subtab' => 'twitter')); ?><!--">--><?php //echo __( 'Twitter', 'uwp' ); ?><!--</a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
<!--    --><?php
//    if ($subtab == 'google') {
//        uwp_social_networks_google_content();
//    } elseif ($subtab == 'facebook') {
//        uwp_social_networks_facebook_content();
//    } elseif ($subtab == 'twitter') {
//        uwp_social_networks_twitter_content();
//    }
//}
//
////subtabs
//function uwp_social_networks_google_content() {
//    echo uwp_display_form();
//}
//
//function uwp_social_networks_facebook_content() {
//    echo uwp_display_form();
//}
//
//function uwp_social_networks_twitter_content() {
//    echo uwp_display_form();
//}