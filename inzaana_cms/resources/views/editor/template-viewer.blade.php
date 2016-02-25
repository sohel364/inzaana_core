@extends('layouts.editor-master') 
@section('title', 'Edit Template') 

@section('header-style')
    <link href="{{ asset('editor_asset/css/main.css') }}" rel="stylesheet" />
    <link href="{{ asset('editor_asset/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('editor_asset/css/bootstrap-dialog.css') }}" rel="stylesheet" />
    <link href="{{ asset('editor_asset/css/jquery-ui.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('editor_asset/css/drag_drop_style.css') }}" rel="stylesheet" />
    <link href="{{ asset('editor_asset/css/control_palette.css') }}" rel="stylesheet" />
    <link href="{{ asset('editor_asset/css/control_template.css') }}" rel="stylesheet" />
    <link href="{{ asset('editor_asset/css/spectrum.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet"
        href="{{ asset('editor_asset/css/jquery-te-1.4.0.css') }}">
    <link href="{{ asset('editor_asset/css/control_template.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('editor_asset/css/control_editor.css') }}" rel="stylesheet" />
@endsection

@section('header-script')
    <script src="{{ asset('editor_asset/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('editor_asset/js/jquery-2.1.1.min.js') }}"></script>
    <script src="{{ asset('editor_asset/js/jquery.flexisel.js') }}"></script>
    <script src="{{ asset('editor_asset/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('editor_asset/js/bootstrap-dialog.js') }}"></script>
    <script src="{{ asset('editor_asset/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('editor_asset/js/spectrum.js') }}"></script>
    <script src="{{ asset('editor_asset/js/jquery.sortable.js') }}"></script>
    <script src="{{ asset('editor_asset/js/main.js') }}"></script>

    <?php
        include ("templates/$category/$template_id/header.html");
    ?>
    <script src="{{ asset('editor_asset/js/savePage.js') }}"></script>
    <script src="{{ asset('editor_asset/js/drag_drop.js') }}"></script>
    <script src="{{ asset('editor_asset/js/menu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('editor_asset/js/template_editor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('editor_asset/js/jquery-te-1.4.0.min.js') }}"
            charset="utf-8"></script>
    <script src="{{ asset('editor_asset/js/outside-click.js') }}"></script>
    <script src="{{ asset('editor_asset/js/control_palette.js') }}"></script>
    <script src="{{ asset('editor_asset/js/jquery.path.js') }}"></script>
    <script src="{{ asset('editor_asset/js/control_editor.js') }}"></script>
    <script>
        isInEditor = false; 
    </script>
@endsection

@section('content')
    <!-- <div>
        @if (Auth::check())
            <button class="template_save_btn btn btn-success"
                onclick="savePage(user_id, template_id);" style="display: block;">Save
            </button>
        @endif
        <canvas id="hidden-canvas" style="display:none"></canvas>
    </div> -->

    <br />
    <br />
    <br />

        <!-- Template Elements  Here -->

    <div id="frame" class="droppedFields">
        <div style="background-color: white;">
            <div class="container">
                <div class="navbar-header">
                    <button data-target="#mainNav" data-toggle="collapse"
                        class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span> <span
                            class="icon-bar"></span> <span class="icon-bar"></span> <span
                            class="icon-bar"></span>
                    </button>
                </div>
                <div id="mainNav" class="collapse navbar-collapse">
                    <?php include ("templates/$category/$template_id/menu.html");?>
                </div>
            </div>
        </div>
        
        <div id="body" contentEditable="false" >
            <?php include ("templates/$category/$template_id/body.html");?>
        </div>

        <div id="footer">
            <?php include ("templates/$category/$template_id/footer.html");?>
        </div>
    </div>
@endsection
