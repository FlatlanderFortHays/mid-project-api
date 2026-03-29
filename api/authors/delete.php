<?php
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Requirement: Must contain id 
if(!empty($data->id)) {
    $author->id = $data->id;

    // Attempt to delete
    if($author->delete()) {
        echo json_encode(array('id' => $author->id));
    } else {
        // Message if no author found to delete [cite: 53]
        echo json_encode(array('message' => 'author_id Not Found'));
    }
} else {
    // General missing parameter message [cite: 73]
    echo json_encode(array('message' => 'Missing Required Parameters'));
}