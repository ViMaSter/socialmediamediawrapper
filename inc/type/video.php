<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />

	<meta property="og:title" content="<?php echo $filename; ?>" />
	<meta property="og:type" content="video.other" />
	<meta property="og:video:url" content="<?php echo $directURL; ?>" />
	<meta property="og:video:type" content="<?php echo $type; ?>" />
	<meta property="og:url" content="<?php echo $canonialURL; ?>" />

	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="@ViMaSter" />
	<meta name="twitter:creator" content="@ViMaSter" />
	<meta name="twitter:description" content="<?php echo $filename; ?>" />

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
		body {
			background-color: black;
			width: 100vw;
  			height: 100vh;
  			display: flex;
		}
		video {
			max-width: 100vw;
  			max-height: 100vh;
  			margin: auto;
  			display: block;
		}
	</style>
</head>
<body>
	<video controls="" autoplay="" name="media"<?php echo !is_null($_GET["loop"])?" loop":"" ?>>
		<source src="<?php echo $directURL; ?>" type="video/mp4">
	</video>
</body>
</html>