<?php
include('inc/inc.php');
include('inc/session.php');
include('icalparser/class.icalreader.php');

date_default_timezone_set('America/Los_Angeles');

if(post('action') != 'save' && get('action') != 'save') {
  header('Location: http://' . $_SERVER['SERVER_NAME'] . '/setup.php');
  die();
}

if(request('name')) {
  $layer = $geoloqi->post('layer/create', array(
    'name' => request('name'),
    'key' => request('name'),
    'public' => 1
  ));  
}

if(isset($_FILES) && array_key_exists('ical_file', $_FILES) && $_FILES['ical_file']['tmp_name']) {
  $url_or_filename = $_FILES['ical_file']['tmp_name'];
} elseif(post('ical_url')) {
  $url_or_filename = post('ical_url');
} elseif(get('mode') == 'test') {
  $url_or_filename = FALSE;
} else {
  end_with_error('You must specify either an iCal URL or upload an .ics file.');
  die();
}

$events = array();

if($url_or_filename) {
  $ical = new ICal($url_or_filename);
  foreach($ical->events() as $event) {

    $e = array();

    $place = $geoloqi->post('place/create', array(
      'layer_id' => $layer->layer_id,
      'key' => $event['UID'],
      'description' => trim($event['DESCRIPTION']),
      'geocode' => str_replace("\\,", ',', $event['LOCATION']),
      'radius' => 500,
    ));
    $e['place'] = $place;

    if(property_exists($place, 'place_id')) {
      $trigger = $geoloqi->post('trigger/create', array(
        'place_id' => $place->place_id,
        'type' => 'message',
        'text' => $event['SUMMARY'] . ' at ' . $event['LOCATION'],
        'date_from' => ($ical->iCalDateToUnixTimestamp($event['DTSTART']) - 86400),
        'date_to' => $ical->iCalDateToUnixTimestamp($event['DTEND']),
        'url' => (array_key_exists('URL', $event) ? $event['URL'] : '')
      ));
      $e['trigger'] = $trigger;
    } else {
      $errors[] = array(
        'summary' => $event['SUMMARY'],
        'location' => str_replace("\\,", ',', $event['LOCATION'])
      );
    }

  }
}


include('inc/header.php');
?>
  <div class="row-fluid marketing">
    <div class="span6">

      <h2>Uploaded!</h2>
      
      <p>You can send this layer to other Geoloqi users to subscribe in the browser.</p>

      <form>
        <fieldset>
          <label>Layer Link</label>
          <input type="text" value="https://geoloqi.com/layer/<?= $layer->layer_id ?>">

          <br />

          <a href="https://geoloqi.com/layer/<?= $layer->layer_id ?>" class="btn btn-success">Subscribe on Geoloqi</a>
        </fieldset>
      </form>

    </div>
  </div>
<?php
include('inc/footer.php');




function end_with_error($message) {
  include('inc/header.php');
  ?>
  <div class="row-fluid marketing">
    <div class="span6">
      <h2>There was a problem!</h2>
      <?= $message ?>
    </div>
  </div>
  <?php
  include('inc/footer.php');
  die();
}

