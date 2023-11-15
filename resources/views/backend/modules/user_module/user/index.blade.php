@extends('backend.template.layout')

@section('per_page_css')
    <link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .data-indicator ul {
            padding-left: 15px;
        }

        .data-indicator ul li {
            display: inline;
        }

        .password-box {
            position: relative;
        }

        .password-box .hide-password {
            display: none;
        }

        .password-box .fas {
            position: absolute;
            top: 60%;
            right: 30px;
            z-index: 10;
            cursor: pointer;
            color: #000;
        }

        .custom-file-input:lang(en)~.custom-file-label::after {
            content: "";
        }

        .custom-file-label::after {
            display: none;
        }
        #vendor_id-div,
        #status-div{
            display: none;
        }
    </style>
@endsection

@section('body-content')
    <div class="br-mainpanel">
        <div class="br-pageheader">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="breadcrumb-item active" href="#">All User</a>
            </nav>
        </div>
        <div class="br-pagebody">
            <div class="row">
               
            </div>
        </div>
        <!--User list table-->
        <div class="br-pagebody">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline table-responsive">
                        <div class="card-header text-right">
                            <!--Add new user-->
                            @if (can('add_user'))
                                <div class="align-self-right">
                                    <button type="button" data-content="{{ route('user.add.modal') }}"
                                        data-target="#largeModal" class="btn btn-outline-dark" data-toggle="modal">
                                        Add
                                    </button>
                                </div>
                            @endif
                            <!--End Add new user-->
                        </div>
                        <!--User listing-->
                        <div class="card-body">
                            <table class="table table-bordered table-striped dataTable dtr-inline user-datatable">
                                <thead>
                                    <tr class="text-center">
                                        <th>#SL</th>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key => $user)
                                        
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">No Data Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="float-right">{{ $users->links() }}</div>
                        </div>
                        <!--End User listing-->
                    </div>
                </div>
            </div>
        </div>
        <!--End User list table-->
    @endsection

    @section('per_page_js')
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="{{ asset('backend/js/custom-script.min.js') }}"></script>

        <script src="{{ asset('backend/js/datatable/jquery.validate.js') }}"></script>
        <script src="{{ asset('backend/js/datatable/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/js/datatable/dataTables.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('backend/js/ajax_form_submit.js') }}"></script>
        <script>
            document.getElementById('file').addEventListener('change', function(e) {
                let filename = document.getElementById('filename');
                filename.innerText = e.target.files[0].name;
            })
            // $(function() {
            //     $('.user-datatable').DataTable({
            //     });
            // });
        </script>
    @endsection
