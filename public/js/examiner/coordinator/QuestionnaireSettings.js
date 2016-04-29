var selected_days_id = [];
$(document).ready(function() {

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
});

function addSchedulePlan(index)
{
  var out = "<div class='form-group' id='plan" + index + "'>" +
            "<div class='col-xs-2 col-sm-offset-1 col-sm-2'>" +
              "<label class='control-label' for='start_time_timer" + index + "'>" + $("#multiple-day-dropdown option[value=" + index + "]").text() + "</label>" +
            "</div>" +
            "<div class='col-xs-3 col-sm-3'>" +
              "<div class='left-inner-addon '>" +
                "<i class='fa fa-hourglass-start'></i>" +
                "<input type='text' id='start_time_timer" + index + "' class='form-control timer' placeholder='Start time'/>" +
              "</div>" +
            "</div>" +
            "<div class='col-xs-3 col-xs-offset-0 col-sm-3'>" +
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
