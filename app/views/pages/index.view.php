<?php
echo $klausimas['klausimas'];
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
<div id="error"></div>
<form method="post" action="?">
	<input type="hidden" name="klausimo_id" value="<?php echo $klausimas['id']?>" />
	<input type="radio" name="atsakymas" value="taip" id="taip" /> <label for="taip">Taip</label><br/>
	<input type="radio" name="atsakymas" value="ne" id="ne" /> <label for="ne">Ne</label><br/>
	<input type="submit" value="Toliau" onclick="return validates();" />
</form>
<script>
function validates()
{
	checkedValue = $('input[name=atsakymas]:checked').val();
	if (checkedValue == 'taip' || checkedValue == 'ne') {
		return true;
	} else {
		$('#error').html('Turite pažymėti atsakymą, kad galėtumėme jums padėti diagnozuoti problemą.');
		return false;
	}
}
</script>