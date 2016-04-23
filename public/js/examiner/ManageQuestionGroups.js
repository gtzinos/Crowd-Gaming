
$(document).ready(function(e) {
    /*
      When he will add an anwser
    */
    $("input[id=answer3],input[id=answer4]").on("keyup change",function(e) {
      if(e.target.value.length > 0)
      {
        /*
          Calculate id
        */
        var id = e.target.id.replace("answer","");
        /*
          if id == 3
        */
        /*
          Enable checkbox
        */
        $("#checkbox"+id).prop("checked",true);
        if(id == 4)
        {
          $("#checkbox3").prop("checked",true);
        }
      }


    });

    /*
      When he will write an anwser
    */
    $("input[id=edit-answer3],input[id=edit-answer4]").on("keyup change",function(e) {
      if(e.target.value.length > 0)
      {
        /*
          Calculate id
        */
        var id = e.target.id.replace("edit-answer","");
        /*
          if id == 3
        */
        /*
          Enable checkbox
        */
        $("#edit-checkbox"+id).prop("checked",true);
        if(id == 4)
        {
          $("#edit-checkbox3").prop("checked",true);
        }
      }


    });

    /*
      On change check state
    */
    $("input[type=checkbox]").change(function(e) {
        /*
          Calculate the id
        */
        var id = e.target.id.replace('checkbox','');
        /*
          If he choosed to uncheck
        */
        if(!e.target.checked)
        {
          if(($("#answer3").val().length > 0 || $("#answer4").val().length > 0) && id == 3)
          {
            $("#checkbox3").prop("checked",true);
            alert("Delete answer 3 and 4 text first !!!");
            return false;
          }
          else if($("#answer4").val().length > 0 && id == 4)
          {
            $("#checkbox4").prop("checked",true);
            alert("Delete answer 4 text first !!!");
            return false;
          }
          else
          {
            $("#correct").val("-");
            $("#correct option[value=" + id + "]").attr("disabled",true);
            if(id == 3)
            {
              $("#checkbox4").prop('checked',false);
              $("#correct option[value=4]").attr("disabled",true);
            }
          }
        }
        /*
          If he choosed to check
        */
        else {
            $("#correct option[value=" + id + "]").attr("disabled",false);
            if(id == 4)
            {
              $("#checkbox3").prop("checked",true);
              $("#correct option[value=3]").attr("disabled",false);
            }
        }
    });


    /*
      On change check state
    */
    $("input[type=checkbox]").change(function(e) {
        /*
          Calculate the id
        */
        var id = e.target.id.replace('edit-checkbox','');
        /*
          If he choosed to uncheck
        */
        if(!e.target.checked)
        {
          if(($("#edit-answer3").val().length > 0 || $("#edit-answer4").val().length > 0) && id == 3)
          {
            $("#edit-checkbox3").prop("checked",true);
            alert("Delete answer 3 and 4 text first !!!");
            return false;
          }
          else if($("#edit-answer4").val().length > 0 && id == 4)
          {
            $("#edit-checkbox4").prop("checked",true);
            alert("Delete answer 4 text first !!!");
            return false;
          }
          else
          {
            $("#edit-correct").val("-");
            $("#edit-correct option[value=" + id + "]").attr("disabled",true);
            if(id == 3)
            {
              $("#edit-checkbox4").prop('checked',false);
              $("#edit-correct option[value=4]").attr("disabled",true);
            }
          }
        }
        /*
          If he choosed to check
        */
        else {
            $("#edit-correct option[value=" + id + "]").attr("disabled",false);
            if(id == 4)
            {
              $("#edit-checkbox3").prop("checked",true);
              $("#edit-correct option[value=3]").attr("disabled",false);
            }
        }
    });


});


/*
  Question group list Variables
*/
var question_group_offset = 0, //offset
    question_group_count = 10; // number of question groups
/*
  Question group list
*/
function show_question_groups()
{
  var Required = {
      Url() { return webRoot + "get-question-groups/" + questionnaire_id + "/" + question_group_offset + "/" + question_group_count; },
      SendType() { return "POST"; },
      variables : "",
      Parameters() {
        return this.variables;
      }
    }

    var Optional = {
      ResponseMethod() { return "show_question_groups_response"; }
    };

    /*
      Send ajax request
    */
    sendAjaxRequest(Required,Optional);

    /*
      Increment the offset
    */
    question_group_offset += 10;
}

