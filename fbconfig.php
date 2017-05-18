<?php
 require_once('Connections/repasses.php');
  require_once('log.php');
@session_start();
error_reporting (E_ALL); 
ini_set ('display_errors',  1);
session_start();
require'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '1654396901493310','9c31f0afbea6e5ade6f304cc9adb13e5' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://carrobomebarato.com/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
// save the session
  $_SESSION['fb_token'] = $session->getToken();
  // create a session using saved token or the new one we generated at login
  $session = new FacebookSession( $session->getToken() );

  // graph api request for user data with response           
$graphObject = (new FacebookRequest( $session, 'GET', '/me?fields=id,first_name,name,email,last_name,tagged_places' ))->execute()->getGraphObject()->asArray();
$_SESSION['FBID']= $graphObject['id'];
$_SESSION['id_facebook']= $graphObject['id'];
$_SESSION['first_name_facebook']= $graphObject['first_name'];
$_SESSION['name_facebook']= $graphObject['name'];
$_SESSION['email_facebook']= $graphObject['email'];
$_SESSION['last_name_facebook']= $graphObject['last_name'];
echo $sql ="SELECT id FROM membros WHERE  idfacebook = '". $_SESSION['id_facebook']."' 
	ORDER BY id DESC "; 
	$query = $mysql->query($sql);
 echo $totalRows_propostas = $query->num_rows;
 
  if($totalRows_propostas =='0'){
$loginUrl="http://carrobomebarato.com/cadastro?facebook";
}
 if( $totalRows_propostas =='1'){
$loginUrl="http://carrobomebarato.com/login?facebook";
}
 header("Location: ".$loginUrl);
} else {
  $loginUrl = $helper->getLoginUrl();
 header("Location: ".$loginUrl);
}
?>