
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
            $("#correct").focus();
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
            $("#edit-correct").focus();
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
          if(question_group_offset != 0)
          {
            show_question_groups();
          }
      }
    }
    iScrollPos = iCurScrollPos;
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
  $.ajax(
  {
    method: "POST",
    url: webRoot + "get-question-groups/" + questionnaire_id + "/" + question_group_offset + "/" + question_group_count,
    data: { }
  })
  .done(function(data)
  {
    /*
      Display data
      (
        an empty set of question groups
        returns me 4 characters..
      )
    */
    if(data.length > 4)
    {
      $("#question-group-list").append(data);
    }
    question_group_offset += question_group_count;
  })
  .fail(function(xhr,error)
  {
    displayServerResponseError(xhr,error);
  })
  .always(function() {
    processing = false;
  });
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
  $.ajax({
    method: "POST",
    url: webRoot + "get-questions/" + question_group_id,
    data: { }
  })
  .done(function(data){
      /*
        Parse json object
      */
      var questions = data;
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
  })
  .fail(function(xhr,error){
    displayServerResponseError(xhr,error);
  });
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
  On mouse over the edit or delete buttons
*/
$(document)
  .on("mouseover","span.edit-question,span.remove-question",function(e) {
    $(e.target).css("color","#36A0FF")
               .css('cursor', 'hand');
  })
  .on("mouseleave","span.edit-question,span.remove-question",function(e) {
    $(e.target).css("color","#000000")
               .css('cursor', 'pointer');
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

    $.ajax({
      method: "POST",
      url: webRoot + "get-answers/" + question_id,
      data: { }
    })
    .done(function(data) {
      /*
        Parse json object
      */
      var answers_array = data;

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
    })
    .fail(function (xhr,error) {
        displayServerResponseError(xhr,error);
    });
}

//Get update question data
function getUpdateQuestionData(question_id)
{
  //Initialize variables
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
    let data = {
      "question-id": question_id,
      "question-text": name,
      "time-to-answer": time,
      "multiplier": multiplier,
      "correct": correct,
      "answer1": answers[0],
      "answer2": answers[1]
    };

    if($("#edit-answer3").val().length > 0 && $("#edit-checkbox3").is(':checked'))
    {
      data["answer3"] = $("#edit-answer3").val();
    }
    if($("#edit-answer4").val().length > 0 && $("#edit-checkbox4").is(':checked'))
    {
      data["answer4"] = $("#edit-answer4").val();
    }

    return data;
  }
  else {
    return null;
  }
}

//Update a question
function update_question(question_id)
{
  var dataToSend = getUpdateQuestionData(question_id);

  if(dataToSend != null)
  {
    $("#save-question-confirm-button").prop("disabled",true);
    $.ajax({
      method: "POST",
      url: webRoot + "edit-question",
      data: dataToSend
    })
    .done(function(data){
      /*
        0 All ok
        1 Question does not exists
        2 You dont have permission
        3 question-text validation error
        4 time-to-answer validation error
        5 Multiplier validation error
        6 Database Error
        7 Invalid Correct Answer
        8 You cant edit a public questionnaire
        -1 No data
      */

      if(data == "0")
      {
          /*
            Success message
          */
          show_notification("success","Question updated successfully.",4000);
          $("#question"+question_id).html(data["question-text"]);
      }
      /*
          If response message == 1
          Question does not exists
      */
      else if(data == "1")
      {
        show_notification("error","Question does not exists.",4000);
      }
      /*
         If response message == 2
         You dont have permission
      */
      else if(data == "2")
      {
        show_notification("error","You dont have permission to update this question.",4000);
      }
      /*
         If response message == 3
         question-text validation error
      */
      else if(data == "3")
      {
        show_notification("error","This is not a valid time to question text.",4000);
      }
      /*
         If response message == 4
         time-to-answer validation error
      */
      else if(data == "4")
      {
        show_notification("error","This not a valid time to answer. Must be >= 5 seconds.",4000);
      }
      /*
         If response message == 5
         Multiplier validation error
      */
      else if(data == "5")
      {
        show_notification("error","This not a valid multiplier.",4000);
      }
      /*
         If response message == 6
         Database Error
      */
      else if(data == "6")
      {
        show_notification("error","General Database Error.",4000);
      }
      /*
         If response message == 7
         Invalid Correct Answer
      */
      else if(data == "7")
      {
        show_notification("error","Invalid Correct Answer.",4000);
      }
      /*
         If response message == 8
         You can't edit a public questionnaire
      */
      else if(data == "8")
      {
        show_notification("error","You can't edit a public questionnaire.",4000);
      }
      /*
         If response message == -1
         No data error
      */
      else if(data == "-1")
      {
        show_notification("error","You didnt send something.",4000);
      }
      /*
          Something going wrong
      */
      else {
        show_notification("error","Unknown error. Contact with one administrator!",4000);
      }
    })
    .fail(function(xhr,error){
      displayServerResponseError(xhr,error);
    })
    .always(function() {
      $("#save-question-confirm-button").prop("disabled",false);
    });
  }

  else {
    /*
      Cannot be empty
    */
    show_notification("error","Fill all fields before save.",4000);
  }
}

