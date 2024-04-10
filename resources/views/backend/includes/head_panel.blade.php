<div class="br-header">
     <div class="br-header-left">
          <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
          <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>

     </div>
     <div class="br-header-right">
          <nav class="nav">

               <div class="dropdown">
                    <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                         <img src="{{ auth('web')->user()->image ? $get_file_path .'/'. auth('web')->user()->image : asset('images/user.png') }}" class="wd-32 rounded-circle" alt="">
                         <span class="square-10 bg-success"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-header wd-250" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-65px, 1px, 0px);">
                         <div class="tx-center">
                              <!-- <a href=""><img src="../img/img1.jpg" class="wd-80 rounded-circle" alt=""></a> -->
                              <h6 class="logged-fullname">{{ auth('web')->check() ? auth('web')->user()->name : "" }}</h6>
                              <p>{{ auth('web')->check() ? auth('web')->user()->email : "" }}</p>
                         </div>
                         <hr>
                         <ul class="list-unstyled user-profile-nav">
                              <li><a href="{{ route('user.edit.my.profile.page') }}"><i class="icon ion-ios-person"></i> Edit Profile</a></li>
                              <li>
                                   <a href="#" onclick="document.getElementById('logout-form').submit()">
                                        <i class="icon ion-power"></i> 
                                        Sign Out
                                        <form action="{{route('do.logout')}}" method="post" id="logout-form">@csrf</form>
                                   </a>
                              </li>
                         </ul>
                    </div>
               </div>
          </nav>
     </div>
</div>