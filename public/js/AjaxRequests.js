var xmlHttp;

	/*
		Send Ajax Request to the server

		PARAMETERS :

		#1 (Required) : required object PARAMETERS
		  variables :
		    Url = Url string to send PARAMETERS
				SendType = e.g "POST","GET"
				Parameters = Parameters to send (e.g username=tzinos&password=123&email=geotzinos@gmail.com)
		#2 (Optional) : optional object PARAMETERS
		  variables :
				ResponseMethod = Response method name
				DelayTime = Delay time (ms) before response method call
		    ResponseLabel = Response Label to send responsed data (e.g "#label1", ".label1")
				SpinnerLoader = Spinner loader (e.g "#spinner1", ".spinner1")
				SubmitButton = Submit Button (e.g "#button1", ".button1")
	*/
	function sendAjaxRequest(Required,Optional)
	{
		/*
			If all required variables setted
		*/
		if(Required.Url() && Required.SendType() && Required.Parameters())
		{
				/*
					If response-label exists
				*/
				if(Optional.ResponseLabel())
				{
					/*
						Initialize response label
					*/
					 $(Optional.ResponseLabel()).html('');
					 $(Optional.ResponseLabel()).hide();
					 //document.getElementById(response-label).style.display = "none";
				}

				 if (window.XMLHttpRequest)
		 		{
		 			/*
		 			 code for IE7+, Firefox, Chrome, Opera, Safari
		 			*/
		 			xmlHttp = new XMLHttpRequest();
		 		}
		 		else {
		 			/*
		 			 code for IE6, IE5
		 			*/
		 			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		 		}

					var opts = {
						lines: 11 // The number of lines to draw
					, length: 28 // The length of each line
					, width: 14 // The line thickness
					, radius: 32 // The radius of the inner circle
					, scale: 0.5 // Scales overall size of the spinner
					, corners: 1 // Corner roundness (0..1)
					, color: '#000' // #rgb or #rrggbb or array of colors
					, opacity: 0.25 // Opacity of the lines
					, rotate: 0 // The rotation offset
					, direction: 1 // 1: clockwise, -1: counterclockwise
					, speed: 1 // Rounds per second
					, trail: 60 // Afterglow percentage
					, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
					, zIndex: 2e9 // The z-index (defaults to 2000000000)
					, className: 'spinner' // The CSS class to assign to the spinner
					, top: '50%' // Top position relative to parent
					, left: '50%' // Left position relative to parent
					, shadow: false // Whether to render a shadow
					, hwaccel: false // Whether to use hardware acceleration
					, position: 'absolute' // Element positioning
					}

					/*
						If spinner loader exist
					*/
					if(Optional.SpinnerLoader())
					{
						var target = document.getElementById(Optional.SpinnerLoader()); //(Optional.SpinnerLoader()).get(0); //like getElementById

						spinner = new Spinner(opts).spin();
						target.appendChild(spinner.el);
					}

					/*
						While spin loading if submit button exists
						 must be disabled
					*/

					if(Optional.SubmitButton())
					{
						$(document).find(Optional.SubmitButton()).prop('disabled',true);
					}

					/*
						Milliseconds which user must wait
						after server response arrived
						(Spinner loader)
					*/
					if(Optional.ResponseMethod())
					{
						var millisecondsToWait = 0;

						if(Optional.DelayTime())
						{
							millisecondsToWait = Optional.DelayTime();
						}
						/*
							After var millisecondsToWait
							we will show results to the client
						*/
						xmlHttp.onreadystatechange = setTimeout(function() {
							 /*
							 	Call response function
							 */
							 window[Optional.ResponseMethod()]();
						}, millisecondsToWait);
					}

						/*
						 Send using POST Method
						*/
						xmlHttp.open(Required.SendType(), Required.Url(), false);
						/*
							Header encryption
						*/
						xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

						xmlHttp.send(Required.Parameters());
			}
			else if(Optional.ResponseLabel())
			{
				$(Optional.ResponseLabel()).show(); //css('display', 'inline-block'); //equivalent of show()
				$(Optional.ResponseLabel()).html("'<div class='alert alert-danger'>You didnt send all required parameter (Url,SendType,Parameters)</div>");
			}
			else {
				console.log("No parameters found2");
			}

	}
