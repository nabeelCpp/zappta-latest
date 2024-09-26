<?php 


// use Google_Client;
// use Google_Service;
// use Google_Service_Oauth2;

use Facebook\Facebook;


// client id
// 359343005755-5kkesbpql6s43trklun3ff5np026hnic.apps.googleusercontent.com

// client secret
//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

function FacebookKeys()
{
    return new Facebook([
                          'app_id' => '573323387834188',
                          'app_secret' => '786f2730e1390118e7b67438a31f4dbc',
                          'default_graph_version' => 'v14.0',
                      ]);
}

function facebook($refer=0)
{
    $fb = FacebookKeys();
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email'];
    return $helper->getLoginUrl(base_url().'/register/fb?refer='.$refer, $permissions);
}

function getFbAccessToken($code)
{
    $app_id = '573323387834188';
    $app_secret = '786f2730e1390118e7b67438a31f4dbc';
    $my_url = base_url().'/register/fb';
    $token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $app_secret . "&code=" . $code;
    $response = file_get_contents($token_url);
    $params = json_decode($response);
    return $params->access_token;
}

function getResponseFB($access_token)
{
    $fb = FacebookKeys();
    try {
      // Get the \Facebook\GraphNodes\GraphUser object for the current user.
      // If you provided a 'default_access_token', the '{access-token}' is optional.
      $response = $fb->get('/me?fields=id,name,email', $access_token);
      return $response->getGraphUser();
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
        return $e->getMessage();
      exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
        return $e->getMessage();
      exit;
    }
}

function google_login_url($refer=0)
{
    $gClient = new Google\Client();
    $gClient->setApplicationName('zappta');
    $gClient->setClientId('359343005755-5kkesbpql6s43trklun3ff5np026hnic.apps.googleusercontent.com');
    $gClient->setClientSecret('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');
    $gClient->setAccessType('offline');
    $gClient->setScopes(['profile','email']);
    $gClient->setRedirectUri(base_url().'/register/google/?refer='.$refer);
    new Google\Service($gClient);
    return $gClient->createAuthUrl();
}

function google_login_response($code)
{
    $client = new Google\Client();
    $client->setClientId('359343005755-5kkesbpql6s43trklun3ff5np026hnic.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri( base_url().'/register/google' );
    $token = $client->fetchAccessTokenWithAuthCode($code);
    $client->setAccessToken($token['access_token']);
    $google_oauth = new Google\Service\Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    return $google_account_info;
}

