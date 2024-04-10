<div class="modal-header pd-y-20 pd-x-25">
    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add new role</h6>
</div>
<div class="modal-body pd-25">
    <form action="{{ route('role.add') }}" method="post" class="ajax-form">
        @csrf
        <div class="row">

            <!-- Name -->
            <div class="col-md-12 form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="name">
            </div>

        </div>

        <!-- permission -->
        <div class="row">
            <div class="col-md-3">
                @foreach( $modules as $module )
                @foreach( $module->permission as $module_permission )
                @if($module->key == $module_permission->key )
                <div class="permission_block" style="padding: 0">
                    <p style="
                                    border-bottom: 1px solid #e0d9d9;
                                    background: #323232;
                                    color: white;
                                    padding: 5px;
                                ">
                        <label>
                            <input type="checkbox" class="module_check" name="permission[]" value="{{ $module_permission->id }}" />
                            <span>{{ $module->name }}</span>
                        </label>
                    </p>
                    <div class="sub_module_block">
                        <ul>
                            @foreach( $module->permission as $sub_module_permission )
                            @if( $sub_module_permission->key != $module->key )
                            <p>
                                <label>
                                    <input type="checkbox" class="sub_module_check" name="permission[]" disabled value="{{ $sub_module_permission->id }}" />
                                    <span>{{ $sub_module_permission->display_name }}</span>
                                </label>
                            </p>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                @endforeach
                @endforeach
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

<script>
    $(".module_check").click(function (e) {
        let $this = $(this);
        if (e.target.checked == true) {
            $this.closest(".permission_block").find(".sub_module_block").find(".sub_module_check").removeAttr(
                "disabled")
        } else {
            $this.closest(".permission_block").find(".sub_module_block").find(".sub_module_check").attr(
                "disabled", "disabled")
        }
    })
</script>