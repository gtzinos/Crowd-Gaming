<? if($section == "QUESTION_GROUP_USERS") : ?>
<div class="modal fade" id="question-group-users" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="fa fa-users"></span> Question Group Users </h4>
       </div>
       <div class="modal-body container-fluid">

         <div class="form-group row">
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
             	<select id="single-group-dropdown" class="selectpicker" data-live-search="true" data-width="100%" title="Select a question group">

             	</select>
           </div>
         </div>
         <br>
         <br>
         <div class="form-group row">
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-5">
             <select id="questionnaire-users-dropdown" class="selectpicker" data-live-search="true" data-width="100%" title="Select questionnaire users" multiple data-actions-box="true" multiple data-selected-text-format="count > 2">

             </select>
           </div>
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-3">
             <button type="button" style="width:100%" class="btn btn-primary" onclick='add_user_on_question_group()' >Insert users</button>
           </div>
         </div>
         <div class="form-group row">
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-5">
             <select id="question-group-users-dropdown" class="selectpicker" data-live-search="true" data-width="100%" title="Select group users" multiple data-actions-box="true" multiple data-selected-text-format="count > 2">

             </select>
           </div>
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-3">
             <button type="button" style="width:100%" class="btn btn-danger" onclick='delete_user_from_question_group()'>Delete users</button>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>

<? endif; ?>
