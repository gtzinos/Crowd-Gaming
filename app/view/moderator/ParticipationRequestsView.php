<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/ParticipationRequests.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <legend class="text-center header">Participation Requests</legend>

  <div class="container-fluid">
    <div class="list-group" id="participation-requests-list">
      <div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'  style='border: 2px solid #30ADFF;' id='qitem" + questionnaires[i].id + "'>
          <div class='row'>
            <div class='visible-xs col-xs-offset-7 col-xs-3'>
                <div style='font-size:15px' class='list-group-item-heading'>20/12/2017</div>
            </div>
              <div class='col-xs-12 col-sm-7 col-md-8'>
                  <div style='font-size:18px' class='list-group-item-heading'><a class='user_name' style='color:black' target='_blank'>Georgios Tzinos</a></div>
              </div>
              <div class='hidden-xs col-sm-offset-2 col-sm-2'>
                  <div style='font-size:15px' class='list-group-item-heading'> 20/12/2016</div>
              </div>
          </div>
          <div class='row'>
            <div class='col-xs-12'>
                <div style='font-size:17px' > Type: <span style='color:#30ADFF'>Player</span></div>
            </div>
            <div class='col-xs-12 col-sm-5 col-md-6'>
                <div style='font-size:17px' > Game: <a class='user_name' style='color:black'>Questionnaire 1</a></div>
            </div>
              <div class='col-xs-offset-6 col-xs-6 col-sm-offset-4 col-sm-3 col-md-2'>
                <button type='button' class="btn btn-success"><span class='fa fa-check'></span></button>
                <button type='button' class="btn btn-danger"><span class='fi-x'></span></button>
              </div>
          </div>
          <!--
            <div class='row'>
              <div class='col-xs-12'>
                  <div style='font-size:17px' > Type: <span style='color:#30ADFF'>Player</span></div>
              </div>
              <div class='col-xs-12 col-sm-5 col-md-6'>
                  <div style='font-size:17px' > Game: Questionnaire 1</div>
              </div>
                <div class='col-xs-3 col-xs-offset-6 col-sm-offset-4 col-sm-3 col-md-2'>
                  <div class='dropdown'>
                      <span class='dropdown-toggle btn btn-default' type='button' data-toggle='dropdown' onclick='questionnaire_id = " + questionnaires[i].id + "; questionnaire_index = " + i + ";'>Actions
                      <span class='caret'></span></span>
                      <ul class='dropdown-menu' >
                        <li class='settingsitem'><a onclick=\"show_confirm_modal()\"><i class='glyphicon glyphicon-edit' ></i> Accept</a></li>
                        <li class='settingsitem'><a onclick=\"showModal('edit-questionnaire'); return false;\"><i class='glyphicon glyphicon-trash'></i> Decline</a></li>
                      </ul>
                  </div>
                </div>
            </div>
          -->
      </div>
    </div>
  </div>

<?php endif; ?>
