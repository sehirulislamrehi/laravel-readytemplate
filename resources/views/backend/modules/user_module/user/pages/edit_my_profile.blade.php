@extends("backend.template.layout")

@section('per_page_css')
<style>
     .avatar-upload {
          position: relative;
          max-width: 205px;
          margin: 50px auto;
     }

     .avatar-upload .avatar-edit {
          position: absolute;
          right: 12px;
          z-index: 1;
          top: 10px;
     }

     .avatar-upload .avatar-edit input {
          display: none;
     }

     .avatar-upload .avatar-edit input+label {
          display: inline-block;
          width: 34px;
          height: 34px;
          margin-bottom: 0;
          border-radius: 100%;
          background: #FFFFFF;
          border: 1px solid transparent;
          box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
          cursor: pointer;
          font-weight: normal;
          transition: all 0.2s ease-in-out;
     }

     .avatar-upload .avatar-edit input+label:hover {
          background: #f1f1f1;
          border-color: #d6d6d6;
     }

     .avatar-upload .avatar-edit input+label:after {
          content: "\f040";
          font-family: 'FontAwesome';
          color: #757575;
          position: absolute;
          top: 10px;
          left: 0;
          right: 0;
          text-align: center;
          margin: auto;
     }

     .avatar-upload .avatar-preview {
          width: 192px;
          height: 192px;
          position: relative;
          border-radius: 100%;
          border: 6px solid #F8F8F8;
          box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
     }

     .avatar-upload .avatar-preview>div {
          width: 100%;
          height: 100%;
          border-radius: 100%;
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center;
     }
</style>
@endsection

@section('body-content')
<div class="br-mainpanel">

     <div class="br-profile-page">

          <!-- header -->
          <div class="card shadow-base bd-0 rounded-0 widget-4">
               <div class="card-body">
                    <h4 class="tx-normal tx-roboto tx-white">{{ $auth ? $auth->name : "" }}</h4>
                    <p class="">{{ $auth ? $auth->email : "" }}</p>
                    <p class="mg-b-25">{{ $auth ? $auth->phone : "" }}</p>

               </div>
          </div>
          <!-- header -->

          <!-- tabs -->
          <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center shadow-base">
               <ul class="nav nav-outline active-info align-items-center flex-row" role="tablist">
                    <li class="nav-item">
                         <a class="nav-link active show" data-toggle="tab" href="#profile" role="tab" aria-selected="true">
                              Profile
                         </a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link" data-toggle="tab" href="#change-password" role="tab" aria-selected="false">
                              Change Password
                         </a>
                    </li>
               </ul>
          </div>
          <!-- tabs -->

          <!-- tabs content -->
          <div class="tab-content br-profile-body">

               <!-- tab-pane start -->
               <div class="tab-pane fade active show" id="profile">
                    <div class="row">
                         <div class="col-md-12">
                              <div class="media-list bg-white rounded shadow-base">
                                   <div class="pd-20 pd-xs-30">
                                        <form action="{{ route('user.edit.my.profile') }}" method="post" class="ajax-form" enctype="multipart/form-data">
                                             @csrf
                                             <div class="row">

                                                  <!-- Profile Image -->
                                                  <div class="col-md-12 form-group">
                                                       <div class="container">
                                                            <h1>
                                                                 Profile Image
                                                                 <small>200x200</small>
                                                            </h1>
                                                            <div class="avatar-upload">
                                                                 <div class="avatar-edit">
                                                                      <input type='file' name="file" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                                      <label for="imageUpload"></label>
                                                                 </div>
                                                                 <div class="avatar-preview">
                                                                      <div id="imagePreview" style="background-image: url({{ $image }});">
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <!-- Name -->
                                                  <div class="col-md-12 form-group">
                                                       <label>Name</label>
                                                       <input class="form-control" type="text" name="name" value="{{ $auth ? $auth->name : '' }}">
                                                  </div>

                                                  <!-- Email -->
                                                  <div class="col-md-12 form-group">
                                                       <label>Email</label>
                                                       <input class="form-control" type="text" name="email" value="{{ $auth ? $auth->email : '' }}">
                                                  </div>

                                                  <!-- Phone -->
                                                  <div class="col-md-12 form-group">
                                                       <label>Phone</label>
                                                       <input class="form-control" type="text" name="phone" value="{{ $auth ? $auth->phone : '' }}">
                                                  </div>
                                             </div>
                                             <div class="row">
                                                  <div class="col-md-12 form-layout-footer">
                                                       <button type="submit" class="btn btn-info">Update Information</button>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- tab-pane end -->

               <!-- tab-pane start -->
               <div class="tab-pane fade" id="change-password">
                    <div class="row">
                         <div class="col-md-12">
                              <div class="media-list bg-white rounded shadow-base">
                                   <div class="pd-20 pd-xs-30">
                                        <form action="{{ route('user.edit.my.password') }}" method="post" class="ajax-form">
                                             @csrf
                                             <div class="row">

                                                  <!-- Old Password -->
                                                  <div class="col-md-12 form-group">
                                                       <label>Old Password</label>
                                                       <input class="form-control" type="password" name="old_password">
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
                                                       <button type="submit" class="btn btn-info">Change Password</button>
                                                  </div>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <!-- tab-pane end -->
          </div>
          <!-- tabs content -->

     </div>
</div>


@endsection

@section('per_page_js')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('backend/js/custom-script.min.js') }}"></script>
<script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>
<script>
     function readURL(input) {
          if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
               }
               reader.readAsDataURL(input.files[0]);
          }
     }
     $("#imageUpload").change(function() {
          readURL(this);
     });
</script>
@endsection