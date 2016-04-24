<? if($section == "QUESTION_LIST") : ?>
<div class="modal fade" id="question-group-user" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span> Question Group Users </h4>
       </div>
       <div class="modal-body container-fluid">

         <div class="form-group row">
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-4">
             	<select id="single-group-dropdown" class="selectpicker" data-live-search="true" title="Select a question group">

             	</select>
           </div>
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-4">
             	<button class="btn" onclick="find_participants()">Find participants</button>
           </div>
         </div>
         <br>
         <br>
         <div class="form-group row">
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-4">
             <select id="question-group-users-dropdown" class="selectpicker" data-live-search="true" title="Select some users" multiple data-actions-box="true" multiple data-selected-text-format="count > 2">

             </select>
           </div>
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-4">
             <select id="multiple-group-dropdown" class="selectpicker" data-live-search="true" title="Select a question group" multiple data-actions-box="true" multiple data-selected-text-format="count > 2">

             </select>
           </div>
         </div>
         <div class="form-group row">
           <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-4">
               <input type="button" class="btn btn-primary" value="Save Users" onclick="save_users()">
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>

<? endif; ?>
