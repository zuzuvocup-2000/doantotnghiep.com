<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface BaseRepositoryInterface
{
   public function all($column);
   public function findById($column = '', int $id);
   public function deleteById(int $id);
   public function SoftDeleteChildrenNode(array $id);
   public function forceDeleteChildrenNode(array $id);

}
