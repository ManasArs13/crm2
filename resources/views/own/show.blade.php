@extends('adminlte::page')

@if (isset($entity)  && $entity!='')
    @section('title',  __('entity.'.$entity))
@endif

@section('content_header')
    <h1>
        @if (isset($entity)  && $entity!='')
            {{  __('entity.'.$entity)}}
        @endif
    </h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{  __('products.fence_types')}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height:100%">
                    <table class="table table-hover text-nowrap">
                        <tbody>
                        @foreach($columns as $column)
                                <tr>
                                    <td>{{__("column.".$column)}}</td>
                                    <td>
                                        @if (preg_match("/_id\z/u", $column))
                                            @php
                                                $column=substr($column, 0, -3)
                                            @endphp
                                            @if ($entityItem->$column!=null)
                                                {{$entityItem->$column->name}}
                                            @endif
                                        @else
                                            {{$entityItem->$column}}
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
