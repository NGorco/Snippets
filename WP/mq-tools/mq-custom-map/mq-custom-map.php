<?php
/*
Plugin Name: MQ Custom Map
Version: 1.0
Description: Creates Google Maps with address you can provide like parametr
Author: Alex Petlenko
Site: http://massique.com
*/

add_action('init', function(){wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp', array('jquery'));});

function mq_custom_map($addrr)
{
	?>
<div id="map" style="width:100%; height:400px;"></div>
<script>

jQuery(function(){
	var k = function(){
		var map;

		function initialize() {

			google_cors("http://maps.googleapis.com/maps/api/geocode/json?address="+ encodeURIComponent('<?=$addrr?>')+ "&sensor=true_or_false", cors_ready);
			

			function cors_ready(data){
				
				var point = new google.maps.LatLng(data.results[0].geometry.location.lat, data.results[0].geometry.location.lng);
			    var mapOptions = {
			        zoom: 14,
			        center: point
			    };
			    map = new google.maps.Map(document.getElementById('map'),
			        mapOptions);

				var marker = new google.maps.Marker({
				    position: point,
				    map: map,
				    title: ''
				});
			}

			function google_cors(url, clbk, notJSON)
			{
				try {
					doCallOtherDomain_google(url, clbk, notJSON)
				} catch (e) {
					return false;
				}

				/**
				* Выполнение запроса
				*/
				function doCallOtherDomain_google(url, clbk, notJSON)
				{
					if(notJSON == undefined) notJSON = false;
					if(url == '' || typeof url != 'string') return false;
					
					var XHR = window.XDomainRequest || window.XMLHttpRequest;
					var xhr = new XHR();
					
					xhr.open('GET', url, true);

					xhr.onload = function()
					{
						if(clbk != undefined)
						{  
							if(!notJSON)
							{
								try
								{
									var DATA = JSON.parse(xhr.responseText)
								}catch(e){

									throw(e)
								}
							}

							console.log("CORS successfull");
							clbk(DATA);				
						}
					}

					xhr.onerror = function() 
					{
						throw("Cross-domain request fail");
					}

					xhr.send()
				}
			}


		}
		google.maps.event.addDomListener(window, 'load', initialize);

		return map;
	}();
})
</script>
<?
}



?>