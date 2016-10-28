<?

/////////////////////////////////////////////////////////////////////
//																					//
//			모든사이트에 기본적으로 들어가는 php 함수			//
//																					//
/////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////// 보안 함수

function pwEncrypt($input) {
	return hash("sha256", $input);
}

function encrypt($input) {
	return hash("sha256", $input);
}

// 이 함수는 물어보고 쓰세요
function clearEscape($input){
	return str_replace('\\','',$input);
}

// 자바스크립트, html, style, 주석 제거
function clean_html($input) { 
	/*
	$search = array(
		'@<script[^>]*?>.*?</script>@si'  // Strip out javascript
		, '@<[\/\!]*?[^<>]*?>@si'            // Strip out HTML tags
		, '@<style[^>]*?>.*?</style>@siU'    // Strip style tags properly
		, '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	);

	$output = preg_replace($search, '', $input); 
	*/
	$output = htmlspecialchars($input);

	return $output;
}

// php.ini 의 magic_quotes_gpc 값이 FALSE 인 경우 addslashes() 적용
function get_magic_quotes($input) {
	if (get_magic_quotes_gpc()) 
		$output = stripslashes($input);
	else 
		$output = addslashes($input);
	
	return $output;
}

// cleanInput() 함수이용한 필터링
function filtering($input) {
    if (is_array($input)) {		
        foreach($input as $key=>$val) {
            $output[$key] = filtering($val); // 해당 값이 배열이 아닐때 까지 함수 반복
        }
    }else {	//노배열
        $input = get_magic_quotes($input);
        $output = clean_html($input);
		$output = mysql_escape_string($input);
    }

    return $output;
}

// 세션변수 생성
function setSession($session_name, $value) {
    // PHP 버전별 차이를 없애기 위한 방법
	$$session_name = $_SESSION["$session_name"] = $value;
}

// 세션변수값 얻음
function getSession($session_name) {
    return $_SESSION[$session_name];
}

function unsetSession($session_name) {
	unset($_SESSION[$session_name]);
}

// 불법접근을 막도록 토큰을 생성하면서 토큰값을 리턴
function createToken() {
    $token = encrypt(md5(uniqid(rand(), true)));
    setSession("sess_token", $token);

    return $token;
}

// 넘어온 토큰과 세션에 저장된 토큰 비교
function chkToken($input) {
    if ($input === getSession('sess_token'))
		return true;
	return FALSE;
}

//파일 확장자 체크
function is_valid_file_extension($filename) {
	$allowed =  array('gif','png' ,'jpg'); //허용된 파일 확장자
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(in_array($ext,$allowed))
		return true;
	else 
		return false;
}

//특수문자 제거
function strip_special_char($input) {
	if (is_array($input)) {		
        foreach($input as $key=>$val) {
            $input[$key] = strip_special_char($val); // 해당 값이 배열이 아닐때 까지 함수 반복
        }
	} else {
		$input = preg_replace('/[#$%^&*()+=\-\[\]\';.\/{}|":<>?~\\\\]/', '',$input);
	}
	return $input;
} 

//랜덤 숫자 난수 생성 (보안성X)
function get_random_num($length){  
	$c= "0123456789";  
	srand((double)microtime()*1000000);  
	for($i=0; $i<$length; $i++) {  
		$rand.= $c[rand()%strlen($c)];  
	}  
	return $rand;  
} 

// -------------------------------------------------
// HTML FIXER v.2.05 15/07/2010
// clean dirty html and make it better, fix open tags
// bad nesting, bad quotes, bad autoclosing tags.
//
// by Giulio Pons, http://www.barattalo.it
// -------------------------------------------------
// usage:
// -------------------------------------------------
// $a = new HtmlFixer();
// $clean_html = $a->getFixedHtml($dirty_html);
// -------------------------------------------------

