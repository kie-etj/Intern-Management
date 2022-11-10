<div class="box-body">
    <div class="col-md-4">
        {!! Form::normalInput('fullname', 'Full Name', $errors, $student) !!}

        {!! Form::normalInputOfType('date', 'dateofbirth', 'Date of Birth', $errors, $student) !!}

        {!! Form::normalInputOfType('email', 'email', 'Student Email', $errors, $student) !!}

        {!! Form::normalInput('phone', 'Phone', $errors, $student) !!}

        {!! Form::normalInput('position', 'Position', $errors, $student) !!}

        {!! Form::normalInput('studentid', 'Student ID', $errors, $student) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalSelect('school', 'School', $errors, $listschools, $student) !!}
        
        {!! Form::normalInput('lecturername', 'Lecturer Name', $errors, $student) !!}
    
        {!! Form::normalInputOfType('email', 'lectureremail', 'Lecturer Email', $errors, $student) !!}
    
        {!! Form::normalInput('lecturerphone', 'Lecturer Phone', $errors, $student) !!}

        {!! Form::normalInputOfType('number', 'year', 'Student Year', $errors, $student, ['min' => 1, 'max' => 6]) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalInput('internyear', 'Intern Year', $errors, $student) !!}

        {!! Form::normalSelect('internquarter', 'Intern Quarter', $errors, [1 => 1, 2 => 2, 3 => 3, 4 => 4], $student) !!}

        {!! Form::normalFile('cv', 'CV', $errors, null, ['accept' => 'application/pdf']) !!}

        {!! Form::normalFile('avatar', 'Avatar', $errors, ['accept' => 'image/*']) !!}
        
        <input type='checkbox' name='clearavatar' id='clearavatar'> Clear Avatar
        <br>
        <img src="{{ isset($student->avatar) ? asset('/assets/student/'.$student->id.'/'.$student->avatar) : '' }}" id="show" width="400px" height="400px" style="border-radius: 50%; object-fit: cover;" />
    </div>

</div>
