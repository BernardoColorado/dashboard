<?php

namespace Core\Models\ORM\Validators;
use Core\Models\ORM\Validators\ValidatorInterface as ValidatorInterface;
use Doctrine\ORM\EntityRepository as Repository;

abstract class EntityValidator implements ValidatorInterface{

public abstract function __construct(Repository $repository);

}