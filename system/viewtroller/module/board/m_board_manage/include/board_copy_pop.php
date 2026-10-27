<script type="text/javascript">
// 카테고리
function changePlace2(ele) {
	//alert(ele);
	var formname = "search";
	var form = document.search;
	var cate = form.cate.value;
	document.ifrm_view.location.href = "sub.php?menukey=<?=$menukey?>&fld=<?=$fld?>&formname="+formname+"&mod=search&cate="+cate;

}
function changePlace3(ele) {
	//alert(ele);
	var formname = "changeDataForm";
	var form = document.changeDataForm;
	var cate = form.cate.value;
	document.ifrm_view.location.href = "sub.php?menukey=<?=$menukey?>&fld=<?=$fld?>&formname="+formname+"&mod=search&cate="+cate;

}

function CheckSid()
{
	var check = document.getElementsByName("chk[]");
	var dataSid="";
	for(i=0;i<check.length;i++)
	{
		if(check[i].checked == true)
		{
			dataSid = dataSid+check[i].value+":";
		}
	}
	return dataSid;
}	
function selectData(status) {
	/*
	var dataSid = CheckSid();
	if(dataSid == "")
	{
		alert("게시물을 선택하시기 바랍니다.");
		return;
	}
	*/

	//document.changeDataForm.datasSid.value = dataSid;
	document.changeDataForm.datasSid.value = <?=$no?>;
	document.changeDataForm.dataStatus.value = status;

	if(status == "C"){
		document.getElementById("tempStatus").innerHTML = "복사";
	}else if(status == "M"){
		document.getElementById("tempStatus").innerHTML = "이동";
	}
	
	showLayerChangeData();

}
//게시물 복사 이동
function showLayerChangeData() {
	var layer = document.getElementById("changeData");

	if(layer.style.visibility == "hidden") {
		layer.style.left = document.body.clientWidth/2 - 230;
		layer.style.top = document.body.clientHeight/2 + document.body.scrollTop - 80;
		layer.style.visibility = "";
	} else {
		layer.style.visibility = "hidden";
	}
}

function checkChangeData(f) {
	if(f.fld.value == "" || f.fld.value == 0) {
		alert("대상 게시판을 선택해 주세요.");
		return;
	}

	var boardSid = f.fld.options[f.fld.selectedIndex].value;
	var dataSid = f.datasSid.value;
	var status = f.dataStatus.value;

	var copyReply = "N";
	if(f.copyReply.checked == true){
		copyReply = "Y";
	}
	
	if(status == "C"){
		f.act.value="bbscopy";
	}else{
		f.act.value="bbsmove";
	}
	//alert(f.token.value);

	f.submit(f.act.value);
	//changeDataStr.changeDataStr(boardSid, dataSid, status, copyReply, "218.151.87.92", ListChangeDataCallback);
}

</script>
<iframe name="ifrm_view" id="iframe" src="sub.php?menukey=<?=$menukey?>&mod=search&fld=<?=$fld?>&cate=<?=$cate?>" width="0" height="0" frameborder="no" border="0" scrolling="auto"></iframe>



<?
//echo "aA:".$_SESSION['token'];
//echo "<BR>";
//echo "aA:".site_config_token;
?>


	<div id="changeData" style="position:absolute; visibility: hidden;cursor:hand">
	<form name="changeDataForm" method="post" action="sub.php?menukey=<?php echo $menukey?>" onsubmit="javascript:return checkChangeData(changeDataForm)"><!--target="comboaction" -->
		<input type="hidden" name="datasSid">
		<input type="hidden" name="dataStatus">
		
		<input type="hidden" name="mod" value="process">
		<input type="hidden" name="act" id="act" value="">
		<input type="hidden" name="token" value="<?php echo site_config_token?>" />

<table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3" colspan="3"style="filter:alpha(opacity=5);"></td>
  </tr>
  <tr>
    <td width="3"style="filter:alpha(opacity=5);">&nbsp;</td>
    <td>
        <table width="100%" border="0" cellpadding="0" cellspacing="3" bgcolor="d20300">
          <tr>
            <td bgcolor="#FFFFFF" style="padding:9px;" class="bg_main01">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="bg_layer01">
              <tr>
			    <td width="28">※</td>
                <td class="bg_layer02">게시물 <span id="tempStatus"></span></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
            </table>

              <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="d9d9d9" class="table01">
                <tr>
                  <td class="td_head">원본 게시판</td>
                  <td class="td_input">

					<input type="checkbox" name="copyReply" value="Y" checked="checked"><font color="blue">답변글 포함</font>

				  </td>
                </tr>
                <tr>
                  <td class="td_head">대상 게시판</td>
                  <td class="td_input">
		        	<select id="fld" name="fld" class="selline" title="검색조건" style="width:200px" >
		        		<option value="">-게시판명-</option>
		        		<?php
							$bwhere2         = " LEFT JOIN M_MENU ON M_MENU.MENU_BOARD = M_BOARD.BOARD_ID where BOARD_SCODE = '00000001' AND menu_scode='00000001' AND MENU_BOARD IS NOT NULL";
							$border2			= "ORDER BY board_name ASC";
							$brsss				= $coreClass -> selectQuery($tbl3, $bwhere2, $border2, "", "");//30
		        			while($browss = $coreClass -> selectFetchArray($brsss)) {
		        				$bcwhere		= "WHERE brdata_bid = '".$browss['BOARD_ID']."'";
								$bcnt			= $coreClass -> selectQueryCount(tbl_board_data, $bcwhere);	
		        				echo "<option value=\"".$browss['BOARD_ID']."\"";
								if($browss['BOARD_ID'] == $code1) {
									echo "selected=\"selected\"";
								}		        				
		        				echo ">".$browss['BOARD_NAME']." [".$bcnt."]</option>";
							}

						?>
					</select>

				  </td>
                </tr>
              </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="right">
                  <!--<a href="javascript:checkChangeData(changeDataForm)"><img src="/rfc/admin/images/button_ok.gif" width="52" height="23" border="0"/></a>&nbsp;-->
				  <a href="javascript:checkChangeData(changeDataForm)" class="btn_big"><strong>확인</strong></a>&nbsp;
				  <a href="Javascript:showLayerChangeData();" class="btn_big"><strong>닫기</strong></a>

                  <!--a href="Javascript:showLayerChangeData();"><img src="/rfc/admin/images/button_close.gif" width="52" height="23" border="0" /></a--></td>
                </tr>
              </table></td>
          </tr>
        </table>
    </td>
    <td width="3"style="filter:alpha(opacity=5);">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="3"style="filter:alpha(opacity=5);"></td>
  </tr>
</table>
</form>
</div>
<script>//makeDraggable("changeData");</script>

