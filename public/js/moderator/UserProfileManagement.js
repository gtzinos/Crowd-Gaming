function updateUser(id,confirmed)
{

}

function banUser(user_id,confirmed)
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
    "user-id" : user_id
  },
  function(data,status){
    if(status == "success")
    {
      if(data == "0")
      {
        show_notification("success","User banned successfully.",4000);
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

function deleteUser(id,confirmed)
{

}
