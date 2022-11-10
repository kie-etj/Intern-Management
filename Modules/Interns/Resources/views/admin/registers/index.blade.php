@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('interns::registers.title.registers') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('interns::registers.title.registers') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.interns.register.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('interns::registers.button.create register') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>F.Name</th>
                                <th>L.Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>StudentID</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Faculty</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($registers)): ?>
                            <?php foreach ($registers as $register): ?>
                            <tr>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->id }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->firstname }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->lastname }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->email }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->phone }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->studentid }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->position }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->school }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->faculty }}
                                    </a>
                                </td>
                                <td>
                                    <a style="cursor: pointer" data-toggle="modal" data-target="#modal-{{ $register->id }}">
                                        {{ $register->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        {!! Form::open(['route' => ['admin.interns.register.store'], 'method' => 'post', 'class' => 'pull-left']) !!}
                                        <input name="id" type="hidden" value="{{ $register->id }}">
                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i></button>
                                        {!! Form::close() !!}
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.interns.register.destroy', [$register->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>F.Name</th>
                                <th>L.Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>StudentID</th>
                                <th>Position</th>
                                <th>School</th>
                                <th>Faculty</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
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
    <!-- Modal -->
    <?php if (isset($registers)): ?>
    <?php foreach ($registers as $register): ?>
    <div class="modal fade" id="modal-{{ $register->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                        <div class="col-md-4">{{ $register->firstname }} {{ $register->lastname }}</div>
    
                        <div class="col-md-2">Birthday:</div>
                        <div class="col-md-4">{{ $register->dateofbirth }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Email:</div>
                        <div class="col-md-4">{{ $register->email }}</div>
                        
                        <div class="col-md-2">Phone:</div>
                        <div class="col-md-4">{{ $register->phone }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Student ID:</div>
                        <div class="col-md-4">{{ $register->studentid }}</div>
                        
                        <div class="col-md-2">Position:</div>
                        <div class="col-md-4">{{ $register->position ?? ' '}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">School:</div>
                        <div class="col-md-4">{{ $register->school }}</div>
                        
                        <div class="col-md-2">Faculty:</div>
                        <div class="col-md-4">{{ $register->faculty }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Year:</div>
                        <div class="col-md-4">{{ $register->year }}</div>
                        
                        <div class="col-md-2">Lecturer Name:</div>
                        <div class="col-md-4">{{ $register->lecturername }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Lecturer Email:</div>
                        <div class="col-md-4">{{ $register->lectureremail }}</div>
    
                        <div class="col-md-2">Lecturer Phone:</div>
                        <div class="col-md-4">{{ $register->lecturerphone }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Avatar:</div>
                        <div class="col-md-4">
                            <img src="{{ asset('/assets/register/'.$register->id.'/'.$register->avatar.'') }}" onerror="this.src='{{ asset('/assets/img/No-Image.png') }}'" style="width: 100px; height: 100px; object-fit: cover; object-position: center; border-radius: 50%">
                            
                        </div>
    
                        <div class="col-md-2">CV:</div>
                        <div class="col-md-4">
                            <a href="{{ asset('/assets/register/'.$register->id.'/'.$register->cv.'') }}" target="_blank">{{ $register->cv }}</a>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Accept</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
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
        <dd>{{ trans('interns::registers.title.create register') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.interns.register.create') ?>" }
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
                }
            });
        });
    </script>
@endpush
