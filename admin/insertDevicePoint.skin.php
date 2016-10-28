<div class="wrap">
<h1>요금제/가입유형 별 지급 포인트 설정</h1>
1= 신규, 2=번이 6-기변
<br/>
1= 공시지원금, 2=선택약정
<br/>
<pre>
array(0 => 'T시그니쳐 Master // band 데이터 100',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1 => 'T시그니쳐 Classic // band 데이터 80', 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2 => 'band 데이터 퍼펙트S // band 데이터 69',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3 => 'band 데이터 퍼펙트 // band 데이터 59',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4 => 'band 데이터 6.5G // band 데이터 51',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5 => 'band 데이터 3.5G // band 데이터 47', 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6 => 'band 데이터 2.2G // band 데이터 42', 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7 => 'band 데이터 1.2G // band 데이터 36', 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8 => 'band 데이터 세이브 // band 데이터 29'
<Br/><Br/>
array(9 => 'T 키즈안심(판매안함)',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10 => 'T 키즈전용');
<Br/><Br/>
array(11 => 'T 아웃도어(공유)',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12 => 'T 아웃도어(단독)');
<Br/><Br/>								
array(13 => 'T 포켓파이 10',	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14 => 'T 포켓파이 20');
<Br/><Br/>
<h1>KT요금제</h1>
array(15 => 'LTE 데이터 선택 109',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;16 => 'LTE 데이터 선택 76.8', 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;17 => 'LTE 데이터 선택 65.8',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18 => 'LTE 데이터 선택 54.8',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19 => 'LTE 데이터 선택 49.3',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20 => 'LTE 데이터 선택 43.8',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;23 => 'LTE 데이터 선택 38.3',
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;24 => 'LTE 데이터 선택 32.8')

<Br/><Br/>
</pre>
<Br/><Br/><Br/>
<ul>
	<?php 
	foreach ($incList['deviceResults'] as $deviceRow) : 	
		$child=array();
		$child = DB::query("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i", $deviceRow['dvKey']);
		$childCount = DB::count();
		$isExistChild = ($childCount>0)?TRUE:FALSE;
	?>
	<li style="margin-bottom:15px">
			<?php if ($isExistChild === FALSE) :?>
			<div>
				<?php echo $deviceRow['dvTit']?> = <?php echo $deviceRow['dvKey']?>
			</div>
			<?php endif?>
			<?php foreach ($child as $childRow) : ?>
			<div>
				<?php echo $deviceRow['dvTit'].' '.$childRow['dvTit']?> = <?php echo $childRow['dvKey']?>
			</div>
			<?php endforeach?>
	</li>
	<?php endforeach?>
</ul>
</div>