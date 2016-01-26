<?php
	include '../php/blog_common.php';
	include_once("analyticstracking.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Blog Writer</title>
	<link type="text/css" rel="stylesheet" href="style_sheets/blog_writer.css">
</head>
<body>

<form method="post" action="Blog_reader_ajax.php?action=write">
	
	<label>Password:</label><input type="password" name="p_word">if you are not Cramer Smith <a href="http://web.engr.oregonstate.edu/~smithcr/new_web/blog_reader.php">please leave</a>.<br>

	<label>Title:</label><input type="text" name="title"><br>

	<label>Topics:</label>(comma seperated list)<br>
	<textarea name="topics" cols="50" rows="4">
	</textarea><br>
	<label>Some possible topics:</label><br>
	<?php
		$topics = get_all_topics();
		ksort($topics);
		foreach ( $topics as $topic => $number ) {   
		    echo $topic . ", ";
		}
	?>

	<h1>Post</h1><br>
	<div class="formatting">
		<h3>
		Formatting information
		</h3>
		<h4>For Tabs Use:</h4> 
		<label>Safari:</label>"ctrl + option + tab"

		<h4> To Add Code:</h4>
		<p>
			add '<strong>// code </strong>' at the beginning of the code <br>
			and '<strong>// code end</strong>' at the end of the code
		</p>

		
	</div>
	<textarea id="posting" name="postings" cols="90" rows="50">
		
	</textarea>
	<input type="submit">

</form>

</body>
</html>