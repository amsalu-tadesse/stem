<x-layout>
    <x-breadcrump title="Detail of Academic Session" parent="Academic Session" child="Academic Session" />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Academic Session Form</h3>
        </div>
        <div class="card-body row">
            <div class="col-8">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>School</th>
                        </tr>
                    </thead>

                    <tbody id="userList">
                    @foreach($students as $student)
                        <tr id="">
                            <td>1</td>
                            <td>{{$student->name}}</td>
                            <td>{{$student->grade}}</td>
                            <td>{{$student->school}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Courses</th>
                        </tr>
                    </thead>

                    <tbody id="userList">
                        @foreach($students as $student)
                        <tr id="">
                            <td>1</td>
                            <td>{{$student->name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

</x-layout>

<style>
    /* Style for the tables */
    table {
        border-collapse: collapse;
        width: 50%;
        /* Adjust the width as needed */
        float: left;
        /* Float the tables to make them appear side by side */
        margin-right: 20px;
        /* Add some margin for spacing */
    }

    /* Style for table cells */
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>