@extends('frontend.layouts.fashion')
@section('title')
    Trang chủ
@endsection

@section('content')
    <?php $banner_main_image = isset($banner_main->image) ? asset($banner_main->image) : ''; ?>
    <?php $sale1_image = isset($sale1_banner->image) ? asset($sale1_banner->image) : ''; ?>
    <?php $sale2_image = isset($sale2_banner->image) ? asset($sale2_banner->image) : ''; ?>
    <?php $sale3_image = isset($sale3_banner->image) ? asset($sale3_banner->image) : ''; ?>
    <?php $sale4_image = isset($sale4_banner->image) ? asset($sale4_banner->image) : ''; ?>
    <?php $sale5_image = isset($sale5_banner->image) ? asset($sale5_banner->image) : ''; ?>
@if (isset($banner_main->id))
    <div class="banner-agile" style="background-image: url({{ $banner_main_image }})">
        <div class="container">
            <?php echo $banner_main->desc ?>

        </div>
    </div>
@endif
<div class="banner-bootom-w3-agileits">
    <div class="container">
        @if (isset($sale1_banner->id))
        <div class="col-md-5 bb-grids bb-left-agileits-w3layouts" >
            <a href="{{ $sale1_banner->link }}">
                <div class="bb-left-agileits-w3layouts-inner" style="background-image: url({{ $sale1_image }})">
                    <?php echo $sale1_banner->desc ?>
                </div></a>
        </div>
        @endif

        <div class="col-md-4 bb-grids bb-middle-agileits-w3layouts">
            @if (isset($sale2_banner->id))
            <a href="{{ $sale2_banner->link }}">
                <div class="bb-middle-top" style="background-image: url({{ $sale2_image }})">
                    <?php echo $sale2_banner->desc ?>
                </div></a>
            @endif
            @if (isset($sale3_banner->id))
            <a href="{{ $sale3_banner->link }}">
                <div class="bb-middle-bottom" style="background-image: url({{ $sale3_image }})">
                    <?php echo $sale3_banner->desc ?>
                </div></a>
            @endif
        </div>
        <div class="col-md-3 bb-grids bb-right-agileits-w3layouts">
            @if (isset($sale4_banner->id))
            <a href="{{ $sale4_banner->link }}">
                <div class="bb-right-top" style="background-image: url({{ $sale4_image }})">
                    <?php echo $sale4_banner->desc ?>
                </div></a>
            @endif
                @if (isset($sale5_banner->id))
            <a href="{{ $sale5_banner->link }}">
                <div class="bb-right-bottom" style="background-image: url({{ $sale5_image }})">
                    <?php echo $sale5_banner->desc ?>
                </div></a>
                @endif
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="top-products">
    <div class="container">
        <h3>Top Products</h3>
        <div class="sap_tabs">
            <div id="horizontalTab">
                <ul class="resp-tabs-list">
                    @foreach($homepage_category as $category)
                    <li class="resp-tab-item"><span>{{ $category->name }}</span></li>
                    @endforeach

                </ul>
                <div class="clearfix"> </div>
                <div class="resp-tabs-container">

                    @foreach($homepage_category as $category)
                    <div class="tab-1 resp-tab-content">
                        @if(isset($category['products']))
                        @foreach($category['products'] as $product)
                                <div class="col-md-3 top-product-grids tp2">
                                    <a href="{{ url('shop/product/'.$product->id)  }}"><div class="product-img">
                                            <?php
                                            $images = (isset($product->images) && $product->images) ? json_decode($product->images) : array();
                                            ?>
                                            @foreach($images as $image)
                                                <img src="{{ asset($image) }}" alt="" />
                                                @break
                                            @endforeach

                                            <div class="p-mask">

                                                <form action="<?php echo url('shop/cart/add') ?>" method="post">
                                                    @csrf
                                                    <input type="hidden" name="cmd" value="_cart" />
                                                    <input type="hidden" name="add" value="1" />
                                                    <input type="hidden" name="w3ls1_item" value="{{ $product->id }}" />
                                                    <input type="hidden" name="amount" value="{{ $product->priceSale }}" />
                                                    <button type="submit" class="w3ls-cart pw3ls-cart"><i class="fa fa-cart-plus" aria-hidden="true"></i> Add to cart</button>
                                                </form>
                                            </div>
                                        </div></a>
                                    <i class="fa fa-star yellow-star" aria-hidden="true"></i>
                                    <i class="fa fa-star yellow-star" aria-hidden="true"></i>
                                    <i class="fa fa-star yellow-star" aria-hidden="true"></i>
                                    <i class="fa fa-star gray-star" aria-hidden="true"></i>
                                    <i class="fa fa-star gray-star" aria-hidden="true"></i>
                                    <h4>{{ $product->name }}</h4>
                                    <h5>${{ $product->priceSale }}</h5>
                                </div>
                        @endforeach
                        @endif

                    </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend_assets/js') }}/easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true   // 100% fit in a container
        });
    });
</script>
<div class="fandt">
    <div class="container">
        <div class="col-md-6 features">
            <h3>Thông tin chi tiết</h3>
            <div class="support">
                <div class="col-md-2 ficon hvr-rectangle-out">
                    <i class="fa fa-user " aria-hidden="true"></i>
                </div>
                <div class="col-md-10 ftext">
                    <h4>Hỗ trợ khách hàng 24/7</h4>
                    <p>Hãy liên lạc với chúng tôi để được hỗ trợ một cách tốt nhất.</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="shipping">
                <div class="col-md-2 ficon hvr-rectangle-out">
                    <i class="fa fa-bus" aria-hidden="true"></i>
                </div>
                <div class="col-md-10 ftext">
                    <h4>Miễn phí vận chuyển</h4>
                    <p>Miễn phí phí giao hàng đối với hóa đơn >500.000 đồng.Nhận ship COD toàn quốc.</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="money-back">
                <div class="col-md-2 ficon hvr-rectangle-out">
                    <i class="fa fa-money" aria-hidden="true"></i>
                </div>
                <div class="col-md-10 ftext">
                    <h4>Hoàn lại tiền 100%</h4>
                    <p>Shop cam kết sản phẩm chính hãng 100%.Hoàn lại tiền nếu phát hiện sản phẩm fake.</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-6 testimonials">
            <div class="test-inner">
                <div class="wmuSlider example1 animated wow slideInUp" data-wow-delay=".5s">
                    <div class="wmuSliderWrapper">
                        <article style="position: absolute; width: 100%; opacity: 0;">
                            <div class="banner-wrap">
                                <img src="{{ asset('frontend_assets/images') }}/123.jpg" alt=" " class="img-responsive" />
                                <p>Chanel shop cam kết sản phẩm chính hãng, hợp thời trang,giá sinh viên.Mẫu mã đa dạng, đem lại sự hài lòng cho khachd hàng.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <script src="{{ asset('frontend_assets/js') }}/jquery.wmuSlider.js"></script>
    <script>
        $('.example1').wmuSlider();
    </script>
</div>

@endsection