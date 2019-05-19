<!-- newsletter -->
<div class="newsletter">
    <div class="container">
        <div class="col-md-6 w3agile_newsletter_left">
            <h3>Subscribe</h3>
            <p>Hãy click Subscribe để bết thêm thông tin sản phẩm.</p>
        </div>
        <div class="col-md-6 w3agile_newsletter_right">
            <form action="{{ url('/newsletter') }}" method="post">
                @csrf
                <input type="email" name="email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
                <input type="submit" value="Subscribe" />
            </form>
        </div>
        <div class="clearfix"> </div>
    </div>
</div>
<!-- //newsletter -->

