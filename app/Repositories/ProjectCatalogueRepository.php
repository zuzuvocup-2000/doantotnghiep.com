<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProjectCatalogueRepositoryInterface;

class ProjectCatalogueRepository extends BaseRepository implements ProjectCatalogueRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

}
