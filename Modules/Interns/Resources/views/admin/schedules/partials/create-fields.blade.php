<div class="box-body">
    {!! Form::normalSelect('student', 'Student', $errors, $liststudents) !!}

    <div class="form-group">
        <label>Check your Schedule</label>
        <table class="table table-hover table-bordered text-center" style="table-layout: fixed; width: 100%;">
            <tr>
                <th></th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
                <th>Sunday</th>
            </tr>
            <tr>
                <th>8:00 - 12:00</th>
                <td><input type="checkbox" name="schedules[]" value="1"></td>
                <td><input type="checkbox" name="schedules[]" value="3"></td>
                <td><input type="checkbox" name="schedules[]" value="5"></td>
                <td><input type="checkbox" name="schedules[]" value="7"></td>
                <td><input type="checkbox" name="schedules[]" value="9"></td>
                <td><input type="checkbox" name="schedules[]" value="11"></td>
                <td><input type="checkbox" name="schedules[]" value="13"></td>
            </tr>
            <tr>
                <th>13:30 - 17:30</th>
                <td><input type="checkbox" name="schedules[]" value="2"></td>
                <td><input type="checkbox" name="schedules[]" value="4"></td>
                <td><input type="checkbox" name="schedules[]" value="6"></td>
                <td><input type="checkbox" name="schedules[]" value="8"></td>
                <td><input type="checkbox" name="schedules[]" value="10"></td>
                <td><input type="checkbox" name="schedules[]" value="12"></td>
                <td><input type="checkbox" name="schedules[]" value="14"></td>
            </tr>
        </table>
    </div>

</div>