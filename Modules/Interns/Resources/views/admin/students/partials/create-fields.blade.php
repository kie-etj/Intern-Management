<div class="box-body">
    <div class="col-md-4">
        {!! Form::normalInput('fullname', 'Student Full Name', $errors) !!}
        
        {!! Form::normalInputOfType('date', 'dateofbirth', 'Date of Birth', $errors) !!}

        {!! Form::normalInputOfType('email', 'email', 'Student Email', $errors) !!}

        {!! Form::normalInput('phone', 'Student Phone', $errors) !!}

        {!! Form::normalInputOfType('number', 'year', 'Student Year', $errors, null, ['min' => 1, 'max' => 6]) !!}

        {!! Form::normalInput('position', 'Position', $errors) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalSelect('school', 'School', $errors, $listschools) !!}
        
        {!! Form::normalInput('lecturername', 'Lecturer Name', $errors) !!}

        {!! Form::normalInputOfType('email', 'lectureremail', 'Lecturer Email', $errors) !!}

        {!! Form::normalInput('lecturerphone', 'Lecturer Phone', $errors) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalFile('avatar', 'Avatar', $errors, null, ['accept' => 'image/*']) !!}

        <img id="show" width="100%" height="100%" />
    </div>    
</div>