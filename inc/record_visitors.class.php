<?php
//session_start();
if(!defined('INDEX') && !defined('ADMIN')){  
	header("Status: 404 Not Found");
	header("Location: index.php"); 
	die(); 
}
class RecordVisitors
{
	private $data = null;
	private $path = '';
	private $file = 'data.txt';
	private $current = '';
	private $record_files = [];

	//-------------------------------------------------//
	function __construct(){
			
			$this->data = new StdClass;
			
			$this->data->id = session_id();
			//$this->path = $this->data->id;
			
			$this->data->ip = '0.0.0.0';
			$this->data->port = '';
			//$ip = $_SERVER['REMOTE_ADDR']; 
			if (getenv("HTTP_CLIENT_IP")){
				$this->data->ip = getenv("HTTP_CLIENT_IP");
			} 
			else if(getenv("HTTP_X_FORWARDED_FOR")){
				$this->data->ip = getenv("HTTP_X_FORWARDED_FOR");
			} 
			else if(getenv("REMOTE_ADDR")){
				$this->data->ip = getenv("REMOTE_ADDR");
			}
			
			if(getenv('REMOTE_PORT')){
				$this->data->port = getenv('REMOTE_PORT');
			}
			
			$this->data->url = @$_SERVER['REQUEST_URI'];
			$this->data->request_time = date('Y-m-d H.i.s', @$_SERVER['REQUEST_TIME']);
			$this->data->referrer = @$_SERVER["HTTP_REFERER"];
			
			date_default_timezone_set('Asia/Aden');
			$this->data->time = date("Y-m-d H.i.s", time());			
			$this->data->browser = @$_SERVER['HTTP_USER_AGENT']; 
			
			
			$this->data->destination = 'index';
			if( strpos($this->data->url, 'admin')!==false){
				$this->data->destination = 'admin';
			}
			//$this->file = $this->data->id.'@'.$this->data->time.'.txt';
			$this->file = $this->data->id.'.txt';
	}
	//-------------------------------------------------//
	
	function record(){
		if( ! isset($_SESSION['loged_in'])){
			return file_put_contents($this->path.$this->file, json_encode($this->data)."\n", FILE_APPEND);
		}
	}
	//-------------------------------------------------//
	
	function get_current(){
		return $this->data;
	}
	//-------------------------------------------------//

	function set_path($path){
		$this->path = rtrim($path, '/').'/';
	}
	//-------------------------------------------------//
	
	function get_record_files(){
		$items = scandir($this->path);
		$bad = array('', '.', '..', 'index.html');
		$this->record_files = array_diff($items, $bad);
		return $this->record_files;
	}
	//-------------------------------------------------//
	
	function get_count(){
		$records = $this->record_files ? $this->record_files : $this->get_record_files();
		return count($records);	
	}
	//-------------------------------------------------//
	
	function show_record_files(){
		$output = '';
		$records = $this->record_files ? $this->record_files : $this->get_record_files();
		if($records){
			$output .= "<table>\n";
			$output .= "<tr><th>#</th><th>Session</th><th>Size</th><th>View</th><th>Delete</th></tr>\n";
			$i=1;
			foreach($records as $record){
				$size = number_format(intval(filesize($this->path.$record)) / pow(1024, 1), 2);
				$output .= "<tr><td>{$i}</td><td>{$record}</td><td>{$size}KB</td><td><a href=\"?do=view&file={$record}\">View</a></td><td><a href='?do=delete&file={$record}'>Delete</a></td></tr>\n";
				$i++;
			}
			$output .= "</table>\n";
		}
		return $output;
	}
	//-------------------------------------------------//
	
	function get_record_data($record_file){
		$output = '';
		if(is_file($this->path.$record_file)){
			$lines = explode("\n", file_get_contents($this->path.$record_file));
			if(is_array($lines)){
				$output .= "<h3>$record_file</h3>\n";
				$output .= "<a href='index.php'>Back</a> | ";
				$output .= "<a href='?do=delete&file={$record_file}'>Delete</a><br />\n";
				$output .= "<table>\n";
				$output .= "<tr><th>port</th><th>time</th><th>referrer</th><th>url</th><th>request time</th><th>browser</th></tr>\n";
				//echo '<pre>';
				
				foreach($lines as $line){
					$data = (array)json_decode($line);
					extract($data);
					//var_dump($data);
					//print_r($data);
					
					if($destination=='admin'){
						$bgcolor = 'background:#faebd7"';
					}else{
						$bgcolor = '';
					} 
					
					$output .= "<tr style=\"$bgcolor\">
					<td>".$port."</td>
					<td>".$time."</td>
					<td>".$referrer."</td>
					<td>".$url."</td>
					<td>".$request_time."</td>
					<td>".$browser."</td></tr>\n";					
				}
				
				$output .= "</table>\n";
			}
		}
		
		else{
			$output = "No records found!";
		}
		return $output;
	}
	//-------------------------------------------------//
	
	function delete($file){
		if(is_file($this->path.$file)){
			return unlink($this->path.$file) or trigger_error("Couldn't delete file {$file}");
		}
		//trigger_error("file: '{$file}' is not exists");
	}
	//-------------------------------------------------//
}




/*
$visitor = new recordVisitors();
$visitor->set_path('data');
$visitor->record();
echo '<br>';
echo $visitor->get_count();
echo '<pre>';
echo $visitor->get_current();
*/