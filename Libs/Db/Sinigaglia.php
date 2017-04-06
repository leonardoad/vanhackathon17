<?php

/**
 * Classe para manipulação dos objetos
 * 
 * @version 23/02/2015
 * @author Leonardo Danieli <leonardo@4coffee.com.br>
 * 
 */
class Db_Sinigaglia {

    private $myDBDriver = 'SQL Server';
    private $myServer = '172.0.0.5';
    private $myUser = "";
    private $myPass = "";
    private $myDB = "";
    private $connection;
    private $resurce;
    private $_readCount;
    private $error;
    private $_text_log;
    private $_columns;
    private $_timeQuery;
    private $_sqlLastQuery;
    private $_list = array();

    /**
     * id do objeto pai da classe
     */
    protected $_owner = '';

    /**
     * estado do objeto se e cCREATE, cUPDATE ou cDELETE
     */
    protected $_state = cCREATE;

    /**
     * Habilita ou desabilita a formatação dos valores lidos do banco,
     * no banco de dados os valores estão salvos no formato html, mas quando e lido os valores para colocar no campos de texto aparece os
     * valores em html e usado para corrigir isso a função Format_String::htmlToString();, mas na comparação dos dados do log ela não pode
     * ser usada, pois quando os dados vem pelo post o sistema trata os dados para evitar SQL Injection ou funções javaScript
     */
    protected $_formatData = true;

    /**
     * Lista de filtros "where" da consulta
     */
    protected $_whereSelect = array();
    protected $_filters = array();

    /**
     * Nome do campo de que sera pego o texto para gravar o log
     *
     * obs: sempre informar este campo nos modelos, so não e preciso se for a_descricao
     * ex: a_descricao
     */
    protected $_log_info = 'a_descricao';

    /**
     * Lista de ordenação ASC/DESC
     */
    protected $_sortOrder;

    /**
     * Lista de junções "joins" da consulta
     */
    protected $_joins = array();

    /**
     * Agrupamaneto das linhas
     */
    protected $_group = false;

    /**
     * Se é pra colocar no INSERT os valores da(s) PK
     * @var boolean
     */
    protected $_store_primary = false;

    /**
     * Guarda no Item da lista "_list" a sua própria posição nela, para ser utilizado no addItem(), quando não se tem a posição que ele estava
     * @var type
     */
    protected $_listPosition = 0;

    /**
     * Agrupamento das linhas na consulta
     *
     * @param $flag true/false
     */
    public function groupBy($flag = true) {
        $this->_group = $flag;
        return $this;
    }

    public function __construct() {
        $this->connect();
    }

    public function getTimeQuery() {
        return $this->_timeQuery;
    }

    public function getError() {
        return $this->error;
    }

    function connect() {
        //criando a conexão
        $this->connection = odbc_connect("DRIVER={$this->myDBDriver};SERVER=$this->myServer;DATABASE=$this->myDB", $this->myUser, $this->myPass, SQL_CUR_USE_ODBC) or die("Falha na conexão " . odbc_errormsg());
    }

    function query($sql) {
        $this->_timeQuery = time();
        $this->_sqlLastQuery = $sql;
        $this->resurce = @odbc_do($this->connection, $sql); //or die("<br><br>Erro na query() on " . __FILE__ . " (line " . __LINE__ . ")<br><br>" . odbc_errormsg() . '<br><br>' . $sql);
        if (!$this->resurce) {
            $msgErro .= "<br><br>Erro na query() on " . __FILE__ . " (line " . __LINE__ . ")<br><br>" . odbc_errormsg() . '<br><br>' . $sql;
            $msg = "Usuario: " . Usuario::getNomeUsuarioLogado();
            $msg .= "<br>Pagina: " . $_SERVER['REDIRECT_URL'];
            $msg .= $msgErro;
            $msg .= "<pre>" . print_r($this->limpaObjeto(), true) . "</pre>";
            SendEmail::sendEmailErro($msg);
            throw new Zend_Db_Adapter_Exception($msgErro);
        }
//        new ErrorException ("<br><br>Erro na query() on " . __FILE__ . " (line " . __LINE__ . ")<br><br>" . odbc_errormsg() . '<br><br>' . $sql);
    }

