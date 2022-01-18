<?php
namespace app\models;

class Video extends \app\core\Model{
	public $video_id;
	public $filename;
	public $client_name;
	public $query_submit;
	public $query_complete;
	public $start_format;
	public $end_format;

	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
		$SQL = 'SELECT * FROM video';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute([]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Video');
		return $STMT->fetchAll();//returns an array of all the records
	}

	public function get($video_id){
		$SQL = 'SELECT * FROM video WHERE video_id = :video_id';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute(['video_id'=>$video_id]);
		$STMT->setFetchMode(\PDO::FETCH_CLASS,'app\\models\\Video');
		return $STMT->fetch();//return the record
	}


	public function insert() {
		$SQL = 'INSERT INTO video (filename, client_name, query_submit, query_complete, start_format, end_format) VALUES (:filename, :client_name, :query_submit, :query_complete, :start_format, :end_format)';
		$STMT = self::$_connection->prepare($SQL);
		$STMT->execute([
			'filename' => $this->filename,
			'client_name' => $this->client_name,
			'query_submit' => $this->query_submit,
			'query_complete' => $this->query_complete,
			'start_format' => $this->start_format,
			'end_format' => $this->end_format
		]);
	}
}