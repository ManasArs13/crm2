@section('title', 'Дашборд Блок')
@extends('adminlte::page')
@section('content')
    <div class="wrapper d-flex justify-content-between">
        <div id="card2" class="card w-75 bg-gray-light mr-3">
            <div class="button-block">
                <div class="buttons">
                    <div class="card-tools w-75 justify-content-end d-flex">
                        <label style="display: block;">
                            <input type="date" id="datepicker" value="{{ \Illuminate\Support\Carbon::now()->format('Y-m-d') }}">
                        </label>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex" >
                        <a href="{{route('admin.dashboard-2',['filter'=>'now'])}}" id="buttons" class="btn" @if(request()->filter == 'now') style="border: solid 2px #676666" @endif>СЕГОДНЯ</a>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-2',['filter'=>'tomorrow'])}}" id="buttons" class="btn" @if(request()->filter == 'tomorrow') style="border: solid 2px #676666" @endif>ЗАВТРА</a>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-2',['filter'=>'three-day'])}}" id="buttons" class="btn" @if(request()->filter == 'three-day') style="border: solid 2px #676666" @endif>3 ДНЯ</a>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-2',['filter'=>'week'])}}" id="buttons" class="btn" @if(request()->filter == 'week') style="border: solid 2px #676666" @endif>НЕДЕЛЯ</a>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-2',['filter'=>'map'])}}" id="buttons" class="btn" @if(request()->filter == 'map') style="border: solid 2px #676666" @endif>КАРТА</a>
                    </div>
                </div>
            </div>
            @if(request()->filter == 'map')
                @include('Dashboard.components.map')
            @else
                @include('Dashboard.components.canvas')
            @endif
            @include('Dashboard.components.load')
            @include('Dashboard.components.orderTable',['filter'=>'block'])
        </div>
        <div id="card3" class="card w-25 bg-gray-light">
            <div  class="card" style="overflow-x:auto ">
                <table cellpadding="5px">
                    <thead>
                    <tr>
                        <th class="d-flex justify-content-center align-items-center mb-2 ">
                            <span style="font-size: 25px;color: #949494">МАТЕРИАЛЫ БЛОКИ</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($blocksMaterials as $blocksMaterial)
                                    @if($blocksMaterial->residual_norm  !== 0
                                    && $blocksMaterial->residual_norm  !== null
                                    && $blocksMaterial->building_material !== 'не выбрано')
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td class="m-1 d-flex justify-content-between">
                                {{$blocksMaterial->name}}
                            </td>
                            <td>
                                <span>
                                        <div 
                                        @if (round(($blocksMaterial->residual /$blocksMaterial->residual_norm ) * 100) <= 30)
                                        class="td-percent-red"
                                        @elseif(round(($blocksMaterial->residual /$blocksMaterial->residual_norm ) * 100) > 30 && round(($blocksMaterial->residual /$blocksMaterial->residual_norm ) * 100) <= 70)
                                        class="td-percent-yellow"
                                        @else
                                        class="td-percent"
                                        @endif>
                                           {{round(($blocksMaterial->residual /$blocksMaterial->residual_norm ) * 100)}}%
                                        </div>

                                </span>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div  class="card" style="overflow-x: auto">
                <table cellpadding="5px" >
                    <thead style=" display:block">
                    <tr>
                        <th class="d-flex justify-content-center align-items-center mb-2">
                            <span style="font-size: 25px;color: #949494;margin-left: 40px">КАТЕГОРИИ БЛОКИ</span>
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
                            <span style="font-size: 25px;color: #949494">ТОВАРЫ БЛОКИ</span>
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

