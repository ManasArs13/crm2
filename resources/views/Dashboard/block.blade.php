@section('title', 'ПАНЕЛЬ - БЛОК')
@extends('adminlte::page')
@section('content')
<div class="row py-2">
    <div class="col-9">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex flex-grow-1">
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'now' || request()->filter == null)
                        <a href="{{route('admin.dashboard-2',['filter'=>'now'])}}" class="btn btn-info">Сегодня</a>
                        @else
                        <a href="{{route('admin.dashboard-2',['filter'=>'now'])}}" class="btn btn-primary">Сегодня</a>
                        @endif
                    </div>
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'tomorrow')
                        <a href="{{route('admin.dashboard-2',['filter'=>'tomorrow'])}}" class="btn btn-info">Завтра</a>
                        @else
                        <a href="{{route('admin.dashboard-2',['filter'=>'tomorrow'])}}" class="btn btn-primary">Завтра</a>
                        @endif
                    </div>
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'three-day')
                        <a href="{{route('admin.dashboard-2',['filter'=>'three-day'])}}" class="btn btn-info">3 дня</a>
                        @else
                        <a href="{{route('admin.dashboard-2',['filter'=>'three-day'])}}" class="btn btn-primary">3 дня</a>
                        @endif
                    </div>
                    <div class="card-tools mx-1">
                        @if(request()->filter == 'week')
                        <a href="{{route('admin.dashboard-2',['filter'=>'week'])}}" class="btn btn-info">Неделя</a>
                        @else
                        <a href="{{route('admin.dashboard-2',['filter'=>'week'])}}" class="btn btn-primary">Неделя</a>
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
            @include('Dashboard.components.orderTable',['filter'=>'block'])
        </div>
    </div>
    <div class="col-3">
        <div class="card" style="overflow-x:auto ">
            <table cellpadding="5px">
                <thead>
                    <tr>
                        <th class="d-flex justify-content-center align-items-center mb-2 ">
                            <span style="font-size: 25px;color: #949494">Материалы (БЛОК)</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blocksMaterials as $blocksMaterial)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td class="m-1 d-flex justify-content-between">
                            {{$blocksMaterial->name}}
                        </td>
                        <td>
                            @if($blocksMaterial->residual_norm !== 0
                            && $blocksMaterial->residual_norm !== null
                            && $blocksMaterial->type !== 'не выбрано')
                            <div @if (round(($material->residual /$blocksMaterial->residual_norm ) * 100) <= 30) class="td-percent-red" @elseif(round(($blocksMaterial->residual /$blocksMaterial->residual_norm ) * 100) > 30 && round(($blocksMaterial->residual /$blocksMaterial->residual_norm ) * 100) <= 70) class="td-percent-yellow" @else class="td-percent" @endif>
                                        {{round(($blocksMaterial->residual /$blocksMaterial->residual_norm ) * 100)}}%
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
                            <span style="font-size: 25px;color: #949494">Категории (БЛОК)</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        @if(isset($category->remainder))
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td class="m-1 d-flex justify-content-between">
                                {{$category->name}}
                            </td>
                            <td>                   
                                    <div @if (round($category->remainder) <= 30)
                                        class="td-percent-red"
                                        @elseif(round($category->remainder) > 30 && round($category->remainder) <= 70)
                                        class="td-percent-yellow"
                                        @else
                                        class="td-percent"
                                        @endif>
                                        {{round($category->remainder)}}%
                                    </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
            </table>
        </div>
        <div  class="card" style="overflow-x: auto ">
                <table cellpadding="5px">
                    <thead>
                    <tr>
                        <th class="d-flex justify-content-center align-items-center mb-2">
                            <span style="font-size: 25px;color: #949494">Товары (БЛОК)</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blocksProducts as $blocksProduct)
                        @if($blocksProduct->residual_norm  !== 0
                                    && $blocksProduct->residual_norm  !== null
                                    && $blocksProduct->building_material !== 'не выбрано')
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td class="m-1 d-flex justify-content-between">
                                {{$blocksProduct->name}}
                            </td>
                            <td>
                                     <div 
                                     @if (round(($blocksProduct->residual /$blocksProduct->residual_norm ) * 100) <= 30)
                                        class="td-percent-red"
                                        @elseif(round(($blocksProduct->residual /$blocksProduct->residual_norm ) * 100) > 30 && round(($blocksProduct->residual /$blocksProduct->residual_norm ) * 100) <= 70)
                                        class="td-percent-yellow"
                                        @else
                                        class="td-percent"
                                        @endif>
                                        {{round(($blocksProduct->residual /$blocksProduct->residual_norm ) * 100)}}%
                                    </div>
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

