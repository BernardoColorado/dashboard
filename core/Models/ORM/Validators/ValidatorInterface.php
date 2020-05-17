<?php

namespace Core\Models\ORM\Validators;
use Doctrine\ORM\EntityRepository as Repository;

interface ValidatorInterface{

  public function __construct(Repository $repository);

}