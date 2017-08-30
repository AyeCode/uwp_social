<?php
/**
 * Modifies the settings form title.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $title         Original title.
 * @param       string      $page          admin.php?page=uwp_xxx.
 * @param       string      $active_tab    active tab in that settings page.
 *
 * @return      string      Form title.
 */
function uwp_social_display_form_title($title, $page, $active_tab) {
    if ($page == 'uwp_social' && $active_tab == 'main') {
        $title = __('Social Settings', 'uwp-social');
    }
    return $title;
}
add_filter('uwp_display_form_title', 'uwp_social_display_form_title', 10, 3);

add_action('uwp_social_settings_main_tab_content', 'uwp_social_main_tab_content', 10, 1);
add_action('uwp_social_settings_google_tab_content', 'uwp_social_google_tab_content', 10, 1);
add_action('uwp_social_settings_facebook_tab_content', 'uwp_social_facebook_tab_content', 10, 1);
add_action('uwp_social_settings_twitter_tab_content', 'uwp_social_twitter_tab_content', 10, 1);
add_action('uwp_social_settings_linkedin_tab_content', 'uwp_social_linkedin_tab_content', 10, 1);
add_action('uwp_social_settings_instagram_tab_content', 'uwp_social_instagram_tab_content', 10, 1);
add_action('uwp_social_settings_yahoo_tab_content', 'uwp_social_yahoo_tab_content', 10, 1);
add_action('uwp_social_settings_vkontakte_tab_content', 'uwp_social_vkontakte_tab_content', 10, 1);
add_action('uwp_social_settings_wordpress_tab_content', 'uwp_social_wordpress_tab_content', 10, 1);

/**
 * Prints the settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_main_tab_content($form) {
    echo $form;
}

/**
 * Prints the Google settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_google_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                <?php echo __('First go to:', 'uwp-social'); ?> <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a>
            </li>
            <li>
                <?php echo __('On the <b>Dashboard sidebar</b> click on <b>Project</b> then click <b>Create Project</b>', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Once the project is created. Select that project, then <b>APIs & auth</b> > <b>Consent screen</b> and fill the required information.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Then <b>APIs & auth</b> > <b>APIs</b> and enable <b>Google+ API</b>. If you want to import the user contatcs enable <b>Contacts API</b> as well.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('After that you will need to create an new application: <b>APIs & auth</b> > <b>Credentials</b> and then click <b>Create new Client ID</b>.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('On the <b>Create Client ID</b> popup :', 'uwp-social'); ?>
            </li>
            <li>
                <ul style="margin-left:35px">
                    <li><?php echo __('Select <b>Web application</b> as your application type.', 'uwp-social'); ?></li>
                    <li><?php echo __('Put your website domain in the <b>Authorized JavaScript origins</b> field. This should match with the current hostname.', 'uwp-social'); ?></li>
                    <li><?php echo __('Provide this URL as the <b>Authorized redirect URI</b> for your application:', 'uwp-social'); ?></li>
                    <li><code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Google</code></li>
                </ul>
            </li>
            <li>
                <?php echo __('Once you have registered past the created application credentials (Client ID and Secret) into the boxes above', 'uwp-social'); ?>
            </li>
        </ol>
    </div>

    <?php
}

/**
 * Prints the Facebook settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_facebook_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                <?php echo __('First go to:', 'uwp-social'); ?> <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>
            </li>
            <li>
                <?php echo __('Select <b>Add a New App</b> from the <b>Apps</b> menu at the top.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Fill out Display Name, Namespace, choose a category and click <b>Create App</b>', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Go to Settings page and click on <b>Add Platform</b>.
                Choose website and enter in the new screen your website url in <b>App Domains</b> and <b>Site URL</b> fields.
                They should match with the current hostname', 'uwp-social'); ?>
                <b><?php echo $_SERVER["SERVER_NAME"]; ?></b>
            </li>
            <li>
                <?php echo __('Go to the <b>Status & Review</b> page and choose <b>yes</b> where it says <b>Do you want to make this app and all its live features available to the general public?</b>', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Go back to the <b>Dashboard</b> page and past the created application credentials (APP ID and Secret) into the boxes above.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __("And that's it!", 'uwp-social'); ?>
            </li>
        </ol>
    </div>
    <?php
}

/**
 * Prints the Twitter settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_twitter_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                <?php echo __('First go to:', 'uwp-social'); ?> <a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a>
            </li>
            <li>
                <?php echo __('Create a new application.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Fill out any required fields such as the application name and description.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Provide this URL as the <b>Callback URL</b> for your application:', 'uwp-social'); ?>
                <br>
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Twitter</code>
            </li>
            <li>
                <?php echo __('Once you have registered, past the created application credentials (Consumer Key and Secret) into the boxes above.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __("And that's it!", 'uwp-social'); ?>
            </li>
        </ol>

    </div>
    <?php
}

/**
 * Prints the LinkedIn settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_linkedin_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">

        <ol>
            <li>
                <?php echo sprintf(__('Go to <a href="%s">%s</a> and <strong>create a new application</strong>.'), "https://www.linkedin.com/developer/apps", "linkedin.com/developer/apps"); ?>
            </li>
            <li>
                <?php echo __('Fill out any required fields such as the application name and description.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Put your website domain in the OAuth 2.0 Authorized Redirect URLs:', 'uwp-social'); ?>
                <br>
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=LinkedIn</code>
            </li>
            <li>
                <?php echo __('Once you have registered, past the created application credentials into the boxes above.', 'uwp-social'); ?>
            </li>
        </ol>
    </div>
    <?php
}

/**
 * Prints the Instagram settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_instagram_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                <?php echo sprintf(__('Go to <a href="%s">%s</a> and <strong>create a new application</strong>.'), "http://instagram.com/developer/clients/manage/", "instagram.com/developer/clients/manage/"); ?>
            </li>
            <li>
                <?php echo __('Fill out any required fields such as the application name and description.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Provide this URL as the <strong>OAuth redirect_uri</strong> (callback url) for your application: ', 'uwp-social'); ?>
                <br>
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Instagram</code>
            </li>
            <li>
                <?php echo __('Once you have registered, past the created application credentials into the boxes above.', 'uwp-social'); ?>
            </li>
        </ol>
    </div>
    <?php
}

/**
 * Prints the Yahoo settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_yahoo_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">

        <ol>
            <li>
                <?php echo sprintf(__('Go to <a href="%s">%s</a> and <strong>create a new application</strong>.'), "https://developer.yahoo.com/apps", "developer.yahoo.com/apps"); ?>
            </li>
            <li>
                <?php echo __('Fill out any required fields such as the Application Name.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Specify the domain to which your application will be returning after successfully authenticating.', 'uwp-social'); ?>
                <br>
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Yahoo</code>
            </li>
            <li>
                <?php echo __('Select private user data APIs that your application needs to access.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Once you have registered, past the created application credentials into the boxes above.', 'uwp-social'); ?>
            </li>
        </ol>
    </div>
    <?php
}

/**
 * Prints the vkontakte settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_vkontakte_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                <?php echo sprintf(__('Go to <a href="%s">%s</a> and <strong>create a new application</strong>.'), "https://vk.com/apps?act=manage", "vk.com/apps?act=manage"); ?>
            </li>
            <li>
                <?php echo __('Fill out any required fields such as the application name and description.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Provide this URL as the <strong>OAuth redirect_uri</strong> (callback url) for your application:', 'uwp-social'); ?>
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=Vkontakte</code>
            </li>
            <li>
                <?php echo __('Once you have registered, past the created application credentials into the boxes above.', 'uwp-social'); ?>
            </li>
        </ol>
    </div>
    <?php
}

/**
 * Prints the WordPress settings form.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       string      $form         Setting form html.
 *
 * @return      void
 */
