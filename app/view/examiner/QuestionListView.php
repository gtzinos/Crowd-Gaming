<? if($section == "CONFIRM_PASSWORD") : ?>
<div class="modal fade" id="question-list" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span> Questions </h4>
       </div>
       <div class="modal-body container-fluid text-center">
         <?php
          echo "<div class='list-group'>";
          $count=0;
            foreach(get("groups")["questions"] as $member)
            {
              $count++;
              echo "<a href='" . LinkUtils::generatePageLink('user') . "/" .
                $member["user"]->getId() . "' target='_blank' class='list-group-item'>" .
                $member["user"]->getName() . " " . $member["user"]->getSurname() . " (";
                echo ")</a>";

            }
          /*
            No members
          */
          if($count == 0)
          {
            echo "<label class='alert alert-danger text-center'>There are no questions on this questionnaire group</label>";
          }
          echo "</div>";
         ?>
       </div>

     </div>
   </div>
 </div>

<? endif; ?>
