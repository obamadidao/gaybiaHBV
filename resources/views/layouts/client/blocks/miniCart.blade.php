<div id="minicart-drawer" class="minicart-right-drawer offcanvas offcanvas-end" tabindex="-1">
    <!--MiniCart Empty-->
    <div id="cartEmpty" class="cartEmpty d-flex-justify-center flex-column text-center p-3 text-muted d-none">
        <div class="minicart-header d-flex-center justify-content-between w-100">
            <h4 class="fs-6 body-font">Your cart (0 Items)</h4>
            <button class="close-cart border-0" data-bs-dismiss="offcanvas" aria-label="Close"><i class="icon anm anm-times-r" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></button>
        </div>
        <div class="cartEmpty-content mt-4">
            <i class="icon anm anm-cart-l fs-1 text-muted"></i> 
            <p class="my-3">No Products in the Cart</p>
            <a href="index.html" class="btn btn-primary cart-btn">Continue shopping</a>
        </div>
    </div>
    <!--End MiniCart Empty-->

    <!--MiniCart Content-->
    <div id="cart-drawer" class="block block-cart">
        <div class="minicart-header">
            <button class="close-cart border-0" data-bs-dismiss="offcanvas" aria-label="Close"><i class="icon anm anm-times-r" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></button>
            <h4 class="fs-6 body-font">Your cart (2 Items)</h4>
        </div>
        <div class="minicart-content">
            <ul class="m-0 clearfix">
                <li class="item d-flex justify-content-center align-items-center">
                    <a class="product-image" href="product-layout1.html">
                        <img class="blur-up lazyload" data-src="assets/images/products/cart-tools-product-img1.jpg" src="assets/images/products/cart-tools-product-img1.jpg" alt="product" title="Product" width="120" height="170" />
                    </a>
                    <div class="product-details">
                        <a class="product-title" href="product-layout1.html">Tool Plasterer</a>
                        <div class="variant-cart my-2">Black / XL</div>
                        <div class="priceRow">
                            <div class="product-price">
                                <span class="price">$54.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="qtyDetail text-center">
                        <div class="qtyField">
                            <a class="qtyBtn minus" href="#;"><i class="icon anm anm-minus-r"></i></a>
                            <input type="text" name="quantity" value="1" class="qty">
                            <a class="qtyBtn plus" href="#;"><i class="icon anm anm-plus-r"></i></a>
                        </div>
                        <a href="#" class="edit-i remove"><i class="icon anm anm-pencil-ar" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
                        <a href="#" class="remove"><i class="icon anm anm-times-r" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
                    </div>
                </li>
                <li class="item d-flex justify-content-center align-items-center">
                    <a class="product-image" href="product-layout1.html">
                        <img class="blur-up lazyload" data-src="assets/images/products/cart-tools-product-img2.jpg" src="assets/images/products/cart-tools-product-img2.jpg" alt="product" title="Product" width="120" height="170" />
                    </a>
                    <div class="product-details">
                        <a class="product-title" href="product-layout1.html">Hammer Tool</a>
                        <div class="variant-cart my-2">Yellow / M</div>
                        <div class="priceRow">
                            <div class="product-price">
                                <span class="price old-price">$114.00</span><span class="price">$99.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="qtyDetail text-center">
                        <div class="qtyField">
                            <a class="qtyBtn minus" href="#;"><i class="icon anm anm-minus-r"></i></a>
                            <input type="text" name="quantity" value="1" class="qty">
                            <a class="qtyBtn plus" href="#;"><i class="icon anm anm-plus-r"></i></a>
                        </div>
                        <a href="#" class="edit-i remove"><i class="icon anm anm-pencil-ar" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
                        <a href="#" class="remove"><i class="icon anm anm-times-r" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="minicart-bottom">
            <div class="shipinfo">
                <div class="progress mb-2"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div></div>
                <div class="freeShipMsg"><i class="icon anm anm-truck-l fs-6 me-2 align-middle"></i>Only <span class="money" data-currency-usd="$199.00" data-currency="USD">$199.00</span> away from <b>Free Shipping</b></div>
                <div class="freeShipMsg d-none"><i class="icon anm anm-truck-l fs-6 me-2 align-middle"></i>Congrats! You are eligible for <b>Free Shipping</b></div>
            </div>
            <div class="subtotal clearfix my-3">
                <div class="totalInfo clearfix mb-1 d-none"><span>Shipping:</span><span class="item product-price">$10.00</span></div>
                <div class="totalInfo clearfix mb-1 d-none"><span>Tax:</span><span class="item product-price">$0.00</span></div>
                <div class="totalInfo clearfix"><span>Total:</span><span class="item product-price">$163.00</span></div>

            </div>
            <div class="agree-check customCheckbox">
                <input id="prTearm" name="tearm" type="checkbox" value="tearm" required />
                <label for="prTearm"> I agree with the </label><a href="#" class="ms-1 text-link">Terms &amp; conditions</a>
            </div>
            <div class="minicart-action d-flex mt-3">
                <a href="checkout-style1.html" class="proceed-to-checkout btn btn-primary w-50 me-1">Check Out</a>
                <a href="cart-style1.html" class="cart-btn btn btn-secondary w-50 ms-1">View Cart</a>
            </div>
        </div>
    </div>
    <!--MiniCart Content-->
</div>