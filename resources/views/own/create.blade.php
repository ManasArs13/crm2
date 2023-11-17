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
                    <h3 class="card-title">{{  __('title.creating')}}</h3>
                </div>
                <!-- /.card-header -->
                <form class="form-horizontal" action="{{route($action)}}" method="post">
                    @csrf
                    @method("post")
                    <div class="card-body">

                        @foreach($columns as $column)
                            @if ($column!="id" )
                                <div class="form-group row">
                                    <label for="input_{{$column}}" class="col-sm-2 col-form-label">{{__("column.".$column)}}</label>
                                    @if (preg_match("/_id\z/u", $column))
    {{--                                    @php--}}
    {{--                                        $column=substr($column, 0, -3)--}}
    {{--                                    @endphp--}}
    {{--                                    @if ($entityItem->$column!=null)--}}
    {{--                                        {{$entityItem->$column->name}}--}}
    {{--                                    @endif--}}
                                    @else
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="input_{{$column}}" name="{{$column}}" placeholder="{{__("column.".$column)}}">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{__("label.save")}}</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
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
