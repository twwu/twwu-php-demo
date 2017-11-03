<?php
    
    include_once(dirname(__FILE__)."/DBHandler.class.php");
    include_once(dirname(__FILE__)."/redisHandler.class.php");

    class Utils{


        public static function resp_wrong($errorCode,$detail){
            return "{\"errorCode\":\"$errorCode\",\"detail\":\"$detail\"}";
        }

        public static function uuid($prefix = '') {  
            $chars = md5(uniqid(mt_rand(), true));  
            $uuid  = substr($chars,0,8) . '-';  
            $uuid .= substr($chars,8,4) . '-';  
            $uuid .= substr($chars,12,4) . '-';  
            $uuid .= substr($chars,16,4) . '-';  
            $uuid .= substr($chars,20,12);  
            return $prefix . $uuid;  
        }  

        public static function getUserFriends($re,$dbHandler,$account,$userID,$page = 1,$perPage = 20){

            $response = '';

            if($re->existKey($account."_friends")){
                $data = $re->getUserFriends($account."_friends");
                $friends = [];
                $count = 0;
                if(count($data) > 0){
                    if(($page - 1) * $perPage > count($data))
                        return json_encode($friends);

                    for ($i = ($page - 1) * $perPage;$i <= count($data);$i++) {
                        if($count >= $perPage)
                            break;
                        $friend = json_decode($data[$i],true);
                        $friends[$count] = $friend;
                        $count++;
                    }
                }
                $response = json_encode($friends);

            }else{

                $data = $dbHandler->getUserFriends($userID);
                $friends =[];

                #var_dump($data);
                if ($data !== null){
                    if(count($data > 0)){
                        $count = 0;
                        if(($page - 1) * $perPage >= count($data))
                            return json_encode($friends);

                        foreach ($data as $key => $value) {
                            $re->setUserFriend($account."_friends",$key,json_encode($value));
                            if($count >= ($page - 1) * $perPage && $count < $page * $perPage)
                                $friends[$count - ($page - 1) * $perPage] = $value;
                            $count ++;
                        }
                    }
                    $response = json_encode($friends);
                    
                }else{

                    $detail = 'get friends wrong';
                    $errorCode = '-5001';
                    $response = self::resp_wrong($errorCode,$detail);

                }
            }
            return $response;

        }

        public static function getUserBlacklist($re,$dbHandler,$account,$userID,$page = 1,$perPage = 20){

            $response = '';

            if($re->existKey($account."_blacklist")){
                $data = $re->getUserBlacklist($account."_blacklist");
                $blacklist = [];
                $count = 0;
                if(count($data) > 0){
                    if(($page - 1) * $perPage > count($data))
                        return json_encode($blacklist);

                    for ($i = ($page - 1) * $perPage;$i <= count($data);$i++) {
                        if($count >= $perPage)
                            break;

                        $black = json_decode($data[$i],true);
                        $blacklist[$count] = $black;
                        $count++;
                    }
                }
                $response = json_encode($blacklist);

            }else{

                $data = $dbHandler->getUserBlacklist($userID);
                $blacklist =[];


                if ($data !== null){
                    if(count($data > 0)){
                        $count = 0;

                        if(($page - 1) * $perPage > count($data))
                            return json_encode($blacklist);

                        foreach ($data as $key => $value) {
                            $re->setUserBlack($account."_blacklist",$key,json_encode($value));

                            if($count >= ($page - 1) * $perPage && $count < $page * $perPage)
                                $blacklist[$count - ($page - 1) * $perPage] = $value;
                            
                            $count ++;
                        }
                    }
                    $response = json_encode($blacklist);
                    
                }else{

                    $detail = 'get blacklist wrong';
                    $errorCode = '-5001';
                    $response = self::resp_wrong($errorCode,$detail);

                }
            }
            return $response;

        }

        public static function getUserProperties($re,$dbHandler,$account,$userID){
            $response = '';

            if($re->existKey($account."_properties")){
                $data = $re->getUserProperties($account."_properties");
                $properties = [];
                $count = 0;
                if(count($data) > 0){
                    foreach ($data as $key => $value) {
                        $property = json_decode($value,true);
                        $properties[$count] = $property;
                        $count++;
                    }
                }
                $response = json_encode($properties);

            }else{

                $data = $dbHandler->getUserProperties($userID);
                $properties =[];


                if ($data !== null){
                    if(count($data > 0)){
                        $count = 0;
                        foreach ($data as $key => $value) {
                            $re->setUserProperty($account."_properties",$key,json_encode($value));
                            $properties[$count] = $value;
                            $count ++;
                        }
                    }
                    $response = json_encode($properties);
                    
                }else{

                    $detail = 'get properties wrong';
                    $errorCode = '-5001';
                    $response = self::resp_wrong($errorCode,$detail);

                }
            }
            return $response;

        }


        public static function getUserInuseProperties($re,$dbHandler,$account,$userID){

            $response = '';

            if($re->existKey($account."_inuse_properties")){
                $data = $re->getUserInuseProperties($account."_inuse_properties");
                $properties = [];
                $count = 0;
                if(count($data) > 0){
                    foreach ($data as $key => $value) {
                        $property = json_decode($value,true);
                        $properties[$count] = $property;
                        $count++;
                    }
                }
                $response = json_encode($properties);

            }else{

                $data = $dbHandler->getUserInUseProperties($userID);
                $properties =[];


                if ($data !== null){
                    if(count($data > 0)){
                        $count = 0;
                        foreach ($data as $key => $value) {
                            $re->setUserInuseProperty($account."_inuse_properties",$key,json_encode($value));
                            $properties[$count] = $value;
                            $count ++;
                        }
                    }
                    $response = json_encode($properties);
                    
                }else{

                    $detail = 'get properties wrong';
                    $errorCode = '-5001';
                    $response = self::resp_wrong($errorCode,$detail);

                }
            }
            return $response;

        }

    }
?>