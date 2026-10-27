<?php
	// 최근 로그인 접속기록
	$where	= "LEFT JOIN ".tbl_member." ON mb_uid = mb_log_uid WHERE 1=1";
	$order	= "ORDER BY mb_log_regdate DESC";
	$logRs	= $coreClass -> selectQuery(tbl_member_login, $where, $order, 0, 7);
	while($log = $coreClass -> selectFetchArray($logRs)) {
		$logCon .= '
			<tr>
				<th style="vertical-align:top;"><span>'.$log['MB_NAME'].'</span></th>
				<td class="date">'.$log['MB_LOG_REGIP'].'<br />'.$log['MB_LOG_REGDATE'].'</td>
			</tr>';
	}
	
	// 최근 로그인 실패기록
	$where	= "LEFT JOIN ".tbl_member." ON mb_uid = mb_logx_uid WHERE 1=1";
	$order	= "ORDER BY mb_logx_regdate DESC";
	$logRs	= $coreClass -> selectQuery(tbl_member_loginx, $where, $order, 0, 7);
	while($logx = $coreClass -> selectFetchArray($logRs)) {
		$logxCon .= '
			<tr>
				<th style="vertical-align:top;"><span>'.$logx['MB_NAME'].'</span></th>
				<td class="date">'.$logx['MB_LOGX_REGIP'].'<br />'.$logx['MB_LOGX_REGDATE'].'</td>
			</tr>';
	}
	
	// 내 접속기록
	$where	= "LEFT JOIN ".tbl_member." ON mb_uid = mb_log_uid WHERE mb_uid = '".S_mb_id."'";
	$order	= "ORDER BY mb_log_regdate DESC";
	$logRs	= $coreClass -> selectQuery(tbl_member_login, $where, $order, 0, 7);
	while($log = $coreClass -> selectFetchArray($logRs)) {
		$logMyCon .= '
			<tr>
				<th style="vertical-align:top;"><span>'.$log['MB_NAME'].'</span></th>
				<td class="date">'.$log['MB_LOG_REGIP'].'<br />'.$log['MB_LOG_REGDATE'].'</td>
			</tr>';
	}
?>

<div class="mainCont3 clearfix">
	<table class="mainTable1_1">
		<caption>최근 로그인 접속기록</caption>
		<thead>
			<tr><th colspan="2">최근 로그인 접속기록</th></tr>
		</thead>
		<tbody>
			<?php echo $logCon?>
		</tbody>
	</table>
	
	<table class="mainTable1_2">
		<caption>최근 로그인 실패기록</caption>
		<thead>
			<tr><th colspan="2">최근 로그인 실패기록</th></tr>
		</thead>
		<tbody>
			<?php echo $logxCon?>
		</tbody>
	</table>

	<table class="mainTable1_1">
		<caption>내 접속기록</caption>
		<thead>
			<tr><th colspan="2">내 접속기록</th></tr>
		</thead>
		<tbody>
			<?php echo $logMyCon?>			
		</tbody>
	</table>
	
	<table class="mainTable1_4">
		<caption></caption>
		<thead>
			<tr><th colspan="2"></th></tr>
		</thead>
		<tbody>
			<tr><td></td></tr>
		</tbody>
	</table>
</div>