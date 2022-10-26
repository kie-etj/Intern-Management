@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('interns::intern_diaries.title.intern_diaries') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('interns::intern_diaries.title.intern_diaries') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.interns.intern_diary.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('interns::intern_diaries.button.create intern_diary') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    <div id="statistical" class="row" style="margin:0 10px">
                        <div id="st-done" class="col-md-2 diary-statistic bg-success">
                            <p>Done</p>
                            <p></p>
                        </div>
                        <div id="st-inProgress" class="col-md-2 diary-statistic bg-primary">
                            <p>In Progress</p>
                            <p></p>
                        </div>
                        <div id="st-new" class="col-md-2 diary-statistic bg-info">
                            <p>New</p>
                            <p></p>
                        </div>
                        <div id="st-warning" class="col-md-2 diary-statistic bg-warning">
                            <p>Warning</p>
                            <p></p>
                        </div>
                        <div id="st-notCompleted" class="col-md-2 diary-statistic bg-danger">
                            <p>Not Completed</p>
                            <p></p>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Position</th>
                                <th>Task</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Statistic</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($intern_diaries)): ?>
                            <?php foreach ($intern_diaries as $intern_diary): ?>
                            <?php
                                if ($intern_diary->statistic == 'Warning'):
                                    $textcolor = '#cccc00';
                                elseif ($intern_diary->statistic == 'Not Completed'):
                                    $textcolor = '#ff0000';
                                elseif ($intern_diary->statistic == 'Done'):
                                    $textcolor = '#28d094';
                                else:
                                    $textcolor = '#0000ff';
                                endif;
                            ?>
                            <tr>
                                <td>
                                    {{ $intern_diary->id }}
                                </td>
                                <td style="color: {{ $textcolor }}">
                                    {{ $intern_diary->student }}
                                </td>
                                <td style="color: {{ $textcolor }}">
                                    {{ $intern_diary->position }}
                                </td>
                                <td style="color: {{ $textcolor }}">
                                    {{ str_limit($intern_diary->task, 30) }}
                                </td>
                                <td style="color: {{ $textcolor }}">
                                    {{ $intern_diary->startdate }}
                                </td>
                                <td style="color: {{ $textcolor }}">
                                    {{ $intern_diary->enddate }}
                                </td>
                                <td style="font-weight: bold; color: {{ $textcolor }}">
                                    {{ $intern_diary->status }}
                                </td>
                                <td style="font-weight: bold; color: {{ $textcolor }}">
                                    {{ $intern_diary->statistic }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.interns.intern_diary.edit', [$intern_diary->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.interns.intern_diary.destroy', [$intern_diary->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Position</th>
                                <th>Task</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Statistic</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('interns::intern_diaries.title.create intern_diary') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.interns.intern_diary.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            var column = this;
                            if (!column.data()[0].startsWith("<div")) {
                                var select = $('<select><option value="">All</option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                                        if (column[0][0] == 1) {
                                            statistic(event);
                                        }
                                    });
            
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        select.append('<option value="' + d + '">' + d + '</option>');
                                    });
                            }
                        });
                },
            });

        });
    </script>

    <!-- Custom -->
    <?php $warnings = Session::get('warnings'); ?>
    <?php if (isset($warnings)): ?>
    <?php echo $warnings; ?>
    <?php endif; ?>

    <script>
        const diary = <?= json_encode($intern_diaries); ?>;
        let students = [];
        diary.forEach(element => {
            if (!students.includes(element.student)) {
                students.push(element.student);
            }
        });

        function defaultStatistic() {
            let done = inProgress = newTask = warning = notCompleted = 0;
            diary.forEach(element => {
                if (element.statistic === 'Done') done += 1;
                else if (element.statistic === 'In Progress') inProgress += 1;
                else if (element.statistic === 'New') newTask += 1;
                else if (element.statistic === 'Warning') warning += 1;
                else notCompleted += 1;
            });
            document.getElementById('st-done').lastChild.innerText = done;
            document.getElementById('st-inProgress').lastChild.innerText = inProgress;
            document.getElementById('st-new').lastChild.innerText = newTask;
            document.getElementById('st-warning').lastChild.innerText = warning;
            document.getElementById('st-notCompleted').lastChild.innerText = notCompleted;
        }

        function statistic(event) {
            let done = inProgress = newTask = warning = notCompleted = 0;
            const student = event.target.value;
            if (students.includes(student)) {
                diary.forEach(element => {
                    if (element.statistic === 'Done' && element.student == student) done += 1;
                    else if (element.statistic === 'In Progress' && element.student == student) inProgress += 1;
                    else if (element.statistic === 'New' && element.student == student) newTask += 1;
                    else if (element.statistic === 'Warning' && element.student == student) warning += 1;
                    else if (element.student == student) notCompleted += 1;
                });
                document.getElementById('st-done').lastChild.innerText = done;
                document.getElementById('st-inProgress').lastChild.innerText = inProgress;
                document.getElementById('st-new').lastChild.innerText = newTask;
                document.getElementById('st-warning').lastChild.innerText = warning;
                document.getElementById('st-notCompleted').lastChild.innerText = notCompleted;
            } else {
                defaultStatistic();
            }
        }

        defaultStatistic();

    </script>
@endpush
