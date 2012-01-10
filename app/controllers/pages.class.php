<?php

/**
 * Description of pages
 * @author Aivaras Voveris <aivaras@activesec.eu>
 * @since Jan 10, 2012
 */
class pages__pages extends page
{    
    public function index()
    {
		if (!empty($_POST)) {
			if (in_array($_POST['atsakymas'], array('taip', 'ne'))) {
				if ($_POST['atsakymas'] == 'taip') {
					$klausimas = $this->db->fetch("SELECT taip_id, taip_isvados_id FROM klausimai WHERE id = " . (int)$_POST['klausimo_id']);
					if ($klausimas['taip_isvados_id'] > 0) {
						$this->_redirect($this->_self . 'isvada?id=' . $klausimas['taip_isvados_id']);
					} else {
						$klausimas = $this->db->fetch("SELECT id, klausimas FROM klausimai WHERE id = " . $klausimas['taip_id']);
					}
				} else {
					$klausimas = $this->db->fetch("SELECT ne_id, ne_isvados_id FROM klausimai WHERE id = " . (int)$_POST['klausimo_id']);
					if ($klausimas['ne_isvados_id'] > 0) {
						$this->_redirect($this->_self . 'isvada?id=' . $klausimas['ne_isvados_id']);
					} else {
						$klausimas = $this->db->fetch("SELECT id, klausimas FROM klausimai WHERE id = " . $klausimas['ne_id']);
					}
				}
			}
		}
		
		if (!$klausimas) {
			$klausimas = $this->db->fetch("SELECT id, klausimas FROM klausimai ORDER BY id ASC LIMIT 1");
			$klausimas['klausimas'] = '<h1>Kompiuterio gedimų diagnostika</h1>Ši sistema paklaus jūsų keletos klausimų siekdama išsiaiškinti kas galėjo nutikti kompiuteriui ir pateiks atitinkamą išvadą. Sistema nesutvarkys jūsų kompiuterio tačiau nukreips į atitinkamą specialistą.<br/><br/>' . $klausimas['klausimas'];
		}
		$this->_set(compact('klausimas'));
    }
	
	public function isvada()
	{
		$this->_set('isvada', $this->db->fetch("SELECT isvada FROM isvados WHERE id = " . (int)$_GET['id']));
	}
}
