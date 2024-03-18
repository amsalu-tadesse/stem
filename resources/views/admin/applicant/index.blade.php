<x-layout>
    <!-- Content Header (Page header) -->
    <x-breadcrump title="Online Applicant List" parent="Online Applicant" child="List" />
    <!-- /.content-header -->
    <div class="card">
        <div class="card-body">
            <table id="applicant-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Applicant Name</th>
                        <th>Phone Number</th>
                        <th>Project Title</th>
                        <th>Total Cost</th>
                        <th>Duration in Month</th>
                        <th>Attachement</th>
                    </tr>
                </thead>
                @if ($applicant_list->count() > 0)
                    @php
                        $i = 0;
                    @endphp
                    <tbody>
                        @foreach ($applicant_list as $applicant)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $applicant->applicant_name }}</td>
                                <td>{{ $applicant->applicant_phone_number }}</td>
                                <td>{{ $applicant?->research_title }}</td>
                                <td>{{ $applicant->total_cost }}</td>
                                <td> {{ $applicant->project_duration }}
                                <td>
                                    <a href="{{ route('admin.download.attachment', ['id' => $applicant->id]) }}"
                                        class="btn btn-primary">Download Attachment</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize DataTable with additional buttons and customized length menu
                $("#applicant-table").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "pageLength": 10,
                    "autoWidth": false,
                    "buttons": [
                        'csv', 'excel', 'pdf', 'print', 'colvis'
                    ],
                    "dom": '<"row"<"col-md-2"l><"col-md-6"B><"col-md-4"f>>tp',
                    "lengthMenu": [
                        [10, 20, 50, -1],
                        [10, 20, 50, "All"]
                    ],
                    "language": {
                        "lengthMenu": " _MENU_  records per page",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "search": "Search:"
                    }
                });
            });
        </script>
    @endpush
</x-layout>
