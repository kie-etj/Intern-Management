<?php

namespace Modules\Interns\Repositories\Cache;

use Modules\Interns\Repositories\ScheduleRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheScheduleDecorator extends BaseCacheDecorator implements ScheduleRepository
{
    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();
        $this->entityName = 'interns.schedules';
        $this->repository = $schedule;
    }
}
