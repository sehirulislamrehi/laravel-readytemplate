@extends("backend.template.layout")

@section('per_page_css')
<style>
    .small-box .inner h3 {
        font-size: 18px;
    }
</style>
@endsection

@section('body-content')
<div class="br-mainpanel">
    <div class="br-pagetitle">
    </div>

    <div class="br-pagebody">
        <div class="row row-sm">

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #127383">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"></p>
                            <span class="tx-11 tx-roboto tx-white-8">Companies</span>
                        </div>
                    </div>
                    <div id="ch1" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->

            

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #6c6c6c">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"></p>
                            <span class="tx-11 tx-roboto tx-white-8">Users</span>
                        </div>
                    </div>
                    <div id="ch2" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #703146">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"></p>
                            <span class="tx-11 tx-roboto tx-white-8">Contact Group</span>
                        </div>
                    </div>
                    <div id="ch3" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #4f52a7">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1"></p>
                            <span class="tx-11 tx-roboto tx-white-8">Unique Numbers</span>
                        </div>
                    </div>
                    <div id="ch4" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->
            
        </div>

        <div class="row row-sm charts mt-5">


            <div class="col-md-6 pr-2 mb-5">
                <div class="card">
                    <div class="card-header">
                        Last 12 month campaign details
                    </div>
                    <div class="card-body" id="campaign-details">
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6 pr-2 mb-5">
                <div class="card">
                    <div class="card-header">
                        Last 6 month success & failed rate
                    </div>
                    <div class="card-body" id="campaign-rate">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section("per_page_js")
<script src="{{ asset('backend/js/apexcharts/apexcharts.js') }}"></script>

@endsection