<a href="<?php echo $here?>naujas">Naujas</a>
<?php
if ($klausimai) {
	echo '<table>';
	echo html__table::tableHeaders(array('ID', 'Klausimas', 'Atsakymas taip', 'Atsakymas ne', 'Veiksmai'));
	foreach($klausimai as $klausimas) {
		if ($klausimas['taip_isvados_id'] > 0) {
			$taip = '<b><i>Išvada</i></b>: ' . $isvados[$klausimas['taip_isvados_id']]['isvada'];
		} else {
			$taip = '<b>Klausimas</b>: ' . $klausimai[$klausimas['taip_id']]['klausimas'];
		}
		
		if ($klausimas['ne_isvados_id'] > 0) {
			$ne = '<b><i>Išvada</i></b>: ' . $isvados[$klausimas['ne_isvados_id']]['isvada'];
		} else {
			$ne = '<b>Klausimas</b>: ' . $klausimai[$klausimas['ne_id']]['klausimas'];
		}
		
		echo html__table::tableData(array(
			$klausimas['id'],
			$klausimas['klausimas'],
			$taip,
			$ne,
			'<a href="'.$here.'redaguoti?id='.$klausimas['id'].'">redaguoti</a> <a href="'.$here.'trinti?id='.$klausimas['id'].'" onclick="return confirm(\'Ar tikrai norite ištrinti klausimą?\')">trinti</a>'
		));
	}
	echo '</table>';
}