    function fetchAll() {
        while ($row = odbc_fetch_array($this->resurce)) {
            $linhas[] = $row;
        }
        return $linhas;
    }

    public function setOwner($id) {
        $this->_owner = $id;
    }

    public function getOwner() {
        return $this->_owner;
    }

    public function getCount() {
        return $this->_readCount;
    }

    /**
     * Retorna o numeto total de itens da lista mesmo eles estando marcados para deletados
     * @return int
     */
    public function countItens() {
        return count($this->_list);
    }

    /**
     * Retorna o nome da chave primaria da tabela
     *
     * @return string
     */
    public function getPrimaryName() {
        if (is_array($this->_primary)) {
            $PrimaryKey = $this->_primary[1];
        } else {
            $PrimaryKey = $this->_primary;
        }
        return $PrimaryKey;
    }

    /**
     * Retorna o numero de itens NÂO deletados na lista
     * @return int
     */
    public function countItensNotDeleted() {
        $count = 0;
        for ($i = 0; $i < $this->countItens(); $i++) {
            $Item = $this->getItem($i);
            if (!$Item->deleted()) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Retorna um item da lista
     * @param int $index
     * @return object
     */
    public function getItem($index) {
        return $this->_list[$index];
    }

    /**
     * Busca um item na lista procurando pelo id passado e retorna esse item
     * @param int $id id do item procurado
     * @return object
     */
    public function getItemById($id) {
        foreach ($this->_list as $key => $item) {
            if ($item->getID() == $id)
                return $this->_list[$key];
        }
    }

    /** Definir quais colunas serão consultadas no select do read()
     * <br>
     * Pode ser passado um array de nomes ou uma string com as colunas separadas por virgula
     * 
     * @param mix $columns array or string
     */
    function setColumns($columns) {
        $this->_columns = array();
        if (is_array($columns)) {
            $this->_columns = $columns;
        } elseif (is_string($columns)) {
            $this->addColumns($columns);
        }
    }

    /**
     * Adiciona as colunas a serem buscadas na consulta
     * obs: colunas separadas por "virgula"
     *
     * @param string $columns ex: coluna1, coluna2, coluna3
     */
    public function addColumns($columns) {
        if (is_array($columns)) {
            $this->addColumns(implode(',', $columns));
        } else {
            $colunas = explode(',', $columns);
            foreach ($colunas as $nome) {
                $this->_columns[] = trim($nome);
            }
        }
        return $this;
    }

    /**
     * Adiciona  uma coluna a ser buscada na consulta, sem fazer nenhum tratamento
     *
     * @param string $column ex: "STUFF((SELECT ',' + Column_Name FROM Table_Name FOR XML PATH ('')) , 1, 1, '')"
     */
    public function addColumn($column) {
        $this->_columns[] = trim($column);
        return $this;
    }

    /**
     * Ordenação do consulta adicionar a colunas e modo de ordenação separados por virgula.
     * Ex: coluna1 asc, colunas2 desc
     * @param string $column
     * @param string $order ordenacao do resultado
     */
    public function sortOrder($column, $order = 'asc') {
        if ($column != '') {
            $this->_sortOrder[] = $column . ' ' . $order;
        }
        return $this;
    }

    /**
     * Parametros da junção "join"
     *
     * @param $table tabela de consulta
     * @param $cond condição da consulta ex: table.id_exemplo = table2.id_exemplo
     * @param $cols colunas a serem retornadas
     * @param $type tipo de junção, inner [padrão], left, right, full, cross, natural
     * @param $schema esquema do banco de dados
     */
    public function join($table, $cond, $cols, $type = 'inner', $schema = null) {
        $array = array();
        if (!empty($cols)) {
            $arrayCols = explode(',', $cols);
            foreach ($arrayCols as $key) {
                $array[] = $table . '.' . trim($key);
            }
        }
        $this->_joins[] = array('table' => $table, 'cond' => $cond, 'col' => $array, 'type' => $type, 'schema' => $schema);
        return $this;
    }

    /**
     *
     * @param type $group
     * @param type $campo
     * @param type $valor
     * @param type $oper
     * @param type $glue
     * @param type $aspas
     */
    public function addGroupFilters($group, $campo, $valor, $oper = '=', $glue = 'and', $aspas = true) {
        $this->addFilters($campo, $valor, $oper, $glue, $group, $aspas);
    }

    /**
     *
     * @param type $campo
     * @param type $valor
     * @param type $oper
     * @param type $glue
     * @param type $group
     * @param type $aspas
     */
    public function addFilters($campo, $valor, $oper = '=', $glue = 'and', $group = '', $aspas = true) {
        if (strpos(strtoupper($valor), 'NULL') !== FALSE) {
            $this->_filters[$group][] = array('campo' => " $campo $valor ", 'glue' => $glue);
        } elseif ($oper == 'like' || $oper == 'ilike') {
            $this->_filters[$group][] = array('glue' => " $glue ", 'campo' => " $campo   $oper  ? ", 'valor' => "'%" . $valor . "%'");
        } else if (!$aspas) {
            $this->_filters[$group][] = array('glue' => " $glue ", 'campo' => " $campo   $oper  ? ", 'valor' => "$valor");
        } else {
            $this->_filters[$group][] = array('glue' => " $glue ", 'campo' => " $campo   $oper  ? ", 'valor' => "'$valor'");
        }
    }

    function getFilters() {
        if (count($this->_joins) > 0) {
            foreach ($this->_joins as $key) {
                if (!empty($key['col'])) {
                    $this->addColumns($key['col']);
                }
                $where .= " {$key['type']} join {$key['table']} on {$key['cond']} " . " \n";
            }
            $this->_joins = array();
        }

        if (count($this->_filters) > 0) {
            $where .= ' WHERE 1=1 ';
            foreach ($this->_filters as $grupo => $filtros) {
                if ($grupo == '') {
                    foreach ($filtros as $filtro) {
                        $where .= $filtro['glue'] . str_replace('?', $filtro['valor'], $filtro['campo']) . " \n";
                    }
                } else {
                    $where .= ' and (' . " \n";
                    foreach ($filtros as $key => $filtro) {
                        $glue = ($key > 0) ? $filtro['glue'] : ''; // so coloca a cola se não for o primeiro filtro do grupo
                        $where .= $glue . str_replace('?', $filtro['valor'], $filtro['campo']) . " \n";
                    }
                    $where .= ' )';
                }
            }
            $this->_filters = array();
        }

        if ($this->_group) {
            $where .= ' GROUP BY ';
            foreach ($this->_columns as $coluna) {
                if (strpos($coluna, 'count(') === false and strpos($coluna, '(SELECT') === false and strpos($coluna, '(STUFF') === false) {
                    list($coluna) = explode(' ', $coluna);
                    $colunasToGroupBy .= $sep . $coluna . " \n";
                    $sep = ', ';
                }
            }
            $where .= $colunasToGroupBy;
        }

        if (count($this->_sortOrder) > 0) {
            $where .= ' ORDER BY ';
            $where .= implode(', ' . " \n", $this->_sortOrder) . " \n";
            $this->_sortOrder = array();
        }

        return $where;
    }

    public function setTextLog($text) {
        $this->_text_log = $text;
    }

    public function getTextLog() {
        return $this->_text_log;
    }

    /**
     * Muda o estado do objeto para novo, atualizar ou deletar
     * @param $state  cCREATE, cUPDATE ou cDELETE 
     */
    public function setState($state) {
        $this->_state = $state;
    }

    /**

     * Retorna o estado do objeto se ele e para novo, atualizar ou deletar
     * @return integer
     */
    public function getState() {
        return $this->_state;
    }

    /**
     * seta o objeto como deletado para ser deletado no save do objeto
     */
    public function setDeleted() {
        $this->_state = cDELETE;
    }

    /**
     * Retorna se o objeto foi marcado para ser deletado
     * @return unknown_type
     */
    public function deleted() {
        if ($this->_state == cDELETE) {
            return true;
        } else
            return false;
    }

    /**
     * Retorna se o objeto está marcado para ser criado no DB, significando que ele é um novo item
     * @return boolean
     */
    public function isNew() {
        return ($this->_state == cCREATE);
    }

    /**
     * Seta a id no proprio o objeto na propriedade a_id ....
     * @param $id
     */
    public function setID($id) {
        $primary = 'a_' . $this->getPrimaryName();
        $this->$primary = $id;
    }

    public function getID() {
        $primary = 'a_' . $this->getPrimaryName();
        if (isset($this->$primary)) {
            return $this->$primary;
        }
    }

    /** retorna todas as colunas separadas por virgula
     *
     * @return string todas as colunas separadas por virgula
     */
    public function getColumns() {
        if ($this->_columns != '') {
            $colunas = implode(', ' . " \n", $this->_columns);
        } else {
            $colunas = " $this->_name.* ";
        }
        return $colunas;
    }

    /**
     * Faz uma leitura no banco de dados de apenas uma linha
     *
     * @param int $id
     * @param string $modo
     * @param $dataConection instance of Zend_Config_Ini
     * @return array or class
     */
    public function read($id = null, $modo = 'obj') {

        if ($id != null) {
            $this->setID($id);
        }
        if ($this->getID() == '') {
            throw new Zend_Db_Table_Exception('O ID do objeto não foi passado ou não está setado no objeto');
        }

        $this->addFilters($this->_name . '.' . $this->getPrimaryName(), $this->getID());


        $filtros = $this->getFilters();
        $colunas = $this->getColumns();
        $this->query("SELECT $colunas FROM $this->_name "
                . $filtros
        );

        $rows = $this->fetchAll();
        if ($modo != 'obj') {
            return $rows;
        }

        if (count($rows) == 0) {
            $this->error = 'Item não Encontrado!';
        }
        if (count($rows) > 0) {
            foreach ($rows as $numLinha => $row) {
                foreach ($row as $key => $value) {
                    $key = 'a_' . $key;
                    if ($this->_formatData) {
                        $this->$key = utf8_encode(FormataDados::formataDadosRead($value));
                    } else {
                        $this->$key = $value;
                    }
                }
            }
        }

        $key = $this->_log_info;
        $this->setTextLog($this->$key);
        if ($this->_readList) {
            $this->classList();
        }

        $this->setState(cUPDATE);

        return $this;
    }

    /**
     * Faz uma leitura no banco de dados de retornando varias linhas
     *
     * @param string $modo [obj|array] para que os itens da lista sejam "casted" como array ou obj
     * @return DB_Sinigaglia Retorna um objeto com uma lista
     */
    public function readLst($modo = 'obj') {
        if ($this->connection == '') {
            $this->connect();
        }

        $filtros = $this->getFilters();
        $colunas = $this->getColumns();
        if ($filtros != '') {
            $sql = "SELECT $colunas FROM $this->_name "
                    . $filtros;
            $this->query($sql);
        }

        if ($modo == 'obj') {
            $rows = $this->fetchAll();
        } else {
            $array = $this->fetchAll();
            $this->_list = $array;
            $this->_timeQuery = time() - $this->_timeQuery;
            $this->_total = count($array);
            return $array;
        }
        if (count($rows) == 0 or $rows == NULL) {
            $this->error = 'Nenhum foi item não encontrado!';
        } else {
//            if ($this->_readCount) {
//                $this->_readCount = $this->count();
//            }

            foreach ($rows as $numLinha => $row) {
                $nome = get_class($this);
                $item = new $nome;
                $item->setState(cUPDATE);
                foreach ($row as $key => $value) {
                    $key = 'a_' . $key;
                    if ($this->_formatData) {
                        $item->$key = utf8_encode(FormataDados::formataDadosRead($value));
                    } else {
                        $item->$key = $value;
                    }
                }
                $key = $this->_log_info;
                $item->setTextLog($item->$key);
                $this->addItem($item, $numLinha);
            }
        }
        $this->_timeQuery = time() - $this->_timeQuery;
        $this->_total = count($rows);
        return $this;
    }

    /**
     * Adiciona um objeto na memoria
     *
     * @param type $nome
     * @param type $group
     */
    public function setInstance($nome, $group = '') {
        $session = Zend_Registry::get('session');
        if ($group != '') {
            if (!isset($session->$group)) {
                $session->$group = array();
            }
            $a = $session->$group;
            $a[$nome] = serialize($this);
            $session->$group = $a;
        } else {
            $session->$nome = serialize($this);
        }
        Zend_Registry::set('session', $session);
    }

    /**
     * Retorna um objeto da memoria
     *
     * @param type $nome
     * @param type $group
     * @return type
     */
    static function getInstance($nome, $group = '') {
        $session = Zend_Registry::get('session');
        if ($group != '') {
            $a = $session->$group;
            return unserialize($a[$nome]);
        } else {
            return unserialize($session->$nome);
        }
    }

    /**
     * Adiciona ou substitui (se passado o index) um item na lista
     *
     * @param string $value
     * @param int $index
     */
    public function addItem($value, $index = '') {
        if (trim($index) == '') {
            $value->_listPosition = count($this->_list);
            $this->_list[] = $value;
        } else {
            $value->_listPosition = $index;
            $this->_list[$index] = $value;
        }
    }

    public function getListPosition() {
        return $this->_listPosition;
    }

    /**
     * Metodo que implementa todos os GET/SET da classe
     * 
     * @author Leonardo
     * @date 20-09-2009
     * @param type $metodo
     * @param type $parametros
     * @return type
     * @throws Zend_Db_Table_Exception
     */
    public function __call($metodo, $parametros) {

        // se for set*, "seta" um valor para a propriedade
        if (substr($metodo, 0, 3) == 'set') {
            $var1 = (substr($metodo, 3));
            $var = 'a_' . $var1;
            if (!property_exists($this, $var)) {
//                           die('Método--> set' . $var1 . '() não existe em ' . get_class($this));
                throw new Zend_Db_Table_Exception("Há propriedade \"$var\" não existe ou não foi setada na classe " . get_class($this));
            } else
                $this->$var = Format_String::htmlToString(trim($parametros[0]));
        }
        // se for get*, retorna o valor da propriedade
        elseif (substr($metodo, 0, 3) == 'get') {
            $var1 = (substr($metodo, 3));
            $var = 'a_' . $var1;
//            print'<pre>';
//                die(print_r( $this));
            if (!property_exists($this, $var)) {
                throw new Zend_Db_Table_Exception("Há propriedade \"$var\" não existe ou não foi setada na classe " . get_class($this));
            } else {
                return $this->$var;
            }
        }
    }

    /**
     * Retorna dos os itens da lista
     * @return array
     */
    public function getItens() {
        return $this->_list;
    }

    /**
     * Retorna o ultimo elemento da lista
     * @return object
     */
    public function getLastItem() {
        if ($this->_list != '')
            return end($this->_list);
    }

    public function save() {

        if ($this->countItens() > 0) {
            for ($i = 0; $i < $this->countItens(); $i++) {
                $item = $this->getItem($i);
                if ($this->deleted()) { //se o item esta marcado para delecao
                    $item->setDeleted();
                    $item->save();
                } else {
                    $item->save();
                }
            }
        } else {
            if ($this->deleted()) { // primeiro ele testa se o item esta setado para delecao, se sim, deleta!
                if ($this->getID() != '') { //so deleta do banco de dados se tiver um id setado, senao da erro no sql
                    $this->addFilters($this->getPrimaryName(), $this->getID());
                    $this->delete();

                    if ($this->_log_ativo) {
                        $nameClass = get_class($this);
                        $class = new $nameClass;
                        $class->read($this->getID());

                        $text = $this->_log_info;

                        if ($this->getOwner() != '') {
                            //							Log::createLogSql($this, $this->getID(), cLOG_SQL, cLOG_ACAO_DELETE);
                            Log::createLogSql($this, $this->getOwner(), cLOG_SQL, cLOG_ACAO_DELETE);
                            Log::createLog($this->getOwner(), 'Deletado ' . $this->_log_text . ' ' . $class->getTextLog(), cLOG_DELETE, cLOG_ACAO_DELETE);
                        } else {
                            Log::createLogSql($this, $this->getID(), cLOG_SQL, cLOG_ACAO_DELETE);
                            Log::createLog($this->getID(), 'Deletado ' . $this->_log_text . ' ' . $class->getTextLog(), cLOG_DELETE, cLOG_ACAO_DELETE);
                        }
                    }
                }
                return $this;
            }

            $data = '';
            $atribs = get_object_vars($this);
            $id = '';
            if (key_exists('a_' . $this->getPrimaryName(), $atribs)) {
                $id = $this->getID();
                if (!$this->_store_primary) {
                    unset($atribs['a_' . $this->getPrimaryName()]);
                }
            }
            $this->setMetaData();
            // percorre todos os atributos da classe para gerar o array dada
            foreach ($atribs as $key => $value) {
                $pos = strpos($key, 'a_');
                if ($pos !== false) {
                    $atrib = substr($key, 2);
                    $data[$atrib] = FormataDados::formataDadosSaveSinigaglia($this, $atrib);
                }
            }
            if (is_array($data)) {
                if ($this->getState() == cUPDATE) {
                    $this->addFilters($this->getPrimaryName(), $id);
                    if ($this->_store_primary) {
                        unset($data[$this->getPrimaryName()]);
                    }
                    if ($this->_log_ativo) {
                        $this->_log_ativo = Log::createLogCampos($this);
                    }
                    $this->update($data);
                    $this->setID($id);

                    if ($this->_log_ativo) {
                        if ($this->getOwner() != '') {
                            Log::createLogSql($this, $this->getOwner(), cLOG_SQL, cLOG_ACAO_UPDATE);
                        } else {
                            Log::createLogSql($this, $this->getId(), cLOG_SQL, cLOG_ACAO_UPDATE);
                        }
                    }
                } else if ($this->getState() == cCREATE) {
                    $id = $this->insert($data); //o insert e devolve o id do novo item do db
                    if (!$this->_store_primary) {
                        $this->setID($id);
                    }
                    $this->setState(cUPDATE);

                    if ($this->_log_ativo) {
                        $nomeClass = get_class($this);
                        $item = new $nomeClass;

                        if ($this->getOwner() != '') {
                            Log::createLogSql($this, $this->getOwner(), cLOG_SQL, cLOG_ACAO_INSERT);
                            $item->read($this->getID());
                            Log::createLog($this->getOwner(), 'Inserido ' . $this->_log_text . '<b> ' . $item->getTextLog() . '</b>', cLOG_INSERT, cLOG_ACAO_INSERT);
                        } else {
                            Log::createLogSql($this, $id, cLOG_SQL, cLOG_ACAO_INSERT);
                            $item->read($this->getID());
                            Log::createLog($this->getID(), 'Inserido ' . $this->_log_text . '<b> ' . $item->getTextLog() . '</b>', cLOG_INSERT, cLOG_ACAO_INSERT);
                        }
                    }
                }
            }
        }
        return $this;
    }

    /** retorna o tipo da coluna no banoc de dados.
     * 
     * @param String $nomeColuna
     * @return String
     */
    public function getTipoColuna($nomeColuna) {
        return $this->_metadata[$nomeColuna]['data_type'];
    }

    function setMetaData() {
        $sql = "select column_name, data_type, character_maximum_length
                    from INFORMATION_SCHEMA.COLUMNS where table_name = '$this->_name'";

        $this->connect();
        $this->query($sql);
        $rows = $this->fetchAll();
        foreach ($rows as $value) {
            $this->_metadata[$value['column_name']] = $value;
        }
    }

    function delete() {

        $sql = 'DELETE FROM ';
        $sql .= $this->_name;

        $filtros = $this->getFilters();
        if ($filtros == '') {
            die('Não podemos deletar todas as linhas da tabela ' . $this->_name);
        }
        $sql .= $filtros;

        $this->connect();
        $this->query($sql);
    }

    function update($data) {

        $sql = ' UPDATE ';
        $sql .= $this->_name;
        $sql .= ' SET ';
        foreach ($data as $campo => $valor) {
            $dados[] = $campo . " = " . utf8_decode($valor);
        }
        $sql .= implode(', ' . "\n", $dados);

        $filtros = $this->getFilters();
        if ($filtros == '') {
            die('Não podemos atualizar todas as linhas da tabela ' . $this->_name);
        }
        $sql .= $filtros;

//            print'<Br><br>update<pre>';
//             (print_r($sql));
        $this->connect();
        $this->query($sql);
    }

    function insert($data) {

        $sql = 'INSERT INTO ';
        $sql .= $this->_name;
        foreach ($data as $campo => $valor) {
            $campos[] = $campo;
            $valores[] = utf8_decode($valor);
        }
        $campos = implode(',' . "\n", $campos);
        $valores = implode(',' . "\n", $valores);

        $sql .= " ($campos) ";
        $sql .= " VALUES ";
        $sql .= " ($valores) ";

//        print'insert<pre>';
//        die(print_r($sql));
//        
        $this->connect();
        $this->query($sql);
        return $this->getLastID();
    }

//    180643

    function getLastID() {
        $this->query("select SCOPE_IDENTITY() as id");
        $ret = $this->fetchAll();
        return $ret[0]['id'];
    }

    /** Retorna somente os tributos que iniciam com "a_" do Objeto em um array
     *
     * Essa função é util quando é necessario passar o objeto para o tamplate, mas somente os atributos vindos do DB
     *
     * @see Db_Table;
     * @example FichaTecnicaController::visualizarAction();
     * @since 02/05/16
     * @author Leonardo Danieli <leonardo@4coffee.com.br>
     *
     * @return array
     */
    public function _toArray() {
        $vars = get_object_vars($this);
        foreach ($vars as $attr => $val) {
            if (strpos($attr, 'a_') !== false) {
                if (is_object($val) and substr(class_parents($val), 0, 3) == 'Db_') {
                    //caso atributo em questão seja um objeto, verifica se ele é do tipo Db_Tables, por exemplo.
                    // chama a função _toArray() recursivamente para ir transformando tudo em array.
                    $val = $val->_toArray();
                }
                $ret[substr($attr, 2)] = $val;
            }
        }
        return $ret;
    }

    /** Retorna os filtros utilizados para a lista formatado para mostrar no Relatório
     *
     * @since 21/07/16
     * @author Leonardo Danieli <leonardo@4coffee.com.br>

     * @return array
     */
    public function getFiltrosToRelatorio() {
        $filtros = $this->_filters;

        foreach ($filtros as $filtrosPorGrupo) {
            foreach ($filtrosPorGrupo as $filtro) {

                $campo = explode('.', $filtro['campo']);
                $re[] = str_replace('?', $filtro['valor'], end($campo));
            }
        }
        return implode(' | ', $re);
    }

    // ================ GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================
    // ================ GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================
    // ================ GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================
    /**
     *
     * @return boolean TRUE se foi bloqueado para esse usuario | FALSE se é somente leitura
     */
    public function bloqueia() {
        $BloqSessao = $this->getBloqueioSessao();
        if (!$BloqSessao->bloqueado()) {
            $BloqSessao->setID_Owner($this->getID());
            $BloqSessao->bloqueia();
            return true; //se ele foi bloqueado por esse usuário, retorna TRUE
        }
        return false;  // o item já estava bloqueado por outro usuario, ele retorna FALSE para saber que nao foi bloqueado para o usuario que chamou!
    }

    public function getBloqueadoPor() {
        $BloqSessao = $this->getBloqueioSessao();
        return $BloqSessao->getBloqueadoPor();
    }

    public function getBloqueadoPorNome() {
        $BloqSessao = $this->getBloqueioSessao();
        $user = new Usuario();
        $user->read($BloqSessao->getBloqueadoPor());
        return $user->getNomeCompleto();
    }

    public function getTempoBloqueado() {
        $BloqSessao = $this->getBloqueioSessao();
        return $BloqSessao->getTempoBloqueado();
    }

    public function bloqueado() {
        $BloqSessao = $this->getBloqueioSessao();
        $BloqSessao->setID_Owner($this->getID());
        return $BloqSessao->bloqueado();
    }

    /**
     *
     * @return BloqueioSessao
     */
    public function getBloqueioSessao() {
        if ($this->BloqueioSessao == "") {
            $this->BloqueioSessao = new BloqueioSessao();
            $this->BloqueioSessao->setNameOwner($this->_name);
            $this->BloqueioSessao->setID_Owner($this->getID());
            $this->BloqueioSessao->setID_Usuario(Usuario::getIdUsuarioLogado());
        }
        return $this->BloqueioSessao;
    }

    // ==== /END ========= GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================

    /** Limpa o objeto para ser enviado para o cliente.
     *
     * @param object $this
     * @return object retorna o objeto limpo
     */
    public function limpaObjeto() {
        unset($this->_db);
        unset($this->_name);
        unset($this->_primary);
        unset($this->_column);
        unset($this->_columns);
        unset($this->_view);
        unset($this->_whereSelect);
        unset($this->_filters);
        unset($this->_joins);
        unset($this->_havings);
        unset($this->_group);
        unset($this->_sortOrder);
        unset($this->_limit);
        unset($this->_offset);
        unset($this->_cols);
        unset($this->_schema);
        unset($this->_definitionConfigName);
        unset($this->_definition);
        unset($this->_store_primary);
        unset($this->_readList);
        unset($this->_classList);
        unset($this->_metadata);
        unset($this->_identity);
        unset($this->_sequence);
        unset($this->_log_ativo);
        unset($this->_owner);
        unset($this->_log_info);
        unset($this->_rowClass);
        unset($this->_rowsetClass);
        unset($this->_referenceMap);
        unset($this->_dependentTables);
        unset($this->_defaultSource);
        unset($this->_defaultValues);
        unset($this->_log_text);
        unset($this->_state);
        unset($this->_formatData);
        unset($this->_text_log);
        unset($this->_readCount);
        unset($this->_removeJoin);
        unset($this->_metadataCache);
        unset($this->_metadataCacheInClass);
//        unset($this->_dependentTables);

        $attrs = get_object_vars($this);
        foreach ($attrs as $attr => $value) {
            if (is_object($value)) {
                $this->$attr = $value->limpaObjeto();
//                print'<pre>';die(print_r($value  ));
            } else if ($attr == '_list') {
                $lista = $this->_list;
                if ($lista == '') {
                    unset($this->_list);
                } else if (count($lista) > 0) {
                    foreach ($lista as $attr2 => $value) {
                        if (is_object($lista[$attr2])) {
                            $o = $lista[$attr2];
                            $lista[$attr2] = $o->limpaObjeto();
                        }
                    }
                    $this->_list = $lista;
                }
            }
        }
        return $this;
    }

}
