<?php

    class loginModel{
        public function __construct(){
            $this->db = new Model;
        }
    
        public function getUser($username){
            $this->db->query("SELECT * FROM users WHERE username = :username");
            $this->db->bind(':username',$username);
            return $this->db->getSingle();
        }

        public function createUser($data){
            $this->db->query("INSERT INTO users (username, pass_hash) values (:username, :pass_hash)");
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':pass_hash', $data['pass_hash']);


            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }

        }
    }
?>