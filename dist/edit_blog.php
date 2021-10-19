<?php
	require_once 'includes/Blog.php';
	$blog_id = $_GET['blog_id'];
  $blog = Blog::find($blog_id);
  $blog->creator_json = $blog->get_creator_json();
	// echo json_encode($blog);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <title>blog-creator</title>

    <link href="https://fonts.googleapis.com/css?family=Caudex:400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="css/flex.css">
	<link rel="stylesheet" href="css/blog_detail.css">
	
	<link href=css/app.css rel=preload as=style>
	<link href=js/app.js rel=preload as=script>
	<link href=js/chunk-vendors.js rel=preload as=script>
	<link href=css/app.css rel=stylesheet>
  </head>
  <body>
    <noscript>
      <strong>We're sorry but blog-creator doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>

    <div id="app">
	  <blog-creator
	  	  blog='<?php echo json_encode($blog); ?>'
        unsplash-client-id="17ef130962858e4304efe9512cf023387ee5d36f0585e4346f0f70b2f9729964"
        image-upload-url="upload_image.php"
        save-url="save_blog.php" />
    </div>

    <script>
      const UNSPLASH_CLIENT_ID = "17ef130962858e4304efe9512cf023387ee5d36f0585e4346f0f70b2f9729964";
      
      window.addEventListener("dragover",function(e){ e = e || event; e.preventDefault(); },false); 
      window.addEventListener("drop",function(e){e = e || event; e.preventDefault(); },false);
	</script>
	
	<script src=/js/chunk-vendors.js></script>
	<script src=/js/app.js></script>
    <!-- built files will be auto injected -->
  </body>
</html>