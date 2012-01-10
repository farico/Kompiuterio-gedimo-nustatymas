<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" src="/editor/ckeditor.js"></script>
<script type="text/javascript" src="/editor/adapters/jquery.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function()
{
var config = {
        toolbar:
        [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
                ['UIColor']
        ]
};

// Initialize the editor.
// Callback function can be passed and executed after full instance creation.
$('.editor').ckeditor(config);
});
//]]>
</script>
<?php
$this->display('app/errors');
?>
<form method="post" action="?">
    <?php
    if (isset($klausimas['id'])):
        ?>
        <input type="hidden" name="id" value="<?php echo $klausimas['id']?>" />
        <?php
    endif;
    ?>
    <label for="klausimas"><?php echo t('Klausimas')?></label><br/>
    <textarea rows="20" cols="60" id="klausimas" class="editor" name="klausimas"><?php echo (isset($klausimas['klausimas']) ? $klausimas['klausimas'] : null)?></textarea><br/>
	<label for="taip"><?php echo t('Jeigu taip')?></label><br/>
	<div style="display:inline">
		<select name="taip_id" id="taip">
			<option>-- klausimas --</option>
			<?php
			foreach ($klausimai as $kitas):?>
				<option value="<?php echo $kitas['id']?>"<?php echo (isset($klausimas['id']) && $klausimas['taip_id'] == $kitas['id'] ? ' selected="selected"':null)?>><?php echo $kitas['klausimas']?></option>
			<?php
			endforeach;
			?>
		</select><br/><br/>
		<label for="ne"><?php echo t('Jeigu ne')?></label><br/>
		<select name="ne_id" id="ne">
			<option>-- klausimas --</option>
			<?php
			foreach ($klausimai as $kitas):?>
				<option value="<?php echo $kitas['id']?>"<?php echo (isset($klausimas['id']) && $klausimas['ne_id'] == $kitas['id'] ? ' selected="selected"':null)?>><?php echo $kitas['klausimas']?></option>
			<?php
			endforeach;
			?>
		</select><br/><br/>
	</div>
	<div style="display:inline">
		<label for="isvada_taip"><?php echo t('Išvada taip')?></label><br/>
		<select name="taip_isvados_id" id="isvada_taip">
			<option>-- išvada --</option>
			<?php
			foreach ($isvados as $isvada):?>
				<option value="<?php echo $isvada['id']?>"<?php echo (isset($isvada['id']) && $isvada['id'] == $klausimas['taip_isvados_id'] ? ' selected="selected"':null)?>><?php echo $isvada['isvada']?></option>
			<?php
			endforeach;
			?>
		</select><br/><br/>
		<label for="isvada_ne"><?php echo t('Išvada ne')?></label><br/>
		<select name="ne_isvados_id" id="isvada_ne">
			<option>-- išvada --</option>
			<?php
			foreach ($isvados as $isvada):?>
				<option value="<?php echo $isvada['id']?>"<?php echo (isset($isvada['id']) && $isvada['id'] == $klausimas['ne_isvados_id'] ? ' selected="selected"':null)?>><?php echo $isvada['isvada']?></option>
			<?php
			endforeach;
			?>
		</select><br/><br/>
	</div>
    <input type="submit" value="<?php echo t("Saugoti")?>" />
</form>