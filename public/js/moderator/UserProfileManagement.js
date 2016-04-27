function update_user(id,confirmed)
{

}

function ban_user(user_id,confirmed)
{
  /*
    Response Codes
     0 : All ok
     1 : User doesnt Exist
     2 : Database Error
    -1 : No data
  */
  $.post(webRoot + "ban-user",
  {
    "user-id" : user_id,
    "action-type" : "1"
  },
  function(data,status){
    if(status == "success")
    {
      if(data == "0")
      {
        show_notification("success","User banned successfully.",3000);
        setTimeout(function() {
          location.reload();
        },4000);
      }
      else if(data == "1")
      {
        show_notification("error","User doesnt exists.",5000);
      }
      else if(data == "2")
      {
        show_notification("error","General database error.",5000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send data.",5000);
      }
      else {
        show_notification("error","Unknown error. Please contact with us!",5000);
      }
    }
  });
}

function unban_user(user_id,confirmed)
{
  /*
    Response Codes
     0 : All ok
     1 : User doesnt Exist
     2 : Database Error
    -1 : No data
  */
  $.post(webRoot + "ban-user",
  {
    "user-id" : user_id,
    "action-type" : "2"
  },
  function(data,status){
    if(status == "success")
    {
      if(data == "0")
      {
        show_notification("success","User unbanned successfully.",3000);
        setTimeout(function() {
          location.reload();
        },4000);
      }
      else if(data == "1")
      {
        show_notification("error","User doesnt exists.",5000);
      }
      else if(data == "2")
      {
        show_notification("error","General database error.",5000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send data.",5000);
      }
      else {
        show_notification("error","Unknown error. Please contact with us!",5000);
      }
    }
  });
}

function delete_user(user_id,confirmed)
{
  /*
    Response Codes
     0 : All ok
     1 : User doesnt Exist
     2 : Database Error
    -1 : No data
  */
  $.post(webRoot + "delete-user",
  {
    "user-id" : user_id
  },
  function(data,status){
    if(status == "success")
    {
      if(data == "0")
      {
        show_notification("success","User deleted successfully.",3000);
        setTimeout(function() {
          location.reload();
        },4000);
      }
      else if(data == "1")
      {
        show_notification("error","User doesnt exists.",5000);
      }
      else if(data == "2")
      {
        show_notification("error","General database error.",5000);
      }
      else if(data == "-1")
      {
        show_notification("error","You didnt send data.",5000);
      }
      else {
        show_notification("error","Unknown error. Please contact with us!",5000);
      }
    }
  });
}

function undelete_user(user_id,confirmed)
{
  show_notification("error","Only administrators can undelete a user.",5000);
}
