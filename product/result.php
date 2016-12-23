<?
    require_once("./_common.inc.php");  // 공용부분 (모든 페이지에 쓰이는 php로직)  

    $import->addCSS('mypageList.css');
    
    require_once($cfg['path']."/headSimple.inc.php");           // 헤더 부분 (스킨포함)
    require_once("result.inc.php");         // 결과페이지 정보
    require_once("result.skin.php");         // 결과페이지 skin
    require_once($cfg['path']."/foot.inc.php");         // foot 부분 (스킨포함)


?>
