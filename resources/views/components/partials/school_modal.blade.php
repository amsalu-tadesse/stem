@props(['school_levels'])

<!-- /.modal -->
<div class="modal fade" id="update_modal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update School Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="school_update_form">
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
                            <div class="form-group">
                                <x-partials.textarea-input-form title="Address" name="address" type="input" />
                            </div>
                            <div class="form-group">
                                <label for="school_level">School Level</label>
                                <select id='school_level' class="school_level_select2 select2 form-control" name="school_level" data-placeholder="Pick school_level" data-dropdown-css-class="select2-blue">
                                    <option value="none" selected disabled>Select a school_level</option>
                                    @foreach ($school_levels as $school_level)
                                    <option value="{{ $school_level->id }}" {{ old('school_level') == $school_level->id ? 'selected' : '' }}>
                                        {{ $school_level->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_level')
                                <span class="invalid-feedback d-block">school_level not selected</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" name="school_id" id="school_id">
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