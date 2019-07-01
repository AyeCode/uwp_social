<?php
function uwp_email_exists( $email )
{
    if( function_exists('email_exists') )
    {
        return email_exists( $email );
    }

    if( $user = get_user_by( 'email', $email ) )
    {
        return $user->ID;
    }

    return false;
}

function uwp_get_social_profile( $provider, $provider_uid )
{
    global $wpdb;

    $sql = "SELECT user_id FROM `{$wpdb->base_prefix}uwp_social_profiles` WHERE provider = %s AND identifier = %s";

    return $wpdb->get_var( $wpdb->prepare( $sql, $provider, $provider_uid ) );
}

function uwp_get_social_profile_by_email_verified( $email_verified )
{
    global $wpdb;

    $sql = "SELECT user_id FROM `{$wpdb->base_prefix}uwp_social_profiles` WHERE emailverified = %s";

    return $wpdb->get_var( $wpdb->prepare( $sql, $email_verified ) );
}

function uwp_social_store_user_profile( $user_id, $provider, $profile )
{
    
    global $wpdb;
    
    $wpdb->show_errors();

    $sql = "SELECT id, object_sha FROM `{$wpdb->base_prefix}uwp_social_profiles` where user_id = %d and provider = %s and identifier = %s";

    $rs  = $wpdb->get_results( $wpdb->prepare( $sql, $user_id, $provider, $profile->identifier ) );

    // we only sotre the user profile if it has changed since last login.
    $object_sha = sha1( serialize( $profile ) );

    // checksum
    if( ! empty( $rs ) && $rs[0]->object_sha == $object_sha )
    {
        return false;
    }

    $table_data = array(
        "id"         => 'null',
        "user_id"    => $user_id,
        "provider"   => $provider,
        "object_sha" => $object_sha
    );

    if(  ! empty( $rs ) )
    {
        $table_data['id'] = $rs[0]->id;
    }

    $fields = array(
        'identifier',
        'profileurl',
        'websiteurl',
        'photourl',
        'displayname',
        'description',
        'firstname',
        'lastname',
        'gender',
        'language',
        'age',
        'birthday',
        'birthmonth',
        'birthyear',
        'email',
        'emailverified',
        'phone',
        'address',
        'country',
        'region',
        'city',
        'zip'
    );
    
    foreach( $profile as $key => $value )
    {
        $key = strtolower($key);

        if( in_array( $key, $fields ) )
        {
            $table_data[ $key ] = (string) $value;
        }
    }

    $wpdb->replace( "{$wpdb->base_prefix}uwp_social_profiles", $table_data );

    return $wpdb->insert_id;
}

function uwp_social_err_template_html_head() {
    ?>
    <head>
        <meta name="robots" content="NOINDEX, NOFOLLOW">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php bloginfo('name'); ?> - <?php _e("Oops! We ran into an issue", 'uwp-social') ?>.</title>
        <style type="text/css">
            body {
                background: #f1f1f1;
            }
            h4 {
                color: #666;
                font: 20px "Open Sans", sans-serif;
                margin: 0;
                padding: 0;
                padding-bottom: 7px;
            }
            p {
                font-size: 14px;
                margin: 15px 0;
                line-height: 25px;
                padding: 10px;
                text-align:left;
            }
            a {
                color: #21759B;
                text-decoration: none;
            }
            a:hover {
                color: #D54E21;
            }
            #error-page {
                background: #fff;
                color: #444;
                font-family: "Open Sans", sans-serif;
                margin: 2em auto;
                padding: 1em 2em;
                max-width: 700px;
                -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.13);
                box-shadow: 0 1px 3px rgba(0,0,0,0.13);
                margin-top: 50px;
            }
            #error-page pre {
                max-width: 680px;
                overflow: scroll;
                padding: 5px;
                background: none repeat scroll 0 0 #F5F5F5;
                border-radius:3px;
                font-family: Consolas, Monaco, monospace;
            }
            .error-message {
                line-height: 26px;
                background-color: #f2f2f2;
                border: 1px solid #ccc;
                padding: 10px;
                text-align:center;
                box-shadow: 0 1px 3px rgba(0,0,0,0.13);
                margin-top:25px;
            }
            .error-hint{
                margin:0;
            }
            #debuginfo {
                display:none;
                text-align: center;
                margin: 0;
                padding: 0;
                padding-top: 10px;
                margin-top: 10px;
                border-top: 1px solid #d2d2d2;
            }
        </style>
    </head>
    <?php
}


function uwp_social_destroy_session_on_logout() {
    if ( isset( $_SESSION['uwp::userprofile'] ) && $_SESSION['uwp::userprofile'] ) {
        unset( $_SESSION['uwp::userprofile']);
    }
}
add_action('wp_logout', 'uwp_social_destroy_session_on_logout');

//When deleting user also delete the social profile row.
add_action('delete_user', 'uwp_social_delete_user_row');
function uwp_social_delete_user_row($user_id) {
    if (!$user_id) {
        return;
    }

    global $wpdb;
    $social_table = $wpdb->base_prefix . 'uwp_social_profiles';
    $wpdb->query($wpdb->prepare("DELETE FROM {$social_table} WHERE user_id = %d", $user_id));
}
