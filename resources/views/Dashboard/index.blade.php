@section('title', 'Дашборд')
@extends('adminlte::page')
@section('content')
<div class="row py-2">
    <div class="col-9">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex flex-grow-1">
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'now' || request()->filter == null)
                        <a href="{{route('admin.dashboard',['filter'=>'now'])}}" class="btn btn-info">Сегодня</a>
                        @else
                        <a href="{{route('admin.dashboard',['filter'=>'now'])}}" class="btn btn-primary">Сегодня</a>
                        @endif
                    </div>
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'tomorrow')
                        <a href="{{route('admin.dashboard',['filter'=>'tomorrow'])}}" class="btn btn-info">Завтра</a>
                        @else
                        <a href="{{route('admin.dashboard',['filter'=>'tomorrow'])}}" class="btn btn-primary">Завтра</a>
                        @endif
                    </div>
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'three-day')
                        <a href="{{route('admin.dashboard',['filter'=>'three-day'])}}" class="btn btn-info">3 дня</a>
                        @else
                        <a href="{{route('admin.dashboard',['filter'=>'three-day'])}}" class="btn btn-primary">3 дня</a>
                        @endif
                    </div>
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'week')
                        <a href="{{route('admin.dashboard',['filter'=>'week'])}}" class="btn btn-info">Неделя</a>
                        @else
                        <a href="{{route('admin.dashboard',['filter'=>'week'])}}" class="btn btn-primary">Неделя</a>
                        @endif
                    </div>
                </div>
                <div class="d-flex">
                    <div class="card-tools mx-1">
                        <label style="display: block;">
                            <span>{{ \Illuminate\Support\Carbon::now()->format('Y-m-d') }}<span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body p-2 wrapper">
                @include('Dashboard.components.canvas')
            </div>
        </div>
        <div class="card">
            @include('Dashboard.components.load')
            @include('Dashboard.components.orderTable',['filter'=>'index'])
        </div>
    </div>
    <div class="col-3">
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
                            <div @if (round(($material->residual /$material->residual_norm ) * 100) <= 30) class="btn btn-danger" @elseif(round(($material->residual /$material->residual_norm ) * 100) > 30 && round(($material->residual /$material->residual_norm ) * 100) <= 70) class="btn btn-warning" @else class="btn btn-success" @endif>
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
                    @if($product->residual_norm)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td class="m-1 d-flex justify-content-between">
                            {{$product->name}}
                        </td>
                        <td>
                        @if($product->residual_norm !== 0
                            && $product->residual_norm !== null
                            && $product->type !== 'не выбрано')
                            <div @if (round(($product->residual /$product->residual_norm ) * 100) <= 30) class="btn btn-danger" @elseif(round(($product->residual /$product->residual_norm ) * 100) > 30 && round(($product->residual /$product->residual_norm ) * 100) <= 70) class="btn btn-warning" @else class="btn btn-success" @endif>
                                        {{round(($product->residual /$product->residual_norm ) * 100)}}%
                            </div>
                            @else
                            {{null}}
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
@include('Dashboard.components.style')