<? if($section == "EDIT_QUESTIONNAIRE") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionnaire.js"); ?>"></script>
<?php
  /*
    Questionnaire Object
  */
  $questionnaire = get("questionnaire")["questionnaire"];
?>
<!-- Modal Box -->
<div class="modal fade" id="edit-questionnaire" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="fa fa-pencil"></span> Edit Questionnaire</h4>
       </div>
       <div class="modal-body container-fluid">
          <form method="POST" id="edit-questionnaire-form" class="form-horizontal" onsubmit="return false">
              <!-- Questionnaire Name -->
              <div class="form-group has-feedback">
                  <div class="col-xs-12 col-sm-offset-1 col-sm-2">
                    <label for="qname">Name</label>
                  </div>
                  <div class="col-xs-12 col-sm-8 gt-input-group" data-validate="length" data-length="2">
                     <input class="form-control" value="<?php echo $questionnaire->getName() ?>" data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" id="qname" type="text" maxlength="255" placeholder="Questionnaire name (Required)" required>
                     <span class="gt-icon"></span>
                  </div>
              </div>
              <!-- Questionnaire Description -->
              <div class="form-group has-feedback">
                  <div class="col-xs-12 col-sm-offset-1 col-sm-2">
                    <label for="qeditor">Description</label>
                  </div>
                  <div class="col-xs-12 col-sm-8 gt-input-group" data-validate="length" data-length="30">
                     <textarea class="form-control mce-editor" style="height:150px" id="qeditor" data-toggle="tooltip" id="editor" id="questionnaire-description" required ><?php echo $questionnaire->getDescription() ?></textarea>
                      <span class="gt-icon"></span>
                  </div>
              </div>
              <!-- Allow multiple groups playthrough ? -->
    					<div class="form-group has-feedback">
    							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-9">
    								<label for="allow-multiple-groups-playthrough">Allow multiple groups playthrough ?</label>
    							</div>
    							<div class="col-xs-offset-0 col-xs-12 col-md-offset-3 col-md-6 gt-input-group" data-validate="select">
    								<select id="allow-multiple-groups-playthrough" class="form-control" required>
                      <?php
                        /*
                          Allow multiple groups playthrough
                        */
                        if($questionnaire->getAllowMultipleGroups() == 0)
                        {
                          echo "<option value='0' selected>No</option>";
                          echo "<option value='1'>Yes</option>";
                        }
                        /*
                          Not allow multiple groups playthrough
                        */
                        else
                        {
                          echo "<option value='0' >No</option>";
                          echo "<option value='1' selected>Yes</option>";
                        }
                      ?>
    								</select>
    								<span class="gt-icon"></span>
    							</div>
    					</div>
              <!-- Password Required -->
              <div class="form-group has-feedback">
                  <div class="col-xs-12 col-sm-offset-3 col-sm-9">
                    <label for="message-required">Would you like users send a password ?</label>
                  </div>
                  <div class="col-xs-12 col-sm-offset-3 col-sm-6 gt-input-group" data-validate="select">
                    <select id="message-required" class="form-control" data-toggle="tooltip" gt-error-message="Not a valid gender type" required>
                      <?php
                        /*
                          Password required
                        */
                        if($questionnaire->getMessageRequired())
                        {
                          echo "<option value='no'>No</option>";
                          echo "<option value='yes' selected>Yes</option>";
                        }
                        /*
                          No Password required
                        */
                        else
                        {
                          echo "<option value='no' selected>No</option>";
                          echo "<option value='yes'>Yes</option>";
                        }
                      ?>
                    </select>
                     <span class="gt-icon"></span>
                  </div>
              </div>
              <!-- Questionnaire password -->
              <div class="form-group has-feedback">
                  <div class="col-xs-12 col-sm-offset-3 col-sm-9">
                    <label for="email">Questionnaire password</label>
                  </div>
                  <div class="col-xs-12 col-sm-offset-3 col-sm-6 gt-input-group" data-validate="length" data-length="1">
                    <?php
                      if($questionnaire->getMessage() != "" || $questionnaire->getMessageRequired())
                      {
                        echo "<input id='questionnaire-password' type='password' class='form-control' value='" . $questionnaire->getMessage() . "' required>";
                      }
                      else {
                        echo "<input id='questionnaire-password' type='password' class='form-control' value='' disabled>";
                      }
                      ?>
                     <span class="gt-icon"></span>
                  </div>
              </div>
              <!-- Response Label Field -->
              <div class="form-group">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-6">
                  <div id="edit-questionnaire-spinner"></div>
                  <label id="questionnaire-edit-response" class="responseLabel">
                  </label>
                </div>
              </div>
              <!-- Update questionnaire submit button -->
              <div class="form-group has-feedback">
                <div class="col-xs-4 col-sm-offset-3 col-sm-2">
                  <button type="button" id="edit-questionnaire-submit" class="btn btn-primary gt-submit" form="edit-questionnaire-form" onclick="updateQuestionnaire(<?php echo $questionnaire->getId(); ?>)" disabled="disabled">Save</button>
                </div>
                <div class="col-xs-3 col-sm-3" style="padding:0px">
                  <button type="button" class="btn btn-primary" onclick="location.href='<?php echo LinkUtils::generatePageLink('question-groups') . "/" . $questionnaire->getId(); ?>';" >Edit Groups</button>
                </div>
              </div>
          </form>
          <!-- fa fa-pencil-square-o -->
        </div>
      </div>
    </div>
  </div>



  <? endif; ?>
