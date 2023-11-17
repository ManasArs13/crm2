@extends('adminlte::page')

@section('title',  __('order.name').$entityItem->id)


@section('content')

    <div class="row container text-center">
        <div class="col-12">
            <div class="row mt-4">
                <div class="col-12 mb-3">
                    <div class="row justify-content-between">
                        <h1 class="col-4">{{  __('order.name')}} <span>{{$entityItem->id}}</span></h1>

                        <div class=" col-4">
                            <span class="date align-baseline fs-3">{{ $entityItem->created_at->format("d.m.Y") }}</span>
                        </div>
                    </div>
                </div>
            </div>

{{--            <div class="card calculator">--}}
{{--                    <div class="card-header">--}}
                        <div class="row">
                            <div class="table-responsive col-4">
                                @php
                                    $total_column_length=0.28*$entityItem->number_of_columns;
                                    $total_wall_length=$entityItem->fence_length-$total_column_length;
                                    $wall_step=ceil($total_wall_length/0.4);

                                    $block_rows=0;
                                    if ($entityItem->fence_type->id==1)
                                        $block_rows=$entityItem->wall->name/20;
                                    elseif ($entityItem->fence_type->id==2 or $entityItem->fence_type->id==3)
                                        $block_rows=$entityItem->wall->name/20-1;
                                @endphp
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>{{__("column.fence_type_id")}}</td>
                                        <td>
                                            @if ($entityItem->fence_type!=null)
                                                {{$entityItem->fence_type->name}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.fence_length")}}</td>
                                        <td>
                                            {{$entityItem->fence_length}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.number_of_columns")}}</td>
                                        <td>
                                           {{$entityItem->number_of_columns}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.wall_id")}}</td>
                                        <td>
                                            @if ($entityItem->wall!=null)
                                                {{$entityItem->wall->name}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.column_id")}}</td>
                                        <td>
                                            @if ($entityItem->column!=null)
                                               {{$entityItem->column->name}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="td background"></td>
                                    </tr>
                                    <tr>
                                        <td>Шагов стены</td>
                                        <td><span id="wall_step">{{$wall_step}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Рядов блока</td>
                                        <td><span id="block_rows">{{$block_rows}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Длина стены общая</td>
                                        <td><span id="total_wall_length">{{$total_wall_length}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Длина колонн общая</td>
                                        <td><span id="total_column_length">{{$total_column_length}}</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-8">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{{__("column.positions")}}</th>
                                        <th>{{__("column.quantity")}}</th>
                                        <th>{{__("column.color_id")}}</th>
                                        <th>{{__("column.weight")}}</th>
                                        <th>{{__("column.price")}}</th>
                                        <th>{{__("column.sum")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $totalSum=0;
                                        $totalWeight=0;
                                    @endphp
                                    @foreach($entityItem->positions as $position)
                                        <tr>
                                            <td>{{$position->product->category->name}}</td>
                                            @php
                                                $sum=$position->price*$position->quantity;
                                                $weight=$position->product->weight_kg*$position->quantity;
                                                $totalSum+=$sum;
                                                $totalWeight+=$weight;
                                            @endphp
                                            <td>
                                                {{$position->quantity}}
                                            </td>
                                            <td>
                                                {{$position->product->color->name}}
                                            </td>
                                            <td>{{$weight}}</td>
                                            <td>{{$position->price}}</td>
                                            <td>{{$sum}}</td>
                                        </tr>

                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            {{$entityItem->weight}}
                                        </td>
                                        <td></td>
                                        <td>
                                            {{$entityItem->sum}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        @if ($entityItem->delivery!=null)
                                            {{$entityItem->delivery->name}}
                                        @endif
                                    </div>

                                    <div class="col-4">
                                        @if ($entityItem->vehicle_type!=null)
                                            {{$entityItem->vehicle_type->name}}
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        {{$entityItem->delivery_price}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        {{$entityItem->name}}
                                    </div>
                                    <div class="col-6">
                                        {{$entityItem->phone}}
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                    </div>--}}
{{--                    <!-- /.card-header -->--}}
{{--                    <div class="card-body" style="height:100%">--}}

{{--                    </div>--}}
{{--                    <!-- /.card-body -->--}}
{{--                </div>--}}
{{--                <!-- /.card -->--}}



                <div class="row mt-4">
                    <div class="col-3">
                        <a class="form-control btn btn-primary" href="javascript:(print());"> {{__("order.print")}}</a>
                    </div>
                    <div class="col-3">
                        <a href="{{route("orders.createOrderMs", $entityItem->id)}}" class="form-control btn btn-primary">{{__("order.sendOrderToMs")}}</a>
                    </div>

                    <div class="col-3">
                        <a href="{{route('orders.create')}}" class="form-control btn btn-primary">{{__("order.create")}}</a>
                    </div>
                    <div class="col-3">
                        <a href="{{route('orders.index')}}" class="form-control btn btn-primary">{{__("order.index")}}</a>
                    </div>
                </div>
        </div>
    </div>

@stop

@section('css')
    @vite('resources/css/app.css')
@stop

@section('js')

@stop
