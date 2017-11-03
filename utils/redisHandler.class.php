<?php

	include_once(dirname(__FILE__)."/../config.php");

	class redisHandler {
		private $redis;

        #connect
		function RedisHandler(){
			$this->redis = new Redis();
    		$this->redis->connect(REDIS_HOST, REDIS_PORT);
		}

        #user
        function getUser($account){
            return $this->redis->hGet(REDIS_USER_KEY, $account); 
        }

        function setUser($account,$value){
            return $this->redis->hSet(REDIS_USER_KEY, $account,$value);

        }

        #no use
        function getUserRecord($account){
            return $this->redis->hGet(REDIS_USER_RECORD_KEY, $account); 
        }

        function setUserRecord($account,$value){
            return $this->redis->hSet(REDIS_USER_RECORD_KEY, $account,$value);

        }

        #user friend
        function delUserFriend($key,$field){
            return $this->redis->hdel($key,$field);
        }

        function getUserFriend($key,$field){
            return $this->redis->hGet($key, $field); 
        }

        function setUserFriend($key,$field,$value){
            return $this->redis->hSet($key, $field,$value);

        }

        function getUserFriends($key){
            return $this->redis->hvals($key);
        }

        #user blacklist
        function delUserBlack($key,$field){
            return $this->redis->hdel($key,$field);
        }

        function getUserBlack($key,$field){
            return $this->redis->hGet($key, $field); 
        }

        function setUserBlack($key,$field,$value){
            return $this->redis->hSet($key, $field,$value);

        }

        function getUserBlacklist($key){
            return $this->redis->hvals($key);
        }


        #user properties || package
        function delUserProperty($key,$field){
            return $this->redis->hdel($key,$field);
        }

        function getUserProperty($key,$field){
            return $this->redis->hGet($key, $field); 
        }

        function setUserProperty($key,$field,$value){
            return $this->redis->hSet($key, $field,$value);

        }

        function getUserProperties($key){
            return $this->redis->hvals($key);
        }

        #user inuse properties 
        function delUserInuseProperty($key,$field){
            return $this->redis->hdel($key,$field);
        }

        function getUserInuseProperty($key,$field){
            return $this->redis->hGet($key, $field); 
        }

        function setUserInuseProperty($key,$field,$value){
            return $this->redis->hSet($key, $field,$value);

        }

        function getUserInuseProperties($key){
            return $this->redis->hvals($key);
        }




        #login token
        function getUserTokens($token){
            return $this->redis->hGet(REDIS_USER_TOKEN_KEY, $token); 
        }

        function setUserTokens($token,$value){
            return $this->redis->hSet(REDIS_USER_TOKEN_KEY, $token,$value);
        }

        function delUserTokens($token){
            return $this->redis->hDel(REDIS_USER_TOKEN_KEY, $token);
        }

        #register token
        function getRegisterTokens($email){
            return $this->redis->hGet(REDIS_REGISTER_TOKEN_KEY, $email); 
        }

        function setRegisterTokens($email,$value){
            return $this->redis->hSet(REDIS_REGISTER_TOKEN_KEY, $email,$value);
        }

        function delRegisterTokens($email){
            return $this->redis->hDel(REDIS_REGISTER_TOKEN_KEY, $email);
        }

        #reset token 
        function getResetTokens($email){
            return $this->redis->hGet(REDIS_RESET_TOKEN_KEY, $email); 
        }

        function setResetTokens($email,$value){
            return $this->redis->hSet(REDIS_RESET_TOKEN_KEY, $email,$value);
        }

        function delResetTokens($email){
            return $this->redis->hDel(REDIS_RESET_TOKEN_KEY, $email);
        }

        #key
        function existKey($key){
            return $this->redis->exists($key);
        }

        function existField($key,$field){
            return $this->redis->hexists($key,$field);
        }

        #room
        function getRoom($key){
            return $this->redis->lGet($key,0);
        }

        function delRoom($key){
            return $this->redis->lPop($key);
        }

        function setRoom($key,$value){
            return $this->redis->rPush($key,$value);
        }

        function lsetRoom($key,$value){
            return $this->redis->lPush($key,$value);
        }

        #gamesession
        function setGameSessions($serverKey,$value){
            return $this->redis->hSet(REDIS_GAME_SESSION_KEY, $serverKey,$value);
        }

        #sieze card configure
        function getSiezeCardConfig(){
            return $this->redis->get(REDIS_SIEZE_CARD_CONFIG_KEY);
        }

        function setSiezeCardConfig($value){
            return $this->redis->set(REDIS_SIEZE_CARD_CONFIG_KEY,$value);
        }

        #game settings
        function getGameSettings(){
            return $this->redis->hget(REDIS_GAME_SETTINGS_KEY,REDIS_GAME_SETTINGS_KEY);
        }

        function setGameSettings($value){
            return $this->redis->hset(REDIS_GAME_SETTINGS_KEY,REDIS_GAME_SETTINGS_KEY,$value);
        }

        function getGameSettingField($key){
            return $this->redis->hget(REDIS_GAME_SETTINGS_KEY,$key);
        }

        function setGameSettingField($key,$value){
            return $this->redis->hset(REDIS_GAME_SETTINGS_KEY,$key,$value);
        }

        #properties
        function setProperty($id,$value){
            return $this->redis->hset(REDIS_PROPERTIES_KEY,$id,$value);
        }

        
        function getProperty($id){
            return $this->redis->hget(REDIS_PROPERTIES_KEY,$id);
        }

        function getProperties(){
            return $this->redis->hvals(REDIS_PROPERTIES_KEY);
        }

        #roomNum

        function setRoomNum($key, $value = null){
            if($value != null && $value == 1){
                return $this->redis->set($key,$value);
            }else{
                $lock_key = 'LOCK_PREFIX_' . $key; 
                $bl = true; 

                while($bl){
                     $is_lock = $this->redis->setnx($lock_key, 1); // 加锁  
                    if($is_lock == true){ // 获取锁权限 

                        $roomNum = $this->redis->get($key);
                        if($roomNum == null ||strlen($roomNum)<0){
                            $this->redis->del($lock_key); 
                            $bl = false;
                            return true;
                        }
                        if($value == -1){
                            $this->redis->set($key,$roomNum-1); // 写入内容 
                            // 释放锁  
                            $this->redis->del($lock_key); 
                            $bl = false;  
                            return true;
                        }else if($roomNum < $value ){

                            $this->redis->set($key,$roomNum+1); // 写入内容 
                            // 释放锁  
                            $this->redis->del($lock_key); 
                            $bl = false;  

                            return true; 
                        }else{
                            $this->redis->del($key);
                            $this->redis->del($lock_key); 
                            $bl = false;
                            return false;
                        }
                             
                    }else{  
                    // 防止死锁  
                        if($this->redis->ttl($lock_key) == -1){  
                            $this->redis->expire($lock_key, 1);  
                        }  
                        $bl = true; // 获取不到锁权限，直接返回  
                    }
                }
               

            }

            
        }

       


	}

?>