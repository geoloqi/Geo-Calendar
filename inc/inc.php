<?php
include('inc/config.php');
include('geoloqi-sdk-php/Geoloqi.php');

$geoloqi = new Geoloqi(GEOLOQI_API_KEY, GEOLOQI_API_SECRET, 'http://' . $_SERVER['SERVER_NAME'] . '/login.php');


function get($k, $default=null) {
  return array_key_exists($k, $_GET) ? $_GET[$k] : $default;
}

function post($k, $default=null) {
  return array_key_exists($k, $_POST) ? $_POST[$k] : $default;
}

