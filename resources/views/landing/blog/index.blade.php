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

    .blog-text {
        font-size: 20px;
        color: #fff;
        font-weight: 700;
        margin-top: 20px;
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
</style>
<section id="pricing" class="pt-14 sm:pt-20 lg:pt-[130px]">
    <div class="px-4 xl:container">
        <!-- Section Title -->
        <div class="wow fadeInUp relative mb-12 w-full pt-10 text-center md:mb-20 lg:pt-16" data-wow-delay=".2s">
            <span class="title whitespace-nowrap"> Our Blogs</span>
            <h2 class="mx-auto mb-5 max-w-[600px] font-heading text-3xl font-semibold text-dark dark:text-white sm:text-4xl md:text-[50px] md:leading-[60px]">
                Blog
            </h2>
            <br>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <div class="relative z-10 container rounded drop-shadow-light">
            <div class="row">
                @foreach ($items as $item)
                    <div class="col-md-4">
                        <div class="price-div">
                            <a href="{{ route('blogs.details',$item->id) }}">
                                <img src="{{ asset('storage/'.$item->photo) }}"/>
                                <h2 class="blog-text">{{ $item->name }}</h2>
                                <p class="perfect-text"> {!! Str::limit(strip_tags($item->description),80) !!}</p>
                            </a>

                        </div>
                    </div>
                @endforeach
                {{ $items->links() }}
            </div>
        </div>
        <div class="pt-12 text-center">
            <h3 class="mb-5 font-heading text-xl font-medium text-dark dark:text-white sm:text-3xl">Looking for a
                customized solution?</h3>
            <p class="text-base text-dark-text"> Contact our team to get a quote : <a
                    href="/cdn-cgi/l/email-protection" class="__cf_email__"
                    data-cfemail="3a584f5e5e437a4a5359525b4e5b5314595557">[email&#160;protected]</a> </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
    </div>
</section>
@endsection