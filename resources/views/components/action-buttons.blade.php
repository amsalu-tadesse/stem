@isset($show)
@can($permission_view)
<a class='btn btn-sm' data-row_id="{{ $row_id }}" role="button" id="show_row">
    <i class='text-info far fa-eye'></i></a>
@endcan
@endisset
@can($permission_edit)
<a class='btn btn-sm' data-row_id="{{ $row_id }}" role="button" id="update_row">
    <i class='text-info far fa-edit'></i></a>
@endcan
@isset($delete)
@else
@can($permission_delete)
<a class='btn btn-sm' onclick="delete_row(this, '{{ $row_id }}')" role="button">
    <i class='text-danger fas fa-trash'></i></a>
@endcan

@endisset