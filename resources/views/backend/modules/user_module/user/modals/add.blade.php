<div class="modal-header pd-y-20 pd-x-25">
    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add new user</h6>
</div>
<div class="modal-body pd-25">
    <form action="{{ route('user.add') }}" method="post" class="ajax-form">
        @csrf
        <div class="row">

            <!-- Name -->
            <div class="col-md-12 form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="name">
            </div>

            <!-- Email -->
            <div class="col-md-12 form-group">
                <label>Email</label>
                <input class="form-control" type="text" name="email">
            </div>

            <!-- Phone -->
            <div class="col-md-12 form-group">
                <label>Phone</label>
                <input class="form-control" type="text" name="phone">
            </div>

            <!-- Role -->
            <div class="col-md-12 form-group">
                <label>Select role</label>
                <select class="form-control chosen" name="role_id">
                    <option value="" selected>Select role</option>
                    @foreach( $roles as $role )
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Password -->
            <div class="col-md-12 form-group">
                <label>Password</label>
                <input class="form-control" type="password" name="password">
            </div>

            <!-- Password confirmation -->
            <div class="col-md-12 form-group">
                <label>Password confirmation</label>
                <input class="form-control" type="password" name="password_confirmation">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-layout-footer">
                <button type="submit" class="btn btn-info">Create</button>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
</div>

<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>
<script>
    $(document).ready(function domReady() {
        $(".chosen").chosen();
    });
</script>