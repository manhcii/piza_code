@extends('admin.layouts.app')

@section('title')
  {{ $module_name }}
@endsection

@section('content-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ $module_name }}
    </h1>
  </section>
@endsection

@section('content')

  <!-- Main content -->
  <section class="content">
    {{-- Search form --}}
    <div class="box box-default">

      <div class="box-header with-border">
        <h3 class="box-title">@lang('Filter')</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <form action="{{ route(Request::segment(2) . '.index') }}" method="GET">
        <div class="box-body">
          <div class="row">

            <div class="col-md-4">
              <div class="form-group">
                <label>@lang('Keyword') </label>
                <input type="text" class="form-control" name="keyword"
                  placeholder="{{ __('Fullname') . ', ' . __('Email') . ', ' . __('Phone') . '...' }}"
                  value="{{ $params['keyword'] ?? '' }}">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>@lang('From date')</label>
                <input name="created_at_from" id="created_at_from" class="form-control datepicker"
                  value="{{ $params['created_at_from'] ?? '' }}" placeholder="@lang('dd/mm/yyyy')">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>@lang('To date')</label>
                <input name="created_at_to" id="created_at_to" class="form-control datepicker"
                  value="{{ $params['created_at_to'] ?? '' }}" placeholder="@lang('dd/mm/yyyy')">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>@lang('Status')</label>
                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                  <option value="">@lang('Please select')</option>
                  @foreach (App\Consts::CONTACT_STATUS as $key => $value)
                    <option value="{{ $key }}"
                      {{ isset($params['status']) && $key == $params['status'] ? 'selected' : '' }}>
                      {{ __($value) }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="col-md-2">
              <div class="form-group">
                <label>@lang('Filter')</label>
                <div>
                  <button type="submit" class="btn btn-primary btn-sm mr-10">@lang('Submit')</button>
                  <a class="btn btn-default btn-sm" href="{{ route(Request::segment(2) . '.index') }}">
                    @lang('Reset')
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    {{-- End search form --}}

    <div class="box">
      <div class="box-header">
        <h3 class="box-title">@lang('Contact list')</h3>
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
            @lang('not_found')
          </div>
        @else
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th><input type="checkbox" name="ids[]" id="check_all"></th>
                <th>@lang('Fullname')</th>
                <th>@lang('Email')</th>
                <th>@lang('Phone')</th>
                <th>@lang('Content note')</th>
                <th>@lang('Admin note')</th>
                <th>@lang('Created at')</th>
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
                      {{ $row->phone }}
                    </td>

                    <td>
                      {{ Str::limit($row->content, 100) }}
                    </td>
                    <td>
                      {{ Str::limit($row->admin_note, 200) }}
                    </td>
                    <td>
                      {{ $row->created_at }}
                    </td>
                    <td>
                      @lang($row->status)
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

      <div class="box-footer clearfix">
        <div class="row">
          <div class="col-sm-5">
            Tìm thấy {{ $rows->total() }} kết quả
          </div>
          <div class="col-sm-7">
            {{ $rows->withQueryString()->links('admin.pagination.default') }}
          </div>
        </div>
      </div>

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
                <form action="{{ route('contact.select.all') }}"  data-url="{{ route('contact.select.all') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="GET" method="GET">
                    
                    {{-- <div class="form-group">
                        <input id="is_type" type="hidden" name="is_type" value="contact">
                    </div> --}}
                    <button type="button" class="form-control" data-url="{{ route('contact.select.all') }}" name="submit">Đồng ý</button>
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection
