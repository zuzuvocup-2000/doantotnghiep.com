<?php

namespace App\Repositories;
use App\Repositories\Interfaces\MemberRepositoryInterface;

class MemberRepository extends BaseRepository implements MemberRepositoryInterface
{
   protected $table;
   protected $model;

   public function __construct($table){
      $this->table = $table;
      $this->model = model('App\Models\AutoloadModel');
   }

   public function getFiveBroker(){
      return $this->model->_get_where([
         'select' => '
            id,
            fullname,
            phone,
            image,
            description,
            (SELECT name FROm vn_province WHERE vn_province.provinceid = tb1.cityid) as city
         ',
         'table' => $this->table.' as tb1',
         'where' => [
            'tb1.catalogueid' => 2,
         ],
         'limit' => 3,
      ], TRUE);
   }
}
