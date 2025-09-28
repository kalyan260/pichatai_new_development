<?php
    $action_type = request()->type;
    if (empty($action_type)) {
        $action_type = 'subscription';
    }
    $title_display = __('Create Policy');
    $title_display_des = __('Create a Policy');
    $paypal_data = isset($payment_config->paypal) ? json_decode($payment_config->paypal) : null;
    $paypal_access = isset($paypal_data->paypal_status) && $paypal_data->paypal_status == '1' ? true : false;
    $integration_access = $paypal_access ? true : false;
    $access_array = ['1' => __('Create'), '2' => __('Update'), '3' => __('Delete'), '4' => __('Special')];
?>
@extends('layouts.auth')
@section('title', $title_display)
@section('page-header-title', $title_display)
@section('page-header-details', __('Create a new access level'))
@section('content')
    <div class="content-wrapper">
        <form class="form form-vertical" enctype="multipart/form-data" method="POST" action="{{ route('policy.add') }}">
            @csrf
            <div class="row">
                <div class='col-12 col-md-12'>
                    <div class="card card-rounded mb-4 p-lg-2">
                        <div class="card-body card-rounded">
                            <h4 class="card-title card-title-dash mb-4">{{ __('Create A Policy') }}</h4>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Title*</label>
                                        <input name="name" class="form-control form-control-lg form-control form-control-lg-lg" type="text" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Url*</label>
                                        <input name="url" class="form-control form-control-lg form-control form-control-lg-lg" type="text"  value="{{ old('url') }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Content*</label>
                                        <textarea class="summernote" name="content" required>{!! old('content') !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <div class="btn-wrapper mt-4">
                                            <button type="submit" class="btn btn-sm rounded btn-success text-white"><i class="fas fa-check-circle"></i>{{__('Save Changes')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script>
@endsection

