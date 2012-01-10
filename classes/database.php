<?php
class Database
{
    protected $sDatabaseHost;
    protected $sDatabaseUser;
    protected $sDatabasePassword;
    protected $sDatabase;
    protected $aQueries = array();
    protected $iSlowQueryTime = 3;
    protected $iDebug = 2;
    private $oConnection = false;
    
    private function connect($sType = 'mysql') {
        if (!$this->oConnection) {
            if ($sType == 'mysql') {
                include BASIC_PATH . 'config.php';
                $this->sDatabaseUser = $db_user;
                $this->sDatabaseHost = $db_host;
                $this->sDatabasePassword = $db_pass;
                $this->sDatabase = $mysql_db;
                $this->oConnection = mysql_connect($this->sDatabaseHost, $this->sDatabaseUser, $this->sDatabasePassword);
                mysql_select_db($this->sDatabase, $this->oConnection);
                mysql_query("SET NAMES 'utf8'", $this->oConnection);
            } elseif ($sType == 'mysqli') {

            }
        }
    }

    public function update($table, $data, $where = null) {
        $query = "UPDATE `$table` SET ";
        foreach ($data as $field => $value) {
            $query .= "`$field` = " . $value . ",";
        }
        $query = substr($query, 0, -1);
        if ($where !== null) {
            $query .= " WHERE " . $where;
        }
        return $this->query($query);
    }


    public function query($sQuery) {
        $this->connect();
        $iStart = microtime(true);
        if (!$rQuery = mysql_query($sQuery)) {
            $this->logSqlError($sQuery . ' ' . date('Y-m-d H:i:s') . ' ' . $_SERVER['REMOTE_ADDR']);
            if ($this->iDebug == 1) {
                echo '<p>SQL Error occured: ' . mysql_error();
            } elseif ($this->iDebug == 2) {
                echo '<p>SQL Error occured: ' . mysql_error() . '<br />DEBUG: ' . $sQuery . '</p>';
            }
        }
        $iEnd = microtime(true);
        $iTakenTime = $iEnd - $iStart;

        $this->aQueries[] = $sQuery . '|' . $iTakenTime;

        if ($iTakenTime > $this->iSlowQueryTime) {
            $this->logSlowQuery($sQuery . ' ' . $iTakenTime);
        }

        return $rQuery;
    }

    public function count($sQuery) {
        $rQuery = $this->query($sQuery);
        $aData = $this->fetch($rQuery, 'array');
        return $aData['COUNT(*)'];
    }

    public function count_total($sTable) {
        $this->connect();
        $rQuery = $this->query("SELECT COUNT(*) FROM `" . $sTable . "`");
        $aInfo = mysql_fetch_array($rQuery);
        return (int) $aInfo['COUNT(*)'];
    }

    public function num_rows($rQuery) {
        $this->connect();
        if (gettype($rQuery) != 'resource') {
            $rQuery = $this->query($rQuery);
        }
        return mysql_num_rows($rQuery);
    }

    public function fetchAll($rQuery) {
        $aResults = array();
        $this->connect();
        if (gettype($rQuery) != 'resource') {
            $rQuery = $this->query($rQuery);
        }
        while ($oResult = mysql_fetch_assoc($rQuery)) {
            $aResults[] = $oResult;
        }
        return $aResults;
    }

    public function fetch($rQuery, $sType = 'assoc') {
        $this->connect();
        if (gettype($rQuery) != 'resource') {
            $rQuery = $this->query($rQuery);
        }
        if ($sType == 'assoc') {
            return mysql_fetch_assoc($rQuery);
        } else {
            return mysql_fetch_array($rQuery);
        }
    }

    public function save($sTable, $aData, $aChanges = array()) {

        $this->connect();
        $aChangeFrom = array();
        $aChangeTo = array();
        if (!empty($aChanges)) {
            foreach ($aChanges as $sChange => $sVal) {
                $aChangeFrom[] = $sChange;
                $aChangeTo[] = $sVal;
            }
        }
        $sQuery = 'INSERT INTO `' . $sTable . '` SET ';
        foreach ($aData as $sField => $sVal) {
            if (is_array($sVal)) {

                $key = array_keys($sVal);

                $sField = $key[0];
                $sVal = $sVal[$key[0]];
            }
            if (preg_match('/NOW\(\)/i', $sVal)) {
                $sQuery .= '`' . $sField . '` = ' . $sVal . ', ';
            } else {
                $sQuery .= '`' . $sField . '` = "' . mysql_real_escape_string(str_replace($aChangeFrom, $aChangeTo, $sVal)) . '", ';
            }
        }
        $sQuery = substr($sQuery, 0, -2);
        $this->query($sQuery);
        return $this->lastInsertedId();
    }

    public function escape($sString) {
        $this->connect();
        return mysql_real_escape_string($sString);
    }

    public function lastInsertedId() {
        $iId = sprintf('%d', mysql_insert_id());
        return $iId;
    }

    public function affectedRows() {
        $rows = sprintf("%d", mysql_affected_rows());
        return $rows;
    }

    protected function logSqlError($sError) {
        //file_put_contents(ROOT.'logs/core/sql_error.log', $sError."\n", FILE_APPEND);
    }

    private function logSlowQuery($sError) {
        //file_put_contents(ROOT.'logs/core/sql_slow.log', $sError."\n", FILE_APPEND);
    }

    public function queryLog() {
        /*
          echo '
          <h4>Query log</h4>
          <pre>
          ';
          print_r($this->aQueries);
          echo '</pre>'; */
        return $this->aQueries;
    }

    public function close() {
        if ($this->oConnection) {
            mysql_close();
        }
    }

}
