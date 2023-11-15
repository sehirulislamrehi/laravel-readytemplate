<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Reset <span class="text-danger">{{ $user->name }}</span> Password</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form class="ajax-form" method="post" action="{{ route('user.update.password', $user->id) }}">
        @csrf
        <!-- name -->
        <div class="row">
            <!--User's login creadentials password-->
            <div class="col-md-12 col-12 form-group">
                <label for="password">Password</label><span class="require-span">*</span>
                <input type="password" id="password" class="form-control" name="password">
            </div>
            <div class="col-md-12 col-12 form-group">
                <label for="password_confirmation">Confirm Password</label><span class="require-span">*</span>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
            </div>
        </div>
        <div class="col-md-12 form-group text-right">
            <button type="submit" class="btn btn-outline-dark">
                Reset
            </button>
        </div>

    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
