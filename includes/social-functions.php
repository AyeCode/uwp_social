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

    if (isset($_GET['action']) && $_GET['action'] == 'uwp_social_authenticated') {
        uwp_social_authenticated_process();
    }
}

function uwp_social_authenticate_process() {
    if (is_user_logged_in()) {
        wp_redirect(home_url());
        die();
    } else {
        if (isset($_GET['provider']) && !empty($_GET['provider'])) {
            $provider = strip_tags(esc_sql(trim($_GET['provider'])));
        } else {
            //todo: maybe display error?
            $provider = 'google';
        }

        $config = uwp_social_build_provider_config($provider);

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
            uwp_social_render_error( $e, $config, $provider );
        }

        // build the authenticateD, which will make wsl_process_login() fire the next step wsl_process_login_end()
        $redirect_to = isset( $_REQUEST[ 'redirect_to' ] ) ? $_REQUEST[ 'redirect_to' ] : home_url();

        // build the authenticateD, which will make wsl_process_login() fire the next step wsl_process_login_end()
        $authenticated_url = add_query_arg(
            array(
                'action' =>  'uwp_social_authenticated',
                'provider' => $provider
            ),
            home_url()
        );

        // display a loading screen
        uwp_social_provider_loading_screen( $provider, $authenticated_url, $redirect_to );

    }
}

function uwp_social_build_provider_config( $provider )
{
    $config = array();
    $config["base_url"] = UWP_SOCIAL_LOGIN_HYBRIDAUTH_ENDPOINT_URL;
    $config["providers"] = array();
    $config["providers"][$provider] = array();
    $config["providers"][$provider]["enabled"] = true;
    $config["providers"][$provider]["keys"] = array( 'id' => null, 'key' => null, 'secret' => null );

    // provider application id ?
    if( uwp_get_option('uwp_social_'.$provider.'_id', false) )
    {
        $config["providers"][$provider]["keys"]["id"] = uwp_get_option('uwp_social_'.$provider.'_id');
    }

    // provider application key ?
    if( uwp_get_option('uwp_social_'.$provider.'_key', false) )
    {
        $config["providers"][$provider]["keys"]["key"] = uwp_get_option('uwp_social_'.$provider.'_key');
    }

    // provider application secret ?
    if( uwp_get_option('uwp_social_'.$provider.'_secret', false) )
    {
        $config["providers"][$provider]["keys"]["secret"] = uwp_get_option('uwp_social_'.$provider.'_secret');
    }

    // set default scope
    if( uwp_get_option('uwp_social_'.$provider.'_scope', false) )
    {
        $config["providers"][$provider]["keys"]["scope"] = uwp_get_option('uwp_social_'.$provider.'_scope');
    }

    // set custom config for facebook
    if( strtolower( $provider ) == "facebook" )
    {
        $config["providers"][$provider]["display"] = "popup";
        $config["providers"][$provider]["trustForwarded"] = true;

    }


    $provider_scope = isset( $config["providers"][$provider]["scope"] ) ? $config["providers"][$provider]["scope"] : '' ;

    // allow to overwrite scopes
    $config["providers"][$provider]["scope"] = apply_filters( 'uwp_social_provider_config_scope', $provider_scope, $provider );

    // allow to overwrite hybridauth config for the selected provider
    $config["providers"][$provider] = apply_filters( 'uwp_social_provider_config', $config["providers"][$provider], $provider );

    return $config;
}


/**
 * Finish the authentication process
 *
 * Steps:
 *     1. Get the user profile from provider
 *     2. Create new wordpress user if he didn't exist in database
 *     3. Store his Hybridauth profile, contacts and BP mapping
 *     4. Authenticate the user within wordpress
 */
