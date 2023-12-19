 @section('title', 'ПАНЕЛЬ - БЕТОН')
 @extends('adminlte::page')
 @section('content')
 <div class="row py-2">
     <div class="col-9">
         <div class="card">
             <div class="card-header d-flex align-items-center justify-content-between">
                 <div class="d-flex flex-grow-1">
                     <div class="card-tools mx-1">
                         @if(request()->filter == 'now' || request()->filter == null)
                         <a href="{{route('admin.dashboard-3',['filter'=>'now'])}}" class="btn btn-info">Сегодня</a>
                         @else
                         <a href="{{route('admin.dashboard-3',['filter'=>'now'])}}" class="btn btn-primary">Сегодня</a>
                         @endif
                     </div>
                     <div class="card-tools mx-1">
                         @if(request()->filter == 'tomorrow')
                         <a href="{{route('admin.dashboard-3',['filter'=>'tomorrow'])}}" class="btn btn-info">Завтра</a>
                         @else
                         <a href="{{route('admin.dashboard-3',['filter'=>'tomorrow'])}}" class="btn btn-primary">Завтра</a>
                         @endif
                     </div>
                     <div class="card-tools mx-1">
                         @if(request()->filter == 'three-day')
                         <a href="{{route('admin.dashboard-3',['filter'=>'three-day'])}}" class="btn btn-info">3 дня</a>
                         @else
                         <a href="{{route('admin.dashboard-3',['filter'=>'three-day'])}}" class="btn btn-primary">3 дня</a>
                         @endif
                     </div>
                     <div class="card-tools mx-1">
                         @if(request()->filter == 'week')
                         <a href="{{route('admin.dashboard-3',['filter'=>'week'])}}" class="btn btn-info">Неделя</a>
                         @else
                         <a href="{{route('admin.dashboard-3',['filter'=>'week'])}}" class="btn btn-primary">Неделя</a>
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
             @include('Dashboard.components.orderTable',['filter'=>'concrete'])
         </div>
     </div>
     <div class="col-3">
         <div class="card" style="overflow-x:auto ">
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
                 @if($concrete->residual_norm !== 0
                 && $concrete->residual_norm !== null
                 && $concrete->building_material !== 'не выбрано')
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