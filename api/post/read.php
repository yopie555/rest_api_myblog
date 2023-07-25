<?php
//headers
header('Access-Control-Allow-Origin: *'); //public
header('Content-Type: application/json'); //json

include_once '../../config/Database.php'; //database connection
include_once '../../models/Post.php'; //post model

//Instantiate DB & connect
$database = new Database(); //create database object
$db = $database->connect(); //call connect method

//Instantiate blog post object
$post = new Post($db); //create post object

//Blog post query
$result = $post->read(); //call read method

//Get row count
$num = $result->rowCount(); //get row count

//Check if any posts
if ($num > 0) {
    //Post array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) { //fetch associative array
        extract($row); //extract row

        $post_item = array( //create post item
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body), //decode html entities
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );
        //Push to "data"
        array_push($posts_arr['data'], $post_item);
    }
    //Turn to JSON & output
    echo json_encode($posts_arr);
} else {
    //No posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}
