<?php
// Get ID from URL parameters
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get the category details
if($category->read_single()) {
    // Create array for JSON output
    $cat_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    // Output JSON
    echo json_encode($cat_arr);
} else {
    // Required error message if the ID does not exist
    echo json_encode(array('message' => 'category_id Not Found'));
}