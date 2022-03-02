<?php
/**
 * Add link to index.php into navigation drawer.
 *      
 * @param global_navigation $nav Node representing the global navigation tree.
 */


 
function local_helloworld_before_footer(){
    global $DB;
    global $USER;
    // $messages = $DB->get_records('local_message');
    $params = [
        'userid' => $USER->id,
    ];
    $sql ="SELECT lm.id , lm.messagetext, lm.messagetype
            FROM {local_message} lm
            LEFT OUTER JOIN {local_message_read} lmr ON lm.id= lmr.messageid
            WHERE lmr.userid <> :userid
        ";
    
    $messages = $DB->get_records_sql($sql,$params);
    foreach( $messages as $message){
        $type ='error';
        if($message->messagetype === '0'){
            $type= \core\output\notification::NOTIFY_WARNING;
        }
        if($message->messagetype === '1'){
            $type= \core\output\notification::NOTIFY_SUCCESS;
        }
        if($message->messagetype === '2'){
            $type= \core\output\notification::NOTIFY_INFO;
        }
        // \core\notification::add($message->messagetext, $type );
        
        $readrecord = new stdClass();
        $readrecord->messageid = $message->id;
        $readrecord->userid = $USER->id;
        $readrecord->timeread = time();
        // $DB->insert_record('local_message_read',$readrecord);
   
    }

    // die("hello");
    // $message ="a test message";
    // $type = \core\output\notification::NOTIFY_WARNING;
    // \core\notification::add($message, $type );
}

// function local_helloworld_extend_navigation_frontpage(navigation_node $nav) {
//     $node = $nav->add(get_string('pluginname','local_helloworld'),'/local/helloworld/', navigation_node::NODETYPE_LEAF,null,null, new pix_icon('i/report', 'grades'));
//     $node->nodetype=1;
//     $node->collapse=false;
//     $node->forceopen=true;
//     $node->isexpandable=false;
//     $node->showinflatnavigation=true;

// }

