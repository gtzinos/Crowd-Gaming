
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
          if($("#answer3").val().length > 0 || $("#answer4").val().length > 0 && id == 3)
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
