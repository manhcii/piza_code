<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('themes/admin/css/bootstrap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('themes/admin/css/font-awesome.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('themes/admin/plugins/Ionicons/css/ionicons.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('themes/admin/plugins/select2/select2.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('themes/admin/css/AdminXKT.min.css') }}">
<!-- Skin style -->
<link rel="stylesheet" href="{{ asset('themes/admin/css/skins/_all-skins.min.css') }}">

<link rel="stylesheet" href="{{ asset('themes/admin/plugins/nestable/jquery.nestable.min.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">




<style>
    #dialog {
        display: none;
        overflow: unset;
    }

    .h4,
    .h5,
    .h6,
    h4,
    h5,
    h6 {
        margin-top: 0;
        margin-bottom: 0;
    }

    .ml-15 {
        margin-left: 15px !important;
    }

    .mr-15 {
        margin-right: 15px !important;
    }

    .mx-15 {
        margin: 0 15px !important;
    }

    .my-15 {
        margin: 15px 0 !important;
    }

    .ml-10 {
        margin-left: 10px !important;
    }

    .mr-10 {
        margin-right: 10px !important;
    }

    .mx-10 {
        margin: 0 10px !important;
    }

    .my-10 {
        margin: 10px 0 !important;
    }

    .checkbox_list {
        padding: 10px;
        list-style: none;
        border: 1px dashed;
    }

    .checkbox_list li label {
        font-size: 14px;
    }

    .border-top {
        border-top: 1px dashed #CDCDCD;
    }

    .border-bottom {
        border-bottom: 1px dashed #CDCDCD;
    }

    .py-2 {
        padding-top: .5rem !important;
        padding-bottom: .5rem !important;
    }

    ul.extra-service:last-child {
        margin: 0;
    }

    .extra-service {
        margin: 10px 0 0;
        display: table;
        width: 100%;
        padding: 0;
    }

    ul.extra-service {
        list-style: none;
    }

    .icon-box-icon-block {
        width: 100%;
        display: inline-block;
    }

    .icon-box-round {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 42px;
        margin-right: 5px;
        color: #27b737;
        font-size: 25px;
        text-align: center;
        border-radius: 50%;
        vertical-align: middle;
    }

    .icon-box-text {
        display: inline-block;
        vertical-align: middle;
    }

    .skin-green .sidebar-menu>li.header {
        color: #FFFFFF;
        background: #1a2226;
    }

    .sidebar-menu li.header {
        font-size: 16px !important;
        text-transform: uppercase;
        font-family: 'RobotoCondensed-Bold', sans-serif;
        padding: 10px 0px 10px 15px;
    }

    .sidebar-menu>li>a {
        padding: 10px 0px 10px 15px;
        display: block;
    }

    .sidebar-menu>li>a>.fa,
    .sidebar-menu>li>a>.glyphicon,
    .sidebar-menu>li>a>.ion,
    .sidebar-menu>li.header .fa,
    .sidebar-menu>li.header .glyphicon,
    .sidebar-menu>li.header .ion {
        width: 20px;
    }

    .sidebar-menu li span {
        font-size: 14px !important;
        font-family: 'RobotoCondensed-Regular', sans-serif;
    }

    .main-sidebar {
        box-shadow: 0 14px 28px rgba(0, 0, 0, .25), 0 10px 10px rgba(0, 0, 0, .22) !important;
        padding-top: 55px;
    }

    .skin-green-light .sidebar-menu>li.header {
        color: #FFFFFF;
        background: #00A157;
    }

    .skin-green-light .main-header .navbar {
        background-color: #00A157;
    }

    .skin-green-light .sidebar-menu>li>a {
        border-left: 3px solid transparent;
    }

    .skin-green-light .sidebar-menu>li:hover>a,
    .skin-green-light .sidebar-menu>li.active>a {
        color: darkcyan;
        border-left-color: darkcyan;
        background: #ecf0f5;
    }

    .mb-15 {
        margin-bottom: 15px;
    }

    .cursor {
        cursor: pointer;
    }

    #loading {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 50;
        background: rgba(255, 255, 255, 0.7);
    }

    .overlay {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transform: -webkit-translate(-50%, -50%);
        transform: -moz-translate(-50%, -50%);
        transform: -ms-translate(-50%, -50%);
        color: #1f222b;
        z-index: 9999;
        background: rgba(255, 255, 255, 0.7);
    }

    .active-item {
        background: #c9eada !important;
    }

    .d-flex-wap {
        display: flex;
        flex-wrap: wrap;
    }

    .align-center {
        align-items: center;
    }

    .ml-1 {
        margin-left: 1rem !important;
    }

    .dd-empty,
    .dd-item,
    .dd-placeholder {
        margin: 10px 0;
    }

    .dd-item>button {
        height: 30px;
    }

    .box-body {
        /* border: 1px solid #ddd; */
        margin-bottom: 10px;
    }

    .box-body .form-horizontal .form-group {
        /* margin: 0px */
    }

    .dd-item .item-details {
        border-bottom: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        margin-bottom: 5px;
        margin-top: 0px;
        max-width: 100%;
        padding: 10px 15px;
    }

    .dd3-content {
        background-color: #fff;
        border: 0;
        height: 40px;
        padding: 10px;
        width: 100%;
    }

    .dd3-handle {
        background: transparent;
        border: 1px solid #aaa;
        border-radius: 0;
        cursor: move;
        height: 40px;
        left: 0;
        margin: 0;
        overflow: hidden;
        position: absolute;
        text-indent: 100%;
        top: 0;
        white-space: nowrap;
        width: 100%;
    }

    .dd3-handle:hover {
        background-color: transparent;
    }

    .dd3-content>span.text.float-end,
    .dd3-content>span.text.float-start {
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        -ms-text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dd3-content>span.text.float-start {
        max-width: 200px;
    }

    .float-start {
        float: left !important;
    }

    .dd3-content .show-item-details {
        background-color: #ccc;
        border-left: 1px solid #aaa;
        color: #000;
        right: 0px;
        ;
        line-height: 38px;
        position: absolute;
        text-align: center;
        top: 1px;
        width: 43px;
    }

    .widget-menu .widget.meta-boxes>a {
        text-decoration: none !important;
    }

    .widget {
        background: #ffffff;
        clear: both;
        margin-bottom: 10px;
    }

    .meta-boxes {
        margin-top: 10px;
    }

    .widget.meta-boxes:first-child {
        margin-top: 0;
    }

    .widget-title {
        cursor: move;
        overflow: hidden;
        background: #ebeae8;
        height: 44px;
        line-height: 34px;
        border-bottom: 1px solid #ffffff;
        color: #1f64a0 !important;
    }

    .widget-menu .meta-boxes .narrow-icon {
        float: right;
        margin-right: 0;
        margin-top: 12px;
    }

    .widget-menu .widget.meta-boxes .collapsed h4.widget-title .narrow-icon:before {
        content: "\f107";
    }

    .meta-boxes .widget-title {
        cursor: pointer;
        overflow: hidden;
        height: 40px;
        /* border: 1px solid #ddd; */
        padding: 0 10px;
        background: none;
        display: flex;
        align-items: center;
        justify-content: space-between
    }

    .widget-menu .widget.meta-boxes .widget-title {
        cursor: pointer;
        font-size: 14px;
        font-weight: 400;
        height: 40px;
        line-height: 40px;
        padding: 0 15px;
    }

    .widget-body {
        padding: 15px 15px;
        border-radius: 0 0 3px 3px;
        min-height: 200px;
    }

    .widget-menu .widget.meta-boxes .widget-body {
        min-height: 130px;
    }

    .box-links-for-menu .list-item {
        border: 1px solid #ddd;
        max-height: 200px;
        overflow: auto;
        padding: 15px;
    }

    .mCSB_container {
        padding: 10px;
    }

    .box-links-for-menu .list-item li {
        list-style: none;
        margin-bottom: 5px;
        position: relative;
    }

    .box-links-for-menu .list-item li label {
        max-width: 80%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    input[type=checkbox] {
        cursor: pointer;
        margin: 0 0.5rem 0 0;
        position: relative;
        top: 0;
    }

    .box-links-for-menu .list-item li label input {
        margin-left: 5px;
    }

    input[type=checkbox]:before {
        border-color: #58b3f0;
        border-style: none none solid solid;
        border-width: 2px;
        content: "";
        height: 5px;
        left: 2px;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0.2em;
        transform: rotate(-45deg) scale(0);
        transition: transform .4s cubic-bezier(.45, 1.8, .5, .75);
        width: 10px;
        z-index: 1;
    }

    input[type=checkbox]:after {
        background: #fff;
        border: 1px solid #c4cdd5;
        border-radius: 3px;
        bottom: 0;
        content: "";
        cursor: pointer;
        height: 16px;
        left: -1px;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0;
        width: 16px;
    }

    input[type=checkbox]:checked:before {
        transform: rotate(-45deg) scale(1);
    }

    input[type=checkbox]:checked:after {
        border-color: #58b3f0;
    }

    .float-end {
        float: right !important;
    }

    .dd3-content>span.text.float-end,
    .dd3-content>span.text.float-start {
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        -ms-text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dd3-content>span.text.float-end {
        margin-right: 40px;
        max-width: 100px;
    }

    .dd {
        max-width: 100% !important;
    }

    .sw_featured .switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 26px;
    }

    .sw_featured .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .sw_featured .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .sw_featured .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .sw_featured input:checked+.slider {
        background-color: #2196F3;
    }

    .sw_featured input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    .sw_featured input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .sw_featured .slider.round {
        border-radius: 34px;
    }

    .sw_featured .slider.round:before {
        border-radius: 50%;
    }

    .box_img_right img {
        width: 150px !important;
        height: 150px !important;
        object-fit: cover;
    }

    .box_img_right {
        position: relative;
        display: inline-block;
    }

    .box_img_right .btn-remove {
        position: absolute;
        top: 0px;
        left: 160px;
        display: none;
    }

    .box_img_right.active:hover .btn-remove {
        display: block;
    }

    .list-relation {
        list-style: none;
    }

    .dropdown-menu {
        font-size: 13px;
    }

    .dd-handle {
        cursor: move;
    }

    .rating .star:after,
    .rating .star:before {
        display: inline-block;
        color: #f5bf1c;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        line-height: 1;
        letter-spacing: 5px;
    }

    .rating.small .star:after,
    .rating.small .star:before {
        font-size: 13px;
        letter-spacing: 2px;
    }

    .rating .star.star-1:before {
        content: "\f005";
    }

    .rating .star.star-2:before {
        content: "\f005\f005";
    }

    .rating .star.star-3:before {
        content: "\f005\f005\f005";
    }

    .rating .star.star-4:before {
        content: "\f005\f005\f005\f005";
    }

    .rating .star.star-5:before {
        content: "\f005\f005\f005\f005\f005";
    }

    .rating .star:after {
        color: #e1e1e1;
    }

    .rating .star.star-0:after {
        content: "\f005\f005\f005\f005\f005";
    }

    .rating .star.star-1:after {
        content: "\f005\f005\f005\f005";
    }

    .rating .star.star-2:after {
        content: "\f005\f005\f005";
    }

    .rating .star.star-3:after {
        content: "\f005\f005";
    }

    .rating .star.star-4:after {
        content: "\f005";
    }

    .rating .star {
        display: inline-block;
    }

    .rating .review-count {
        display: inline-block;
        margin-left: 10px;
    }

    .box_bg_color {
        position: relative;
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        top: 5px;
    }

    .box_excel {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-items: center;
    }

    .box_excel .btn {
        margin-left: 20px;
    }

    .gallery-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
    }
    .gallery-image.my-15{
        height: 180px;
    }
</style>
