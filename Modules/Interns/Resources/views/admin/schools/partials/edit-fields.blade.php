<div class="box-body">
    <div class="col-md-6">
        {!! Form::normalInput('shortname', 'Short name', $errors, $school) !!}

        {!! Form::normalInput('fullname', 'Full name', $errors, $school) !!}
    </div>
    <div class="col-md-6">
        {!! Form::normalInput('logo', 'Logo', $errors, $school) !!}

        {!! Form::normalInput('webpage', 'Web page', $errors, $school) !!}
    </div>
</div>
