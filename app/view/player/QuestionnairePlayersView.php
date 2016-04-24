<? if($section == "QUESTIONNAIRE_PLAYERS") : ?>

	<div class="modal fade" id="questionnaire-players" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span> Questionnaire Members </h4>
				 </div>
				 <div class="modal-body container-fluid text-center">
					 <div class="list-group" id="mgroup">
           <?php
					 $count=0;
					 $item_class = "col-xs-12";

					 //only for coordinators
					 if(get("questionnaire")["questionnaire"]->getCoordinatorId() == $_SESSION["USER_ID"])
					 {
						 $item_class = "col-xs-9 col-sm-9";
					 }

						foreach(get("questionnaire")["members-participating"] as $member)
						{
							if($member["player-participation"])
							{
								$count++;
								echo "<div id='mitem" . $member["user"]->getId() . "' class='list-group-item col-xs-12'>";

								echo "<a href='" . LinkUtils::generatePageLink('user') . "/" .
								$member["user"]->getId() . "' target='_blank' class='" . $item_class . "'>" .
								$member["user"]->getName() . " " . $member["user"]->getSurname() . " (";
								$bool = 0;
								if(get("questionnaire")["questionnaire"]->getCoordinatorId() ==  $member["user"]->getId())
								{
									$bool = 1;
									echo "Coordinator";
								}

								if($member["examiner-participation"])
								{
									if($bool) {
										echo ",";
										$bool = 0;
									}
									echo "Examiner";
									$bool = 1;
								}

								//player participation checked before
								if($bool) echo ",";
								echo "Player";

								echo ")</a>";

								//only for coordinators
								if(get("questionnaire")["questionnaire"]->getCoordinatorId() == $_SESSION["USER_ID"])
								{
									echo "<span onclick='remove_participant(" . $member["user"]->getId() . ",true)' class='col-xs-offset-1 col-xs-1 remove-question glyphicon glyphicon-trash remove-user'>
												</span>";
								}

								echo "</div>";
							}
						}

						/*
							No members
						*/
						if($count == 0)
						{
							echo "<label class='alert alert-danger text-center'>There are no members on this questionnaire</label>";
						}
            echo "</div>";
           ?>
				 </div>

			 </div>
		 </div>
	 </div>

<? endif; ?>