function uwp_social_wordpress_tab_content($form) {
    echo $form;
    ?>
    <div class="uwp_social_tab_content_help" style="">
        <ol>
            <li>
                <?php echo sprintf(__('Go to <a href="%s">%s</a> and <strong>create a new application</strong>.'), "https://developer.wordpress.com/apps/", "developer.wordpress.com/apps/"); ?>
            </li>
            <li>
                <?php echo __('Fill out any required fields such as the application name and description.', 'uwp-social'); ?>
            </li>
            <li>
                <?php echo __('Provide this URL as the <strong>Redirect URLs</strong> for your application: ', 'uwp-social'); ?>
                <code><?php echo UWP_SOCIAL_HYBRIDAUTH_ENDPOINT; ?>?hauth.done=WordPress</code>
            </li>
            <li>
                <?php echo __('Once you have registered, past the created application credentials into the boxes above.', 'uwp-social'); ?>
            </li>
        </ol>
    </div>
    <?php
}

add_action('uwp_admin_sub_menus', 'uwp_add_admin_social_sub_menu', 10, 1);
/**
 * Adds the current userswp addon settings page menu as submenu.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       callable   $settings_page    The function to be called to output the content for this page.
 *
 * @return      void
 */
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
/**
 * Adds settings tabs for the current userswp addon.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       array     $tabs    Existing tabs array.
 *
 * @return      array     Tabs array.
 */
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
/**
 * Registers form fields for the current userswp addon settings page.
 *
 * @since       1.0.0
 * @package     userswp
 *
 * @param       array     $uwp_settings    Existing settings array.
 *
 * @return      array     Settings array.
 */
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_google_pick_email' => array(
            'id'   => 'uwp_social_google_pick_email',
            'name' => 'Let the user enter email?',
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_facebook_pick_email' => array(
            'id'   => 'uwp_social_facebook_pick_email',
            'name' => 'Let the user enter email?',
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_twitter_pick_email' => array(
            'id'   => 'uwp_social_twitter_pick_email',
            'name' => 'Let the user enter email?',
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_linkedin_pick_email' => array(
            'id'   => 'uwp_social_linkedin_pick_email',
            'name' => 'Let the user enter email?',
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_instagram_pick_email' => array(
            'id'   => 'uwp_social_instagram_pick_email',
            'name' => 'Let the user enter email?',
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_yahoo_pick_email' => array(
            'id'   => 'uwp_social_yahoo_pick_email',
            'name' => 'Let the user enter email?',
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_wordpress_pick_email' => array(
            'id'   => 'uwp_social_wordpress_pick_email',
            'name' => 'Let the user enter email?',
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
            'name' => 'Let the user enter username?',
            'desc' => 'By default, the username is auto generated. If this option enabled then we would ask the user to pick the username by displaying a form.',
            'type' => 'checkbox',
            'std'  => '0',
            'class' => 'uwp_label_inline',
        ),
        'uwp_social_vkontakte_pick_email' => array(
            'id'   => 'uwp_social_vkontakte_pick_email',
            'name' => 'Let the user enter email?',
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
