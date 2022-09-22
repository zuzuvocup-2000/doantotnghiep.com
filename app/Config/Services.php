<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

require_once SYSTEMPATH . 'Config/Services.php';

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{
   /* Services */
   public static function AuthService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('AuthService', $param);
       }

       return new \App\Services\AuthService($param);
   }
   public static function UserService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('UserService', $param);
       }

       return new \App\Services\UserService($param);
   }
   public static function MemberService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('MemberService', $param);
       }

       return new \App\Services\MemberService($param);
   }
   public static function ProjectTypeService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('ProjectTypeService', $param);
       }

       return new \App\Services\ProjectTypeService($param);
   }
   public static function MemberCatalogue($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('MemberCatalogue', $param);
       }

       return new \App\Services\MemberCatalogueService($param);
   }
   public static function ProjectCatalogue($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('ProjectCatalogue', $param);
       }

       return new \App\Services\ProjectCatalogueService($param);
   }
   public static function productCatalogue($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('productCatalogue', $param);
       }

       return new \App\Services\ProductCatalogueService($param);
   }
   public static function ProjectService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('ProjectService', $param);
       }

       return new \App\Services\ProjectService($param);
   }
   public static function ProductService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('ProductService', $param);
       }

       return new \App\Services\ProductService($param);
   }

   public static function ProductFrontendService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('ProductFrontendService', $param);
       }

       return new \App\Services\ProductFrontendService($param);
   }

   public static function TypeService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('TypeService', $param);
       }

       return new \App\Services\TypeService($param);
   }

   public static function PriceService($param = [], $getShared = true)
   {
       if ($getShared)
       {
           return static::getSharedInstance('PriceService', $param);
       }

       return new \App\Services\PriceService($param);
   }


   /* Repository */
   public static function ProjectCatalogueRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('ProjectCatalogueRepository', $table);
      }

      return new \App\Repositories\ProjectCatalogueRepository($table);
   }
   public static function ProjectTypeRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('ProjectTypeRepository', $table);
      }

      return new \App\Repositories\ProjectTypeRepository($table);
   }
   public static function ProductCatalogueRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('ProductCatalogueRepository', $table);
      }

      return new \App\Repositories\ProductCatalogueRepository($table);
   }
   public static function ProductRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('ProductRepository', $table);
      }

      return new \App\Repositories\ProductRepository($table);
   }
   public static function ProvinceRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('ProvinceRepository', $table);
      }

      return new \App\Repositories\ProvinceRepository($table);
   }
   public static function TypeRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('TypeRepository', $table);
      }

      return new \App\Repositories\TypeRepository($table);
   }
   public static function ProjectRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('ProjectRepository', $table);
      }

      return new \App\Repositories\ProjectRepository($table);
   }
   public static function PriceRepository($table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('PriceRepository', $table);
      }

      return new \App\Repositories\TypeRepository($table);
   }
   public static function RouterRepository(string $table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('RouterRepository', $table);
      }

      return new \App\Repositories\RouterRepository($table);
   }

   public static function MemberCatalogueRepository(string $table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('MemberCatalogueRepository', $table);
      }

      return new \App\Repositories\MemberCatalogueRepository($table);
   }

   public static function MemberRepository(string $table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('MemberRepository', $table);
      }

      return new \App\Repositories\MemberRepository($table);
   }
   public static function UserRepository(string $table = '', $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('UserRepository', $table);
      }

      return new \App\Repositories\UserRepository($table);
   }


   /* Libraries */
   public static function pagination($getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('pagination');
      }

      return new \App\Libraries\Pagination();
   }

   public static function nestedSetBie($param = [], $getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('nestedSetBie', $param);
      }

      return new \App\Libraries\Nestedsetbie($param);
   }

   public static function array($getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('array');
      }

      return new \App\Libraries\MyArray();
   }

   public static function auth($getShared = true){
      if ($getShared)
      {
          return static::getSharedInstance('auth');
      }

      return new \App\Libraries\Authentication();
   }

}
