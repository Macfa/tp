<?php
ini_set('max_execution_time', '0');
include_once('./_common.inc.php');
require_once(PATH_LIB."/lib.zip.inc.php");	// 공용부분 (모든 페이지에 쓰이는 php로직)
echo META_CHARSET;

$arr = array('01192115059@naver.com','0383v@naver.com','050609@naver.com','0915mg@naver.com','1092kong@naver.com','12676721@naver.com','1402juny@naver.com','217742589','21cxmk@naver.com','220509683','226154363','226875906','227075119','227809638','228788729','229630584','229960892','230166262','230284985','230414154','230551309','230753675','230755352','230768525','230801621','230818642','230878398','230907042','230910336','230931817','230954823','230982885','230985061','230999282','231005577','231005869','231012037','231020977','231058200','231066248','231067428','231075440','231084090','231087370','231093090','231134041','231221651','231291353','231400987','231539591','231595962','231647061','231651619','231663483','231664068','231684507','231688751','231703970','231711746','231722790','231733867','231762259','231771131','231829227','231830084','231918214','231923990','231953034','232100742','232142361','232206097','232236486','232240690','232241768','232276578','232291503','232297033','232384795','232485051','232492696','232580474','232737729','232794326','232859864','232968492','233123825','233161929','233388999','233500328','233501538','233517549','233544433','233552984','233606291','233645391','233677649','233696666','233704840','233728443','233754923','233817016','233842477','233871758','233891415','233907666','233918576','233969228','234030884','234061057','234067857','234086246','234089390','234089465','234098705','234104550','234116408','234117859','234153748','234190533','234235125','234242219','234288889','234296751','234411388','234435118','234564115','234636353','234712701','234747634','234871902','234871947','234876251','234881402','234896046','234902566','234904864','234933746','234967757','234984832','235009128','235044989','235188319','235201363','235281024','235376455','235514915','235549945','235554862','235561960','235578314','235585344','235662291','235791411','235848404','236199420','236254101','236561793','237085928','2napig@naver.com','3327fksl@naver.com','457gogh@naver.com','550556@naver.com','7208k@naver.com','80432811@naver.com','921401@naver.com','94bada@naver.com','a_reum_choi@naver.com','a4447511@hanmail.net','a5481004@naver.com','adjlsk12@naver.com','admin@naver.com','adultedu@naver.com','ahrduddl@naver.com','airss@naver.com','aleyz@naver.com','alstjq87@naver.com','altattorney@naver.com','andrea891004@naver.com','angel23v@naver.com','ankiwon@nate.com','ankiwon@naver.com','annhojin@naver.com','anstjd3@naver.com','armani76@naver.com','atjmall@naver.com','ayh2828@naver.com','azppk@naver.com','baby8152@naver.com','babyduck04@nate.com','bbarsss@gmail.com','bcsup@naver.com','beautyhj19@naver.com','berneux@naver.com','bestbada@naver.com','bladepack@naver.com','bluecolak@naver.com','bluerainr@daum.net','bmwm4@naver.com','bogo9@naver.com','borakikiki@naver.com','bossfriend@naver.com','byeongdoo@lycos.co.kr','cafestock@naver.com','ccc5798@naver.com','chae3512@naver.com','chaepark79@naver.com','chan-suna@hanmail.net','chateau09@naver.com','chhyup@nate.com','chki0217@naver.com','cho9200@naver.com','chodingjjo@naver.com','chsandy8574@naver.com','chunineya@naver.com','ciwat@naver.com','cjs8010@naver.com','ckstn02@naver.com','classiccolor@naver.com','cls8127@naver.com','coch1234@naver.com','coldong@naver.com','contagious9@naver.com','coogi0928@naver.com','cool5400@naver.com','cortman2@naver.com','crepubic@naver.com','csm7160@hotmail.com','csyoung777@naver.com','cupofteagirl@naver.com','custom158@naver.com','cwdh007@naver.com','cwk2821@naver.com','cyc7550@naver.com','daebe@naver.com','daljuya@naver.com','dark2862@naver.com','darkshj86@naver.com','dbsdn_a@naver.com','desiree@naver.com','devilaqua@naver.com','dhdus3@naver.com','dhkcmapdl123@naver.com','dhshin','dillkkor@naver.com','dir1103@naver.com','distroy1@naver.com','djdj018@naver.com','djv14@naver.com','dkfla1115@naver.com','dkqrnfl@naver.com','dks0126@naver.com','dlaqhd7707@naver.com','dlwnsalsals1@naver.com','dmms486@daum.net','dnfqh1228@hanmail.net','docdelee@naver.com','dofjaotlwl@naver.com','doohuo@naver.com','dpsch2773@naver.com','ds1prh@naver.com','dskim6265@nate.com','dubnew@naver.com','duddnjsdls@naver.com','dudgkr1224@naver.com','dwkang@seyangcorp.co.kr','dygks00205@naver.com','dysuhjp@naver.com','ebhglee14@naver.com','ehdtkddhr@naver.com','eim20@naver.com','ejrqls1982@naver.com','elding@naver.com','emt0816@naver.com','eusilverluv@naver.com','faith_9095@naver.com','fasto05@naver.com','forno61@naver.com','frankliner@naver.com','frogelf@naver.com','future417@naver.com','fydsu@naver.com','gatsgrain@naver.com','gckim_2000@naver.com','ggi666@naver.com','ghdlfjq93@naver.com','ghdrkdgh@naver.com','gigongroh2@naver.com','gistmd@naver.com','gits99@naver.com','gkscndwo@naver.com','gmqgufrn@naver.com','gn2872@naver.com','gogo2748@naver.com','govigovl@naver.com','greensky@naver.com','gsukjh0105@naver.com','gusdkdy000@naver.com','gusdnc05@naver.com','gwangil90@naver.com','h2s1011@naver.com','h63003@naver.com','ha710@hanmail.net','haangel@naver.com','haemil100@naver.com','hana1356@naver.com','hanis95@naver.com','hanmink2@naver.com','hansyomi@naver.com','hanzzzang@naver.com','happybase@naver.com','hbhj0804@naver.com','hckim777@naver.com','hdex2@naver.com','hdhcoss@naver.com','heartduo@nate.com','heejin8111@naver.com','heeyaga@dreamwiz.com','herb1936@naver.com','hiveband@naver.com','hj150207@naver.com','hjhjjyg@naver.com','hjttl97@naver.com','hjyjh0213@naver.com','hm_seo420@naver.com','hmest1234@naver.com','hobbangww@naver.com','hojini1978@naver.com','hun1288@naver.com','hwsman@naver.com','hyoek7@naver.com','hyon_do@naver.com','iamnasg@naver.com','id7123@naver.com','idlenom11@naver.com','ihj011@naver.com','ilove125@naver.com','imseijun@naver.com','indipa00@naver.com','inhakiki@naver.com','ioo5424110@naver.com','issue94@naver.com','jaep17@naver.com','jchaha434@naver.com','jedh96@naver.com','jesuslove366@naver.com','jetty86@naver.com','jil010@naver.com','jintang2000@naver.com','jio1024@naver.com','jjh8910@naver.com','jocrabz@naver.com','joeun03@naver.com','jokerpolice@naver.com','jong910711@naver.com','js251102@naver.com','jsaltb@naver.com','jssh999@naver.com','jssrose@naver.com','jst21c@naver.com','jty1130@naver.com','jujak79@naver.com','julu866@naver.com','junki365@naver.com','junsoo00@naver.com','jyahn0102@naver.com','jyjy1950@naver.com','k2yblue@naver.com','k35618484@gmail.com','kaebong02@naver.com','kalaka82@naver.com','kbg3320@naver.com','kcw0825jmk@gmail.com','keunhong0426@naver.com','kheeya012@naver.com','khs30523@naver.com','khyunj64@gmail.com','kikira5@naver.com','kim.by@daum.net','kim01231@naver.com','kimdang7@naver.com','kimhan21a@naver.com','kimke075@hanmail.net','kimsinye@naver.com','kimspon@naver.com','kiolee@gmail.com','kisado1256@naver.com','kiwnpjg@naver.com','kjot1999@naver.com','kkhw1@naver.com','kkpark73@naver.com','km2015@naver.com','kmo7473@naver.com','kog11@naver.com','kohhyunj@naver.com','konami11@naver.com','konan79','koyoon0911@naver.com','kruta@naver.com','kschoi0511@naver.com','kshjj00@naver.com','kshzz012@naver.com','kwj5429@naver.com','kwt0206@naver.com','kylim2020@naver.com','kyo_85@naver.com','kystorm@naver.com','ldstm82@naver.com','leeholy@naver.com','leehwajin88@naver.com','leejae1588@naver.com','leejj3170@naver.com','leerae92@naver.com','leescgood@naver.com','leesho81@naver.com','lencks@naver.com','leodaniel@naver.com','lex84@naver.com','lgh1107first@naver.com','lhr101@nate.com','ljc2026@naver.com','ljk21@naver.com','ljk90@snu.ac.kr','ljl8926@naver.com','ljwtax@naver.com','lobo2913@gmail.com','loki741@naver.com','loveline-@naver.com','loveship76@naver.com','lsctmdcjf@naver.com','lsh9035@gmail.com','lsh9035@naver.com','lsk830727@naver.com','lsm6012@naver.com','lsmkpl@naver.com','ltsahj@naver.com','luckycloud11@naver.com','lunakent@naver.com','luri7550@naver.com','luvfulsun@gmail.com','lylylya@naver.com','macbeth1@naver.com','mallpark@hanmail.net','mandal77@naver.com','mange1004@naver.com','mebacks@naver.com','mhmicky@naver.com','mildmild60@naver.com','milkyway2206@naver.com','mina8302@naver.com','mio1233@naver.com','mirkr@naver.com','mjewoos@naver.com','mksm0927@naver.com','mm4125@naver.com','molia@naver.com','moonpolice@naver.com','moonsun68@naver.com','moral9@naver.com','mr0rain@gmail.com','msando@naver.com','mulanida@naver.com','my016ha@hanmail.net','myunghwa96@naver.com','na082xy@naver.com','naelsaint@naver.com','naff9250@naver.com','nallstar@naver.com','nameiswt@naver.com','nameiswt@sulbing.com','namulring@naver.com','nanosec79@naver.com','neo244@naver.com','nightking22@naver.com','odins74@naver.com','oe260634@naver.com','ohjinsub10@naver.com','ohsujin_a@naver.com','okbijou@naver.com','onghe92@naver.com','onsaemmi@naver.com','operbghks@naver.com','opjubu@naver.com','orolloo4@naver.com','osung0802@gmail.com','outset@hanmail.net','owsend513@naver.com','pa_@naver.com','pabrio@naver.com','paido@naver.com','parkgold0@naver.com','parksejin016@naver.com','pc3956@nate.com','pinnnk@hanmail.net','pinnnk@naver.com','pjh830612@naver.com','pjjy2706@hanmail.net','pjw324@naver.com','pkelfone@naver.com','pnchlove@naver.com','pnixhoon@naver.com','pokeman2000@naver.com','polaris0607@naver.com','pooh7274@naver.com','poseidon1028@naver.com','pshgeo@naver.com','psl1128@naver.com','pyodm@naver.com','qkqh6412@naver.com','qkrrkdtp11@naver.com','qqooqq22@naver.com','qusgmlfk@naver.com','qwea1487@naver.com','qwer951@naver.com','r75752@naver.com','ramy570@naver.com','random1234@naver.com','randomiz@naver.com','redfox970519@naver.com','redpsb@naver.com','redwinetears@naver.com','reum1107@gmail.com','rhdidglsla@naver.com','rheyong@naver.com','rjk2743@naver.com','rktlsk0000@naver.com','rockeya@naver.com','rodemiez@naver.com','rokaflkh@naver.com','rolly385@naver.com','rookie0401@naver.com','rttoo@naver.com','ruca3651@naver.com','ryeowook0623@naver.com','sabtak@naver.com','sallove17@naver.com','sch710409@naver.com','sct0328@naver.com','seohaejong@naver.com','sgh2080@naver.com','sharkyak@naver.com','shauts@naver.com','shdmf1990@naver.com','shematalk@naver.com','shin_ki_soo@naver.com','shwalee@naver.com','sien5@naver.com','silky_@naver.com','silvaweldd@naver.com','simering123@naver.com','siwon913@nave.com','sjstar@naver.com','skclssk12@naver.com','skykds0219@naver.com','skysh1623@naver.com','skyso1623@naver.com','snipper3@naver.com','snoopdie@naver.com','snupy2002@naver.com','solomon1001@naver.com','soniceguy@naver.com','sos2sos1@naver.com','soulfree47@naver.com','spirit1124@naver.com','srchango2@naver.com','ssoo1882@naver.com','ssrney@naver.com','stopjin@naver.com','stouma@naver.com','sugbong2@naver.com','sunderfoot@naver.com','sweetblossom@daum.net','sylvanus123@naver.com','tabasco1021@naver.com','tai156616@naver.com','targin@naver.com','tbsskdhk@naver.com','teamo2012@naver.com','theshop9@naver.com','thfud83@naver.com','thief20@naver.com','thisba2000@naver.com','tjdahqndu@naver.com','tjdrnjsdl79@naver.com','tjfwodlr1@naver.com','tjsgpzkfzkf1@naver.com','tkdgygygy@naver.com','tlaqk250@naver.com','tnwl80@naver.com','tonuni@naver.com','trejor1224@naver.com','ttub712@naver.com','uscousco@naver.com','uu1542@naver.com','vanmysun@korea.kr','waguno@naver.com','we7899@naver.com','web2dung2@naver.com','weekendh@naver.com','weeksmall@naver.com','westside2975@naver.com','whomed@naver.com','winds90@naver.com','windsp7@naver.com','windysz7@naver.com','wjddms4917@naver.com','wldhgo2788@naver.com','wldn0703@naver.com','wlsdnjs81@naver.com','wlsgks777@naver.com','wndrnl879@naver.com','worldfuture@naver.com','wujinkihoan@naver.com','wwjyn0203@naver.com','wwwl0ve@naver.com','xjvmqkrrk@hanmail.net','xpromy@naver.com','xprotz@naver.com','xx1204xx@naver.com','yds0002@naver.com','yeojoocc@naver.com','yeons62@naver.com','yg777777@naver.com','yhjung2000@naver.com','yiopuu@naver.com','yjlloves2@hanmail.net','yoonee33@naver.com','yoongoodid@naver.com','yoonmh12@naver.com','young4270@naver.com','youngjiv@naver.com','yucoms@naver.com','yulim6038@naver.com','zest621@naver.com','zltmf79@naver.com');

