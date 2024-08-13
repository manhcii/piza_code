@extends('admin.layouts.app')

@section('title')
    {{ $module_name }}
@endsection
@php
    if (Request::get('lang') == $languageDefault->lang_locale || Request::get('lang') == '') {
        $lang = $languageDefault->lang_locale;
    } else {
        $lang = Request::get('lang');
    }

@endphp
@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $module_name }}
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="/">
                    <i class="fa fa-dashboard"></i> Home
                </a>
            </li>
            <li class="active">{{ $module_name }}</li>
        </ol>
    </section>
@endsection

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>

    @php
        // lấy dữ liệu cho chart doughnut
        $count_contact = $count_call_request = $count_newsletter = 0;
        if (isset($rows_contact)) {
            foreach ($rows_contact as $val) {
                if ($val->is_type == 'contact') {
                    $count_contact++;
                }
                if ($val->is_type == 'call_request') {
                    $count_call_request++;
                }
                if ($val->is_type == 'newsletter') {
                    $count_newsletter++;
                }
            }
        }
        $data_chart = [$count_contact, $count_call_request, $count_newsletter];

        // end

        // lấy dữ liệu cho chart line
        //tháng năm hiện tại
        $month_now = (int)date('m', time());
        $year_now = date('Y', time());
        // lấy 5 tháng trước hiện tại
        $data_month = [];
        for ($i = 1; $i <= 5; $i++) {
            if ($month_now - $i > 0) {
                $data_month[5 - $i] = $month_now - $i . '/' . $year_now;
            } elseif ($month_now - $i < 0) {
                $data_month[5 - $i] = 12 + ($month_now - $i) . '/' . ($year_now - 1);
            } else {
                $data_month[5 - $i] = 12 - ($month_now - $i) . '/' . ($year_now - 1);
            }
        }
        array_push($data_month, $month_now . '/' . $year_now);
        ksort($data_month);

        $data_line = [];
        // lấy dữ liệu theo từng tháng
        $key = 0;
        foreach ($data_month as $month_year) {
            $data_line['data'][$key] = 0;
            foreach ($rows_order as $val_order) {
                if ($month_year == date('n/Y', strTotime($val_order->created_at))) {
                    $data_line['data'][$key] += 1;
                }
            }
            // lấy tên tháng
            $data_line['month'][$key] = App\Consts::MONTH[explode('/', $month_year)[0]];
            $key++;
        }
    @endphp
    <section class="content">
        @if (session('errorMessage'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('errorMessage') }}
            </div>
        @endif
        @if (session('successMessage'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('successMessage') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="container-fluid">
            <div class="row">
                <!-- ./col -->
                @isset($rows_order)
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{ count($rows_order) }}</h3>

                                <p>@lang('New Orders')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('order_products.index') }}" class="small-box-footer">@lang('More info') <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endisset
                @isset($rows_comment)
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{ count($rows_comment) }}</h3>

                                <p>@lang('Comments')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-chatbox"></i>
                            </div>
                            <a href="{{ route('comments.index') }}" class="small-box-footer">@lang('More info') <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endisset
                @isset($rows_customer)
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{ count($rows_customer) }}</h3>

                                <p>@lang('User Registrations')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('customer.index') }}" class="small-box-footer">@lang('More info') <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endisset
                @isset($rows_contact)
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{ $count_contact ?? '' }}</h3>

                                <p>@lang('Contacts')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('contacts.index') }}" class="small-box-footer">@lang('More info') <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endisset
            </div>

            <!-- ./col -->
            <div class="row">
                <div class="col-md-6">

                    @isset($rows_customer)
                        <section class="connectedSortable list-group">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('Latest Users')</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table no-margin">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Email')</th>
                                                    <th>@lang('Name')</th>
                                                    <th>@lang('Status')</th>
                                                    <th>@lang('Time Created')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rows_customer as $items)
                                                    @php
                                                        if ($loop->index == 10) {
                                                            break;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $items->email }}</td>
                                                        <td>{{ $items->name }}</td>
                                                        <td><span
                                                                class="label {{ $items->status == 'active' ? 'label-success' : ($items->status == 'pending' ? 'label-warning' : 'label-danger') }}">{{ $items->status }}</span>
                                                        </td>
                                                        <td>
                                                            {{ $items->created_at }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> --}}
                                    <a href="{{ route('customer.index') }}"
                                        class="btn btn-sm btn-default btn-flat pull-right">@lang('View All Users')</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                        </section>
                    @endisset

                    @isset($admins)
                        <div class="list-group">
                            <!-- USERS LIST -->
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('Latest Members')</h3>

                                    <div class="box-tools pull-right">
                                        <span class="label label-danger">{{ count($admins) }} New Members</span>
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <ul class="users-list clearfix">
                                        @foreach ($admins as $item_admin)
                                            <li>
                                                <img src="{{ asset('data/images/nophoto.png') }}"
                                                    alt="{{ $item_admin->name }}">
                                                <p class="users-list-name">{{ $item_admin->name }}</p>
                                                <span class="users-list-date">{{ $item_admin->role_name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- /.users-list -->
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="{{ route('admins.index') }}" class="uppercase">@lang('View All Members')</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                            <!--/.box -->
                        </div>
                    @endisset



                    @isset($rows_product)
                        <div class="list-group">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('Recently Added Products')</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="products-list product-list-in-box">
                                        @foreach ($rows_product as $items_product)
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="{{ $items_product->image ?? '' }}"
                                                        alt="{{ $items_product->name }}">
                                                </div>
                                                <div class="product-info">
                                                    <a href="{{ route('frontend.page', ['taxonomy' => $items_product->alias ?? '']) }}"
                                                        class="product-title">{{ $items_product->name }}
                                                        @if (isset($items_product->price) && $items_product->price != null)
                                                            <span
                                                                class="label label-warning pull-right">${{ $items_product->price }}</span>
                                                        @endif
                                                    </a>
                                                    <span class="product-description">
                                                        {{ $items_product->json_params->brief->$lang ?? $items_product->brief }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                        <!-- /.item -->
                                    </ul>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="{{ route('cms_products.index') }}" class="uppercase">@lang('View All Products')</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                        </div>
                    @endisset



                </div>
                <div class="col-md-6">

                    <div class="list-group">
                        <canvas id="chart_line" style="width: 100%;"></canvas>
                    </div>

                    <div class="list-group">
                        <canvas id="chart_doughnut" width="400" height="400" style="margin: auto"></canvas>
                    </div>


                    @isset($rows_post)
                        <div class="list-group">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('Recently Added Post')</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <ul class="products-list product-list-in-box">
                                        @foreach ($rows_post as $items_post)
                                            <li class="item">
                                                <div class="product-img">
                                                    <img src="{{ $items_post->image ?? '' }}" alt="{{ $items_post->name }}">
                                                </div>
                                                <div class="product-info">
                                                    <a href="{{ route('frontend.page', ['taxonomy' => $items_post->alias ?? '']) }}"
                                                        class="product-title">{{ $items_post->name }}

                                                    </a>
                                                    <span class="product-description">
                                                        {{ $items_post->json_params->brief->$lang ?? $items_post->brief }}
                                                    </span>
                                                </div>
                                            </li>
                                        @endforeach
                                        <!-- /.item -->
                                    </ul>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer text-center">
                                    <a href="{{ route('cms_products.index') }}" class="uppercase">@lang('View All Post')</a>
                                </div>
                                <!-- /.box-footer -->
                            </div>
                        </div>
                    @endisset




                </div>
            </div>

        </div>
    </section>
    <script>
        var ctx = document.getElementById("chart_doughnut");
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Call equest', 'Contact', 'New Letter'],
                datasets: [{
                    label: 'Sent count',
                    data: {{ json_encode($data_chart) }},
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'

                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: false,

            }
        });

        var line = document.getElementById("chart_line");
        var Chartline = new Chart(line, {
            type: 'line',
            data: {
                labels: {!! str_replace('"', "'", json_encode($data_line['month'], true)) !!},
                datasets: [{
                    label: 'My Orders',
                    data: {{ json_encode($data_line['data']) }},
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: false,

            }
        });
    </script>
@endsection