Class HtmlFixer {
	public $dirtyhtml;
	public $fixedhtml;
	public $allowed_styles;		// inline styles array of allowed css (if empty means ALL allowed)
	private $matrix;			// array used to store nodes
	public $debug;
	private $fixedhtmlDisplayCode;

	public function __construct() {
		$this->dirtyhtml = "";
		$this->fixedhtml = "";
		$this->debug = false;
		$this->fixedhtmlDisplayCode = "";
		$this->allowed_styles = array();
	}

	public function getFixedHtml($dirtyhtml) {
		$c = 0;
		$this->dirtyhtml = $dirtyhtml;
		$this->fixedhtml = "";
		$this->fixedhtmlDisplayCode = "";
		if (is_array($this->matrix)) unset($this->matrix);
		$errorsFound=0;
		while ($c<10) {
			/*
				iterations, every time it's getting better...
			*/
			if ($c>0) $this->dirtyhtml = $this->fixedxhtml;
			$errorsFound = $this->charByCharJob();
			if (!$errorsFound) $c=10;	// if no corrections made, stops iteration
			$this->fixedxhtml=str_replace('<root>','',$this->fixedxhtml);
			$this->fixedxhtml=str_replace('</root>','',$this->fixedxhtml);
			$this->fixedxhtml = $this->removeSpacesAndBadTags($this->fixedxhtml);
			$c++;
		}
		return $this->fixedxhtml;
	}

	private function fixStrToLower($m){
		/*
			$m is a part of the tag: make the first part of attr=value lowercase
		*/
		$right = strstr($m, '=');
		$left = str_replace($right,'',$m);
		return strtolower($left).$right;
	}

	private function fixQuotes($s){
		$q = "\"";// thanks to emmanuel@evobilis.com
		if (!stristr($s,"=")) return $s;
		$out = $s;
		preg_match_all("|=(.*)|",$s,$o,PREG_PATTERN_ORDER);
		for ($i = 0; $i< count ($o[1]); $i++) {
			$t = trim ( $o[1][$i] ) ;
			$lc="";
			if ($t!="") {
				if ($t[strlen($t)-1]==">") {
					$lc= ($t[strlen($t)-2].$t[strlen($t)-1])=="/>"  ?  "/>"  :  ">" ;
					$t=substr($t,0,-1);
				}
				//missing " or ' at the beginning
				if (($t[0]!="\"")&&($t[0]!="'")) $out = str_replace( $t, "\"".$t,$out); else $q=$t[0];
				//missing " or ' at the end
				if (($t[strlen($t)-1]!="\"")&&($t[strlen($t)-1]!="'")) $out = str_replace( $t.$lc, $t.$q.$lc,$out);
			}
		}
		return $out;
	}

	private function fixTag($t){
		/* remove non standard attributes and call the fix for quoted attributes */
		$t = preg_replace (
			array(
				'/borderColor=([^ >])*/i',
				'/border=([^ >])*/i'
			), 
			array(
				'',
				''
			)
			, $t);
		$ar = explode(" ",$t);
		$nt = "";
		for ($i=0;$i<count($ar);$i++) {
			$ar[$i]=$this->fixStrToLower($ar[$i]);
			if (stristr($ar[$i],"=")) $ar[$i] = $this->fixQuotes($ar[$i]);	// thanks to emmanuel@evobilis.com
			//if (stristr($ar[$i],"=") && !stristr($ar[$i],"=\"")) $ar[$i] = $this->fixQuotes($ar[$i]);
			$nt.=$ar[$i]." ";
		}
		$nt=preg_replace("/<( )*/i","<",$nt);
		$nt=preg_replace("/( )*>/i",">",$nt);
		return trim($nt);
	}

	private function extractChars($tag1,$tag2,$tutto) { /*extract a block between $tag1 and $tag2*/
		if (!stristr($tutto, $tag1)) return '';
		$s=stristr($tutto,$tag1);
		$s=substr( $s,strlen($tag1));
		if (!stristr($s,$tag2)) return '';
		$s1=stristr($s,$tag2);
		return substr($s,0,strlen($s)-strlen($s1));
	}

	private function mergeStyleAttributes($s) {
		//
		// merge many style definitions in the same tag in just one attribute style
		//

		$x = "";
		$temp = "";
		$c = 0;
		while(stristr($s,"style=\"")) {
			$temp = $this->extractChars("style=\"","\"",$s);
			if ($temp=="") {
				// missing closing quote! add missing quote.
				return preg_replace("/(\/)?>/i","\"\\1>",$s);
			}
			if ($c==0) $s = str_replace("style=\"".$temp."\"","##PUTITHERE##",$s);
				$s = str_replace("style=\"".$temp."\"","",$s);
			if (!preg_match("/;$/i",$temp)) $temp.=";";
			$x.=$temp;
			$c++;
		}

		if (count($this->allowed_styles)>0) {
			// keep only allowed styles by Martin Vool 2010-04-19
			$check=explode(';', $x);
			$x="";
			foreach($check as $chk){
				foreach($this->allowed_styles as $as)
					if(stripos($chk, $as) !== False) { $x.=$chk.';'; break; } 
			}
		}

		if ($c>0) $s = str_replace("##PUTITHERE##","style=\"".$x."\"",$s);
		return $s;


	}

	private function fixAutoclosingTags($tag,$tipo=""){
		/*
			metodo richiamato da fix() per aggiustare i tag auto chiudenti (<br/> <img ... />)
		*/
		if (in_array( $tipo, array ("img","input","br","hr")) ) {
			if (!stristr($tag,'/>')) $tag = str_replace('>','/>',$tag );
		}
		return $tag;
	}

	private function getTypeOfTag($tag) {
		$tag = trim(preg_replace("/[\>\<\/]/i","",$tag));
		$a = explode(" ",$tag);
		return $a[0];
	}


	private function checkTree() {
		// return the number of errors found
		$errorsCounter = 0;
		for ($i=1;$i<count($this->matrix);$i++) {
			$flag=false;
			if ($this->matrix[$i]["tagType"]=="div") { //div cannot stay inside a p, b, etc.
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em"))) $flag=true;
			}

			if (in_array( $this->matrix[$i]["tagType"], array( "b", "strong" )) ) { //b cannot stay inside b o strong.
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("b","strong"))) $flag=true;
			}

			if (in_array( $this->matrix[$i]["tagType"], array ( "i", "em") )) { //i cannot stay inside i or em
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("i","em"))) $flag=true;
			}

			if ($this->matrix[$i]["tagType"]=="p") {
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em"))) $flag=true;
			}

			if ($this->matrix[$i]["tagType"]=="table") {
				$parentType = $this->matrix[$this->matrix[$i]["parentTag"]]["tagType"];
				if (in_array($parentType, array("p","b","i","font","u","small","strong","em","tr","table"))) $flag=true;
			}
			if ($flag) {
				$errorsCounter++;
				if ($this->debug) echo "<div style='color:#ff0000'>Found a <b>".$this->matrix[$i]["tagType"]."</b> tag inside a <b>".htmlspecialchars($parentType)."</b> tag at node $i: MOVED</div>";
				
				$swap = $this->matrix[$this->matrix[$i]["parentTag"]]["parentTag"];
				if ($this->debug) echo "<div style='color:#ff0000'>Every node that has parent ".$this->matrix[$i]["parentTag"]." will have parent ".$swap."</div>";
				$this->matrix[$this->matrix[$i]["parentTag"]]["tag"]="<!-- T A G \"".$this->matrix[$this->matrix[$i]["parentTag"]]["tagType"]."\" R E M O V E D -->";
				$this->matrix[$this->matrix[$i]["parentTag"]]["tagType"]="";
				$hoSpostato=0;
				for ($j=count($this->matrix)-1;$j>=$i;$j--) {
					if ($this->matrix[$j]["parentTag"]==$this->matrix[$i]["parentTag"]) {
						$this->matrix[$j]["parentTag"] = $swap;
						$hoSpostato=1;
					}
				}
			}

		}
		return $errorsCounter;

	}

	private function findSonsOf($parentTag) {
		// build correct html recursively
		$out= "";
		for ($i=1;$i<count($this->matrix);$i++) {
			if ($this->matrix[$i]["parentTag"]==$parentTag) {
				if ($this->matrix[$i]["tag"]!="") {
					$out.=$this->matrix[$i]["pre"];
					$out.=$this->matrix[$i]["tag"];
					$out.=$this->matrix[$i]["post"];
				} else {
					$out.=$this->matrix[$i]["pre"];
					$out.=$this->matrix[$i]["post"];
				}
				if ($this->matrix[$i]["tag"]!="") {
					$out.=$this->findSonsOf($i);
					if ($this->matrix[$i]["tagType"]!="") {
						//write the closing tag
						if (!in_array($this->matrix[$i]["tagType"], array ( "br","img","hr","input"))) 
							$out.="</". $this->matrix[$i]["tagType"].">";
					}
				}
			}
		}
		return $out;
	}

	private function findSonsOfDisplayCode($parentTag) {
		//used for debug
		$out= "";
		for ($i=1;$i<count($this->matrix);$i++) {
			if ($this->matrix[$i]["parentTag"]==$parentTag) {
				$out.= "<div style=\"padding-left:15\"><span style='float:left;background-color:#FFFF99;color:#000;'>{$i}:</span>";
				if ($this->matrix[$i]["tag"]!="") {
					if ($this->matrix[$i]["pre"]!="") $out.=htmlspecialchars($this->matrix[$i]["pre"])."<br>";
					$out.="".htmlspecialchars($this->matrix[$i]["tag"])."<span style='background-color:red; color:white'>{$i} <em>".$this->matrix[$i]["tagType"]."</em></span>";
					$out.=htmlspecialchars($this->matrix[$i]["post"]);
				} else {
					if ($this->matrix[$i]["pre"]!="") $out.=htmlspecialchars($this->matrix[$i]["pre"])."<br>";
					$out.=htmlspecialchars($this->matrix[$i]["post"]);
				}
				if ($this->matrix[$i]["tag"]!="") {
					$out.="<div>".$this->findSonsOfDisplayCode($i)."</div>\n";
					if ($this->matrix[$i]["tagType"]!="") {
						if (($this->matrix[$i]["tagType"]!="br") && ($this->matrix[$i]["tagType"]!="img") && ($this->matrix[$i]["tagType"]!="hr")&& ($this->matrix[$i]["tagType"]!="input"))
							$out.="<div style='color:red'>".htmlspecialchars("</". $this->matrix[$i]["tagType"].">")."{$i} <em>".$this->matrix[$i]["tagType"]."</em></div>";
					}
				}
				$out.="</div>\n";
			}
		}
		return $out;
	}

	private function removeSpacesAndBadTags($s) {
		$i=0;
		while ($i<10) {
			$i++;
			$s = preg_replace (
				array(
					'/[\r\n]/i',
					'/  /i',
					'/<p([^>])*>(&nbsp;)*\s*<\/p>/i',
					'/<span([^>])*>(&nbsp;)*\s*<\/span>/i',
					'/<strong([^>])*>(&nbsp;)*\s*<\/strong>/i',
					'/<em([^>])*>(&nbsp;)*\s*<\/em>/i',
					'/<font([^>])*>(&nbsp;)*\s*<\/font>/i',
					'/<small([^>])*>(&nbsp;)*\s*<\/small>/i',
					'/<\?xml:namespace([^>])*><\/\?xml:namespace>/i',
					'/<\?xml:namespace([^>])*\/>/i',
					'/class=\"MsoNormal\"/i',
					'/<o:p><\/o:p>/i',
					'/<!DOCTYPE([^>])*>/i',
					'/<!--(.|\s)*?-->/',
					'/<\?(.|\s)*?\?>/'
				), 
				array(
					' ',
					' ',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					' ',
					'',
					''
				)
				, trim($s));
		}
		return $s;
	}

	private function charByCharJob() {
		$s = $this->removeSpacesAndBadTags($this->dirtyhtml);
 		if ($s=="") return;
		$s = "<root>".$s."</root>";
		$contenuto = "";
		$ns = "";
		$i=0;
		$j=0;
		$indexparentTag=0;
		$padri=array();
		array_push($padri,"0");
		$this->matrix[$j]["tagType"]="";
		$this->matrix[$j]["tag"]="";
		$this->matrix[$j]["parentTag"]="0";
		$this->matrix[$j]["pre"]="";
		$this->matrix[$j]["post"]="";
		$tags=array();
		while($i<strlen($s)) {
			if ( $s[$i] =="<") {
				/*
					found a tag
				*/
				$contenuto = $ns;
				$ns = "";
				
				$tag="";
				while( $i<strlen($s) && $s[$i]!=">" ){
					// get chars till the end of a tag
					$tag.=$s[$i];
					$i++;
				}
				$tag.=$s[$i];
				
				if($s[$i]==">") {
					/*
						$tag contains a tag <...chars...>
						let's clean it!
					*/
					$tag = $this->fixTag($tag);
					$tagType = $this->getTypeOfTag($tag);
					$tag = $this->fixAutoclosingTags($tag,$tagType);
					$tag = $this->mergeStyleAttributes($tag);

					if (!isset($tags[$tagType])) $tags[$tagType]=0;
					$tagok=true;
					if (($tags[$tagType]==0)&&(stristr($tag,'/'.$tagType.'>'))) {
						$tagok=false;
						/* there is a close tag without any open tag, I delete it */
						if ($this->debug) echo "<div style='color:#ff0000'>Found a closing tag <b>".htmlspecialchars($tag)."</b> at char $i without open tag: REMOVED</div>";
					}
				}
				if ($tagok) {
					$j++;
					$this->matrix[$j]["pre"]="";
					$this->matrix[$j]["post"]="";
					$this->matrix[$j]["parentTag"]="";
					$this->matrix[$j]["tag"]="";
					$this->matrix[$j]["tagType"]="";
					if (stristr($tag,'/'.$tagType.'>')) {
						/*
							it's the closing tag
						*/
						$ind = array_pop($padri);
						$this->matrix[$j]["post"]=$contenuto;
						$this->matrix[$j]["parentTag"]=$ind;
						$tags[$tagType]--;
					} else {
						if (@preg_match("/".$tagType."\/>$/i",$tag)||preg_match("/\/>/i",$tag)) {
							/*
								it's a autoclosing tag
							*/
							$this->matrix[$j]["tagType"]=$tagType;
							$this->matrix[$j]["tag"]=$tag;
							$indexparentTag = array_pop($padri);
							array_push($padri,$indexparentTag);
							$this->matrix[$j]["parentTag"]=$indexparentTag;
							$this->matrix[$j]["pre"]=$contenuto;
							$this->matrix[$j]["post"]="";
						} else {
							/*
								it's a open tag
							*/
							$tags[$tagType]++;
							$this->matrix[$j]["tagType"]=$tagType;
							$this->matrix[$j]["tag"]=$tag;
							$indexparentTag = array_pop($padri);
							array_push($padri,$indexparentTag);
							array_push($padri,$j);
							$this->matrix[$j]["parentTag"]=$indexparentTag;
							$this->matrix[$j]["pre"]=$contenuto;
							$this->matrix[$j]["post"]="";
						}
					}
				}
			} else {
				/*
					content of the tag
				*/
				$ns.=$s[$i];
			}
			$i++;
		}
		/*
			remove not valid tags
		*/
		for ($eli=$j+1;$eli<count($this->matrix);$eli++) {
			$this->matrix[$eli]["pre"]="";
			$this->matrix[$eli]["post"]="";
			$this->matrix[$eli]["parentTag"]="";
			$this->matrix[$eli]["tag"]="";
			$this->matrix[$eli]["tagType"]="";
		}
		$errorsCounter = $this->checkTree();		// errorsCounter contains the number of removed tags
		$this->fixedxhtml=$this->findSonsOf(0);	// build html fixed
		if ($this->debug) {
			$this->fixedxhtmlDisplayCode=$this->findSonsOfDisplayCode(0);
			echo "<table border=1 cellspacing=0 cellpadding=0>";
			echo "<tr><th>node id</th>";
			echo "<th>pre</th>";
			echo "<th>tag</th>";
			echo "<th>post</th>";
			echo "<th>parentTag</th>";
			echo "<th>tipo</th></tr>";
			for ($k=0;$k<=$j;$k++) {
				echo "<tr><td>$k</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["pre"])."</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["tag"])."</td>";
				echo "<td>&nbsp;".htmlspecialchars($this->matrix[$k]["post"])."</td>";
				echo "<td>&nbsp;".$this->matrix[$k]["parentTag"]."</td>";
				echo "<td>&nbsp;<i>".$this->matrix[$k]["tagType"]."</i></td></tr>";
			}
			echo "</table>";
			echo "<hr/>{$j}<hr/>\n\n\n\n".$this->fixedxhtmlDisplayCode;
		}
		return $errorsCounter;
	}
}


	 //return bin2hex(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));