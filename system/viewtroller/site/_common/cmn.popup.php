<?php
	$where	= "WHERE (icd_scode = '".site_config_code."' OR icd_scode = '00000000') AND icd_pid = '00000004' AND icd_sdate <= '".site_regdate."' AND icd_edate >= '".site_regdate."' AND icd_visible = 'Y'";
	$order	= "ORDER BY icd_regdate ASC";
	$result	= $coreClass -> selectQuery(tbl_cms_icd, $where, $order, "", "");
	$leftSum	= 50;

	while($pop = $coreClass -> selectFetchArray($result)) {
?>

<div class="popupArea" id="popupArea<?php echo $pop['ICD_ID']?>" style="top:<?php echo $pop['ICD_FLD1']?>px; left:<?php echo $pop['ICD_FLD2']?>px; width:<?php echo $pop['ICD_WIDTH']?>px;">
	<div class="popupAreaContent" style="width:<?php echo $pop['ICD_WIDTH']?>px; height:<?php echo $pop['ICD_HEIGHT']?>px;"><?php echo $pop['ICD_CONTENT']?></div>
	<div style="padding:5px; text-align:center">
      	<a href="#null" onclick="popupClose('popupArea<?php echo $pop['ICD_ID']?>',2);return false;">1일간 팝업창 닫기 </a> |
		<a href="#null" onclick="popupClose('popupArea<?php echo $pop['ICD_ID']?>',1);return false;"> 팝업창 닫기</a>
	</div>
</div>
<?php
	}
?>

<style>
.popupArea {
	position:absolute;
	min-width: 230px;
	z-index:999999;
	background:#ededeb;
	border:1px solid #000;
	text-align:center;
}
.popupArea .popupAreaContent {
	margin:0 auto;
}
</style>

<script>
$(document).ready(function(){ 
	$('.popupAreaContent img').css({
		"width":"100%", "height":"100%"
	});

	$(".popupArea").each(function(){
		if(getCookie($(this).attr("id"))){
			popupClose($(this).attr("id"),1);
		}
	});
});

function popupClose(id,t)
{
	if(t == 2){
		setCookie( id, 'don', 1 );
	}
	$("#"+id).hide();
}
</script>

<script type="text/javascript">

	function setCookie( name, value, expiredays ) {
		var today = new Date();
		today.setDate( today.getDate() + expiredays );
		document.cookie = name + '=' + escape( value ) + '; path=/; expires=' + today.toGMTString() + ';';
	}

	function getCookie( cookieName )
	{
		var search = cookieName + "=";
		var cookie = document.cookie;

		// 현재 쿠키가 존재할 경우
		if( cookie.length > 0 )
		{
			// 해당 쿠키명이 존재하는지 검색한 후 존재하면 위치를 리턴.
			startIndex = cookie.indexOf( cookieName ); //alert(cookie);

			// 만약 존재한다면
			if( startIndex != -1 )
			{
				// 값을 얻어내기 위해 시작 인덱스 조절
				startIndex += cookieName.length;

				// 값을 얻어내기 위해 종료 인덱스 추출
				endIndex = cookie.indexOf( ";", startIndex );

				// 만약 종료 인덱스를 못찾게 되면 쿠키 전체길이로 설정
				if( endIndex == -1) endIndex = cookie.length;

				// 쿠키값을 추출하여 리턴
				return unescape( cookie.substring( startIndex + 1, endIndex ) );
			}
			else
			{
				// 쿠키 내에 해당 쿠키가 존재하지 않을 경우
				return false;
			}
		}
		else
		{
			// 쿠키 자체가 없을 경우
			return false;
		}
	}
</script>