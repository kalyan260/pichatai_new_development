<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ config('app.localeDirection') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PiChatAi - Verify your phone number</title>
    <link rel="shortcut icon" href="https://pichatai.com/storage/agency/favicon.png" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/cdn/css/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/cdn/css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body class="{{ config('app.localeDirection') }}">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <a href="{{ route('home') }}"><img src="https://pichatai.com/storage/agency/logo.jpg" alt="logo"></a>
                            </div>
                            <style>
                                /* Chrome, Safari, Edge, Opera */
                                input::-webkit-outer-spin-button,
                                input::-webkit-inner-spin-button {
                                    -webkit-appearance: none;
                                    margin: 0;
                                }

                                /* Firefox */
                                input[type=number] {
                                    -moz-appearance: textfield;
                                }


                                @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

                                form .input-field {
                                    flex-direction: row;
                                    column-gap: 10px;
                                }

                                .input-field input {
                                    height: 45px;
                                    width: 42px;
                                    border-radius: 6px;
                                    outline: none;
                                    font-size: 1.125rem;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                }

                                .input-field input:focus {
                                    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
                                }

                                .input-field input::-webkit-inner-spin-button,
                                .input-field input::-webkit-outer-spin-button {
                                    display: none;
                                }

                                form button {
                                    /* margin-top: 25px; */
                                    width: 100%;
                                    color: #fff;
                                    font-size: 1rem;
                                    border: none;
                                    padding: 9px 0;
                                    cursor: pointer;
                                    border-radius: 6px;
                                    pointer-events: none;
                                    background: #6e93f7;
                                    transition: all 0.2s ease;
                                }

                                form button.active {
                                    background: #4070f4;
                                    pointer-events: auto;
                                }

                                form button:hover {
                                    background: #0e4bf1;
                                }

                                .input-otp {
                                    display: none;
                                }

                                .verification-section {
                                    margin-top: 25px;
                                }

                                .alert-danger {
                                    display: none;
                                }

                                .alert-success {
                                    display: none;
                                }
                            </style>
                            <h4>{{ __('Verify your phone number') }}</h4>
                            <div class="alert alert-danger" role="alert">
                            </div>
                            <div class="alert alert-success" role="alert">
                            </div>
                            <div class="verification-section">
                                <div class="row input-phone">
                                    <div class="col-md-3" style="padding-bottom: 5px;">
                                        <select name="" id="address-country" class="form-control">
					    @foreach ($countries as $country)
                                                <option value="+{{ $country->phonecode }}" @if($country != null && $country != false) @if($country->id == $user_country->id) selected @endif @endif>{{ $country->name }} (+{{ $country->phonecode }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5" style="padding-bottom: 5px;">
                                        <input type="number" name="mobile" id="mobile" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-success send-otp-button">Send Otp</button>
                                    </div>
                                </div>
                                <div class="input-otp">
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-md-8 input-field" style="padding-bottom: 10px;">
                                                <input type="number" class="verify-otp" />
                                                <input type="number" disabled class="verify-otp" />
                                                <input type="number" disabled class="verify-otp" />
                                                <input type="number" disabled class="verify-otp" />
                                            </div>
                                            <div class="col-md-4">
                                                <button class="verify-otp-button">Verify OTP</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <script>
                                const inputs = document.querySelectorAll(".verify-otp"),
                                    button = document.querySelector(".verify-otp-button");
                                // iterate over all inputs
                                inputs.forEach((input, index1) => {
                                    input.addEventListener("keyup", (e) => {
                                        // This code gets the current input element and stores it in the currentInput variable
                                        // This code gets the next sibling element of the current input element and stores it in the nextInput variable
                                        // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
                                        const currentInput = input,
                                            nextInput = input.nextElementSibling,
                                            prevInput = input.previousElementSibling;
                                        // if the value has more than one character then clear it
                                        if (currentInput.value.length > 1) {
                                            currentInput.value = "";
                                            return;
                                        }
                                        // if the next input is disabled and the current value is not empty
                                        //  enable the next input and focus on it
                                        if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                                            nextInput.removeAttribute("disabled");
                                            nextInput.focus();
                                        }
                                        // if the backspace key is pressed
                                        if (e.key === "Backspace") {
                                            // iterate over all inputs again
                                            inputs.forEach((input, index2) => {
                                                // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
                                                // and the previous element exists, set the disabled attribute on the input and focus on the previous element
                                                if (index1 <= index2 && prevInput) {
                                                    input.setAttribute("disabled", true);
                                                    input.value = "";
                                                    prevInput.focus();
                                                }
                                            });
                                        }
                                        //if the fourth input( which index number is 3) is not empty and has not disable attribute then
                                        //add active class if not then remove the active class.
                                        if (!inputs[3].disabled && inputs[3].value !== "") {
                                            button.classList.add("active");
                                            return;
                                        }
                                        button.classList.remove("active");
                                    });
                                });
                                //TODO:: Need to change this implementation
                                window.addEventListener("load", () => inputs[0].focus());
                            </script>
                            <script src="https://code.jquery.com/jquery-3.7.0.min.js"
                                integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
                            <script>
                                $('.send-otp-button').on('click', () => {
                                    let mobile = $('#mobile').val();
                                    let csrf_token = "{{ csrf_token() }}";
                                    if (mobile.length > 0) {
                                        $('.alert-danger').html('');
                                        $('.alert-danger').hide();
                                        let country_code = $('#address-country').val();
                                        mobile = country_code + mobile;
                                        $.ajax({
                                            type: 'POST',
                                            url: '{{ route('verify-phone-number') }}',
                                            data: {
                                                _token: csrf_token,
                                                mobile: mobile
                                            },
                                            success: function(data) {
                                                if (data.status == true) {
                                                    $('.input-phone').hide();
                                                    $('.input-otp').show();
                                                    $('.alert-success').show();
                                                    $('.alert-success').html(data.msg);
                                                    $('.alert-danger').hide();
                                                    $('.alert-danger').html('');
                                                } else {
                                                    $('.input-otp').hide();
                                                    $('.input-phone').show();

                                                    $('.alert-success').hide();
                                                    $('.alert-success').html('');
                                                    $('.alert-danger').hide();
                                                    $('.alert-danger').html(data.msg);
                                                }
                                            }
                                        });
                                    } else {
                                        $('.alert-danger').html('Please Enter A Valid Phone Number');
                                        $('.alert-danger').show();
                                    }
                                });
                                $('.verify-otp-button').on('click', (e) => {
                                    e.preventDefault(true);
                                    let mobile = $('#mobile').val();
                                    let country_code = $('#address-country').val();
                                    let otpInputs = document.querySelectorAll(".verify-otp");
                                    let typed_otp = '';
                                    otpInputs.forEach((input, index1) => {
                                        console.log(input.value);
                                        typed_otp += input.value;
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        url: '{{ route('verify-otp') }}',
                                        data: {
                                            _token: csrf_token,
                                            otp: typed_otp,
                                            mobile: mobile,
                                            country_code: country_code
                                        },
                                        success: function(data) {
                                            if (data.status == true) {
                                                $('.alert-success').show();
                                                $('.alert-success').html(data.msg);
                                                $('.alert-danger').hide();
                                                $('.alert-danger').html('');
                                                const myTimeout = setTimeout(myGreeting, 3000);

                                                function myGreeting() {
                                                    window.location.href = '{{ route('dashboard') }}';
                                                }
                                            } else {
                                                $('.alert-danger').show();
                                                $('.alert-danger').html(data.msg);
                                                $('.alert-success').hide();
                                                $('.alert-success').html('');
                                            }
                                        }
                                    });
                                })
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('include.guest-variables')
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/cdn/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/cdn/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/common/common.js') }}"></script>

    @stack('scripts-footer')
    @stack('styles-footer')
</body>

</html>
