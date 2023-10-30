<div class="btn-group">
    <button type="button" class="btn btn-info">Action</button>
    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" role="menu" style="">

        @isset($show)
        @can($permission_view)
        <a class='dropdown-item btn btn-sm' data-row_id="{{ $row_id }}" role="button" id="show_row">Show
        </a>
        @endcan
        @endisset
        {{-- </a> --}}
        @can($permission_edit)
        <a class="dropdown-item btn btn-sm" data-user_id="{{ $row_id }}" role="button" id="update_user">Edit
        </a>
        @endcan

        @if ($issue->kpi < 4) @isset($delete) @else
        @can($permission_delete)
 <a class='dropdown-item btn btn-sm' onclick="delete_user(this, '{{ $row_id }}')" role="button">Delete
            </a>
            @endcan
            @endisset
            @endif

            {{-- @php
            $issues = Apps\Models\Issue::all();
        @endphp --}}

            @if ($issue->kpi == 1 || $issue->kpi == 3)
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" onclick="issue_request(this, '{{ $row_id }}')" role="button" id="request">Issue Request</a>
            @endif

            @if(!$issue->$workinggroupname && $issue->kpi >=4)
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" onclick="assign_working_group(this, '{{ $row_id }}')" role="button" id="assign">Assign Working Group</a>
            @endif
    </div>
</div>
