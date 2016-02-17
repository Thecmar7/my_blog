<?php
	include('../php/blog_common.php');
	include('../php/common.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog</title>
	<link type="text/css" rel="stylesheet" href="../style_sheets/common.css" />
	<link type="text/css" rel="stylesheet" href="style_sheets/blog_style.css"/>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/highlight.js/8.9.1/styles/docco.min.css"/>
	
	<script src="//cdn.jsdelivr.net/highlight.js/8.9.1/highlight.min.js"></script>
	<script src="../Javascript/home.js"></script>
	<script>
		hljs.initHighlightingOnLoad();
		hljs.configure({tabReplace: '  '});
	</script>

</head>

<body>
	<!-- heading -->
	<?php
	$links = array(
			"Home" => "http://web.engr.oregonstate.edu/~smithcr/php/home.php",
			"Blog" => "http://web.engr.oregonstate.edu/~smithcr/new_web/blog_reader.php",
			"Projects" => "http://web.engr.oregonstate.edu/~smithcr/php/projects.php",
			"New Post" => "http://web.engr.oregonstate.edu/~smithcr/new_web/Blog_writer.php"
			);

		$desc = "This is my blog. I use it to practice writing and have a place for my thoughts. Forgive any typos or bad grammar I am not an english major.";

		top_part($links, $desc);
	?>
	<div id="dah_page">


	<?php
		
	
		//access the file.	
		if ($_GET["year"] != null) {		
			$Year = $_GET["year"];			// give a year a month and a title.
			$Month = $_GET["month"];		// the path that we are accessing
			$title = $_GET["title"];		// the title.
			$path = "Blog/" . $Year . "/" . $Month . "/" . $title . ".html";
			make_blog_post($path);
		} else if ($_GET["topic"] != null) {
			$topicked_posts = get_posts_by_topic($_GET["topic"]);
			$sorted_topic_posts = sort_posts_by_date($topicked_posts);
			foreach ($sorted_topic_posts as $post) {
				make_blog_post($post);
			}
		} else {
			$all_posts = glob("Blog/20??/*/*.html");
			$all_posts_sorted = sort_posts_by_date($all_posts);
			$count = 0;
			foreach ($all_posts_sorted as $post) {
				make_blog_post($post);
				$count++;
				if ($count >= 10) {
					break;
				}
			}
		}

		?>
	</div>

		<!-- sidebar -->
		<div id="side_bar">
			<img src="http://web.engr.oregonstate.edu/~smithcr/new_web/pictures/casual.jpg">

			<p>
				Hello world! My name is Cramer Smith, and I am currently studying Computer Science at Oregon State University with a focus in web and mobile developement.
			</p>

			<?php
			
				$posting = array();
				foreach (glob("Blog/20??/*/*.html") as $post) {
					$posting[strtotime("now") - strtotime(get_post_creation_date($post))] = $post;
				}
				ksort($posting);
				$current_year = 0;
				$current_month = "noll";
				foreach ($posting as $post) {
					$titles = explode("/", $post);
					if ($titles[1] != $current_year) {
						$current_year = $titles[1];
						?>
						<?=$current_year?> <br>
						<?php
					}
					if ($titles[2] != $current_month) {
						$current_month = $titles[2];
						?>
							<span class="tabin" ></span> <?=substr($month, 10)?>
							<?=$current_month?>
						<?php
					}
					$title = substr($titles[3], 0, -5);
					?>
					<div>
						<span class="tabin"></span><span class="tabin"></span>
						<a href="http://web.engr.oregonstate.edu/~smithcr/new_web/blog_reader.php?year=<?=$titles[1]?>&month=<?=$titles[2]?>&title=<?=$title?>"><?=$title?></a>
					</div>
					<?php
				}


			?>
		</div> <!-- end of side bar -->
	</div>
	<?php
		
	?>
</body>
</html>

<?php

	/******************************************************************************
	 *
	 ******************************************************************************/
	function get_posts_by_month($month) {

	}

	/******************************************************************************
	 *
	 ******************************************************************************/
	function get_posts_by_year($year) {
		
	}

	/******************************************************************************
	 *
	 ******************************************************************************/
	function get_posts_by_title($title) {
		
	}


?>
