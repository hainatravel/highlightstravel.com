<ul class="ArticleList">
	<?php if(!empty($parent->ic_content)){?>
		 <li><a href="<?php echo $parent->ic_url;?>" title="<?php echo $parent->ic_url_title;?>"><?php echo $parent->ic_url_title;?></a></li>
	<?php }?>
  <?php  foreach ($same_level as $key=>$v){?>
    <li class="<?php echo $key===0?"":"";?>"><a href="<?php echo $v->ic_url;?>" title="<?php echo $v->ic_url_title;?>"><?php echo $v->ic_url_title;?></a></li>
  <?php  }?>

</ul>
<script>
$(function(){
    var purl = window.location.pathname || '';
	if(purl == ''){
		return false;
	}
	$.ajax({
		url:'/ajax_get/getads/',
		type:'POST',
		data:{murl:purl},
		error:function(){
			console.log('err 500');
		},
		success:function(obj){
			if(obj == 'err'){
				return false;
			}
			if(typeof obj.left_nav_top != 'undefined'){
				$('.ArticleList').prepend(obj.left_nav_top.content);
			}
			if(typeof obj.left_nav_bottom != 'undefined'){
				$('.ArticleList').append(obj.left_nav_bottom.content);
			}
		}
	});
})
</script>