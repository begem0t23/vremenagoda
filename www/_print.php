<?php
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head> 
<meta	http-equiv="Content-Type"	content="charset=utf-8" />
    <style type="text/css">
	   
	  </style>
	  <script>

  window.onload=window.print();;
</script>
</head><body>
<?php

$pdf= $_POST['print'];
echo $pdf;

?>

</body></html>
