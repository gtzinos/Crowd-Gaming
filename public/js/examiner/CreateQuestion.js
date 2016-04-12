
$(document).ready(function(e) {
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
          $("#correct option[value=" + id + "]").attr("disabled",true);
          if(id == 3)
          {
            $("#checkbox4").prop('checked',false);
            $("#correct option[value=4]").attr("disabled",true);
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