echo ' <pre>';
foreach ($arr as $val) {
	list($mbName, $mbPhone) = DB::queryFirstList("SELECT mbName, mbPhone FROM tmMember where mbEmail = %s",$val);
	echo $val.'|';
	echo $mbName.'|';
	echo $mbPhone;
	echo '<br/>';
}
echo '</pre>';
/*
$d = @dir('/home/www/traumplanet-storage/');
while ($entry = $d->read()) {
	if ($entry == "." || $entry == "..") continue;
	foreach ($arr as $val) {
		echo $val.' ---- ';
		
		if(isContain($val,$entry)){
			//$zip->addFile('/home/www/traumplanet-storag	e/'.$entry);
			echo $entry.'<br/>';
			continue;
		}
		echo '<br/>';
	}
	
}
*/

//echo META_CHARSET;


?>
<?
/*
$fileList = DB::query("SELECT * FROM `tmFileStorage` where fsFileName like '%조경락%'	or
fsFileName like '%박선희%'	or
fsFileName like '%김동흔%'	or
fsFileName like '%김수영%'	or
fsFileName like '%김경희%'	or
fsFileName like '%이영우%'	or
fsFileName like '%김학명%'	or
fsFileName like '%이진수%'	or
fsFileName like '%이순영%'	or
fsFileName like '%임청진%'	or
fsFileName like '%한민수%'	or
fsFileName like '%김지성%'	or
fsFileName like '%박종섭%'	or
fsFileName like '%정영문%'	or
fsFileName like '%박경식%'	or
fsFileName like '%김기웅%'	or
fsFileName like '%정일영%'	or
fsFileName like '%김경원%'	or
fsFileName like '%안성호%'	or
fsFileName like '%박지현%'	or
fsFileName like '%정인권%'	or
fsFileName like '%동상옥%'	or
fsFileName like '%강후남%'	or
fsFileName like '%정원진%'	or
fsFileName like '%이재련%'	or
fsFileName like '%최지연%'	or
fsFileName like '%김형주%'	or
fsFileName like '%김행호%'	or
fsFileName like '%이정규%'	or
fsFileName like '%구성림%'	or
fsFileName like '%박정일%'	or
fsFileName like '%황금미%'	or
fsFileName like '%장혜원%'	or
fsFileName like '%최소라%'	or
fsFileName like '%김선화%'	or
fsFileName like '%박미례%'	or
fsFileName like '%박영환%'	or
fsFileName like '%고혜련%'	or
fsFileName like '%조지훈%'	or
fsFileName like '%박경진%'	or
fsFileName like '%박준모%'	or
fsFileName like '%이영직%'	or
fsFileName like '%정형진%'	or
fsFileName like '%안지민%'	or
fsFileName like '%이정애%'	or
fsFileName like '%김한열%'	or
fsFileName like '%최승희%'	or
fsFileName like '%원택연%'	or
fsFileName like '%김보영%'	or
fsFileName like '%이상혁%'	or
fsFileName like '%오창현%'	or
fsFileName like '%김가람%'	or
fsFileName like '%조성애%'	or
fsFileName like '%이예리%'	or
fsFileName like '%이승원%'	or
fsFileName like '%박재홍%'	or
fsFileName like '%정수정%'	or
fsFileName like '%김신영%'	or
fsFileName like '%서태식%'	or
fsFileName like '%김성%'	or
fsFileName like '%박지호%'	or
fsFileName like '%박상은%'	or
fsFileName like '%이영희%'	or
fsFileName like '%유환%'	or
fsFileName like '%조경수%'	or
fsFileName like '%김동원%'	or
fsFileName like '%정대운%'	or
fsFileName like '%조미진%'	or
fsFileName like '%최수영%'	or
fsFileName like '%홍정현%'	or
fsFileName like '%황성욱%'	or
fsFileName like '%정영묵%'	or
fsFileName like '%조성문%'	or
fsFileName like '%최태영%'	or
fsFileName like '%전은주%'	or
fsFileName like '%김지섭%'	or
fsFileName like '%김나래%'	or
fsFileName like '%서대신%'	or
fsFileName like '%김수은%'	or
fsFileName like '%변희라%'	or
fsFileName like '%김대중%'	or
fsFileName like '%박수윤%'	or
fsFileName like '%강창한%'	or
fsFileName like '%정혜현%'	or
fsFileName like '%김종남%'	or
fsFileName like '%최웅집%'	or
fsFileName like '%김정임%'	or
fsFileName like '%박준석%'	or
fsFileName like '%강보라%'	or
fsFileName like '%최민우%'	or
fsFileName like '%이목영%'	or
fsFileName like '%윤두루찬%'	or
fsFileName like '%이아람%'	or
fsFileName like '%신아영%'	or
fsFileName like '%이종희%'	or
fsFileName like '%이사랑%'	or
fsFileName like '%구성진%'");

$zip = new DirectZip();
$zip->open($cfg['time_ymdhis'].' LG 신청자 가입신청서모음.zip');

foreach ($fileList as $val) {
	//if (isNullVal($val['fsFileName'])) continue;
	//echo '<pre>';
	//print_r($val);
	//echo '</pre><br/>';
	if (file_exists('/home/www/traumplanet-storage/'.$val['fsFileName']))
		$zip->addFile('/home/www/traumplanet-storage/'.$val['fsFileName']);
		//echo "yes<br/>";
		
	//	echo "yes<Br/><Br/><Br/><Br/><Br/>";
	//else
	//	echo "no<Br/><Br/><Br/><Br/><Br/>";
		
}

$zip->close();
*/

