<? if($section == "QUESTION_LIST") : ?>
<div class="modal fade" id="question-list" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="material-icons">question_answer</span> Questions </h4>
       </div>
       <div class="modal-body container-fluid text-center">
         <?php
          echo "<div class='list-group' id='question-list-group'>";

          echo "</div>";
         ?>
       </div>
     </div>
   </div>
 </div>

<? endif; ?>
