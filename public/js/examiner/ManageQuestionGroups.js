
$(document).ready(function(e) {
    /*
      When he will write an anwser
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
});


/*
  Question group list Variables
*/
var question_group_offset = 0, //offset
    questionnaire_id = 1, //questionnaire id
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
  				Display data
        */
         $("#question-list").append(xmlHttp.responseText);
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
          + "&time-to-answer=" + time + "&multiplier=" + multiplier + "&answer1=" + answers[0] +
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
