<? if($section == "CREATE_QUESTION") : ?>
<div class="modal fade" id="create-question" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="gt-modal-header"><span class="glyphicon glyphicon-lock"></span>Create Question</h4>
       </div>
       <div class="modal-body container-fluid">
          <form id="create-question-form" onsubmit="return false" class="form-horizontal">
            <!-- Question Name Field -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1 col-sm-2">
                  <span class="text-center"><i class="material-icons mediumicon">question_answer</i></i></span>
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="length" data-length="2">
                    <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 2 characters" id="qname" type="text" placeholder="Question Name" required >
                    <span class="gt-icon"></span>
                </div>
            </div>
            <!-- Time to answer Field -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1 col-sm-2">
                  <span class="text-center"><i class="fa fa-hourglass-half mediumicon"></i></span>
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="number" data-type="integer" data-min-number="5" data-max-number="180">
                    <input class="form-control" data-toggle="tooltip" gt-error-message="Only numbers ( 5 - \infty )" id="qtime" type="text" placeholder="Time to answer (sec)" required >
                    <span class="gt-icon"></span>
                </div>
            </div>
            <!-- Multiplier Field -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1">
                  <span class="text-center"><i class="glyphicon glyphicon-equalizer mediumicon"></i></i></span>
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="number" data-number-greater-than="0">
                    <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 1 number" id="qmultiplier" type="text" placeholder="Multiplier (Default 1)" required >
                    <span class="gt-icon"></span>
                </div>
            </div>
            <!-- Correct answer -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1">
                    <span><i class="fa fa-check mediumicon"></i></span>
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="select" data-length="8">
                    <select class="form-control" id="correct">
                      <option value="-" disabled selected="selected">Select the correct answer</option>
                      <option value="1">Answer 1</option>
                      <option value="2">Answer 2</option>
                      <option value="3">Answer 3</option>
                      <option value="4">Answer 4</option>
                    </select>
                </div>
              </div>
            <!-- Answer 1 Field -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1">
                  <input type="checkbox" id="checkbox1" checked="checked" disabled="disabled" />
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="length" data-length="1">
                    <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 1 character" id="answer1" type="text" placeholder="Answer 1" required >
                    <span class="gt-icon"></span>
                </div>
            </div>
            <!-- Answer 2 Field -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1">
                  <input type="checkbox" id="checkbox2" checked="checked" disabled="disabled"/>
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="length" data-length="1">
                    <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 1 character" id="answer2" type="text" placeholder="Answer 2" required >
                    <span class="gt-icon"></span>
                </div>
            </div>
            <!-- Answer 3 Field -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1">
                  <input type="checkbox" id="checkbox3" checked="checked"/>
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="length" data-length="1">
                    <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 1 character" id="answer3" type="text" placeholder="Answer 3">
                    <span class="gt-icon"></span>
                </div>
            </div>
            <!-- Answer 4 Field -->
            <div class="form-group has-feedback">
                <div class="col-xs-offset-0 col-xs-2 col-sm-offset-1">
                  <input type="checkbox" id="checkbox4" checked="checked"/>
                </div>
                <div class="col-xs-10 col-sm-8 col-md-7 gt-input-group" data-validate="length" data-length="1">
                    <input class="form-control" data-toggle="tooltip" gt-error-message="Must contain at least 1 character" id="answer4" type="text" placeholder="Answer 4">
                    <span class="gt-icon"></span>
                </div>
            </div>
            <!-- Create Question button / Cancel Button Field -->
            <div class="form-group">
               <div class="col-xs-offset-0 col-xs-4 col-sm-offset-3 col-sm-2">
                 <!-- A Script will add on click method -->
                 <button id="create-question-confirm-butto" form="create-question-form" type="button" class="btn btn-primary round gt-submit" disabled>Create</button>
               </div>
               <div class="col-xs-4 col-sm-2">
                 <button type="button" class="btn btn-primary round" data-dismiss="modal" >
                   Cancel
                 </button>
               </div>
            </div>
            <div class="form-group">
              <div class="col-xs-offset-0 col-xs-12 col-sm-offset-3 col-sm-8 col-md-7">
                <label id="create-question-response" class="responseLabel"></label>
              </div>
            </div>
          </form>
       </div>
     </div>
   </div>
 </div>

<? endif; ?>
