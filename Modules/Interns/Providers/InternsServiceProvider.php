<?php

namespace Modules\Interns\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Interns\Events\Handlers\RegisterInternsSidebar;

class InternsServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterInternsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('schools', array_dot(trans('interns::schools')));
            $event->load('faculties', array_dot(trans('interns::faculties')));
            $event->load('students', array_dot(trans('interns::students')));
            $event->load('schedules', array_dot(trans('interns::schedules')));
            $event->load('intern_diaries', array_dot(trans('interns::intern_diaries')));
            $event->load('histories', array_dot(trans('interns::histories')));
            // append translations






        });
    }

    public function boot()
    {
        $this->publishConfig('interns', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Interns\Repositories\SchoolRepository',
            function () {
                $repository = new \Modules\Interns\Repositories\Eloquent\EloquentSchoolRepository(new \Modules\Interns\Entities\School());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Interns\Repositories\Cache\CacheSchoolDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Interns\Repositories\FacultyRepository',
            function () {
                $repository = new \Modules\Interns\Repositories\Eloquent\EloquentFacultyRepository(new \Modules\Interns\Entities\Faculty());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Interns\Repositories\Cache\CacheFacultyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Interns\Repositories\StudentRepository',
            function () {
                $repository = new \Modules\Interns\Repositories\Eloquent\EloquentStudentRepository(new \Modules\Interns\Entities\Student());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Interns\Repositories\Cache\CacheStudentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Interns\Repositories\ScheduleRepository',
            function () {
                $repository = new \Modules\Interns\Repositories\Eloquent\EloquentScheduleRepository(new \Modules\Interns\Entities\Schedule());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Interns\Repositories\Cache\CacheScheduleDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Interns\Repositories\Intern_DiaryRepository',
            function () {
                $repository = new \Modules\Interns\Repositories\Eloquent\EloquentIntern_DiaryRepository(new \Modules\Interns\Entities\Intern_Diary());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Interns\Repositories\Cache\CacheIntern_DiaryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Interns\Repositories\HistoryRepository',
            function () {
                $repository = new \Modules\Interns\Repositories\Eloquent\EloquentHistoryRepository(new \Modules\Interns\Entities\History());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Interns\Repositories\Cache\CacheHistoryDecorator($repository);
            }
        );
// add bindings






    }
}
