  <!-- Modal -->
  <div class="modal fade" id="issue_show_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Issue Detail</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="card-body">

                      <div class="form-group row">
                          <label class="col-sm-2">Title</label>
                          <div class="col-sm-10">
                              <x-partials.textarea-input-for-show-modals name="title" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2">Description</label>
                          <div class="col-sm-10">
                              <x-partials.textarea-input-for-show-modals name="description" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2">Issue Level</label>
                          <div class="col-sm-10">
                              <x-partials.textarea-input-for-show-modals name="issue_level" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2">Approved Date</label>
                          <div class="col-sm-10">
                              <x-partials.textarea-input-for-show-modals name="start_date" /> 
                          </div>
                      </div>
                      {{-- <div class="form-group row">
                        <label class="col-sm-2">Approved Date</label>
                        <div class="col-sm-10">
                            <x-partials.textarea-input-for-show-modals name="end_date" />
                        </div>
                    </div> --}}
                      <div class="form-group row">
                          <label class="col-sm-2">Public Benefit</label>
                          <div class="col-sm-10">
                              <x-partials.textarea-input-for-show-modals name="public_benefit" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2">Private Benefit</label>
                          <div class="col-sm-10">
                              <x-partials.textarea-input-for-show-modals name="private_benefit" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2">Created By</label>
                          <div class="col-sm-10">
                              <x-partials.textarea-input-for-show-modals name="created_by" />
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-2">Documents</label>
                          <div class="col-sm-10" id="issue_attachments_list">
                          </div>
                      </div>

                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
