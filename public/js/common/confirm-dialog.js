/*
  Official website : http://craftpip.github.io/jquery-confirm/

  Api : http://craftpip.github.io/jquery-confirm/#api
*/

$('button.gt-confirm-message').confirm({
		icon: 'fa fa-warning', // Title icon
    title: 'Please confirm',
		closeIcon: true,
	 	closeIconClass: 'fa fa-close', // or 'glyphicon glyphicon-remove'
		columnClass: 'col-xs-6 col-xs-offset-3',
    //content: '',
		confirmButton: 'Yes i agree',
    cancelButton: 'NOT now',
		confirmButtonClass: 'btn-warning', // btn-primary btn-inverse btn-warning btn-info btn-danger btn-success
    cancelButtonClass: 'btn-info', // btn-primary btn-inverse btn-warning btn-info btn-danger btn-success
    confirm: function(){
        //$.alert('Done');
    },
    cancel: function(){
        $.alert('You have canceled it.')
    }
});
