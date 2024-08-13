@extends('admin.layouts.app')

@section('title')
    {{ $module_name }}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $module_name }}
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Add')</a>
        </h1>
    </section>

    <!-- Main content -->
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
        <form role="form" action="{{ route(Request::segment(2) . '.update', $detail->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Update form')</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">


                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="row">

                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label>
                                                        @lang('Title') <small class="text-red">*</small>:
                                                    </label>
                                                    <input type="text" class="form-control" name="title"
                                                        placeholder="@lang('title')"
                                                        value="{{ $detail->title ?? old('title') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>@lang('status')</label>
                                                    <div class="form-control">
                                                        <label>
                                                            <input type="radio" name="status" value="active"
                                                                {{ $detail->status == 'active' ? 'checked' : '' }}>
                                                            <small>@lang('active')</small>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="status" value="deactive"
                                                                class="ml-15"
                                                                {{ $detail->status == 'deactive' ? 'checked' : '' }}>
                                                            <small>@lang('deactive')</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>@lang('is_config')</label>
                                                    <div class="form-control">
                                                        <label>
                                                            <input type="radio" name="is_config" value="1"
                                                                {{ $detail->is_config == '1' ? 'checked' : '' }}>
                                                            <small>@lang('true')</small>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="is_config" value="0"
                                                                class="ml-15" {{ $detail->is_config == '0' ? 'checked' : '' }}>
                                                            <small>@lang('false')</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>@lang('iorder')</label>
                                                    <input type="number" class="form-control" name="iorder"
                                                        placeholder="@lang('iorder')"
                                                        value="{{ $detail->iorder ?? old('iorder') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Image')</label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <a data-input="image" data-preview="image-holder"
                                                                class="btn btn-primary lfm" data-type="cms-images">
                                                                <i class="fa fa-picture-o"></i> @lang('choose')
                                                            </a>
                                                        </span>
                                                        <input id="image" class="form-control" type="text"
                                                            name="image" placeholder="@lang('image_link')..."
                                                            value="{{ $detail->image }}">
                                                    </div>
                                                    <div id="image-holder" style="margin-top:15px;max-height:100px;">
                                                        @if ($detail->image != '')
                                                            <img style="height: 5rem;" src="{{ $detail->image }}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="box-footer">
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route(Request::segment(2) . '.index') }}">
                                                <i class="fa fa-bars"></i> @lang('List')
                                            </a>
                                            <button type="submit" class="btn btn-primary pull-right btn-sm"><i
                                                    class="fa fa-floppy-o"></i>
                                                @lang('Save')</button>
                                        </div>
                                    </div>

                                </div><!-- /.tab-content -->
                            </div><!-- nav-tabs-custom -->

                        </div>
                    </div>
                </div>
        </form>
    </section>
@endsection
