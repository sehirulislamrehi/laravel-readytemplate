<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $vendor_user->user->name }} : {{ $vendor_user->vendor->name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <form class="ajax-form" method="post" action="{{ route('user.vendor.plan.update',[
                                                        'user_id' => encrypt($vendor_user->user_id),
                                                        'vendor_id' => encrypt($vendor_user->vendor_id),
                                                    ]) }}">
        @csrf
        
        <div class="row">

            <!-- status -->
            <div class="col-md-12 col-12 form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" @if( $vendor_user->is_active == 1 ) selected @endif >Active</option>
                    <option value="0" @if( $vendor_user->is_active == 0 ) selected @endif >Inactive</option>
                </select>
            </div>

            <!--update-->
            <div class="col-md-12 form-group text-right">
                <button type="submit" class="btn btn-outline-dark">
                    Update
                </button>
            </div>

        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
