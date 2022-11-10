<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .container {
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 2%/5%;
        }
        
        label {
            font-weight: bold;
        }
        .content {
            padding: 1rem;
        }
        .heading {
            text-align: center;
            background-color: #454545;
            border: 1px solid #ccc;
            color: #fff;
            padding: 10px;
            margin: 0 -12px;
        }
        .form-group {
            padding: .5rem;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            margin: 10px;
        }
        .help-block {
            color: #f00;
        }
    </style>
</head>
<body>
    {!! Form::open(['route' => ['register-intern/create'], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
    <div class="container">
        <h1 class="heading">REGISTER NEW INTERN</h1>
        <hr>
        <div class="content">
            <div class="tab-content">
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            {!! Form::normalInput('firstname', 'First Name', $errors, null, ['required']) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalInput('lastname', 'Last Name', $errors, null, ['required']) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalInputOfType('date', 'dateofbirth', 'Date of Birth', $errors, null, ['required']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! Form::normalInput('studentid', 'Student ID', $errors, null, ['required']) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalInputOfType('email', 'email', 'Student Email', $errors, null, ['required']) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalInput('phone', 'Student Phone', $errors, null, ['required']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! Form::normalSelect('school', 'School', $errors, $listschools) !!}
                        </div>
                        <div id="faculty" class="col">

                        </div>
                        <div class="col">
                            {!! Form::normalInputOfType('number', 'year', 'Student Year', $errors, null, ['min' => 1, 'max' => 6]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! Form::normalInput('lecturername', 'Teacher Name', $errors) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalInputOfType('email', 'lectureremail', 'Teacher Email', $errors) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalInput('lecturerphone', 'Teacher Phone', $errors) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! Form::normalInput('position', 'Position', $errors) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalFile('avatar', 'Avatar', $errors, null, ['accept' => 'image/*']) !!}
                        </div>
                        <div class="col">
                            {!! Form::normalFile('cv', 'CV', $errors, null, ['accept' => 'application/pdf']) !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        
                        <div class="col"></div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-submit">REGISTER</button>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <!-- Custom -->
    <?php if (isset($warnings)): ?>
    <?php echo $warnings; ?>
    <?php endif; ?>

    <script>
        function addOption(element, selectElement) {
            const newOption = document.createElement('option');
            newOption.value = element.id;
            newOption.innerText = element.facultyname;
            selectElement.add(newOption);
        }

        const faculties = <?= json_encode($faculties) ?>;
        const defaultFaculty = <?= json_encode(isset($student) ? $student['faculty'] : null) ?>;
        const school = document.getElementsByName('school').length ? document.getElementsByName('school')[0] : undefined;
        school.classList.add('form-select');
        const facultyEle = document.getElementById('faculty');
        
        const newDiv = document.createElement('div');
        newDiv.id = 'facultyDynamic';
        newDiv.classList.add('form-group', 'dropdown');

        const newLabel = document.createElement('label');
        newLabel.innerText = 'Faculty';
        
        const newSelect = document.createElement('select');
        newSelect.name = 'faculty';
        newSelect.className = 'form-control form-select';
        
        faculties.forEach(element => {
            if (element.school == school.value) {
                addOption(element, newSelect);
            }
        });
        
        defaultFaculty ? newSelect.value = defaultFaculty : '';
        newDiv.appendChild(newLabel);
        newDiv.appendChild(newSelect);
        facultyEle.appendChild(newDiv);
        
        // Onclick change school event
        school.onchange = function (e) {
            document.getElementById('facultyDynamic').remove();
            newSelect.replaceChildren();
            faculties.forEach(element => {
                if (element.school == school.value) {
                    addOption(element, newSelect);
                }
            });
            
            newDiv.appendChild(newLabel);
            newDiv.appendChild(newSelect);
            facultyEle.appendChild(newDiv);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
