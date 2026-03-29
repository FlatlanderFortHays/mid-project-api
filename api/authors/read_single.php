<?php
// Get ID from URL - use null instead of die()
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $author->id = $id;

    // Get author
    if($author->read_single()) {
        $author_arr = array(
            'id' => $author->id,
            'author' => $author->author_name
        );
        echo json_encode($author_arr);
    } else {
        echo json_encode(array('message' => 'Author Not Found'));
    }
} else {
    echo json_encode(array('message' => 'Author Not Found'));
}