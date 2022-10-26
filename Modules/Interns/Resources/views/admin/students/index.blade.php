@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('interns::students.title.students') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('interns::students.title.students') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.interns.student.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('interns::students.button.create student') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('interns::admin.students.partials.filter-fields')
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Faculty</th>
                                <th>Year</th>
                                <th>Lecturer Name</th>
                                <th>Lecturer Email</th>
                                <th>Phone</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody class="table-body">
                            <?php if (isset($students)): ?>
                            <?php foreach ($students as $student): ?>
                            <tr class="data-row" style="color: #337ab7">
                                <td>
                                    {{ $student->id }}
                                </td>
                                <td style="font-weight: bold;">
                                    {{ $student->fullname }}
                                </td>
                                <td>
                                    {{ $student->dateofbirth }}
                                </td>
                                <td>
                                    {{ $student->email }}
                                </td>
                                <td>
                                    {{ $student->phone }}
                                </td>
                                <td>
                                    {{ $student->position }}
                                </td>
                                <td>
                                    {{ $student->school }}
                                </td>
                                <td>
                                    {{ $student->faculty }}
                                </td>
                                <td>
                                    {{ $student->year }}
                                </td>
                                <td>
                                    {{ $student->lecturername }}
                                </td>
                                <td>
                                    {{ $student->lectureremail }}
                                </td>
                                <td>
                                    {{ $student->lecturerphone }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <?php if ($student->schedule): ?>
                                            <a href="{{ route('admin.interns.schedule.edit', [$student->schedule]) }}" class="btn btn-default btn-flat"><i class="fa fa-calendar"></i></a>
                                        <?php else: ?>
                                            <a href="{{ route('admin.interns.schedule.create') }}" class="btn btn-default btn-flat"><i class="fa fa-calendar"></i></a>
                                        <?php endif; ?>
                                        <a href="{{ route('admin.interns.student.edit', [$student->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.interns.student.destroy', [$student->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                                
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Faculty</th>
                                <th>Year</th>
                                <th>Lecturer Name</th>
                                <th>Lecturer Email</th>
                                <th>Phone</th>
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
        <dd>{{ trans('interns::students.title.create student') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.interns.student.create') ?>" }
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
                                    });
            
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        text = d.length > 10 ? d.substring(0, 8) + '...' : d;
                                        if (d.length > 0) {
                                            select.append('<option value="' + d + '">' + text + '</option>');
                                        }
                                    });
                            }
                        });
                },
            });
            
        });
    </script>

    
@endpush