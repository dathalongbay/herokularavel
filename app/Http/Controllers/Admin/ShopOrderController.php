<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\OrderDetails;
use App\Model\Admin\ShopOrderModel;
use App\Model\Admin\ShopProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ShopOrderController extends Controller
{
    //

    /**
     * Hàm khởi tạo của class được chạy ngay khi khởi tạo đổi tượng
     * Hàm này nó luôn được chạy trước các hàm khác trong class
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index() {
        $items = DB::table('orders')->paginate(10);

        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();
        $data['orders'] = $items;

        return view('admin.content.shop.order.index', $data);
    }

    public function edit($id) {
        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();

        $item = ShopOrderModel::find($id);
        $data['order'] = $item;
        $data['order_details'] = OrderDetails::where('order_id', $id)
            ->orderBy('id', 'asc')
            ->get();

        $products = array();

        if (!empty($data['order_details'])) {
            foreach ($data['order_details'] as $detail) {
                $products[$detail->product_id] = ShopProductModel::find($detail->product_id);
            }
        }

        $data['products'] = $products;

        return view('admin.content.shop.order.edit', $data);
    }

    public function delete($id) {
        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();

        $item = ShopOrderModel::find($id);
        $data['order'] = $item;

        return view('admin.content.shop.order.delete', $data);
    }

    public function update(Request $request, $id) {

        $input = $request->all();

        $validatedData = $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',
            'customer_note' => 'required',
            'customer_address' => 'required',
            'customer_city' => 'required',
            'customer_country' => 'required',
            'total_price' => 'required',
            'status' => 'required',
        ]);
        
        $item = ShopOrderModel::find($id);

        $item->customer_name = $input['customer_name'];
        $item->customer_phone = $input['customer_phone'];
        $item->customer_email = $input['customer_email'];
        $item->customer_note = $input['customer_note'];
        $item->customer_address = $input['customer_address'];
        $item->customer_city = $input['customer_city'];
        $item->customer_country = $input['customer_country'];
        $item->total_price = $input['total_price'];
        $item->status = $input['status'];

        $item->save();

        return redirect('/admin/shop/order');
    }

    public function destroy($id) {
        $item = ShopOrderModel::find($id);

        $item->delete();

        $details = OrderDetails::where('order_id', $id)->get();
        foreach ($details as $detail) {
            $detail->delete();
        }

        return redirect('/admin/shop/order');
    }

    public function printView($id) {
        /**
         * Đây là biến truyền từ controller xuống view
         */
        $data = array();

        $item = ShopOrderModel::find($id);
        $data['order'] = $item;

        $data['order_details'] = OrderDetails::where('order_id', $id)
            ->orderBy('id', 'asc')
            ->get();

        $products = array();

        if (!empty($data['order_details'])) {
            foreach ($data['order_details'] as $detail) {
                $products[$detail->product_id] = ShopProductModel::find($detail->product_id);
            }
        }

        $data['products'] = $products;


        return view('admin.content.shop.order.printView', $data);
    }

    public function printInvoice($id) {

        $data = array();

        $item = ShopOrderModel::find($id);
        $order = $item;

        $order_details = OrderDetails::where('order_id', $id)
            ->orderBy('id', 'asc')
            ->get();

        $products = array();

        if (!empty($order_details)) {
            foreach ($order_details as $detail) {
                $products[$detail->product_id] = ShopProductModel::find($detail->product_id);
            }
        }
        $status_txt = '';
        if ($order->status == 0) {
            $status_txt = 'Chưa thanh toán';
        }
        if ($order->status == 1) {
            $status_txt = 'Đã thanh toán';
        }
        if ($order->status == 2) {
            $status_txt = 'Đang vận chuyển';
        }
        if ($order->status == 3) {
            $status_txt = 'Đã giao hàng';
        }
        if ($order->status == 4) {
            $status_txt = 'Hủy đơn';
        }

        $view = "<!DOCTYPE html>
            <html lang=\"en\">
            <head>      
                <meta charset=\"UTF-8\">        
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
                <title>Title</title>
                <style type='text/css'>
                body {
                    font-family: DejaVu Sans;
                    }
                    </style>
            </head>
            <body>
            ";

        $view .= "<div id=\"lightboxFrame\" class=\"row\" style=\"border: 1px solid black;margin-top: 30px;\">

        <div style=\"padding: 30px\">
            <h1> ĐƠN HÀNG SỐ ".$order->id." </h1>

            <div style=\"padding: 10px 10px 10px 0; font-size: 24px\">
                Tên khách hàng : ".$order->customer_name."
            </div>
            <div style=\"padding: 10px 10px 10px 0; font-size: 24px\">
                Email : ".$order->customer_email."
            </div>
            <div style=\"padding: 10px 10px 10px 0; font-size: 24px\">
                Số điện thoại : ".$order->customer_phone."
            </div>
            <div style=\"padding: 10px 10px 10px 0; font-size: 24px\">
                Địa chỉ : ".$order->customer_address ."
            </div>
            <div style=\"padding: 10px 10px 10px 0; font-size: 24px\">
                Thành phố : ".$order->customer_city." 
            </div>
            <div style=\"padding: 10px 10px 10px 0; font-size: 24px\">
                Tổng tiền : ".number_format($order->total_price)."  VNĐ
            </div>
            <div style=\"padding: 10px 10px 10px 0; font-size: 24px\">
                Trạng thái : ".$status_txt."                
            </div>
            <div style=\"padding: 10px 10px 10px 0; font-size: 18px\">
                <table class=\"table\">
                    <thead>
                    <tr>
                        <th style=\"width: 5%; text-align: center\">ID</th>
                        <th style=\"width: 25%; text-align: center\">Tên sản phẩm</th>
                        <th style=\"width: 25%; text-align: center\">Hình ảnh</th>
                        <th style=\"width: 15%; text-align: center\">Giá bán</th>
                    </tr>
                    </thead>
                    <tbody>";
                    foreach ($order_details as $order_detail) {
                         $product = isset($products[$order_detail->product_id]) ? $products[$order_detail->product_id] : array();
                        $view .= "<tr>
                            <td style=\"text-align: center\"> ".$product->id." </td>
                            <td style=\"text-align: center\"> ".$product->name." </td>
                            <td style=\"text-align: center\">";
                                $images = (isset($product->images) && $product->images) ? json_decode($product->images) : array();
                                if(!empty($images)) {
                                    foreach($images as $image) {
                                        $view .= "<img src=\"".asset($image)."\" style=\"margin-top:15px;max-height:100px;\">";
                                    }
                                }
                            $view .= "</td>
                            <td style=\"text-align: center\"> ".$order_detail->total_price." VND</td>
                        </tr>";
                        }
                    $view .= "</tbody>
                        </table>
                    </div>
                    <div style=\"padding: 10px 10px 10px 0; font-size: 18px\">
                        Ghi chú : ".strip_tags($order->customer_note)."
                    </div>
                </div>
            </div>";

        $view .= "
                </body>
                </html>";


        $a = fopen("my_html_file_written_with_php.html", 'w');
        fwrite($a, $view);
        fclose($a);
        chmod("my_html_file_written_with_php.html", 0644);


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        //$pdf->loadFile(public_path().'/my_html_file_written_with_php.html')->save(public_path().'/invoice_'.$order->id.time().'.pdf');
        //return $pdf->download('invoice_'.$order->id.time().'.pdf');
        return $pdf->stream('invoice_'.$order->id.time().'.pdf');
    }



}
