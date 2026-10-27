if(_mapUSE){
		var geocoder;
		var map;
		var infowindow;
		var marker;

		function initialize() {

			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(_mapX,_mapY);
			var myLatlng = new google.maps.LatLng(_mapX,_mapY);

			var myOptions = { 
				zoom: 14,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}

			map = new google.maps.Map(document.getElementById("mapArea"), myOptions);

			var contentString = '<div id="windowContent">';
			
			if(_mapTT != "") contentString += '<h1 id="firstHeading">'+_mapTT+'</h1>';
			if(_mapADDR != "") contentString += '<p style="padding-top:5px;">'+_mapADDR+'</p>';
			if(_mapCONT != "") contentString += '<p style="padding-top:5px;">'+_mapCONT+'</p>';

			contentString += '</div>';

			infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title:_mapTT
			});

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			});
			
			infowindow.open(map,marker);
		}	

		window.onload = function(){ 
			initialize();	
		}
}