<?php

namespace App\Repositories;
use App\Repositories\Interfaces\MemberCatalogueRepositoryInterface;

class MemberCatalogueRepository extends BaseRepository implements MemberCatalogueRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }
}
