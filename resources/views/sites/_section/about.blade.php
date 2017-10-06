@extends('sites.master')

@section('siteTitle', __('Home'))

@section('content')
@include('sites._section.head')
<div id="fh5co-about-us" data-section="about">
    <div class="container">
        <div class="row row-bottom-padded-lg" id="about-us">
            <div class="col-md-12 section-heading text-center">
                <h2 class="to-animate">{{ trans('site.about') }}</h2>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 to-animate">
                        <h3></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-8 to-animate">
                <img src="images/s.jpg" class="img-responsive img-rounded" alt="Free HTML5 Template">
            </div>
            <div class="col-md-4 to-animate">
                <p>
                    <a href="#" class="btn btn-primary">{{ trans('site.more_stylist') }}</a>
                </p>
            </div>
        </div>
        <div class="row" id="team">
            <div class="col-md-12 section-heading text-center to-animate">
                <h2>{{ trans('site.stylist') }}</h2>
            </div>
            <div class="col-md-12">
                <div class="row row-bottom-padded-lg">
                    <div class="col-md-4 text-center to-animate">
                        <div class="person">
                            <img src="" class="img-responsive img-rounded" alt="Person">
                            <h3 class="name"></h3>
                            <div class="position"></div>
                            <p></p>
                            <ul class="social social-circle">
                                <li><a href="#"><i class="icon-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-linkedin"></i></a></li>
                                <li><a href="#"><i class="icon-instagram"></i></a></li>
                                <li><a href="#"><i class="icon-dribbble"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
