<?php
	require_once 'includes/Blog.php';
	$blog_id = $_GET['blog_id'];
  $blog = Blog::find($blog_id);
  $cover = json_decode($blog->creator_json)->cover;
  $cover_class = 'cover-image-' . $cover->options->width;
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
  </head>
  <body>
    <div id="content">
      <div id="insightBody">
        <div id="insightImage" class="blogpost-section-wrapper <?php echo $cover_class; ?>">
          <img src="<?php echo $blog->cover_url ?>" alt="">
        </div>

        <div class="blogpost-section-wrapper">
            <div id="insightTitle">
                <h1>
                  <?php echo $blog->title; ?>
                </h1>

                <!-- <h5><span class="taggy-item">BUSINESS GROWTH</span><span class="taggy-item">TECHNOLOGY</span></h5> -->
            </div>
            <span id="insightDate">
                <!-- Published {{date | formatDate}} -->
                By <?php echo $blog->author; ?> | <?php echo $blog->published_at; ?>
            </span>
        </div>

        <div class="blog-content">
          <?php echo $blog->body; ?>
        </div>
      </div>
    </div>
  </body>
</html>