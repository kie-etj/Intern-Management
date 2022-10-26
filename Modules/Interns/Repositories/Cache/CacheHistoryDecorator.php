<?php

namespace Modules\Interns\Repositories\Cache;

use Modules\Interns\Repositories\HistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheHistoryDecorator extends BaseCacheDecorator implements HistoryRepository
{
    public function __construct(HistoryRepository $history)
    {
        parent::__construct();
        $this->entityName = 'interns.histories';
        $this->repository = $history;
    }
}
