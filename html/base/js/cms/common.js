// XmlHttpRequest 객체 생성////////////////
if (typeof ActiveXObject != 'undefined') {
    XMLHttpRequest = function () {
        return new ActiveXObject(navigator.userAgent.indexOf('MSIE 5') >-1 ? 'Microsoft.XMLHTTP' : 'Msxml2.XMLHTTP');
    };
}
var xhr = new XMLHttpRequest();

// ID 객체 생성하고 함수 생성
function memberIdChk() {
	var uid = document.getElementById("info2").value;
    var url = "/base/xml/memberIdChk.php?uid="+uid;
    xhr.open("Get",url,true);
    xhr.onreadystatechange = memberIdCall;
    xhr.send();
}
function memberIdCall() {
    if (xhr.readyState == 4 && xhr.status == 200) {
    	var txt = xhr.responseText;
		if(txt == "true") {
			document.getElementById('idchk').innerHTML = "&nbsp;&bull;&nbsp;사용할 수 있는 아이디입니다.";
			document.getElementById('idchk').style.color = "#00F";
			document.getElementById('ichk').value = "true";
		} else if(txt == "false") {
			document.getElementById('idchk').innerHTML = "&nbsp;&bull;&nbsp;사용할 수 없는 아이디입니다.";
			document.getElementById('idchk').style.color = "#F00";
			document.getElementById('ichk').value = "false";
		} else if(txt == "error") {
			document.getElementById('idchk').innerHTML = "&nbsp;&bull;&nbsp;6~12자의 영문 및 숫자로 기입해주세요.";
			document.getElementById('idchk').style.color = "#F00";
			document.getElementById('ichk').value = "false";
		}
    }
}

// 멤버정보 입력폼
function memberInsertChk(obj) {
	if (!obj.info1.value) {
		alert("이름을 입력하세요");
		obj.info1.focus();
		return false;
	} else if (!obj.info2.value) {
		alert("아이디를 입력하세요");
		obj.info2.focus();
		return false;
	} else if(obj.ichk.value == "false") {
		alert("아이디를 바르게 입력하세요");
		obj.info2.focus();
		return false;
	} else if(!obj.info3.value || !obj.info4.value) {
		alert("비밀번호를 입력하세요");
		obj.info3.focus();
		return false;
	} else if(obj.info3.value != obj.info4.value) {
		alert("비밀번호가 일치하지 않습니다. 다시 입력하세요");
		obj.info3.focus();
		return false;
	} else {
		return true;
	}
}

$.datepicker.setDefaults({
    monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear:true,
    dateFormat: 'yy-mm-dd',
    buttonImageOnly: true,
    buttonText: "달력",
    buttonImage: "imgs/btn/btn_calendar.gif"
});
$(document).ready(function(){

    $("#icd_sdate, #Psdate").datepicker({
        defaultDate: new Date(),
        showOn: "both", // focus, button, both
        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
        showOptions: {direction: 'horizontal'},
        duration: 200
    });
	$("#icd_edate, #Pedate").datepicker({
        defaultDate: new Date(),
        showOn: "both", // focus, button, both
        showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
        showOptions: {direction: 'horizontal'},
        duration: 200
    });
	
	$.getXmlData("#menu1", "", 1, "");
	$("#menu1").click( function () {
		$("#menu2 option").remove();
		$.getXmlData("#menu2", "", 2, $("#menu1 option:selected").val());
		$("#icd_title").val($("#menu1 option:selected").text());
		$("#scodevar").val($("#menu1 option:selected").val());
	});		
	$("#menu2").click( function () {
		$("#menu3 option").remove();
		$.getXmlData("#menu3", $("#menu2 option:selected").val(), 3, $("#menu1 option:selected").val());
		$("#icd_title").val($("#menu1 option:selected").text() + " > " + $("#menu2 option:selected").text());
	});		
	$("#menu3").click( function () {
		$("#menu4 option").remove();
		$.getXmlData("#menu4", $("#menu3 option:selected").val(), 4, $("#menu1 option:selected").val());
		$("#icd_title").val($("#menu1 option:selected").text() + " > " + $("#menu2 option:selected").text() + " > " + $("#menu3 option:selected").text());
	});	
	$("#menu4").click( function () {
		$("#menu5 option").remove();
		$.getXmlData("#menu5", $("#menu4 option:selected").val(), 5, $("#menu1 option:selected").val()); 
		$("#icd_title").val($("#menu1 option:selected").text() + " > " + $("#menu2 option:selected").text() + " > " + $("#menu3 option:selected").text() + " > " + $("#menu4 option:selected").text() );
	});
	$("#menu5").click( function () { 
		$("#menu6 option").remove();
		$.getXmlData("#menu6", $("#menu5 option:selected").val(), 6, $("#menu1 option:selected").val()); 
		$("#icd_title").val($("#menu1 option:selected").text() + " > " + $("#menu2 option:selected").text() + " > " + $("#menu3 option:selected").text() + " > " + $("#menu4 option:selected").text() + " > " + $("#menu5 option:selected").text());
	});
	$("#menu6").click( function () {
		$("#icd_title").val($("#menu1 option:selected").text() + " > " + $("#menu2 option:selected").text() + " > " + $("#menu3 option:selected").text() + " > " + $("#menu4 option:selected").text() + " > " + $("#menu5 option:selected").text() + " > " + $("#menu6 option:selected").text());
	});
	/*$("#menu4").click( function () {
		$("#icd_title").val($("#menu1 option:selected").text() + " > " + $("#menu2 option:selected").text() + " > " + $("#menu3 option:selected").text() + " > " + $("#menu4 option:selected").text());
	});*/
});


$.getXmlData = function(target, kwd, type, scode) {   
	$.ajax({   
    	type: "get",   
		dataType: "xml",
		url: "/base/xml/siteMenu.php?kwd=" + kwd + "&type=" + type + "&scode=" + scode,    
		success: function(xml) {
			if($(xml).find("models").find("model").length > 0) {   
				$(xml).find("models").find("model").each(function() {   
					var menukey = $(this).find("menukey").text();   
					var title = $(this).find("title").text();   
					$(target).append("<option value='"+menukey+"'>"+title+"</option>");   
				});   
			}              
		},    
		error: function(xhr, status, error) {
			$(target).append("<option value=''>에러가 발생하였습니다.</option>");
			$(target).append("<option value=''>" + error + "</option>");
		}   
	});   
};

// 공통유형 폼 체크
$.frmValidation = function() {
	if($('#icd_title').is(this) && $.trim($('#icd_title').val()) == '') {
		alert("제목을 입력하세요.");
		$('#icd_title').focus();
		return false;
	} else if($('#board_name').is(this) && $.trim($('#board_name').val()) == '') {
		alert("제목을 입력하세요.");
		$('#board_name').focus();
		return false;
	} else if($('#brdata_subject').is(this) && $.trim($('#brdata_subject').val()) == '') {
		alert("제목을 입력하세요.");
		$('#brdata_subject').focus();
		return false;
	} else {
		$.submitContent();
	}
};

function datebtn(vars) {
	var f = document.getElementById("datechk");
	if(f.checked == true) {
		document.getElementById("icd_edate").value = "2020-12-31";
	} else if(f.checked == false) {
		document.getElementById("icd_edate").value = vars;
	}
}