@extends('admin.layouts.app')

@section('title')
    {{ $module_name }}
@endsection

@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $module_name }}
            {{-- <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Add')</a> --}}
        </h1>
    </section>
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang('Reviews list')</h3>
            </div>
            <div class="box-header">
              <button class="btn btn-danger btn-xs delete-select-all" data-url=""><i class="fa fa-trash"></i></button> Xóa các bản ghi được chọn
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
                        @lang('No record found')
                    </div>
                @else
                <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th><input type="checkbox" name="ids[]" id="check_all"></th>
                        <th>@lang('Fullname')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Content note')</th>
                        <th>@lang('Created at')</th>
                        <th>@lang('Updated at')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($rows as $row)
                        <form action="{{ route(Request::segment(2) . '.destroy', $row->id) }}" method="POST"
                          onsubmit="return confirm('@lang('confirm_action')')">
                          <tr class="valign-middle">
                            <td><input type="checkbox" class="checkbox" data-id="{{$row->id}}"></td>
                            <td>
                              <strong style="font-size: 14px;">{{ $row->name }}</strong>
                            </td>

                            <td>
                              {{ $row->email }}
                            </td>
                            <td>
                              {{ Str::limit($row->comment, 100) }}
                            </td>
                            <td>
                              {{ $row->created_at }}
                            </td>
                            <td>
                              {{ $row->updated_at }}
                            </td>
                            <td class="wrap-load-active" data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadStatusReview',['id'=>$row->id]) }}">
                              @include('admin.components.load-change-status',['data'=>$row,'type'=>'bản ghi'])
                            </td>
                            <td>
                              <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="@lang('Update')"
                                data-original-title="@lang('Update')"
                                href="{{ route(Request::segment(2) . '.edit', $row->id) }}">
                                <i class="fa fa-pencil-square-o"></i>
                              </a>
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip" title="@lang('Delete')"
                                data-original-title="@lang('Delete')">
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

            @if ($rows->hasPages())
                <div class="box-footer clearfix">
                    {{ $rows->withQueryString()->links('pagination.default') }}
                </div>
            @endif

        </div>
    </section>
    <div id="delete_action_all" class="modal fade" role="dialog">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <h3>Xóa tất cả bản ghi được chọn</h3>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('review.select.all') }}"  data-url="{{ route('review.select.all') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="GET" method="GET">
                      <button type="button" class="form-control" data-url="{{ route('review.select.all') }}" name="submit">Đồng ý</button>
                  </form>
              </div>
          </div>
      </div>
    </div>
@endsection