//get create question data
function getCreateQuestionData(question_group_id)
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
    let data = {
      "question-group-id": question_group_id,
      "question-text": name,
      "time-to-answer": time,
      "multiplier": multiplier,
      "correct": correct,
      "answer1": answers[0],
      "answer2": answers[1]
    };

    if($("#answer3").val().length > 0)
    {
      data["answer3"] = $("#answer3").val();
    }
    if($("#answer4").val().length > 0)
    {
      data["answer4"] = $("#answer4").val();
    }
    return data;
  }
  else {
    return null;
  }
}

/*
  Create a new question
*/
function create_question(question_group_id)
{
  if(notCompletedRequest == true || $("#create-question-confirm-butto").prop("disabled"))
  {
    return;
  }

  var dataToSend = getCreateQuestionData(question_group_id);
  if(dataToSend != null) {
    notCompletedRequest = true;
    //$("#create-question-confirm-butto").prop("disabled",true);
    $.ajax({
      method: "POST",
      url: webRoot + "create-question",
      data: dataToSend
    })
    .done(function(data){
      /*
        0 All ok
        1 Invalid Access
        2 question-text validation error
        3 time-to-answer validation error
        4 Multiplier validation error
        5 Database Error
        6 Answer Text validation error
        7 Correct answer error
        8 Cant create a question when the questionnaire is public
        -1 No data
      */

      if(data == "0")
			{
    			/*
    				Success message
          */
          show_notification("success","Your question created successfully.",4000);

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
         If response message == 1
         Invalid Access
      */
      else if(data == "1")
      {
        show_notification("error","You dont have access to do it.",4000);
      }
      /*
         If response message == 2
         question-text validation error
      */
      else if(data == "2")
      {
        show_notification("error","This is not a valid question name.",4000);
      }
      /*
         If response message == 3
         time-to-answer validation error
      */
      else if(data == "3")
      {
        show_notification("error","This is not a valid time to answer value.",4000);
      }
      /*
         If response message == 4
         Multiplier validation error
      */
      else if(data == "4")
      {
        show_notification("error","This not a valid multiplier.",4000);
      }
      /*
         If response message == 5
         Database Error
      */
      else if(data == "5")
      {
        show_notification("error","General database error.",4000);
      }
      /*
         If response message == 6
         6 Answer Text validation error
      */
      else if(data == "6")
      {
        show_notification("error","Answers didnt valid.",4000);
      }
      /*
         If response message == 7
         7 Correct answer error
      */
      else if(data == "7")
      {
        show_notification("error","This is not a valid correct answer.",4000);
      }
      /*
         If response message == 8
         7 Correct answer error
      */
      else if(data == "8")
      {
        show_notification("error","Cant create a question when the questionnaire is public.",4000);
      }
      /*
         If response message == -1
         No data error
      */
      else if(data == "-1")
      {
        show_notification("error","No data error.",4000);
      }
      /*
          Something going wrong
      */
      else {
        show_notification("error","Unknown error. Contact with one administrator!",4000);
      }
    })
    .fail(function(xhr,error){
      displayServerResponseError(xhr,error);
    })
    .always(function() {
      $("#create-question-confirm-butto").prop("disabled",false);
      notCompletedRequest = false;
    });
  }
  else {
    show_notification("error","Please fill all fields.",4000);
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
    $.ajax({
      method: "POST",
      url: webRoot + "delete-question",
      data: { "question-id": question_id }
    })
    .done(function(data){
      /*
        0 All ok
        1 Authentication failed
        2 Access error
        3 Database error
        4 Questionnaire is public , you cant delete it.
        -1 No Data
      */

      if(data == "0")
      {
          /*
            Success message
          */
          if (parseInt($("#qcounter"+question_group_id).text()) == 1) {
            $("#question-list-group").html("<label class='alert alert-danger text-center'>There are no questions on this question group</label>");
          }
          $("#qitem"+question_id).remove();
          $("#qcounter"+question_group_id).html(parseInt($("#qcounter"+question_group_id).text()) - 1);
          show_notification("success","Question " + question_id + " deleted successfully.",4000);
      }
      /*
         If response message == 1
          Authentication failed
      */
      if(data == "1")
      {
        show_notification("error","Authentication failed.",4000);
      }
      /*
         If response message == 2
         Access error
      */
      else if(data == "2")
      {
        show_notification("error","You dont have permission to delete this question.",4000);
      }
      /*
         If response message == 3
         Database error
      */
      else if(data == "3")
      {
        show_notification("error","General database error.",4000);
      }
      /*
         If response message == 4
         Database error
      */
      else if(data == "4")
      {
        show_notification("error","Questionnaire is public , you can't delete it.",4000);
      }
      /*
         If response message == -1
         No data error
      */
      else if(data == "-1")
      {
        show_notification("error","You didnt send something.",4000);
      }
      /*
          Something going wrong
      */
      else {
        show_notification("error","Unknown error. Contact with one administrator!",4000);
      }
    })
    .fail(function(xhr,error){
      displayServerResponseError(xhr,error);
    })
  }
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
    $.ajax({
      method: "POST",
      url: webRoot + "delete-question-group",
      data: { "question-group-id": question_group_id }
    })
    .done(function(data) {
      /*
        0 All ok
        1 Authentication failed
        2 Access error
        3 Database error
        4 Questionnaire is public , you cant delete this.
        -1 No Data
      */

      if(data == "0")
      {
          /*
            Success message
          */
          $("#qgitem"+question_group_id).remove();
          if($("[id^=qgitem]").length == 0)
          {
            $("#question-group-list").html("<a class='list-group-item col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10'>" +
                        "<div class='col-xs-12'>" +
                            "<div class='alert alert-danger'>We don't have any question group in our database. </div>" +
                        "</div>" +
                        "</a>");
          }
          show_notification("success","Question group " + question_group_id + " deleted successfully.",5000);
      }
      /*
         If response message == 1
          Authentication failed
      */
      else if(data == "1")
      {
        show_notification("error","Authentication failed.",4000);
      }
      /*
         If response message == 2
         Access error
      */
      else if(data == "2")
      {
        show_notification("error","You dont have permission to delete this question group.",4000);
      }
      /*
         If response message == 3
         Database error
      */
      else if(data == "3")
      {
        show_notification("error","General database error.",4000);
      }
      /*
         If response message == 4
         Questionnaire is public, you cant delete this.
      */
      else if(data == "4")
      {
        show_notification("error","Questionnaire is public, you cant delete this.",4000);
      }
      /*
         If response message == -1
         No data error
      */
      else if(data == "-1")
      {
        show_notification("error","You didn't send the required data.",4000);
      }
      /*
          Something going wrong
      */
      else {
        show_notification("error","Unknown error. Contact with one administrator!",4000);
      }
    })
    .fail(function(xhr,error)
    {
      displayServerResponseError(xhr,error);
    })
  }
}

  //get question group users
  function get_question_group_users(question_group_id)
  {
    $.ajax({
      method: "POST",
      url: webRoot + "get-users-from-question-group",
      data: { "question-group-id": question_group_id }
    })
    .done(function(data){
      /*
        0 All ok
        1 Invalid Access
        -1 No Post Data
      */
      var users = data.users;

      var i=0,
      out = "";

      for(i = 0;i<users.length;i++)
      {
        out += "<option value='" + users[i].id + "' data-tokens='" + users[i].email + " " + users[i].gender
        + " " + users[i].country + " " + users[i].city + " " + users[i].address
       + " " + users[i].phone + "'>" + " " + users[i].name
       + " " + users[i].surname + "</option>";
      }
      $("#question-group-dropdown").html(out);
    })
    .fail(function(xhr,error){
      displayServerResponseError(xhr,error);
    })
  }
