<?php

/**
 * Description of klausimai
 * @author Aivaras Voveris <aivaras@activesec.eu>
 * @since Jan 10, 2012
 */
class pages__klausimai extends admin_page
{
	protected $_table = 'klausimai';
	
	public function index()
	{
		$this->_set('klausimai', $this->_visi());
		$this->_set('isvados', $this->_isvados());
	}
	
	public function naujas()
	{
		if (!empty($_POST)) {
            $fields = array('klausimas');
            foreach($fields as $field) {
                if (empty($_POST[$field])) {
                    $this->_error(t('Neužpildyti visi laukai'));
                    break;
                }
            }
            if ($this->_validates()) {
                if (empty($_POST['id'])) {
                    $this->db->save($this->_table, array(
                        'klausimas' => $_POST['klausimas'],
						'taip_id' => (int)$_POST['taip_id'],
						'ne_id' => (int)$_POST['ne_id'],
						'taip_isvados_id' => (int)$_POST['taip_isvados_id'],
						'ne_isvados_id' => (int)$_POST['ne_isvados_id'],
                    ));
                } else {
                    $this->db->query("UPDATE {$this->_table} SET
                    klausimas = '" . $this->db->escape($_POST['klausimas']) . "',
					taip_id = " . (int)$_POST['taip_id'] . ",
					ne_id = " . (int)$_POST['ne_id'] . ",
					taip_isvados_id = " . (int)$_POST['taip_isvados_id'] . ",
					ne_isvados_id = " . (int)$_POST['ne_isvados_id'] . "
                    WHERE id = " . (int)$_POST['id']);
                }
                $this->_redirect($this->_self);
            } else {
                $this->_set('klausimas', $_POST);
            }
        }
		$this->_set('klausimai', $this->_visi());
		$this->_set('isvados', $this->_isvados());
	}
	
	public function redaguoti()
	{
		$this->_set('klausimas', $this->db->fetch("SELECT * FROM {$this->_table} WHERE id = " . (int)$_GET['id']));
		$this->_set('klausimai', $this->_visi());
		$this->_set('isvados', $this->_isvados());
        $this->naujas();
        $this->display($this->_self . '/naujas');
        return false;
	}
	
	public function trinti()
	{
		$id = (int)$_GET['id'];
		$this->db->query("DELETE FROM `{$this->_table}` WHERE id = $id");
		$this->_redirect($this->_self);
	}
	
	protected function _visi()
	{
		$klausimai = array();
		$klausimaiDB = $this->db->fetchAll("SELECT * FROM `{$this->_table}`");
		foreach($klausimaiDB as $klausimas) {
			$klausimai[$klausimas['id']] = $klausimas;
		}
		return $klausimai;
	}
	
	protected function _isvados()
	{
		$isvados = array();
		$isvadosDB = $this->db->fetchAll("SELECT * FROM `isvados`");
		foreach($isvadosDB as $isvada) {
			$isvados[$isvada['id']] = $isvada;
		}
		return $isvados;
	}
}
