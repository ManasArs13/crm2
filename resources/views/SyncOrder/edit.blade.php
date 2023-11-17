@extends('adminlte::page')

@if (isset($entity)  && $entity!='')
    @section('title',  __('entity.'.$entity))
@endif
@section('content_header')
    <h1>
        Синхронизациа Заказов
    </h1>
@stop
@php
    $urlMs = 'https://online.moysklad.ru/app/#customerorder/edit?id=';
    $urlAmo = 'https://euroblock.amocrm.ru/leads/detail/';
    @endphp
@section('content')
@if($orderAmo)
    <div class="card-body table-responsive p-0" style="overflow-y: scroll;">
        <div>
            @php
                $columnNames = [
                    'id'=>__('column.id'),
                    'status_ms_id' => __('column.status_ms_id'),
                    'name' => __('column.name'),
                    'contact_ms_id' => __('column.contact_ms_id'),
                    'status_shipped' => __('column.status_shipped'),
                    'order_amo_link' => __('column.order_amo_link'),
                    'sum' => __('column.sum'),
                    'payed_sum' => __('column.payed_sum')
                ];
            @endphp
            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    @foreach ($columnNames as $columnName)
                        <th>{{ $columnName }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><span>{{ $orderMs->id }}</span></td>
                    <td><span>{{ $orderMs->status_ms->name }}</span></td>
                    <td><span>{{ $orderMs->name }}</span></td>
                    <td><span>{{ $orderMs->contact_ms_id }}</span></td>
                    <td><span>{{ $orderMs->status_shipped }}</span></td>
                    <td>
                            <a href="{{$urlAmo.$orderAmo->id}}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-up-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z"></path>
                                    <path fill-rule="evenodd" d="M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z"></path>
                                </svg>
                            </a>
                    </td>
                    <td><span>{{ $orderMs->sum }}</span></td>
                    <td><span>{{ $orderMs->payed_sum }}</span></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            @php
                $columnNames = [
                    'id'=>__('column.id'),
                    'status_amo_id' => __('column.status_amo_id'),
                     'name' => __('column.name'),
                    'order_link_ms' => __('column.order_link_ms'),
                    'contact_amo_id' => __('column.contact_amo_id'),
                    'status_shipped' => __('column.status_shipped'),
                    'price' => __('column.price')
                ];
            @endphp

            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    @foreach ($columnNames as $columnName)
                        <th>{{ $columnName }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><span>{{ $orderAmo->id }}</span></td>
                    <td><span>{{ $orderAmo->status_amo->name}}</span></td>
                    <td><span>{{ $orderAmo->name }}</span></td>
                    <td>
                            <a href="{{$urlMs.$orderMs->id}}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-up-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z"></path>
                                    <path fill-rule="evenodd" d="M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z"></path>
                                </svg>
                            </a>
                    </td>
                    <td><span>{{ $orderAmo->contact_amo_id }}</span></td>
                    <td><span>{{ $orderAmo->status_shipped }}</span></td>
                    <td><span>{{ $orderAmo->price }}</span></td>
                </tr>
                </tbody>
            </table>
        </div>
        <form method="post" action="{{route($urlSync ,['order_ms_id'=>$orderMs->id])}}">
            @csrf
          <div class="d-flex justify-content-start align-items-center">
              <div class="d-flex justify-content-between">
                  <button type="submit" class="btn btn-danger" value="notSync" name="notSync">{{__("label.notSync")}}</button>
              </div>
              <div class=" btn btn-secondary" style="margin-left: 5px">
                  <a href="{{route('sync')}}" style="color: white">{{__('label.back')}}</a>
              </div>
          </div>
        </form>

    </div>
@else
    <div class="card-body table-responsive p-0 fa-directions columns-4" style="overflow-y: scroll;">
        <div>
            @php
                $columnNames = [
                    'id'=>__('column.id'),
                    'name' => __('column.name'),
                    'status_ms_id' => __('column.status_ms_id'),
                    'contact_ms_id' => __('column.contact_ms_id'),
                    'status_shipped' => __('column.status_shipped'),
                    'sum' => __('column.sum'),
                    'payed_sum' => __('column.payed_sum')
                ];
            @endphp

            <table class="table table-head-fixed text-nowrap">
                <thead>
                <tr>
                    @foreach ($columnNames as $columnName)
                        <th>{{ $columnName }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><span>{{ $orderMs->id }}</span></td>
                    <td><span>{{ $orderMs->name }}</span></td>
                    <td><span>{{ $orderMs->status_ms_id }}</span></td>
                    <td><span>{{ $orderMs->contact_ms_id }}</span></td>
                    <td><span>{{ $orderMs->status_shipped }}</span></td>
                    <td><span>{{ $orderMs->sum }}</span></td>
                    <td><span>{{ $orderMs->payed_sum }}</span></td>
                </tr>
                </tbody>
            </table>
        </div>
        @if(isset($suggestions[0]))
            {{--            @dd($suggestions[0])--}}
            <div  class="mt-4">

                @php
                    $columnNames = [
                        'id'=>__('column.id'),
                        'name' => __('column.name'),
                        'status_amo_id' => __('column.status_amo_id'),
                         'contact_amo_id' => __('column.contact_amo_id'),
                        'price' => __('column.price')
                    ];
                @endphp
                <form method="post" action="{{route($urlSync ,['order_ms_id'=>$orderMs->id])}}">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                    <tr>
                        @foreach ($columnNames as $columnName)
                            <th>{{ $columnName }}</th>
                        @endforeach
                    </tr>
                    </thead>
                        @csrf
                        @foreach($suggestions as $suggestion)
                            <tbody>
                            <tr>
                                <td>
                                    <label>
                                        <input class="check" type="checkbox" value="{{$suggestion->id}}" name="id" style="margin-right: 10px">
                                    </label>
                                    <script>
                                        let checkbox = document.querySelector('.check');
                                        checkbox.addEventListener('click',(e)=>{
                                            if (e.target.checked){
                                                cont.style.display = 'none'
                                            }
                                            if(!e.target.checked){
                                                cont.style.display = 'block'
                                            }
                                        })
                                    </script>
                                    <span>{{ $suggestion->id }}</span></td>
                                <td><span>{{ $suggestion->name }}</span></td>
                                <td><span>{{ $suggestion->status_amo_id }}</span></td>
                                <td><span>{{ $suggestion->contact_amo_id }}</span></td>
                                <td><span>{{ $suggestion->price }}</span></td>
                            </tr>
                            </tbody>
                        @endforeach

                </table>
                    <button type="submit" class="btn btn-primary" value="sync" name="sync">{{__("label.sync")}}</button>
                </form>
            </div>
        @endif
        <div id="btn" class="btn btn-secondary" style="width: 122px">
            <a href="{{back()->getTargetUrl()}}" style="color: white">{{__('label.back')}}</a>
        </div>
        <div id="cont">
            <form method="post" action="{{route($urlSync ,['order_ms_id'=>$orderMs->id])}}" class="form" style="padding: 0; margin-top: 12px">
                @csrf
                <label>
                    <input type="text" name="id" placeholder="связывать по айдишнику" class="form-control" required>
                </label>
                <button type="submit" class="btn btn-primary" value="sync" name="sync">{{__("label.sync")}}</button>
            </form>
        </div>
    </div>
<script>
    let cont = document.getElementById('cont')
</script>
@endif
@stop
<style>
    .form{
        padding-left: 20px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 10px;
    }
    .form button {
        margin-bottom: 0.5rem;
        background-color: #1c7430;
    }
    .form button:hover {
        background-color: #0b2e13;
    }

</style>

