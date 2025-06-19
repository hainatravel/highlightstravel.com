<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo empty($seo_title) ? 'Vietnam Travel Agency, tour with Asia Highlights-Since 1959' : $seo_title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta name="description" content="<?php echo empty($seo_description) ? false : $seo_description; ?>">
        <meta name="keywords" content="<?php echo empty($seo_keywords) ? false : $seo_keywords; ?>">
		<meta http-equiv="x-dns-prefetch-control" content="on">
		<?php 
		if(isset($detail)){
				if($detail->ic_type != 'pd_tour' && $detail->ic_type != 'pd_package'){
					if(!empty($detail->ic_photo)){
						//$url = 'https://www.asiahighlights.com'.$detail->ic_photo;
						//$imgobj = getimagesize($url);
						echo '<meta property="og:type" content="website" />';
						echo '<meta property="fb:admins" content="1665186613743391">';
						echo '<meta property="og:title" content="'.$seo_title.'" />';
						echo '<meta property="og:description" content="'.$seo_description.'" />';
						echo '<meta property="og:url" content="https://www.asiahighlights.com'.$detail->ic_url.'" />';
						echo '<meta property="og:site_name" content="Asia Highlights" />';
						echo '<meta property="article:publisher" content="https://www.asiahighlights.com" />';
						echo '<meta property="article:author" content="Asia Highlights" />';
						echo '<meta property="og:image" content="https://www.asiahighlights.com'.$detail->ic_photo.'"/>';
						echo '<meta property="og:image:secure_url" content="https://www.asiahighlights.com'.$detail->ic_photo.' "/>';
						echo '<meta property="og:image:width" content="800" />';
						echo '<meta property="og:image:height" content="500" />';
						echo '<meta property="og:image:alt" content="'.$detail->ic_url_title.'" />';
					}
			}
		}
		
		 ?>
		<?php  if (!empty($meta_addon_picture)) {?>
		<meta property="og:image" content="<?php echo $meta_addon_picture; ?>">
		<?php } ?>
		<link rel="dns-prefetch" href="//data.asiahighlights.com">
        <?php if (!empty($seo_url)) { ?>
            <link rel="canonical" href="https://www.asiahighlights.com<?php echo empty($canonical) ? $seo_url : $canonical; ?>">
        <?php } ?>
		
        <?php if (!empty($amp_url)) { ?>
            <link rel="amphtml" href="https://www.asiahighlights.com<?php echo $amp_url; ?>">
        <?php } ?>
		
        <link href="https://data.asiahighlights.com/min/?f=/js/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.css" rel="stylesheet">  
        <?php if (!empty($meta_addon_css)) { ?>
            <link href="https://data.asiahighlights.com/min/?f=<?php echo $meta_addon_css; ?>" rel="stylesheet">
        <?php } ?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-56CMWN3');</script>
		<!-- End Google Tag Manager -->
        <script src="https://data.asiahighlights.com/min/?f=/js/jquery-1.8.2.min.js,/js/bootstrap.min.js,/js/bootstrap-datepicker/bootstrap-datepicker.min.js,/js/typeahead.bundle.js,/js/basic.js,/js/jquery.form.min.js,/js/poshytip/jquery.poshytip.min.js,/js/jquery.sticky-kit.min.js"></script>
        <?php echo!empty($meta_addon_js) ? '<script language="JavaScript" src="https://data.asiahighlights.com/min/?f='.$meta_addon_js.'" type="text/javascript"></script>' : false; ?>
		<link rel="shortcut icon" href="https://www.asiahighlights.com/favicon.ico" />
        <style>
		.flowheader{
			position:fixed;
			width:100%;
			z-index:9999;
			background-color:#fff;
		}
		</style>
		<script>
            
            $(function() {
                if(IsPC()){                  
                    $(".dropdown-menu-ah-csk").mouseover(function() {
                        $(this).addClass('open');
                    }).mouseout(function() {
                        $(".dropdown-menu-ah-csk").removeClass('open');
                    });
                }
				
				$(window).on('scroll',function(){
					var top = $('html,body').scrollTop();
					if(top > 0){
						$('#header').addClass('flowheader');
						$('.menu').addClass('slideMenu');
						$('.flow-pic').removeClass('visible-xs');
						$('.top-pic').addClass('hide');
						$('.contactInfo').addClass('hide');
						$('.flow_about').removeClass('hide');
						$('.flow_createTrip').addClass('createTrip');
					}else if(top == 0){
						$('#header').removeClass('flowheader');
						$('.menu').removeClass('slideMenu');
						$('.top-pic').removeClass('hide');
						$('.flow-pic').addClass('visible-xs');
						$('.contactInfo').removeClass('hide');
						$('.flow_about').addClass('hide');
						$('.flow_createTrip').removeClass('createTrip');
					}
				});
				
				
				
				//展开所有天数行程
				$('.openall').click(function(){
					$('.dayTrip .collapse').addClass('in');
					$('.detail_collapse').removeClass('collapsed');
					$('.detail_collapse').removeClass('openAction');
					$('.detail_collapse').addClass('closeAction');
					$('.collapse').removeAttr('style');
					$('.collapse').attr('style','height:auto');
				});
				
				//关闭所有天数行程
				$('.closeall').click(function(){
					$('.collapse').removeClass('in');
					$('.detail_collapse').removeClass('closeAction');
					$('.detail_collapse').addClass('openAction');
				});
				
				//单天页面打开关闭
				$('.detail_collapse').click(function(){
					var flag = $(this).hasClass('collapsed');
					if(!flag){
						$(this).removeClass('closeAction');
						$(this).addClass('openAction');
					}else{
						$(this).removeClass('openAction');
						$(this).addClass('closeAction');
					}
				});
            });
        </script>
    </head>

    <body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-56CMWN3"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<header>
        <div id="header">
            <div class="container">
                <div class="row navbar-inverse" role="1navigation">
				<div class="navbar-header col-xs-4">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				  </div>
                    <div class="col-md-6 col-sm-6 col-xs-10 top-pic hidden-xs"><a href="/"><img src="https://data.asiahighlights.com/pic/logo-ah.png"  loader="nolazy" class="img-responsive" alt="Asia Highlights"></a></div>
					<div class="col-md-6 col-sm-6 col-xs-12 flow-pic visible-xs"><a href="/"><img src="https://data.asiahighlights.com/pic/ah-slide-logo.png"  loader="nolazy" class="img-responsive" alt="Asia Highlights"></a></div>
                    <?php if($_SERVER['REQUEST_URI'] != '/create-my-trip.htm'){?>
                    <div class="col-xs-8 tailorM">
					  <a href="/forms/tailormademobile">CUSTOMIZE</a>
					</div>
					<?php }?>
                    <div class="collapse navbar-collapse csk-overflow-y">
                        <div class="col-md-18 col-sm-18" id="mainNav">  
							<nav>
								<div class="menu">
									<?php
									$url = get_origin_url();
									$active_home = '';
									$active_guide = '';
									$active_tours = '';
									$active_mytrip = '';
									$active_aboutus = '';
									switch ($url) {
										case '/':
											$active_home = 'active';
											break;
										case '/guide/':
											$active_guide = 'active';
											break;
										case '/tours/':
											$active_tours = 'active';
											break;
										case '/create-my-trip.htm':
											$active_mytrip = 'active';
											break;
										case '/about-us.htm':
											$active_aboutus = 'active';
											break;
									}
									?>
									<a href="/" class="<?php echo $active_home; ?>">Home</a> 
								 <!--   <a href="/vietnam/" class="<?php echo $active_guide; ?>">Plan Your Trip</a> -->
									<li class="dropdown dropdown-menu-ah-csk" id="dropdown-menu-ah">
										<a href="#" class="dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Plan Your Trip<span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-ah" id="dropdown-menu-ah-box">
										  <li>
											<em><a href="/thailand/travel-guide">Thailand</a></em>
												<a href="/thailand/travel-guide" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/travel-guide/thailand/thailand-header.jpg" alt="Thailand" class="img-rounded">
												</a>
											</li>
											<li>
											<em><a href="/vietnam/travel-guide">Vietnam</a></em>
												<a href="/vietnam/travel-guide" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/ha-long-bay.jpg" alt="Ha Long Bay" class="img-rounded">
												</a>
											</li>
											<li>
											<em><a href="/india/travel-guide">India</a></em>
												<a href="/india/travel-guide" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/india-travel-guide.jpg" alt="india travel guide" class="img-rounded">
												</a>
											</li>
											<li>
												<em><a href="/japan/travel-guide">Japan</a></em>
												<a href="/japan/travel-guide" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/travel-guide/japan/traditional-japanese-ladies.jpg" alt="Traditional Japanese Ladies" class="img-rounded">
												</a>
											</li>
											<li>
											<em><a href="/myanmar/travel-guide">Myanmar</a></em>
												<a href="/myanmar/travel-guide" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/myanmar-monks.jpg" alt="myanmar" class="img-rounded">
												</a>
											</li>
											<li>
											
											<li>
											<em><a href="/cambodia/travel-guide">Cambodia</a></em>
												<a href="/cambodia/travel-guide" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/cambodia.jpg" alt="cambodia" class="img-rounded">
												</a>
											</li>
										   
											<li>
											<em><a href="/laos/travel-guide">Laos</a></em>
												<a href="/laos/travel-guide" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/laos.jpg" alt="Laos" class="img-rounded">
												</a>
											</li>
											<li>
											<em><a href="/tours/year.htm">Southeast Asia </a></em>
												<a href="/tours/year.htm" class="hidden-xs">
											   <img src="https://data.asiahighlights.com/image/hot-air-balloon-flight-over-bagan.jpg" alt="Hot-air-balloon Flight over Bagan" class="img-rounded">
												</a>
										  </li>
											 <li>
											<em><a href="/southeast-asia/ports-and-shore-excursions.htm">Arriving by Cruise</a></em>
												<a href="/southeast-asia/ports-and-shore-excursions.htm" class="hidden-xs">
													<img src="https://data.asiahighlights.com/image/bangkok-excursion.jpg" alt="Bangkok Excursion" class="img-rounded">
												</a>
											</li>
										</ul>
									</li>
									<li class="dropdown dropdown-menu-ah-csk">
										<a href="#" class="dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tours<span class="caret"></span></a>
										<ul class="dropdown-menu dropdown-menu-ah" id="dropdown-menu-ah-box">
										<li>
											<em><a href="/tours/">Top Asia Tours</a></em>
												<a href="/tours/" class="hidden-xs">
											   <img src="https://data.asiahighlights.com/image/wat-phra-singh.jpg" alt="wat phra singh" class="img-rounded">
												</a>
										  </li>
										  <li>
											<em><a href="/vietnam/tours/">Vietnam Tours</a></em>
												<a href="/vietnam/tours/" class="hidden-xs">
											   <img src="https://data.asiahighlights.com/image/vietnam.jpg" alt="Vietnam Lady" class="img-rounded">
												</a>
										  </li>
										  <li>
											<em><a href="/thailand/tours/">Thailand Tours</a></em>
												<a href="/thailand/tours/" class="hidden-xs">
											   <img src="https://data.asiahighlights.com/image/chiang-mai.jpg" alt="Chiang Mai" class="img-rounded">
												</a>
										  </li>
										  <li>
											<em><a href="/india/tours/">India Tours</a></em>
												<a href="/india/tours/" class="hidden-xs">
											   <img src="https://data.asiahighlights.com/image/india-tours.jpg" alt="india tours" class="img-rounded">
												</a>
										  </li>
										  <li>
											<em><a href="/myanmar/tours/">Myanmar Tours</a></em>
												<a href="/myanmar/tours/" class="hidden-xs">
											   <img src="https://data.asiahighlights.com/image/myanmar-lady.jpg" alt="Myanmar Lady" class="img-rounded">
												</a>
										  </li>
										  <li>
											<em><a href="/japan/tours/">Japan Tours</a></em>
												<a href="/japan/tours/" class="hidden-xs">
											   <img src="https://data.asiahighlights.com/image/miyajima-island-of-japan.jpg" alt="miyajima island" class="img-rounded">
												</a>
										  </li>
										
										</ul>
									</li>
									
									<a href="/about-us.htm" class="<?php echo $active_aboutus; ?>">About</a>
									<a href="/forms/tailormade?tourCode=<?php if(isset($pd_tour->CLI_NO)){echo $pd_tour->CLI_NO; } ?>" class="<?php echo $active_mytrip;?> flow_createTrip">Create My Trip</a>
									</div>
							</div>
						</nav>
                    </div>
                </div>
            </div>
        </div>	
	</header>		