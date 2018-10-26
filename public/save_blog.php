<?php
	require_once 'includes/Blog.php';

$rest_json = file_get_contents("php://input");
    
$_POST = json_decode($rest_json, true);

$is_new_blog = true;
$blog = new Blog();

if(isset($_POST['id'])){
	$blog->id = $_POST['id'];
	$is_new_blog = false;
}

$title = $_POST['title'];

if(isset($title) && strlen($title) > 0){
	$blog->slug = createSlug($title);
}
	
$blog->title = $title;
$blog->body = $_POST['body'];
$blog->creator_json = $_POST['creator_json'];
$blog->slug = $_POST['slug'];
$blog->cover_url = $_POST['cover_url'];
$blog->author = $_POST['author'];
$blog->published_at = $_POST['published_at'];

$new_blog_id = $blog->save();

if($new_blog_id){
	if($is_new_blog)
		echo json_encode(["new_id" => $new_blog_id, "status" => true]);
	else 
		echo json_encode(["status" => true]);
}
else
	echo json_encode(["status" => false]);



function createSlug($str, $delimiter = '-'){
	$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
	return $slug;
}