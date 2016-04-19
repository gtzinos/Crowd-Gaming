
$(document).ready(function(e) {
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
        */
         $("#question-group-list").append(xmlHttp.responseText);
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
      ResponseMethod() { return "show_questions_response"; }
    };

    /*
      Send ajax request
    */
    sendAjaxRequest(Required,Optional);
}


/*
  Show questions response
*/
function show_questions_response()
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
        out += "<div class='col-xs-12 col-sm-12 list-group'>" +
                  "<div class='list-group-item col-xs-12'>" +
                      "<span class='col-xs-9 col-sm-10' id='question" + questions.questions[i].id + "'>"
                          + questions.questions[i].question_text +
                      "</span>" +
                      "<span onclick=\"$('#edit-question').modal('show'); show_edit_question_data('" + questions.questions[i].id + "','" + questions.questions[i].question_text + "','" + questions.questions[i].time_to_answer + "','" + questions.questions[i].creation_date + "','" + questions.questions[i].multiplier + "');\" class='edit-question fa fa-pencil col-xs-1'></span>" +
                      "<span onclick=\"delete_question('" + questions.questions[i].id + "')\" class='remove-question glyphicon glyphicon-trash col-xs-1'></span>" +
                  "</div>" +
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

          if($("#answer3").val().length > 0 && $("#checkbox3").is(':checked'))
          {
            this.variables += "&answer3=" + $("#answer3").val();
          }
          if($("#answer4").val().length > 0 && $("#checkbox4").is(':checked'))
          {
            this.variables += "&answer4=" + $("#answer4").val();
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
function create_question(id)
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
          this.variables = "question-group-id=" + id + "&question-text=" +  name
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
        ResponseMethod() { return "response_create_question"; },
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
function response_create_question()
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
  delete question group
*/
function delete_question_group()
{
  confirm("Are you sure, you want to delete this question group ? All data will delete from our system.")
}

/*
  response delete question group
*/
function response_delete_question_group()
{

}
