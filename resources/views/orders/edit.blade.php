@extends('adminlte::page')

@section('title',  __('order.name'))


@section('content')

    <div class="row container text-center">
        <div class="col-10">
            <div class="row mt-4">
                <div class="col-4 mb-3">
                    <a href="{{route('orders.create')}}" class="form-control btn btn-primary">{{__("order.create")}}</a>
                </div>
                <div class="col-4 mb-3">
                    <a href="{{route('orders.index')}}" class="form-control btn btn-primary">{{__("order.index")}}</a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 mb-3">
                    <div class="row justify-content-between">
                        <h3 class="col-4">{{  __('order.name')}} <span></span></h3>

                        <div class=" col-4">
                            <span class="date align-baseline fs-3">{{ date('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <form class="form-horizontal" action="{{route($action)}}" method="post">
                @csrf
                @method("post")

                <div class="card calculator">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>{{__("column.fence_type_id")}}</td>
                                        <td>
                                            <div class="form-group">
                                                <select class="custom-select form-control-border" name="fence_type_id">
                                                    @foreach ($fenceTypes as $fenceType)
                                                        <option value="{{$fenceType->id}}">{{$fenceType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.fence_length")}}</td>
                                        <td>
                                            <input type="text" name="fence_length"
                                                   class='form-control form-control-border' value="{{$defaultValues["fence_length"]}}">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.number_of_columns")}}</td>
                                        <td><input type="text" class='form-control form-control-border'
                                                   name="number_of_columns" value="{{$defaultValues["number_of_columns"]}}"></td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.wall_id")}}</td>
                                        <td>
                                            <select class="custom-select form-control-border" name="wall_id">
                                                @foreach ($wallsHeights as $wall)
                                                    <option value="{{$wall->id}}">{{$wall->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{__("column.column_id")}}</td>
                                        <td>
                                            <select class="custom-select form-control-border" name="column_id">
                                                @foreach ($columnsHeights as $column)
                                                    <option value="{{$column->id}}">{{$column->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">

                                @php
                                    $total_column_length=0.28*$defaultValues["number_of_columns"];
                                    $total_wall_length=$defaultValues["fence_length"]-$total_column_length;
                                    $wall_step=ceil($total_wall_length/0.4);

                                    $block_rows=0;
                                    if ($fenceTypes[0]->id==1)
                                        $block_rows=$wallsHeights[0]->name/20;
                                    elseif ($fenceTypes[0]->id==2 or $fenceTypes[0]->id==3)
                                        $block_rows=$wallsHeights[0]->name/20-1;
                                @endphp

                                <table class="table table-bordered">
                                    <tbody>
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
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="height:100%">
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
                                $productsJS=json_encode($products);
                            @endphp
                            @foreach($productsCategories as $category)
                                <tr>
                                    <td>{{$category->name}}</td>
                                    @php
                                        $quantity=1;
                                        switch($category->id){
                                            case '8a32b2b3-4bd4-11e9-9109-f8fc0011b70f':
                                                $quantity=$wall_step*$block_rows;
                                                break;
                                                //decor
                                            case '63ed558e-9f46-11ea-0a80-05d800085fa4':
                                                if ($fenceTypes[0]->id==1)
                                                   $quantity=0;
                                                elseif ($fenceTypes[0]->id==2 or $fenceTypes[0]->id==3)
                                                    $quantity=$wallsHeights[0]->name*2;
                                                break;
                                                //parapet
                                            case '89392d42-4bd5-11e9-9107-50480012181f':
                                                 if ($fenceTypes[0]->id==1 or $fenceTypes[0]->id==2)
                                                   $quantity=$wall_step;
                                                elseif ($fenceTypes[0]->id==3)
                                                    $quantity=$wall_step*3;
                                                break;
                                                //krishki
                                            case '9fa1ece2-4bd5-11e9-9ff4-34e800129536':
                                                $quantity=$defaultValues["number_of_columns"];
                                                break;
                                                //kolonni
                                            case 'fe72b162-a056-11e7-7a6c-d2a900046be1':
                                                $quantity=$columnsHeights[0]->name*$defaultValues["number_of_columns"]/20;
                                                break;
                                        }
                                        $sum=$products[$category->id][$defaultValues["color_id"]]["price"]*$quantity;
                                        $weight=$products[$category->id][$defaultValues["color_id"]]["weight_kg"]*$quantity;

                                        $totalSum+=$sum;
                                        $totalWeight+=$weight;
                                        $product=[
                                           // "category_id"=>$category->id,
                                           // "color_id"=>$defaultValues["color_id"],
                                            "product_id"=>$products[$category->id][$defaultValues["color_id"]]["id"],
                                            "price"=>$products[$category->id][$defaultValues["color_id"]]["price"],
                                            "quantity"=>$quantity,
                                            "sum"=>$sum,
                                            "weight"=>$weight
                                        ];
                                    @endphp
                                    <td>
                                        <input type="hidden" name="products[{{$category->id}}]" value="{{json_encode($product)}}">
                                        <span id="quantity_{{$category->id}}">{{$quantity}}</span>
                                    </td>
                                    <td>
                                        <select class="custom-select form-control-border" name="color_id">
                                            @foreach ($colors as $color)
                                                <option value="{{$color->id}}" {{$color->id==$defaultValues["color_id"]?"selected":""}}>
                                                    <div
                                                        style="background: #{{$color->hex}}; border-radius: 2px; height: 10px; width:100%">{{$color->name}}</div>
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><span id="weight_kg_{{$category->id}}">{{$weight}}</span></td>
                                    <td>{{$products[$category->id][$defaultValues["color_id"]]["price"]}}</td>
                                    <td><span id="sum_{{$category->id}}">{{$sum}}</span></td>
                                </tr>

                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    {{$totalWeight}}
                                    <input type="hidden" class='form-control form-control-border'
                                           name="weight" disabled value="{{$totalWeight}}">
                                </td>
                                <td></td>
                                <td>
                                    {{$totalSum}}
                                    <input type="hidden" class='form-control form-control-border'
                                           name="sum" disabled value="{{$totalSum}}">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="row mb-3">
                    <div class="col-4">
                        <div class="form-group">
                            <select class="custom-select form-control-border" name="delivery_id">
                                @foreach ($deliveries as $delivery)
                                    <option value="{{$delivery->id}}">
                                        {{$delivery->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <select class="custom-select form-control-border" name="vehicle_type_id">
                                @foreach ($vehicleTypes as $vehicleType)
                                    <option value="{{$vehicleType->id}}">
                                        {{$vehicleType->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" class='form-control form-control-border' name="price">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input type="text" class='form-control form-control-border' name="name"
                               placeholder="{{__("column.name")}}">
                    </div>
                    <div class="col-6">
                        <input type="text" class='form-control form-control-border' name="phone"
                               placeholder="{{__("column.phone")}}">
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-4">
                        <a class="form-control btn btn-primary" href="javascript:(print());"> {{__("order.print")}}</a>
                    </div>
                    <div class="col-4">
                        <a href="#" class="form-control btn btn-primary">{{__("order.sendOrderToMs")}}</a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="form-control btn btn-primary">{{__("label.save")}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')

@stop

@section('js')
    <script>
        if (typeof window.staticStore === 'undefined') {
            window.staticStore = {};
        }
        window.staticStore.products=JSON.parse('{!! $productsJS !!}');;
        console.log(window.staticStore.products);

    </script>
    @vite('resources/js/app.js')
@stop
