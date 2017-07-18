<?php
add_filter('uwp_display_form_title', 'uwp_social_display_form_title', 10, 3);
function uwp_social_display_form_title($title, $page, $active_tab) {
    if ($page == 'uwp_social' && $active_tab == 'main') {
        $title = __('Social Settings', 'uwp-social');
    }
    return $title;
}

add_action('uwp_social_settings_main_tab_content', 'uwp_social_main_tab_content', 10, 1);
add_action('uwp_social_settings_google_tab_content', 'uwp_social_google_tab_content', 10, 1);
add_action('uwp_social_settings_facebook_tab_content', 'uwp_social_facebook_tab_content', 10, 1);
add_action('uwp_social_settings_twitter_tab_content', 'uwp_social_twitter_tab_content', 10, 1);
add_action('uwp_social_settings_linkedin_tab_content', 'uwp_social_linkedin_tab_content', 10, 1);
add_action('uwp_social_settings_instagram_tab_content', 'uwp_social_instagram_tab_content', 10, 1);
add_action('uwp_social_settings_yahoo_tab_content', 'uwp_social_yahoo_tab_content', 10, 1);
add_action('uwp_social_settings_vkontakte_tab_content', 'uwp_social_vkontakte_tab_content', 10, 1);
add_action('uwp_social_settings_wordpress_tab_content', 'uwp_social_wordpress_tab_content', 10, 1);
function uwp_social_main_tab_content($form) {
    echo $form;
}

// Google
function uwp_social_google_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <p>
            <b>Application</b> id and secret (also sometimes referred as <b>Consumer</b> key and secret
            or <b>Client</b> id and secret) are what we call an application credentials.
            This application will link your website <code><?php echo $_SERVER["SERVER_NAME"]; ?></code> to <code>Google API</code>
            and these credentials are needed in order for <b>Google</b> users to access your website.
        </p>

        <p>
            These credentials may also differ in format, name and content depending on the social network.
        </p>

        <p>
            To enable authentication with this provider and to register a new <b>Google API Application</b>, follow the steps
        </p>

        <ol>
            <li>
                First go to: <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a>
            </li>
            <li>
                On the <b>Dashboard sidebar</b> click on <b>Project</b> then click <b>Create Project</b>
            </li>
            <li>
                Once the project is created. Select that project, then <b>APIs &amp; auth</b> &gt; <b>Consent screen</b> and fill the required information.
            </li>
            <li>
                Then <b>APIs &amp; auth</b> &gt; <b>APIs</b> and enable <b>Google+ API</b>. If you want to import the user contatcs enable <b>Contacts API</b> as well.
            </li>
            <li>
                After that you will need to create an new application: <b>APIs &amp; auth</b> &gt; <b>Credentials</b> and then click <b>Create new Client ID</b>.
            </li>
            <li>
                On the <b>Create Client ID</b> popup :
            </li>
            <li>
                <ul style="margin-left:35px">
                    <li>Select <b>Web application</b> as your application type.</li>
                    <li>Put your website domain in the <b>Authorized JavaScript origins</b> field. This should match with the current hostname <b>localhost</b>.</li>
                    <li>
                        Provide this URL as the <b>Authorized redirect URI</b> for your application: <br>
                        <span style="color:green"><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Google</span>
                    </li>
                </ul>
            </li>
            <li>
                Once you have registered past the created application credentials (Client ID and Secret) into the boxes above
            </li>
        </ol>
    </div>

    <?php
}

// Facebook
function uwp_social_facebook_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <p>
            <b>Application</b> id and secret (also sometimes referred as <b>Consumer</b> key and secret
            or <b>Client</b> id and secret) are what we call an application credentials.
            This application will link your website <code><?php echo $_SERVER["SERVER_NAME"]; ?></code> to <code>Facebook API</code>
            and these credentials are needed in order for <b>Facebook</b> users to access your website.
        </p>

        <p>
            These credentials may also differ in format, name and content depending on the social network.
        </p>

        <p>
            To enable authentication with this provider and to register a new <b>Facebook API Application</b>, follow the steps
        </p>

        <ol>
            <li>
                First go to: <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>
            </li>
            <li>
                Select <b>Add a New App</b> from the <b>Apps</b> menu at the top.
            </li>
            <li>
                Fill out Display Name, Namespace, choose a category and click <b>Create App</b>
            </li>
            <li>
                Go to Settings page and click on <b>Add Platform</b>.
                Choose website and enter in the new screen your website url in <b>App Domains</b> and <b>Site URL</b> fields.
                They should match with the current hostname <b><?php echo $_SERVER["SERVER_NAME"]; ?></b>
            </li>
            <li>
                Go to the <b>Status &amp; Review</b> page and choose <b>yes</b> where it says <b>Do you want to make this app and all its live features available to the general public?</b>
            </li>
            <li>
                Go back to the <b>Dashboard</b> page and past the created application credentials (APP ID and Secret) into the boxes above.
            </li>
            <li>
                And that's it!
            </li>
            <li>
                If for some reason you still can't manage to create an application for Facebook,
                first try to <a href="https://www.google.com/search?q=Facebook API create application" target="_blank">Google it</a>,
                then check it on <a href="http://www.youtube.com/results?search_query=Facebook API create application " target="_blank">Youtube</a>
            </li>
        </ol>
    </div>
    <?php
}

