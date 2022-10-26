<?php

namespace Modules\Interns\Repositories\Cache;

use Modules\Interns\Repositories\FacultyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFacultyDecorator extends BaseCacheDecorator implements FacultyRepository
{
    public function __construct(FacultyRepository $faculty)
    {
        parent::__construct();
        $this->entityName = 'interns.faculties';
        $this->repository = $faculty;
    }
}
