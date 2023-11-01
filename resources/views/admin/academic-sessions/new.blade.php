<x-layout>
    <x-breadcrump title="Add New Academic Session" parent="Academic Session" child="Add New Academic Session" />

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Add Academic Session Form</h3>
        </div>

        <form id="academic_session_form" method="POST" action="{{ route('admin.academic-sessions.store') }}">
            @csrf
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Academic Year</label>
                        <input type="text" class="form-control" name="datepicker" id="datepicker" />
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <div class="input-group date" id="start_date" data-target-input="nearest">
                            <div class="input-group-append" data-target="#start_date">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start_date" data-toggle="datetimepicker">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="week_type">Week Type</label>
                        <select id='week_type' class="form-control" name="week_type">
                            <option value="">Select Week Type</option>
                            <option value="0">Weeks</option>
                            <option value="1">Weekend</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <div class="input-group date" id="end_date" data-target-input="nearest">
                            <div class="input-group-append" data-target="#end_date">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#end_date" data-toggle="datetimepicker">
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-info float-right mx-3">Submit</button>
            </div>

        </form>

    </div>

    @push('scripts')
    <script>
        $('#start_date').datetimepicker({
            format: 'YYYY-MM-DD HH:MM:SS',
            icons: {
                time: 'far fa-clock'
            },
            buttons: {
                showClear: true,
                showClose: true,
            }

        });
        
        $('#end_date').datetimepicker({
            format: 'YYYY-MM-DD HH:MM:SS',
            icons: {
                time: 'far fa-clock'
            },
            buttons: {
                showClear: true,
                showClose: true,
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
        })
    </script>
    <style>
.daterangepicker .drp-calendar {
    background-color: #f0f0f0 !important; 
    color: #333 !important; 
}

.daterangepicker input[name="daterangepicker_start"] {
    background-color: #f0f0f0 !important; 
    color: #333 !important; 
}

.daterangepicker input[name="daterangepicker_end"] {
    background-color: #f0f0f0 !important; 
    color: #333 !important; 
}

    </style>
    @endpush
   
</x-layout>