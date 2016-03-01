<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>
<script src="<?php print LinkUtils::generatePublicLink("js/player/profileManager.js"); ?>"> </script>
<?php elseif($section == "MAIN_CONTENT" ) : ?>

  <div class="container-fluid">
    <form class="form-horizontal">
         <!-- Email Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                    <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="email">
                 <input value="<?php if(get("user")) echo get("user")->getEmail(); ?>"class="form-control" type="email" id="profile-email" maxlength="40" placeholder="Email (Required)" required>
                 <span></span>
             </div>
         </div>
         <!-- New Password Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="8">
                 <input type="password" class="form-control" id="profile-new-password" placeholder="New Password (Optional)" />
                 <span></span>
             </div>
         </div>
         <!-- Repeat Password Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="glyphicon glyphicon-lock bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="8" data-equal="profile-new-password">
                    <input type="password" class="form-control" id="profile-repeat-password" placeholder="Repeat Password (Optional)" />
                 <span></span>
             </div>
         </div>
         <!-- First Name Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="2">
                 <input value="<?php if(get("user")) echo get("user")->getName(); ?>" class="form-control" type="text" id="profile-fname" maxlength="25" placeholder="First Name (Required) *Length >= 2" required />
                 <span></span>
             </div>
         </div>
         <!-- Last Name Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="2">
               <input value="<?php if(get("user")) echo get("user")->getSurname(); ?>" class="form-control" type="text" id="profile-lname" maxlength="25" placeholder="Last Name (Required) *Length >= 2" required/>
               <span></span>
             </div>
         </div>
         <!-- Gender Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="fi-male-female bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="select">
               <select class="form-control" id="profile-gender" required>
                 <option selected>Gender (Required)</option>
               <?php
               /*
                   If user parameter exists
               */
                 if(get("user"))
                 {
                   /*
                     If gender = 0
                     then select the male
                   */
                   if(get("user")->getGender() == 0)
                   {
                     echo "<option value='0' selected>Male</option>";
                     echo "<option value='1'>Female</option>";
                   }
                   /*
                     Else gender = 1
                     then select the female
                   */
                   else
                   {
                     echo "<option value='0'>Male</option>";
                     echo "<option value='1' selected>Female</option>";
                   }
                 }
                ?>
               </select>
               <span></span>
             </div>
         </div>
         <!-- Country Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="glyphicon glyphicon-globe bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="3">
               <input value="<?php if(get("user")) echo get("user")->getCountry(); ?>" class="form-control" type="text" id="profile-country" maxlength="25" placeholder="Country (Required) *Length >= 3"  required />
               <span></span>
             </div>
         </div>
         <!-- City Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="material-icons bigicon">location_city</i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="3">
               <input value="<?php if(get("user")) echo get("user")->getCity(); ?>" class="form-control" type="text" id="profile-city" maxlength="25" placeholder="City (Required) *Length >= 3" required/>
               <span></span>
             </div>
         </div>
         <!-- Address Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="glyphicon glyphicon-home bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="5">
               <input value="<?php if(get("user")) if(get("user")->getAddress()) echo get("user")->getAddress(); ?>" class="form-control" type="text" id="profile-address" maxlength="25" placeholder="Address (Optional) *Length >= 5"/>
               <span></span>
             </div>
         </div>
         <!-- Phone Field -->
         <div class="form-group has-feedback">
             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
               <span class="text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
             </div>
             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="phone">
               <input value="<?php if(get("user")) if(get("user")->getPhone()) echo get("user")->getPhone(); ?>" class="form-control" type="text" id="profile-phone" maxlength="15" placeholder="Phone (Optional)"/>
               <span></span>
             </div>
         </div>
         <!-- Spinner and Response Label Field -->
         <div class="form-group">
           <div class="col-xs-offset-5 col-xs-4 ">
             <div id="profile-spinner">

             </div>
             <label id="profile-response" class="responseLabel"></label>
           </div>
         </div>
         <!-- Login Button Field -->
         <div class="form-group">
            <div class="col-xs-offset-0 col-xs-4 col-sm-offset-3 col-sm-2">
              <button type="button" class="btn btn-primary btn-md round submit" onclick="confirmPassword('profileUpdate')">Save Profile</button>
            </div>
            <div class="col-xs-offset-1 col-xs-5 col-sm-offset-0 col-sm-2">
              <button type="button" class="btn btn-primary btn-md round" onclick="confirmPassword('deleteAccount')">Delete Account</button>
            </div>

         </div>
   </form>
 </div>

  <?php load("CONFIRM_PASSWORD"); ?>


<?php endif; ?>
