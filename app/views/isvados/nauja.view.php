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
    if (isset($isvada['id'])):
        ?>
        <input type="hidden" name="id" value="<?php echo $isvada['id']?>" />
        <?php
    endif;
    ?>
    <label for="isvada"><?php echo t('Išvada')?></label><br/>
    <textarea rows="20" cols="60" id="isvada" class="editor" name="isvada"><?php echo (isset($isvada['isvada']) ? $isvada['isvada'] : null)?></textarea>
    <br/>
    <input type="submit" value="<?php echo t("Saugoti")?>" />
</form>
<script>
$(function(){
    $('#date').datepicker($.datepicker.regional['lt']);
});
</script>