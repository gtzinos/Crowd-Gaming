<? if($section == "CONTACT_WITH_ONE_EMAIL") : ?>
	<div class="modal fade" id="contact-modal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal">&times;</button>
					 <h4 class="gt-modal-header"><span class="material-icons">message</span> Ask Something </h4>
				 </div>
				 <div class="modal-body container-fluid">
						<form id="contact-form" onsubmit="return !$('#contact-coordinator').prop('disabled')" method="POST" class="form-horizontal">
              <div class="form-group has-feedback">
                  <div class="col-xs-offset-0 col-xs-1 col-md-offset-1">
                      <span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                  </div>
                  <div class="col-xs-offset-1 col-xs-7 col-md-offset-1 col-md-7 gt-input-group" data-validate="length" data-length="10">
                      <textarea class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 10 characters" maxlength="1000" id="contact-message" style="height:60px" name="contact-message" placeholder="Write a message. (Required)" required><?php
													if(isset($_POST["contact-message"]) && $_POST["contact-message"] != "")
													{
														echo $_POST["contact-message"];
													}
											?></textarea>
                      <span class="gt-icon"></span>
                  </div>
              </div>
						</form>
				 </div>
				<!-- Footer fields -->
				<div class="modal-footer container-fluid">
						<!-- Send Email / Cancel Button Field -->
						<div class="form-group">
							 <div class="col-xs-offset-2 col-xs-5 col-sm-offset-2 col-sm-4">
								 <!-- A Script will add on click method -->
								 <button id="contact-coordinator" form="contact-form" type="button" class="btn btn-primary btn-md gt-submit" onclick="$('#contact-form').submit()" disabled>Send Message</button>
							 </div>
							 <div class="col-xs-3 col-sm-2">
								 <button type="button" class="btn btn-primary btn-md" data-dismiss="modal" >
									 Cancel
								 </button>
							 </div>
						</div>
				 </div>
			 </div>
		 </div>
	 </div>

<? endif; ?>
