@extends('admin.layouts.glance')
@section('title')
Trang quản trị viên
@endsection
@section('content')
        <script src="{{asset('admin_assets/js/statistiacl.js')}}"></script>
        <div class="col_3">
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>{{$invoice}}</strong></h5>
                        <a href="{{'admin/shop/order'}}"><span>Số hóa đơn</span></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-laptop user1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>{{$product}}</strong></h5>
                        <a href="{{'admin/shop/product'}}"><span>Số sản phẩm</span></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-money user2 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>$1012</strong></h5>
                        <span>Nhập hàng</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>$450</strong></h5>
                        <span>Khách qua cửa hàng
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget">
                <div class="r3_counter_box">

                    <i class="pull-left fa fa-dollar icon-rounded"></i>
                    <div class="stats">
                        <h6><strong>@php echo number_format($sum_money)." đ" @endphp</strong></h6>
                        <span>Tổng tiền</span>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>

        <div class="row-one widgettable">
                <div class="col-lg-3">
                    <label>Năm</label>
                    <select class="form-control" id="year">
                        @foreach($year as $y)
                            <option value="{{$y->year}};">{{$y->year}}</option>
                        @endforeach

                    </select>
                </div>
                    <canvas id="lineChart"></canvas>
                    <div class="card-header">
                        <img src="{{ asset('admin_assets/images') }}/S3.jpg" alt="">
                    </div>



            <div class="clearfix"> </div>
        </div>

@endsection
