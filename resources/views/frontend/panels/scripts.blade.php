<!-- Dependency Scripts -->
<script src="{{ asset('themes/frontend/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!-- JS -->
<script src="{{ asset('themes/frontend/assets/js/index.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/js/homepage.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/js/products.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/js/services.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/js/about-us.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/js/blog.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/js/blog-detail.js') }}"></script>
<script src="{{ asset('themes/frontend/assets/js/sweetalert2.all.min.js') }}"></script>

<script>
    (function($) {
        $(document).ready(function() {
            $('.share-facebook').click(function(e) {
                e.preventDefault();
                window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + (
                        $(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 -
                        225) +
                    ', toolbar=0, location=0, menubar=0,         directories=0, scrollbars=0');
                return false;
            });
        });
        // Form ajax default
        $(".form_ajax").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    form[0].reset();
                    alert(response.message);
                    location.reload();
                },
                error: function(response) {
                    // Get errors
                    console.log(response);
                    var errors = response.responseJSON.errors;
                    // Foreach and show errors to html
                    var elementErrors = '';
                    $.each(errors, function(index, item) {
                        if (item === 'CSRF token mismatch.') {
                            item = "@lang('CSRF token mismatch.')";
                        }
                        elementErrors += '<p>' + item + '</p>';
                    });
                }
            });
        });

        $(document).on('click', '.add-to-cart', function() {
            let _root2 = $(this).find('.button');
            let _root = $(this);
            let _html = _root.html();
            let _id = _root.attr("data-id");
            let _quantity = _root.attr("data-quantity") ?? $("#quantity").val();
            let _size = $(".data-size .data-parameter.checked").attr("data") ?? "";
            let _color = $(".data-color .data-parameter.checked").attr("data") ?? "";

            // _root2.addClass('loading');

            if (_id > 0) {
                var url = "{{ route('frontend.order.add_to_cart') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": _id,
                        "quantity": _quantity,
                        "size": _size,
                        "color": _color
                    },
                    success: function(data) {
                        _root.html(_html);
                        window.location.reload();
                    },
                    error: function(data) {
                        // Get errors
                        var errors = data.responseJSON.message;
                        alert(errors);
                        location.reload();
                    }
                });
            }
        });

        $(".update-cart").change(function(e) {
            e.preventDefault();
            var ele = $(this);
            $.ajax({
                url: '{{ route('frontend.order.cart.update') }}',
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    key: ele.parents("tr").attr("data-arr"),
                    quantity: ele.parents("tr").find(".qty").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $('.remove-card').on('click', function(e) {
            e.preventDefault();

            if (confirm("{{ __('Are you sure want to remove?') }}")) {
                var id = $(this).attr('data-id');
                var key = $(this).attr('data-arr');
                // var mini_cart = $(this).closest('.mini-cart');
                // var _this=$(this);
                $.ajax({
                    url: '{{ route('frontend.order.cart.remove') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        key: key,
                    },
                    success: function(response) {
                        location.reload();
                        // _this.closest('li').remove();
                        // mini_cart.find('.cart-count').text(mini_cart.find('.cart-list-wrap .cart-list li').length);
                        // if (!mini_cart.find('.cart-list-wrap .cart-list li').length) {
                        //     mini_cart.find('.cart-empty-wrap').show();
                        //     mini_cart.find('.cart-list-wrap').hide();
                        // }
                        // var total=0;
                        // $('.each_cart').each(function(){
                        //   var each_quantity=Number($(this).find('.quantity_num').text());
                        //   var each_price=Number($(this).find('.price_num').text());
                        //   var each_total=each_quantity*each_price;
                        //   total+=Number(each_total);
                        // })
                        // $('.total-price-number').text('$'+total);
                        // $('body').append('<div class="cart-product-added"><div class="added-message">Product was added to cart successfully!</div>');
                        //   setTimeout(function() {
                        //       $(".cart-product-added").fadeOut(1000, function() {});
                        //   }, 1500);
                    }
                });
            }
        })

        const filterArray = (array, fields, value) => {
            fields = Array.isArray(fields) ? fields : [fields];
            return array.filter((item) => fields.some((field) => item[field] === value));
        };
    })(jQuery);

    function loadMore(cl = '', view = '', type = '') {
        const productGroup = $(cl + ".active");
        var perpage = productGroup.attr('data-perpage');
        var currentpage = productGroup.attr('data-currentpage');
        var lastpage = productGroup.attr('data-lastpage');
        var taxonomy = productGroup.attr('data-taxonomy');
        var lang = '{{ $locale ?? 'vi' }}';
        var url = "{{ route('frontend.view_more') }}";
        var items = '';
        productGroup.attr('data-currentpage', (Number(currentpage) + 1));
        if (Number(currentpage) + 1 >= lastpage) {
            productGroup.find('.main-button-m').hide();
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
                "taxonomy": taxonomy,
                "lastpage": lastpage,
                "currentpage": currentpage,
                "perpage": perpage,
                "lang": lang,
                "type": type,
            },
            success: function(response) {
                
                $.each(response.data, function(key, val) {
                    if (type == 'product') {
                        items += `
                    <li class="products-item">
                        <div class="image">
                            <img src="` + val.image + `"
                                alt="` + val.name + `"
                                title="` + val.name + `" />
                        </div>
                        <a href="` + val.link + `"
                            title="` + val.name + `"
                            class="name">` + val.name + `</a>
                        <span class="price"> $` + val.price + ` </span>
                    </li>`;
                    } else {
                        items += `
                        <li class="news-item">
                            <div class="news-item-image">
                                <img src="` + val.image + `"
                                    alt="` + val.name + `"
                                    title="` + val.name + `" />
                            </div>
                            <p class="news-item-date">` + val.time + `</p>
                            <a href="` + val.link + `"
                                title="` + val.name + `"
                                class="news-item-title">` + val.name + `</a>
                            <p class="news-item-desc">
                                ` + val.brief + `
                            </p>
                        </li>
                        `;
                    }

                });
                productGroup.find(view).append(items);
            },
            error: function(data) {
                // Get errors
                var errors = data.responseJSON.message;
                alert(errors);
                location.reload();
            }
        });
    }
</script>
