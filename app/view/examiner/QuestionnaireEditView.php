<? if($section == "EDIT_QUESTIONNAIRE") : ?>
<!-- Tinymce editor -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
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
         <h4 class="gt-modal-header">Edit Questionnaire <span class="fa fa-pencil"></span> </h4>
       </div>
       <div class="modal-body container-fluid">
          <form method="POST" id="edit-questionnaire-form" class="form-horizontal" onsubmit="return false">
              <!-- Questionnaire Name -->
              <div class="form-group has-feedback">
                  <div class="col-xs-12 col-sm-offset-1 col-sm-2">
                    <label for="email">Name</label>
                  </div>
                  <div class="col-xs-12 col-sm-8 gt-input-group" data-validate="length" data-length="2">
                     <input class="form-control" value="<?php echo $questionnaire->getName() ?>" data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" id="qname" type="text" maxlength="255" placeholder="Questionnaire name (Required)" required>
                     <span class="gt-icon"></span>
                  </div>
              </div>
              <!-- Questionnaire Description -->
              <div class="form-group has-feedback">
                  <div class="col-xs-12 col-sm-offset-1 col-sm-2">
                    <label for="email">Description</label>
                  </div>
                  <div class="col-xs-12 col-sm-8 gt-input-group" data-validate="length" data-length="30">
                     <textarea class="form-control mce-editor" style="height:150px" id="qeditor" data-toggle="tooltip" gt-error-message="Must contain at least 30 characters" id="editor" id="questionnaire-description" placeholder="Questionnaire Description (Required) *Length >= 20" required ><?php echo $questionnaire->getDescription() ?></textarea>
                      <span class="gt-icon"></span>
                  </div>
              </div>

              <!-- Message Required -->
              <div class="form-group has-feedback">
                  <div class="col-xs-12 col-sm-offset-3 col-sm-9">
                    <label for="email">Would you like users send a password ?</label>
                  </div>
                  <div class="col-xs-12 col-sm-offset-3 col-sm-6 gt-input-group" data-validate="length" data-length="2">
                    <select id="mrequired" class="form-control" data-toggle="tooltip" gt-error-message="Not a valid gender type" required>
                      <?php
                        /*
                          Message required
                        */
                        if($questionnaire->getMessageRequired())
                        {
                          echo "<option value='no'>No</option>";
                          echo "<option value='yes' selected>Yes</option>";
                        }
                        /*
                          No Message required
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
              <!-- Update questionnaire submit button -->
              <div class="form-group has-feedback">
                <div class="col-xs-3 col-sm-offset-3 col-sm-2">
                  <button type="button" id="edit-questionnaire" class="btn btn-primary gt-submit" form="edit-questionnaire-form" onclick="updateQuestionnaire(<?php echo $questionnaire->getId(); ?>)" disabled="disabled">Save</button>
                </div>
                <div class="col-xs-3 col-sm-3" style="padding:0px">
                  <button type="button" class="btn btn-primary" onclick="location.href='<?php echo LinkUtils::generatePageLink('questionnaire-groups') . "/" . $questionnaire->getId(); ?>';" >Edit Groups</button>
                </div>
              </div>
              <!-- Response Label Field -->
              <div class="form-group" style="margin-top:5%">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8">
                  <label id="questionnaire-edit-response" class="responseLabel">
                    <?php
                       /*
                         Display errors
                       */
                    ?>
                  </label>
                </div>
              </div>
          </form>
          <!-- fa fa-pencil-square-o -->
        </div>
      </div>
    </div>
  </div>



  <? endif; ?>
