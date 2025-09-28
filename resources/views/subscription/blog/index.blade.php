<?php
$lang_display = __('BLog');
$title_display = __('Blog');
?>
@extends('layouts.auth')
@section('title', $title_display)
@section('page-header-title', $title_display)
@section('page-header-details', __('All your user access in one place'))
@section('content')
    <div class="content-wrapper">
        @include('layouts.alert')

        <div class="card card-rounded mb-4 p-lg-2">
            <div class="card-body card-rounded">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="card-title card-title-dash">{{ $lang_display }}</h4>
                        <p class="card-subtitle card-subtitle-dash mb-2 mb-lg-4">{{ __('Manage Blog') }}</p>
                    </div>
                    <div class="btn-wrapper mb-2">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown d-inline">
                            <div class="btn-group" role="group">
                                <a href="{{ route('blog.add') }}" type="button" class="btn btn-otline-dark btn-sm makeDefault">
                                     {{ __('Create') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class='table table-sm table-select' id="mytable">
                        <thead>
                            <tr class="table-light">
                                <th class=" text-center">{{ __('ID') }}</th>
                                <th class=" text-center">{{ __('Name') }}</th>
                                <th class=" text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($items as $item)
                                @php
                                    $count ++;
                                @endphp
                                <tr>
                                    <td class=" text-center">{{ $count }}</td>
                                    <td class=" text-center">{{ $item->name }}</td>
                                    <td class=" text-center">
                                        <a class="btn btn-info btn-sm" href="{{ route('blog.edit',$item->id) }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a onclick="onClickDelete(event)" class="btn btn-danger btn-sm" href="{{ route('blog.delete',$item->id) }}">
                                            <i class="fas fa-user">
                                            </i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles-header')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/subscription/package.list-package.css') }}">
@endpush