/*
  Function question group list response
*/
function show_question_groups_response()
{
  /*
		if Server responsed successfully
	*/
	if (xmlHttp.readyState == 4) {
		if (xmlHttp.status == 200) {

  			/*
  				Display data
          (
            an empty set of question groups
            returns me 4 characters..
          )
        */
        if(xmlHttp.responseText.length > 4)
        {
          $("#question-group-list").append(xmlHttp.responseText);
        }
		}
  }
}
/*
  Initialize first 10 question groups
*/
show_question_groups();

/*
  Show questions
*/
function show_questions(question_group_id)
{
  var Required = {
      Url() { return webRoot + "get-questions/" + question_group_id; },
      SendType() { return "POST"; },
      variables : "",
      Parameters() {
        return this.variables;
      }
    }

    var Optional = {
      ResponseMethod() { return "show_questions_response(" + question_group_id + ")"; }
    };

    /*
      Send ajax request
    */
    sendAjaxRequest(Required,Optional);
}

/*
  Open question dialog
*/
function openQuestionDialog(question_group_id)
{
  $("#create-question").modal("show");
  $("#create-question-confirm-butto").attr("onclick","create_question(" + question_group_id + ")");
}

/*
  Show questions response
*/
function show_questions_response(question_group_id)
{
  /*
		if Server responsed successfully
	*/
	if (xmlHttp.readyState == 4) {
		if (xmlHttp.status == 200) {
      /*
        Parse json object
      */
      var questions = JSON.parse(xmlHttp.responseText);
      /*
        Initialize
      */
      var i=0,
          out="";

      for(i = 0; i < questions.questions.length; i++) {
        out += "<div class='list-group-item col-xs-12' id='qitem" + questions.questions[i].id + "'>" +
                      "<span class='col-xs-9 col-sm-10' id='question" + questions.questions[i].id + "'>"
                          + questions.questions[i].question_text +
                      "</span>" +
                      "<span onclick=\"$('#edit-question').modal('show'); show_edit_question_data('" + questions.questions[i].id + "','" + questions.questions[i].question_text + "','" + questions.questions[i].time_to_answer + "','" + questions.questions[i].creation_date + "','" + questions.questions[i].multiplier + "');\" class='edit-question fa fa-pencil col-xs-1'></span>" +
                      "<span onclick=\"delete_question('" + question_group_id + "','" + questions.questions[i].id + "',false)\" class='remove-question glyphicon glyphicon-trash col-xs-1'></span>" +
                  "</div>";
      }

      /*
        No members
      */
      if(i == 0)
      {
        out += "<label class='alert alert-danger text-center'>There are no questions on this questionnaire group</label>";
      }
  			/*
  				Display data
        */
         $("#question-list-group").html(out);
		}
  }
}
/*
  On mouse over the edit or delete buttons
*/
$(document)
  .on("mouseover","span.edit-question,span.remove-question",function(e) {
    $(e.target).css("color","#36A0FF");
  })
  .on("mouseleave","span.edit-question,span.remove-question",function(e) {
    $(e.target).css("color","#000000");
  });



