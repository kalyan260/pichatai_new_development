@extends('layouts.auth')
@section('title', $title)
@section('page-header-title', $title)
@section('content')
<div class="content-wrapper pt-1">
    <div class="row d-none d-xl-flex">
    </div>
    <div class="email-wrapper wrapper">
        <div class="row align-items-stretch">
            <div class="col-lg-4 pt-4 pt-md-2 pb-4 bg-white">
                <div class="menu-bar p-0 p-xl-2">
                    <form method="POST" action="{{ route('image-generator.genarete') }}" class="mt-2" id="generate-form">
                        @csrf
                        <input type="hidden" name="url" value="text2img">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Document Title</label>
                                <input type="text" name="document_name" autofocus placeholder="Untitled Document" id="document_name" value="" class="form-control form-control-lg">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group repeater">
                                <label>Topic *</label>
                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                    <input type="text" value="" required name="promt" class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 pe-xl-1">
                                <div class="form-group">
                                    <label>Output With (px)</label>
                                    <input type="number" value="512" required name="width" class="form-control form-control-lg" id="width">
                                </div>
                            </div>
                            <div class="col-xl-6 pe-xl-1">
                                <div class="form-group">
                                    <label>Output Height (px)</label>
                                    <input type="number" value="512" required name="height" class="form-control form-control-lg" id="height">
                                </div>
                            </div>
                            <div class="col-12 col-xl-6 ps-xl-1" style="display: none">
                                <div class="form-group">
                                    <label>
                                        Variation <i class="fas fa-info-circle text-dark" data-bs-toggle="tooltip" title="It determines the number of completions to generate for each submit. However, it is important to note that this can consume a significant amount of your token quota due to the high number of variations it generates. Therefore, use it carefully and make sure to have appropriate settings for max tokens and stop."></i>
                                    </label>
                                    <input type="number" value="4" min="1" max="10" name="variation" id="variation" class="form-control form-control-lg">
                                    <span id="variation_err" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-lg btn-primary fw-bol btn-block mt-2 w-100" id="generate" type="submit"><i class="fas fa-pen-nib"></i>&nbsp;&nbsp;Generate</button>
                    </form>
                </div>
            </div>
            <div class="mail-view col-lg-8 bg-white border-left-lg p-0">
                <div class="row d-none d-md-flex">
                    <div class="col-12 text-center">
                        <img src="http://127.0.0.1:8000/assets/images/content-pending.jpg" alt="" class="mt-5 pt-5 content-pending">
                        <h4 class="my-4 pb-5 text-primary px-4">
                            When done, your desired content will be displayed here.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
