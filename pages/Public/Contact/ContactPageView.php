<?php if($section == "CSS") : ?>
  <link rel="stylesheet" href="pages/Public/Contact/css/ContactPageStyle.css">

<?php elseif($section == "JAVASCRIPT") : ?>

<?php elseif($section == "MAIN_CONTENT" ) : ?>

          <div class="col-md-12">
                  <form class="form-horizontal" method="post">
                    <fieldset>
                         <legend class="text-center header">Contact us</legend>
                          <div class="form-group">
                              <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                              <div class="col-md-8">
                                  <input id="fname" name="name" type="text" placeholder="First Name" class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-user bigicon"></i></span>
                              <div class="col-md-8">
                                  <input id="lname" name="name" type="text" placeholder="Last Name" class="form-control">
                              </div>
                          </div>

                          <div class="form-group">
                              <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-envelope bigicon"></i></span>
                              <div class="col-md-8">
                                  <input id="email" name="email" type="email" placeholder="Email Address" class="form-control">
                              </div>
                          </div>

                          <div class="form-group">
                              <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-earphone bigicon"></i></span>
                              <div class="col-md-8">
                                  <input id="phone" name="phone" type="text" placeholder="Phone" class="form-control">
                              </div>
                          </div>

                          <div class="form-group">
                              <span class="col-md-1 col-md-offset-2 text-center"><i class="glyphicon glyphicon-edit bigicon"></i></span>
                              <div class="col-md-8">
                                  <textarea class="form-control" id="message" name="message" placeholder="Enter your message for us here. We will get back to you within 2 business days." rows="7"></textarea>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="col-md-8 text-center">
                                  <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                              </div>
                          </div>
                      </fieldset>
                  </form>
          </div>

<?php endif; ?>
