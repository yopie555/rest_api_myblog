<?php
//headers
header('Access-Control-Allow-Origin: *'); //public api
header('Content-Type: application/json'); //json data

include_once '../../config/Database.php'; //database connection
include_once '../../models/Post.php'; //post model

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//Blog post query
$result = $post->read();
//Get row count
$num = $result->rowCount();

//Check if any posts
if ($num > 0) {
    //Post array
    $posts_arr = array(); //this is the same as $posts_arr = [];
    $posts_arr['data'] = array(); //this is the same as $posts_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        //this is not needed because 
        //we are not using extract() in the model
        //this is the same as extract($row) 
        //but we are not using extract() in the model
        $post_item = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'body' => html_entity_decode($row['body']), //html_entity_decode() is used to decode html entities
            'author' => $row['author'],
            'category_id' => $row['category_id'],
            'category_name' => $row['category_name']
        );

        //Push to "data"
        array_push($posts_arr['data'], $post_item); //this is the same as $posts_arr['data'][] = $post_item;
    }

    //Turn to JSON & output
    echo json_encode($posts_arr);
}