// Twitter
function uwp_social_twitter_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <p>
            <b>Application</b> id and secret (also sometimes referred as <b>Consumer</b> key and secret
            or <b>Client</b> id and secret) are what we call an application credentials.
            This application will link your website <code><?php echo $_SERVER["SERVER_NAME"]; ?></code> to <code>Twitter API</code>
            and these credentials are needed in order for <b>Twitter</b> users to access your website.
        </p>

        <p>
            These credentials may also differ in format, name and content depending on the social network.
        </p>

        <p>
            To enable authentication with this provider and to register a new <b>Twitter API Application</b>, follow the steps
        </p>

        <ol>
            <li>
                First go to: <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>
            </li>
            <li>
                Create a new application.
            </li>
            <li>
                Fill out any required fields such as the application name and description.
            </li>
            <li>
                Provide this URL as the <b>Callback URL</b> for your application: <br>
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Twitter</code>
            </li>
            <li>
                Once you have registered, past the created application credentials (Consumer Key and Secret) into the boxes above.
            </li>
            <li>
                And that's it!
            </li>
        </ol>

    </div>
    <?php
}

// LinkedIn
function uwp_social_linkedin_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">

        <ol>
            <li>
                Go to <a target="_blank" href="https://www.linkedin.com/developer/apps">https://www.linkedin.com/developer/apps</a> and <strong>create
                    a new application</strong> by clicking "Create Application".
            </li>
            <li>
                Fill out any required fields such as the application name and description.
            </li>
            <li>
                Put your website domain in the OAuth 2.0 Authorized Redirect URLs: (i.e
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=LinkedIn</code>)
            </li>
            <li>
                Once you have registered, past the created application credentials into the boxes above.
            </li>
        </ol>
    </div>
    <?php
}

// Instagram
function uwp_social_instagram_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                Go to <a href="http://instagram.com/developer/clients/manage/">instagram.com/developer/clients/manage/</a> and <strong>create a new application</strong> (Register new Client).
            </li>
            <li>
                Fill out any required fields such as the application name and description.
            </li>
            <li>
                Provide this URL as the <strong>OAuth redirect_uri</strong> (callback url) for your application: <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Instagram</code>
            </li>
            <li>
                Once you have registered, past the created application credentials into the boxes above.
            </li>
        </ol>
    </div>
    <?php
}

// Yahoo
function uwp_social_yahoo_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">

        <ol>
            <li>
                Go to <a target="_blank" href="https://developer.yahoo.com/apps">https://developer.yahoo.com/apps</a> and <strong>create
                    a new application</strong> by clicking "Create an App".
            </li>
            <li>
                Fill out any required fields such as the Application Name.
            </li>
            <li>
                Specify the domain to which your application will be returning after successfully authenticating. (i.e.
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Yahoo</code>
            </li>
            <li>
                Select private user data APIs that your application needs to access.
            </li>
            <li>
                Once you have registered, past the created application credentials into the boxes above.
            </li>
        </ol>
    </div>
    <?php
}

// vkontakte
function uwp_social_vkontakte_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                Go to <a href="https://vk.com/apps?act=manage">vk.com/apps?act=manage</a> and <strong>create a new application</strong>.
            </li>
            <li>
                Fill out any required fields such as the application name and description.
            </li>
            <li>
                Provide this URL as the <strong>OAuth redirect_uri</strong> (callback url) for your application: <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Vkontakte</code>
            </li>
            <li>
                Once you have registered, past the created application credentials into the boxes above.
            </li>
        </ol>
    </div>
    <?php
}

// WordPress
function uwp_social_wordpress_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                Go to <a href="https://developer.wordpress.com/apps/">developer.wordpress.com/apps/</a> and <strong>create a new application</strong>.
            </li>
            <li>
                Fill out any required fields such as the application name and description.
            </li>
            <li>
                Provide this URL as the <strong>Redirect URLs</strong> for your application: <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=WordPress</code>
            </li>
            <li>
                Once you have registered, past the created application credentials into the boxes above.
            </li>
        </ol>
    </div>
    <?php
}