$('#edit-question').on('edit.bs.modal', function () {
    document.getElementById("edit-question-form").reset();
})
/*
  Edit question modal box
*/
function show_edit_question_data(question_id,question_text,time_to_answer,creation_date,multiplier)
{
  document.getElementById("edit-question-form").reset();
  $("#edit-question-response").html("");
  $("#edit-question-response").hide();
  $("#save-question-confirm-button").unbind("click");
  $("#save-question-confirm-button").on("click",function() {
    update_question(question_id);
  });
  /*
    Set question array values
  */
  $("#edit-qname").val(question_text);
  $("#edit-qtime").val(time_to_answer);
  $("#edit-qmultiplier").val(multiplier);

  var Required = {
      Url() { return webRoot + "get-answers/" + question_id; },
      SendType() { return "POST"; },
      variables : "",
      Parameters() {
        return this.variables;
      }
    }

    var Optional = {
      ResponseMethod() { return "show_edit_question_data_response"; }
    };

    /*
      Send ajax request
    */
    sendAjaxRequest(Required,Optional);
  }

  /*
  Show questions response
  */
  function show_edit_question_data_response()
  {
    /*
      if Server responsed successfully
    */
    if (xmlHttp.readyState == 4) {

        if (xmlHttp.status == 200) {
          /*
            Parse json object
          */
          var answers_array = JSON.parse(xmlHttp.responseText);

          //id, answer-text , is-correct , creation-date,
          var i=0;
          for(i=0; i < answers_array.answers.length; i++)
          {
            if(answers_array.answers[i].is_correct)
            {
              $("#edit-correct").val(i + 1);
            }
            $("#edit-checkbox" + (i+1)).prop("checked",true);
            $("#edit-answer" + (i+1)).val(answers_array.answers[i].answer_text);
          }
          /*
            No answers
          */
          if(i == 0)
          {
            $("#question-edit-response").show();
            $("#question-edit-response").html("<div class='alert alert-danger'>There are no answers in this question. </div>");
          }

        }
    }
}

function update_question(question_id)
{
  /*
    Initialize variables
  */

  var name = $("#edit-qname").val();
  var time = $("#edit-qtime").val();
  var multiplier = $("#edit-qmultiplier").val();
  var correct = $("#edit-correct").val();
  var answers;

  if($("#edit-answer1").val().length > 0 && $("#edit-answer2").val().length > 0)
  {
    answers = [ $("#edit-answer1").val() , $("#edit-answer2").val() ];
  }

  if(name && time && multiplier && correct && answers.length == 2)
  {
    var Required = {
        Url() { return webRoot + "edit-question"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "question-id=" + question_id + "&question-text=" +  name
          + "&time-to-answer=" + time + "&multiplier=" + multiplier + "&correct=" + correct + "&answer1=" + answers[0] +
          "&answer2=" + answers[1];

          if($("#edit-answer3").val().length > 0 && $("#edit-checkbox3").is(':checked'))
          {
            this.variables += "&answer3=" + $("#edit-answer3").val();
          }
          if($("#edit-answer4").val().length > 0 && $("#edit-checkbox4").is(':checked'))
          {
            this.variables += "&answer4=" + $("#edit-answer4").val();
          }

          return this.variables;
        }
      }

      var Optional = {
        ResponseMethod() { return "update_question_response('" + question_id + "','" + name + "')"; },
        SubmitButton() { return "#save-question-confirm-button"; }
      };

      /*
        Send ajax request
      */
      sendAjaxRequest(Required,Optional);
    }

  else {
    /*
      Cannot be empty
    */
    $("#edit-question-response").show();
    $("#edit-question-response").html("<div class='alert alert-danger'>Fill all fields before save. </div>");

  }

  }

  /*
  Update question response
  */
  function update_question_response(id,text)
  {
  /*
    if Server responsed back successfully
  */
  if (xmlHttp.readyState == 4) {
    if (xmlHttp.status == 200) {
      /*
        0 All ok
        1 Question does not exists
        2 You dont have permission
        3 question-text validation error
        4 time-to-answer validation error
        5 Multiplier validation error
        6 Database Error
        -1 No data
      */

      /*
        Debug
      */
      //console.log(xmlHttp.responseText);

      if(xmlHttp.responseText.localeCompare("0") == 0)
      {
          /*
            Success message
          */
          $("#edit-question-response").show();
          $("#edit-question-response").html("<div class='alert alert-success'>Question updated successfully.</div>");
          $("#question"+id).html(text);
      }

      /*
        If server responsed with an error code
      */
      else {

        /*
          Display an response message
        */
        var response_message = "";
        /*
           If response message == 1
            Question does not exists
        */
        if(xmlHttp.responseText.localeCompare("1") == 0)
        {
         response_message += "<div class='alert alert-danger'> Question does not exists.</div>";
        }
        /*
           If response message == 2
           You dont have permission
        */
        else if(xmlHttp.responseText.localeCompare("2") == 0)
        {
         response_message += "<div class='alert alert-danger'>You dont have permission to update this question.</div>";
        }
        /*
           If response message == 3
           question-text validation error
        */
        else if(xmlHttp.responseText.localeCompare("3") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid time to question text.</div>";
        }
        /*
           If response message == 4
           time-to-answer validation error
        */
        else if(xmlHttp.responseText.localeCompare("4") == 0)
        {
         response_message += "<div class='alert alert-danger'>This not a valid time to answer. Must be >= 5 seconds.</div>";
        }
        /*
           If response message == 5
           Multiplier validation error
        */
        else if(xmlHttp.responseText.localeCompare("5") == 0)
        {
         response_message += "<div class='alert alert-danger'>This not a valid multiplier.</div>";
        }
        /*
           If response message == 6
           Database Error
        */
        else if(xmlHttp.responseText.localeCompare("6") == 0)
        {
         response_message += "<div class='alert alert-danger'>General Database Error.</div>";
        }
        /*
           If response message == -1
           No data error
        */
        else if(xmlHttp.responseText.localeCompare("-1") == 0)
        {
         response_message += "<div class='alert alert-danger'>You didnt send something.</div>";
        }
        /*
            Something going wrong
        */
        else {
          response_message += "<div class='alert alert-danger'>Unknown error. Contact with one administrator!</div>";
        }



       $("#edit-question-response").show();
       $("#edit-question-response").html(response_message);
      }
    }
  }
 }


