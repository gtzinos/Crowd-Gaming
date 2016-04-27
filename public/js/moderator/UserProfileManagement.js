function update_user(user_id,confirmed)
{
  if(!confirmed)
  {
    display_confirm_dialog("Confirm","Are you sure to update this profile with that data ?","btn-default","btn-default","black","update_user(" + user_id + ",true)","");
    return;
  }

  var access,
      email,
      password1,
      password2,
      name,
      surname,
      gender,
      country,
      city,
      address,
      phone;

  access = $("#edit-user-access").val();
  email = $("#edit-user-email").val();
  password1 = $("#edit-user-new-password").val();
  password2 = $("#edit-user-new-repeat-password").val();
  name = $("#edit-user-name").val();
  surname = $("#edit-user-surname").val();
  gender = $("#edit-user-gender").val();
  country = $("#edit-user-country").val();
  city = $("#edit-user-city").val();

  if ($("#user-edit-view-form").find('> * > .gt-input-group.has-success [required], > .gt-input-group.has-success').length >= $("#user-edit-view-form").find(' > * > .gt-input-group [required], > .gt-input-group [required]').length && $("#user-edit-view-form").find('> * > .gt-input-group.has-error, > .gt-input-group.has-error').length == 0)
  {
    alert("Invalid form fields.");
    return;
  }
  else if(access.length > 0 && email.length > 0 && password1 == password2 &&
          password1.length > 0 && password2.length > 0 && name.length > 0 && surname.length > 0
         && gender.length > 0 && country.length > 0 && city.length > 0)
  {
      let data_to_send = {
        "user-id" : user_id,
        "access" : access,
        "email" : email,
        "password" : password1,
        "name" : name,
        "surname" : surname,
        "gender" : gender,
        "country" : country,
        "city" : city
      };

    if($("#edit-user-address").val().length > 0){
      data_to_send["address"] = $("#edit-user-address").val();
    }
    if($("#edit-user-phone").val().length > 0) {
      data_to_send["phone"] = $("#edit-user-phone").val();
    }

    $.post(webRoot + "update-user-profile",data_to_send,
      //"extra-field": flag ? "extra" : null
    function(data,status){
      if(status == "success")
      {
        if(data == "0")
        {
          show_notification("success","User updated successfully.",3000);
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
        else if(data == "3")
        {
          show_notification("error","User had already a banned status.",5000);
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
}

function ban_user(user_id,confirmed)
{

  if(!confirmed)
  {
    display_confirm_dialog("Confirm","Are you sure to ban this user ?","btn-default","btn-default","black","ban_user(" + user_id + ",true)","");
    return;
  }

  /*
    Response Codes
     0 : All ok
     1 : User doesnt Exist
     2 : Database Error
     3 : Invalid action
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
      else if(data == "3")
      {
        show_notification("error","User had already a banned status.",5000);
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

  if(!confirmed)
  {
    display_confirm_dialog("Confirm","Are you sure to unban this user ?","btn-default","btn-default","black","unban_user(" + user_id + ",true)","");
    return;
  }

  /*
    Response Codes
     0 : All ok
     1 : User doesnt Exist
     2 : Database Error
     3 : Invalid action
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
      else if(data == "3")
      {
        show_notification("error","User is unbanned.",5000);
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
  if(!confirmed)
  {
    display_confirm_dialog("Confirm","Are you sure to delete this user ? Only database administrator can restore a deleted user.","btn-default","btn-default","black","delete_user(" + user_id + ",true)","");
    return;
  }

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
