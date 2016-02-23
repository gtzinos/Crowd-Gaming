<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="<?php print LinkUtils::generatePublicLink("css/ContactPageStyle.css"); ?>">

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

          <div class="col-md-12">
                  <form class="form-horizontal" method="post">
                         <legend class="text-center header">Contact us</legend>

                         <!-- First Name Field -->
           							<div class="form-group has-feedback">
           								<div class="col-xs-2">
                            <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                            </div>
           								<div class="input-group col-xs-7" data-validate="length" data-length="2">
           								 	  <input class="form-control" id="contact-fname" name="fname" type="text" maxlength="25" placeholder="First Name (Required) *Length >= 2" required >
           										<span></span>
           								</div>
           							</div>
                        <!-- Last Name Field -->
                       <div class="form-group has-feedback">
                         <div class="col-xs-2">
                              <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                         </div>
                        <div class="input-group col-xs-7" data-validate="length" data-length="2">
                          <input class="form-control" id="contact-lname" name="fname" type="text" maxlength="25" placeholder="Last Name (Required) *Length >= 2" required >
                          <span></span>
                      </div>
                    </div>

                    <!-- Email Address Field -->
                   <div class="form-group has-feedback">
                      <div class="col-xs-2">
                          <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
                      </div>
                      <div class="input-group col-xs-7" data-validate="length" data-length="2">
                          <input id="contact-email" name="email" type="email" maxlength="40" placeholder="Email Address (Required)" class="form-control" required>
                      </div>
                  </div>
                  <!-- Phone Number Field -->
                 <div class="form-group has-feedback">
                      <div class="col-xs-2">
                          <span class="text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
                      </div>
                      <div class="input-group col-xs-7"  data-validate="phone">
                            <input id="contact-phone" name="phone" type="text" maxlength="15" placeholder="Phone (Optional)" class="form-control">
                      </div>
                  </div>
                  <!-- Message Text Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-2">
                          <span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                      </div>
                      <div class="input-group col-xs-7"  data-validate="length" data-length="20">
                          <textarea class="form-control" maxlength="250" id="contact-message" name="message" placeholder="Enter your message for us here. We will get back to you within 2 business days. (Required) *Length >= 20"></textarea>
                      </div>
                  </div>

                  <!-- Button Field -->
                  <div class="form-group has-feedback">
                      <div class="col-xs-2">
                          <span></span>
                      </div>
                      <div class="input-group col-xs-7">
                          <button id="submit" type="submit" class="btn btn-primary btn-lg" disabled>Send Message</button>
                      </div>
                  </div>
                  </form>
          </div>

<?php endif; ?>
