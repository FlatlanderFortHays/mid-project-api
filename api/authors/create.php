<?php
// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if author name is provided
if(!empty($data->author)) {
    $author->author = $data->author;

    // Create author
    if($author->create()) {
        echo json_encode(
            array('id' => $db->lastInsertId(), 'author' => $author->author)
        );
    } else {
        echo json_encode(array('message' => 'Author Not Created'));
    }
} else {
    // Required error message for missing parameters
    echo json_encode(array('message' => 'Missing Required Parameters'));
}