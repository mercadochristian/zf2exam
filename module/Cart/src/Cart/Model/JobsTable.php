<?php
/**
 * Created by PhpStorm.
 * User: christian.me
 * Date: 5/5/2016
 * Time: 6:44 PM
 */

namespace Cart\Model;


use Zend\Db\TableGateway\TableGateway;

class JobsTable extends TableGateway
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function insertToJobItems($Cart)
    {

    }
    

}