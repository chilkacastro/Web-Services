<?php require APPROOT . '/views/includes/header.php'; ?>
  <?php
  $str = '/'.'public'.'/vid'.'/';

  if (!empty($data['videos'])) {
    foreach($data["videos"] as $video) {

        $array = explode('-', trim($video->video));
        $filename = $array[0];
        $location = URLROOT.$str. $video->video;
        $name =  $video->video_name;  
        $date_time = $video->upload_datetime;
        // echo $video->video."<br>";
        // echo $filename.
        // "<br>";
        echo "
        <div style='float: left; margin-right: 5px;'>
            <video controls width='320px' height='320px' src='$location' type='video/mp4'> 
            </video>     
            <br>
        <span>".'Video Title: '.$name."</span>
        <br>
        <span>".'Uploaded on: '.$date_time."</span>
        <br>
        <span>".'Filename: '.$filename."</span>
        <br>
      <a class='btn btn-warning' href='/MVC/Video/editVideo/$video->videoID' role='button'>Edit</a>
      <a class='btn btn-danger' href='/MVC/Video/deleteVideo/$video->videoID' role='button'>Delete</a>
        </div>";
    }
  }
  else {
    echo "<h1 class='text-center' style='padding-top:35px;'>There are no videos<h1>";
  }
  ?>
<?php require APPROOT . '/views/includes/footer.php'; ?>