<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            {!! Form::normalInput('task', 'Task Name', $errors, $intern_diary) !!}
        </div>
        <div class="col-md-2">
            {!! Form::normalInputOfType('date', 'startdate', 'Start Date', $errors, $intern_diary) !!}
        </div>
        <div class="col-md-2">
            {!! Form::normalInputOfType('date', 'enddate', 'End Date', $errors, $intern_diary) !!}
        </div>
        <div class="col-md-2">
            {!! Form::normalSelect('status', 'Status', $errors, ['New' => 'New', 'In Progress' => 'In Process', 'Done' => 'Done'], $intern_diary) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::normalTextarea('description', 'Work Description', $errors, $intern_diary) !!}
        </div>
    </div>
</div>
