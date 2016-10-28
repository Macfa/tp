<div class="nav-sub-wrap <?=$isSubNavActive?>">
	<div class="wrap">
		<ul class="nav-sub">
			<li class="snb-tit-wrap">
				<a href="/<?=$_GET['carrier']?>/all" class="snb-tit <?=$isSubAllActive?>" id="link-snb-all">
					<span>전체</span>	
				</a>
			</li><li class="snb-tit-wrap">
				<a href="/<?=$_GET['carrier']?>/samsung" class="snb-tit <?=$isSubSamsungActive?>" id="link-snb-samsung">
					<span>삼성</span>	
				</a>
			</li><li class="snb-tit-wrap">
				<a href="/<?=$_GET['carrier']?>/apple" class="snb-tit <?=$isSubAppleActive?>" id="link-snb-apple">
					<span>애플</span>	
				</a>
			</li><li class="snb-tit-wrap">
				<a href="/<?=$_GET['carrier']?>/lg" class="snb-tit <?=$isSubLgActive?>" id="link-snb-lg">
					<span>LG</span>	
				</a>
			</li><li class="snb-tit-wrap">
				<a href="/<?=$_GET['carrier']?>/etc" class="snb-tit <?=$isSubEtcActive?>" id="link-snb-etcManuf">
					<span>기타 제조사</span>	
				</a>
			</li>
		</ul>
	</div>
</div>