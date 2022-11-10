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
                    <div>
                        <label for="" class="col-md-12">Filter</label>
                        <div id="filter-5" class="col-md-2"></div>
                        <div id="filter-6" class="col-md-2"></div>
                        <div id="filter-8" class="col-md-2"></div>
                        <div id="filter-9" class="col-md-2"></div>
                        <div id="filter-10" class="col-md-2"></div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Student ID</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Faculty</th>
                                <th>Lecturer Name</th>
                                <th>Intern</th>
                                <th>Quarter</th>
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
                                    {{ $student->email }}
                                </td>
                                <td>
                                    {{ $student->phone }}
                                </td>
                                <td>
                                    {{ $student->studentid }}
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
                                    {{ $student->lecturername }}
                                </td>
                                <td>
                                    {{ $student->internyear }}
                                </td>
                                <td>
                                    {{ $student->internquarter }}
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-flat" data-toggle="modal" data-target="#modal-{{ $student->id }}"><i class="fa fa-eye"></i></a>
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
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Student ID</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Faculty</th>
                                <th>Lecturer Name</th>
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
    <?php if (isset($students)): ?>
    <?php foreach ($students as $student): ?>
    <div class="modal fade" id="modal-{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="font-weight: bold;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title" id="modalLabel">Student Information</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">Full Name:</div>
                        <div class="col-md-4">{{ $student->fullname }}</div>
    
                        <div class="col-md-2">Birthday:</div>
                        <div class="col-md-4">{{ $student->dateofbirth }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Email:</div>
                        <div class="col-md-4">{{ $student->email }}</div>
                        
                        <div class="col-md-2">Phone:</div>
                        <div class="col-md-4">{{ $student->phone }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Student ID:</div>
                        <div class="col-md-4">{{ $student->studentid }}</div>
                        
                        <div class="col-md-2">Position:</div>
                        <div class="col-md-4">{{ $student->position ?? ' '}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">School:</div>
                        <div class="col-md-4">{{ $student->school }}</div>
                        
                        <div class="col-md-2">Faculty:</div>
                        <div class="col-md-4">{{ $student->faculty }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Year:</div>
                        <div class="col-md-4">{{ $student->year }}</div>
                        
                        <div class="col-md-2">Lecturer Name:</div>
                        <div class="col-md-4">{{ $student->lecturername }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Lecturer Email:</div>
                        <div class="col-md-4">{{ $student->lectureremail }}</div>
    
                        <div class="col-md-2">Lecturer Phone:</div>
                        <div class="col-md-4">{{ $student->lecturerphone }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Avatar:</div>
                        <div class="col-md-4">
                            <img src="{{ asset('/assets/student/'.$student->id.'/'.$student->avatar.'') }}" onerror="this.src='{{ asset('/assets/img/No-Image.png') }}'" style="width: 100px; height: 100px; object-fit: cover; object-position: center; border-radius: 50%">
                            
                        </div>
    
                        <div class="col-md-2">CV:</div>
                        <div class="col-md-4">
                            <a href="{{ asset('/assets/student/'.$student->id.'/'.$student->cv.'') }}" target="_blank">{{ $student->cv }}</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
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
                "order": [[ 9, "desc" ], [ 10, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function (d) {
                            var column = this;
                            var theadname = $("#DataTables_Table_0_wrapper th").eq([d]).text();
                            if (column[0] == 5 || column[0] == 6 || column[0] == 8 || column[0] == 9 || column[0] == 10) {
                                var select = $('<select class="form-control"><option value="">'+ theadname +'</option></select>')
                                    .appendTo($('#filter-'+column[0]))
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                                    });
            
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        if (d.length > 0) {
                                            select.append('<option value="' + d + '">' + d + '</option>');
                                        }
                                    });
                            }
                        });
                },
            });
            
        });
    </script>

    
@endpush
