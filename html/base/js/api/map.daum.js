if(_mapUSE){
	window.onload = function(){ 

		var mapContainer = document.getElementById('mapLoaderArea');// 지도를 표시할 div 
			mapContainer.style.height = "370px";

		var mapOption = { 
				center: new daum.maps.LatLng(_mapX,_mapY), // 지도의 중심좌표
				level: 3 // 지도의 확대 레벨
			};  

		var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

		// 일반 지도와 스카이뷰로 지도 타입을 전환할 수 있는 지도타입 컨트롤을 생성합니다
		var mapTypeControl = new daum.maps.MapTypeControl();

		// 지도에 컨트롤을 추가해야 지도위에 표시됩니다
		// daum.maps.ControlPosition은 컨트롤이 표시될 위치를 정의하는데 TOPRIGHT는 오른쪽 위를 의미합니다
		map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);

		// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
		var zoomControl = new daum.maps.ZoomControl();
		map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);

		// 마커가 표시될 위치입니다 
		var markerPosition  = new daum.maps.LatLng(_mapX,_mapY); 

		// 마커를 생성합니다
		var marker = new daum.maps.Marker({
			position  : markerPosition,
			clickable : true // 마커를 클릭했을 때 지도의 클릭 이벤트가 발생하지 않도록 설정합니다
			
		});

		// 마커가 지도 위에 표시되도록 설정합니다
		marker.setMap(map);

		var iwContent    = '<div style="position:relative; margin:5px; width:200px; text-align:center;"><h3><strong>'+_mapTT+'</strong></h3><!-- <a href="http://map.daum.net/link/map/Hello World!,33.450701,126.570667" style="color:blue" target="_blank">큰지도보기</a> <a href="http://map.daum.net/link/to/Hello World!,33.450701,126.570667" style="color:blue" target="_blank">길찾기</a> --></div>', // 인포윈도우에 표출될 내용으로 HTML 문자열이나 document element가 가능합니다
			iwPosition   = new daum.maps.LatLng(_mapX,_mapY); //인포윈도우 표시 위치입니다
			iwRemoveable = false; // removeable 속성을 ture 로 설정하면 인포윈도우를 닫을 수 있는 x버튼이 표시됩니다


		// 인포윈도우를 생성합니다
		var infowindow = new daum.maps.InfoWindow({
			position  : iwPosition, 
			content   : iwContent,
			removable : iwRemoveable
		});

		// 마커에 클릭이벤트를 등록합니다
		daum.maps.event.addListener(marker, 'click', function() {
			  // 마커 위에 인포윈도우를 표시합니다
			  infowindow.open(map, marker);  
		});
		  
		// 마커 위에 인포윈도우를 표시합니다. 두번째 파라미터인 marker를 넣어주지 않으면 지도 위에 표시됩니다
		infowindow.open(map, marker); 

	}

}