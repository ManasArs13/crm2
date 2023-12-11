@section('title', 'Дашборд')
@extends('adminlte::page')
@section('content')
<div class="wrapper d-flex justify-content-between">
    <div id="card2" class="card bg-gray-light">
        <div class="button-block">
            <div class="buttons">
                <div class="card-tools w-75 justify-content-end d-flex">
                    <label style="display: block;">
                        <input type="date" id="datepicker" value="{{ \Illuminate\Support\Carbon::now()->format('Y-m-d') }}">
                    </label>
                </div>
                <div class="card-tools w-100 h-75 justify-content-end d-flex">
                    <a href="{{route('admin.dashboard',['filter'=>'now'])}}" id="buttons" class="btn " @if(request()->filter == 'now') style="border: solid 2px #676666" @endif>СЕГОДНЯ</a>
                </div>
                <div class="card-tools w-100 h-75 justify-content-end d-flex">
                    <a href="{{route('admin.dashboard',['filter'=>'tomorrow'])}}" id="buttons" class="btn " @if(request()->filter == 'tomorrow') style="border: solid 2px #676666" @endif>ЗАВТРА</a>
                </div>
                <div class="card-tools w-100 h-75 justify-content-end d-flex">
                    <a href="{{route('admin.dashboard',['filter'=>'three-day'])}}" id="buttons" class="btn " @if(request()->filter == 'three-day') style="border: solid 2px #676666" @endif>3 ДНЯ</a>
                </div>
                <div class="card-tools w-100 h-75 justify-content-end d-flex">
                    <a href="{{route('admin.dashboard',['filter'=>'week'])}}" id="buttons" class="btn" @if(request()->filter == 'week') style="border: solid 2px #676666" @endif>НЕДЕЛЯ</a>
                </div>
            </div>
        </div>
        @include('Dashboard.components.canvas')
        @include('Dashboard.components.load')
        @include('Dashboard.components.orderTable',['filter'=>'index'])
    </div>
    <div id="card3" class="card bg-gray-light">
        <div class="card" style="overflow-x:auto ">
            <table cellpadding="5px">
                <thead>
                    <tr>
                        <th class="d-flex justify-content-center align-items-center mb-2 ">
                            <span style="font-size: 25px;color: #949494">Материалы</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td class="m-1 d-flex justify-content-between">
                            {{$material->name}}
                        </td>
                        <td>
                            @if($material->residual_norm !== 0
                            && $material->residual_norm !== null
                            && $material->type !== 'не выбрано')
                            <div @if (round(($material->residual /$material->residual_norm ) * 100) <= 30) class="td-percent-red" @elseif(round(($material->residual /$material->residual_norm ) * 100) > 30 && round(($material->residual /$material->residual_norm ) * 100) <= 70) class="td-percent-yellow" @else class="td-percent" @endif>
                                        {{round(($material->residual /$material->residual_norm ) * 100)}}%
                            </div>
                            @else
                            {{null}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card" style="overflow-x: auto ">
            <table cellpadding="5px">
                <thead>
                    <tr>
                        <th class="d-flex justify-content-center align-items-center mb-2">
                            <span style="font-size: 25px;color: #949494">Товары</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td class="m-1 d-flex justify-content-between">
                            {{$product->name}}
                        </td>
                        <td>
                            @if($product->residual_norm !== 0
                            && $product->residual_norm !== null
                            && $product->type !== 'не выбрано')
                            <div class="td-percent">
                                {{round(($product->residual /$product->residual_norm ) * 100)}}%
                            </div>
                            @else
                            {{null}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
@include('Dashboard.components.style')