@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('interns::histories.title.histories') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('interns::histories.title.histories') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.interns.history.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('interns::histories.button.create history') }}
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
                                <th>Student</th>
                                <th>Date</th>
                                <th>First Checkin Time</th>
                                <th>Image</th>
                                <th>Last Checkin Time</th>
                                <th>Image</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($histories)): ?>
                            <?php foreach ($histories as $history): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.interns.history.edit', [$history->id]) }}">
                                        {{ $history->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.interns.history.edit', [$history->id]) }}">
                                        {{ $history->student }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.interns.history.edit', [$history->id]) }}">
                                        {{ $history->date }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.interns.history.edit', [$history->id]) }}">
                                        {{ $history->firsttime }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ $history->firstimage }}">
                                        <img src="{{ $history->firstimage }}" style="width: 100px; height: 100px; object-fit: none; object-position: center; border-radius: 50%">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.interns.history.edit', [$history->id]) }}">
                                        {{ $history->lasttime }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ $history->lastimage }}">
                                        <img src="{{ $history->lastimage }}" style="width: 100px; height: 100px; object-fit: none; object-position: center; border-radius: 50%">
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.interns.history.edit', [$history->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.interns.history.destroy', [$history->id]) }}"><i class="fa fa-trash"></i></button>
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
                                <th>Date</th>
                                <th>First Checkin Time</th>
                                <th>Image</th>
                                <th>Last Checkin Time</th>
                                <th>Image</th>
                                <!-- <th>{{ trans('core::core.table.created at') }}</th> -->
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
        <dd>{{ trans('interns::histories.title.create history') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.interns.history.create') ?>" }
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

    <!-- Custom -->
    <?php $warnings = Session::get('warnings'); ?>
    <?php if (isset($warnings)): ?>
    <?php echo $warnings; ?>
    <?php endif; ?>
@endpush
