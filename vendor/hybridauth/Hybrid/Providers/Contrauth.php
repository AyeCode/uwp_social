<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2014, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html 
*/

/**
 * Hybrid_Providers_Google provider adapter based on OAuth2 protocol
 * 
 * http://hybridauth.sourceforge.net/userguide/IDProvider_info_Google.html
 */
class Hybrid_Providers_Contrauth extends Hybrid_Provider_Model_OAuth2
{
    // > more infos on google APIs: http://developer.google.com (official site)
	// or here: http://discovery-check.appspot.com/ (unofficial but up to date)

	// default permissions 
	public $scope = "profile";

	/**
	* IDp wrappers initializer 
	*/
	function initialize() 
	{
		parent::initialize();

		// Provider api end-points
		$this->api->api_base_url   = "http://127.0.0.1:8000/oauth2/";
		$this->api->authorize_url  = "http://127.0.0.1:8000/oauth2/auth";
		$this->api->token_url      = "http://127.0.0.1:8000/oauth2/token";
		$this->api->token_info_url = "http://127.0.0.1:8000/oauth2/tokeninfo";
        
		// Override the redirect uri when it's set in the config parameters. This way we prevent
		// redirect uri mismatches when authenticating with Google.
		if( isset( $this->config['redirect_uri'] ) && ! empty( $this->config['redirect_uri'] ) ){
			$this->api->redirect_uri = $this->config['redirect_uri'];
		}
	}

	/**
	* begin login step 
	*/
	function loginBegin()
	{
		$parameters = array("scope" => $this->scope, "access_type" => "offline", "state" => str_shuffle("abcdefghijkl123456789"));
		$optionals  = array("scope", "access_type", "redirect_uri", "approval_prompt", "hd");

		foreach ($optionals as $parameter){
			if( isset( $this->config[$parameter] ) && ! empty( $this->config[$parameter] ) ){
				$parameters[$parameter] = $this->config[$parameter];
			}
			if( isset( $this->config["scope"] ) && ! empty( $this->config["scope"] ) ){
				$this->scope = $this->config["scope"];
			}
		}

        if( isset( $this->config[ 'force' ] ) && $this->config[ 'force' ] === true ){
            $parameters[ 'approval_prompt' ] = 'force';
        }

		Hybrid_Auth::redirect( $this->api->authorizeUrl( $parameters ) ); 
	}

	function loginFinish()
	{
		$error = (array_key_exists('error',$_REQUEST))?$_REQUEST['error']:"";

		// check for errors
		if ( $error ){
			throw new Exception( "Authentication failed! {$this->providerId} returned an error: " . htmlentities( $error ), 5 );
		}

		// try to authenticate user
		$code = (array_key_exists('code',$_REQUEST))?$_REQUEST['code']:"";

		try{
			$this->authenticate( $code );
		}
		catch( Exception $e ){
			throw new Exception( "Authentication failed! {$this->providerId} returned an error", 5 );
		}

		// check if authenticated
		if ( ! $this->api->access_token ){
			throw new Exception( "Authentication failed! {$this->providerId} returned an invalid access_token", 5 );
		}

		// store tokens
		$this->token( "access_token" , $this->api->access_token  );
		$this->token( "refresh_token", $this->api->refresh_token );
		$this->token( "expires_in"   , $this->api->access_token_expires_in );
		$this->token( "expires_at"   , $this->api->access_token_expires_at );

		// set user connected locally
		$this->setUserConnected();
	}

	function authenticate( $code )
	{
		$params = array(
			"client_id"     => $this->api->client_id,
			"grant_type"    => "authorization_code",
			"redirect_uri"  => $this->api->redirect_uri,
			"code"          => $code
		);

		$http_headers = array();
		$http_headers['Content-Type'] = 'application/x-www-form-urlencoded';
		$http_headers['Authorization'] = 'Basic ' . base64_encode( $this->api->client_id .  ':' . $this->api->client_secret);

		$response = $this->request( $this->api->token_url, http_build_query($params, '', '&'), 'POST', $http_headers );

		$response = $this->parseRequestResult( $response );

		if( ! $response || ! isset( $response->access_token ) ){
			throw new Exception( "The Authorization Service has return: " . $response->error );
		}

		if( isset( $response->access_token  ) ) $this->api->access_token            = $response->access_token;
		if( isset( $response->refresh_token ) ) $this->api->refresh_token           = $response->refresh_token;
		if( isset( $response->expires_in    ) ) $this->api->access_token_expires_in = $response->expires_in;

		// calculate when the access token expire
		if( isset( $response->expires_in ) ) {
			$this->api->access_token_expires_at = time() + $response->expires_in;
		}
		else {
			$this->api->access_token_expires_at = time() + 3600;
		}

		return $response;
	}

