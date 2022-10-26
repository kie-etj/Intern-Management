<!-- <div class="filter-group">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group dropdown">
                <label>Filter School</label>
                <select id="filterSchool" class="form-control">
                    <option value="">-------- Choose One --------</option>
                    <?php if (isset($schools)): ?>
                    <?php foreach ($schools as $school): ?>
                        <option value="{{ $school->fullname }}">{{ $school->fullname }}</option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group dropdown">
                <label>Filter Position</label>
                <select id="filterPosition" class="form-control">
                    <option value="">-------- Choose One --------</option>
                    <?php if (isset($positions)): ?>
                    <?php foreach ($positions as $position): ?>
                        <option value="{{ $position->position }}">{{ $position->position }}</option>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        
    </div>
</div> -->