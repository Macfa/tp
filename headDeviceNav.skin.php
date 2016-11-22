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
		</ul>
	</div>
</div>