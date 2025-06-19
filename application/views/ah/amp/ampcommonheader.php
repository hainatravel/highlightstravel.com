<!-- Start Navbar -->
<header class="ampstart-headerbar  flex justify-start items-center top-0 left-0 right-0 pl2 pr4 pt2 md-pt0">
  <div role="button" aria-label="open sidebar" on="tap:header-sidebar.toggle" tabindex="0" class="ampstart-navbar-trigger  pr2 absolute top-0 pr0 mr2 mt2"><svg xmlns="//www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" class="block">
    <path fill="none" d="M0 0h24v24H0z"></path>
    <path fill="currentColor" d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
    </svg> </div>
  <a href="/" class="text-decoration-none inline-block mx-auto ampstart-headerbar-home-link mb1 md-mb0 ">
  <amp-img src="https://data.asiahighlights.com/pic/ah-slide-logo.png" width="178" height="45" layout="fixed" class="my0 mx-auto"></amp-img>
  </a>
  <div class="ampstart-headerbar-fixed center m0 p0 flex justify-center nowrap absolute top-0 right-0 pt2 pr3">
    <div class="mr2"> </div>
    <a href="/forms/tailormademobile" class="tailorM"> CUSTOMIZE </a> </div>
</header>

<!-- Start Sidebar -->
<amp-sidebar id="header-sidebar" class="ampstart-sidebar px3  md-flex flex-column justify-content items-center justify-center" layout="nodisplay">
  <div class="flex justify-start items-center ampstart-sidebar-header">
    <div role="button" aria-label="close sidebar" on="tap:header-sidebar.toggle" tabindex="0" class="ampstart-navbar-trigger items-start">✕</div>
  </div>
  <nav class="ampstart-sidebar-nav ampstart-nav ">
    <ul class="list-reset m0 p0 ampstart-label">
      <li class="logo"> <a href="/" class="text-decoration-none block">
        <amp-img src="https://data.asiahighlights.com/pic/ah-slide-logo.png" width="178" height="45" layout="responsive" class="ampstart-sidebar-nav-image inline-block mb4" alt="Company logo" noloading="">
          <div placeholder="" class="commerce-loader"></div>
        </amp-img>
        </a> </li>
		<li class="ampstart-nav-item m0 p0"><a class="ampstart-nav-link" href="/">HOME</a></li>
      <li class="ampstart-nav-item">

  
<amp-accordion>
  <section>
    <h3 class="ampstart-nav-link amphtml-accordion-header">PLAN YOUR TRIP <i class="fa fa-angle-right" aria-hidden="true"></i></h3>
		<ul class="ampstart-dropdown-items list-reset m0 p0 ">
            <li ><a href="/thailand/travel-guide" >THAILAND</a></li>
            <li ><a href="/vietnam/travel-guide" >VIETNAM</a></li>
			<li ><a href="/myanmar/travel-guide" >MYANMAR</a></li>
            <li ><a href="/india/travel-guide" >INDIA</a></li>
			<li ><a href="/japan/travel-guide" >JAPAN</a></li>
			<li ><a href="/cambodia/travel-guide" >CAMBODIA</a></li>
			<li ><a href="/laos/travel-guide" >LAOS</a></li>
			<li ><a href="/tours/year.htm" >SOUTHEAST ASIA</a></li>
			<li ><a href="/southeast-asia/ports-and-shore-excursions.htm" >ARRIVING BY CRUISE</a></li>
		</ul>
  </section>
</amp-accordion>
	 
	  
	  </li> 
      <li class="ampstart-nav-item">
<amp-accordion>
  <section>
    <h3 class="ampstart-nav-link amphtml-accordion-header">TOURS <i class="fa fa-angle-right" aria-hidden="true"></i></h3>
		<ul class="ampstart-dropdown-items list-reset m0 p0">
		  <li ><a href="/tours/" >TOP ASIA TOURS</a></li>
		  <li ><a href="/thailand/tours/" >THAILAND TOURS</a></li>
		  <li ><a href="/india/tours/" >INDIA TOURS</a></li>
		  <li ><a href="/vietnam/tours/" >VIETNAM TOURS</a></li>
		  <li ><a href="/japan/tours/" >JAPAN TOURS</a></li>
		  <li ><a href="/myanmar/tours/" >MYANMAR TOURS</a></li>
		</ul>
  </section>
</amp-accordion>
	  </li>
      <li class="ampstart-nav-item "><a class="ampstart-nav-link" href="/about-us.htm">ABOUT</a></li>
      <li class="ampstart-nav-item "><a class="ampstart-nav-link" href="/forms/tailormademobile?tourCode=<?php if(isset($pd_tour->CLI_NO)){echo $pd_tour->CLI_NO; } ?>">CREAT MY TRIP</a></li>
    </ul>
  </nav>
  <span class="socialLink"><a class="fb fa fa-facebook" title="Follow us on Facebook" rel="nofollow" href="https://www.facebook.com/AsiaHighlights"></a><a class="tw fa fa-twitter" title="Share us on Twitter" rel="nofollow" href="https://twitter.com/Asiahighlights"></a></span>

</amp-sidebar>
<!-- End Sidebar --> 
<!-- End Navbar -->