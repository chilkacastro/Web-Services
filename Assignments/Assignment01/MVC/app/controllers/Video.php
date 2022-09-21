<?php

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Video extends Controller{
    public function __construct() {
        $this->videoModel = $this->model('videoModel');
        
        // PUT IN CONSTRUCTOR becuase if someone is not logged in then they dont have access to the user -> ONLY HAVE ACCESS WHEN SOMEONE IS LOGGED IN
        if(!isLoggedIn()){
            header('Location: /MVC/Login');
        }
    }

    // default method
    public function index(){
        $this->view('Video/index');
    }

    public function getVideos(){
        if(!isLoggedIn()) {                     // restrict anyone to accessing data without helping it
            header('Location: /MVC/Login');     // you need to login first before you can access the data -> THIS LINE WILL JUST SEND YOU TO THE LOGIN PAGE again
        }
        $videos = $this->videoModel->getVideos();
        $data = [
            "videos" => $videos
        ];
        $this->view('Video/getVideos', $data);
    }

    public function createVideo() {
        if(!isLoggedIn()) {                      // restrict anyone to accessing data without helping it -> this is the reason why we create the helper file so we can restrict the access
            header('Location: /MVC/Login');
        }
        if(!isset($_POST['register'])) {
            $this->view('Video/createVideo');
        }
        else {
            $filename = $this->videoUpload();
            $data=[
                'video_name' => trim($_POST['name']),
                'userID' => $_SESSION['user_id'],
                'video' => $filename,
            ];
            
            if($this->videoModel->createVideo($data)){
                header('Location: /MVC/Video/getVideos');
                // echo '<meta http-equiv="Refresh" content="2; url=/MVC/Video/getVideos">';
            }
        }
    }

    public function editVideoFileName($filename){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_';
        $result = '';
        for ($i = 0; $i < 11; $i++)
            $result .= $characters[mt_rand(0, 63)];     
        $c = '-';
        return $filename . $c . $_SESSION['user_id'] . $c . time() . $c. $result;   //filname-user_id-time-randomgen
    }


    public function videoUpload()
    {
        $maxsize = 5242880; // 5MB
        // LOGGING
        // Create the logger
        $logger = new Logger('video_upload_logger');
        // Now add some handlers
        $logger->pushHandler(new StreamHandler(dirname(dirname(__FILE__)).'/logs/videoUpload.log', Level::Debug));
        $logger->pushHandler(new FirePHPHandler());
       
        if(isset($_FILES['video']['name']) && $_FILES['video']['name'] != ''){
            $name = $this->editVideoFileName($_FILES['video']['name']);
            $target_dir = dirname(APPROOT) . '/public/vid/'; // folder where it will be stored
            
            $target_file = $target_dir . $_FILES["video"]["name"];
            // Select file type
            $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $target_file =  $target_dir . $name;  // change content
    
            // Valid file extensions
            $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

            // Check extension
            if( in_array($extension,$extensions_arr) ){
        
                // Check file size
                if(($_FILES['video']['size'] >= $maxsize) || ($_FILES["video"]["size"] == 0)) {
                    $logger->info("File too large. File must be less than 5MB.");
                }
                else{
                    // Upload
                    if(move_uploaded_file($_FILES['video']['tmp_name'], $target_file)){
                        // You can now use your logger
                        $logger->info("video uploaded successfully");
                    }
                }
            }
            else {
                $logger->debug("invalid file extension");
            }
        }
        else {
            $_SESSION['message'] = "Please select a file.";
            $logger->info("File too large. File must be less than 5MB.");
        }
   
        return $name;
    }
            
    public function editVideo($video_ID){
        $video = $this->videoModel->getVideo($video_ID);

        if(!isset($_POST['update'])){
            $this->view('Video/editVideo', $video);
        }
        else{
            if (is_uploaded_file($_FILES['video']['tmp_name'])) {   // for new video
                $filename = $this->videoUpload();
            }
            else {
                $filename = $video->video;
            }
            $data=[
                'name' => trim($_POST['name']),
                'video' => $filename,
                'ID' => $video_ID
            ];
            if($this->videoModel->updateVideo($data)){
                echo 'Please wait we are upating the video for you!';
                // //header('Location: /MVC/User/getUsers');
                echo '<meta http-equiv="Refresh" content="2; url=/MVC/Video/getVideos">';
            }
            
        }
    }

    public function deleteVideo($video_ID){
        $data=[
            'ID' => $video_ID
        ];
        if($this->videoModel->delete($data)){
            // echo 'Please wait we are deleting the video for you!';
            header('Location: /MVC/Video/getVideos');
            // echo '<meta http-equiv="Refresh" content=".2; url=/MVC/Video/getVideos">';
        }
    }

    }

?>