/*
  Official website : http://craftpip.github.io/jquery-confirm/

  Api : http://craftpip.github.io/jquery-confirm/#api
*/

var confirm_dialog;

function display_confirm_dialog(title,body,confirmButtonClass,cancelButtonClass,theme,onConfirm,onCancel)
{
 	confirm_dialog = $.confirm({
		title: title,
		content: body,
		contentLoaded: function(){
		},
		icon: '',
			confirmButton: 'Yes',
		cancelButton: 'Cancel',
		confirmButtonClass: confirmButtonClass,
		cancelButtonClass: cancelButtonClass,
		theme: 'black',
		animation: 'zoom',
		closeAnimation: 'scale',
		animationSpeed: 500,
		animationBounce: 1.2,
		keyboardEnabled: false,
		rtl: false,
		confirmKeys: [13], // ENTER key
		cancelKeys: [27], // ESC key
		container: 'body',
		confirm: function () {
			if(onConfirm != "")
			{
				eval(onConfirm);
			}

		},
		cancel: function () {
			if(onCancel != "")
			{
				eval(onCancel);
			}

		},
		backgroundDismiss: false,
		autoClose: false,
		closeIcon: true,
    closeIconClass: 'fa fa-close', // or 'glyphicon glyphicon-remove'
		columnClass: 'col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1',
		onOpen: function(){
		},
		onClose: function(){
		},
		onAction: function(){
		}
	});

}
