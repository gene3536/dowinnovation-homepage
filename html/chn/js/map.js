var mapContainer1 = document.getElementById('map'); // 지도를 표시할 div 

var mapOption = {
        center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
        level: 3 // 지도의 확대 레벨
    };  
    

// 지도를 생성합니다    
var map1 = new kakao.maps.Map(mapContainer1, mapOption);

// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
var zoomControl1 = new kakao.maps.ZoomControl();
map1.addControl(zoomControl1, kakao.maps.ControlPosition.RIGHT);
map1.setZoomable(false);

// 주소-좌표 변환 객체를 생성합니다
var geocoder = new kakao.maps.services.Geocoder();

// 주소로 좌표를 검색합니다
geocoder.addressSearch('충청북도 음성군 대소면 산내로 60-40', function(result, status) {

    // 정상적으로 검색이 완료됐으면 
     if (status === kakao.maps.services.Status.OK) {

        var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

        // 결과값으로 받은 위치를 마커로 표시합니다
        var marker = new kakao.maps.Marker({
            map: map1,
            position: coords
        });

        coords1 = coords

        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
        map1.setCenter(coords);
    } 
});

$(window).resize(function(){
    map1.relayout();
    map1.setCenter(coords1);
});

$(window).click(function(){
    map1.relayout();
    map1.setCenter(coords1);
});