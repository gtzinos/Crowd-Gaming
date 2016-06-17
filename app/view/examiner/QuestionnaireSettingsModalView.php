<? if($section == "QUESTIONNAIRE_SETTINGS") : ?>
<?php
    $questionnaire = get("questionnaire")["questionnaire"];
?>
<div class="modal fade" id="questionnaire-settings" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="fa fa-cogs"></span> Questionnaire Settings </h4>
       </div>
       <div class="modal-body container-fluid">
         <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#requests">Requests</a></li>
            <li><a data-toggle="tab" href="#schedule">Schedule</a></li>
         </ul>

         <div class="tab-content">
            <!-- Request menu started -->
            <div id="requests" class="tab-pane fade in active">
              <br><br>



                    <?php
                      if($questionnaire->getPublic())
                      {
                        echo "
                          <div class='form-group'>
                            <div class='col-xs-12 col-xs-offset-0 col-sm-offset-2 col-sm-8'>
                              <div class='input-group'>
                                <input type='text' class='form-control' placeholder='Status' style='color:green' value='Public (All users)' readonly>
                                <span class='input-group-btn'>
                                  <button class='btn btn-error' type='button' disabled>Published</button>
                                </span>
                              </div>
                            </div>
                          </div>
                        ";

                      }
                      else if( get("questionnaire")["active-publish-request"])
                      {
                        //moderator view
                        if($_SESSION["USER_LEVEL"] == 3)
                        {
                          echo "
                            <div class='form-group'>
                              <div class='col-xs-12 col-xs-offset-0 col-sm-offset-2 col-sm-8'>
                                <div class='input-group'>
                                  <input type='text' class='form-control' placeholder='Status' style='color:black' value='Request submitted..' readonly>
                                  <span class='input-group-btn'>
                                       <button class='btn btn-danger' type='button' disabled>Delete request</button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          ";
                        }
                        else
                        {
                          echo "
                            <div class='form-group'>
                              <div class='col-xs-12 col-xs-offset-0 col-sm-offset-2 col-sm-8'>
                                <div class='input-group'>
                                  <input type='text' class='form-control' placeholder='Status' style='color:black' value='Request submitted..' readonly>
                                  <span class='input-group-btn'>
                                       <button class='btn btn-danger' type='button' onclick=\"delete_public_request()\">Delete request</button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          ";
                        }
                      }
                      else {
                        //moderator view
                        if($_SESSION["USER_LEVEL"] == 3)
                        {
                          echo "
                            <div class='form-group'>
                              <div class='col-xs-12 col-xs-offset-0 col-sm-offset-2 col-sm-8'>
                                <div class='input-group'>
                                  <input type='text' class='form-control' placeholder='Status' style='color:red' value='Private (Only examiners)' readonly>
                                  <span class='input-group-btn'>
                                       <button class='btn btn-success' type='button' disabled>Request for public</button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          ";
                        }
                        else
                        {
                          echo "
                            <form class='form-horizontal'>
                              <div class='form-group has-feedback'>
                                <div class='col-xs-12 col-sm-offset-3 col-sm-7 gt-input-group' data-validate='length' data-length='5'>
                                  <textarea id='publish-request-reason' class='form-control' placeholder='*Tell us the reason' required></textarea>
                                  <span class='gt-icon'></span>
                                </div>
                                <div style='margin-top:2%' class='col-sm-offset-3 col-xs-4'>
                                  <button id='publish-request-submit' class='btn btn-success' type='button' onclick='sendPublicRequest()'>Request for public</button>
                                </div>
                              </div>
                            </form>
                          ";
                        }
                      }
                    ?>
                    <span id="publish-request-spinner"></span>
            </div>

            <!-- Schedule menu started -->
            <div id="schedule" class="tab-pane fade">
              <br><br>
              <form role="form" class="form-horizontal" onsubmit="return false">
                <div class="form-group">
                  <div class="col-xs-112 col-xs-offset-0 col-sm-offset-3 col-sm-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="datepicker" placeholder="Select a specific date">
                        <span class="input-group-btn">
                             <button class="btn btn-default" type="button" onclick="$('#datepicker').val('');">Clear</button>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-10 col-xs-offset-0 col-sm-offset-3 col-sm-6">
                    	<select id="multiple-day-dropdown" class="selectpicker form-control" multiple data-selected-text-format="count > 2" title="Select the days">
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
                <br>
                <!-- Schedule plan -->
                <div id="schedule-plan">

                </div>
                <br>
                <div class="form-group">
                  <div id="update-schedule-spinner"></div>
                </div>
                <div class="form-group">
                  <div class="col-xs-4 col-xs-offset-0 col-sm-offset-3 col-sm-4">
                    	<input id="update-schedule-submit-button" type="button" class="btn btn-primary" value="Save Changes" onclick="updateSchedulePlan()">
                  </div>
                </div>
              </form>

            </div>

          </div>

       </div>
     </div>
   </div>
 </div>
<? endif; ?>
