<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery 3 -->
<script src="{{ asset('themes/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('themes/admin/js/jquery.validate.min.js') }}"></script>
<!-- CKEditor-->
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

{{-- <script src="//cdn.ckeditor.com/4.17.2/full/ckeditor.js"></script> --}}
<!-- ckfinder-->
{{-- <script src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script> --}}
@include('ckfinder::setup')
<!-- Custom & config js -->
<script src="{{ asset('themes/admin/js/custom.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('themes/admin/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('themes/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('themes/admin/plugins/select2/select2.full.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('themes/admin/js/app.min.js') }}"></script>

<script src="{{ asset('themes/admin/plugins/nestable/jquery.nestable.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(function() {
        $('.show_dialog').on('click', function() {
            // dialog
            var title_dialog = $(this).attr('data-title');
            var url = $(this).attr('data-url');
            $('#iframe_block').attr('src', url);
            $("#dialog").dialog({
                title: title_dialog,
                draggable: true,
                height: 600,
                width: '60vw',
                minWidth: '60vw',
                minHeight: 500,
                modal: true,
                dialogClass: "fixed_pos",
                position: {
                    my: "center center",
                    at: "center center",
                    of: window
                },
                close: function() {
                    $('#iframe_block').attr('src', '');
                }
            });

        });

        // $('.kudo').show_block();

        $(".form-block").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    form[0].reset();
                    window.parent.closeIframe();
                    window.parent.location.reload();
                    window.opener.location.reload();
                    window.close();
                },
                error: function(response) {
                    // Get errors
                    console.log(response);
                    var errors = response.responseJSON.errors;
                    // Foreach and show errors to html
                    var elementErrors = '';
                    $.each(errors, function(index, item) {
                        if (item === 'CSRF token mismatch.') {
                            item = "@lang('CSRF token mismatch.')";
                        }
                        elementErrors += '<p>' + item + '</p>';
                    });
                }
            });
        });
    });

    function closeIframe() {
        $('#iframe_block').attr('src', '');
        $('#dialog').dialog('close');
        return false;
    }


    $(".select2").select2();
    // Call single input
    $('.lfm').filemanager('other', {
        // prefix: route_prefix
        prefix: '{{ route('ckfinder_browser') }}'
    });



    const filterArray = (array, fields, value) => {
        fields = Array.isArray(fields) ? fields : [fields];
        return array.filter((item) => fields.some((field) => item[field] === value));
    };

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [day, month, year].join('/');
    }
    $('.completed').on('click', function() {
        return false
    })
</script>
<script>
    $('.delete-select-all').on('click', function(e) {
        $('#delete_action_all').modal('show');
    });

    $('#delete_action_all button[name = "submit"]').on('click', function(e) {
        var idsArr = [];
        $(".checkbox:checked").each(function() {
            idsArr.push($(this).attr('data-id'));
        });
        // let is_type = $("input[name='is_type']").val();
        let urlRequest = $(this).data('url');
        if (idsArr.length <= 0) {
            alert("Vui lòng chọn ít nhất một bản ghi để xóa.");
        } else {
            var ids = idsArr;
            $.ajax({
                type: "GET",
                url: urlRequest,
                data: {
                    ids: ids
                },
                success: function(data) {
                    if (data.code == 200) {
                        //$('#load_color').html(data.html);
                        $('#delete_action_all').modal('hide');
                        $(".checkbox").prop('checked', false);
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                }
            });
        }
    });
    $('#check_all').on('click', function(e) {
        if ($(this).is(':checked', true)) {
            $(".checkbox").prop('checked', true);
        } else {
            $(".checkbox").prop('checked', false);
        }
    });

    $('.checkbox').on('click', function() {
        if ($('.checkbox:checked').length == $('.checkbox').length) {
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }
    });
</script>
