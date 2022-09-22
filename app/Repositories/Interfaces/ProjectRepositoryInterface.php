<?php

namespace App\Repositories\Interfaces;

/**
 * Interface PostCatalogueServiceInterface
 * @package App\Services\Interfaces
 */
interface ProjectRepositoryInterface extends BaseRepositoryInterface
{
   public function getTenProjectByOrder();

}
