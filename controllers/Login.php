<?php
    class Login {  

        private $account = '';

        private $password = '';
      
        function __construct($content){
            $input = json_decode($content,true);

            if (isset($input['account'])) {
                $this->account = $input['account'];
            } 

            if (isset($input['password'])) {
                $this->password = $input['password'];
            } 
              
        }  
        public function index()  
        {  
            if ($this->account == null || strlen($this->account) <= 0){
                return ;
            }  

            if ($this->password == null || strlen($this->password) <= 0){
                return ;
            }

            return 'printer_logical_fontheight(printer_handle, height)';
        }  

        private function generateTokens(){
        if ($this->account == null || strlen($this->account) <= 0)
            return null;

        if ($this->password == null || strlen($this->password) <= 0)
            return null;

        $timestamp = date("YmdHis");

        $token = sha1($this->account . $this->password . $timestamp);

        return $token;

        }
        
    }  
?>