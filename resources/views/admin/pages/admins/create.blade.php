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
          class="fa fa-plus"></i>
        @lang('Add')</a>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    @if (session('successMessage'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('successMessage') }}
      </div>
    @endif

    @if (session('errorMessage'))
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('errorMessage') }}
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

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">@lang('Create form')</h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->
      <form role="form" action="{{ route(Request::segment(2) . '.store') }}" method="POST">
        @csrf
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label>@lang('Full name') <small class="text-red">*</small></label>
              <input type="text" class="form-control" name="name" placeholder="@lang('Full name')"
                value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
              <label>@lang('Email') <small class="text-red">*</small></label>
              <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}"
                required>
            </div>

            <div class="form-group">
              <label>@lang('Password') <small class="text-red">*</small></label>
              <input type="password" class="form-control" name="password" placeholder="@lang('Password must be at least 8 characters')" value=""
                autocomplete="new-password" required>
            </div>
          </div>
          <div class="col-md-6">

            <div class="form-group">
              <label>@lang('Role') <small class="text-red">*</small></label>
              <select name="role" id="role" class="form-control select2" required>
                <option value="">@lang('Please select')</option>
                @foreach ($roles as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>@lang('Status')</label>
              <div class="form-control">
                <label>
                  <input type="radio" name="status" value="active" checked>
                  <small>@lang('Active')</small>
                </label>
                <label>
                  <input type="radio" name="status" value="deactive" class="ml-15">
                  <small>@lang('Deactive')</small>
                </label>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <a class="btn btn-success btn-sm" href="{{ route(Request::segment(2) . '.index') }}">
            <i class="fa fa-bars"></i> @lang('List')
          </a>
          <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-floppy-o"></i>
            @lang('Save')</button>
        </div>
      </form>
    </div>
  </section>
@endsection
