<!DOCTYPE html>
<html>
<head>
	<meta name="_token" content="{{ csrf_token() }}"/>
	<base href="{{ asset('/') }}">
	<title>Plagiarism Checker DTU</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="DTU icon" href="images/DTU.ICO">
    <link href="asset/bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main-header">
  		<h1 class="logo header-chunk">
		  	<a href="/" class="large-screen-logo"></a>
		</h1>
	  	<nav class="header-chunk primary-nav fill-space priority-nav" id="secondary-primary-nav">
		    <ul>
		      	<li class="primary primary-pens" id="primary-nav-pens"><a href="/">Home</a></li>
		      	<li class="primary primary-posts"><a href="/">Plagiarism</a></li>
		      	<!-- <li class="primary primary-collections primary-last"><a href="/collections/">Collections</a></li>
		      	<li class="primary-spark"><a href="/spark/">Spark</a></li>
		      	<li class="primary-jobs"><a href="/jobs/">Jobs</a></li>
		      	<li class="primary-blog"><a href="http://blog.codepen.io/">Blog</a></li>
		      	<li class="primary-store"><a href="http://blog.codepen.io/store/">Store</a></li>
		        <li class="primary-pro"><a href="/pro/">Go <span class="badge badge-pro">PRO</span></a></li> -->
		    </ul>
	  	</nav>
	    <div class="header-chunk primary-actions old-header-buttons">
	      	<div class="multi-button">
	        	<!-- <a href="http://codepen.io/pen/" class="button button-medium new-pen-button">
	          		<span class="icon">
	            		+
	          		</span>
	          		New Pen
	        	</a> -->
	      	</div>
	    </div>
  		<div class="pen-templates-dropdown is-dropdown link-list" data-dropdown-position="css" id="pen-templates-dropdown"></div>

  
  		<div id="user-header-dropdown" class="user-stuff header-chunk">
    		<a id="login-button" class="button button-medium login-button" href="https://codepen.io/login">Log In</a>
    		<a href="/accounts/signup" class="button button-medium signup-button">Sign Up</a>
  		</div>
    	<div class="header-search header-chunk" id="header-search" role="search">
  			<a href="#0" class="header-search-button" id="header-search-button">
    			<svg class="header-icon-mag" width="25px" height="65px">
      				<use xlink:href="#mag"></use>
    			</svg>
 			</a>
		</div>
	</header>

	<header class="mega-header center">
  		<h1>PLAGIARISM CHECKER DTU</h1>
  		<p>Duy Tân University</p>
	</header>

	@yield('content')
	

	<script src="asset/js/jquery-1.11.2.min.js"></script>
	<script src="asset/bootstrap-3.3.6/js/bootstrap.min.js"></script>
	@yield('javascript')
</body>
</html>