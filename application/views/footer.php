<footer>
	<div id="footer">
	  <div class="footTrust hidden-xs">
		<div class="container">
		  <div class="row">
			<div class="col-md-6 col-sm-6">
			  <div class="trustList"> <span class="trustTitle">AUTHENTIC</span>
				<ul>
				  <li>Your itinerary is 100% tailor-made for you.</li>
				  <li>Your entire journey is made at your own pace.</li>
				  <li>Unique experiences are designed to match your interests.</li>
				</ul>
			  </div>
			</div>
			<div class="col-md-6 col-sm-6">
			  <div class="trustList"> <span class="trustTitle">ASIA-BASED</span>
				<ul>
				  <li>Our Asia-based specialists maintain current first-hand knowledge.</li>
				  <li>We select the best local guides, to high standards.</li>
				  <li>Our reliable customer-care team supports you 24/7.</li>
				</ul>
			  </div>
			</div>
			<div class="col-md-6 col-sm-6">
			  <div class="trustList"> <span class="trustTitle">TRUSTED</span>
				<ul>
				  <li>Began in China, tried and tested over 20 years.</li>
				  <li>Rated 4.8 out of 5 on TRUSTPILOT.</li>
				  <li>Rated 5 out of 5 on TripAdvisor.</li>
				</ul>
			  </div>
			</div>
			<div class="col-md-6 col-sm-6">
			  <div class="trustList"> <span class="trustTitle">PROTECTED</span>
				<ul>
				  <li>Money-back guarantee.</li>
				</ul>
				<span class="img-responsive"><img src="/pic/member-icons.png"></span> </div>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="mainFooter">
		<div class="container">
		  <div class="featuredIn"><img class="img-responsive" src="/pic/featured-in-icons.png"></div>
		  <div class="footLinks">
			<div class="row">
			  <div class="col-md-5 col-sm-5"><span class="linkTitle">Destinations</span>
				<ul>
				  <li><a href="/thailand/tours/">Thailand</a></li>
				  <li><a href="/vietnam/tours/">Vietnam</a></li>
                  <li><a href="/india/tours/">India</a></li>
				  <li><a href="/japan/tours/">Japan</a></li>         
				  <li><a href="/myanmar/tours/">Myanmar</a></li>
				</ul>
			  </div>
			  <div class="col-md-5 col-sm-5"><span class="linkTitle">About</span>
				<ul>
				  <li><a href="/about-us.htm">About Us</a></li>
				  <li><a href="/about-us/history.htm">History</a></li>
				  <li><a href="/about-us/our-differences.htm">Our Differences</a></li>
				  <li><a href="/contact-us.htm">Contact Us</a></li>
				</ul>
			  </div>
			  <div class="col-md-5 col-sm-5"><span class="linkTitle">Connected</span>
				<p>Travelling with us? Tag your travels with #asiahighlights and you may be featured.</p>
				<span class="followUs">Follow us <a class="fb fa fa-facebook" title="Follow us on Facebook" rel="nofollow" href="https://www.facebook.com/AsiaHighlights"  target="_blank"></a><a class="tw fa fa-twitter" title="Share us on Twitter" rel="nofollow" href="https://twitter.com/Asiahighlights"  target="_blank"></a></span> </div>
			  <div class="col-md-9 col-sm-9 trustPilotIconBig">
			  <a href="https://www.trustpilot.com/review/asiahighlights.com" target="_blank"><img class="img-responsive" src="https://data.asiahighlights.com/image/trustpilot-5stars.png"></a>
			  <a href="https://www.trustpilot.com/review/asiahighlights.com" target="_blank">Rated 4.8 out of 5 | Excellent</a>
			  </div>
			</div>
		  </div>
		  <div class="copyRight">
		  <span class="crInfo">Copyright &copy; <?php echo date('Y',time());?> Asia Highlights.</span>
		   <span class="hidden-xs privacyLinks"><a href="/privacy.htm">Privacy policy</a> <a href="/terms-of-use.htm">Terms of use</a></div>
		</div>
	  </div>
	</div>
</footer>



<?php if(!empty($detail)){ if($detail->ic_ht_area_type != 'pd'){?>
<script type="application/ld+json">{"@context": "http://schema.org","@type": "NewsArticle","@id": "https://www.asiahighlights.com<?php echo $detail->ic_url;?>","mainEntityOfPage": [{
  "@type": "WebPage","@id": "https://google.com/article"}],"headline": "<?php echo $detail->ic_title?>","author": [{"@type": "Person","name": "<?php echo $detail->OPI2_FirstName.$detail->OPI2_LastName;?>"
  }],"description": "<?php echo $detail->ic_seo_description?>", "image": [{"@type": "ImageObject","url": "https://data.asiahighlights.com/pic/logo-ah.png", "width": "238","height": "117"
  }], "publisher": [{ "@type": "Organization", "name": "Asia Highlights","logo": [{"@type": "ImageObject", "url": "https://data.asiahighlights.com/pic/logo-ah.png", "width": "238", "height": "117"}] }],"datePublished": "<?php echo $detail->is_datetime;?>","dateModified": "<?php echo $detail->ic_datetime;?>"
}
</script>
<?php }}?>
<?php 
if(!empty($detail->construct_tag)){
	echo $detail->construct_tag;
}
?>
<script type="text/javascript">
$.ajax({url:'/ip/' , dataType: 'json', success: function(data){if(data.country_code!=='CN' && data.country_code!=='-'){var e = document.createElement("script"),n = document.getElementsByTagName("body")[0];e.setAttribute("type", "text/javascript"),e.setAttribute("async", "async"),e.setAttribute("src", "//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-598408c3e2fb90c3"),n.appendChild(e);}}});
</script>

