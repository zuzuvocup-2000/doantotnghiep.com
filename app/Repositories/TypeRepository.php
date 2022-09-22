<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;

class TypeRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }



}
