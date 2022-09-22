<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProjectTypeRepositoryInterface;

class ProjectTypeRepository extends BaseRepository implements ProjectTypeRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }
}
