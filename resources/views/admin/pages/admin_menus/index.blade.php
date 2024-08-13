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
          class="fa fa-plus"></i> @lang('Add')</a>
    </h1>
  </section>
@endsection

@section('content')

  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">@lang('List')</h3>
      </div>

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

        @if (count($rows) == 0)
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            @lang('No record found on the system!')
          </div>
        @else
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>@lang('Name')</th>
                <th>@lang('Link')</th>
                <th>@lang('Order')</th>
                <th>@lang('Updated at')</th>
                <th>@lang('Status')</th>
                <th>@lang('Action')</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($rows as $row)
                @if ($row->parent_id == 0 || $row->parent_id == null)
                  <form action="{{ route(Request::segment(2) . '.destroy', $row->id) }}" method="POST"
                    onsubmit="return confirm('@lang('confirm_action')')">
                    <tr class="valign-middle">
                      <td>
                        {{ __($row->name) }}
                      </td>
                      <td>
                        {{ $row->url_link }}
                      </td>
                      <td>
                        <input data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadOrderVeryModel',['table'=>'admin_menus','id'=>$row->id]) }} " class="lb-order text-center"  type="number" min="0" value="{{ $row->iorder?$row->iorder:0 }}" style="width:50px" />
                      </td>
                      <td>
                          {{ $row->updated_at }}
                      </td>
                      <td class="wrap-load-active" data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadStatusAdminMenu',['id'=>$row->id]) }}">
                          @include('admin.components.load-change-status',['data'=>$row,'type'=>'bản ghi'])
                      </td>
                      <td>
                        <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="@lang('Edit')"
                          data-original-title="@lang('Edit')"
                          href="{{ route(Request::segment(2) . '.edit', $row->id) }}">
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

                  @foreach ($rows as $sub)
                    @if ($sub->parent_id == $row->id)
                      <form action="{{ route(Request::segment(2) . '.destroy', $sub->id) }}" method="POST"
                        onsubmit="return confirm('@lang('confirm_action')')">
                        <tr class="valign-middle bg-gray-light">
                          <td>
                            - - - - {{ __($sub->name) }}
                          </td>
                          <td>
                            - - - - {{ $sub->url_link }}
                          </td>
                          <td>
                            - - - - <input data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadOrderVeryModel',['table'=>'admin_menus','id'=>$sub->id]) }} " class="lb-order text-center"  type="number" min="0" value="{{ $sub->iorder?$sub->iorder:0 }}" style="width:50px" />
                          </td>
                          <td>
                              {{ $sub->updated_at }}
                          </td>
                          <td class="wrap-load-active" data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadStatusAdminMenu',['id'=>$sub->id]) }}">
                              @include('admin.components.load-change-status',['data'=>$sub,'type'=>'bản ghi'])
                          </td>
                          <td>
                            <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="@lang('Edit')"
                              data-original-title="@lang('Edit')"
                              href="{{ route(Request::segment(2) . '.edit', $sub->id) }}">
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
                    @endif
                  @endforeach
                @endif
              @endforeach

            </tbody>
          </table>
        @endif
      </div>

    </div>
  </section>
@endsection
