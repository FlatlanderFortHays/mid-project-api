<?php
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Requirement: Must contain id and author 
if(!empty($data->id) && !empty($data->author)) {
    $author->id = $data->id;
    $author->author = $data->author;

    // Attempt to update
    if($author->update()) {
        echo json_encode(
            array('id' => $author->id, 'author' => $author->author)
        );
    } else {
        // If the ID is valid but the record wasn't found [cite: 91]
        echo json_encode(array('message' => 'author_id Not Found'));
    }
} else {
    // Required if parameters are missing [cite: 93]
    echo json_encode(array('message' => 'Missing Required Parameters'));
}