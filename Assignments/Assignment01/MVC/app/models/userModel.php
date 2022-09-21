<?php
class userModel{
    public function __construct(){
        $this->db = new Model;
    }

    public function getUser() {
        $this->db->query("SELECT * FROM users WHERE userID = :userID");
        $this->db->bind(':userID', $_SESSION['user_id']);
        return $this->db->getSingle();
    }   

    public function updateUsername($data) {
        $this->db->query("UPDATE users SET username=:username WHERE userID=:userID");
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':userID', $_SESSION['user_id']);
        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }

    }
}