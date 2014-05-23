<?php
/**
 * This controller processes a SAML response and deals with
 * user matching, creation and authentication
 * Upon successful authentication it redirects to the URL 
 * the user was trying to access.
 * Upon failure it redirects to the Maestrano access
 * unauthorized page
 *
 */

//-----------------------------------------------
// Define root folder
//-----------------------------------------------
require dirname(__FILE__) . '/../../app/initializers/auth_controllers.php';

// Destroy session completely to avoid garbage (undeclared classes)
// but keep previous url if defined
session_start();
if(isset($_SESSION['mno_previous_url'])) {
	$previous_url = $_SESSION['mno_previous_url'];
}
session_unset();
session_destroy();

// Restart session and inject previous url if defined
session_start();
if(isset($previous_url)) {
	$_SESSION['mno_previous_url'] = $previous_url;
}

// Options variable
if (!isset($opts)) {
  $opts = array();
}

// Build SAML response
$samlResponse = Maestrano::sso()->buildResponse($_POST['SAMLResponse']);

try {
    if ($samlResponse->isValid()) {
        
        // Get Maestrano User and group
        $sso_user = new Maestrano_Sso_User($samlResponse, $opts);
        $sso_group = new Maestrano_Sso_Group($samlResponse, $opts);
        
        // Try to match the user with a local one
        $sso_user->matchLocal();
        
        // If user was not matched then attempt
        // to create a new local user
        if (!$sso_user->isMatched()) {
          $sso_user->createLocalUserOrDenyAccess();
        }
        
        // Once user is matched/created
        // Deal with group association
        $user_group_linked = false;
        if ($sso_user->isMatched()) {
          $sso_group->matchLocal();
          
          // If group does not exist then create it
          if (!$sso_group->isMatched()) {
            $user_group_linked = $sso_group->createLocalGroupAndMatch();
          }
          
          // Add user to the group (if not already)
          $user_group_linked = $sso_group->addUser($sso_user, $sso_user->group_role);
        }
        
        // If user is matched then sign it in
        // Refuse access otherwise
        if ($sso_user->isMatched() && $sso_group->isMatched() && $user_group_linked) {
          $sso_user->signIn();
          header("Location: " . Maestrano::sso()->getAfterSignInPath());
        } else {
          header("Location: " . Maestrano::sso()->getUnauthorizedUrl());
        }
    }
    else {
        echo 'There was an error during the authentication process.<br/>';
        echo 'Please try again. If issue persists please contact support@maestrano.com';
    }
}
catch (Exception $e) {
    echo 'There was an error during the authentication process.<br/>';
    echo 'Please try again. If issue persists please contact support@maestrano.com';
    echo $e;
}