add_action('uwp_admin_sub_menus', 'uwp_add_admin_social_sub_menu', 10, 1);
function uwp_add_admin_social_sub_menu($settings_page) {

    add_submenu_page(
        "userswp",
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
        'instagram' => __( 'Instagram', 'uwp-social' ),
        'yahoo' => __( 'Yahoo', 'uwp-social' ),
        'wordpress' => __( 'WordPress', 'uwp-social' ),
        'vkontakte' => __( 'VKontakte', 'uwp-social' ),
    );
    return $tabs;
}

add_filter('uwp_registered_settings', 'uwp_add_social_settings');
function uwp_add_social_settings($uwp_settings) {

    $options = array(
        'uwp_social_settings_info' => array(
            'id'   => 'uwp_social_settings_info',
            'name' => __( 'Info', 'uwp-social' ),
            'desc' => __( 'You can allow users to login via several social networks, once enabled the login icons will appear on most login forms and you can also use the UWP widget to add a social login buttons to widget areas.', 'uwp-social' ),
            'type' => 'info',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        )
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
            'name' => __( 'Google APP ID', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Google APP ID', 'uwp-social' )
        ),
        'uwp_social_google_secret' => array(
            'id' => 'uwp_social_google_secret',
            'name' => __( 'Google APP Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Google APP Secret', 'uwp-social' )
        ),
        'uwp_social_google_callback' => array(
            'id' => 'uwp_social_google_callback',
            'name' => __( 'Google APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=Google',
        ),
        'uwp_social_google_pick_username' => array(
            'id'   => 'uwp_social_google_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_google_pick_email' => array(
            'id'   => 'uwp_social_google_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
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
        'uwp_social_facebook_id' => array(
            'id' => 'uwp_social_facebook_id',
            'name' => __( 'Facebook API ID', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Facebook API ID', 'uwp-social' )
        ),
        'uwp_social_facebook_secret' => array(
            'id' => 'uwp_social_facebook_secret',
            'name' => __( 'Facebook API Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Facebook API Secret', 'uwp-social' )
        ),
        'uwp_social_facebook_callback' => array(
            'id' => 'uwp_social_facebook_callback',
            'name' => __( 'Facebook APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=Facebook',
        ),
        'uwp_social_facebook_pick_username' => array(
            'id'   => 'uwp_social_facebook_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_facebook_pick_email' => array(
            'id'   => 'uwp_social_facebook_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
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
            'name' => __( 'Twitter API Key', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Twitter API Key', 'uwp-social' )
        ),
        'uwp_social_twitter_secret' => array(
            'id' => 'uwp_social_twitter_secret',
            'name' => __( 'Twitter API Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Twitter API Secret', 'uwp-social' )
        ),
        'uwp_social_twitter_callback' => array(
            'id' => 'uwp_social_twitter_callback',
            'name' => __( 'Twitter APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=Twitter',
        ),
        'uwp_social_twitter_pick_username' => array(
            'id'   => 'uwp_social_twitter_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_twitter_pick_email' => array(
            'id'   => 'uwp_social_twitter_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
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
        'uwp_social_linkedin_id' => array(
            'id' => 'uwp_social_linkedin_id',
            'name' => __( 'LinkedIn Client ID', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter LinkedIn Client ID', 'uwp-social' )
        ),
        'uwp_social_linkedin_secret' => array(
            'id' => 'uwp_social_linkedin_secret',
            'name' => __( 'LinkedIn Client Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter LinkedIn Client Secret', 'uwp-social' )
        ),
        'uwp_social_linkedin_callback' => array(
            'id' => 'uwp_social_linkedin_callback',
            'name' => __( 'LinkedIn APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=LinkedIn',
        ),
        'uwp_social_linkedin_pick_username' => array(
            'id'   => 'uwp_social_linkedin_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_linkedin_pick_email' => array(
            'id'   => 'uwp_social_linkedin_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
    );

    $instagram_options = array(
        'enable_uwp_social_instagram' => array(
            'id'   => 'enable_uwp_social_instagram',
            'name' => 'Enable Instagram',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_instagram_id' => array(
            'id' => 'uwp_social_instagram_id',
            'name' => __( 'Instagram APP ID', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Instagram APP ID', 'uwp-social' )
        ),
        'uwp_social_instagram_secret' => array(
            'id' => 'uwp_social_instagram_secret',
            'name' => __( 'Instagram APP Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Instagram APP Secret', 'uwp-social' )
        ),
        'uwp_social_instagram_callback' => array(
            'id' => 'uwp_social_instagram_callback',
            'name' => __( 'Instagram APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=Instagram',
        ),
        'uwp_social_instagram_pick_username' => array(
            'id'   => 'uwp_social_instagram_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_instagram_pick_email' => array(
            'id'   => 'uwp_social_instagram_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
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
        'uwp_social_yahoo_id' => array(
            'id' => 'uwp_social_yahoo_id',
            'name' => __( 'Yahoo Client ID', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Yahoo Client ID', 'uwp-social' )
        ),
        'uwp_social_yahoo_secret' => array(
            'id' => 'uwp_social_yahoo_secret',
            'name' => __( 'Yahoo Client Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Yahoo Client Secret', 'uwp-social' )
        ),
        'uwp_social_yahoo_callback' => array(
            'id' => 'uwp_social_yahoo_callback',
            'name' => __( 'Yahoo APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=Yahoo',
        ),
        'uwp_social_yahoo_pick_username' => array(
            'id'   => 'uwp_social_yahoo_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_yahoo_pick_email' => array(
            'id'   => 'uwp_social_yahoo_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
    );

    $wordpress_options = array(
        'enable_uwp_social_wordpress' => array(
            'id'   => 'enable_uwp_social_wordpress',
            'name' => 'Enable WordPress',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_wordpress_id' => array(
            'id' => 'uwp_social_wordpress_id',
            'name' => __( 'WordPress APP ID', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter WordPress APP ID', 'uwp-social' )
        ),
        'uwp_social_wordpress_secret' => array(
            'id' => 'uwp_social_wordpress_secret',
            'name' => __( 'WordPress APP Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter WordPress APP Secret', 'uwp-social' )
        ),
        'uwp_social_wordpress_callback' => array(
            'id' => 'uwp_social_wordpress_callback',
            'name' => __( 'WordPress APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=WordPress',
        ),
        'uwp_social_wordpress_pick_username' => array(
            'id'   => 'uwp_social_wordpress_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_wordpress_pick_email' => array(
            'id'   => 'uwp_social_wordpress_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
    );

    $vkontakte_options = array(
        'enable_uwp_social_vkontakte' => array(
            'id'   => 'enable_uwp_social_vkontakte',
            'name' => 'Enable Vkontakte',
            'desc' => '',
            'type' => 'checkbox',
            'std'  => '1',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_vkontakte_id' => array(
            'id' => 'uwp_social_vkontakte_id',
            'name' => __( 'Vkontakte APP ID', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Vkontakte APP ID', 'uwp-social' )
        ),
        'uwp_social_vkontakte_secret' => array(
            'id' => 'uwp_social_vkontakte_secret',
            'name' => __( 'Vkontakte APP Secret', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'size' => 'regular',
            'placeholder' => __( 'Enter Vkontakte APP Secret', 'uwp-social' )
        ),
        'uwp_social_vkontakte_callback' => array(
            'id' => 'uwp_social_vkontakte_callback',
            'name' => __( 'Vkontakte APP Callback URL', 'uwp-social' ),
            'desc' => "",
            'type' => 'text',
            'readonly' => true,
            'size' => 'regular',
            'std'  => UWP_SOCIAL_HYBRIDAUTH_ENDPOINT.'?hauth.done=Vkontakte',
        ),
        'uwp_social_vkontakte_pick_username' => array(
            'id'   => 'uwp_social_vkontakte_pick_username',
            'name' => 'Let the user to enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_vkontakte_pick_email' => array(
            'id'   => 'uwp_social_vkontakte_pick_email',
            'name' => 'Let the user to enter email?',
            'desc' => 'By default, the email returned by the provider is used. If this option enabled then we would ask the user to enter the email by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
    );


    $uwp_settings['uwp_social'] = array(
        'main' => apply_filters( 'uwp_settings_social', $options),
        'google' => apply_filters( 'uwp_settings_social_google', $google_options),
        'facebook' => apply_filters( 'uwp_settings_social_facebook', $facebook_options),
        'twitter' => apply_filters( 'uwp_settings_social_twitter', $twitter_options),
        'linkedin' => apply_filters( 'uwp_settings_social_linkedin', $linkedin_options),
        'instagram' => apply_filters( 'uwp_settings_social_instagram', $instagram_options),
        'yahoo' => apply_filters( 'uwp_settings_social_yahoo', $yahoo_options),
        'wordpress' => apply_filters( 'uwp_settings_social_wordpress', $wordpress_options),
        'vkontakte' => apply_filters( 'uwp_settings_social_vkontakte', $vkontakte_options),
    );

    return $uwp_settings;
}
