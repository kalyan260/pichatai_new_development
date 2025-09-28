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