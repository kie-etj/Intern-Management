<?php

namespace Modules\Interns\Repositories\Cache;

use Modules\Interns\Repositories\RegisterRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRegisterDecorator extends BaseCacheDecorator implements RegisterRepository
{
    public function __construct(RegisterRepository $register)
    {
        parent::__construct();
        $this->entityName = 'interns.registers';
        $this->repository = $register;
    }
}
