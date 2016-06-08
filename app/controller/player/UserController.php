<?php
	include_once '../app/model/mappers/user/UserMapper.php';

	class UserController extends Controller{

		public function init(){
			global $_CONFIG;

			$view = new HtmlView;

			$view->setTemplate($_CONFIG["BASE_TEMPLATE"]);

			$view->defSection('CSS','player/UserView.php');
			$view->defSection('JAVASCRIPT','player/UserView.php');
			$view->defSection('MAIN_CONTENT','player/UserView.php');

			$this->setView( $view);
		}

		public function run(){
			/*
				This page shows some information about any user.

				The first parameters is the id of the User
			 */
			if( !isset($this->params[1]) ){
				// If parameter is not set redirect to the default page
				$this->redirect("");
			}

			$userMapper = new UserMapper;


			$user = $userMapper->findById( $this->params[1] );

			if( $user === null )
			{
				$this->redirect("home");
			}

			$this->setArg("PAGE_TITLE",$user->getName() . ' '.$user->getSurname());

			if($user->getId() == $_SESSION['USER_ID'])
			{
				$this->redirect("profile");
			}

			$this->setArg("user" , $user);
		}

	}
