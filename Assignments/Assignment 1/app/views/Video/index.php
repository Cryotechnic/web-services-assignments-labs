<html>
<head>
	<title>Video upload</title>
</head>
<body>
	<?php
		if($data['error'] != null){
			echo "<p>$data</p>";
		}

		foreach($data['videos'] as $video)
			echo "<img src='/uploads/$video->filename'>"
	?>





	<h1>Upload a new video</h1>
	<form method="post" enctype="multipart/form-data">
		<input type="text" name="client_name" placeholder="Client Name">
		Select an image file to upload: <input type="file" name="newVideo">
		<input type="submit" name="action">
	</form>

</body>
</html>