<?php
class Upload {

    private $upload_dest = array();
    private $check_size = 0;
    private $file_name = '';
    private $check_mime = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'mp3' => 'audio/mpeg'
    );

    public function addFILE($file) {
        // echo "<pre>file";
        // var_dump($file);
        // echo "</pre>";
        $this->upload_dest[] = $file;   // 업로드 파일들을 배열 형식에 담는다
        // echo "<pre>thisuploaddest";
        // var_dump($this->upload_dest);
        // echo "</pre>";
        $this->file_name[] = basename($upload_dest);
        return $this;
    }   // end stament addFILE

    public function checkFILE() {

        $checkfile = $this->upload_dest;
        echo "<pre>checkfile";
        var_dump($checkfile);
        echo "</pre>";

        foreach ($checkfile as $key => $value) {
            echo "<pre>foreachvalue";
            var_dump($value);
            echo "</pre>";
            $finfo = new finfo();
            $basefile_type = $finfo->file($finfo_open(FILEINFO_MIME_TYPE), $value);
            echo "<pre>basefile";
            var_dump($basefile_type);
            echo "</pre>";
            if(strcasecmp($check_mime, $basefile_type) === 0 ) {
                echo $basefile.' has match !';
            } else {
                return false;
            }// end stament if
        }   // end stament foreach
    }   // end stament checkFILE

    public function setSIZE($size = 102400) {
        $this->check_size = $size;
        return $this;
    }   // end stament setSIZE

    public function checkSIZE() {
        $file_size = filesize($this->upload_dest) / 1024;
        $basefile_size = $this->check_size;
        if ($file_size < $basefile_size) {
            echo $filesize.'has set !';
        } else {
            return false;
        }   // end stament if
    }   // end stament checkSIZE

    public function valiate() {
        if($this->checkFILE() === false) echo "FILE Checked"; return false;
        if($this->checkSIZE() === false) echo "SIZE Checked"; return false;
    }   // end stament valiate

    public function upload() {
        if($this->valiate() === false ) return false;
        foreach($this->file_name as $value)
        if (move_uploaded_file($value, '/Users/chy/tmp')) {
            echo $value." file upload complete !";
        } else {
            echo "upload failed Check dump".var_dump($this->upload());
        }   // end stament if
    }   // end stament upload
}   // end stament class
 ?>
