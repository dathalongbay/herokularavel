@extends('admin.layouts.print')
@section('title')
    Danh mục nội dung
@endsection
@section('content')

    <h2 style="text-align: center">
        <a class="btn btn-primary btnPrint" style="font-size: 20px; color: #0b0f28"><span class="fa fa-print"></span> In đơn hàng!</a></h2>

    <div id="lightboxFrame" class="row" style="border: 1px solid black;margin-top: 30px;">

        <div style="padding: 30px">
            <h1> ĐƠN HÀNG SỐ {{ $order->id }}</h1>

            <div style="padding: 10px 10px 10px 0; font-size: 24px">
                Tên khách hàng : {{ $order->customer_name }}
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 24px">
                Email : {{ $order->customer_email }}
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 24px">
                Số điện thoại : {{ $order->customer_phone }}
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 24px">
                Địa chỉ : {{ $order->customer_address }}
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 24px">
                Thành phố : {{ $order->customer_city }}
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 24px">
                Tổng tiền : {{ number_format($order->total_price) }} VNĐ
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 24px">
                Trạng thái :
                <?php echo ($order->status == 0) ? 'Chưa thanh toán' : '';  ?>
                <?php echo ($order->status == 1) ? 'Đã thanh toán' : '';  ?>
                <?php echo ($order->status == 2) ? 'Đang vận chuyển' : '';  ?>
                <?php echo ($order->status == 3) ? 'Đã giao hàng' : '';  ?>
                <?php echo ($order->status == 4) ? 'Hủy đơn' : '';  ?>
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 18px">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="width: 5%; text-align: center">ID</th>
                        <th style="width: 25%; text-align: center">Tên sản phẩm</th>
                        <th style="width: 25%; text-align: center">Hình ảnh</th>
                        <th style="width: 15%; text-align: center">Giá bán</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order_details as $order_detail)
                        <?php $product = isset($products[$order_detail->product_id]) ? $products[$order_detail->product_id] : array() ?>
                        <tr>
                            <td style="text-align: center">{{ $product->id }}</td>
                            <td style="text-align: center">{{ $product->name }}</td>
                            <td style="text-align: center">
                                <?php
                                $images = (isset($product->images) && $product->images) ? json_decode($product->images) : array();
                                ?>
                                @if(!empty($images))
                                    @foreach($images as $image)
                                        <img src="{{ asset($image) }}" style="margin-top:15px;max-height:100px;">
                                    @endforeach
                                @endif
                            </td>
                            <td style="text-align: center">{{ $order_detail->total_price }} VND</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding: 10px 10px 10px 0; font-size: 18px">
                Ghi chú : {{ strip_tags($order->customer_note) }}
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {
            function printDiv()
            {

                var divToPrint=document.getElementById('lightboxFrame');

                var newWin=window.open('','Print-Window');

                newWin.document.open();

                newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

                newWin.document.close();

                setTimeout(function(){newWin.close();},10);

            }

            $(".btnPrint").on('click', function (e) {
                e.preventDefault();
                //$(this).hide();
                //window.print();
                printDiv();
            });

        });
    </script>


@endsection
