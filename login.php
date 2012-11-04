<?php
include('inc/inc.php');
include('inc/session.php');

if(get('logout') !== null) {
  $geoloqi->logout();
  unset($_SESSION[$sessionName]);
  header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php');
  die();
}

if(get('code')) {
  $_SESSION[$name] = $geoloqi->getAuthWithCode($_GET['code']);
  header('Location: http://' . $_SERVER['SERVER_NAME'] . '/setup.php');
  die();
}

$geoloqi->login();

