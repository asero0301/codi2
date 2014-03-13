<?
$mem_name = $_REQUEST['mem_name'];
$mem_key = $_REQUEST['mem_key'];
$mem_jumin = $_REQUEST['mem_jumin'];
?>

<form name="frm" method="post" action="mobile_gateway.php">
<input type="hidden" name="mem_name" id="mem_name" value="<?=$mem_name?>" />
<input type="hidden" name="mem_key" id="mem_key" value="<?=$mem_key?>" />
<input type="hidden" name="mem_jumin" id="mem_jumin" value="<?=$mem_jumin?>" />
</form>
<script>
document.frm.submit();
</script>