/*
  Create a new question
*/
function create_question(question_group_id)
{
  /*
    Initialize variables
  */
  var name = $("#qname").val();
  var time = $("#qtime").val();
  var multiplier = $("#qmultiplier").val();
  var correct = $("#correct").val();
  var answers;

  if($("#answer1").val().length > 0 && $("#answer2").val().length > 0)
  {
    answers = [ $("#answer1").val() , $("#answer2").val() ];
  }

  if(name && time && multiplier && correct && answers.length == 2)
  {
    var Required = {
        Url() { return webRoot + "create-question"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "question-group-id=" + question_group_id + "&question-text=" +  name
          + "&time-to-answer=" + time + "&multiplier=" + multiplier + "&correct=" + correct + "&answer1=" + answers[0] +
          "&answer2=" + answers[1];

          if($("#answer3").val().length > 0)
          {
            this.variables += "&answer3=" + $("#answer3").val();
          }
          if($("#answer4").val().length > 0)
          {
            this.variables += "&answer4=" + $("#answer4").val();
          }

          return this.variables;
        }
      }

      var Optional = {
        ResponseMethod() { return "response_create_question(" + question_group_id + ")"; },
        ResponseLabel() { return "create-question-response"; },
        SubmitButton() { return "#create-question-confirm-button"; }
      };

      /*
				Send ajax request
			*/
			sendAjaxRequest(Required,Optional);

    }

  else {
    /*
      Cannot be empty
    */
    $("#create-question-response").show();
    $("#create-question-response").html("<div class='alert alert-danger'>Questionnaire name and description cannot be empty. </div>");

  }

}