function uwp_social_authenticated_process()
{

    $redirect_page_id = uwp_get_option('login_redirect_to', 0);
    if ($redirect_page_id) {
        $redirect_to = esc_url( get_permalink($redirect_page_id) );
    } else {
        $redirect_to = home_url('/');
    }

    if (isset($_GET['provider']) && !empty($_GET['provider'])) {
        $provider = strip_tags(esc_sql(trim($_GET['provider'])));
    } else {
        //todo: maybe display error?
        $provider = 'google';
    }

    // authentication mode
    $auth_mode = 'login';

    $is_new_user             = false; // is it a new or returning user
    $user_id                 = ''   ; // wp user id
    $adapter                 = ''   ; // hybriauth adapter for the selected provider
    $hybridauth_user_profile = ''   ; // hybriauth user profile
    $requested_user_login    = ''   ; // username typed by users in Profile Completion
    $requested_user_email    = ''   ; // email typed by users in Profile Completion

    // provider is enabled?
    $enable = uwp_get_option('enable_uwp_social_'.$provider, "0");

    if ($enable != "1") {
        echo uwp_social_render_error( __( "Unknown or disabled provider.", 'uwp-social' ) );
    }


    if( 'login' == $auth_mode )
    {

        $data = uwp_social_get_user_data( $provider, $redirect_to );
        // returns user data after he authenticate via hybridauth

        if (is_string($data)) {
            echo $data;
            die();
        } else {
            list
                (
                $user_id                ,
                $adapter                ,
                $hybridauth_user_profile,
                $requested_user_login   ,
                $requested_user_email   ,
                $wordpress_user_id
                )
                = $data;
        }


        // if no associated user were found in uwp social profiles, create new WordPress user
        if( ! $wordpress_user_id )
        {
            $user_id = uwp_social_create_wp_user( $provider, $hybridauth_user_profile, $requested_user_login, $requested_user_email );

            $is_new_user = true;
        }else{
            $user_id = $wordpress_user_id;
            $is_new_user = false;
        }
    }

    $wp_user = get_userdata( $user_id );

    
    // store user profile
    uwp_social_update_user_data( $is_new_user, $user_id, $provider, $adapter, $hybridauth_user_profile, $wp_user );

    // finally create a wordpress session for the user
    uwp_social_authenticate_user( $user_id, $provider, $redirect_to, $adapter, $hybridauth_user_profile, $wp_user );
}


/**
 * Returns user data after he authenticate via hybridauth
 *
 * Steps:
 *    1. Grab the user profile from hybridauth
 *    2. Run Bouncer::Filters if enabled (domains, emails, profiles urls)
 *    3. Check if user exist in database by looking for the couple (Provider name, Provider user ID) or verified email
 *    4. Deletegate detection of user id to custom functions / hooks
 *    5. If Bouncer::Profile Completion is enabled and user didn't exist, we require the user to complete the registration (user name & email)
 */
function uwp_social_get_user_data( $provider, $redirect_to )
{
    do_action( "uwp_social_get_user_data_start", $provider, $redirect_to );

    $user_id                  = null;
    $config                   = null;
    $hybridauth               = null;
    $adapter                  = null;
    $hybridauth_user_profile  = null;
    $requested_user_login     = '';
    $requested_user_email     = '';
    $wordpress_user_id        = 0;


    if( ! ( isset( $_SESSION['uwp::userprofile'] ) && $_SESSION['uwp::userprofile'] && $hybridauth_user_profile = json_decode( $_SESSION['uwp::userprofile'] ) ) )
    {
        $hybridauth_user_profile = uwp_request_user_social_profile( $provider );

        $_SESSION['uwp::userprofile'] = json_encode( $hybridauth_user_profile );
    }

    $adapter = uwp_social_get_provider_adapter( $provider );

    $hybridauth_user_email = sanitize_email( $hybridauth_user_profile->email );

    

    $user_id = (int) uwp_get_social_profile( $provider, $hybridauth_user_profile->identifier );


    if( ! $user_id )
    {
        // Bouncer :: Accept new registrations?
        if (!get_option('users_can_register')) 
        {
            return uwp_social_render_notice( __( "Registration is now closed.", 'uwp-social' ) );
        }
        
        $require_email = true;

        if(( $require_email == 1 && empty( $hybridauth_user_email )))
        {
            do
            {
                list
                    (
                    $shall_pass,
                    $user_id,
                    $requested_user_login,
                    $requested_user_email
                    )
                    = uwp_social_new_users_gateway( $provider, $redirect_to, $hybridauth_user_profile );
            }
            while( ! $shall_pass );
        }
    }else{
        $wordpress_user_id = $user_id;
    }
    
    // check if user already exist in uwp social profiles
    $user_id = (int) uwp_get_social_profile( $provider, $hybridauth_user_profile->identifier );

    // if not found in uwp social profiles, then check his verified email
    if( ! $user_id && ! empty( $hybridauth_user_profile->emailVerified ) )
    {
        // check if the verified email exist in wp_users
        $user_id = (int) uwp_email_exists( $hybridauth_user_profile->emailVerified );

        // the user exists in Wordpress
        $wordpress_user_id = $user_id;

        // check if the verified email exist in uwp social profiles
        if( ! $user_id )
        {
            $user_id = (int) uwp_get_social_profile_by_email_verified( $hybridauth_user_profile->emailVerified );
        }
    }
    
    return array(
        $user_id,
        $adapter,
        $hybridauth_user_profile,
        $requested_user_login,
        $requested_user_email,
        $wordpress_user_id
    );
}

