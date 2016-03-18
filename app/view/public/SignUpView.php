<? if($section == "SIGN_UP") : ?>
<div class="modal fade" id="registerModal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4><span class="glyphicon glyphicon-lock"></span> Register Page</h4>
       </div>
       <div class="modal-body container-fluid">

          <form onsubmit="return false" class="form-horizontal">
              <!-- Email Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                             <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 col-md-offset-0 col-md-8 block gt-input-group" data-validate="email">
                          <input class="form-control" data-toggle="tooltip" gt-error-message="Not a valid email address" id="signup-email" type="email" maxlength="40" placeholder="Email (Required)" required >
                          <span></span>
                      </div>
                  </div>
                  <!-- First Password Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="8">
                          <input class="form-control"  data-toggle="tooltip" gt-error-message="Must contain at least 8 characters" id="signup-password" type="password" placeholder="Password (Required) *Length >= 8" required >
                          <span></span>
                      </div>
                  </div>
                  <!-- Second Password Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="8" data-equal="signup-password">
                          <input class="form-control"  data-toggle="tooltip" gt-error-message="Must contain at least 8 characters" id="signup-repeat" type="password" placeholder="Repeat Password (Required)" required >
                          <span></span>
                      </div>
                  </div>
                  <!-- First Name Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="2">
                          <input class="form-control"  data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" id="signup-fname" maxlength="25" type="text" placeholder="First Name (Required) *Length >= 2" required >
                          <span></span>
                      </div>
                  </div>
                  <!-- Last Name Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="2">
                          <input class="form-control"  data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" id="signup-lname" maxlength="25" type="text" placeholder="Last Name (Required) *Length >= 2" required >
                          <span></span>
                      </div>
                  </div>
                  <!-- Gender Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="fi-male-female bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="select">
                        <select class="form-control" data-toggle="tooltip" gt-error-message="Not a valid gender type" id="signup-gender" required>
                          <option value="" disabled selected>Gender (Required)</option>
                          <option value="0">Male</option>
                          <option value="1">Female</option>
                        </select>
                        <span></span>
                      </div>
                  </div>
                  <!-- Country Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="glyphicon glyphicon-globe bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="3">
                          <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 3 characters" id="signup-country" maxlength="25" type="text" placeholder="Country (Required) *Length >= 3" required >
                          <span></span>
                      </div>
                  </div>
                  <!-- City Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="material-icons bigicon">location_city</i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="3">
                          <input class="form-control"  data-toggle="tooltip" gt-error-message="Must contain at least 3 characters" id="signup-city" maxlength="25" type="text" placeholder="City (Required) *Length >= 3" required >
                          <span></span>
                      </div>
                  </div>
                  <!-- Address Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="glyphicon glyphicon-home bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="length" data-length="5">
                          <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 5 characters" id="signup-address" maxlength="25" type="text" placeholder="Address (Optional) *Length >= 5" >
                          <span></span>
                      </div>
                  </div>
                  <!-- Phone Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-offset-1 col-xs-2">
                        <span class="text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
                      </div>
                      <div class="col-xs-offset-0 col-xs-8 block gt-input-group" data-validate="phone">
                          <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain 10 number" id="signup-phone" maxlength="15" type="text" placeholder="Phone (Optional)" >
                          <span></span>
                      </div>
                  </div>
                  <!-- Accept Licence Field -->
                  <div class="form-group has-feedback">
                      <div class="gt-input-group" data-validate="accept-checkbox">
                          <div class="col-xs-offset-3 col-xs-6 col-sm-offset-3 col-sm-4" >
                            <label class="control-label" style="font-size:12px">
                              <input id="signup-licence" type="checkbox" required />
                              Accept the <a href="#" target="_blank" >Licence</a>
                            </label>
                          </div>
                          <div class="col-xs-offset-0 col-xs-1 col-sm-offset-0 col-sm-2 ">
                            <span> </span>
                          </div>
                      </div>

                  </div>
                  <!-- Spinner and Response Label Field -->
                  <div class="form-group">
                    <div class="col-xs-offset-3 col-xs-8 ">
                      <label id="signup-response" style="display:block" class="responseLabel text-center"></label>
                      <div id="signup-spinner">

                      </div>

                    </div>
                  </div>
                  <!-- Login Button Field -->
                  <div class="form-group">
                     <div class="col-xs-offset-3 col-xs-8 col-sm-offset-3">
                       <button type="button" class="btn btn-primary btn-md btn-block submit" onclick="signUpFromForm()" disabled>Register Now</button>
                      </div>
                  </div>
            </form>
            <div style="margin-left:auto;width:143px">
              <span style="font-size:12px">
                  Already a member? <a href="" onclick="return showModal('loginModal')">Log In</a>
              </span>
            </div>
          </div>

          <!-- Foot Fields -->
          <!-- Footer container fluid ( Fluid is a container on a parent container.For this form parent=modal) -->
          <!-- footer comment
          <div class="modal-footer container-fluid">

               <div class="col-xs-offset-0 col-xs-2 col-sm-offset-0 col-sm-2">
                  <a href="#">
                    <img src="<?php print LinkUtils::generatePublicLink('img/social/facebook.png'); ?>" alt="Login via Facebook" width="40" height="35" />
                  </a>
               </div>
               <div class="col-xs-offset-0 col-xs-2 col-sm-offset-0 col-sm-2">
                  <a href="#">
                    <img src="<?php print LinkUtils::generatePublicLink('img/social/google.png'); ?>" alt="Login via Google Plus" width="40" height="35" />
                 </a>
               </div>

          </div>
        -->
       </div>
     </div>
</div>

<? endif; ?>
