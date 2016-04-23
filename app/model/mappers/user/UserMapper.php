<?php
	include_once '../core/model/DataMapper.php';
	include_once '../app/model/domain/user/User.php';
	include_once '../app/model/domain/user/Player.php';
	include_once '../app/model/domain/user/Examiner.php';
	include_once '../app/model/domain/user/Moderator.php';
	
	class UserMapper extends DataMapper{

		public function findById($id){
			$statement = $this->getStatement(
				"SELECT * FROM `User` WHERE id=?");

			$statement->setParameters('i' ,$id);

			$resultSet = $statement->execute();

			if($resultSet->next()){

				$accessLevel = $resultSet->get("access");

				$user = 0;
				if( $accessLevel == 1 )
					$user = new Player();
				else if ( $accessLevel == 2)
					$user = new Examiner();
				else if ( $accessLevel == 3)
					$user = new Moderator();

				$user->setAccessLevel($accessLevel);
				$user->setId( $resultSet->get("id") );
				$user->setName( $resultSet->get("name") );
				$user->setSurname( $resultSet->get("surname") );
				$user->setEmail( $resultSet->get("email") );
				$user->setGender( $resultSet->get("gender") );
				$user->setCountry( $resultSet->get("country") );
				$user->setCity( $resultSet->get("city") );
				$user->setVerified( $resultSet->get("verified") );
				$user->setDeleted( $resultSet->get("deleted") );
				$user->setBanned( $resultSet->get("banned") );
				$user->setEmailVerificationToken( $resultSet->get("email_verification_token") );
				$user->setEmailVerificationDate( $resultSet->get("email_verification_date") );
				$user->setPasswordRecoveryToken( $resultSet->get("password_recovery_token") );
				$user->setPasswordRecoveryDate( $resultSet->get("password_recovery_date") );
				$user->setApiToken($resultSet->get("api_token"));
				$user->setNewEmail( $resultSet->get("new_email") );

				if( $resultSet->get("address") !== null )
					$user->setAddress( $resultSet->get("address") );

				if( $resultSet->get("phone") !== null )
					$user->setPhone( $resultSet->get("phone") ); 

				return $user;
			}

			return null;
		}

		public function findByEmail($email){
			$statement = $this->getStatement(
				"SELECT * FROM `User` WHERE `email`=?");

			$statement->setParameters('s' ,$email);

			$resultSet = $statement->execute();

			if($resultSet->next()){

				$accessLevel = $resultSet->get("access");

				$user = 0;
				if( $accessLevel == 1 )
					$user = new Player();
				else if ( $accessLevel == 2)
					$user = new Examiner();
				else if ( $accessLevel == 3)
					$user = new Moderator();

				$user->setAccessLevel($accessLevel);
				$user->setId( $resultSet->get("id") );
				$user->setName( $resultSet->get("name") );
				$user->setSurname( $resultSet->get("surname") );
				$user->setEmail( $resultSet->get("email") );
				$user->setGender( $resultSet->get("gender") );
				$user->setCountry( $resultSet->get("country") );
				$user->setCity( $resultSet->get("city") );
				$user->setVerified( $resultSet->get("verified") );
				$user->setDeleted( $resultSet->get("deleted") );
				$user->setBanned( $resultSet->get("banned") );
				$user->setEmailVerificationToken( $resultSet->get("email_verification_token") );
				$user->setEmailVerificationDate( $resultSet->get("email_verification_date") );
				$user->setPasswordRecoveryToken( $resultSet->get("password_recovery_token") );
				$user->setPasswordRecoveryDate( $resultSet->get("password_recovery_date") );
				$user->setApiToken($resultSet->get("api_token"));
				$user->setNewEmail( $resultSet->get("new_email") );

				if( $resultSet->get("address") !== null )
					$user->setAddress( $resultSet->get("address") );

				if( $resultSet->get("phone") !== null )
					$user->setPhone( $resultSet->get("phone") ); 

				return $user;
			}

			return null;
		}

		public function findAllParticipants($questionnaireId){
			$query = "SELECT `User`.*,`QuestionnaireParticipation`.`participation_type` FROM `User` INNER JOIN `QuestionnaireParticipation` on `QuestionnaireParticipation`.`user_id`=`User`.`id` WHERE `QuestionnaireParticipation`.`questionnaire_id`=? ORDER BY `QuestionnaireParticipation`.`participation_type` DESC";

			$statement = $this->getStatement($query);
			$statement->setParameters('i' ,$questionnaireId);

			$set = $statement->execute();

			$members = array();

			while($set->next()){
				
				if( array_key_exists( $set->get("id") , $members) ){
					if( $set->get("participation_type") == 1)
						$members[$set->get("id")]["player-participation"] = true;
					else if ( $set->get("participation_type") == 2 )
						$members[$set->get("id")]["examiner-participation"] = true;
				}else{
					$user = new User;
					$user->setAccessLevel( $set->get("access"));
					$user->setId( $set->get("id") );
					$user->setName( $set->get("name") );
					$user->setSurname( $set->get("surname") );
					$user->setEmail( $set->get("email") );
					$user->setGender( $set->get("gender") );
					$user->setCountry( $set->get("country") );
					$user->setCity( $set->get("city") );
					$user->setVerified( $set->get("verified") );
					$user->setDeleted( $set->get("deleted") );
					$user->setBanned( $set->get("banned") );
					$user->setEmailVerificationToken( $set->get("email_verification_token") );
					$user->setEmailVerificationDate( $set->get("email_verification_date") );
					$user->setPasswordRecoveryToken( $set->get("password_recovery_token") );
					$user->setPasswordRecoveryDate( $set->get("password_recovery_date") );
					$user->setApiToken($set->get("api_token"));
					$user->setNewEmail( $set->get("new_email") );
					if( $set->get("address") !== null )
						$user->setAddress( $set->get("address") );

					if( $set->get("phone") !== null )
						$user->setPhone( $set->get("phone") ); 

					$members[$user->getId()]["user"] = $user;

					if( $set->get("participation_type") == 1){
						$members[$set->get("id")]["player-participation"] = true;
						$members[$set->get("id")]["examiner-participation"] = false;
					}else if ( $set->get("participation_type") == 2 ){
						$members[$set->get("id")]["player-participation"] = false;
						$members[$set->get("id")]["examiner-participation"] = true;
					}
				}

			} 
			return $members;
		}

		public function findUsersByQuestionnaire($questionnaireId,$participationType){
			$query = "SELECT `User`.* FROM `User` INNER JOIN `QuestionnaireParticipation` on `QuestionnaireParticipation`.`user_id`=`User`.`id` WHERE `QuestionnaireParticipation`.`questionnaire_id`=? AND `QuestionnaireParticipation`.`participation_type`=?";

			$statement = $this->getStatement($query);

			$statement->setParameters('ii' ,$questionnaireId,$participationType);

			$resultSet = $statement->execute();

			// init array that will hold the users
			$users = array();

			while($resultSet->next()){

				$accessLevel = $resultSet->get("access");

				$user = 0;
				if( $accessLevel == 1 )
					$user = new Player();
				else if ( $accessLevel == 2)
					$user = new Examiner();
				else if ( $accessLevel == 3)
					$user = new Moderator();

				$user->setAccessLevel($accessLevel);
				$user->setId( $resultSet->get("id") );
				$user->setName( $resultSet->get("name") );
				$user->setSurname( $resultSet->get("surname") );
				$user->setEmail( $resultSet->get("email") );
				$user->setGender( $resultSet->get("gender") );
				$user->setCountry( $resultSet->get("country") );
				$user->setCity( $resultSet->get("city") );
				$user->setVerified( $resultSet->get("verified") );
				$user->setDeleted( $resultSet->get("deleted") );
				$user->setBanned( $resultSet->get("banned") );
				$user->setEmailVerificationToken( $resultSet->get("email_verification_token") );
				$user->setEmailVerificationDate( $resultSet->get("email_verification_date") );
				$user->setPasswordRecoveryToken( $resultSet->get("password_recovery_token") );
				$user->setPasswordRecoveryDate( $resultSet->get("password_recovery_date") );
				$user->setApiToken($resultSet->get("api_token"));
				$user->setNewEmail( $resultSet->get("new_email") );

				if( $resultSet->get("address") !== null )
					$user->setAddress( $resultSet->get("address") );

				if( $resultSet->get("phone") !== null )
					$user->setPhone( $resultSet->get("phone") ); 

				$users[] = $user;
			}

			return $users;
		}

		public function persist($user){
			$id =  $user->getId();
			if( isset( $id ) ){
				$this->_update($user);
			}else
				$this->_create($user);
		}


		private function _update($user){
			if( self::emailInUseNotByMe($user->getEmail() ,$user->getId() ) )
				throw new EmailInUseException("This email is in use by another user.");

			$statement = $this->getStatement(
				"UPDATE `User` ".
				"SET `email`=?,`access`=?,`name`=?, `surname`=?, ".
				"`gender`=?,`country`=?,`city`=?, `address`=?, ".
				"`phone`=?, `password`=COALESCE(?,`password`) , ".
				"`banned`=? , `deleted`=? , `verified`=?, ".
				"`email_verification_token`=?, `password_recovery_token`=?, ".
				"`api_token`=? ,".
				"`new_email`=? ".
				"WHERE `id`=?");

			$statement->setParameters("sississsssiiissssi",	
				$user->getEmail(),
				$user->getAccessLevel(),
				$user->getName(),
				$user->getSurname(),
				$user->getGender(),
				$user->getCountry(),
				$user->getCity(),
				$user->getAddress(),
				$user->getPhone(),
				$user->getPassword(),
				$user->getBanned(),
				$user->getDeleted(),
				$user->getVerified(),
				$user->getEmailVerificationToken(),
				$user->getPasswordRecoveryToken(),
				$user->getApiToken(),
				$user->getNewEmail(),
				$user->getId() );

			$statement->executeUpdate();
		}


		private function _create($user){
			if( self::emailInUse($user->getEmail()) )
				throw new EmailInUseException("This email is in use by another user.");


			$statement = $this->getStatement("insert into User (email,password,access,name,surname,gender,country,city,address,phone,banned,deleted,verified,email_verification_token,api_token) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

			$statement->setParameters("ssississssiiiss",	
				$user->getEmail(),
				$user->getPassword(),
				$user->getAccessLevel(),
				$user->getName(),
				$user->getSurname(),
				$user->getGender(),
				$user->getCountry(),
				$user->getCity(),
				$user->getAddress(),
				$user->getPhone(),
				$user->getBanned(),
				$user->getDeleted(),
				$user->getVerified(),
				$user->getEmailVerificationToken(),
				$user->getApiToken()  );

			$statement->executeUpdate();
		}

		/*
			Removes a user from the database
		 */
		public function delete($user){
			$statement = $this->getStatement("delete from user where id=?");

			$statement->setParameters("i" , $user->getId());

			$statement->executeUpdate();
		}

		public function getIdByEmail($email){
			$statement = $this->getStatement("select id from User where email=?");
			$statement->setParameters("s" ,$email);

			$resultSet = $statement->execute();

			if($resultSet->next()){
				return $resultSet->get("id");
			}
			return null;
		}

		/*
			Checks if an email already exists in the database
		 */
		public function emailInUse($email){
			$statement = $this->getStatement("select email from User where email=? and deleted=0");
			$statement->setParameters("s" , $email);

			$result = $statement->execute();

			if($result->getRowCount() > 0)
				return true;
			else 
				return false;
		}


		public function emailInUseNotByMe($email , $myId){
			$statement = $this->getStatement("select email from User where email=? and id<>? and deleted=0");
			$statement->setParameters("si" , $email , $myId);

			$result = $statement->execute();

			if($result->getRowCount() > 0)
				return true;
			else 
				return false;
		}

		public function isBanned($userId){
			$query = "select banned from User where id=?";

			$statement = $this->getStatement($query);

			$statement->setParameters("i" , $userId);

			$resultSet = $statement->execute();

			if($resultSet->next()){
				$banned = $resultSet->get("banned");

				if( $banned == "0" )
					return false;
				else
					return true;
			}else{
				/*
					Not really banned , if this code executes it means the user
					doesnt exists. We return true because its safer for the calling
					code to assume the user is banned than he is not.
				 */ 
				return true;
			}
		}

		public function banExaminersOfQuestionnaire($questionnaireId)
		{
			$query =   "UPDATE `User`
						INNER JOIN `QuestionnaireParticipation`
						ON `QuestionnaireParticipation` .`user_id`=`User`.`id`
						SET `User`.`banned`=1
						WHERE `QuestionnaireParticipation`.`participation_type`=2 AND `QuestionnaireParticipation`.`questionnaire_id`=?";
			
			$statement = $this->getStatement($query);

			$statement->setParameters("i" , $questionnaireId);

			$statement->executeUpdate();
		}

		public function findUserLevel($userId){
			$statement = $this->getStatement("SELECT `access` FROM `User` WHERE `id`=?");

			$statement->setParameters('i' , $userId);

			$set = $statement->execute();

			if($set->next()){
				return $set->get("access");
			}
			return 0;
		}

		public function updateEmailVerificationDate($user){
			$statement = $this->getStatement("UPDATE `User` SET `email_verification_date`=CURRENT_TIMESTAMP WHERE `id`=?");

			$statement->setParameters("i" , $user->getId());

			$statement->executeUpdate();
		}

		public function updatePasswordRecoveryDate($user){
			$statement = $this->getStatement("UPDATE `User` SET `password_recovery_date`=CURRENT_TIMESTAMP WHERE `id`=?");

			$statement->setParameters("i" , $user->getId());

			$statement->executeUpdate();
		}

		/*
			Returns false if the authentication was failed.
			Returns the access level if the access level is below 0
			else it returns the user object meaning it was successful.
		 */
		public function authenticate($email , $password){
			$query =	"select User.* from User ".
						"where User.email=? and User.deleted=0";

			$preparedStatement = $this->getStatement($query);
			$preparedStatement->setParameters('s' , $email);

			$set = $preparedStatement->execute();

			if($set->next()){
				$deleted = $set->get("deleted");
				$verified = $set->get("verified");
				$banned = $set->get("banned");

				if( !$verified)
					return "2";
				else if($deleted)
					return "3";
				else if($banned)
					return "4";

				$hashedPassword = $set->get("password");
				if(password_verify($password , $hashedPassword)){
					$user = 0;
					$userType = $set->get("access");
					if( $userType == "1" )
						$user = new Player();
					else if( $userType == "2")
						$user = new Examiner();
					else if( $userType == "3");
						$user = new Moderator();

					$user->setDeleted($deleted);
					$user->setVerified($verified);
					$user->setName($set->get("name"));
					$user->setSurname($set->get("surname"));
					$user->setApiToken($set->get("api_token"));
					$user->setBanned($banned);
					$user->setId( $set->get("id") );
					$user->setEmail( $email);
					$user->setAccessLevel( $set->get("access"));

					return $user;
				}else{
					return null;
				}
			}else{
				return null;
			}
		}

		public function authenticateByToken($token){
			$query =	"select AccessLevel.name, User.access, User.id , User.verified , User.deleted ,User.banned from User ".
						"inner join AccessLevel on AccessLevel.id = User.access ".
						"where User.api_token=?";

			$preparedStatement = $this->getStatement($query);
			$preparedStatement->setParameters('s' , $token);

			$set = $preparedStatement->execute();

			if($set->next()){
				$deleted = $set->get("deleted");
				$verified = $set->get("verified");
				$banned = $set->get("banned");

				if( !$verified)
					return "2";
				else if($deleted)
					return "3";
				else if($banned)
					return "4";

				$user = 0;
				$userType = $set->get("name");
				if( $userType == "Player" )
					$user = new Player();
				else if( $userType == "Examiner")
					$user = new Examiner();
				else if( $userType == "Moderator");
					$user = new Moderator();
					
				$user->setDeleted($deleted);
				$user->setVerified($verified);
				$user->setBanned($banned);
				$user->setId( $set->get("id") );
				$user->setAccessLevel( $set->get("access"));

				return $user;
			}else{
				return null;
			}
		}


		/*
			Returns the userId that corresponds to the $token.
			If the token is not valid the function returns false
		 */
		public function verifyEmailToken($token){

			$statement = $this->getStatement( "SELECT `id` FROM `User` WHERE `email_verification_token`=? AND TIMESTAMPDIFF(HOUR,`email_verification_date`,CURRENT_TIMESTAMP)<?");

			$statement->setParameters('si',$token , 24);

			$set = $statement->execute();


			if($set->next()){
				return $set->get("id");
			}else{
				return 0;
			}
		}

		/*
			Returns the userId that corresponds to the $token.
			If the token is not valid the function returns false
		 */
		public function verifyPasswordToken($token){

			$statement = $this->getStatement( "SELECT `id` FROM `User` WHERE `password_recovery_token`=? AND TIMESTAMPDIFF(HOUR,`password_recovery_date`,CURRENT_TIMESTAMP)<?");

			$statement->setParameters('si',$token , 24);

			$set = $statement->execute();


			if($set->next()){
				return $set->get("id");
			}else{
				return 0;
			}
		}

	}