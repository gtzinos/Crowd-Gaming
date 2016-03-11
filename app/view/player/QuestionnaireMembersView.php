<? if($section == "QUESTIONNAIRE_MEMBERS") : ?>

	<div class="modal fade" id="questionnaire-modal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 ><span class="glyphicon glyphicon-lock"></span> Questionnaire Members </h4>
				 </div>
				 <div class="modal-body container-fluid text-center">
           <?php
            echo "<div class='list-group'>";
						$count=0;
							foreach(get("questionnaire")["members-participating"] as $member)
	            {
								$count++;
	              echo "<a href='" . LinkUtils::generatePageLink('user') . "/" .
								  $member["user"]->getId() . "' target='_blank' class='list-group-item'>" .
									$member["user"]->getName() . " " . $member["user"]->getSurname() . " (";
									$bool = 0;
									if(get("questionnaire")["questionnaire"]->getCoordinatorId() ==  $member["user"]->getId())
									{
										$bool = 1;
										echo "Coordinator";
									}
									if($bool) echo ",";
									$bool = 0;
									if($member["examiner-participation"])
									{
										echo "Examiner";
										$bool = 1;
									}
									if($bool) echo ",";
									if($member["player-participation"])
									{
										echo "Player";
									}

									echo ")</a>";

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
