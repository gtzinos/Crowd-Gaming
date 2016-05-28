<?php if($section == "CSS") : ?>

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

          <div class="container-fluid">
                  <form class="form-horizontal" id="contact-form" method="POST" action="./contact">
                         <legend class="text-center header">Contact us</legend>
                         <!-- First Name Field -->
                         <div class="form-group has-feedback">
                             <div class="hidden-xs col-xs-1 col-sm-offset-2">
                               <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                             </div>
                             <div class="col-xs-12 col-sm-7 gt-input-group" data-validate="length" data-length="2">
                                <input data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" class="form-control" id="contact-fname" name="name" type="text" maxlength="25" placeholder="First Name (Required)" required >
                                <span class="gt-icon"></span>
                             </div>
                         </div>
                         <!-- Last Name Field -->
                         <div class="form-group has-feedback">
                             <div class="hidden-xs col-xs-1 col-sm-offset-2">
                               <span class="text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                             </div>
                             <div class="col-xs-12 col-sm-7 gt-input-group" data-validate="length" data-length="2">
                               <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" name="surname" id="contact-lname" type="text" maxlength="25" placeholder="Last Name (Required) *Length >= 2" required >
                               <span class="gt-icon"></span>
                             </div>
                         </div>
                         <!-- Email Field -->
                         <div class="form-group has-feedback">
                             <div class="hidden-xs col-xs-1 col-sm-offset-2">
                                    <span class="text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
                             </div>
                             <div class="col-xs-12 col-sm-7 gt-input-group" data-validate="email">
                               <input class="form-control" data-toggle="tooltip" gt-error-message="Not a valid email address" name="email" id="contact-email" type="email" maxlength="40" placeholder="Email Address (Required)" required>
                               <span class="gt-icon"></span>
                             </div>
                         </div>
                         <!-- Phone Field -->
                         <div class="form-group has-feedback">
                             <div class="hidden-xs col-xs-1 col-sm-offset-2">
                               <span class="text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
                             </div>
                             <div class="col-xs-12 col-sm-7 gt-input-group" data-validate="phone">
                               <input id="contact-phone" data-toggle="tooltip" gt-error-message="Must contain 10 numbers" name="phone" type="text" maxlength="15" placeholder="Phone (Optional)" class="form-control">
                               <span class="gt-icon"></span>
                             </div>
                         </div>
                        <!-- Message Text Field -->
                        <div class="form-group has-feedback">
                            <div class="hidden-xs col-xs-1 col-sm-offset-2">
                                <span class="text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                            </div>
                            <div class="col-xs-12 col-sm-7 gt-input-group" data-validate="length" data-length="20">
                                <textarea style="height:120px" class="form-control" maxlength="250" data-toggle="tooltip" gt-error-message="Must contain at least 20 characters" id="contact-message" name="message" placeholder="Enter your message for us here. We will get back to you within 2 business days. (Required) *Length >= 20" required></textarea>
                                <span class="gt-icon"></span>
                            </div>
                        </div>
                        <!-- Submit Button Field -->
                        <div class="form-group has-feedback">
                            <div class="col-xs-6 col-sm-offset-3 gt-input-group">
                                <button id="submit" form="contact-form" type="submit" class="btn btn-primary btn-lg gt-submit" disabled>Send Message</button>
                            </div>
                        </div>
                        <!-- Response Label Field -->
                        <div class="form-group">
                          <div class="col-xs-offset-0 col-xs-9 col-sm-offset-3 col-sm-6">
                            <?php

                                if(exists("response-code")){
                                /*
                                  Initialize response message
                                */
                                $response_message="<label class='alert alert-danger'>";
                                  /*
                                    If response-code = 0
                                    Everything is okay
                                  */

                                  if(get("response-code") == 0)
                                  {
                                    $response_message = "<label class='alert alert-success'>Your message was sent successfully. We will reply soon.";
                                  }
                                  /*
                                    Else If response-code = 1
                                    then problem with email validation
                                  */
                                  else if(get("response-code") == 1)
                                  {
                                    $response_message .= "This is not a valid email address.";
                                  }
                                  /*
                                    Else If response-code = 2
                                    then problem with Name validation
                                  */
                                  else if(get("response-code") == 2)
                                  {
                                    $response_message .= "This is not a valid name.";
                                  }
                                  /*
                                    Else If response-code = 3
                                    then problem with Surname validation
                                  */
                                  else if(get("response-code") == 3)
                                  {
                                    $response_message .= "This is not a valid surname.";
                                  }
                                  /*
                                    Else If response-code = 4
                                    then problem with Message validation
                                  */
                                  else if(get("response-code") == 4)
                                  {
                                    $response_message .= "This is not a valid message text.";
                                  }
                                  /*
                                    Else If response-code = 5
                                    then problem with Phone validation
                                  */
                                  else if(get("response-code") == 5)
                                  {
                                    $response_message .= "This is not a valid phone number.";
                                  }
                                  /*
                                    Else If response-code = 6
                                    then problem with Name validation
                                  */
                                  else if(get("response-code") == 6)
                                  {
                                    $response_message .= "We are under maintenance. Please try later!";
                                  }
                                  /*
                                    Else one new error occur
                                  */
                                  else {
                                      $response_message .= "Something going wrong. Please contact with one administrator!";
                                  }

                                  if($response_message != "")
                                  {
                                    echo $response_message;
                                    echo "</label>";
                                  }
                                }
                            ?>

                          </div>
                        </div>
                  </form>
          </div>

<?php endif; ?>
