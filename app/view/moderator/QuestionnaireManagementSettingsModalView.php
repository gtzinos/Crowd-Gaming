<? if($section == "QUESTIONNAIRE_MANAGEMENT_SETTINGS") : ?>
	<div class="modal fade" id="questionnaire-management-settings" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header" id='qtitle-actions-modal'></h4>
				 </div>
				 <div class="modal-body container-fluid">
           <ul class="nav nav-tabs">
              <li><a data-toggle="tab" href="#ban">Ban users</a></li>
              <li><a data-toggle="tab" href="#coordinator">Coordinator</a></li>
           </ul>

           <div class="tab-content">

               <!-- Schedule menu started -->
               <div id="ban" class="tab-pane fade">
                 <br><br>
                 <form role="form" class="form-horizontal" onsubmit="return false">
									 <div class="col-xs-7 col-sm-5">
				             <select id="questionnaire-members-dropdown" class="selectpicker form-control" data-live-search="true" title="Select some users" multiple data-actions-box="true" data-selected-text-format="count > 2">
				             </select>
				           </div>
				           <div class="col-xs-3 col-sm-4">
				             <div class="dropdown">
				                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Ban
				                <span class="caret"></span></button>
				                <ul class="dropdown-menu">
				                  <li><input type="button" class="btn btn-link" onclick="ban_members_from_questionnaire('ban',false)" value="Selected members"></li>
													<li><input type="button" class="btn btn-link" onclick="ban_all_examiners_from_questionnaire(false)" value="All examiners"></li>
				                </ul>
				             </div>
				           </div>
								 <br><br>
                 </form>

               </div>

							 <div id="coordinator" class="tab-pane fade">
								 <br><br>
								 <form role="form" class="form-horizontal" onsubmit="return false">
									 <div class="col-xs-6 col-sm-5">
				             <select id="questionnaire-available-coordinators-dropdown" class="selectpicker form-control" title="Select the new coordinator">
				             </select>
				           </div>
									<div class="form-group">
										<div class="col-xs-3 col-sm-4">
												<input type="button" class="btn btn-primary"  value="Change">
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
