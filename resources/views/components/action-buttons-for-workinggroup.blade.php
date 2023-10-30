@if($status =='1')
<a class='btn btn-md' onclick="unAuthorizeWorkingGroup(this, '{{ $row_id }}')" role="button">
<span id="nikebtn" class="fa fa-unlock" style="color: green;">&nbsp; Authorized</span>
</a>
@else
<a class='btn btn-md' onclick="authorizeWorkingGroup(this, '{{ $row_id }}')" role="button">
    <span id="xbtn" class="fa fa-lock" style="color: #ff6c99; text-align: left">&nbsp; Access Denied</span>
</a>
@endif
