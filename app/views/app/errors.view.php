<?php
if (!empty($errors)):
$errorCount = count($errors);
$lastError = array_pop($errors);
$errorCount--;
?>
<div id="action_errors">
<p><?php echo n($errorCount +1, t('Error'), t('Errors'))?>:</p>
<ul class="errors">
    <?php
    if ($errorCount != 0):?>
    <li><?php echo implode(';</li><li>', $errors)?>;</li>
    <?php endif?>
    <li><?php echo $lastError?>.</li>
</ul>
</div>
<?php
endif;
