<?php 

class import {
	private $templateJS = '<script type="text/javascript" src="{js}"></script>';
	private $templateCSS = '<link rel="stylesheet" type="text/css" href="{csspath}"/>';

	private $css = array();
	private $js = array();

	public function addCSS($css) {
		$this->css[] = $css;
		return $this;
	}

	public function addJS($js, $flag='basic') {
		$this->js[] = array (
						'flag' => $flag,
						'file' => $js
					);

		return $this;
	}

	public function importCSS() {
		foreach($this->css as $value) {
			$value_css = PATH_CSS."/".$value;
			$data['csspath'] = $value_css.'?v='.filemtime($value_css);
			echo getResultTemplate($data, $this->templateCSS);
		}
	}

	public function importJS() {
		foreach($this->js as $value) {
			if($value['flag'] === 'lib')
				$path = PATH_JS_LIB;
			else
				$path = PATH_JS;

			$value_js = $path."/".$value['file'];
			$data['js'] = $value_js.'?v='.filemtime($value_js);
			echo getResultTemplate($data, $this->templateJS);
		}
	}

	public function debug(){
		var_dump($this->js);
	}

}