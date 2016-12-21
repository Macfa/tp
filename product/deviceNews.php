<?

$arrCategory = DB::query("SELECT neKey FROM tmNewsCategory WHERE ncCategory=%s OR ncCategory=%s OR ncCategory=%s OR ncCategory=%s", $_GET['carrier'], $_GET['device'], $_GET['manuf'], $_GET['id']); 
foreach ($arrCategory as $value) {
	foreach ($value as $key => $val) {
		$newsKeyList[] = $val;
	}	
} // 카테고리에 해당하는 neKey 가지고 오기 


if(isExist($newsKeyList)){
	$newsKeyList = array_unique($newsKeyList);
	foreach ($newsKeyList as $key => $newsKey) {		
		$arrnews[] = DB::queryFirstRow("SELECT * FROM tmNews WHERE neKey=%i AND neDisplay = 1", $newsKey);
		$news = array_filter($arrnews);
		

	} // neKey에 해당하는 뉴스 정보 가지고 오기
}


$url = URL."/image.index.php?name=";

require_once("deviceNews.skin.php"); 
?>