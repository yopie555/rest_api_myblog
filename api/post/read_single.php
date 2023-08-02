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

//something.com?id=1
//Get ID from URL
//if id is set, then assign it to $post->id, otherwise, 
//kill the script (ternary operator)
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$post->read_single();

//Create array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

//Make JSON
print_r(json_encode($post_arr));
