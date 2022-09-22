<?php

namespace App\Repositories;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function getProductByParentNode($lft, $rgt){
      return $this->model->_get_where([
         'select' => '
            tb1.id,
            tb2.title,
            tb2.canonical,
            tb1.image,
            tb1.price,
            tb1.area,
            (SELECT name FROM vn_district WHERE vn_district.districtid = tb1.district_id) as district
         ',
         'table' => $this->table.' as tb1',
         'join' => [
            [
               'product_translate as tb2','tb1.id = tb2.objectid','inner'
            ]
         ],
         'query' => '(tb1.catalogueid IN (SELECT id FROM product_catalogue WHERE lft >= '.$lft.' AND rgt <= '.$rgt.'))',
         'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
            'tb2.module' => 'product'
         ],
         'limit' => 4
      ], TRUE);
   }
}
