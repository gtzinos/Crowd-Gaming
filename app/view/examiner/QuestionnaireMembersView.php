<? if($section == "QUESTIONNAIRE_MEMBERS") : ?>
<div class="modal fade" id="manage-questionnaire-members" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span> Manage Questionnaire Users </h4>
       </div>
       <div class="modal-body container-fluid">

         <div class="form-group">
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-4">
             	<select id="single-questionnaire-dropdown" class="selectpicker" data-live-search="true" title="Select a questionnaire">

             	</select>
           </div>
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-4">
             	<button class="btn" onclick="find_participants()">Find Members</button>
           </div>
         </div>
         <br>
         <br>
         <br>
         <div class="form-group col-xs-12">
             <select id="questionnaire-members-dropdown" class="selectpicker" data-live-search="true" title="Select some users" multiple data-actions-box="true" multiple data-selected-text-format="count > 2">

             </select>
         </div>

         <div class="form-group">
           <div class="col-xs-offset-0 col-xs-3 col-sm-2">
               <input type="button" class="btn btn-primary" value="Add Members" onclick="save_users()">
           </div>
           <div class="col-xs-offset-1 col-xs-4 col-sm-offset-1 col-sm-4">
               <input type="button" class="btn btn-primary" value="Override Members" onclick="save_users()">
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>

<? endif; ?>
