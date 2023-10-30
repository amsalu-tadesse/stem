@props(['userLists'])

<!-- /.modal -->
<div class="modal fade" id="update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update PPD Committee Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="ppdCommittee_update_form">
                @csrf
                <div class="modal-body">
                    <!-- /.card-body -->
                    <!-- row -->
                    <div class="card-body row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-partials.input-form title="Name" name="name" type="input" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currentSecretariat">Current Secretariat</label>
                                <select id='currentSecretariat' class="form-control" name="current_secretariat">
                                    <option value="">Select Current Secretariat</option>
                                    @foreach ($userLists as $userList)
                                    <option value="{{$userList->id}}">{{$userList->first_name}} {{$userList->middle_name}}{{$userList->last_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Description" name="description" />
                            </div>
                        </div>
                        <!--/.col (right) -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="ppdCommittee_id" id="ppdCommittee_id">
                    <button type="submit" class="btn btn-info">Save changes</button>
                </div>
            </form>
            <!-- /#user_form -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->