<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;
    protected $table;

   /**
   * BaseRepository constructor.
   *
   * @param Model $model
   */
   public function __construct($table)
   {
     $this->model = model('App\Models\AutoloadModel');
     $this->table = $table;
   }

   public function all($column = '*'){
      return $this->model->_get_where([
         'select' => $column,
         'table' => $this->table,
         'where' => [
            'deleted_at' => 0,
         ]
      ], TRUE);
   }

   public function findById($column = '', $id){
      return $this->model->_get_where([
         'select' => $column,
         'table' => $this->table,
         'where' => [
            'deleted_at' => 0,
            'id' => $id,
         ]
      ]);
   }

   public function create($payload){
      return $this->model->_insert([
         'data' => $payload,
         'table' => $this->table
      ]);
   }

   public function deleteById(int $id){
      $this->model->_delete([
         'table' => $this->table,
         'where' => [
            'id' => $id
         ]
      ]);
   }

   public function SoftdeleteById(int $id){
      $this->model->_update([
         'table' => $this->table,
         'where' => [
            'id' => $id
         ],
         'data' => [
            'deleted_at' => 1
         ]
      ]);
   }

   public function getAllChildrenNode($column, $lft, $rgt){
      return $this->model->_get_where([
         'select' => $column,
         'table' => $this->table,
         'where' => [
            'lft >=' => $lft,
            'rgt <=' => $rgt,
            'deleted_at' => 0,
         ]
      ], TRUE);
   }

   public function SoftDeleteChildrenNode(array $id){
      return $this->model->_update([
         'table' => $this->table,
         'where_in' => $id,
         'where_in_field' => 'id',
         'data' => [
            'deleted_at' => 1
         ]
      ]);
   }

   public function forceDeleteChildrenNode(array $id){
      return $this->model->_delete([
         'table' => $this->table,
         'where_in' => $id,
         'where_in_field' => 'id',
      ]);
   }



}
