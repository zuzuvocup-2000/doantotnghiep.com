<?php

namespace App\Repositories;
use App\Repositories\Interfaces\RouterRepositoryInterface;

class RouterRepository extends BaseRepository implements RouterRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function deleteByCondition($id, $module, $language){
      return $this->model->_delete([
         'table' => $this->table,
         'where' => [
            'objectid' => $id,
            'language' => $language,
            'module' => $module,
         ]
      ]);
   }




}