<script>eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}('8.R=10;(4(){3 h=b 26();4 11(X){8.R=X&&X.1I===\'1b\'?h.1V==1:10;1c()}h.1T=11;h.1Z=11;h.S=\'1M:1R/1x;1F,1Q/1P=\'})();5(!c.g){c.g=(4(){3 1u=y.M.1S;3 P=4(l){6 I l==="4"||1u.Q(l)==="[19 1L]"};3 1j=4(D){3 f=1O(D);5(1N(f)){6 0}5(f===0||!1Y(f)){6 f}6(f>0?1:-1)*o.1X(o.20(f))};3 1y=o.1U(2,1W)-1;3 1a=4(D){3 9=1j(D);6 o.1G(o.1H(9,0),1y)};6 4 g(J){3 C=E;3 U=y(J);5(J==p){F b H("c.g 1K 1J 1E-1D 19 - V p 1k B")}3 n=j.m>1?j[1]:2o B;3 T;5(I n!=="B"){5(!P(n)){F b H("c.g: 2q 2j, 2i 2k 2l 2m 2n a 4")}5(j.m>2){T=j[2]}}3 9=1a(U.m);3 A=P(C)?y(b C(9)):b c(9);3 k=0;3 d;1l(k<9){d=U[k];5(n){A[k]=I T==="B"?n(d,k):n.Q(T,d,k)}z{A[k]=d}k+=1}A.m=9;6 A}}())}5(!c.M.v){c.M.v=4(u){3 T,k;5(E==p){F b H("E 1i p 1k V 2p")}3 O=y(E);3 9=O.m>>>0;5(I u!=="4"){F b H(u+" 1i V a 4")}5(j.m>1){T=j[1]}k=0;1l(k<9){3 d;5(k 13 O){d=O[k];u.Q(T,d,k,O)}k++}}}4 1c(2h){3 14=4(i){i.W("1b",4(){i.r.q=1});5(8.R){i.1z("S",i.1B("1A").25(\'.28\',\'.1x\'))}z{i.1z("S",i.1B("1A"))}};3 1p=c.g(e.1q("h[1C=27]"));1p.v(4(7,Y){7.r.q=0;7.r.1w="q 0.18 1e-13-1m";14(7)});3 w=1o();w();4 12(l,1s,1v){3 N=p,L=b 1r();6 4(){3 K=b 1r();22(N);5(K-L>=1v){l();L=K}z{N=21(l,1s)}}}4 1h(1n){3 16=1n.24();6{15:16.15+8.23-e.t.2e,1t:16.1t+8.2d-e.t.2g}}4 1o(){3 G=c.g(e.1q("h[1C=2f]"));G.v(4(7,Y){7.r.q=0;7.r.1w="q 0.18 1e-13-1m"});6 4(){3 1g=8.2a;3 x=(e.t&&e.t.x)||(e.1d&&e.1d.x);G=G.29(4(7,Y){3 1f=1h(7).15;3 Z=1f<1g+x;5(Z){14(7)}6!Z})}}5(8.W){8.W("2c",12(w,s,s),10)}z{5(8.17){8.17("2b",12(w,s,s))}}};',62,151,'|||var|function|if|return|element|window|len||new|Array|kValue|document|number|from|img|target|arguments||fn|length|mapFn|Math|null|opacity|style|500|documentElement|callback|forEach|lazyloader|scrollTop|Object|else||undefined||value|this|throw|lazyImageList|TypeError|typeof|arrayLike|curTime|startTime|prototype|timeout||isCallable|call|isSupportWebp|src||items|not|addEventListener|event|index|hasVisible|false|getResult|throttle|in|loadImageByUrl|top|box|attachEvent|5s|object|toLength|load|createImageLoader|body|ease|offsetTop|seeHeight|getOffset|is|toInteger|or|while|out|el|createLazyloader|imageList|querySelectorAll|Date|delay|left|toStr|atleast|transition|webp|maxSafeInteger|setAttribute|originalsrc|getAttribute|loader|like|array|base64|min|max|type|an|requires|Function|data|isNaN|Number|vuUAAA|UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA|image|toString|onerror|pow|width|53|floor|isFinite|onload|abs|setTimeout|clearTimeout|pageYOffset|getBoundingClientRect|replace|Image|ready|jpg|filter|innerHeight|onscroll|scroll|pageXOffset|clientTop|lazy|clientLeft|settings|the|provided|second|argument|must|be|void|defined|when'.split('|'),0,{}))
</script>
</body>
</html>



