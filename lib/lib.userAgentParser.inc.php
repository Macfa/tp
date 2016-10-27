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
			'class' => $this->class
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
