<?php
// Get ID from URL
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get quote
if($quote->read_single()) {
    // Create array - Note we use 'author' and 'category' as keys per rubric
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author_name,
        'category' => $quote->category_name
    );

    // Make JSON
    echo json_encode($quote_arr);
} else {
    // Required error message if quote ID doesn't exist
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}