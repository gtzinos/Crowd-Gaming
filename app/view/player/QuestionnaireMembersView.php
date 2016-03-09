<? if($section == "QUESTIONNAIRE_MEMBERS") : ?>

	<div class="modal fade" id="questionnaire-modal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 ><span class="glyphicon glyphicon-lock"></span> Questionnaire Members </h4>
				 </div>
				 <div class="modal-body container-fluid">
           <?php
            echo "<div class='list-group'>";
            foreach(get("questionnaire") as $questionnaire)
            {
              echo "<a href='#' class='list-group-item'>" . $questionnaire . "</a>";
            }
            echo "</div>";
           ?>
				 </div>

			 </div>
		 </div>
	 </div>

<? endif; ?>
