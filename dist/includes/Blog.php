<?php 
	require_once("model.php");
	
	/**
	* Blog class
	*/
	class Blog extends Model{
		protected static $table_name = "blogs";
  		protected static $db_fields = array('id', 'title', 'body', 'slug', 'cover_url', 'author', 'published_at');

		public $id;
		public $title;
		public $body;
		public $slug;
		public $cover_url;
		public $author;
		public $published_at;
			
		protected static function table_creating_query(){
			$query = "<br/>`id` int(11) NOT NULL auto_increment,";
			$query .= "<br/>`title` varchar(255),";
			$query .= "<br/>`body` text,";
			$query .= "<br/>`slug` varchar(255),";
			$query .= "<br/>`cover_url` varchar(255),";
			$query .= "<br/>`author` varchar(255),";
			$query .= "<br/>`published_at` varchar(255),";
			$query .= "<br/>PRIMARY KEY (`id`)";
			
			return $query;
		}

		public function get_creator_json(){
			$json = file_get_contents("blogs/$this->id.json");
			// return json_decode($json);
			return $json;
		}
	}
