<?

// 파일명.inc.php 는 다른 파일에 종속(include)되는 파일로 단독적으로 활용될수 없습니다.
// 파일명.skin.php 는 다른 파일의 html 부분을 담당하는 파일로 단독적으로 활용될수 없습니다.

require_once("./_common.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
 
$add_css = '<link rel="stylesheet" href="'.PATH_CSS.'/gifts.css" type="text/css">';
$js_file = '<script type="text/javascript" src="'.PATH_JS.'/gifts.js"></script>';
$isShowGiftDetail = false;

if ($_GET['giftId']) {
	$isShowGiftDetail = true;
	$showGift = 'active';
	$disableBody = 'disabled';
}

require_once($cfg['path']."/head.inc.php");			// 헤더 부분 (스킨포함)
?>
<main role="main">
	<ul class="main-slider bxslider">
		<li class="slide-item banner-rasiel">
			<a class="js-giftViewToggle" data-key="107"></a>
		</li>
	</ul>
</main>
<?
require_once("gifts.skin.php");	
require_once($cfg['path']."/foot.inc.php");			// foot 부분 (스킨포함)

?>

