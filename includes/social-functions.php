<?php
function uwp_get_available_social_providers() {
    $providers =  array(
        array(
            "provider_id"       => "facebook",
            "provider_name"     => "Facebook",
            "require_client_id" => true,
            "callback"          => true,
            "new_app_link"      => "https://developers.facebook.com/apps",
            "default_api_scope" => "email, public_profile, user_friends",
            "default_network"   => true,
            "cat"               => "socialnetworks",
        ),
        array(
            "provider_id"       => "google",
            "provider_name"     => "Google",
            "callback"          => true,
            "require_client_id" => true,
            "new_app_link"      => "https://console.developers.google.com",
            "default_api_scope" => "profile https://www.googleapis.com/auth/plus.profile.emails.read",
            "default_network"   => true,
            "cat"               => "socialnetworks",
        ),
        array(
            "provider_id"       => "twitter",
            "provider_name"     => "Twitter",
            "callback"          => true,
            "new_app_link"      => "https://dev.twitter.com/apps",
            "default_network"  => true,
            "cat"               => "microblogging",
        ),
        array(
            "provider_id"       => "linkedIn",
            "provider_name"     => "LinkedIn",
            "new_app_link"      => "https://www.linkedin.com/secure/developer",
            "cat"               => "professional",
        ),
        array(
            "provider_id"       => "yahoo",
            "provider_name"     => "Yahoo!",
            "new_app_link"      => null,
            "cat"               => "pleasedie",
        ),
    );

    $providers = apply_filters('uwp_get_available_social_providers', $providers);
    return $providers;
}


function uwp_social_login_buttons() {
    $providers = uwp_get_available_social_providers();

    ?>
    <ul class="uwp_social_login_ul">
    <?php
    foreach ($providers as $provider) {
        $provider_id   = isset( $provider["provider_id"]   ) ? $provider["provider_id"]   : '';
        $provider_name = isset( $provider["provider_name"] ) ? $provider["provider_name"] : '';

        $enable = uwp_get_option('enable_uwp_social_'.$provider_id, "0");

        if ($enable == "1") {
            $key = uwp_get_option('uwp_social_'.$provider_id.'_key', "");
            $secret = uwp_get_option('uwp_social_'.$provider_id.'_secret', "");
            $icon = plugins_url()."/uwp_social/assets/images/32/".$provider_id.".png";
            $url = home_url() . "/?action=uwp_social_authenticate&provider=".$provider_id;

            if (!empty($key) && !empty($secret)) {
                ?>
                <li class="uwp_social_login_icon">
                    <a href="<?php echo $url; ?>">
                        <img src="<?php echo $icon; ?>" alt="<?php echo $provider_name; ?>">
                    </a>
                </li>
                <?php
            }
        }
    }
    ?>
    </ul>
    <?php
}

function uwp_social_login_buttons_display($args, $instance, $shortcode = false) {
    
    extract($args, EXTR_SKIP);
    ob_start();
    
    $title = empty($instance['title']) ? __('Social Login', 'uwp') : apply_filters('uwp_social_login_title', $instance['title']);
    echo $before_widget;
    ?>
    <?php if ($title) {
        echo $before_title . $title . $after_title;
    } ?>
    <div class="uwp-social-login-wrap">
        <?php uwp_social_login_buttons(); ?>
    </div>
    <?php echo $after_widget;
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


add_action('init', 'uwp_social_authenticate_init');
function uwp_social_authenticate_init() {
    if (isset($_GET['action']) && $_GET['action'] == 'uwp_social_authenticate') {
        uwp_social_authenticate_process();
    }
}

function uwp_social_authenticate_process() {
    if (is_user_logged_in()) {
        wp_redirect(home_url());
        die();
    } else {
        if (!isset($_GET['provider']) || empty($_GET['provider'])) {
            return false;
        }

        $config = array();
        $config["base_url"] = UWP_SOCIAL_LOGIN_HYBRIDAUTH_ENDPOINT_URL;
        $config["providers"] = array();
        $config["providers"][$provider] = array();
        $config["providers"][$provider]["enabled"] = true;
        $config["providers"][$provider]["keys"] = array( 'id' => null, 'key' => null, 'secret' => null );

        // load hybridauth main class
        if( ! class_exists('Hybrid_Auth', false) )
        {
            require_once UWP_SOCIAL_LOGIN_PATH . "vendor/hybridauth/Hybrid/Auth.php";
        }

        try
        {
            // create an instance oh hybridauth with the generated config
            $hybridauth = new Hybrid_Auth( $config );

            $params = apply_filters("uwp_process_login_authenticate_params",array(),$provider);
            $adapter = $hybridauth->authenticate( $provider,$params );
        }

            // if hybridauth fails to authenticate the user, then we display an error message
        catch( Exception $e )
        {
            return uwp_process_login_render_error_page( $e, $config, $provider );
        }
    }
}