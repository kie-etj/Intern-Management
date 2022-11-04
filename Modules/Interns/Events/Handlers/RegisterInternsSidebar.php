<?php

namespace Modules\Interns\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterInternsSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('interns::interns.title.interns'), function (Item $item) {
                $item->icon('fa fa-book');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('interns::schools.title.schools'), function (Item $item) {
                    $item->icon('fa fa-university');
                    $item->weight(0);
                    $item->append('admin.interns.school.create');
                    $item->route('admin.interns.school.index');
                    $item->authorize(
                        $this->auth->hasAccess('interns.schools.index')
                    );
                });
                $item->item(trans('interns::faculties.title.faculties'), function (Item $item) {
                    $item->icon('fa fa-object-group');
                    $item->weight(0);
                    $item->append('admin.interns.faculty.create');
                    $item->route('admin.interns.faculty.index');
                    $item->authorize(
                        $this->auth->hasAccess('interns.faculties.index')
                    );
                });
                $item->item(trans('interns::registers.title.registers'), function (Item $item) {
                    $item->icon('fa fa-external-link');
                    $item->weight(0);
                    $item->append('admin.interns.register.create');
                    $item->route('admin.interns.register.index');
                    $item->authorize(
                        $this->auth->hasAccess('interns.registers.index')
                    );
                });
                $item->item(trans('interns::students.title.students'), function (Item $item) {
                    $item->icon('fa fa-users');
                    $item->weight(0);
                    $item->append('admin.interns.student.create');
                    $item->route('admin.interns.student.index');
                    $item->authorize(
                        $this->auth->hasAccess('interns.students.index')
                    );
                });
                $item->item(trans('interns::schedules.title.schedules'), function (Item $item) {
                    $item->icon('fa fa-calendar-check-o');
                    $item->weight(0);
                    $item->append('admin.interns.schedule.create');
                    $item->route('admin.interns.schedule.index');
                    $item->authorize(
                        $this->auth->hasAccess('interns.schedules.index')
                    );
                });
                $item->item(trans('interns::intern_diaries.title.intern_diaries'), function (Item $item) {
                    $item->icon('fa fa-bar-chart');
                    $item->weight(0);
                    $item->append('admin.interns.intern_diary.create');
                    $item->route('admin.interns.intern_diary.index');
                    $item->authorize(
                        $this->auth->hasAccess('interns.intern_diaries.index')
                    );
                });
                $item->item(trans('interns::histories.title.histories'), function (Item $item) {
                    $item->icon('fa fa-history');
                    $item->weight(0);
                    $item->append('admin.interns.history.create');
                    $item->route('admin.interns.history.index');
                    $item->authorize(
                        $this->auth->hasAccess('interns.histories.index')
                    );
                });
// append







            });
        });

        return $menu;
    }
}
