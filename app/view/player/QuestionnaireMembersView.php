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
							foreach(get("questionnaire")["players-participating"] as $member)
	            {
	              echo "<a href='" . LinkUtils::generatePageLink('user') . "/" . $member->getId() . "' target='_blank' class='list-group-item'>" . $member->getName() . " " . $member->getSurname() . " (" . ")</a>";
	            }
            echo "</div>";
           ?>
				 </div>

			 </div>
		 </div>
	 </div>

<? endif; ?>
