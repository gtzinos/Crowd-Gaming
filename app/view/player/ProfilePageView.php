<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

  <form role="form" class="form-horizontal">
    <!-- Email Field -->
    <div class="form-group has-feedback">
       <div class="col-xs-2">
          <!--   <label class="control-label" for="email">Email</label> -->
              <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
       </div>
       <div class="input-group col-xs-7" data-validate="email">
              <input class="form-control" type="email" id="signup-email" maxlength="40" placeholder="Email (Required)" required>
              <span id="email-response"></span>
       </div>
     </div>
     <!-- Password Field -->
     <div class="form-group has-feedback">
       <div class="col-xs-2">
              <!--  <label class="control-label" for="pwd">Password:</label> -->
              <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
       </div>
       <div class="input-group col-xs-7" data-validate="length" data-length="8" >
              <input type="password" class="form-control" id="signup-password" placeholder="Password (Required) *Length >= 8" required />
              <span id="password-response"></span>
       </div>
     </div>
     <!-- First Name Field -->
     <div class="form-group has-feedback">
         <div class="col-xs-2">
            <!--  <label class="control-label">Name</label> -->
            <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
         </div>
         <div class="input-group col-xs-7" data-validate="length" data-length="2" >
              <input class="form-control" type="text" id="signup-fname" maxlength="25" placeholder="First Name (Required) *Length >= 2" required />
              <span id="fname-response"></span>
         </div>
     </div>
     <!-- Last Name Field -->
     <div class="form-group has-feedback">
        <div class="col-xs-2">
          <!--  <label class="control-label">Surname</label> -->
          <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
        </div>
        <div class="input-group col-xs-7" data-validate="length" data-length="2" >
            <input class="form-control" type="text" id="signup-lname" maxlength="25" placeholder="Last Name (Required) *Length >= 2" required/>
            <span id="lname-response"></span>
        </div>
     </div>
     <!-- Gender Field -->
     <div class="form-group has-feedback">
        <div class="col-xs-2">
           <!--  <label class="control-label" for="sel1">Gender</label> -->
           <span class="text-center"><i class="fi-male-female bigicon"></i></span>
        </div>
        <div class="input-group col-xs-7" data-validate="select">
            <select class="form-control" id="signup-gender" required>
              <option selected>Gender (Required)</option>
              <option value="0">Male</option>
              <option value="1">Female</option>
            </select>
            <span id="gender-response"></span>
        </div>
     </div>
     <!-- Country Field -->
     <div class="form-group has-feedback">
        <div class="col-xs-2">
            <!--  <label class="control-label">Country</label> -->
            <span class="text-center"><i class="glyphicon glyphicon-globe bigicon"></i></span>
        </div>
        <div class="input-group col-xs-7" data-validate="length" data-length="3">
          <input class="form-control" type="text" id="signup-country" maxlength="25" placeholder="Country (Required) *Length >= 3"  required />
          <span id="country-response"></span>
        </div>
     </div>
     <!-- City Field -->
     <div class="form-group has-feedback">
        <div class="col-xs-2">
            <!-- <label class="control-label">City</label> -->
            <span class="text-center"><i class="material-icons bigicon">location_city</i></span>
        </div>
        <div class="input-group col-xs-7" data-validate="length" data-length="3">
            <input class="form-control" type="text" id="signup-city" maxlength="25" placeholder="City (Required) *Length >= 3" required/>
            <span id="city-response"></span>
        </div>
     </div>
     <!-- Address Field -->
     <div class="form-group has-feedback">
        <div class="col-xs-2">
            <!--  <label class="control-label">Address</label> -->
            <span class="text-center"><i class="glyphicon glyphicon-home bigicon"></i></span>
        </div>
        <div class="input-group col-xs-7" data-validate="length" data-length="5">
            <input class="form-control" type="text" id="signup-address" maxlength="25" placeholder="Address (Optional) *Length >= 5"/>
            <span id="address-response"></span>
        </div>
     </div>
     <!-- Phone Field -->
     <div class="form-group has-feedback">
        <div class="col-xs-2">
            <!--  <label class="control-label">Phone</label> -->
            <span class="text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
        </div>
        <div class="input-group col-xs-7" data-validate="phone">
            <input class="form-control" type="text" id="signup-phone" maxlength="15" placeholder="Phone (Optional)"/>
            <span id="phone-response"></span>
        </div>
     </div>
    <!-- Spinner Loader Field -->
    <div class="form-group">
      <div class="col-xs-2"></div>
      <div class="col-xs-7">
          <div id="signup-spinner"> </div>
          <label id="signup-response" class="responseLabel"></label>
      </div>
    </div>
    <!-- Spinner Loader Field -->
    <div class="form-group">
      <div class="col-xs-2"></div>
      <div class="col-xs-7">
          <button type="button" class="btn btn-primary btn-md round submit" onclick="profileUpdate()" disabled>Save Profile</button>
          <button type="button" class="btn btn-primary btn-md round" data-dismiss="modal" onclick="deleteAccount()">Delete Account</button>
      </div>
    </div>

  </form>

<?php endif; ?>
