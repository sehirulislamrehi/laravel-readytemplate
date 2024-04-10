<div class="modal-header pd-y-20 pd-x-25">
     <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Reset user password</h6>
</div>
<div class="modal-body pd-25">
     <form action="{{ route('user.reset', $user->id) }}" method="post" class="ajax-form">
          @csrf
          <div class="row">

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
                    <button type="submit" class="btn btn-info">Reset</button>
               </div>
          </div>
     </form>
</div>
<div class="modal-footer">
     <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
</div>