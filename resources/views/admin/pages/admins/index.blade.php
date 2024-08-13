@extends('admin.layouts.app')

@section('title')
  {{ $module_name }}
@endsection

@section('content-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ $module_name }}
      <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
          class="fa fa-plus"></i>
        @lang('Add')</a>
    </h1>
  </section>
@endsection

@section('content')

  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form action="{{ route(Request::segment(2) . '.index') }}" method="GET">
        <div class="box-header">
          <h3 class="box-title">@lang('List')</h3>

          <div class="box-tools">
            <div class="input-group input-group-sm">
              <input type="text" name="keyword" class="form-control pull-right" placeholder="@lang('Search by name or email...')"
                value="{{ $keyword }}">

              <div class="input-group-btn">
                <button type="submit" class="btn btn-default" data-toggle="tooltip" title="@lang('Search')">
                  <i class="fa fa-search"></i>
                </button>
                <a class="btn btn-primary" href="{{ route(Request::segment(2) . '.index') }}" data-toggle="tooltip"
                  title="@lang('Refresh')">
                  <i class="fa fa-refresh"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>

      <div class="box-body table-responsive">
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

        @if (!$admins->total())
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @lang('No record found on the system!')
          </div>
        @else
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>@lang('Email')</th>
                <th>@lang('Full name')</th>
                <th>@lang('Role')</th>
                <th>@lang('Updated at')</th>
                <th>@lang('Status')</th>
                <th>@lang('Action')</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($admins as $admin)
                <form action="{{ route(Request::segment(2) . '.destroy', $admin->id) }}" method="POST"
                  onsubmit="return confirm('@lang('confirm_action')')">
                  <tr class="valign-middle">
                    <td>
                      {{ $admin->id }}
                    </td>
                    <td>
                      {{ $admin->email }}
                    </td>
                    <td>
                      {{ $admin->name }}
                    </td>
                    <td>
                      {{ $admin->role_name }}
                    </td>
                    <td>
                      {{ $admin->updated_at }}
                    </td>
                    <td class="wrap-load-active" data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadStatusAdmin',['id'=>$admin->id]) }}">
                      @include('admin.components.load-change-status',['data'=>$admin,'type'=>'bản ghi'])
                    </td>
                    <td>
                      <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="@lang('Edit')"
                        data-original-title="@lang('Edit')"
                        href="{{ route(Request::segment(2) . '.edit', $admin->id) }}">
                        <i class="fa fa-pencil-square-o"></i>
                      </a>
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip"
                        title="@lang('Delete')" data-original-title="@lang('Delete')">
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </form>
              @endforeach

            </tbody>
          </table>
        @endif
      </div>

      @if ($admins->hasPages())
        <div class="box-footer clearfix">
          {{ $admins->withQueryString()->links('admin.pagination.default') }}
        </div>
      @endif
    </div>
  </section>
@endsection
