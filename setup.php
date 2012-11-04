<?php
include('inc/inc.php');
include('inc/session.php');
include('inc/header.php');
?>

<div class="row-fluid marketing">
  <div class="span6">

    <form action="import.php" method="post">
      <fieldset>
        <legend>Geo Calendar Import</legend>

        <p>Import your calendar data by uploading a file in iCal format</p>

        <label>Event List Name</label>
        <input type="text" placeholder="Required" name="name">

        <label>Icon URL (57x57px)</label>
        <input type="text" placeholder="Optionally specify an icon" name="icon">

        <label>Description</label>
        <input type="text" placeholder="Description of your calendar" name="description">

      </fieldset>

      <br />

      <fieldset>
        <legend>Specify an iCal File</legend>

        <div style="margin-bottom: 20px;">
          <label>From a file</label>
          <input type="file" name="ical_file">
        </div>

        <div>
          <label>From a URL</label>
          <input type="text" placeholder="http://" name="ical_url">
        </div>

      </fieldset>

      <br />
      <button type="submit" class="btn">Submit</button>
    </form>

  </div>
</div>

<?php
include('inc/footer.php');
