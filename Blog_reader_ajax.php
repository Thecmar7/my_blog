<?php

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if ($_GET["action"] == "write") {
			if ($_POST["p_word"] == "coolpostbro") {
				$title = $_POST["title"];
				$topics = explode(", ", $_POST["topics"]);

				$posting = $_POST["postings"];

				$year = date("Y");
				$month = date("F");
				mkdir("Blog/$year/$month/", 0777, true);

				$date = date("F d, Y H:i");
				$location = "Blog/$year/$month/$title.html";
				$file = fopen($location, "w");

				$the_post = "$title\n$date\n";
				foreach ($topics as $topic) {
					$the_post = $the_post . $topic . "\n";
				}
				$the_post = $the_post . "// post\n$posting";

				fwrite($file, $the_post);
				header('Location: http://web.engr.oregonstate.edu/~smithcr/new_web/blog_reader.php');
			} else { 
				header('Location: http://web.engr.oregonstate.edu/~smithcr/new_web/blog_reader.php');
			}
		}
	} else {
		header('Location: http://web.engr.oregonstate.edu/~smithcr/new_web/blog_reader.php');
	}
?>