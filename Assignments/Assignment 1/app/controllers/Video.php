<?php
namespace app\controllers;

class Video extends \app\core\Controller{
	private $folder='uploads/';
	
	public function index(){
		if(isset($_POST['action'])){
			// Start process timer
			$date_clicked = date('Y-m-d H:i:s');
			// Get file name
			$filename = $_FILES['newVideo']['name'];
			// Get file type
			$filetype = $_FILES['newVideo']['type'];
			// Get file size
			$filesize = $_FILES['newVideo']['size'];
			// convert file to avi using exec ffmpeg
			$filepath = $this->folder.$filename;
			$destination = $this->folder.'converted/'.$filename;
			$dest_out = $this->folder.$filename;
			move_uploaded_file($_FILES['newVideo']['tmp_name'], $filepath);
		
			$folder = $this->folder;

			$newFilename = pathinfo($filename, PATHINFO_FILENAME).'.avi';
			// move new file to convert directory
			
			// convert file to avi using exec ffmpeg, except php doesn't know where to find the ffmpeg executable so we have to use the full path
			exec('"S:\Program Files\FFmpeg\bin\ffmpeg.exe" -y -i '.$folder.DIRECTORY_SEPARATOR.$filename.' -c:v libx264 -c:a aac -pix_fmt yuv420p -movflags faststart -hide_banner '.$folder.DIRECTORY_SEPARATOR.$newFilename.' 2>&1', $out, $res);
			// move new file to convert directory
			copy($folder.$filename, $folder.'converted/'.$newFilename);
			// delete original file
			unlink($folder.$filename);
			unlink($folder.$newFilename);
			if ($out != null) {
				$date_completed = date('Y-m-d H:i:s');
				echo "<br>Conversion complete on".$date_completed;
				$video = new \app\models\Video();
				$video->filename = $newFilename;
				$video->client_name = $_POST['client_name'];
				$video->query_submit = $date_clicked;
				$video->query_complete = $date_completed;
				$video->start_format = $filetype;
				$video->end_format = 'video/avi';
				$video->insert();
			}
			// // download file to user, but it outputs 1kb file, why?
			// header('Content-Description: File Transfer');
			// header('Content-Type: application/octet-stream');
			// header('Content-Disposition: attachment; filename='.basename($filename));
			// header('Expires: 0');
			// header('Cache-Control: must-revalidate');
			// header('Pragma: public');
			// header('Content-Length: ' . filesize($filename));
			// flush();
			// readfile($newFilename);
			// die();
			
			// dbg stuff
			// echo "Out: ".var_dump($out);
			// echo "<br>Time the button was clicked: ".$date_clicked."<br>";
			echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>FILE EXTENSION: ".$filetype;
			echo "Done! Output: ".$newFilename."<br>";
			echo "<a href='/Video/index'>Go back</a>";

		}else{
			//present the form
			$video = new \app\models\Video();
			$videos = $video->getAll();
			$this->view('Video/index',['error'=>null,'videos'=>$videos]);
		}
	}
}