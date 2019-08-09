@extends('layout.master')
@section('title', 'Table Dragger')
@section('parentPageTitle', 'Table')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/table-dragger/table-dragger.min.css')}}">
@stop
@section('content')
<div class="container-fluid">       
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Default <small>With no options, sort columns, handler was the first row</small></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="default-table" class="table table-striped">
                            <thead>
                                <tr>
                                <th>Movie Title<i class="zmdi zmdi-arrows"></i></th>
                                <th>Genre<i class="zmdi zmdi-arrows"></i></th>
                                <th>Year<i class="zmdi zmdi-arrows"></i></th>
                                <th>Gross<i class="zmdi zmdi-arrows"></i></th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Star Wars</td>
                                <td>Adventure, Sci-fi</td>
                                <td>1977</td>
                                <td>$460,935,665</td>
                            </tr>
                            <tr>
                                <td>Howard The Duck</td>
                                <td>"Comedy"</td>
                                <td>1986</td>
                                <td>$16,295,774</td>
                            </tr>
                            <tr>
                                <td>American Graffiti</td>
                                <td>Comedy, Drama</td>
                                <td>1973</td>
                                <td>$115,000,000</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Handler <small>Specify drag handler wherever within the table</small></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="handle-table" class="table table-striped">
                            <thead>
                                <tr>
                                <th>Movie Title <i class="zmdi zmdi-arrows handle">dragme</i></th>
                                <th>Genre</th>
                                <th>Year</th>
                                <th>Gross</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Star Wars</td>
                                <td>Adventure, Sci-fi</td>
                                <td>1977</td>
                                <td>$460,935,665</td>
                            </tr>
                            <tr>
                                <td>Howard The Duck</td>
                                <td>"Comedy"</td>
                                <td>1986</td>
                                <td>$16,295,774</td>
                            </tr>
                            <tr>
                                <td>American Graffiti</td>
                                <td>Comedy, Drama</td>
                                <td>1973</td>
                                <td>$115,000,000</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Only Body <small>Setting onlyBody to true in row mode, user can only lift rows in tBody</small></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="only-bodytable" class="table table-striped">
                            <thead>
                                <tr>
                                <th>Movie Title</th>
                                <th>Genre</th>
                                <th>Year</th>
                                <th>Gross</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Star Wars<i class="zmdi zmdi-arrows sindu_handle"></i></td>
                                <td>Adventure, Sci-fi</td>
                                <td>1977</td>
                                <td>$460,935,665</td>
                            </tr>
                            <tr>
                                <td>Howard The Duck<i class="zmdi zmdi-arrows sindu_handle"></i></td>
                                <td>"Comedy"</td>
                                <td>1986</td>
                                <td>$16,295,774</td>
                            </tr>
                            <tr>
                                <td>American Graffiti<i class="zmdi zmdi-arrows sindu_handle"></i></td>
                                <td>Comedy, Drama</td>
                                <td>1973</td>
                                <td>$115,000,000</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>                
    </div>
    
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Sort Rows <small>Sort rows, handler was the first column</small></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="row-table" class="table table-striped">
                            <thead>
                                <tr>
                                <th>Movie Title<i class="zmdi zmdi-arrows"></i></th>
                                <th>Genre</th>
                                <th>Year</th>
                                <th>Gross</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Star Wars<i class="zmdi zmdi-arrows"></i></td>
                                <td>Adventure, Sci-fi</td>
                                <td>1977</td>
                                <td>$460,935,665</td>
                            </tr>
                            <tr>
                                <td>Howard The Duck<i class="zmdi zmdi-arrows"></i></td>
                                <td>"Comedy"</td>
                                <td>1986</td>
                                <td>$16,295,774</td>
                            </tr>
                            <tr>
                                <td>American Graffiti<i class="zmdi zmdi-arrows"></i></td>
                                <td>Comedy, Drama</td>
                                <td>1973</td>
                                <td>$115,000,000</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Free <small>After mousedown, move mouse horizontally or vertically, see what happens. Don't forget to specify drag handler</small></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table id="free-table" class="table table-striped">
                            <thead>
                                <tr>
                                <th>Movie Title</th>
                                <th>Genre</th>
                                <th>Year</th>
                                <th>Gross</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Star Wars<i class="zmdi zmdi-arrows handle"></i></td>
                                <td>Adventure, Sci-fi</td>
                                <td>1977</td>
                                <td>$460,935,665</td>
                            </tr>
                            <tr>
                                <td>Howard The Duck</td>
                                <td>"Comedy"</td>
                                <td>1986</td>
                                <td>$16,295,774</td>
                            </tr>
                            <tr>
                                <td>American Graffiti</td>
                                <td>Comedy, Drama</td>
                                <td>1973</td>
                                <td>$115,000,000</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/table-dragger/table-dragger.min.js')}}"></script>
<script>
    // Default
    tableDragger(document.querySelector("#default-table"));

    // Handler
    tableDragger(document.querySelector("#handle-table"), { dragHandler: ".handle" });

    // Sort Rows
    tableDragger(document.querySelector("#row-table"), { mode: "row" });

    // Free
    tableDragger(document.querySelector("#free-table"), { mode: "row", onlyBody: true, dragHandler: ".handle" });

    // Only Body
    tableDragger(document.querySelector("#only-bodytable"), { mode: "row", onlyBody: true });
</script>
@stop