function uwp_social_create_wp_user( $provider, $hybridauth_user_profile, $requested_user_login, $requested_user_email )
{
    do_action( "uwp_social_create_wp_user_start", $provider, $hybridauth_user_profile, $requested_user_login, $requested_user_email );

    $user_login = '';
    $user_email = '';

    // if coming from "complete registration form"
    if( $requested_user_login )
    {
        $user_login = $requested_user_login;
    }

    if( $requested_user_email )
    {
        $user_email = $requested_user_email;
    }

    if( ! $user_login )
    {
        // attempt to generate user_login from hybridauth user profile display name
        $user_login = $hybridauth_user_profile->displayName;

        // sanitize user login
        $user_login = sanitize_user( $user_login, true );

        // remove spaces and dots
        $user_login = trim( str_replace( array( ' ', '.' ), '_', $user_login ) );
        $user_login = trim( str_replace( '__', '_', $user_login ) );

        // if user profile display name is not provided
        if( empty( $user_login ) )
        {
            $user_login = sanitize_user( current( explode( '@', $user_email ) ), true );
        }

        // user name should be unique
        if( username_exists( $user_login ) )
        {
            $i = 1;
            $user_login_tmp = $user_login;

            do
            {
                $user_login_tmp = $user_login . "_" . ($i++);
            }
            while( username_exists ($user_login_tmp));

            $user_login = $user_login_tmp;
        }
    }

    if( ! $user_email )
    {
        $user_email = $hybridauth_user_profile->email;

        // generate an email if none
        if( ! isset ( $user_email ) OR ! is_email( $user_email ) )
        {
            $user_email = strtolower( $provider . "_user_" . $user_login ) . '@example.com';
        }

        // email should be unique
        if( uwp_email_exists ( $user_email ) )
        {
            do
            {
                $user_email = md5( uniqid( wp_rand( 10000, 99000 ) ) ) . '@example.com';
            }
            while( uwp_email_exists( $user_email ) );
        }
    }

    $display_name = $hybridauth_user_profile->displayName;

    if( empty( $display_name ) )
    {
        $display_name = $hybridauth_user_profile->firstName;
    }

    if( empty( $display_name ) )
    {
        $display_name = strtolower( $provider ) . "_user";
    }

    $userdata = array(
        'user_login'    => $user_login,
        'user_email'    => $user_email,

        'display_name'  => $display_name,

        'first_name'    => $hybridauth_user_profile->firstName,
        'last_name'     => $hybridauth_user_profile->lastName,
        'user_url'      => $hybridauth_user_profile->profileURL,
        'description'   => $hybridauth_user_profile->description,

        'user_pass'     => wp_generate_password()
    );

    $userdata['role'] = get_option('default_role');
    
    $userdata = apply_filters( 'uwp_social_alter_wp_insert_user_data', $userdata, $provider, $hybridauth_user_profile );

    do_action( 'uwp_social_before_wp_insert_user', $userdata, $provider, $hybridauth_user_profile );

    $user_id = apply_filters( 'uwp_social_delegate_wp_insert_user', $userdata, $provider, $hybridauth_user_profile );

    // Create a new WordPress user
    if( ! $user_id || ! is_integer( $user_id ) )
    {
        $user_id = wp_insert_user( $userdata );
    }

    // do not continue without user_id
    if( ! $user_id || ! is_integer( $user_id ) )
    {
        if( is_wp_error( $user_id ) )
        {
            return uwp_social_render_notice( __( "An error occurred while creating a new user: ", 'uwp-social' ) . $user_id->get_error_message() );
        }

        return uwp_social_render_notice( __( "An error occurred while creating a new user!", 'uwp-social' ) );
    }

    // wp_insert_user may fail on first and last name meta, expliciting setting to correct.
    update_user_meta($user_id, 'first_name', apply_filters( 'uwp_social_pre_user_first_name',$userdata['first_name']));
    update_user_meta($user_id, 'last_name', apply_filters( 'uwp_social_pre_user_last_name', $userdata['last_name']));

    // Send notifications
    // todo: process email notification

    do_action( 'uwp_social_after_wp_insert_user', $user_id, $provider, $hybridauth_user_profile );

    // returns the user created user id
    return $user_id;
}


