<? if($section == "QUESTIONNAIRE_MEMBERS") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/examiner/ManageQuestionnaireMembers.js"); ?>"></script>
<div class="modal fade" id="manage-questionnaire-members" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span> Manage Questionnaire Users </h4>
       </div>
       <div class="modal-body container-fluid">
         <form role="form" class="form-horizontal" onsubmit="return false">
           <div class="form-group">
             <div class="col-xs-7 col-sm-5">
               	<select id="single-questionnaire-dropdown" class="selectpicker form-control" data-live-search="true" title="Select a questionnaire">

               	</select>
             </div>
             <div class="col-xs-3 col-sm-4">
               	<button class="btn" onclick="transfer_participants()">Transfer</button>
             </div>
           </div>
           <div class="form-group">
             <div class="col-xs-7 col-sm-5" >
               	<input id="find-a-user" type="text" class="form-control">
             </div>
             <div class="col-xs-3 col-sm-4">
               <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Add
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><input type="button" class="btn btn-link" onclick="add_member_on_questionnaire(1)" value="Add Player"></li>
                    <li><input type="button" class="btn btn-link" onclick="add_member_on_questionnaire(2)" value="Add Examiner"></li>
                  </ul>
               </div>
             </div>
           </div>
         <div class="form-group">
           <div class="col-xs-7 col-sm-5">
             <select id="questionnaire-members-dropdown" class="selectpicker form-control" data-live-search="true" title="Select some users" multiple data-actions-box="true" data-selected-text-format="count > 2">
             </select>
           </div>
           <div class="col-xs-3 col-sm-4">
             <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Delete
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><input type="button" class="btn btn-link" onclick="delete_members_from_questionnaire(1,false)" value="Delete Player"></li>
                  <li><input type="button" class="btn btn-link" onclick="delete_members_from_questionnaire(2,false)" value="Delete Examiner"></li>
                </ul>
             </div>
           </div>
         </div>
        </form>
       </div>
     </div>
   </div>
 </div>

<? endif; ?>
