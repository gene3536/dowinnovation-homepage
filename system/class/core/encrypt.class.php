<?php		
	class encryptClass extends msgClass {
		// 암복호화 함수 
		function bytexor($a, $b, $l) {
			$c = "";
			for($i=0; $i<$l; $i++) {
				if(isset($a{$i}) && isset($b{$i})) {
					$c .= $a{$i}^$b{$i};
				}
			}
			return($c);
		}
		
		// 암복호화 함수
		function binmd5($val) {
			return (pack("H*",md5($val)));
		}

		// 복호화 처리 
		function decrypt_md5($msg, $heslo) {
			$msg	= urldecode($msg);
			//$msg	= base64_decode($msg);
			$key	= $heslo;
			$sifra	= "";
			$key1	= $this -> binmd5($key);
			while($msg) {
				$m		= substr($msg,0,16);
				$msg	= substr($msg,16);
				$sifra	.= $m = $this -> bytexor($m,$key1,16);
				$key1	= $this -> binmd5($key.$key1.$m);
			}
			return($sifra);
		}

		// 암호화 처리
		function crypt_md5($msg, $heslo) {
			$key	= $heslo;
			$sifra	= "";
			$key1	= $this -> binmd5($key);
			while($msg) {
				$m		= substr($msg,0,16);
				$msg	= substr($msg,16);
				$sifra	.= $this -> bytexor($m,$key1,16);
				$key1	= $this -> binmd5($key.$key1.$m);
			}
			//$sifra	= base64_encode($sifra);
			$sifra	= urlencode($sifra);
			return($sifra);
		}
		
		// sha-256 암호화 - 2013.05.06
		function crypt_sha256($msg) {
			return hash("sha256", $msg);
		}
		
		// sha1 암호화 - 2013.12.06
		function crypt_imsi($str) {
			return "*".strtoupper(sha1(sha1($str, true)));
		}
	}
?>
