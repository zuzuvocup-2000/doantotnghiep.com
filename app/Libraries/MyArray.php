<?php
namespace App\Libraries;

class MyArray{

   public function __construct(){}

   public function convertArrayById(array $array = []){
      $newArray = [];
      if(isset($array) && is_array($array) && count($array)){
         foreach($array as $key => $val){
            $newArray[] = $val['id'];
         }
      }
      return $newArray;
   }

   public function convertArrayByValue(array $array = [], $string = ''){
      $newArray = [];
      $newArray[0] = ($string) ?? '-- Lựa Chọn --';
      if(isset($array) && is_array($array) && count($array)){
         foreach($array as $key => $val){
            $newArray[$val['id']] = $val['title'];
         }
      }
      return $newArray;
   }

   public function converProvinceArray(array $array){
      $newArray = [];
      $newArray[0] = 'Chọn Thành Phố';
      if(isset($array) && is_array($array) && count($array)){
         foreach($array as $key => $val){
            $newArray[$val['provinceid']] = $val['name'];
         }
      }
      return $newArray;
   }


}
