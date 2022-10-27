<div class="box-body">
    <div class="col-md-4">
        {!! Form::normalInput('fullname', 'Full Name', $errors, $student) !!}

        {!! Form::normalInputOfType('date', 'dateofbirth', 'Date of Birth', $errors, $student) !!}

        {!! Form::normalInputOfType('email', 'email', 'Student Email', $errors, $student) !!}

        {!! Form::normalInput('phone', 'Phone', $errors, $student) !!}

        {!! Form::normalInput('position', 'Position', $errors, $student) !!}

        {!! Form::normalInputOfType('number', 'year', 'Student Year', $errors, $student, ['min' => 1, 'max' => 6]) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalSelect('school', 'School', $errors, $listschools, $student) !!}
        
        {!! Form::normalInput('lecturername', 'Lecturer Name', $errors, $student) !!}
    
        {!! Form::normalInputOfType('email', 'lectureremail', 'Lecturer Email', $errors, $student) !!}
    
        {!! Form::normalInput('lecturerphone', 'Lecturer Phone', $errors, $student) !!}

        {!! Form::normalInput('hanetpersonid', 'Hanet Person ID', $errors, $student) !!}
    </div>
    <div class="col-md-4">
        {!! Form::normalFile('avatar', 'Avatar', $errors, ['accept' => 'image/*']) !!}
        
        <input type='checkbox' name='clearavatar' id='clearavatar'> Clear Avatar
        <img src="{{ isset($student->avatar) ? asset('/avatars/'.$student->avatar) : '' }}" id="show" width="100%" height="100%" />
    </div>

</div>
