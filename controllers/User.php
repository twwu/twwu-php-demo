<?php
    class User { 

        private $response;

        private $token = '';

        private $password = ''; 

        private $avatarUrl = '';

        private $gender = '';

        private $nickname = '';

        private $bio = '';

        private $realname = '';

        private $telephone = '';

        private $pointsAvatarUrl = '';

        private $balance = '';

        private $response;
      
        function __construct(){  
              
        }  
        public function index($name='')  
        {  
            echo 'hello,'.$name.',lucky,you are arrive here!';  
        }  
    }  
?>