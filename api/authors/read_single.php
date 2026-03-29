<?php
// Get ID from URL
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get author
if($author->read_single()) {
    // Create array
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author_name
    );

    // Make JSON
    echo json_encode($author_arr);
} else {
    echo json_encode(array('message' => 'Author Not Found'));
}