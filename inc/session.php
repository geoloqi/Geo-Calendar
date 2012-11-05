<?php
$sessionName = 'geoloqi';
session_start();

if(isset($_SESSION[$name])) {
  $geoloqi->setAuth($_SESSION[$name]);
}
