<?php

    class videoModel{
        public function __construct(){
            $this->db = new Model;
        }
        public function getVideos(){
            $this->db->query("SELECT * FROM videos WHERE userID = :user_id ORDER BY videoID DESC");
            $this->db->bind(':user_id', $_SESSION['user_id']);
            return $this->db->getResultSet();
        }

        public function getVideo($videoID){
            $this->db->query("SELECT * FROM videos WHERE videoID = :videoID");
            $this->db->bind(':videoID', $videoID);
            return $this->db->getSingle();
        }

        public function createVideo($data){
            $this->db->query("INSERT INTO videos (userID, video_name, upload_datetime, video) 
                values (:userID, :video_name, now(), :video)");
            $this->db->bind(':userID', $data['userID']);
            $this->db->bind(':video_name', $data['video_name']);
            $this->db->bind(':video', $data['video']);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function updateVideo($data){
            $this->db->query("UPDATE videos SET video_name=:video_name, video=:video WHERE videoID=:videoID");
            $this->db->bind(':video_name', $data['name']);
            $this->db->bind(':video', $data['video']);
            $this->db->bind(':videoID',$data['ID']);
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }

        }

        public function delete($data){
            $this->db->query("DELETE FROM videos WHERE videoID=:videoID");
            $this->db->bind(':videoID',$data['ID']);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }

        }
    }

?>