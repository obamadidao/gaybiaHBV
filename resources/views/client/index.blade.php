<!-- Start Product Image -->
<div class="product-image">
<!-- Start Product Image -->
                                                    <a href="product-layout1.html" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
                                                    <a href="{{ route('client.product', $product->slug) }}" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
<!-- End Product Image -->
<!-- Product label -->
<div class="product-labels"><span class="lbl pr-label3">New</span></div>
@@ -104,7 +104,7 @@
<!--End Product Vendor-->
<!-- Product Name -->
<div class="product-name">
                                                        <a href="product-layout1.html">{{$product->name}}</a>
                                                        <a href="{{ route('client.product', $product->slug) }}">{{$product->name}}</a>
</div>
<!-- End Product Name -->
<!-- Product Price -->
@@ -147,7 +147,7 @@
<!-- Start Product Image -->
<div class="product-image">
<!-- Start Product Image -->
                                                    <a href="product-layout1.html" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
                                                    <a href="{{ route('client.product', $product->slug) }}" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
<!-- End Product Image -->
<!-- Product label -->
<div class="product-labels"><span class="lbl pr-label3">Sale</span></div>
@@ -169,7 +169,7 @@
<!--End Product Vendor-->
<!-- Product Name -->
<div class="product-name">
                                                        <a href="product-layout1.html">{{$product->name}}</a>
                                                        <a href="{{ route('client.product', $product->slug) }}">{{$product->name}}</a>
</div>
<!-- End Product Name -->
<!-- Product Price -->
@@ -212,7 +212,7 @@
<!-- Start Product Image -->
<div class="product-image">
<!-- Start Product Image -->
                                                    <a href="product-layout1.html" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
                                                    <a href="{{ route('client.product', $product->slug) }}" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
<!-- End Product Image -->
<!-- Product label -->
<div class="product-labels"><span class="lbl pr-label3">Hot</span></div>
@@ -234,7 +234,7 @@
<!--End Product Vendor-->
<!-- Product Name -->
<div class="product-name">
                                                        <a href="product-layout1.html">{{$product->name}}</a>
                                                        <a href="{{ route('client.product', $product->slug) }}">{{$product->name}}</a>
</div>
<!-- End Product Name -->
<!-- Product Price -->