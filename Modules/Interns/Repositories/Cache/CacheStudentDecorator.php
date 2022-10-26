<?php

namespace Modules\Interns\Repositories\Cache;

use Modules\Interns\Repositories\StudentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheStudentDecorator extends BaseCacheDecorator implements StudentRepository
{
    public function __construct(StudentRepository $student)
    {
        parent::__construct();
        $this->entityName = 'interns.students';
        $this->repository = $student;
    }
}
