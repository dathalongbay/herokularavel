<?php

namespace App\Http\Controllers\Frontend;
use App\Model\Admin\ConfigModel;
use App\Model\Admin\ShopOrderModel;
use App\Model\Front\OrderDetailModel;
use App\Model\Front\OrderModel;
use App\Model\Front\ShopProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShopPaymentController extends Controller
{
    //

    public function index() {
        $data = array();

        $cartCollection = \Cart::getContent();

        $data['cart_products'] = $cartCollection;
        $products = array();

        foreach ($cartCollection as $p) {
            $pid = $p->id;
            $products[$pid] = ShopProductModel::find($pid);

        }
        $data['products'] = $products;
        $data['total_payment'] = \Cart::getTotal();
        $data['total_qtt_cart'] = \Cart::getTotalQuantity();

        return view('frontend.payment.index', $data);
    }

    public function order(Request $request) {
        $input = $request->all();

        $validatedData = $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required',
            'customer_note' => 'required',
            'customer_address' => 'required',
            'customer_city' => 'required',
            'customer_country' => 'required',
        ]);

        $cartCollection = \Cart::getContent();

        /**
         * Kiểm tra xem khách hàng cũ qua số điện thoại
         * nếu số điện thoại đã có trong đơn hàng
         * đã thanh toán sẽ giảm giá %
         */
        $discount_percent = 0;


        /*$olds = DB::table('orders')->where([
            ['customer_phone', ' = ', trim($input['customer_phone'])],
        ])->whereIn('status', [1, 3])->get();


        $olds = DB::table('orders')->where([
            ['customer_phone', ' = ', '08612345678'],
        ])->first();*/

        $olds1 = DB::table('orders')->where('customer_phone', trim($input['customer_phone']))
            ->where('status', 0)->first();

        $olds2 = DB::table('orders')->where('customer_phone', trim($input['customer_phone']))
            ->where('status', 3)->first();

        if ( (isset($olds1->id) && ($olds1->id > 0)) || (isset($olds2->id) && ($olds2->id > 0))) {

            $items = ConfigModel::all();

            $config = array();
            $config[] = 'web_name';
            $config[] = 'header_logo';
            $config[] = 'footer_logo';
            $config[] = 'intro';
            $config[] = 'desc';

            $default = array();

            /**
             * Tạo mặc định cho mảng config
             */
            foreach ($config as $item_config) {

                if (!isset($default[$item_config])) {
                    $default[$item_config] = '';
                }
            }

            /**
             * Lấy từ CSDL ra đè lại mảng $default
             */
            foreach ($items as $item) {

                $key = $item->name;
                $default[$key] = $item->value;
            }

            $global_settings = $default;
            $discount_percent = (int) $global_settings['customer_discount'];

        }

        $order = new OrderModel();

        $order->customer_name = $input['customer_name'];
        $order->customer_phone = $input['customer_phone'];
        $order->customer_email = $input['customer_email'];
        $order->customer_note = $input['customer_note'];
        $order->customer_address = $input['customer_address'];
        $order->customer_city = $input['customer_city'];
        $order->customer_country = $input['customer_country'];
        $order->total_price = \Cart::getTotal();

        $order->total_price = $order->total_price - (($order->total_price*$discount_percent)/100);
        $order->status = 0;

        $order->save();

        foreach ($cartCollection as $product) {
            $order_detail = new OrderDetailModel();

            $order_detail->order_id = $order->id;
            $order_detail->product_id = $product->id;
            $order_detail->quantity = $product->quantity;
            $order_detail->unit_price = $product->price;
            $order_detail->total_price = $product->price * $product->quantity;
            $order_detail->total_price = $order_detail->total_price - (($order_detail->total_price * $discount_percent)/100);
            $order_detail->status = 0;

            $order_detail->save();
        }

        \Cart::clear();

        return redirect('shop/payment/after');
    }

    public function afterOrder() {
        return view('frontend.payment.success');
    }
}
