<?php if($_GET['carrier']== 'kt'): ?>

<div class="nav-device-wrap <?php echo $deviceNavActive?>">
	<div class="wrap">
		<ul class="nav-device">
			<li class="nav-device-item ">
				<a href="/page/galaxys7Apply.php" class="nav-device-item-wrap" id="link-snb-device-galaxys7">
					<i class="ico-device-galaxy"></i>
					<span class="nav-device-tit">갤럭시 S7 </span>
				</a>
			</li><li class="nav-device-item ">
				<a href="/page/galaxys7Apply.php" class="nav-device-item-wrap" id="link-snb-device-galaxys7edge">
					<i class="ico-device-galaxy"></i>
					<span class="nav-device-tit">갤럭시 S7 엣지 </span>
				</a>
			</li><li class="nav-device-item">			
				<a href="/product/egg.php" class="nav-device-item-wrap" id="link-snb-device-egg">
					<i class="ico-device-portable-wifim"></i>
					<span class="nav-device-tit">egg</span>
				</a>
			</li><li class="nav-device-item">			
				<a href="/page/preorderV20Apply.php" class="nav-device-item-wrap" id="link-snb-device-v20">
					<i class="ico-device-lg"></i>
					<span class="nav-device-tit">V20</span>
				</a>
			</li>
		</ul>
	</div>
</div>

<?php else :?>
<div class="nav-device-wrap <?php echo $deviceNavActive?>">
	<div class="wrap">
		<ul class="nav-device">


			<?php foreach ($deviceNavResult as $deviceNavRow) :?>
			<li class="nav-device-item <?php echo $deviceNavItemActive[$deviceNavRow['dvId']]?>">
				<a href="<?=$cfg['path']?>/device/<?php echo $deviceNavRow['dvId']?>" class="nav-device-item-wrap" id="link-snb-device-<?php echo $deviceNavRow['dvId']?>">
					<i class="ico-device-<?php echo $deviceNavRow['dvIcon']?>"></i>
					<span class="nav-device-tit"><?php echo $deviceNavRow['dvTit']?></span>
				</a>
			</li>
			<?php endforeach?>

			<?php if (($_GET['carrier']== 'sk' && $_GET['manuf'] == 'all') || ($_GET['carrier']== 'sk' && $_GET['manuf'] == '') || ($_GET['carrier']== 'sk' && $_GET['manuf'] == 'lg') || $_GET['manuf'] == 'lg' || $device['dvManuf']=== 'lg'):?>
			<li class="nav-device-item">			
				<a href="<?=$cfg['path']?>/page/preorderV20.php" class="nav-device-item-wrap" id="link-snb-device-v20">
					<i class="ico-device-lg"></i>
					<span class="nav-device-tit">V20</span>
				</a>
			</li>
			<?php endif?>
			<?php if (($_GET['carrier']== 'sk' && $_GET['manuf'] == 'all') || ($_GET['carrier']== 'sk' && $_GET['manuf'] == '') || ($_GET['carrier']== 'sk' && $_GET['manuf'] == 'samsung') || $_GET['manuf'] == 'samsung' 
						|| $device['dvManuf']=== 'samsung' ):?>
			<li class="nav-device-item">
				<a href="<?=$cfg['path']?>/page/preOrderNote7.php" class="nav-device-item-wrap" id="link-snb-device-v20">
					<i class="ico-device-galaxy"></i>
					<span class="nav-device-tit">갤럭시 노트7</span>
				</a>
			</li>
			<?php endif?>
		</ul>
	</div>
</div>
<?php endif?>