<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
  <script src="<?php print LinkUtils::generatePublicLink("js/moderator/PublicationRequests.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>
  <legend class="text-center header">Participation Requests</legend>

  <div class="container-fluid">
    <div class="list-group" id="participation-requests-list">
      <div class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10' id='qitem" + questionnaires[i].id + "'>
          <div class='col-xs-12'>
              <div class='col-xs-6'>
                  <h4 class='list-group-item-heading'>Georgios Tzinos</h4>
              </div>
              <div class='col-xs-offset-3 col-xs-3'>
                  <h5 class='list-group-item-heading'> 20/12/2016</h5>
              </div>
          </div>
          <div class='col-xs-12'>
            <div class='col-xs-12'>
                <h5 class='list-group-item-heading'> Type : Player</h5>
            </div>
            <div class='col-xs-4 col-sm-5 col-md-4'>
                <h5 class='list-group-item-heading'> Game : Questionnaire 1</h5>
            </div>
              <div class='col-xs-3 col-sm-offset-4 col-sm-3 col-md-2'>
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
      </div>
    </div>
  </div>

<?php endif; ?>
