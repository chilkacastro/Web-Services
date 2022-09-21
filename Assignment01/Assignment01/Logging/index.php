<?php
require 'vendor/autoload.php';

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

// CONVERSION
$video_name = "convertedsample";
$orig_video = "sample.mp4";
$converted_video = "convertedsample.avi";
$ffmpeg = FFMpeg\FFMpeg::create();
// open the video to be converted
$video = $ffmpeg->open($orig_video);
$format = new FFMpeg\Format\Video\X264();
$video->save($format, $converted_video);

$date_time = filemtime($converted_video);

// LOGGING
// Create the logger
$logger = new Logger('my_logger');
// Now add some handlers
$logger->pushHandler(new StreamHandler(__DIR__.'/conversionlog.log', Level::Info));
$logger->pushHandler(new FirePHPHandler());

// You can now use your logger
$logger->info('mp4 video converted successfully to avi');

// DATABASE 
$link = mysqli_connect("localhost", "root", "", "videodb");

// Connection
if($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$path = dirname(__FILE__). "/". $converted_video;
$path = str_replace("\\", "/", $path);

// Attempt insert query execution
$sql = "INSERT INTO convertedvideo(video_name, file_path, date_time, original_format, target_format) VALUES ('$video_name', '$path', FROM_UNIXTIME($date_time), 'mp4', 'avi')";

if(mysqli_query($link, $sql)){
    $logger->pushHandler(new StreamHandler(__DIR__.'/successDBRecord.log', Level::Info));
    $logger->pushHandler(new FirePHPHandler());
    $logger->info('uploaded to database successfully');
    echo "Records added successfully.";
}
 else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    $logger->pushHandler(new StreamHandler(__DIR__.'/errorDBRecord.log', Level::Error));
    $logger->pushHandler(new FirePHPHandler());
    $logger->error('Error to upload to database');
}
// Close connection
mysqli_close($link);
?>
