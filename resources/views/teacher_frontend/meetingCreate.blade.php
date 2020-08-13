@extends('teacher_frontend.layouts.master')
@section('content')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group float-right m-b-20">
                            <button type="button" class="btn btn-custom dropdown-toggle page-title-drop waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">Settings <span class="m-l-5"><i class="fa fa-cog"></i></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" class="dropdown-item">Action</a></li>
                                <li><a href="#" class="dropdown-item">Another action</a></li>
                                <li><a href="#" class="dropdown-item">Something else here</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a href="#" class="dropdown-item">Separated link</a></li>
                            </ul>
                        </div>
                        <h4 class="page-title">Starter Page</h4>

                    </div>
                </div>



            </div> <!-- container-fluid -->

        </div> <!-- content -->

        <footer class="footer">
            2017 - 2019 c Flacto. <span class="d-none d-sm-inline-block">Design by <a href="http://coderthemes.com/" target="_blank" class="text-muted">Coderthemes</a></span>
        </footer>

    </div>
@endsection
@section('title','首頁')