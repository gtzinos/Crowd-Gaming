var selected_days_id = [];

function initialize()
{
  /*
    Create a datepicker
  */
  var daterangerpicker = create_daterangerpicker("#datepicker",{minDate : moment(),"autoUpdateInput": false});
  $('#datepicker').on('apply.daterangepicker', function(ev, picker) {
    $('#datepicker').val(picker.startDate.format('YYYY-MM-DD'));
    $('#datepicker').val($('#datepicker').val() + " - " + picker.endDate.format('YYYY-MM-DD'));
  });
}

$(window).on('load',function() {

  initialize();
  $('#multiple-day-dropdown').on('changed.bs.select', function (e,clickedIndex, newValue, oldValue) {
    //NEVER REMOVE THIS LINE
    clickedIndex++;
    //if($('#multiple-day-dropdown').val() == null) { return }
    if(String($('#multiple-day-dropdown').val()).indexOf(",") >= 0)
    {
      selected_days_id = String($('#multiple-day-dropdown').val()).split(",");
    }
    else {
      selected_days_id[0] = String($('#multiple-day-dropdown').val());
    }

    if(newValue)
    {
      addSchedulePlan(clickedIndex);
    }
    else if(oldValue)
    {
      removeSchedulePlan("#plan"+ clickedIndex);
    }
    else {
        //select all deselect all
        if(selected_days_id.length == 0)
        {
          removeSchedulePlan("[id^=plan]");
        }
    }
  });
  //$("#questionnaire-settings").on("shown.bs.modal",function() {
     getSchedulePlans();
  //});
});

function getSchedulePlans()
{
  $.post(webRoot + "get-questionnaire-schedule",
  {
    'questionnaire-id' : questionnaire_id
  },
  function(data,status)
  {
    if(status == "success")
    {
      if(data.schedule.length > 0)
      {
        var i = 0;

        var selected_days = [],counter = 0;
        for(i = 0;i<data.schedule.length;i++)
        {
          if(data.schedule[i].day != 0) {
              selected_days[counter] = data.schedule[i].day;
              counter++;
          }
        }
        for(i = 0;i<data.schedule.length;i++)
        {
          (function(i)
          {
            if(data.schedule[i].day != 0) {
              $("#multiple-day-dropdown").trigger("changed.bs.select",[ data.schedule[i].day - 1, true, false]);

              if(data.schedule[i]['start-time'] != null)
              {
                var hours = 0,minutes = 0;
                if(data.schedule[i]['start-time'] >= 60)
                {
                  hours = parseInt(data.schedule[i]['start-time'] / 60);
                }
                minutes = parseInt(data.schedule[i]['start-time'] - (hours*60));

                //Convert to time
                hours = (hours < 9 ? "0" : "") + hours;
                minutes = (minutes < 9 ? "0" : "") + minutes;

                $("#multiple-day-dropdown").promise().done(function() {
                  $("#start_time_timer" + data.schedule[i].day).val(hours + ":" + minutes);
                });
              }

              if(data.schedule[i]['end-time'] != null)
              {
                var hours = 0,minutes = 0;
                if(data.schedule[i]['end-time'] > 60)
                {
                  hours = parseInt(data.schedule[i]['end-time'] / 60);
                }
                minutes = parseInt(data.schedule[i]['end-time'] - (hours*60));

                //convert to time
                hours = (hours < 9 ? "0" : "") + hours;
                minutes = (minutes < 9 ? "0" : "") + minutes;
                $("#multiple-day-dropdown").promise().done(function() {
                  $("#stop_time_timer" + data.schedule[i].day).val(hours + ":" + minutes);
                });
              }
            }
            //set start - stop date
            if(data.schedule[i]['start-date'] != null && data.schedule[i]['end-date'] != null)
            {
              //set value on textbox
              $("#datepicker").val(data.schedule[i]['start-date'] + " - " + data.schedule[i]['end-date']);
              //initialize date picker
              $('#datepicker').data('daterangepicker').setStartDate(data.schedule[i]['start-date']);
              $('#datepicker').data('daterangepicker').setEndDate(data.schedule[i]['end-date']);
            }
          })(i);
        }
        $("#multiple-day-dropdown").selectpicker("val",selected_days);
      }
    }
  });
}

