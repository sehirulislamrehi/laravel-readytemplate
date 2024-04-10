<div class="modal-header pd-y-20 pd-x-25">
     <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">{{ $role->name }}</h6>
</div>
<div class="modal-body pd-25">
     <form action="{{ route('role.update', $role->id) }}" method="post" class="ajax-form">
          @csrf
          <div class="row">

               <!-- Name -->
               <div class="col-md-12 form-group">
                    <label>Name</label>
                    <input class="form-control" type="text" name="name" value="{{ $role->name }}">
               </div>

               <!-- status -->
               <div class="col-md-12 col-12 form-group">
                    <label>Status</label>
                    <select class="form-control" name="is_active">
                         <option value="1" @if( $role->is_active == true ) selected @endif >Active</option>
                         <option value="0" @if( $role->is_active == false ) selected @endif >Inactive</option>
                    </select>
               </div>

          </div>

          <!-- permission -->
          <div class="row">
               <div class="col-md-3">

                    @foreach( $modules as $index => $module )
                    @foreach( $module->permission as $index_2 => $module_permission )
                    @if($module->key == $module_permission->key )
                    <div class="permission_block" style="padding: 0;">
                         <p style="
                                    border-bottom: 1px solid #e0d9d9;
                                    background: #323232;
                                    color: white;
                                    padding: 5px;
                                ">
                              <label>
                                   <input type="checkbox" class="module_check" name="permission[]" value="{{ $module_permission->id }}" @php $i=0; @endphp @foreach($role->permission as $role_permission)
                                   @if( $role_permission->id == $module_permission->id )
                                   {{ $i++ }}
                                   @endif
                                   @endforeach

                                   @if( $i != 0 )
                                   checked
                                   @endif
                                   >
                                   <span>{{ $module->name }}</span>
                              </label>
                         </p>
                         <div class="sub_module_block">
                              <ul>
                                   @foreach( $module->permission as $sub_module_permission )
                                   @if( $sub_module_permission->key != $module->key )
                                   <p>
                                        <label>
                                             <input type="checkbox" class="sub_module_check" name="permission[]" value="{{ $sub_module_permission->id }}" @php $j=0; @endphp @foreach( $role->permission as $role_permission )
                                             @if( $role_permission->id == $sub_module_permission->id )
                                             {{ $j++ }}
                                             @endif
                                             @endforeach

                                             @if( $i == 0 )
                                             disabled
                                             @endif
                                             @if( $j > 0 )
                                             checked
                                             @endif

                                             />
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
                    <button type="submit" class="btn btn-info">Update</button>
               </div>
          </div>
     </form>
</div>
<div class="modal-footer">
     <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
</div>

<script>
     $(".module_check").click(function(e) {
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