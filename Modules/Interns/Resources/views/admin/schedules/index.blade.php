@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('interns::schedules.title.schedules') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('interns::schedules.title.schedules') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <!-- <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.interns.schedule.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('interns::schedules.button.create schedule') }}
                    </a>
                </div>
            </div> -->
            <div class="box box-primary">
                <div class="box-header">
                    {!! Form::open(['route' => ['admin.interns.fullcalendar.store'], 'method' => 'post']) !!}
                        <div class="col-md-6">
                            {!! Form::normalInput('title', 'Schedule Note', $errors, null, ['required']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::normalInputOfType('datetime-local', 'start', 'Start', $errors, null, ['required']) !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::normalInputOfType('datetime-local', 'end', 'End', $errors, null, ['required']) !!}
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="" style="visibility: hidden">Create</label>
                                <button type="submit" class="btn btn-primary btn-flat form-control"><i class="fa fa-pencil"></i> Create A Schedule Note</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id='full-calendar'></div>
                    <br>
                    <?php if ($schedules != 'Intern'): ?>
                    <div class="table-responsive">
                        @include('interns::admin.schedules.partials.schedule-fields')
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Position</th>
                                <th>Schedule</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($schedules)): ?>
                            <?php foreach ($schedules as $schedule): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.interns.schedule.edit', [$schedule->id]) }}">
                                        {{ $schedule->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.interns.schedule.edit', [$schedule->id]) }}">
                                        {{ $schedule->fullname }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.interns.schedule.edit', [$schedule->id]) }}">
                                        {{ $schedule->position }}
                                    </a>
                                </td>
                                <td id="student-{{ $schedule->id}}">
                                    <a href="{{ route('admin.interns.schedule.edit', [$schedule->id]) }}">
                                        
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.interns.schedule.edit', [$schedule->id]) }}">
                                        {{ $schedule->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.interns.schedule.edit', [$schedule->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.interns.schedule.destroy', [$schedule->id]) }}"><i class="fa fa-trash"></i></button>
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
                                <th>Schedule</th>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                    <?php endif; ?>
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
        <dd>{{ trans('interns::schedules.title.create schedule') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.interns.schedule.create') ?>" }
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
    <?php if (isset($warnings)): ?>
    <?php echo $warnings; ?>
    <?php endif; ?>
    
    <!-- Schedule -->
    <script>
        const schedules = <?= json_encode($schedules); ?>;
        const positionColor = {
            'DESIGN': '#f00',
            'FRONT-END': '#00f',
            'BACK-END': '#000',
            'MARKETING': '#ff0',
            'BA': '#0f0',
            'TESTER': '#f0f',
        }

        for (const key in positionColor) {
            if (Object.hasOwnProperty.call(positionColor, key)) {
                const element = positionColor[key];
                if (document.getElementById("legend")) {
                    document.getElementById("legend").innerHTML +=
                        `<p style="color: ${element}"><b>${key}</b></p>`;
                }
            }
        }

        function showLegend() {
            var legend = document.getElementById("legend");
            legend.classList.toggle("show-legend");
        }

        function workSessionCase(sessionID) {
            switch (sessionID) {
                case '1': text = 'Monday - Morning - 8:30-12:00'; break;
                case '2': text = 'Monday - Afternoon - 13:30-17:30'; break;
                case '3': text = 'Tuesday - Morning - 8:30-12:00'; break;
                case '4': text = 'Tuesday - Afternoon - 13:30-17:30'; break;
                case '5': text = 'Wednesday - Morning - 8:30-12:00'; break;
                case '6': text = 'Wednesday - Afternoon - 13:30-17:30'; break;
                case '7': text = 'Thursday - Morning - 8:30-12:00'; break;
                case '8': text = 'Thursday - Afternoon - 13:30-17:30'; break;
                case '9': text = 'Friday - Morning - 8:30-12:00'; break;
                case '10': text = 'Friday - Afternoon - 13:30-17:30'; break;
                case '11': text = 'Saturday - Morning - 8:30-12:00'; break;
                case '12': text = 'Saturday - Afternoon - 13:30-17:30'; break;
                case '13': text = 'Sunday - Morning - 8:30-12:00'; break;
                case '14': text = 'Sunday - Afternoon - 13:30-17:30'; break;
                default: text = ''; break;
            }
            return text;
        }        

        if (schedules != 'Intern') {
            schedules.forEach(element => {
                element.schedule = element.schedule.split(",")
            });

            schedules.forEach(element => {
                element.schedule.forEach(item => {
                    $(`#session-${item}`).append(
                        `<p style="color: ${positionColor[element.position.toUpperCase()]}"><b>${element.fullname}</b></p>`
                    );

                    $(`#student-${element.id}`).find('a').append(
                        `<p>${workSessionCase(item)}</p>`
                    );
                });
            });       
        }
        
            
    </script>
    <!-- FullCalendar -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            var SITEURL = "{{ url('/') }}/en/backend/interns";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#full-calendar').fullCalendar({
                header: {
                    left:   'agendaWeek listWeek',
                    center: 'title',
                    right:  'today prev,next'
                },
                height: 500,
                titleFormat: 'DD/MM/YYYY',
                defaultView: 'agendaWeek',
                allDaySlot: false,
                columnHeaderFormat: 'ddd DD/MM',
                firstDay: 1,
                nowIndicator: true,
                businessHours: {
                    dow: [ 1, 2, 3, 4, 5, 6 ],
                    start: '08:00',
                    end: '18:00',
                },

                editable: true,
                editable: true,
                events: SITEURL + "/schedules",
                displayEventTime: true,
                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                    element.popover({
                        title: event.student,
                        content: event.title,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body',
                    });
                },
                selectable: true,
                selectHelper: true,
                // select: function (event_start, event_end, allDay) {
                //     var event_name = prompt('Schedule Notes:');
                //     if (event_name) {
                //         var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                //         var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                //         $.ajax({
                //             url: SITEURL + "/fullcalendar-ajax",
                //             data: {
                //                 event_name: event_name,
                //                 event_start: event_start,
                //                 event_end: event_end,
                //                 type: 'create'
                //             },
                //             type: "POST",
                //             success: function (data) {
                //                 displayMessage("Create Schedule Successful!!!");
                //                 calendar.fullCalendar('renderEvent', {
                //                     id: data.id,
                //                     title: event_name,
                //                     start: event_start,
                //                     end: event_end,
                //                     allDay: allDay
                //                 }, true);
                //                 calendar.fullCalendar('unselect');
                //             }
                //         });
                //     }
                // },
                // eventDrop: function (event, delta) {
                //     var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                //     var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                //     $.ajax({
                //         url: SITEURL + '/fullcalendar-ajax',
                //         data: {
                //             event_name: event.event_name,
                //             event_start: event_start,
                //             event_end: event_end,
                //             id: event.id,
                //             type: 'edit'
                //         },
                //         type: "POST",
                //         success: function (response) {
                //             displayMessage("Update Schedule Successful!!!");
                //         }
                //     });
                // },
                eventClick: function (event) {
                    var eventDelete = confirm("Delete this Schedule???");
                    if (eventDelete) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/fullcalendar-ajax',
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function (response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                displayMessage("Removed Schedule!!!");
                            }
                        });
                    }
                }
            });
        });
        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    </script>

@endpush
