<?php

require 'class.iCalReader.php';
date_default_timezone_set('America/Los_Angeles');

$url_or_filename = 'http://www.google.com/calendar/ical/pdx.edu_47pvfc2jj25a8ea9cghvmlo948@group.calendar.google.com/public/basic.ics';
$ical = new ICal($url_or_filename);
foreach ($ical->events() as $event) {
  print_r(
    array(
      'title' => $event['SUMMARY'],
      'description' => $event['DESCRIPTION'],
      'location' => $event['LOCATION'],
      'start_time' => $ical->iCalDateToUnixTimestamp($event['DTSTART']),
      'end_time' => $ical->iCalDateToUnixTimestamp($event['DTEND']),
      'created_time' => $ical->iCalDateToUnixTimestamp($event['CREATED']),
    )
  );
}
