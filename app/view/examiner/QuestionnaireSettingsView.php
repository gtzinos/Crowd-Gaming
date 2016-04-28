<? if($section == "QUESTIONNAIRE_SETTINGS") : ?>
<div class="modal fade" id="questionnaire-settings" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span> Questionnaire Settings </h4>
       </div>
       <div class="modal-body container-fluid">
         <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#requests">Requests</a></li>
            <li><a data-toggle="tab" href="#schedule">Schedule</a></li>
         </ul>

         <div class="tab-content">
            <!-- Request menu started -->
            <div id="requests" class="tab-pane fade in active">


            </div>

            <!-- Schedule menu started -->
            <div id="schedule" class="tab-pane fade">


            </div>

          </div>

       </div>
     </div>
   </div>
 </div>
<?php endif; ?>