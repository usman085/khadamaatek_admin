@extends('dashboard.base')

@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header"> Bootstrap Breadcrumb
                      <div class="card-header-actions"><a class="card-header-action" href="http://coreui.io/docs/components/bootstrap-breadcrumb/" target="_blank"><small class="text-muted">docs</small></a></div>
                    </div>
                    <div class="card-body">
                      <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item active" aria-current="page">@lang('dashboard.home')</li>
                        </ol>
                      </nav>
                      <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="#">@lang('dashboard.home')</a></li>
                          <li class="breadcrumb-item active" aria-current="page">Library</li>
                        </ol>
                      </nav>
                      <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="#">@lang('dashboard.home')</a></li>
                          <li class="breadcrumb-item"><a href="#">Library</a></li>
                          <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                      </nav>
                      <nav class="breadcrumb"><a class="breadcrumb-item" href="#">@lang('dashboard.home')</a><a class="breadcrumb-item" href="#">Library</a><a class="breadcrumb-item" href="#">Data</a><span class="breadcrumb-item active">Bootstrap</span></nav>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.row-->
            </div>
          </div>

@endsection

@section('javascript')

@endsection