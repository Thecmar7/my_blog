<?php
// blog_common.php
	/******************************************************************************
	 *
	 ******************************************************************************/
	function get_all_topics() {
		$all_posts = glob("Blog/20??/*/*.html");
		$topics = array();
		foreach ($all_posts as $post) {
			$data = get_post_data($post);
			foreach ($data['topics'] as $topic) {
				$topics[$topic] = 1;
			}
		}
		//print_r($topics);
		return $topics;
	}

	/******************************************************************************
	 *
	 ******************************************************************************/
	function get_posts_by_topic($topic) {
		$posts_by_topic = array();
		foreach (glob("Blog/20??/*/*.html") as $post) {
		 	$data = get_post_data($post)['topics'];
			foreach ($data as $one_topic) {
				if (trim($one_topic) === $topic) {
					$posts_by_topic[] = $post;	
				}
			}
		}
		return $posts_by_topic;
	}

	/******************************************************************************
	 *
	 ******************************************************************************/
	function sort_posts_by_date($array_of_posts) {
		$arranged_posts = array();
		foreach ($array_of_posts as $post) {
			$arranged_posts[strtotime("now") - strtotime(get_post_creation_date($post))] = $post;
		}
		ksort($arranged_posts);
		return $arranged_posts;
	}

	/******************************************************************************
	 *
	 ******************************************************************************/
	function get_post_creation_date($path) {
		$data = get_post_data($path);
		return $data['c_time'];
	}

	/******************************************************************************
	 * Returns an array of data from the a given file pointer
	 * 	 title : 	the post title
	 *	 c_time: 	created time of the file
	 *   topics: 	an array of the topics that are in the blog post
	 *	 post_meat: an array of the lines in the post
	 * POST: Moves the file pointer down to the post, past the meta data.
	 * metadata array,
	 * line 1 			: the title.
	 * line 2 			: the Creation date cause UNIX don't save the file creation date.
	 * line 3 and up  	:is the topics of the blog post.
     * line after '// post' : The blog post

	 * The first parts are put in as just elements of the array but the topics are 
	 * put in as another array so the data array is a multi dementional array.
	 ******************************************************************************/
	function get_post_data($location) {
		if (file_exists($location)) {
			$post = fopen($location, "r");
			$data = array('title' => fgets($post), 'c_time' => fgets($post), 'topics' => array(trim(fgets($post))), 'post_meat' => array(""));
			$loopin = True;
			while ($loopin && ($topic = fgets($post)) !== false) {
				if (strcmp(trim($topic), "") !== 0) {
					if ( strcmp(trim($topic), "// post") !== 0) {	
						$data['topics'][] = trim($topic);
					} else {
						$loopin = false;
					}
				}
			}
			while (($line = fgets($post)) !== false) {
				$data['post_meat'][] = $line;
			}
			fclose($post);
			return $data;
		} else {
			return false;
		}
	}

	/******************************************************************************
	 * make_blog_post($path);
	 *	$path:	The path to the post that you want to make.
	 ******************************************************************************/
	function make_blog_post($loca) {
		if ($data = get_post_data($loca)) {
			?>
			<div class="article">
			<?php
			
			
			# The title
			?>
				<h1 class="post_title"> <?=$data['title']?> </h1>
				<hr> 
			<?php
			# meat of the post this will create the basic post 
			?>
				<div class=\"post_meat\">
			<?php
			for ($i = 0; $i < count($data['post_meat']); $i++) {
				$line = $data['post_meat'][$i];
				if (strcmp(trim($line), "") !== 0) {
					if (strcmp(trim($line), "// code") === 0) {
						$codin = True;							// start of code
						$i++;
						$type_of_code = $data['post_meat'][$i];
						if ($type_of_code == "") {
							$type_of_code = "html";
						}
						?>
							<pre><code class="<?=$type_of_code?>"> 
						<?php
						while ($codin) {
							$i++;
							if ($i < count($data['post_meat'])) {
								$code = $data['post_meat'][$i];
								if (strcmp(trim($code), "// code end") === 0) {
									$codin = False;
								} else {
									echo htmlspecialchars($code);
								}
							}
						}
						?>
							</code></pre>									
						<?php 									// end of code
					} else {
						?>
						 	<p><?=$line?></p>
						<?php
					}
				}
			}
			?>
				</div> <!-- end of post meat --> 
				<div class="topic_all">
					<h2 class="topic_heading">Topics: </h2>
					<ul class="topics">
			<?php
			for ($i = 0; $i < count($data['topics']); ++$i) {
				?>
	        		<span class="pipe">|</span>
	        		<li class="topic"><a href="http://web.engr.oregonstate.edu/~smithcr/new_web/blog_reader.php?topic=<?=$data['topics'][$i]?>"><?=$data['topics'][$i]?></a></li>
	        	<?php
	    	}
	    	?>	
    			</ul>
    		</div>
			</br>

			<div class="shame">
				Created: <?=$data['c_time']?> </br>
				Last modified: <?=date("F d, Y H:i",filemtime($loca))?>
			</div>
			<?php
				fclose($loca);
			?>
			</div>
		<?php
		}
	}

?>