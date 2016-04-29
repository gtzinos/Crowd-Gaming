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
              <br><br>
              <form role="form" class="form-horizontal" onsubmit="return false">
                <div class="form-group">
                  <div class="col-xs-7 col-xs-offset-3 col-sm-6">
                    	<select id="multiple-day-dropdown" class="selectpicker form-control" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count > 2" title="Select the days">
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                    	</select>
                  </div>
                </div>
                <br><br>
                <!-- Schedule plan -->
                <div id="schedule-plan">

                </div>
              </form>

            </div>

          </div>

       </div>
     </div>
   </div>
 </div>
<?php endif; ?>