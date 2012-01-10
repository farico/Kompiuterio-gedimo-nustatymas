<?php

/**
 * Description of klausimai
 * @author Aivaras Voveris <aivaras@activesec.eu>
 * @since Jan 10, 2012
 */
class pages__isvados extends admin_page
{
	protected $_table = 'isvados';
	
	public function index()
	{
		$this->_set('isvados', $this->_visos());
	}
	
	public function nauja()
	{
		if (!empty($_POST)) {
            $fields = array('isvada');
            foreach($fields as $field) {
                if (empty($_POST[$field])) {
                    $this->_error(t('Neužpildyti visi laukai'));
                    break;
                }
            }
            if ($this->_validates()) {
                if (empty($_POST['id'])) {
                    $this->db->save($this->_table, array(
                        'isvada' => $_POST['isvada'],
                    ));
                } else {
                    $this->db->query("UPDATE {$this->_table} SET
                    isvada = '" . $this->db->escape($_POST['isvada']) . "'
                    WHERE id = " . (int)$_POST['id']);
                }
                $this->_redirect($this->_self);
            } else {
                $this->_set('isvada', $_POST);
            }
        }
		$this->_set('isvados', $this->_visos());
	}
	
	public function redaguoti()
	{
		$this->_set('isvada', $this->db->fetch("SELECT * FROM {$this->_table} WHERE id = " . (int)$_GET['id']));
		$this->_set('isvados', $this->_visos());
        $this->nauja();
        $this->display($this->_self . '/nauja');
        return false;
	}
	
	public function trinti()
	{
		$id = (int)$_GET['id'];
		$this->db->query("DELETE FROM `{$this->_table}` WHERE id = $id");
		$this->db->query("UPDATE `klausimas` SET isvados_id = 0 WHERE isvados_id = $id");
		$this->_redirect($this->_self);
	}
	
	protected function _visos()
	{
		$isvados = array();
		$isvadosDB = $this->db->fetchAll("SELECT * FROM `{$this->_table}`");
		foreach($isvadosDB as $isvada) {
			$isvados[$isvada['id']] = $isvada;
		}
		return $isvados;
	}
}
