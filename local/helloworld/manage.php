<?php

require_once(__DIR__ . '/../../config.php');

global $DB;
$PAGE->set_url(new moodle_url('/local/helloworld/manage.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Manage messages');


$messages = $DB->get_records('local_message');
echo $OUTPUT->header();

$templatecontext = (object)[
    // 'texttodisplay'=> 'List of current messages',
    'messages' => array_values($messages),
    'editurl' => new moodle_url('/local/helloworld/edit.php'),
];

echo $OUTPUT->render_from_template('local_helloworld/manage',$templatecontext);

echo $OUTPUT->footer();