/**
 *  Grab the user profile from social network
 */
function uwp_request_user_social_profile( $provider )
{
    $adapter                 = null;
    $config                  = null;
    $hybridauth_user_profile = null;

    try
    {
        // get idp adapter
        $adapter = uwp_social_get_provider_adapter( $provider );

        $config = $adapter->config;

        // if user authenticated successfully with social network
        if( $adapter->isUserConnected() )
        {
            // grab user profile via hybridauth api
            $hybridauth_user_profile = $adapter->getUserProfile();
        }

        // if user not connected to provider (ie: session lost, url forged)
        else
        {
            return uwp_social_render_notice( sprintf( __( "Sorry, we couldn't connect you with <b>%s</b>. <a href=\"%s\">Please try again</a>.", 'uwp-social' ), $provider, site_url( 'wp-login.php', 'login_post' ) ) );
        }
    }

        // if things didn't go as expected, we dispay the appropriate error message
    catch( Exception $e )
    {
        return uwp_social_render_error( $e, $config, $provider, $adapter );
    }

    return $hybridauth_user_profile;
}


function uwp_social_update_user_data( $is_new_user, $user_id, $provider, $adapter, $hybridauth_user_profile, $wp_user )
{
    do_action( "uwp_social_update_user_data_start", $is_new_user, $user_id, $provider, $adapter, $hybridauth_user_profile, $wp_user );

    uwp_social_store_user_profile( $user_id, $provider, $hybridauth_user_profile );
    
}


/**
 * Authenticate a user within wordpress
 *
 */
function uwp_social_authenticate_user( $user_id, $provider, $redirect_to, $adapter, $hybridauth_user_profile, $wp_user )
{
    do_action( "uwp_social_authenticate_user_start", $user_id, $provider, $redirect_to, $adapter, $hybridauth_user_profile, $wp_user );

    // update some fields in usermeta for the current user
    update_user_meta( $user_id, 'wsl_current_provider', $provider );

    if(  $hybridauth_user_profile->photoURL )
    {
        // todo: change this to uwp avatar
        update_user_meta( $user_id, 'uwp_social_user_image', $hybridauth_user_profile->photoURL );
    }
    
    // This action runs just before logging the user in (before creating a WP cookie)
    do_action( "uwp_social_authenticate_user_set_auth_cookie", $user_id, $provider, $hybridauth_user_profile );
    
    // Set WP auth cookie
    wp_set_auth_cookie( $user_id, true );

    // let keep it std
    do_action( 'wp_login', $wp_user->user_login, $wp_user );
    

    do_action( "uwp_social_authenticate_before_wp_safe_redirect", $user_id, $provider, $hybridauth_user_profile, $redirect_to );

    do_action( 'uwp_social_authenticate_session' );

    wp_safe_redirect( $redirect_to );

    // for good measures
    die();
}

