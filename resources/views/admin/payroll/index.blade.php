<x-layout>
    <x-breadcrump title="Payroll" parent="payroll" child="List" />
    <div class="card">
        <div class="card-header">
           <div>
                <div class="row mx-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="select2-blue">
                                <select name="school" class="form-control select2" id="course_filter" multiple data-placeholder="-- Course --" data-dropdown-css-class="select2-blue" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    @foreach($courses as $course)
                                    <option value="{{$course->id}}">{{$course->name}}
                                    </option>
                                    @endforeach
                                
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="course_filter_button" class="btn btn-success form-control">Search</button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="course_reset_button" class="btn btn-warning form-control">Reset</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col">
                <div style="display: flex; justify-content:flex-end">
                  
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        {{ $dataTable->table(['class' => 'table table-bordered table-striped']) }}
        </div>

        <!-- /.card-body -->
    </div>
    @push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.school_select2').select2();
        $('#course_filter').select2();
      
    </script>
    <script>
        $('#course_filter_button').on('click', function() {
            window.LaravelDataTables["courses-table"].ajax.reload();
        });

        $('#course_reset_button').on('click', function() {
            $('#school_filter').val([]).trigger('change');
            console.log('clicked');
            window.LaravelDataTables["students-table"].ajax.reload();
        });
    </script>
    @endpush
</x-layout>
