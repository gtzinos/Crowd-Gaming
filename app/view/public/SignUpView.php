<? if($section == "SIGN_UP") : ?>
 <div class="modal fade" id="registerModal" role="dialog">
	 <div class="modal-dialog modal-md">
		 <div class="modal-content">
			 <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 	 <h4><span class="glyphicon glyphicon-lock"></span> Register Page</h4>
			 </div>
			 <div class="modal-body">
						<form role="form">
							<div class="form-group">
								 <label for="email">Email</label>
								 <input class="form-control" type="email"  placeholder="Email">
							 </div>
							 <div class="form-group">
								 <label for="pwd">Password:</label>
								 <input type="password" class="form-control" placeholder="Password">
							 </div>
							 <div class="form-group">
								   <label>First Name</label>
							 		<input class="form-control" type="text"  placeholder="First Name" />
							 </div>
							 <div class="form-group">
									<label>Last Name</label>
							 		<input class="form-control" type="text"  placeholder="Last Name" />
							 </div>
							 <div class="form-group">
								  <label for="sel1">Gender</label>
								  <select class="form-control" id="gender">
								    <option>Male</option>
								    <option>Female</option>
								  </select>
							 </div>
							 <div class="form-group">
									<label>Country</label>
							 		<input class="form-control" type="text"  placeholder="Country" />
							 </div>
							 <div class="form-group">
									<label>City</label>
							 		<input class="form-control" type="text"  placeholder="City" />
							 </div>
							 <div class="form-group">
									<label>Address</label>
							 		<input class="form-control" type="text"  placeholder="Address" />
							 </div>
							 <div class="form-group">
									<label>Phone</label>
							 		<input class="form-control" type="text"  placeholder="Phone" />
							 </div>
							<div class="checkbox">
								<label>
									<input type="checkbox" />Accept licence
								</label>
							</div>

						</form>
				</div>
			 <div class="modal-footer">
				 <button type="button" class="btn btn-primary btn-md round">Sign Up</button>
				 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal">Close</button>
			 </div>
		 </div>
	 </div>
 </div>

<? endif; ?>