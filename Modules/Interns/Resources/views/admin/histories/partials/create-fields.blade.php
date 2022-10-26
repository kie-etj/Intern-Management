<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            {!! Form::normalSelect('student', 'Student', $errors, $liststudents) !!}
        </div>
        <div class="col-md-6">
            {!! Form::normalInputOfType('date', 'date', 'Work Day', $errors) !!}
        </div>
    </div>
</div>