	private function request( $url, $params = array(), $type="GET", $http_headers = null )
	{
		if( $type == "GET" ){
			$url = $url . ( strpos( $url, '?' ) ? '&' : '?' ) . http_build_query($params, '', '&');
		}

		$this->http_info = array();
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL            , $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt($ch, CURLOPT_TIMEOUT        , $this->api->curl_time_out );
		curl_setopt($ch, CURLOPT_USERAGENT      , $this->api->curl_useragent );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , $this->api->curl_connect_time_out );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , $this->api->curl_ssl_verifypeer );
		curl_setopt($ch, CURLOPT_HTTPHEADER     , $this->api->curl_header );

		if (is_array($http_headers)) {
			$header = array();
			foreach($http_headers as $key => $parsed_urlvalue) {
				$header[] = "$key: $parsed_urlvalue";
			}

			curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
		}
		else{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->api->curl_header );
		}

		if($this->api->curl_proxy){
			curl_setopt( $ch, CURLOPT_PROXY        , $this->api->curl_proxy);
		}

		if( $type == "POST" ){
			curl_setopt($ch, CURLOPT_POST, 1);
			if($params) curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
		}

		$response = curl_exec($ch);

		$this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ch));

		curl_close ($ch);

		return $response;
	}

	private function parseRequestResult( $result )
	{
		if( json_decode( $result ) ) return json_decode( $result );

		parse_str( $result, $output );

		$result = new StdClass();

		foreach( $output as $k => $v )
			$result->$k = $v;

		return $result;
	}


	/**
	* load the user profile from the IDp api client
	*/
	function getUserProfile()
	{
		// refresh tokens if needed 
		$this->refreshToken();

		$response = $this->api->api( "http://127.0.0.1:8000/users/me" );

		if ( ! isset( $response->id ) || isset( $response->error ) ){
			throw new Exception( "User profile request failed! {$this->providerId} returned an invalid response.", 6 );
		}

		$this->user->profile->identifier    = (property_exists($response,'id'))?$response->id:((property_exists($response,'id'))?$response->id:"");
		$this->user->profile->firstName     = (property_exists($response,'name'))?$response->name->givenName:"";
		$this->user->profile->lastName      = (property_exists($response,'name'))?$response->name->familyName:"";
		$this->user->profile->displayName   = (property_exists($response,'displayName'))?$response->displayName:"";
		$this->user->profile->photoURL      = (property_exists($response,'image'))?((property_exists($response->image,'url'))?substr($response->image->url, 0, -2)."200":''):'';
		$this->user->profile->profileURL    = (property_exists($response,'url'))?$response->url:"";
		$this->user->profile->description   = (property_exists($response,'aboutMe'))?$response->aboutMe:"";
		$this->user->profile->gender        = (property_exists($response,'gender'))?$response->gender:""; 
		$this->user->profile->language      = (property_exists($response,'locale'))?$response->locale:'';
		$this->user->profile->email         = (property_exists($response,'email'))?$response->email:'';

		if (property_exists($response, 'emails')) {
			if (count($response->emails) == 1) {
				$this->user->profile->email = $response->emails[0]->value;
			} else {
				foreach ($response->emails as $email) {
					if ($email->type == 'account') {
						$this->user->profile->email = $email->value;
						break;
					}
				}
			}
		}

		$this->user->profile->emailVerified = $this->user->profile->email;

		$this->user->profile->phone 		= (property_exists($response,'phone'))?$response->phone:"";
		$this->user->profile->country 		= (property_exists($response,'country'))?$response->country:"";
		$this->user->profile->region 		= (property_exists($response,'region'))?$response->region:"";
		$this->user->profile->zip	 		= (property_exists($response,'zip'))?$response->zip:"";
		if( property_exists($response,'placesLived') ){
			$this->user->profile->city 	= ""; 
			$this->user->profile->address	= ""; 
			foreach($response->placesLived as $c){
				if(property_exists($c,'primary')){
					if($c->primary == true){ 
						$this->user->profile->address 	= $c->value;
						$this->user->profile->city 	= $c->value;
						break;
					}
				}else{
					if(property_exists($c,'value')){
						$this->user->profile->address 	= $c->value;
						$this->user->profile->city 	= $c->value;
					}	
				}
			}
		}
		
		// google API returns multiple urls, but a "website" only if it is verified 
		// see http://support.google.com/plus/answer/1713826?hl=en
		if( property_exists($response,'urls') ){
			foreach($response->urls as $u){
				if(property_exists($u, 'primary') && $u->primary == true) $this->user->profile->webSiteURL = $u->value;
			}
		} else {
			$this->user->profile->webSiteURL = '';
		}
		// google API returns age ranges or min. age only (with plus.login scope)
		if( property_exists($response,'ageRange') ){
			if( property_exists($response->ageRange,'min') && property_exists($response->ageRange,'max') ){
				$this->user->profile->age 	= $response->ageRange->min.' - '.$response->ageRange->max;
			} else {
				$this->user->profile->age 	= '> '.$response->ageRange->min;
			}
		} else {
			$this->user->profile->age = '';
		}
		// google API returns birthdays only if a user set 'show in my account'
		if( property_exists($response,'birthday') ){ 
			list($birthday_year, $birthday_month, $birthday_day) = explode( '-', $response->birthday );

			$this->user->profile->birthDay   = (int) $birthday_day;
			$this->user->profile->birthMonth = (int) $birthday_month;
			$this->user->profile->birthYear  = (int) $birthday_year;
		} else {
			$this->user->profile->birthDay=0;$this->user->profile->birthMonth=0;$this->user->profile->birthYear=0;
		}
                
		return $this->user->profile;
	}

	/**
	 * Add to the $url new parameters
	 * @param string $url
	 * @param array $params
	 * @return string
	 */
	function addUrlParam($url, array $params)
	{
		$query = parse_url($url, PHP_URL_QUERY);

		// Returns the URL string with new parameters
		if( $query ) {
			$url .= '&' . http_build_query( $params );
		} else {
			$url .= '?' . http_build_query( $params );
		}
		return $url;
	}
}
