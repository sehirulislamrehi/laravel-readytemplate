<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $user->name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <form class="ajax-form" method="post" action="{{ route('user.vendor.plan.add',encrypt($user->id)) }}">
        @csrf
        
        <div class="row">

            <!-- Vendor -->
            <div class="col-md-12 col-12 form-group">
                <label>Vendor</label>
                <select name="vendor_id" class="form-control">
                    @foreach( $vendors as $vendor )
                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- status -->
            <div class="col-md-12 col-12 form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
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
