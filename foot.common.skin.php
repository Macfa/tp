<?php if($cfg['isDev'] !== true) :?>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-50392756-4', 'auto');
	ga('require', 'linkid', 'linkid.js');
	ga('send', 'pageview');
	</script>
	<script type="text/javascript" src="http://wcs.naver.net/wcslog.js"></script> 
	<script type="text/javascript"> if(!wcs_add) var wcs_add = {}; wcs_add["wa"] = "15caf96a92fd0a8"; wcs_do(); </script>
	<script type="text/javascript">
	if(!wcs_add) var wcs_add = {};
	wcs_add["wa"] = "dcc9fbe2d0ac48";
	wcs_do();
	</script>
	<script>
	(function(h,o,t,j,a,r){
		h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		h._hjSettings={hjid:219919,hjsv:5};
		a=o.getElementsByTagName('head')[0];
		r=o.createElement('script');r.async=1;
		r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		a.appendChild(r);
	})(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
	</script>
	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','https://connect.facebook.net/en_US/fbevents.js');

	fbq('init', '1044525538935836');
	fbq('track', "PageView");</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1044525538935836&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
	<!--[if lt IE 9]>
	 <script src="<?=PATH_JS_LIB?>/outdatedbrowser.js"></script>
	<![endif]-->
<?php endif?>
<script type="text/javascript" src="<?=PATH_JS_LIB?>/require.js"></script>
<script>
   var require = {
        baseUrl: '<?=PATH_JS_LIB?>'
    };
</script>
<?php $import->importJS(); ?>
<?=$js_file?>
</body>
</html>