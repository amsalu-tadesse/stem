
@can($permission_delete)
<a class='btn btn-sm' onclick="delete_subscription(this, '{{ $row_id }}')" role="button">
    <i class='text-danger fas fa-trash'></i></a>
    @endcan