function addSchedulePlan(index)
{
  var out = "<div class='form-group' id='plan" + index + "'>" +
            "<div class='col-xs-3 col-sm-offset-1 col-sm-2'>" +
              "<label class='control-label' for='start_time_timer" + index + "'>" + $("#multiple-day-dropdown option[value=" + index + "]").text() + "</label>" +
            "</div>" +
            "<div class='col-xs-4 col-sm-3'>" +
              "<div class='left-inner-addon '>" +
                "<i class='fa fa-hourglass-start'></i>" +
                "<input type='text' id='start_time_timer" + index + "' class='form-control timer' placeholder='Start time'/>" +
              "</div>" +
            "</div>" +
            "<div class='col-xs-4 col-sm-3'>" +
              "<div class='left-inner-addon'>" +
                  "<i class='fa fa-hourglass-end'></i>" +
                  "<input type='text' id='stop_time_timer" + index + "' class='form-control timer' placeholder='Stop time'/>" +
              "</div>" +
            "</div>" +
        "</div>";

  if(selected_days_id.length == 1)
  {
    $("#schedule-plan").append(out);
  }
  else
  {
    var i = selected_days_id.length - 1;
    for(i; i >=  0; i--){
      if(selected_days_id[i] < index)
      {
        $("#plan" + selected_days_id[i]).after(out);
        initialize_clock_picker($(".timer"),default_options);
        return;
      }
    }
    $("#plan" + selected_days_id[1]).before(out);
  }
  initialize_clock_picker($(".timer"),default_options);
}

function removeSchedulePlan(selector)
{
  $(selector).remove();
}

function updateSchedulePlan()
{
  if(notCompletedRequest == true)
  {
      return;
  }
  notCompletedRequest = true;
  show_spinner("update-schedule-spinner");
  $("#update-schedule-submit-button").prop("disabled",true);

  let data = {
    'start-date' : $("#datepicker").val().length == 23 ? $("#datepicker").val().split(" ")[0] : null,
    'end-date' : $("#datepicker").val().length == 23 ? $("#datepicker").val().split(" ")[2] : null
  };

  let days = {};
  if(String($('#multiple-day-dropdown').val()).indexOf(",") >= 0)
  {
    $.each(String($('#multiple-day-dropdown').val()).split(","),function(){
      days["" + this + ""] = {
        'start-time' : $("#start_time_timer" + this).val().length == 5 ? convertToDecimal($("#start_time_timer" + this).val()) : 0,
        'end-time' : $("#stop_time_timer" + this).val().length == 5 ? convertToDecimal($("#stop_time_timer" + this).val()) : 1440
      };
    });
  }
  else if($('#multiple-day-dropdown').val() != null){
    days[$('#multiple-day-dropdown').val()] = {
      'start-time' : $("#start_time_timer" + $('#multiple-day-dropdown').val()).val().length == 5 ? convertToDecimal($("#start_time_timer" + $('#multiple-day-dropdown').val()).val()) : 0,
      'end-time' : $("#stop_time_timer" + $('#multiple-day-dropdown').val()).val().length == 5 ? convertToDecimal($("#stop_time_timer" + $('#multiple-day-dropdown').val()).val()) : 1440
    };
  }

  data['days'] = days;
  $.ajax(
    {
      method: "POST",
      url: webRoot + "update-questionnaire-schedule",
      data:
      {
        'questionnaire-id' : questionnaire_id,
        'data' : JSON.stringify(data)
      }
    })
    .done(function(data) {
        /*
          0 : all ok
          1 : Invalid Access
          2 : Data Validation error
          3 : Database Error
          -1: No data
        */
        if(data == "0")
        {
          show_notification("success","Questionnaire schedule updated successfully.",5000);
          setTimeout(function() {
            location.reload();
          },2000);
        }
        else
        {
          if(data == "1")
          {
            show_notification("error","Invalid access.",4000);
          }
          else if(data == "2")
          {
            show_notification("error","Data validation error.",4000);
          }
          else if(data == "3")
          {
            show_notification("error","General Database error.",4000);
          }
          else if(data == "-1")
          {
            show_notification("error","You didn't send data.",4000);
          }
          else {
            show_notification("error","Unknown error. Please contact with us.",4000);
          }
          notCompletedRequest = false;
          remove_spinner("update-schedule-spinner");
          $("#update-schedule-submit-button").prop("disabled",false);
        }
    })
    .fail(function(xhr,error) {
        displayServerResponseError(xhr,error);
        notCompletedRequest = false;
        remove_spinner("update-schedule-spinner");
        $("#update-schedule-submit-button").prop("disabled",false);
    });
}

function convertToDecimal(value)
{
  if(value.indexOf(":") < 0 && value.length != 5)
  {
    return 0;
  }

  var hours = parseInt(value.split(":")[0]) * 60,
      minutes = parseInt(value.split(":")[1]);

  return minutes + hours;
}
