<? if($section == "SIGN_UP") : ?>
 <div class="modal fade" id="registerModal" role="dialog">
	 <div class="modal-dialog modal-md">
		 <div class="modal-content">
			 <div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal">&times;</button>
				 	 <h4><span class="glyphicon glyphicon-lock"></span> Register Page</h4>
			 </div>
			 <div class="modal-body">
						<form role="form" class="form-horizontal">
							<div class="form-group">
                 <div class="col-xs-2">
								    <!--   <label class="control-label" for="email">Email</label> -->
                        <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
                 </div>
                 <div class="col-xs-7">
								        <input class="form-control" type="email" id="signup-email" placeholder="Email">
                 </div>
							 </div>
							 <div class="form-group">
                 <div class="col-xs-2">
								        <!--  <label class="control-label" for="pwd">Password:</label> -->
                        <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
                 </div>
                 <div class="col-xs-7">
								        <input type="password" class="form-control" id="signup-password" placeholder="Password">
                 </div>
               </div>
							 <div class="form-group">
                   <div class="col-xs-2">
								      <!--  <label class="control-label">Name</label> -->
                      <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                   </div>
                   <div class="col-xs-7">
							 		      <input class="form-control" type="text" id="signup-fname" placeholder="First Name" />
                   </div>
               </div>
							 <div class="form-group">
                  <div class="col-xs-2">
									  <!--  <label class="control-label">Surname</label> -->
                    <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                  </div>
                  <div class="col-xs-7">
							 		    <input class="form-control" type="text" id="signup-lname" placeholder="Last Name" />
                  </div>
               </div>
							 <div class="form-group">
                  <div class="col-xs-2">
								     <!--  <label class="control-label" for="sel1">Gender</label> -->
                     <span class="text-center"><i class="fi-male-female bigicon"></i></span>
                  </div>
                  <div class="col-xs-7">
    								  <select class="form-control" id="signup-gender">
    								    <option>Male</option>
    								    <option>Female</option>
    								  </select>
                  </div>
							 </div>
							 <div class="form-group">
                  <div class="col-xs-2">
									    <!--  <label class="control-label">Country</label> -->
                      <span class="text-center"><i class="glyphicon glyphicon-globe bigicon"></i></span>
                  </div>
                  <div class="col-xs-7">
							 		  <input class="form-control" type="text" id="signup-country" placeholder="Country" />
                  </div>
               </div>
							 <div class="form-group">
                  <div class="col-xs-2">
									    <!-- <label class="control-label">City</label> -->
                      <span class="text-center"><i class="material-icons bigicon">location_city</i></span>
                  </div>
                  <div class="col-xs-7">
							 		    <input class="form-control" type="text" id="signup-city" placeholder="City" />
                  </div>
               </div>
							 <div class="form-group">
                  <div class="col-xs-2">
									    <!--  <label class="control-label">Address</label> -->
                      <span class="text-center"><i class="glyphicon glyphicon-home bigicon"></i></span>
                  </div>
                  <div class="col-xs-7">
                      <input class="form-control" type="text" id="signup-address" placeholder="Address" />
                  </div>
               </div>
							 <div class="form-group">
                  <div class="col-xs-2">
									    <!--  <label class="control-label">Phone</label> -->
                      <span class="text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
                  </div>
                  <div class="col-xs-7">
							 		          <input class="form-control" type="text" id="signup-phone" placeholder="Phone" />
                  </div>
               </div>
							<div class="checkbox">
                <div class="col-xs-2">
                </div>
                <div class="col-xs-7">
                  <label class="control-label">
                    <input type="checkbox" id="signup-licence"/>Accept the <a href="#" target="_blank" >Licence</a>
                  </label>
                </div>
							</div>
              <div class="form-group">
                <div id="signup-spinner"> </div>
                <div class="col-xs-11">
                  <label id="signup-response" class="responseLabel"></label>
                </div>
              </div>
						</form>
				</div>
			 <div class="modal-footer">
				 <button type="button" class="btn btn-primary btn-md round" onclick="signUp()" >Sign Up</button>
				 <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal">Close</button>
			 </div>
		 </div>
	 </div>
 </div>

<? endif; ?>