//$zip = new DirectZip();
//$zip->open($cfg['time_ymdhis'].' LG 신청자 가입신청서모음.zip');

/*
$list = array('heeyaga@dreamwiz\.com','230878398','gogo2748@naver\.com','dubnew@naver\.com','230910336','231829227','lylylya@naver\.com','sugbong2@naver\.com','heeyaga@dreamwiz\.com','kimhan21a@naver\.com','ghdrkdgh@naver\.com','457gogh@naver\.com','qusgmlfk@naver\.com','lsh9035@gmail\.com','234876251','ehdtkddhr@naver\.com','sallove17@naver\.com','jty1130@naver\.com','kimdang7@naver\.com','worldfuture@naver\.com','jsaltb@naver\.com','loveline-@naver\.com','234871947','233918576','sjstar@naver\.com','eim20@naver\.com','rheyong@naver\.com','232276578','csyoung777@naver\.com','rodemiez@naver\.com','loveline-@naver\.com','bluecolak@naver\.com','ahrduddl@naver\.com','loki741@naver\.com','onsaemmi@naver\.com','solomon1001@naver\.com','234896046','chan-suna@hanmail\.net','234984832','tai156616@naver\.com','gits99@naver\.com','lsh9035@gmail\.com','lsh9035@naver\.com','rktlsk0000@naver\.com','ghdrkdgh@naver\.com','234904864','jty1130@naver\.com','nightking22@naver\.com');

$d = @dir('/home/www/traumplanet-storage/');
while ($entry = $d->read()) {
	if ($entry == "." || $entry == "..") continue;
	echo $entry.'<br/>';
	
	foreach ($list as $val) {
		
		
		if(isContain($val,$entry)){
			//$zip->addFile('/home/www/traumplanet-storage/'.$entry);
			echo $entry.'<br/>';
			continue;
		}
		
	}
	
}
*/