/*
  create question response
*/
function response_create_question(question_group_id)
{

  /*
		if Server responsed back successfully
	*/
	if (xmlHttp.readyState == 4) {
		if (xmlHttp.status == 200) {
      /*
        0 All ok
        1 Invalid Access
        2 question-text validation error
        3 time-to-answer validation error
        4 Multiplier validation error
        5 Database Error
        6 Answer Text validation error
        7 Correct answer error
        -1 No data
      */

			/*
				Debug
			*/
			//console.log(xmlHttp.responseText);

      if(xmlHttp.responseText.localeCompare("0") == 0)
			{
    			/*
    				Success message
          */
          $("#create-question-response").show();
          $("#create-question-response").html("<div class='alert alert-success'>Your question created successfully.</div>");

          $("#qcounter"+question_group_id).html(parseInt($("#qcounter"+question_group_id).text()) + 1);

          $("#qname").val("");
          $("#qname").focus();

          $("#qtime").val("");
          $("#qtime").focus();

          $("#qmultiplier").val("");
          $("#qmultiplier").focus();

          $("#correct").val("-");
          $("#correct").focus();

          $("#answer1").val("");
          $("#answer1").focus();

          $("#answer2").val("");
          $("#answer2").focus();

          $("#answer3").val("");
          $("#answer3").focus();

          $("#answer4").val("");
          $("#answer4").focus();
      }

      /*
        If server responsed with an error code
      */
      else {
        /*
          Display an response message
        */
        var response_message = "";
        /*
           If response message == 1
           Invalid Access
        */
        if(xmlHttp.responseText.localeCompare("1") == 0)
        {
         response_message += "<div class='alert alert-danger'>You dont have access to do it.</div>";
        }
        /*
           If response message == 2
           question-text validation error
        */
        else if(xmlHttp.responseText.localeCompare("2") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid question name.</div>";
        }
        /*
           If response message == 3
           time-to-answer validation error
        */
        else if(xmlHttp.responseText.localeCompare("3") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid time to answer value.</div>";
        }
        /*
           If response message == 4
           Multiplier validation error
        */
        else if(xmlHttp.responseText.localeCompare("4") == 0)
        {
         response_message += "<div class='alert alert-danger'>This not a valid multiplier.</div>";
        }
        /*
           If response message == 5
           Database Error
        */
        else if(xmlHttp.responseText.localeCompare("5") == 0)
        {
         response_message += "<div class='alert alert-danger'>General database error.</div>";
        }
        /*
           If response message == 6
           6 Answer Text validation error
        */
        else if(xmlHttp.responseText.localeCompare("6") == 0)
        {
         response_message += "<div class='alert alert-danger'>Answers didnt valid.</div>";
        }
        /*
           If response message == 7
           7 Correct answer error
        */
        else if(xmlHttp.responseText.localeCompare("7") == 0)
        {
         response_message += "<div class='alert alert-danger'>This is not a valid correct answer.</div>";
        }
        /*
           If response message == -1
           No data error
        */
        else if(xmlHttp.responseText.localeCompare("-1") == 0)
        {
         response_message += "<div class='alert alert-danger'>No data error.</div>";
        }
        /*
            Something going wrong
        */
        else {
          response_message += "<div class='alert alert-danger'>Unknown error. Contact with one administrator!</div>";
        }

       $("#create-question-response").show();
       $("#create-question-response").html(response_message);
      }
    }
  }
}

/*
  Ask to delete a specific question
*/
function delete_question(question_group_id,question_id,ask_required)
{
  if(ask_required == false)
  {
    display_confirm_dialog("Confirm","Are you sure to delete it ?","btn-default","btn-default","black","delete_question(" + question_group_id + "," + question_id + ",true)","");
  }
  else {
    var Required = {
        Url() { return webRoot + "delete-question"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "question-id=" + question_id;
          return this.variables;
        }
      }

      var Optional = {
        ResponseMethod() { return "delete_question_response(" + question_group_id + "," + question_id + ")"; }
      };

      /*
        Send ajax request
      */
      sendAjaxRequest(Required,Optional);
  }
}

/*
  Delete question (Server response)
*/
function delete_question_response(question_group_id,question_id)
{
  /*
    if Server responsed back successfully
  */
  if (xmlHttp.readyState == 4) {
    if (xmlHttp.status == 200) {
      /*
        0 All ok
        1 Authentication failed
        2 Access error
        3 Database error
        -1 No Data
      */

      /*
        Debug
      */
      //console.log(xmlHttp.responseText);

      if(xmlHttp.responseText.localeCompare("0") == 0)
      {
          /*
            Success message
          */
          $("#edit-question-response").show();
          $("#edit-question-response").html("<div class='alert alert-success'>Question deleted successfully.</div>");
          if (parseInt($("#qcounter"+question_group_id).text()) == 1) {
            $("#question-list-group").html("<label class='alert alert-danger text-center'>There are no questions on this questionnaire group</label>");
          }
          $("#qitem"+question_id).remove();
          $("#qcounter"+question_group_id).html(parseInt($("#qcounter"+question_group_id).text()) - 1);
          show_notification("success","Question " + question_id + " deleted successfully.",4000);
      }

      /*
        If server responsed with an error code
      */
      else {

        /*
          Display an response message
        */
        var response_message = "";
        /*
           If response message == 1
            Authentication failed
        */
        if(xmlHttp.responseText.localeCompare("1") == 0)
        {
         response_message += "<div class='alert alert-danger'>Authentication failed.</div>";
        }
        /*
           If response message == 2
           Access error
        */
        else if(xmlHttp.responseText.localeCompare("2") == 0)
        {
         response_message += "<div class='alert alert-danger'>You dont have permission to delete this question.</div>";
        }
        /*
           If response message == 3
           Database error
        */
        else if(xmlHttp.responseText.localeCompare("3") == 0)
        {
         response_message += "<div class='alert alert-danger'>General database error.</div>";
        }
        /*
           If response message == -1
           No data error
        */
        else if(xmlHttp.responseText.localeCompare("-1") == 0)
        {
         response_message += "<div class='alert alert-danger'>You didnt send something.</div>";
        }
        /*
            Something going wrong
        */
        else {
          response_message += "<div class='alert alert-danger'>Unknown error. Contact with one administrator!</div>";
        }

        show_notification("error",response_message,5000);
      }
    }
  }
}

