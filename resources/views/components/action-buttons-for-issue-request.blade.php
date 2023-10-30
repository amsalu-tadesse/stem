
@isset($show)
<a class='btn btn-sm' data-row_id="{{ $row_id }}" role="button" id="show_row">
    <i class='text-info far fa-eye'></i></a>
@endisset
{{-- <a class='btn btn-sm' data-user_id="{{ $row_id }}" role="button" id="update_user">
    <i class='text-info far fa-edit'></i></a> --}}
    {{-- @isset($delete)
   @else
<a class='btn btn-sm' onclick="delete_user(this, '{{ $row_id }}')" role="button">
    <i class='text-danger fas fa-trash'></i></a>
    @endisset --}}
