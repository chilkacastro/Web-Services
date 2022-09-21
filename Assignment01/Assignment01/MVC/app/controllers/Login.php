<?php

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Login extends Controller
{
    public function __construct()
    {
        $this->loginModel = $this->model('loginModel');
        $this->videoModel = $this->model('videoModel');
    }

    // default method of the Login page
    public function index()
    {
        if(!isset($_POST['login'])){
            $this->view('Login/index');
        }
        else{
            $user = $this->loginModel->getUser($_POST['username']);
            
            if($user != null){
                $hashed_pass = $user->pass_hash;
                $password = $_POST['password'];
                if(password_verify($password,$hashed_pass)){
                    //echo '<meta http-equiv="Refresh" content="2; url=/MVC/">';
                    $this->createSession($user);
                    $data = [
                        'msg' => "Welcome, $user->username!",
                    ];
                    $this->view('Home/index',$data);
                
                    // LOGGING
                    // Create the logger
                    $logger = new Logger('my_logger');
                    // Now add some handlers
                    $logger->pushHandler(new StreamHandler(dirname(dirname(__FILE__)).'/logs/conversionlog.log', Level::Debug));
                    $logger->pushHandler(new FirePHPHandler());

                    // You can now use your logger
                    $logger->info($user->username.' logged in successfully');
                }
                else{
                    $data = [
                        'msg' => "Password incorrect! for $user->username",
                    ];
                    $this->view('Login/index',$data);
                }
            }
            else{
                $data = [
                    'msg' => "User: ". $_POST['username'] ." does not exists",
                ];
                $this->view('Login/index',$data);
            }
        }
    }

    public function create()
    {
        if(!isset($_POST['signup'])){
            $this->view('Login/create');
        }
        else{
            $user = $this->loginModel->getUser($_POST['username']);
            if($user == null){
                $data = [
                    'username' => trim($_POST['username']),
                    'pass_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                ];
                if($this->loginModel->createUser($data)){
                        echo 'Please wait creating the account for '.trim($_POST['username']);
                        echo '<meta http-equiv="Refresh" content="2; url=/MVC/Login/">';      
                }
            }
            else{
                $data = [
                    'msg' => "User: ". $_POST['username'] ." already exists",
                ];
                $this->view('Login/create',$data);
            }
            
        }
    }

    public function createSession($user){
        $_SESSION['user_id'] = $user->userID;
        $_SESSION['user_username'] = $user->username;
    }

    public function logout(){
        unset($_SESSION['user_id']);
        session_destroy();
        echo '<meta http-equiv="Refresh" content="1; url=/MVC/Login/">';   

    }
}
