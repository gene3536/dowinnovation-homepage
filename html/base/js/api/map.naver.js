if(_mapUSE){

	naver.maps.Service.geocode({
		address: _mapADDR
	}, function(status, response) {
		if (status !== naver.maps.Service.Status.OK) {
			return alert('Something wrong!');
		}

		var result = response.result, // 검색 결과의 컨테이너
			items = result.items; // 검색 결과의 배열

			var _x = items[0].point.x;
			var _y = items[0].point.y; 

			if(_x && _y){ 

				var center = new naver.maps.LatLng(_y, _x),
				    map = new naver.maps.Map('map', {
						center: new naver.maps.LatLng(_y, _x),
						zoom: 8, //지도의 초기 줌 레벨
						minZoom: 1, //지도의 최소 줌 레벨
						zoomControl: true, //줌 컨트롤의 표시 여부
						zoomControlOptions: { //줌 컨트롤의 옵션
							position: naver.maps.Position.TOP_RIGHT
						},
						mapTypeControl : true //지도 유형 컨트롤의 표시 여부
					});

				var marker = new naver.maps.Marker({
					position: center,
					map: map
				});

				var contentString = [
					'<div class="iw_inner">',
					'   <h3>'+_mapTT+'</h3>',
					'   <p>'+_mapADDR+'<br />',
					'		'+_mapCONT+'<br />',
					'   </p>',
					'</div>'
				].join('');

				var infowindow = new naver.maps.InfoWindow({
					content : contentString
				});

				naver.maps.Event.addListener(marker, "click", function(e) {
					if (infowindow.getMap()) {
						infowindow.close();
					} else {
						infowindow.open(map, marker);
					}
				});

				infowindow.open(map, marker);

			}
	});

}