function uwp_social_new_users_gateway( $provider, $redirect_to, $hybridauth_user_profile )
{
    do_action( "uwp_social_new_users_gateway_start", $provider, $redirect_to, $hybridauth_user_profile );

    $assets_base_url = UWP_SOCIAL_LOGIN_PLUGIN_URL . 'assets/images/16x16/';

    // remove wsl widget
    remove_action( 'register_form', 'uwp_render_auth_widget_in_wp_register_form' );

    $hybridauth_user_email       = sanitize_email( $hybridauth_user_profile->email );
    $hybridauth_user_login       = sanitize_user( $hybridauth_user_profile->displayName, true );
    $hybridauth_user_avatar      = $hybridauth_user_profile->photoURL;
    $hybridauth_user_website     = $hybridauth_user_profile->webSiteURL;
    $hybridauth_user_link        = $hybridauth_user_profile->profileURL;

    $hybridauth_user_login       = trim( str_replace( array( ' ', '.' ), '_', $hybridauth_user_login ) );
    $hybridauth_user_login       = trim( str_replace( '__', '_', $hybridauth_user_login ) );

    $requested_user_email        = isset( $_REQUEST["user_email"] ) ? trim( $_REQUEST["user_email"] ) : $hybridauth_user_email;
    $requested_user_login        = isset( $_REQUEST["user_login"] ) ? trim( $_REQUEST["user_login"] ) : $hybridauth_user_login;

    $requested_user_email        = apply_filters( 'uwp_new_users_gateway_alter_requested_email', $requested_user_email );
    $requested_user_login        = apply_filters( 'uwp_new_users_gateway_alter_requested_login', $requested_user_login );

    $user_id    = 0;
    $shall_pass = false;

    $bouncer_account_linking    = false;
    $account_linking_errors     = array();

    $bouncer_profile_completion = false;
    $profile_completion_errors  = array();

    $require_email   = 2;
    $change_username = 2;
    $extra_fields    = 2;

    

//    if( isset( $_REQUEST["bouncer_profile_completion"] ) )
//    {
//        if( $require_email == 2 && $change_username == 2 && $extra_fields == 2 )
//        {
//            $shall_pass = true;
//        }
//    }

    if( $require_email == 2 && $change_username == 2 && $extra_fields == 2 )
    {
        $shall_pass = true;
    }
    

    return array( $shall_pass, $user_id, $requested_user_login, $requested_user_email );
}


function uwp_social_get_provider_name_by_id( $provider_id)
{
    $providers = uwp_get_available_social_providers();

    foreach( $providers as $provider ) {
        if ( $provider['provider_id'] == $provider_id ) {
            return $provider['provider_name'];
        }
    }

    return $provider_id;
}


function uwp_social_provider_loading_screen( $provider, $authenticated_url, $redirect_to )
{

    $assets_base_url  = UWP_SOCIAL_LOGIN_PLUGIN_URL . 'assets/images/';
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="robots" content="NOINDEX, NOFOLLOW">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php _e("Redirecting...", 'uwp-social') ?> - <?php bloginfo('name'); ?></title>
        <style type="text/css">
            html {
                background: #f1f1f1;
            }
            body {
                background: #fff;
                color: #444;
                font-family: "Open Sans", sans-serif;
                margin: 2em auto;
                padding: 1em 2em;
                max-width: 700px;
                -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.13);
                box-shadow: 0 1px 3px rgba(0,0,0,0.13);
            }
            #loading-screen {
                margin-top: 50px;
            }
            #loading-screen div{
                line-height: 20px;
                background-color: #f2f2f2;
                border: 1px solid #ccc;
                padding: 10px;
                text-align:center;
                box-shadow: 0 1px 3px rgba(0,0,0,0.13);
                margin-top:25px;
            }
        </style>
        <script>
            function init()
            {
                document.loginform.submit();
            }
        </script>
    </head>
    <body id="loading-screen" onload="init();">
    <table width="100%" border="0">
        <tr>
            <td align="center"><img src="<?php echo $assets_base_url ?>loading.gif" /></td>
        </tr>
        <tr>
            <td align="center">
                <div>
                    <?php _e( "Processing, please wait...", 'uwp-social');  ?>
                </div>
            </td>
        </tr>
    </table>

    <form name="loginform" method="post" action="<?php echo $authenticated_url; ?>">
        <input type="hidden" id="redirect_to" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>">
        <input type="hidden" id="provider" name="provider" value="<?php echo $provider ?>">
        <input type="hidden" id="action" name="action" value="wordpress_social_authenticated">
    </form>
    </body>
    </html>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
    die();
}