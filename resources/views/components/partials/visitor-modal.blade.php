<!-- /.modal -->
@props(['institutions', 'institution_types','countries'])

<div class="modal" tabindex="-1" role="dialog" id="visitor_create_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Make Appointment</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="visitor_create_form">
                @csrf
                <div class="modal-body row">
                    <!-- /.card-body -->
                    <!-- left column -->
                    <div class="col-md-6 p-2">
                        <div class='form-group p-2'>
                            <label for='institution'>Institution</label>
                            <select name='institution_id' class='institutions_select2 select2 form-control'
                                id='institution_id' data-dropdown-css-class='select2-blue'>
                                <option value=''>Select institution</option>
                                @foreach ($institutions as $institution)
                                    <option value='{{ $institution->id }}'>
                                        {{ $institution->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group p-2">
                            <x-partials.input-form title="Responsible Person" name="responsible_person"
                                type="input" />
                            <span class="text-danger error" id="responsible_person_error"></span>

                        </div>
                        <div class="form-group p-2">
                            <x-partials.input-form title="Phone Number" name="phone_number" type="tel" />
                            <span class="text-danger error" id="phone_error"></span>
                        </div>
                        <div class='form-group p-2'>
                            <label for='country'>Country</label>
                            <select name='country_id' class='countries_select2 select2 form-control'
                                id='country_id' data-dropdown-css-class='select2-blue'>
                                <option value=''>Select country</option>
                                @foreach ($countries as $country)
                                    <option value='{{ $country->id }}'>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 p-2">
                        <div class='form-group p-2'>
                            <label for='institution_type'>Institution Type</label>
                            <select name='institution_type_id' class='institution_types_select2 select2 form-control'
                                id='institution_type_id' data-dropdown-css-class='select2-blue'>
                                <option value=''>Select institution type</option>
                                @foreach ($institution_types as $institution_type)
                                    <option value='{{ $institution_type->id }}'>
                                        {{ $institution_type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group p-2">
                            <x-partials.input-form title="Email" name="email" type="email" />
                            <span class="text-danger error" id="email_error"></span>

                        </div>
                        <div class="form-group p-2">
                            <x-partials.input-form title="Number of Visitors" name="visitor_count" type="number" />
                            <span class="text-danger error" id="visitor_count_error"></span>
                        </div>
                        <div class="form-group p-2">
                            <x-partials.textarea-input-form title="Description" name="description" type="text" />
                            <span class="text-danger error" id="visitor_count_error"></span>
                        </div>
                        <input type="hidden" name="selected_date" id="create_selected_date">
                        <input type="hidden" name="selected_day_range" id="create_selected_day_range">
                        <input type="hidden" name="created_from" id="created_from"
                         value="{{ request()->query('redirect') }}">

                    </div>
                </div>
                <div class="modal-footer justify-content-between p-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <input type="hidden" name="course_id" id="course_id"> --}}
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
            <!-- /#user_form -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
