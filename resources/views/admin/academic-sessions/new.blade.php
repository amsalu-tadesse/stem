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
                        <input type="text" class="form-control" name="academic_year" id="academic_year" />
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <div class="input-append input-group">
                            <div class="input-group-append" data-target="#end_date">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="start_date" name="start_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" type="text">

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
                        <div class="input-append input-group">
                            <div class="input-group-append" data-target="#end_date">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            <input id="end_date" name="end_date" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" type="text">

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
    <script type='text/javascript'>
        $(function() {
            $('#start_date').datetimepicker({
                pickTime: false
            });
            $('#end_date').datetimepicker({
                pickTime: false
            });
        });

        $(document).ready(function() {
            $("#academic_year").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
        })
    </script>

    @endpush

</x-layout>