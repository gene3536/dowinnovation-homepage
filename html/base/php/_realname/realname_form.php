<?php if ( ! defined('CONFIG_DOC_DIR')) exit('No direct script access allowed');
/**
 * 0. Project  : i815 프로젝트
 *
 * 1. FileName : realname_form.php
 * 2. Comment : 
 * 3. 작성자  : GONOTE02
 * 4. 작성일  : 2010. 7. 27. 오전 10:55:42 
 * 5. 변경이력 : **/
 
// 이름 : GONOTE02   일시 : 2010. 7. 27. 오전 10:55:42    내용 : 신규작성
#공공 I-PIN
include $_SERVER["DOCUMENT_ROOT"]."/_prog/_realname/g-pin/input.php";
?>
<div id="txt">

<!--
<?if($mode=='L' || !$mode){?>
	<form name='inputFrm' action='<?=SSL?>/_prog/_member/' method='post'>
	<input type='hidden' name='return_url' value='<?=$return_url?>' />
	<input type='hidden' name='site_dvs_cd' value='<?=$site_dvs_cd?>' />
	<input type='hidden' name='menu_dvs_cd' value='<?=$menu_dvs_cd?>' />
	<input type='hidden' name='mode' value='LR' />
		<div id="member_login2">
			<p class="no_mar no_padd"><img src="/_prog/_member/img/member_login2_ti.gif" alt="Member Login 독립기념관 회원일경우 로그인 해주세요!" /></p>
		    <fieldset>
		    	<legend><strong>로그인폼 : </strong></legend>
		        <form action="/_prog/_member/login_result.php" name="memberform" id="memberform" method="post" style="display:inline">
		        <ul>
		        	<li>
		            	<label for="login_id">ㆍ아이디</label>
		                <input type="text" name="login_id" id="login_id" style="width:148px; border:1px solid #dadada;" />
		            </li>
		            <li class="left_mar_20">
		            	<label for="login_passwd">ㆍ비밀번호</label>
		                <input type="password" name="login_pwd" id="login_passwd" style="width:148px; border:1px solid #dadada;" />
		            </li>
		            <li class="left_mar_5"><input type="image" src="/_prog/_member/img/member_login2_loginbt.gif" alt="로그인" /></li>
		        </ul>
		        </form>
		    </fieldset>
		    <div class="member_login2_bt">
		    	<a href="/_prog/_member/?&amp;site_dvs_cd=<?=$site_dvs_cd?>&amp;menu_dvs_cd=070105"><img src="/_prog/_member/img/member_login2_bt1.gif" alt="회원가입" /></a>
		        <a href="/_prog/_member/index.php?mode=I&amp;site_dvs_cd=<?=$site_dvs_cd?>&amp;menu_dvs_cd=070103"><img src="/_prog/_member/img/member_login2_bt2.gif" alt="아이디찾기" /></a>
		        <a href="/_prog/_member/index.php?mode=P&amp;site_dvs_cd=<?=$site_dvs_cd?>&amp;menu_dvs_cd=070103"><img src="/_prog/_member/img/member_login2_bt3.gif" alt="비밀번호찾기" /></a>
		    </div>
		</div>
	</form>
<?}?>
-->

<?if($mode=='R' || !$mode){?>

<div class="point_box point_icon1">
	<p class="point_title">본인확인</p>
	<div class="point_cont">
		<ul class="ul_list1">
			<li>영동 국악체험촌은 원활한 홈페이지서비스이용과 익명의 사용자로인한 피해를 방지하고자 본인확인제도를 시행하고 있습니다.</li>
			<li>아래 본인(휴대폰)인증 또는 공공 I-PIN인증 중 하나를 선택하여 본인확인을 해 주시기 바랍니다.</li>
		</ul>
	</div>
</div>

<div class="principal_area">
	<div class="principal_box">
		<div class="principal_cont">
			<h4 class="cont_title2 mt20">휴대폰인증</h4>
			<p class="principal_text cont_box mt10">생년월일, 성명, 내/외국인, 휴대폰번호, 통신사를 입력하여 본인확인을 받습니다.</p>
			<!-- <p class="mt10 btn_base_center"><a href="javascript:alert('현재 서비스 준비중입니다.\n이용에 불편을 드려 죄송합니다.');" title="휴대폰 실명인증 새창열림" >휴대폰인증</a></p> -->
			<p class="mt10 btn_base_center"><a href="#" target="_blank" title="휴대폰 실명인증 새창열림" onclick="openPCCWindow();return false;" onkeypress="" class="btn_base">휴대폰인증</a></p>
		</div>
	</div>
	<div class="principal_box">
		<div class="principal_cont">
			<h4 class="cont_title2 mt20">공공 I-PIN 인증</h4>
			<p class="principal_text cont_box mt10">공공 아이핀(i-PIN)은 행정안전부에서 주관하는 주민등록번호대체수단으로 회원님의 주민등록번호 대신 식별ID를행정안전부로부터 발급받아 본인확인을 하는 서비스입니다.</p>
			<p class="mt10 btn_base_center"><a href="/_prog/_realname/g-pin/AuthRequest.php?return_url=<?=$return_url?>" target='_blank' onclick="GpinAuth();return false;" title="클릭시 공공아이핀 새창으로 이동합니다" class="btn_base">공공 I-PIN 인증</a></p>
		</div>
	</div>
</div>


<div class="gray_box mt30">
	<p>휴대폰인증을 통하여 본인확인이 안되는 경우에는 실명인증기관에 고객님의 정보가 없는경우이므로, 아래 실명인증기관을 통해 고객님의 실명정보를 등록해 주셔야 합니다.실명인증기관에 등록하신 후 24시간(영업일 기준)이 지나면 정상적으로 실명확인이 가능합니다.</p>
	<strong>내국인, 기업 실명등록 문의 : 서울신용평가정보(주) (☎1577-1006)</strong>
</div>

<p class="cont_title1 mt30">영동 국악체험촌은 개인정보 보호를 위해 최선의 노력을 기울이고 있습니다. </p>
<p class="mt5 indent_box1">여러분의 개인정보는 동의없이 공개되지 않으며, 개인정보 보호정책에 의해 보호받고 있습니다. </p>



<?}?>
</div>