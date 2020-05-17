<?php

namespace Core\Models\Warehouse;

use Google\Cloud\BigQuery\BigQueryClient;

class Warehouse{

  protected $bigQuery = null;

  public  function __construct(array $config)
  {

    $this->bigQuery = new BigQueryClient($config);

  }
  public function query(string $query):array
  {

    return [];

  }

}