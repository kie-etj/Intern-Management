<div class="box-body">
    <div class="col-md-4">
        {!! Form::normalInput('fullname', 'Student Full Name', $errors) !!}
        
        {!! Form::normalInputOfType('date', 'dateofbirth', 'Date of Birth', $errors) !!}

        {!! Form::normalInputOfType('email', 'email', 'Student Email', $errors) !!}

        {!! Form::normalInput('phone', 'Student Phone', $errors) !!}

        {!! Form::normalInputOfType('number', 'year', 'Student Year', $errors, null, ['min' => 1, 'max' => 6]) !!}

        {!! Form::normalInput('studentid', 'Student ID', $errors) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalSelect('school', 'School', $errors, $listschools) !!}
        
        {!! Form::normalInput('lecturername', 'Lecturer Name', $errors) !!}

        {!! Form::normalInputOfType('email', 'lectureremail', 'Lecturer Email', $errors) !!}

        {!! Form::normalInput('lecturerphone', 'Lecturer Phone', $errors) !!}

        {!! Form::normalInput('position', 'Position', $errors) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalInput('internyear', 'Intern Year', $errors) !!}

        {!! Form::normalSelect('internquarter', 'Intern Quarter', $errors, [1 => 1, 2 => 2, 3 => 3, 4 => 4]) !!}

        {!! Form::normalFile('cv', 'CV', $errors, null, ['accept' => 'application/pdf']) !!}

        {!! Form::normalFile('avatar', 'Avatar', $errors, null, ['accept' => 'image/*']) !!}

        <img id="show" width="400px" height="400px" style="border-radius: 50%; object-fit: cover;" />
    </div>
</div>