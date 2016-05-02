<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<style>
.modal:nth-of-type(even) {
    z-index: 1042 !important;
}
.modal-backdrop.in:nth-of-type(even) {
    z-index: 1041 !important;
}

</style>
<body>
  <script>
  $(document).ready(function() {

    var users = [ '1' , '2' ];
    var i = 0;
    for(i;i<users.length;i++) {
      $.post("http://localhost/Treasure-Thess-Website/public/ban-user",
      {
        'user-id': users[i],
        'action-type' : 'ban'
      },
      function(data,status)
      {
        alert(data);
      });
    }

  });
  </script>
</body>
</html>
