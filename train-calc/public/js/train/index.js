/*$(document).ready(function(){
	$('#getRoute').bind('click',function(){
		var stationA = $('#stationA').val();
		var stationB = $('#stationB').val();
		var csrfToken = $('#csrfToken').val();
		bodyContent = $.ajax({
		      url: "../getshortestroute",
		      global: false,
		      type: "POST",
		      data: ({stationA : stationA, stationB : stationB, csrfToken : csrfToken}),
		      dataType: "html",
		      async:false,
		      success: function(msg){
		         alert(msg);
		      }
		   }
		).responseText;
	
	}); // end of getRoute event
	
}); // end of document ready*/

(function($)
{
	$(document).ready(function() {
		$('#ThemeChangerInput').bind('change',function()
		{
			
			switchStylestyle($(this).val());
			return false;
		});
		var c = readCookie('style');
		if (c) switchStylestyle(c);
	});

	function switchStylestyle(styleName)
	{
		$('link[rel*=style][title]').each(function(i) 
		{
			this.disabled = true;
			
			if (this.getAttribute('title') == styleName) {
				this.disabled = false;
			$('#ThemeChangerInput').val(styleName);
			}
			
		});
		createCookie('style', styleName, 365);
	}
})(jQuery);


function createCookie(name,value,days)
{
	if (days)
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name)
{
	createCookie(name,"",-1);
}










$(document).ready(function(){
						   
	
	$('#start-over').bind('click',function(){
		$('#stationA').val('');
		$('#divSt1').empty().html('&nbsp;');
		
		$('#stationB').val('');
		$('#divSt2').empty().html('&nbsp;');
		
		$('#divSR').empty().html('&nbsp;');
		
		$('#respMsg').text('Select Your First Station');
		
	});
	
	$('#stations').bind('click',function(){
		if($('#stationA').val()==''){
			st = $('#stations').val();
			$('#stationA').val( st );
			$('#divSt1').html( ''+st );
			$('#respMsg').text('Select Your Second Station');
			
		}else if ($('#stationB').val()==''){
			st = $('#stations').val();
			$('#stationB').val( st );
			$('#divSt2').html( ''+st );
			
			
			var stationA = $('#stationA').val();
			var stationB = $('#stationB').val();
			var csrfToken = $('#csrfToken').val();
			bodyContent = $.ajax({
			      url: "/train-calc/public/getshortestroute",
			      global: false,
			      type: "POST",
			      data: ({stationA : stationA, stationB : stationB, csrfToken : csrfToken}),
			      dataType: "json",
			      async:false,
			      success: function(data){
			         if(data[0].status){
			        	 msg = data[0].msg + ' Total Distance is: ' + data[0].distance + ' and Shortest Path is: ' +  (data[0].shortestpath).join('-');
			        	 $('#respMsg').text(msg);
			        	 $('#divSR').text((data[0].shortestpath).join('-'));
			         }else{
			        	 $('#respMsg').text(data[0].msg);
			         }
			         
			      }
			   }
			).responseText;
			
			
			
			
		}
		
		
	});
	
	
});