//$zip->close();
/*
DB::query("SELECT * FROM tmFileStorage as a LEFT JOIN tmPreorderNote7 as b ON a.fsKey = b.fsKey WHERE b.pnState = 0");
foreach ($fileList as $val) {
	if (isNullVal($val['fsFileName'])) continue;
	//echo '<pre>';
	//print_r($val);
	//echo '</pre><br/>';
	if (file_exists('/home/www/traumplanet-storage/'.iconv("utf-8","CP949", $val['fsFileName'])))
		$zip->addFile('/home/www/traumplanet-storage/'.iconv("utf-8","CP949", $val['fsFileName']), $val['pnKey'].'_'.$val['fsFileName']);
	else if (file_exists('/home/www/traumplanet-storage/'.$val['fsFileName']))
		$zip->addFile('/home/www/traumplanet-storage/'.$val['fsFileName'], $val['pnKey'].'_'.$val['fsFileName']);
	//DB::update('tmPreorderNote7', array('pnState' => 1), 'mbEmail = %s', $val['mbEmail']);
}


$fileList = DB::query("SELECT * FROM tmFileStorage as a LEFT JOIN tmPreorderNote7 as b ON a.fsKey = b.fsKey");
$d = @dir('/home/www/traumplanet-storage/');
while ($entry = $d->read()) {
	if ($entry == "." || $entry == "..") continue;

	$extension = explode('.',$entry);
	$extension = $extension[count($extension)-1];

	if (file_exists('/home/www/traumplanet-storage/'.$entry))
		echo $entry."- ".mb_detect_encoding($entry)."<br/><br/>";

	//echo $entry."<Br/>";

	foreach ($fileList as $val) {
		if (isNullVal($val['mbEmail'])) continue;
		if (isContain($val['mbEmail'], $entry)){
			$mb = DB::queryFirstRow("select * from tmMember where mbEmail = %s", $val['mbEmail']);
			$fileName = $mb['mbEmail'].'_'.$mb['mbName'].'_'.$mb['mbPhone'].'_'.pwEncrypt($mb['mbName'].time()).'.'.$extension;
			
			//$reuslt = rename('/home/www/traumplanet-storage/'.$entry, $fileName);
			$result = DB::update("tmFileStorage", array("fsFileName"=>$fileName), "fsKey = %i", $val['fsKey']);
			print_r($result);
		}
	}
}

$fileList = DB::query("SELECT * FROM tmFileStorage as a LEFT JOIN tmPreorderNote7 as b ON a.fsKey = b.fsKey");

foreach ($fileList as $val) {
	if (isNullVal($val['mbEmail'])) continue;

	$mb = DB::queryFirstRow("select * from tmMember where mbEmail = %s", $val['mbEmail']);
	$fileName = $mb['mbEmail'].'_'.$mb['mbName'].'_'.$mb['mbPhone'].'_'.encrypt($mb['mbName'].time()).'.zip';
	
	//$reuslt = rename('/home/www/traumplanet-storage/'.$entry, $fileName);
	$result = DB::update("tmFileStorage", array("fsFileName"=>$fileName), "fsKey = %i", $val['fsKey']);
	print_r($result);

}
*/
/*
include_once(PATH_LIB.'/lib.snoopy.inc.php');

include(PATH_LIB.'/httpful.phar');
$url = "https://api.github.com/users/nategood";
$response = \Httpful\Request::get('http://www.naver.com')->send();
echo $response->body;


$data = new snoopy;
$data->_httpmethod = "POST"; 
$data->agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
$data->referer = "https://tgatemng.sktelecom.com/menu/menuCommon.do?url=/tgate/admin/ScrbMgmt.jsp&menu_id=B050000&submenu_id=";
//$auth['pw'] = '';
$auth['userCookie'] = '';
$auth['pw'] = 'mktk0313!';
$auth['CMD'] = '1';
$auth['gubun'] = 'T';
$auth['login_id'] = 'mktraum1';
$auth['scrt_num'] = $auth['pw'];
//$auth['smsYn'] = 'Y';
//$auth['x'] = 59;
//$auth['y'] = 20;
//$smsCheck = 'https://tgatemng.sktelecom.com/main/login/CertiSMS.do';
//$data->submit($smsCheck,$auth);
//$data->setcookies();
//$loginURL = 'http://tgatemng.sktelecom.com/main/login/loginAction.do?smsYn=Y';
$data->cookies['__smVisitorID'] = 'Q8bblOBSqQz';
$data->cookies['JSESSIONID'] = '2FB7B93D6159942099995668F310CA02.ta_node1';
$dataUrl = 'https://tgatemng.sktelecom.com/scrbmgmt/scrbMgmtSrchLst.do?prodsrchsel=&prdsrchst=cre_dt&prdsrchsel=03&prdsrchstadt=20160616&prdsrchenddt=20160616&mktdivorgid=B111090000&cntrorgid=C112840000&agnorgid=0000007433&selrid=MKTRAUM1&appl_form_oper_grp_num=&applformseq=&buyrnm=&buyrphonnum=&fixnum=&eqpcd=&eqp_color=&wireprodcd=&wire_prod=&eqpsernum=&spmallodernum=&usimmdl=&usimnum=&applstcdwless=&wire_st_cl=&applstcdwire=&exchgrtnclcd=&agrmtallotcl=&spmallcl=&spmallcd=&applformscrbtyp=&prcplncl=&supl_svc=&allot_prd=&_search=false&nd=1466060417940&rows=10&page=1&sidx=&sord=asc';
$data->fetch($dataUrl);
echo $data->results;

userCookie=&pw=mktk0313&CMD=1&gubun=T&login_id=mktraum1&scrt_num=mktk0313
 판매자 ID 또는 비밀번호가 올바르지 않습니다.  판매자ID찾기 / 비밀번호초기화 사용가능합니다.
$loginURL = 'https://tgatemng.sktelecom.com/main/login/loginAction.do?smsYn=Y&userCookie=&pw=mktk0313&CMD=1&gubun=T&login_id=mktraum1&scrt_num=mktk0313';
$loginVars = 'login_id=mktraum1&scrt_num=mktk0313!&gubun=T&CMD=1'; 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $loginURL); 
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $loginVars); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
$result = curl_exec($ch); 
echo $result;


//echo pwEncrypt('mktk0313');

$result = DB::query("SELECT * FROM tmFileStorage");

foreach($result as $val){
	$mbEmail = explode('_',$val['fsFileName']);
	$mbEmail = $mbEmail[0];
	list($mbName, $mbPhone) = DB::queryFirstList("SELECT mbName, mbPhone FROM tmMember WHERE mbEmail = %s", $mbEmail);
	echo $val['fsKey'];
	echo '<br/>';
	echo $fsFileName = $mbEmail.'_'.$mbName.'_'.$mbPhone.'_'.pwEncrypt($mbName.'mktk123123asd');
	echo '<br/>';
	//DB::delete("tmFileStorage", 'fsFileName = %s', $fsFileName);
	DB::update("tmFileStorage", array('fsFileName' => $fsFileName), 'fsKey = %i', $val['fsKey']);
	DB::update("tmPreorderNote7", array('fsKey' => $val['fsKey']), 'mbEmail = %s', $mbEmail);
}
*/


?>
