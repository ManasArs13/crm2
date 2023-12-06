 @section('title', 'Дашборд Бетон')
@extends('adminlte::page')
@section('content')
    <div class="wrapper d-flex justify-content-between">
        <div id="card2" class="card w-75 bg-gray-light">
            <div class="button-block">
                <div class="buttons">
                    <div class="card-tools w-75 justify-content-end d-flex">
                        <label style="display: block;">
                            <input type="date" id="datepicker" value="{{ \Illuminate\Support\Carbon::now()->format('Y-m-d') }}">
                        </label>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-3',['filter'=>'now'])}}" id="buttons" class="btn" @if(request()->filter == 'now') style="border: solid 2px #676666" @endif>СЕГОДНЯ</a>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-3',['filter'=>'tomorrow'])}}" id="buttons" class="btn" @if(request()->filter == 'tomorrow') style="border: solid 2px #676666" @endif>ЗАВТРА</a>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-3',['filter'=>'three-day'])}}" id="buttons" class="btn" @if(request()->filter == 'three-day') style="border: solid 2px #676666" @endif>3 ДНЯ</a>
                    </div>
                    <div  class="card-tools w-100 h-75 justify-content-end d-flex">
                        <a href="{{route('admin.dashboard-3',['filter'=>'week'])}}" id="buttons" class="btn" @if(request()->filter == 'week') style="border: solid 2px #676666" @endif>НЕДЕЛЯ</a>
                    </div>
                </div>
            </div>
            @include('Dashboard.components.canvas')
            @include('Dashboard.components.load')
            @include('Dashboard.components.orderTable',['filter'=>'concrete'])
        </div>
        <div id="card3" class="card w-25 bg-gray-light">
            <div  class="card" style="overflow-x:auto">
                <table cellpadding="5px">
                    <thead>
                    <tr>
                        <th class="d-flex justify-content-center align-items-center mb-2 ">
                            <span style="font-size: 25px;color: #949494">БЕТОН</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($concretes as $concrete)
                        @if($concrete->residual_norm  !== 0
                                    && $concrete->residual_norm  !== null
                                    && $concrete->building_material !== 'невыбрено')
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td class="m-1 d-flex justify-content-between">
                                {{$concrete->name}}
                            </td>
                            <td>
                                <span>   
                                        <div class="td-percent">
                                           {{round(($concrete->residual /$concrete->residual_norm ) * 100)}}%
                                        </div>
                                </span>
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

