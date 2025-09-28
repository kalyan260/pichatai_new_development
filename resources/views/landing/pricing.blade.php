@extends('layouts.landing')
@section('title', $title)
@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('meta_keyword', $meta_keyword)
@section('meta_author', $meta_author)
@section('meta_image', $meta_image)
@section('meta_image_width', $meta_image_width)
@section('meta_image_height', $meta_image_height)
@section('content')
    <style>
        .container {
            max-width: 1140px;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-4 {
            -ms-flex: 0 0 33.333333%;
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        ::selection {
            background: #ed00eb;
            color: #000000;
        }

        .price-button {
            background: #151315;
            padding: 15px 30px;
            color: #fff;
            border-radius: 5px;
            margin-right: 5px;
            transition: 0.5s;
        }

        .price-button:hover {
            background: #ed00eb;
            text-decoration: none;
            color: #fff;
        }

        .price-div {
            padding-bottom: 2.2rem;
            padding-top: 2.2rem;
            padding-left: 2.2rem;
            padding-right: 2.2rem;
            background: #151315;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .free-text {
            font-size: 1.8rem;
            color: #fff;
            font-weight: 700;
        }

        .perfect-text {
            color: hsla(0, 0%, 100%, .6);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .free-2text {
            margin-top: 30px;
            font-size: 4rem;
            font-weight: 700;
            color: #fff;
        }

        .free-atag {
            width: 100%;
            display: block;
            background: #3b393b;
            padding: 15px 0;
            text-align: center;
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            text-decoration: none;
        }

        .free-atag:hover {
            color: #fff;
            text-decoration: none;

        }

        .tome-div {
            margin-top: 20px;
        }

        .tome-text1 {
            color: #fff;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .tome-text2 {
            font-size: 1rem;
            color: hsla(0, 0%, 100%, .6);
        }

        .bg-pro {
            background: #ed00eb;
        }

        @media (max-width: 991px) {
            .col-md-4 {
                flex: 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 767px) {
            .hidden-mobile {
                display: none;
            }

            .col-md-4 {
                flex: 100%;
                max-width: 100%;
            }
        }

        @media only screen and (min-width: 500px) {
            .mobileshow {
                display: none !important;
            }

            .price-button {
                padding: 15px 15px;
            }
        }

        @media (max-width: 480px) {
            .price-button {
                padding: 15px 15px;
            }
        }
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: none;
            background: url('//upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Phi_fenomeni.gif/50px-Phi_fenomeni.gif') 50% 50% no-repeat rgb(249,249,249);
        }
    </style>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <section id="pricing" class="pt-14 sm:pt-20 lg:pt-[130px]">
        <div class="px-4 xl:container">
            <!-- Section Title -->
            <div class="wow fadeInUp relative mb-12 w-full pt-10 text-center md:mb-20 lg:pt-16" data-wow-delay=".2s">
                <span class="title whitespace-nowrap">Pricing Plans</span>
                <h2
                    class="mx-auto mb-5 max-w-[600px] font-heading text-3xl font-semibold text-dark dark:text-white sm:text-4xl md:text-[50px] md:leading-[60px]">
                    Affordable Pricing With Simple Plans </h2>
                <br>
                <p>
                    @if (count($package_validity_list) > 1)
                        @foreach ($package_validity_list as $kv => $vv)
                            <a href="{{ route('pricing-plan') }}?validity={{ $kv }}" class="@if ($kv == $default_validity) bg-primary @endif cs-price-button hover:bg-primary inline-flex items-center rounded bg-dark-text font-heading text-base text-white validity-level" data-validity = {{ $kv }}>
                                {{ $vv }}
                            </a>
                        @endforeach
                    @endif
                </p>
            </div>
            <div class="loader"></div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <div class="relative z-10 container rounded drop-shadow-light">
                <div class="row pricing-list">
                    @foreach ($get_pricing_list_news as $get_pricing_list_new)
                        @php
                            $discount_data = $get_pricing_list_new->discount_data;
                            $price_raw_data = format_price($get_pricing_list_new->price, $format_settings, $discount_data, ['return_raw_array' => true]);
                            $package_price = $price_raw_data->display_price_currency ?? '';
                            $validity = $get_pricing_list_new->validity;
                            $validity_extra_info = $get_pricing_list_new->validity_extra_info;
                            if ($validity > 0) {
                                $validity_text = convert_number_validity_phrase($validity);
                            }
                            if ($validity == 0) {
                                $validity_text = __('Forever');
                            }
                            $first_package_validity = $validity_text;
                        @endphp
                        <div class="col-md-4">
                            <div class="price-div">
                                <h2 class="free-text">{{ $get_pricing_list_new->package_name }}</h2>
                                <p class="perfect-text">All of these at affortable price</p>
                                <h1 class="free-2text">
                                    @if ($location != false && $location->countryName == 'India')
                                        {{ $package_price }}
                                    @else
                                        @php
                                            $format_settings['currency'] = 'USD';
                                            $price_raw_data = format_price(($get_pricing_list_new->other_price), $format_settings, $discount_data, ['return_raw_array' => true]);
                                            $package_price = $price_raw_data->display_price_currency ?? '';
                                        @endphp
                                        {{ $package_price }}
                                    @endif
                                </h1>
                                <p class="perfect-text">{{ strtolower($first_package_validity) }}</p>
                                @if ($get_pricing_list_new->is_free != 1)
                                    <a href="{{ route('buy-package', $get_pricing_list_new->id) }}" class="free-atag">Purchase</a>
                                @else
                                    <a href="{{ route('register') }}" class="free-atag">Purchase</a>
                                @endif
                                <div class="tome-div">
                                    <p class="tome-text1">PiechatAi creation </p>
                                    @php
                                        $module_assigned_limit = json_decode($get_pricing_list_new->monthly_limit);
                                    @endphp
                                    @foreach ($get_modules as $get_module)
                                        @if (in_array($get_module->id, explode(',', $get_pricing_list_new->module_ids)))
                                            @php
                                                $assignmed_model_id = $get_module->id;
                                            @endphp
                                            <p class="tome-text2">
                                                <span>
                                                    <i class="fa fa-check" style="color: green;"></i>
                                                </span>
                                                {{ $get_module->module_name }}
                                                <p class="tome-text2" style="margin-left: 20px;">
                                                    {{ intWithStyle($module_assigned_limit->$assignmed_model_id) }} {{ $get_module->extra_text }}
                                                </p>
                                            </p>
                                        @endif
                                    @endforeach
                                    @foreach ($get_modules as $get_module)
                                        @if (!in_array($get_module->id, explode(',', $get_pricing_list_new->module_ids)))
                                            @php
                                                $assignmed_model_id = $get_module->id;
                                            @endphp
                                            <p class="tome-text2">
                                                <span>
                                                    <i class="fa fa-check"></i>
                                                </span>
                                                {{ $get_module->module_name }}
                                            </p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-12 text-center">
                <h3 class="mb-5 font-heading text-xl font-medium text-dark dark:text-white sm:text-3xl">Looking for a
                    customized solution?</h3>
                <p class="text-base text-dark-text"> Contact our team to get a quote : <a
                        href="{{ $get_landing_language->company_email ?? '' }}" class="__cf_email__"
                        data-cfemail="3a584f5e5e437a4a5359525b4e5b5314595557">{{ $get_landing_language->company_email ?? '' }}</a>
                </p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('custom/Frontend/Pricing.js') }}"></script> --}}
    <script>
        $('.validity-level').click((e)=> {
            e.preventDefault(true);
            let validity = $(e.currentTarget).data('validity');
            // $('.loader').show();
            $.ajax({
                type: 'post',
                dataType: 'html',
                url: '{{ route('pricing-ajax') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "validity": validity
                },
                success: function(response) {
                    $(".validity-level").each(function(){
                        $(this).removeClass("bg-primary")
                    });
                    $(".pricing-list").html(response);
                    $(e.currentTarget).addClass('bg-primary');
                    // $('.loader').hide();
                }
            });
        })
    </script>
@endsection

