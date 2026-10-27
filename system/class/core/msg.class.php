<?php
	class msgClass extends connectionClass {
		function go($url){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						window.location.href = \"".$url."\";
					//]]>
					</script>
					<noscript>&bull;&nbsp;3초뒤에 이동<meta http-equiv='refresh' content='3; url=".$url."'></noscript>
				");
			die;
		}
	
		function msg_go($msg, $url){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						alert(\"".$msg."\");
						window.location.href = \"".$url."\";
						//]]>
					</script>
					<noscript>".$msg."<br>3초뒤에 이동<meta http-equiv='refresh' content='3; url=".$url."'></noscript>
				");
			die;
		}
		
		function confirm_go($msg, $url){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						var obj = window.confirm('".$msg."');          
						if(obj) {
							window.location.href = \"".$url."\";							
						} else {
							history.back();
						}
						//]]>
					</script>
					<noscript>".$msg."<br>3초뒤에 이동<meta http-equiv='refresh' content='3; url=".$url."'></noscript>
				");
			die;
		}
	
		function back(){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						history.back();
					//]]>
				</script>
				<noscript><a href=\"/\">메인페이지로이동</a>또는 뒤로가기 버튼을 눌러주세요</noscript>
				");
			die;
		}
	
		function msg_back($msg){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						alert(\"".$msg."\");
						history.back();
					//]]>
				</script>
				<noscript>".$msg."<br><a href=\"/\">메인페이지로이동</a>또는 뒤로가기 버튼을 눌러주세요</noscript>
				");
			die;
		}
	
		function msg($msg){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						alert(\"".$msg."\");
					//]]>
					</script>
				");
		}
		
		function msg_close($msg){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						alert(\"".$msg."\");
						self.close();
					//]]>
					</script>
				");
			die;
		}

		function msg_refresh($msg){
			echo("<script type=\"text/javascript\">
					//<![CDATA[
						alert(\"".$msg."\");
						opener.location.reload();
						self.close();
					//]]>
					</script>
				");
			die;
		}


	}
?>