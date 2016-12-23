<?php
class parseUserAgent {	
	private $u_agent = ''; 
	private $bname = 'Unknown';
	private $platform = 'Unknown';
	private $class = 'unknown';
	private $version= "";
	private $ub = '';


	function __construct(){
		$this->u_agent = $_SERVER['HTTP_USER_AGENT'];
	}

	public  function parse() { 

		//First get the platform?
		if (preg_match('/linux/i', $this->u_agent)) {
			$this->platform = 'linux';
		}
		else if (preg_match('/macintosh|mac os x/i', $this->u_agent)) {
			$this->platform = 'mac';
		} 
		else if (preg_match('/windows NT 10/i', $this->u_agent)) {
			$this->platform = 'win10';
		}
		else if (preg_match('/windows|win32/i', $this->u_agent)) {
			$this->platform = 'win';
		}

		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE|Trident/i',$this->u_agent) && !preg_match('/Opera/i',$this->u_agent)) { 
			$this->bname = 'Internet Explorer'; 
			$this->ub = "MSIE"; 
			$this->class = 'ie';
		} 
		else if(preg_match('/Firefox/i',$this->u_agent)) { 
			$this->bname = 'Mozilla Firefox'; 
			$this->ub = "Firefox"; 
			$this->class = 'firefox';
		} 
		else if(preg_match('/Chrome/i',$this->u_agent)){ 
			$this->bname = 'Google Chrome'; 
			$this->ub = "Chrome"; 
			$this->class = 'chrome';
		} 
		else if(preg_match('/Safari/i',$this->u_agent)) { 
			$this->bname = 'Apple Safari'; 
			$this->ub = "Safari"; 
			$this->class = 'safari';
		} 
		else if(preg_match('/Opera/i',$this->u_agent)) { 
			$this->bname = 'Opera'; 
			$this->ub = "Opera"; 
			$this->class = 'opera';
		} 
		else if(preg_match('/Netscape/i',$this->u_agent)) { 
			$this->bname = 'Netscape'; 
			$this->ub = "Netscape"; 
			$this->class ='netscape';
		} 

		//모바일 기기인지 아닌지 체크
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$this->u_agent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($this->u_agent,0,4))) {
			$this->device = 'mobile';
		}else{
			$this->device = 'pc';
		}

		// finally get the correct version number
		$known = array('Version', $this->ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $this->u_agent, $matches)) {
		// we have no matching number just continue
		}

		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($this->u_agent,"Version") < strripos($this->u_agent,$this->ub)){
				$this->version= $matches['version'][0];
			}else {
				$this->version= $matches['version'][1];
			}
		}else {
			$this->version= $matches['version'][0];
		}

		// check if we have a number
		if ($this->version==null || $this->version=="") {$this->version="?";}

		return $this;
	} 

	public function get(){
		return array(
			'userAgent' => $this->u_agent,
			'name'      => $this->bname,
			'version'   => $this->version,
			'platform'  => $this->platform,
			'class' => $this->class,
			'device' => $this->device
		);
	}

	public function getBrowserClass(){
		return $this->class;
	}

	public function getOS(){
		return $this->platform;
	}

	public function debug(){
		consoleLog($this->u_agent);
	}
}
