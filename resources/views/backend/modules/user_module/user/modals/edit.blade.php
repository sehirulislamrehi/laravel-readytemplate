<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <form class="ajax-form" method="post" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('patch')
        <div class="row">
            <!-- name -->
            <div class="col-md-6 col-12 form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            </div>

            <!-- phone number -->
            <div class="col-md-6 col-12 form-group">
                <label for="phone">Phone</label><span class="require-span">*</span>
                <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}">
            </div>

            <!-- phone email -->
            <div class="col-md-6 col-12 form-group">
                <label for="email">Email</label><span class="require-span">*</span>
                <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}">
            </div>

            <!--User type-->
            {{--<div class="form-group col-md-12">
                <label for="userType">Type</label><span class="require-span">*</span>
                <select id="userType" name="type" class="form-control">
                    <option selected disabled>Choose...</option>
                    @foreach ($usertypes as $usertype)
                    <option value="{{ $usertype }}" @if( $user->type == $usertype ) selected @endif>{{ $usertype }}
                    </option>
                    @endforeach
                </select>
            </div>--}}

            <!-- select role -->
            {{--<div class="col-md-12 col-12 form-group select-role @if ($user->type=='vendor-administrator') d-block @else d-none @endif"
                 id="roleSelect">
                <label>Please select a user role</label><span class="require-span">*</span>
                <div class="role-block">
                    <select name="role_id" id="role" class="form-control role_id chosen">
                        <option value="" selected disabled>Select role</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @if( $user->role_id == $role->id ) selected @endif >{{
                            $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>--}}

            <!-- user status -->
            {{--<div class="col-md-12 col-12 form-group">
                <label>User Status</label>
                <select class="form-control" name="is_active">
                    <option value="1" @if( $user->is_active == true ) selected @endif >Active
                    </option>
                    <option value="0" @if( $user->is_active == false ) selected @endif >Inactive
                    </option>
                </select>
            </div>--}}

            <!--User location co-ordinate-->
            <div class="col-md-6 col-12 form-group">
                <label for="latitude">Latitude</label>
                <input type="number" id="latitude" step="any" value="{{ $user->latitude }}" class="form-control" name="latitude">
            </div>
            <div class="col-md-6 col-12 form-group">
                <label for="longitude">Longitude</label>
                <input type="number" id="longitude" step="any" value="{{ $user->longitude }}" class="form-control" name="longitude">
            </div>
            <!--User location co-ordinate-->
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


<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>

<script>
    // Changing usertype to vendor will make the role select box required
        document.getElementById('userType').addEventListener('change',function(e){
        const rolebox=document.getElementById('roleSelect');
        const role=document.getElementById('role');
        if(e.target.value==="vendor-administrator"){
            if(rolebox.classList.contains('d-none')){
               rolebox.classList.remove('d-none');
               rolebox.classList.add('d-block')
               role.required=true;
            }
        }
        else{
            if(rolebox.classList.contains('d-block')){
                rolebox.classList.remove('d-block')
                rolebox.classList.add('d-none');
                role.required=false;
                role.value=null;
                console.log(role.value)
            }
        }
    })
    $(document).ready(function domReady() {
        $(".chosen").chosen();
    });
</script>