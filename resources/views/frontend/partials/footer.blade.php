<div class="footer">
    <div class="container">
        <div class="col-md-4 footer-grids fgd1">
            <a href="{{ url('/') }}"><img src="{{ asset($fe_global_settings['footer_logo']) }}" alt=" " /><h3><?php echo $fe_global_settings['web_name'] ?></h3></a>
            <ul>
                <li>Mở cửa 8:00 - 22:00</li>
                <li>Đia chỉ: 197 Cầu giấy Hà Nội</li>
                <li>email: chanelshop197@gmail.com</li>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </ul>
        </div>
        <div class="col-md-4 footer-grids fgd2">
            <h4>Tài khoản</h4>
            <ul>
                <li>NGUYỄN THỊ MAI</li>
                <li>Ngân hàng :BIDV</li>
                <li>Số tài khoản:018277388934</li>
                <li>Chi nhánh: Cầu giấy-Hà Nội</li>
            </ul>
        </div>
        <div class="col-md-4 footer-grids fgd4">
            <h4>My Account</h4>
            <ul>
                @guest
                    <li>
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li>
                            <a href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li>
                        <a href="{{ route('logout') }}">{{ Auth::user()->name }} {{  __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
        <div class="clearfix"></div>
        <p class="copy-right">©Chanelshop cam kết hàng chính hãng</p>
    </div>
</div>
