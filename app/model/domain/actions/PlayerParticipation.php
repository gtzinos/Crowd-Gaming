<?php
	include_once 'Participation.php';

	class PlayerParticipation extends Participation{

		public function __construct(){
			$this->setParticipationType(1);
		}

	}
