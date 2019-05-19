<?php

namespace App\Http\Controllers;

use App\Model\AdminModel;
use Illuminate\Http\Request;
use App\Model\Admin\ShopOrderModel;
use App\model\Admin\ShopProductModel;

class AdminController extends Controller
{
    /**
     * Hàm khởi tạo của class được chạy ngay khi khởi tạo đổi tượng
     * Hàm này nó luôn được chạy trước các hàm khác trong class
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->only('index');
    }

    /**
     * Phương thức trả về view khi đăng nhập admin thành công
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $year = \DB::table('orders')->select(\DB::raw('YEAR(created_at) as year'))->orderBy('created_at', 'desc')->distinct()->get();
        $sum_money = ShopOrderModel::where('status', 1)->sum('total_price');
        $product = ShopProductModel::count();
        $invoice = \DB::table('orders')->count();

        return view('admin.dashboard', compact(['year', 'sum_money', 'product', 'invoice']));
    }

    public function getDataLine($year) {
        $money = \DB::table('orders')->select(\DB::raw('sum(total_price) as money, MONTH(created_at) as month'))->whereYear('created_at', $year)->where('status', 1)->groupBy(\DB::raw('MONTH(created_at)'))->get();
        $month = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
        foreach ($money as $value) {
            if($value->month) {
                $month[$value->month] = $value->money;
            }
        }

        return $month;

    }

    /**
     * Phương thức trả về view dùng để đăng ký tài khoản admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        //return view('admin.auth.register');
        return view('admin.auth.registertemplate');
    }


    public function store(Request $request) {

        // validate dữ liệu được gửi từ form đi
        $this->validate($request, array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ));

        // Khởi tạo model để lưu admin mới
        $adminModel = new AdminModel();
        $adminModel->name = $request->name;
        $adminModel->email = $request->email;
        $adminModel->password = bcrypt($request->password);
        $adminModel->save();

        return redirect()->route('admin.auth.login');
    }


}
