<?php
//-----------------------------------------------
// Define root folder
//-----------------------------------------------
if (!defined('MAESTRANO_ROOT')) {
  define("MAESTRANO_ROOT", realpath(dirname(__FILE__) . '/../../'));
}

//-----------------------------------------------
// Require Maestrano library
//-----------------------------------------------
require_once MAESTRANO_ROOT . '/lib/maestrano-php/lib/Maestrano.php';

//-----------------------------------------------
// Require Model customization files
//-----------------------------------------------
require_once MAESTRANO_ROOT . '/app/models/sso/User.php';
require_once MAESTRANO_ROOT . '/app/models/sso/Group.php';

//-----------------------------------------------
// Configure Maestrano
//-----------------------------------------------
Maestrano::configure(array(
  'environment'          => 'test', # 'test' or 'production'
  'api_key'              => 'api_key_from_sandbox_or_production',
  'app_host'             => 'http://localhost:8888',
  'sso_enabled'          => true,
  'sso_app_init_path'    => '/maestrano/auth/saml/index.php',
  'sso_app_consume_path' => '/maestrano/auth/saml/consume.php',
  'user_creation_mode'   => 'virtual'
));
