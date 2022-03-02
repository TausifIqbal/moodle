<?php

require_once(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . '/local/helloworld/classes/form/edit.php');

global $DB;

$PAGE->set_url(new moodle_url('/local/helloworld/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Edit');



$mform = new edit();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/helloworld/manage.php', 'You cancelled the form');
} else if ($fromform = $mform->get_data()) {
  //In this case you process validated data. $mform->get_data() returns data posted in form.

//   var_dump($fromform);
//   die();

    // Insert the data into our database table
    $recordtoinsert = new stdClass();
    $recordtoinsert->messagetext = $fromform->messagetext;
    $recordtoinsert->messagetype = $fromform->messagetype;
    // var_dump($fromform);
    // var_dump($recordtoinsert);
    // die;
    $DB->insert_record('local_message',$recordtoinsert);
    redirect($CFG->wwwroot . '/local/helloworld/manage.php', 'You created a message  with title ' . $fromform->messagetext );

} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.

}
echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();