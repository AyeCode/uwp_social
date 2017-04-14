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

function uwp_social_get_provider_adapter( $provider )
{
    if( ! class_exists('Hybrid_Auth', false) )
    {
        require_once UWP_SOCIAL_LOGIN_PATH . "vendor/hybridauth/Hybrid/Auth.php";
    }

    $adapter                 = null;
    $config = null;

    try {
        $adapter = Hybrid_Auth::getAdapter( $provider );
    } catch( Exception $e )
    {
        echo uwp_social_render_error( $e, $config, $provider, $adapter );
        die();
    }
    return $adapter;
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