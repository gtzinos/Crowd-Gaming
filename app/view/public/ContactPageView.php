<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/ContactPageStyle.css"); ?>">

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

          <div class="container-fluid">
                  <form class="form-horizontal">
                         <legend class="text-center header">Contact us</legend>
                         <!-- First Name Field -->
                         <div class="form-group has-feedback">
                             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                               <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                             </div>
                             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="2">
                                <input class="form-control" id="contact-fname" name="fname" type="text" maxlength="25" placeholder="First Name (Required) *Length >= 2" required >
                                <span></span>
                             </div>
                         </div>
                         <!-- Last Name Field -->
                         <div class="form-group has-feedback">
                             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                               <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                             </div>
                             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="2">
                               <input class="form-control" id="contact-lname" type="text" maxlength="25" placeholder="Last Name (Required) *Length >= 2" required >
                               <span></span>
                             </div>
                         </div>
                         <!-- Email Field -->
                         <div class="form-group has-feedback">
                             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                                    <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
                             </div>
                             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="email">
                               <input class="form-control" id="contact-email" type="email" maxlength="40" placeholder="Email Address (Required)" required>
                               <span></span>
                             </div>
                         </div>
                         <!-- Phone Field -->
                         <div class="form-group has-feedback">
                             <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                               <span class="text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
                             </div>
                             <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="phone">
                               <input id="contact-phone" name="phone" type="text" maxlength="15" placeholder="Phone (Optional)" class="form-control">
                               <span></span>
                             </div>
                         </div>
                        <!-- Message Text Field -->
                        <div class="form-group has-feedback">
                            <div class="col-xs-offset-0 col-xs-2 col-md-offset-1 col-md-2">
                                <span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                            </div>
                            <div class="col-xs-offset-1 col-xs-9 col-md-offset-0 col-md-6 gt-input-group" data-validate="length" data-length="20">
                                <textarea class="form-control" maxlength="250" id="contact-message" name="message" placeholder="Enter your message for us here. We will get back to you within 2 business days. (Required) *Length >= 20" required></textarea>
                                <span></span>
                            </div>
                        </div>
                        <!-- Submit Button Field -->
                        <div class="form-group has-feedback">
                            <div class="col-xs-offset-3 col-xs-6 col-md-offset-3 col-md-6 gt-input-group">
                                <button id="submit" type="submit" class="btn btn-primary btn-lg submit" disabled>Send Message</button>
                            </div>
                        </div>
                  </form>
          </div>

<?php endif; ?>
