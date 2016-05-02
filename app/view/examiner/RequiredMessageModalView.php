<? if($section == "REQUIRED_MESSAGE") : ?>
	<div class="modal fade" id="required-message-modal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span>Send us some info for your request</h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form id="required-message-form" onsubmit="return false" method="POST" class="form-horizontal">
              <div class="form-group has-feedback">
                  <div class=" col-xs-2 col-sm-offset-1 col-sm-2">
                      <span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                  </div>
                  <div class="col-xs-7 gt-input-group" data-validate="length" data-length="5">
                      <textarea class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 5 characters" maxlength="1000" id="required-message" style="height:60px" name="required-message" placeholder="Send us a message. (Required)" required></textarea>
                      <span class="gt-icon"></span>
                  </div>
              </div>
						</form>
				 </div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<div class="form-group">
							 <div class="col-xs-offset-1 col-xs-5 col-sm-offset-2 col-sm-4">
								 <button form="required-message-form" type="button" class="btn btn-primary btn-md round gt-submit" onclick="sendPublicRequest()" disabled>Send request</button>
							 </div>
							 <div class="col-xs-offset-0 col-xs-3 col-sm-offset-0 col-sm-2">
								 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal" >
									 Cancel
								 </button>
							 </div>
						</div>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
