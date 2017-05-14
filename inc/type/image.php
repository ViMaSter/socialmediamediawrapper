<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />

	<meta itemprop="image" content="<?php echo $directURL; ?>" />

	<meta property="og:title" content="<?php echo $filename; ?>" />
	<meta property="og:type" content="instapp:photo"<?php /* workaround for facebook */ ?> />

	<meta property="og:url" content="<?php echo $canonialURL ?>" />
	<meta property="og:image" content="<?php echo $directURL; ?>" />

	<meta name="medium" content="image" />

	<meta name="twitter:card" content="photo" />
	<meta name="twitter:site" content="@ViMaSter" />
	<meta name="twitter:creator" content="@ViMaSter" />
	<meta name="twitter:image" content="<?php echo $directURL; ?>" />

	<title><?php echo $filename; ?></title>
	<style type="text/css">
	/*	
		http://meyerweb.com/eric/tools/css/reset/ 
   		v2.0 | 20110126
   		License: none (public domain)
	*/
	a,abbr,acronym,address,applet,article,aside,audio,b,big,blockquote,body,canvas,caption,center,cite,code,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,header,hgroup,html,i,iframe,img,ins,kbd,label,legend,li,mark,menu,nav,object,ol,output,p,pre,q,ruby,s,samp,section,small,span,strike,strong,sub,summary,sup,table,tbody,td,tfoot,th,thead,time,tr,tt,u,ul,var,video{margin:0;padding:0;border:0;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:after,blockquote:before,q:after,q:before{content:'';content:none}table{border-collapse:collapse;border-spacing:0}
	</style>
	<style type="text/css">
	body
	{
	    background: #0e0e0e;
	    width: 100vw;
	    height: 100vh;
	    display: table-cell;
	    vertical-align: middle;
	    text-align: center;
	}
	.centered
	{
	    max-width: 100vw;
		max-height: 100vh;
	}
	</style>
</head>
<body>
	<img src="<?php echo $directURL; ?>" alt="" class="centered" onclick="toggleFullscreen(this)">
	<script type="text/javascript">
	function toggleFullscreen(element)
	{
		element.classList.toggle('centered');
	}
	</script>
</body>
</html>