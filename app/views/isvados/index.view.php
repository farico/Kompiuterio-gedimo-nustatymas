<a href="<?php echo $here?>nauja">Nauja</a>
<?php
if ($isvados) {
	echo '<table>';
	echo html__table::tableHeaders(array('ID', 'Išvada', 'Veiksmai'));
	foreach($isvados as $isvada) {
		echo html__table::tableData(array(
			$isvada['id'],
			$isvada['isvada'],
			'<a href="'.$here.'redaguoti?id='.$isvada['id'].'">redaguoti</a> <a href="'.$here.'trinti?id='.$isvada['id'].'" onclick="return confirm(\'Ar tikrai norite ištrinti klausimą?\')">trinti</a>'
		));
	}
	echo '</table>';
}