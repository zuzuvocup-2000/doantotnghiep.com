<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function getAllProject(){
      return $this->model->_get_where([
         'select' => 'tb1.id, tb2.title',
         'table' => $this->table.' as tb1',
         'join' => [
            ['project_translate as tb2','tb2.objectid = tb1.id','inner']
         ],
         'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
            'tb2.module' => 'project'
         ],
         'order_by' => 'order desc, id desc'
      ], TRUE);
   }

   public function getProjectByDistrict($district_id = ''){
      return $this->model->_get_where([
         'select' => '
            tb1.id,
            tb2.title,
            (SELECT COUNT(id) FROM product WHERE tb1.id = product.project_id) as count_product
         ',
         'table' => $this->table.' as tb1',
         'join' => [
            ['project_translate as tb2','tb2.objectid = tb1.id','inner']
         ],
         'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
            'tb2.module' => 'project',
            'tb1.district_id' => $district_id
         ],
         'order_by' => 'order desc, id desc'
      ], TRUE);
   }

   public function getTenProjectByOrder(){
      return $this->model->_get_where([
         'select' => '
            tb1.id,
            tb2.title,
            tb2.description,
            tb1.image,
            tb2.canonical,
            tb1.address,
         ',
         'table' => $this->table.' as tb1',
         'join' => [
            ['project_translate as tb2','tb1.id = tb2.objectid','inner']
         ],
         'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
            'tb2.module' => 'project'
         ],
         'order_by' => 'order desc, id desc'
      ], TRUE);
   }

}
