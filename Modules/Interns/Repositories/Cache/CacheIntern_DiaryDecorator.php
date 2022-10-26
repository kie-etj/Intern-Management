<?php

namespace Modules\Interns\Repositories\Cache;

use Modules\Interns\Repositories\Intern_DiaryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheIntern_DiaryDecorator extends BaseCacheDecorator implements Intern_DiaryRepository
{
    public function __construct(Intern_DiaryRepository $intern_diary)
    {
        parent::__construct();
        $this->entityName = 'interns.intern_diaries';
        $this->repository = $intern_diary;
    }
}
