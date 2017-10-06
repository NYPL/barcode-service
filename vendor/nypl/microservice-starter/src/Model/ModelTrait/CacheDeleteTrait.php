<?php
namespace NYPL\Starter\Model\ModelTrait;

use NYPL\Starter\Cache;

trait CacheDeleteTrait
{
    /**
     * @return bool
     */
    public function delete(array $filters = [])
    {
        Cache::getCache()->del(
            $this->getCacheKey($this->getId())
        );

        return true;
    }
}
