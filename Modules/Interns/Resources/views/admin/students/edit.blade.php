@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('interns::students.title.edit student') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.interns.student.index') }}">{{ trans('interns::students.title.students') }}</a></li>
        <li class="active">{{ trans('interns::students.title.edit student') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.interns.student.update', $student->id], 'method' => 'put', 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('interns::admin.students.partials.edit-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.interns.student.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.interns.student.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>


    
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
        function addDefaultOption(element, selectElement) {
            const newOption = document.createElement('option');
            newOption.value = element.id;
            newOption.innerText = element.facultyname;
            selectElement.add(newOption);
        }


        const faculties = <?= json_encode($faculties) ?>;
        const defaultFaculty = <?= json_encode($student->faculty) ?>;
        const school = document.getElementsByName('school').length ? document.getElementsByName('school')[0] : undefined;
        const parentSchool = school.parentNode;
        
        const newDiv = document.createElement('div');
        newDiv.id = 'facultyDynamic';
        newDiv.classList.add('form-group', 'dropdown');

        const newLabel = document.createElement('label');
        newLabel.innerText = 'Faculty';
        
        const newSelect = document.createElement('select');
        newSelect.name = 'faculty';
        newSelect.className = 'form-control';
        
        faculties.forEach(element => {
            if (element.school == school.value) {
                addOption(element, newSelect);
            }
        });
        
        newSelect.value = defaultFaculty;
        newDiv.appendChild(newLabel);
        newDiv.appendChild(newSelect);
        parentSchool.after(newDiv);
        
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
            parentSchool.after(newDiv);
        }

        // Check File and Show File
        const show = document.getElementById('show');

        const avatar = '<?= json_encode($student->avatar); ?>';
        if (avatar == 'null') {
            show.hidden = true;
        }

        const clearavatar = document.getElementById('clearavatar');
        clearavatar.onclick = function () {
            if (this.checked) {
                show.hidden = true;
            } else {
                show.hidden = false;
            }
        }

        function checkImageFile(event) {
            const fileName = document.getElementById("avatar").value;
            const dot = fileName.lastIndexOf(".") + 1;
            const extFile = fileName.substr(dot, fileName.length).toLowerCase();
            
            if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
                show.hidden = false;
                show.src = URL.createObjectURL(event.target.files[0]);
                show.onload = function() {
                    URL.revokeObjectURL(show.src);
                };
            } else {
                show.hidden = true;
                document.getElementById("avatar").value = null;
                alert("Chỉ được gửi file ảnh .jpg, .jpeg, .png!!!");
            }
        }

        document.getElementById('avatar').setAttribute('onchange', 'checkImageFile(event)');

    </script>

    
@endpush
