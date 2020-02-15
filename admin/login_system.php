<?php
//session_start();
if(!defined('ADMIN')){  
	header("Status: 404 Not Found");
	header("Location: index.php"); 
	die(); 
}

class LoginSystem 
{
	private $pass_file = 'info/pass.dat';
	private $post = null;
	//-------------------------------------------------//
	function __construct(){
		$this->post = new StdClass;
	}
	//-------------------------------------------------//
	function form(){
		?>
		<form method="post" action="?do=login">
		<div class="container">
			<h4>Login</h4>
			<label><span>Username:</span><input type="text" name="data[username]" id="username"></label>
			<label><span>Password:</span><input type="password" name="data[password]" id="password"></label>
			<label><span></span><input type="submit" value="Login"></label>
		</div>
		</form>
		<?php
		if( ! is_file($this->pass_file) ){
				require_once 'info/config.php';
				$a['username'] = $this->encrypt(USER);
				$a['password'] = $this->encrypt(PASS);
				file_put_contents($this->pass_file, json_encode($a));
		}		
	}

	//-------------------------------------------------//
	function login(){
		if(is_file($this->pass_file)){

			if(isset($_POST['data'])){
				$this->post->username = RemoveXSS($_POST['data']['username']);
				$this->post->password = RemoveXSS($_POST['data']['password']);
				
				// Get stored data from file
				$file = file_get_contents($this->pass_file) or die("No data found!");
				$data = json_decode($file);
				// Check if data is correct
				if(is_object($data)){

					if( $this->encrypt($this->post->username) == $data->username 
					 && $this->encrypt($this->post->password) == $data->password )
					{
						$_SESSION['loged_in'] = true;
						$_SESSION['user'] 		= $this->post->username;
						$_SESSION['sess_id'] 	= session_id();
						//header("Location: index.php"); 
						echo '<meta http-equiv="refresh" content="0; url=index.php">';
						return true;
					}
					else{
						echo('Username or password was not correct.');
						echo '<meta http-equiv="refresh" content="3; url=index.php">';

						return false;
					}
				}
			}else{
				trigger_error('No post data');
			}
		}
		else{
			trigger_error('Some thing not correct in database!');
		}
		
	}
	//-------------------------------------------------//
	function is_login(){
		return isset($_SESSION['loged_in']) && ($_SESSION['loged_in'] == true);
	}
	//-------------------------------------------------//
	function controls(){
		echo '<div class="welcome">Welcome:'. $_SESSION['user'].', <a href="?do=logout">Logout</a> | <a href="../">Home</a></div>';
	}
	//-------------------------------------------------//
	function logout(){
		$_SESSION['loged_in'] = null;
		$_SESSION['user']     = null;
		session_destroy();
		//header("Location: index.php"); 
		echo '<meta http-equiv="refresh" content="0; url=index.php">';

		die(); 
		
	}
	//-------------------------------------------------//
	private function encrypt($data){
		return md5($data);
	}
	//-------------------------------------------------//
}