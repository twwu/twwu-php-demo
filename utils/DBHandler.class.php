<?php
	include_once(dirname(__FILE__)."/../config.php");
	
	Class DBHandler {

		private $dbh;
		
		#connect
		function DBHandler(){
			try {
				$user = MYSQL_USERNAME;
				$pass = MYSQL_PASSWORD;
				$host = MYSQL_HOST;
				$dbname = MYSQL_DATABASE;
				$this->dbh = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
				#$this->dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Database Connect Err: ".$e->getMessage()."\r\n", FILE_APPEND | LOCK_EX);
			}
		}

		#disconnect
		function disconnect(){
			$this->dbh = null;
		}
		
		#select
		function haveAccount($account){
			$userID = 0;
			if($account == null || strlen($account)<= 0)
				return $userID;
			$sql = "select id from t_users where account = '".$account."'";
			#var_dump($this->dbh);
			try{
				$result = $this->dbh->query($sql);
				#var_dump($result);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0)
						$userID = $result->fetchColumn();	
				}else{
					file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Select Account Err: ".", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
				
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Select Account Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $userID;
		}
		
		function getPWD($account){
			$pwd = null;
			if($account == null || strlen($account)<= 0)
				return $pwd;
			$sql = "select password from t_users where account = '".$account."'";
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						$pwd = $result->fetchColumn();
					}
				}else{
					file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Get PWD Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}		
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Get PWD Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $pwd;
		}


		function searchUserByNickname($nickname){
			$users = [];

			if($nickname == null || strlen($nickname) < 0)
				return $users;

			$sql = "select t_users.id,realname,telephone,avatar_url,gender,nickname,bio,level,rank_id,rank_time,balance,points_avatar_url,total,fail,success,friend_total,friend_fail,friend_success,normal_total,normal_fail,normal_success,advanced_total,advanced_fail,advanced_success,exp,total_exp,points,normal_points,advanced_points,recent_perfs ,rate,friend_rate,normal_rate,advanced_rate,name from t_users left join t_user_records on t_users.id = t_user_records.user_id left join t_ranks on t_users.rank_id = t_ranks.id where t_users.nickname = '$nickname'";
			#var_dump($sql);
			
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						$count = 0;
						foreach ($result as $row) {
							$user = [];
							$profile = [];
							$record =[];
							
							$profile['id'] = $row['id'];
							$profile['realname'] = $row['realname'];
							$profile['telephone'] = $row['telephone'];
							$profile['avatar_url'] = $row['avatar_url'];
							$profile['gender'] = $row['gender'];
							$profile['nickname'] = $row['nickname'];
							$profile['bio'] = $row['bio'];
							$profile['level'] = $row['level'];
							$profile['rank_time'] = $row['rank_time'];
							$profile['balance'] = (int)$row['balance'];
							$profile['points_avatar_url'] = $row['points_avatar_url'];
							$profile['rank'] = $row['name'];
							if($row['total']!=null && strlen($row['total'])>0){
								$record['total'] = $row['total'];
								$record['fail'] = $row['fail'];
								$record['success'] = $row['success'];
								$record['friend_total'] = $row['friend_total'];
								$record['friend_fail'] = $row['friend_fail'];
								$record['friend_success'] = $row['friend_success'];
								$record['normal_total'] = $row['normal_total'];
								$record['normal_fail'] = $row['normal_fail'];
								$record['normal_success'] = $row['normal_success'];
								$record['advanced_total'] = $row['advanced_total'];
								$record['advanced_fail'] = $row['advanced_fail'];
								$record['advanced_success'] = $row['advanced_success'];
								$record['exp'] = $row['exp'];
								$record['total_exp'] = $row['total_exp'];
								#$record['exp_percent_display'] = $record['total_exp'].'/'.$record['exp'];
								$record['points'] = $row['points'];
								$record['normal_points'] = $row['normal_points'];
								$record['advanced_points'] = $row['advanced_points'];
								$record['recent_perfs'] = $row['recent_perfs'];
								if($record['total_exp'] == 0){
									$record['exp_percent'] = 0.00;
								}else{
									$record['exp_percent'] = (float)(number_format((float)($record['exp']/$record['total_exp']),2));
								}

								$record['rate'] = $row['rate'];
									
								$record['friend_rate'] = $row['friend_rate'];
								
								$record['normal_rate'] = $row['normal_rate'];
								
								$record['advanced_rate'] = $row['advanced_rate'];
							}

							$user['profile'] = $profile;
							$user['record'] = $record;

							$users[$count] = $user;

							$count ++;
							
						}
					}
				}
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Search user Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}


			return $users;
		}
		

	
		function getUserProfile($userID){
			$profile = [];
			if($userID == null || $userID == 0)
				return $profile;
			$sql = "select id,realname,telephone,avatar_url,gender,nickname,bio,level,rank_id,rank_time,balance,points_avatar_url from t_users where id = ".$userID;
			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						if ($result->rowCount() == 1){
							foreach ($result as $row ) {
								$profile['id'] = $row['id'];
								$profile['realname'] = $row['realname'];
								$profile['telephone'] = $row['telephone'];
								$profile['avatar_url'] = $row['avatar_url'];
								$profile['gender'] = $row['gender'];
								$profile['nickname'] = $row['nickname'];
								$profile['bio'] = $row['bio'];
								$profile['level'] = $row['level'];
								$profile['rank_time'] = $row['rank_time'];
								$profile['balance'] = (int)$row['balance'];
								$profile['points_avatar_url'] = $row['points_avatar_url'];
								$sql1 = 'select name from t_ranks where id = '.$row['rank_id'];
								$result1 = $this->dbh->query($sql1);
								if ($result1!=null &&$result1!=false){
									if ($result1->rowCount()>0){
										$profile['rank']= $result1->fetchColumn();
									}
								}else{
									file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Get Rank Err: ".$result1.", sql: ".$sql1."\r\n", FILE_APPEND | LOCK_EX);
								}
		
							}
						}else{
							file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Profile Multi Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
						}
					}

				}else{
					file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Profile Err: ".", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}				
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Profile Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $profile;
		}
		
		function getUserRecord($userID){
			$record = [];
			if($userID == null || $userID == 0)
				return $record;

			$sql = "select total,fail,success,friend_total,friend_fail,friend_success,normal_total,normal_fail,normal_success,advanced_total,advanced_fail,advanced_success,exp,total_exp,points,normal_points,advanced_points,recent_perfs ,rate,friend_rate,normal_rate,advanced_rate from t_user_records where user_id = ".$userID;

			#var_dump($sql);

			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount() == 1){
						foreach ($result as $row ) {
							$record['total'] = $row['total'];
							$record['fail'] = $row['fail'];
							$record['success'] = $row['success'];
							$record['friend_total'] = $row['friend_total'];
							$record['friend_fail'] = $row['friend_fail'];
							$record['friend_success'] = $row['friend_success'];
							$record['normal_total'] = $row['normal_total'];
							$record['normal_fail'] = $row['normal_fail'];
							$record['normal_success'] = $row['normal_success'];
							$record['advanced_total'] = $row['advanced_total'];
							$record['advanced_fail'] = $row['advanced_fail'];
							$record['advanced_success'] = $row['advanced_success'];
							$record['exp'] = $row['exp'];
							$record['total_exp'] = $row['total_exp'];
							#$record['exp_percent_display'] = $record['total_exp'].'/'.$record['exp'];
							$record['points'] = $row['points'];
							$record['normal_points'] = $row['normal_points'];
							$record['advanced_points'] = $row['advanced_points'];
							$record['recent_perfs'] = $row['recent_perfs'];
							if($record['total_exp'] == 0){
								$record['exp_percent'] = 0.00;
							}else{
								$record['exp_percent'] = (float)(number_format((float)($record['exp']/$record['total_exp']),2));
							}


							
							$record['rate'] = $row['rate'];
							

							
							$record['friend_rate'] = $row['friend_rate'];
							

							
							$record['normal_rate'] = $row['normal_rate'];
							

							
							$record['advanced_rate'] = $row['advanced_rate'];
							
							
						}
					}else{
						//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Records Multi Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
					}
				}else{
					file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Records Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}				
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Records Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $record;
		}
		
		function getUserFriends($userID){
			$friends = [];
			if($userID == null || $userID == 0)
				return $friends;
			$sql = "select friend_user_id,nickname,level,rank,avatar_url,bio from t_user_friends where user_id = ".$userID;

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						#$count = 0;
						foreach ($result as $row ) {
							$friend = [];
							$friend['friend_id'] = $row['friend_user_id'];
							$friend['nickname'] = $row['nickname'];
							$friend['level'] = $row['level'];
							$friend['rank'] = $row['rank'];
							$friend['avatar_url'] = $row['avatar_url'];
							$friend['bio'] = $row['bio'];
							$friends['friend_'.$friend['friend_id']] = $friend;
							#$count++;
						}
							
					}
				}else{
					#$friends = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Friends Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				$friends = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Friends Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $friends;
		}

		function getUserBlacklist($userID){
			$blacklist = [];
			if($userID == null || $userID == 0)
				return $blacklist;
			$sql = "select black_user_id,nickname,level,rank,avatar_url,bio from t_user_blacklist where user_id = ".$userID;

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						#$count = 0;
						foreach ($result as $row ) {
							$black = [];
							$black['black_id'] = $row['black_user_id'];
							$black['nickname'] = $row['nickname'];
							$black['level'] = $row['level'];
							$black['rank'] = $row['rank'];
							$black['avatar_url'] = $row['avatar_url'];
							$black['bio'] = $row['bio'];
							$blacklist['friend_'.$black['black_id']] = $black;
							#$count++;
						}
							
					}
				}else{
					#$blacklist = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Friends Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				$blacklist = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET blacklist Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $blacklist;
		}
		
		function getUserProperties($userID){
			$properties = [];
			if($userID == null || $userID == 0)
				return $properties;
			$sql = "select property_id,name,description,effect,type,quantity,url from t_user_properties where user_id = ".$userID;

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						#$count = 0;
						foreach ($result as $row ) {
							$property = [];
							$property['property_id'] = (int)$row['property_id'];
							$property['name'] = $row['name'];
							$property['description'] = $row['description'];
							$property['effect'] = $row['effect'];
							$property['type'] = $row['type'];
							$property['quantity'] = $row['quantity'];
							$property['url'] = $row['url'];
							$properties['property_'.$property['property_id']] = $property;
							#$count++;
						}

					}
							
				}else{
					#$properties = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Properties Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				$properties = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Properties Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $properties;
		}
		
		function getUserInUseProperties($userID){
			$properties = [];
			if($userID == null || $userID == 0)
				return $properties;
			$sql = "select property_id,name,description,effect,type,ttl,effective,url from t_user_inuse_properties where user_id = ".$userID;

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						#$count = 0;
						foreach ($result as $row ) {
							$property = [];
							$property['property_id'] = (int)$row['property_id'];
							$property['name'] = $row['name'];
							$property['description'] = $row['description'];
							$property['effect'] = $row['effect'];
							$property['type'] = $row['type'];

							#if($row['ttl'] != null || strlen($row['ttl']) > 0)
							$property['ttl'] = $row['ttl'];

							#if($row['effective'] != null || strlen($row['ttl']) > 0)
							$property['effective'] = $row['effective'];

							$property['url'] = $row['url'];

							$properties['property_'.$property['property_id']] = $property;
							#$count++;
						}

					}
							
				}else{
					#$properties = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Properties Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				$properties = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET INUSE Properties Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $properties;
		}

		function getUserFriend($userID,$friendID){
			$friend = [];
			if($userID == null || $userID == 0)
				return $friend;
			$sql = "select nickname,level,rank,avatar_url,bio from t_user_friends where user_id = $userID and friend_user_id = $friendID";

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount() == 1){
						#$count = 0;
						foreach ($result as $row ) {
							
							$friend['friend_id'] = $friendID;
							$friend['nickname'] = $row['nickname'];
							$friend['level'] = $row['level'];
							$friend['rank'] = $row['rank'];
							$friend['avatar_url'] = $row['avatar_url'];
							$friend['bio'] = $row['bio'];
							#$count++;
						}
							
					}
				}else{
					#$friend = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Friends Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				#$friend = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Friend Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $friend;

		}

		function getUserBlack($userID,$blackID){
			$black = [];
			if($userID == null || $userID == 0)
				return $black;
			$sql = "select nickname,level,rank,avatar_url,bio from t_user_blacklist where user_id = $userID and black_user_id = $blackID";

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount() == 1){
						#$count = 0;
						foreach ($result as $row ) {
			
							$black['black_id'] = $blackID;
							$black['nickname'] = $row['nickname'];
							$black['level'] = $row['level'];
							$black['rank'] = $row['rank'];
							$black['avatar_url'] = $row['avatar_url'];
							$black['bio'] = $row['bio'];
							
							#$count++;
						}
							
					}
				}else{
					#$blacklist = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Friends Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				#$blacklist = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET black Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $black;

		}

		function getUserProperty($userID,$propertyID){
			$property = [];
			if($userID == null || $userID == 0)
				return $property;
			$sql = "select name,description,effect,type,quantity,url from t_user_properties where user_id = $userID and property_id = $propertyID";

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount() == 1){
						#$count = 0;
						foreach ($result as $row ) {
							
							$property['property_id'] = (int)$propertyID;
							$property['name'] = $row['name'];
							$property['description'] = $row['description'];
							$property['effect'] = $row['effect'];
							$property['type'] = $row['type'];
							$property['quantity'] = $row['quantity'];
							$property['url'] = $row['url'];
							#$count++;
						}

					}
							
				}else{
					#$properties = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Properties Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				#$properties = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Properties Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $property;

		}

		function getUserInuseProperty($userID,$propertyID){
			$property = [];
			if($userID == null || $userID == 0)
				return $property;
			$sql = "select name,description,effect,type,ttl,effective,url from t_user_inuse_properties where user_id = $userID and property_id = $propertyID";

			#var_dump($sql);
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount() == 1){
						#$count = 0;
						foreach ($result as $row ) {
							
							$property['property_id'] = (int)$propertyID;
							$property['name'] = $row['name'];
							$property['description'] = $row['description'];
							$property['effect'] = $row['effect'];
							$property['type'] = $row['type'];

							#if($row['ttl'] != null || strlen($row['ttl']) > 0)
							$property['ttl'] = $row['ttl'];

							#if($row['effective'] != null || strlen($row['ttl']) > 0)
							$property['effective'] = $row['effective'];

							$property['url'] = $row['url'];

							
							#$count++;
						}

					}
							
				}else{
					#$properties = null;
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Properties Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				#$properties = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET INUSE Properties Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $property;
		}

		function getSeizeCardConfig(){
			$SeizeCardConfig = [];
			
			$sql = "select type,price,name from t_seize_role_config inner join t_roles on t_seize_role_config.role_id=t_roles.id";
			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						$count = 0;
						foreach ($result as $row ) {
							$property = [];
							$property['type'] = (int)($row['type']);
							$property['name'] = $row['name'];
							$property['price'] = $row['price'];
							$SeizeCardConfig[$count] = $property;
							$count++;
						}

					}
							
				}else{
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET SeizeCardConfig Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET SeizeCardConfig Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $SeizeCardConfig;
		}

		function getGameSettings(){
			$gameSettings = [];

			$sql = "select name,value from t_settings ";

			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						$count = 0;
						foreach ($result as $row ) {
							$property = [];
							$property['name'] = $row['name'];
							$property['value'] = $row['value'];
							$gameSettings[$count] = $property;
							$count++;
						}

					}
							
				}else{
					//file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET SeizeCardConfig Err: ".$result.", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
				}
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET Game Settings Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}

			return $gameSettings;

		}

		function getProperties(){
			$properties = [];

			$sql = "select id,name,price,description,effect,type,url from t_properties where status = 1";

			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount()>0){
						#$count = 0;
						foreach ($result as $row ) {
							$property = [];
							$property['id'] = (int)$row['id'];
							$property['name'] = $row['name'];
							$property['price'] = $row['price'];
							$property['description'] = $row['description'];
							$property['effect'] = $row['effect'];
							$property['type'] = $row['type'];
							$property['url'] = $row['url'];
							$properties['property_'.$row['id']] = $property;
							#$count++;
						}

					}
				}else{
					$properties = null;
				}
			}catch (PDOException $e) {
				$properties = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET properties Settings Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}

			return $properties;
		}

		function getProperty($propertyID){
			$property = [];

			$sql = "select id,name,price,description,effect,type,url from t_properties where status = 1 and id = $propertyID";

			try{
				$result = $this->dbh->query($sql);
				if ($result!=null &&$result!=false){
					if ($result->rowCount() == 1){
						#$count = 0;
						foreach ($result as $row ) {
							
							$property['id'] = (int)$row['id'];
							$property['name'] = $row['name'];
							$property['price'] = $row['price'];
							$property['description'] = $row['description'];
							$property['effect'] = $row['effect'];
							$property['type'] = $row['type'];
							$property['url'] = $row['url'];
							$properties['property_'.$row['id']] = $property;
							#$count++;
						}

					}
				}else{
					$property = null;
				}
			}catch (PDOException $e) {
				$property = null;
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " GET property Settings Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}

			return $property;
		}


		#insert
		function insertTokens($userID,$token){
			$bl = false;
			$now = date("Y-m-d H:i:s");
			if($userID == null || $userID == 0 || $token == null || strlen($token) <= 0)
				return $bl;
			#var_dump($token);
			$sql = "update t_game_sessions set token = '$token',date_accessed = '$now' where user_id = $userID";
			  
			#$sql = "insert into t_game_sessions (user_id,token,date_created,date_accessed) values ('{$userID}', '{$token}', '{$now}', '{$now}')";
			#var_dump($this->dbh);
			try{
				$result = $this->dbh->exec($sql);
				
				if($result != null && $result != false){
						$bl = true;
				}else{
					$sql2 = "insert into t_game_sessions (user_id,token,date_created,date_accessed) values ($userID, '$token', '$now', '$now')";
					$result2 = $this->dbh->exec($sql2);
					if($result2 != null && $result2 != false)
						$bl = true;
				}
			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Insert Tokens Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;
		}

		function insertUserFriend($userID,$friendID,$nickname,$level,$rank,$avatar_url,$bio = ''){
			$bl = false;

			$now = date('Y-m-d H:i:s');

			$sql = "insert into t_user_friends (user_id,friend_user_id,nickname,level,rank,avatar_url,bio,date_created) values ($userID,$friendID,'$nickname','$level','$rank','$avatar_url','$bio','$now')";

			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Insert User friend Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;



		}

		function insertUserBlacklist($userID,$blackID,$nickname,$level,$rank,$avatar_url,$bio = ''){

			$bl = false;

			$now = date('Y-m-d H:i:s');

			$sql = "insert into t_user_blacklist (user_id,black_user_id,nickname,level,rank,avatar_url,bio,date_created) values ($userID,$blackID,'$nickname','$level','$rank','$avatar_url','$bio','$now')";

			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Insert User blacklist Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function insertUserProperty($userID,$propertyID,$name,$description,$effect,$type,$quantity,$url){

			$bl = false;

			$now = date('Y-m-d H:i:s');

			$sql = "insert into t_user_properties (user_id,property_id,name,description,effect,type,quantity,url,date_created) values ($userID,$propertyID,'$name','$description','$effect','$type',$quantity,'$url','$now')";

			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Insert User property Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function insertUserInuseProprerty($userID,$propertyID,$name,$description,$effect,$type,$url,$ttl = '',$effective = ''){

			$bl = false;

			$now = date('Y-m-d H:i:s');
			if (($ttl == null ||strlen($ttl)<=0) && ($effective == null ||strlen($effective)<=0)){
				$sql = "insert into t_user_inuse_properties (user_id,property_id,name,description,effect,type,url,date_created) values ($userID,$propertyID,'$name','$description','$effect','$type','$url','$now')";
			}
			if(($ttl != 0 &&strlen($ttl)>0 )&& ($effective == null ||strlen($effective)<0)){
				$sql = "insert into t_user_inuse_properties (user_id,property_id,name,description,effect,type,url,date_created,ttl) values ($userID,$propertyID,'$name','$description','$effect','$type','$url','$now',$ttl)";
			}
			if(($ttl == null ||strlen($ttl)<=0) && ($effective != null &&strlen($effective)>0)){
				$sql = "insert into t_user_inuse_properties (user_id,property_id,name,description,effect,type,url,date_created,effective) values ($userID,$propertyID,'$name','$description','$effect','$type','$url','$now',$effective)";
			}

			if(($ttl != 0 &&strlen($ttl)>0 )&& ($effective != null &&strlen($effective)>0)){
				$sql = "insert into t_user_inuse_properties (user_id,property_id,name,description,effect,type,url,date_created,ttl,effective) values ($userID,$propertyID,'$name','$description','$effect','$type','$url','$now',$ttl,$effective)";
			}

			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Insert User inuse property Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;
		}

		function createUser($account,$password,$avatar_url,$gender,$nickname,$bio = '',$realname = '',$telephone = '',$points_avatar_url = ''){

			$bl = false;
			$now = date("Y-m-d H:i:s");
			$sql = "insert into t_users (account,password,avatar_url,gender,nickname,bio,realname,telephone,points_avatar_url,date_created) values ('$account','$password','$avatar_url','$gender','$nickname','$bio','$realname','$telephone','$points_avatar_url','$now')";
			#var_dump($sql);
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Insert User  Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}



		#update
		function updateUserProfile($account,$request){
			$bl = false;

			$sql = "update t_users set ";
			foreach ($request as $key => $value) {
				$sql = $sql . $key . " = '$value' ,";
			}
			$sql = substr($sql,0,strlen($sql)-1);

			$sql = $sql . " where account = '$account'";

			#var_dump($sql);

			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Update User profile Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function updateUserAvatarUrl($account,$url){
			$bl = false;

			$sql = "update t_users set avatar_url = '$url' where account = '$account'";
			#var_dump($sql);
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Update User avatar_url Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function updateUserPassword($account,$password){
			$bl = false;

			$sql = "update t_users set password = '$password' where account = '$account'";
			#var_dump($sql);
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Update User password Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function updateUserbalance($account,$balance) {
			$bl = false;

			$sql = "update t_users set balance = '$balance' where account = '$account'";
			#var_dump($sql);
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Update User balance Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;
		}

		function updateUserPropertyQuantity($userID,$propertyID,$quantity){

			$bl = false;

			$sql = "update t_user_properties set quantity = $quantity where user_id = $userID and property_id = $propertyID";
			#var_dump($sql);
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " Update User property quantity Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		#del 
		function delUserFriend($userID,$friendID){
			$bl = false;

			$sql="delete from t_user_friends where user_id = $userID and friend_user_id = $friendID";  

			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " delete User friend  Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function delUserBlack($userID,$blackID){

			$bl = false;

			$sql="delete from t_user_blacklist where user_id = $userID and black_user_id = $blackID";  
			  
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " delete User black  Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function delUserProperty($userID,$propertyID){

			$bl = false;

			$sql="delete from t_user_properties where user_id = $userID and property_id = $propertyID";  
			  
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " delete User property  Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}

		function delUserInuseProperty($userID,$propertyID){

			$bl = false;

			$sql="delete from t_user_blacklist where user_id = $userID and property_id = $propertyID";  
			  
			try{
				$result = $this->dbh->exec($sql);
				if($result != null && $result != false){
					$bl = true;
				}

			}catch (PDOException $e) {
				file_put_contents('./logs/DBHandlerErrLogfile'.date('Ymd').'.log', date("Y-m-d H:i:s"). " delete User inuse property  Err: ".$e->getMessage().", sql: ".$sql."\r\n", FILE_APPEND | LOCK_EX);
			}
			return $bl;

		}




	}
?>