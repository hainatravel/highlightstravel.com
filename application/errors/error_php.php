<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;display:none">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

</div>

<?php
ini_set('user_agent',$_SERVER['HTTP_USER_AGENT']);
Header("HTTP/1.1 404 Not Found"); 
echo file_get_contents("https://www.asiahighlights.com/page-not-found");
?>