/*
  edit question group
*/
function edit_question_group()
{

}
/*
  response edit question group
*/
function response_edit_question_group()
{

}

/*
  Ask to delete question group
*/
function delete_question_group(question_group_id,ask_required)
{
  if(ask_required == false)
  {
    display_confirm_dialog("Confirm","Are you sure to delete it ?","btn-default","btn-default","black","delete_question_group(" + question_group_id + ",true)","");
  }
  else {
    var Required = {
        Url() { return webRoot + "delete-question-group"; },
        SendType() { return "POST"; },
        variables : "",
        Parameters() {
          /*
            Variables we will send
          */
          this.variables = "question-group-id=" + question_group_id;
          return this.variables;
        }
      }

      var Optional = {
        ResponseMethod() { return "delete_question_group_response(" + question_group_id + ")"; }
      };

      /*
        Send ajax request
      */
      sendAjaxRequest(Required,Optional);
  }
}

/*
  Delete question group (Server response)
*/
function delete_question_group_response(question_group_id)
{
  /*
    if Server responsed back successfully
  */
  if (xmlHttp.readyState == 4) {
    if (xmlHttp.status == 200) {
      /*
        0 All ok
        1 Authentication failed
        2 Access error
        3 Database error
        -1 No Data
      */
      /*
        Debug
      */
      //console.log(xmlHttp.responseText);

      if(xmlHttp.responseText.localeCompare("0") == 0)
      {
          /*
            Success message
          */
          $("#qgitem"+question_group_id).remove();
          show_notification("success","Question group " + question_group_id + " deleted successfully.",5000);
      }

      /*
        If server responsed with an error code
      */
      else {

        /*
          Display an response message
        */
        var response_message = "";
        /*
           If response message == 1
            Authentication failed
        */
        if(xmlHttp.responseText.localeCompare("1") == 0)
        {
         response_message += "<div class='alert alert-danger'>Authentication failed.</div>";
        }
        /*
           If response message == 2
           Access error
        */
        else if(xmlHttp.responseText.localeCompare("2") == 0)
        {
         response_message += "<div class='alert alert-danger'>You dont have permission to delete this question group.</div>";
        }
        /*
           If response message == 3
           Database error
        */
        else if(xmlHttp.responseText.localeCompare("3") == 0)
        {
         response_message += "<div class='alert alert-danger'>General database error.</div>";
        }
        /*
           If response message == -1
           No data error
        */
        else if(xmlHttp.responseText.localeCompare("-1") == 0)
        {
         response_message += "<div class='alert alert-danger'>You didn't send the required data.</div>";
        }
        /*
            Something going wrong
        */
        else {
          response_message += "<div class='alert alert-danger'>Unknown error. Contact with one administrator!</div>";
        }

        show_notification("error",response_message,6000);
      }
    }
  }
}


var iScrollPos = 0,
    processing = false;
$(window).scroll(function () {

    var iCurScrollPos = $(this).scrollTop();

    if (iCurScrollPos > iScrollPos) {

      if (processing)
      {
        return false;
      }
      if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.8){
          processing = true; //sets a processing AJAX request flag
          show_question_groups();
      }
      processing = false;
    }
    iScrollPos = iCurScrollPos;
  });
