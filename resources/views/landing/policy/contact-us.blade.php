@extends('layouts.landing')
@section('title',$title)
@section('meta_title',$meta_title)
@section('meta_description',$meta_description)
@section('meta_keyword',$meta_keyword)
@section('meta_author',$meta_author)
@section('meta_image',$meta_image)
@section('meta_image_width',$meta_image_width)
@section('meta_image_height',$meta_image_height)
@section('content')
<section class="pt-[130px]" id="policy-page">
  <div class="wow fadeInUp relative z-10 bg-cover bg-center bg-no-repeat py-20 lg:py-[120px]" data-wow-delay=".2s">
    <div class="absolute top-0 left-0 z-10 h-full w-full bg-cover bg-center opacity-20 mix-blend-overlay bg-noise-pattern"></div>
    <div class="absolute top-0 left-0 -z-10 h-full w-full bg-[#EEF1FDEB] dark:bg-[#1D232DD9]"></div>
    <div class="px-4 xl:container">
      <div class="mx-auto max-w-[580px] text-center">
        <h1 class="mb-8 font-heading text-3xl font-semibold text-dark dark:text-white md:text-[44px] md:leading-tight">
          {{$title}}
        </h1>
      </div>
    </div>
  </div>
  <div class="px-4 pt-24 xl:container">
    <div class="border-b pb-20 dark:border-[#2E333D] lg:pb-[130px]">
        {{-- <h4 class="text-base text-dark-text mb-4">{{__('Contact With Us')}}</h4> --}}
        <h4 class="text-base text-dark-text mb-4">{{__('Contact us')}} : </h4>
        <p class="mb-12 text-base text-dark-text">
            <a href="mailto:buddy@pichatai.com" class="font-heading text-base text-dark hover:text-primary dark:text-white dark:hover:text-primary">buddy@pichatai.com </a>
        </p>
    </div>
  </div>
</section>
@endsection