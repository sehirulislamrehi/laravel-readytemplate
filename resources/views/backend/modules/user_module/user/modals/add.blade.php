<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form class="ajax-form" action="{{ route('user.add') }}" method="POST">
        @csrf
        <div class="row">
            <!-- User name -->
            <div class="col-md-4 col-12 form-group">
                <label for="name">Name</label><span class="require-span">*</span>
                <input type="text" id="name" class="form-control" name="name">
            </div>

            <!-- User email -->
            <div class="col-md-4 col-12 form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" name="email">
            </div>

            <!-- User phone -->
            <div class="col-md-4 col-12 form-group">
                <label for="phone">Phone</label><span class="require-span">*</span>
                <input type="text" id="phone" class="form-control" name="phone">
            </div>

            <!--User type-->
            <div class="form-group col-md-12 col-12">
                <label for="userType">User Type</label><span class="require-span">*</span>
                <select id="userType" name="type" class="form-control" onchange="userTypeChange(this)">
                    <option selected disabled>Choose...</option>
                    @foreach ($usertypes as $usertype)
                    <option value="{{ $usertype }}">{{ $usertype }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!--Buisness unit id-->
            <div class="form-group col-md-4 col-12" id="vendor_id-div">
                <label for="vendorId">Vendor</label><span class="require-span">*</span>
                <select id="vendorId" name="vendor_id" class="form-control">
                    <option selected disabled>Choose...</option>
                    @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>

            <!--User active status-->
            <div class="form-group col-md-4 col-12" id="status-div">
                <label for="activeStatus">Active status</label><span class="require-span">*</span>
                <select id="activeStatus" name="is_active" class="form-control">
                    <option selected disabled>Choose...</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <!--User role depend on the user type vendor-->
            <div class="form-group col-md-4 col-12 d-none">
                <label for="role">Role</label><span class="require-span">*</span>
                <select id="role" name="role_id" class="form-control">
                    <option selected disabled>Choose...</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="row">
            <!--User's login creadentials password-->
            <div class="col-md-6 col-12 form-group">
                <label for="password">Password</label><span class="require-span">*</span>
                <input type="password" id="password" class="form-control" name="password">
            </div>
            <div class="col-md-6 col-12 form-group">
                <label for="password_confirmation">Confirm Password</label><span class="require-span">*</span>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
            </div>
        </div>
        <div class="row">
            <!--User's latitude and longitude-->
            <div class="col-md-6 col-12 form-group">
                <label for="latitude">Latitude</label>
                <input type="number" id="latitude" class="form-control" name="latitude">
            </div>
            <div class="col-md-6 col-12 form-group">
                <label for="longitude">Longitude</label>
                <input type="number" id="longitude" class="form-control" name="longitude">
            </div>
        </div>
        <div class="row">
            

        </div>
        <div class="col-md-12 form-group text-right">
            <button type="submit" class="btn btn-outline-dark">
                Add
            </button>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>


<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>
<script type="text/javascript">
    // Changing usertype to vendor will make the role select box required
    document.getElementById('userType').addEventListener('change',function(e){
        const dependent=document.getElementById('role');
        const vendor_id_dom = document.getElementById("vendor_id-div")
        const status_dom = document.getElementById("status-div")

        if(e.target.value==="vendor-administrator"){
            vendor_id_dom.style.display = 'block'
            status_dom.style.display = 'block'

            if(dependent.parentElement.classList.contains('d-none')){
                dependent.parentElement.classList.remove('d-none');
                dependent.required=true;
            }
        }
        else{
            vendor_id_dom.style.display = 'none'
            status_dom.style.display = 'none'

            if(!dependent.parentElement.classList.contains('d-none')){
                dependent.parentElement.classList.add('d-none');
                dependent.required=false;
            }
        }
    })
    $(document).ready(function domReady() {
        $(".chosen").chosen();
    });
</script>
