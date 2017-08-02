<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{ Html::style('bower/bootstrap/dist/css/bootstrap.css') }}
    {{ Html::style('css/site.css') }}
</head>
<body>
    <div class="container">
        <div class="row fix-top">
            <div class = "col-md-12 content" >
                <div class="box-info">
                    <h2>{{ __('Đặt hàng thành công') }}</h2>  
                    <h4>{{ __('Cảm ơn Quý Khách !!!') }}</h4>
                    <div class="box text-center" style="">
                        <h3>{{ __('Thong Tin Khach Hang') }}</h3>
                        <p>{{ __('Nguyen Thi Hanh') }}</p>
                        <p>{{ __('0987423412') }}</p>
                        <p>{{ __('15-7-2017 - 15:00 PM ') }}</p>
                        <p>{{ __('Stylist : Japan') }}</p>
                        <p>{{ __('Tai : Fshalon 434 Tran Khac Chan') }}</p>
                    </div>
                    <a href="/">
                        <div class="btn button" >{{ __('BACK') }}</div>
                    </a>
                </div>
            </div>  
        </div>
    </div>
</div>
</body>
</html>
