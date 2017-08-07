@extends('sites.master')

@section('siteTitle', __('Home'))

@section('content')
    @include('sites._section.head')
    @include('sites._section.slider')
    @include('sites._section.booking')
    @include('sites._section.hair_style')
    @include('sites._section.about')
    @include('sites._section.service')
    @include('sites._section.testimonials')
    @include('sites._section.footer')
@endsection
