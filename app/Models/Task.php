<?php

namespace Models;


use Core\Orm\ActiveRecord;

class Task extends ActiveRecord
{
    /**
     * @var string
     */
    protected $table = 'tasks';
}