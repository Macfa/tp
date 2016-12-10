<?php

class import
{
    private $importcss = '<link rel="stylesheet" type="text/css" href="{csspath}">';
    private $importjs = '<script type="text/javascript" src="{jspath}"></script>';
    private $css = array();
    private $js = array();

    public function addCSS($csspath) {
        $this->css[] = $csspath;
        return $this;
    }   // end stament addCSS

    public function addJS($jspath) {
        $this->js[] = $jspath;
        return $this;
    }   // end stament addJS

    public function importCSS() {
        foreach ($this->css as $key => $value) {
            $path_ext = pathinfo($value);

            if (strcmp($path_ext['extension'], 'css') === 0) {
                $data['csspath'] = $value.'?v='.filemtime($value);
                $result = str_replace('{csspath}', $data['csspath'], $this->importcss);
                echo $result;
            } else {
                echo "확장자명을 확인하여 다시 시도해주세요.";
                echo "Detail Error : ".var_dump($path_ext['extension']);
                break;
            }   // end stament if
        }   // end stament foreach
    }   // end stament importCSS

    public function importJS() {
        foreach ($this->js as $key => $value) {
            $path_ext = pathinfo($value);   // 확장자를 구해 변수에 대입 인덱스(extension)

            if (strcmp($path_ext['extension'], 'js') === 0) {   // js 와 동일하다면 0을 리턴
                $data['jspath'] = $value.'?v='.filemtime($value);   //변수에 파일명에 수정시간을 붙힌 값을 대입
                $result = str_replace('{jspath}', $data['jspath'], $this->importjs);    //변수에 1번째 인자를 2번째 인자로 넘겼
                echo $result;
            } else {
                echo "확장자명을 확인하여 다시 시도해주세요.";
                echo "Detail Error : ".var_dump($path_ext['extension']);
                break;
            }   // end stament if
        }   // end stament foreach
    }   // end stament importJS

}   // end stament class

 ?>
