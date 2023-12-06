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
                    <h3 class="card-title">{{  __('title.editing')}}</h3>
                </div>
                <!-- /.card-header -->
                <form class="form-horizontal" action="{{ route($action, $entityItem->id) }}" method="post">
                    @csrf
                    @method("PATCH")
                    <div class="card-body">
                        @foreach($columns as $column)
                            @if ($column!="id" and $column!="created_at" and $column!="updated_at")
                                <div class="form-group row">
                                    <label for="input_{{$column}}" class="col-sm-2 col-form-label">{{__("column.".$column)}}</label>
                                    @if (preg_match("/_id\z/u", $column))
                                        @php
                                            $column=substr($column, 0, -3)
                                        @endphp
                                        @if ($entityItem->$column!=null)
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input_{{$column}}" name="{{$column.'_id'}}" placeholder="{{__("column.".$column)}}" value="{{$entityItem->$column->id}}">
                                            </div>
                                        @else
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input_{{$column}}" name="{{$column.'_id'}}" placeholder="{{__("column.".$column)}}" value="{{isset($entityItem->$column->name)?$entityItem->$column->id:''}}">
                                            </div>
                                        @endif
                                    @elseif( $column == 'type' )
                                    <div class="col-sm-10">
                                            <select  class="custom-select" name="type" id="inputGroupSelect01">
                                                <option value="не выбрано" @if($entityItem->$column == 'не выбрано')selected @endif>не выбрено</option>
                                                <option value="продукция" @if($entityItem->$column == 'продукция') selected @endif>продукция</option>
                                                <option value="материал" @if($entityItem->$column == 'материал')selected @endif>материал</option>
                                            </select>
                                        </div>
                                    @elseif($column == 'building_material')
                                        <div class="col-sm-10">
                                            <select  class="custom-select" name="building_material" id="inputGroupSelect01">
                                                <option value="не выбрано" @if($entityItem->$column == 'не выбрано')selected @endif>не выбрено</option>
                                                <option value="бетон" @if($entityItem->$column == 'бетон') selected @endif>бетон</option>
                                                <option value="блок" @if($entityItem->$column == 'блок')selected @endif>блок</option>
                                            </select>
                                        </div>
                                    @else
                                        @if(isset($consumption))
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input_{{$column}}" name="{{$column}}" placeholder="{{__("column.".$column)}}" value="{{$consumption}}">
                                            </div>
                                        @endif
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="input_{{$column}}" name="{{$column}}" placeholder="{{__("column.".$column)}}" value="{{$entityItem->$column}}">
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
