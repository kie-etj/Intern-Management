<?php

namespace Modules\Interns\Repositories\Cache;

use Modules\Interns\Repositories\SchoolRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSchoolDecorator extends BaseCacheDecorator implements SchoolRepository
{
    public function __construct(SchoolRepository $school)
    {
        parent::__construct();
        $this->entityName = 'interns.schools';
        $this->repository = $school;
    }
}
