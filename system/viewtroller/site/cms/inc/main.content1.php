<div class="mainCont1 clearfix">
	<table>
		<thead>
			<tr>
			    <th colspan="2">시스템정보</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			    <th><span>Operating System</span></th>
			    <td class="date"><?php echo $coreClass -> getOperationName()?></td>
			</tr>
			<tr>
			    <th><span>Disk Space</span></th>
			    <td class="date"><?php echo $coreClass -> getDiskSpace()?></td>
			</tr>
			<tr>
			    <th><span>CMS Version</span></th>
			    <td class="date"><?php echo site_config_ver ?></td>
			</tr>
			<tr>
			    <th></th>
			    <td class="date"></td>
			</tr>
			<tr><td colspan="2" class="tbl_padding"></td></tr>
		</tbody>
	</table>

	<table class="tableLast">
		<thead>
			<tr>
			    <th colspan="2">방문자수</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			    <th><span>전체 방문자수</span></th>
			    <td class="date"><?php echo number_format(site_count_total)?> 명</td>
			</tr>
			<tr>
			    <th><span>오늘 방문자수</span></th>
			    <td class="date"><?php echo number_format(site_count_today)?> 명</td>
			</tr>
			<tr>
			    <th><span>어제 방문자수</span></th>
			    <td class="date"><?php echo number_format(site_count_yesterday)?> 명</td>
			</tr>
			<tr>
			    <th><span>이달 방문자수</span></th>
			    <td class="date"><?php echo number_format(site_count_month)?> 명</td>
			</tr>
			<tr><td colspan="2" class="tbl_padding"></td></tr>
		</tbody>
	</table>
</div>