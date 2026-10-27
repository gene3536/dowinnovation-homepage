
// 다음 도로명주소 api
//document.write('<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>');

function execDaumPostcode(p) { 
	new daum.Postcode({
		oncomplete: function(data) {
			
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
			// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
			var extraRoadAddr = ''; // 도로명 조합형 주소 변수

			// 법정동명이 있을 경우 추가한다.
			if(data.bname !== ''){
				extraRoadAddr += data.bname;
			}
			// 건물명이 있을 경우 추가한다.
			if(data.buildingName !== ''){
				extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
			}
			// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
			if(extraRoadAddr !== ''){
				extraRoadAddr = ' (' + extraRoadAddr + ')';
			}
			// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
			if(fullRoadAddr !== ''){
				fullRoadAddr += extraRoadAddr;
			}
			
			var prefix = (typeof p != "undefined")? p : ""; 

			// 우편번호와 주소 정보를 해당 필드에 넣는다.
			document.getElementById(prefix+"post1").value = data.zonecode;
			//document.getElementById(prefix+"post2").value = data.postcode2;
			document.getElementById(prefix+"addr1").value = data.roadAddress;
			document.getElementById(prefix+"addr2").focus();
			//document.getElementById("addr2").value = data.jibunAddress;

			// 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
			if(data.autoRoadAddress) {
				//예상되는 도로명 주소에 조합형 주소를 추가한다.
				var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
				document.getElementById(prefix+"guide").innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

			} else if(data.autoJibunAddress) {
				var expJibunAddr = data.autoJibunAddress;
				document.getElementById(prefix+"guide").innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

			} else {
				document.getElementById(prefix+"guide").innerHTML = '';
			}

			/*var prefix = ((typeof f != "undefined") && f == 2)? "prtct_" : "";

			if(data.addressType=="R"){
				document.getElementById(prefix+"post1").value = data.postcode1;
				document.getElementById(prefix+"post2").value = data.postcode2;
				document.getElementById(prefix+"addr1").value = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '') + data.address2;
				document.getElementById(prefix+"addr2").focus();
				//document.getElementById(prefix+"addr2").value = data.address2;
			}else{
				alert("\n도로명 주소만 선택/입력이 가능합니다.\n\n확인 후 다시 검색/선택 해주세요.");
			}*/

		}
	}).open();
}
