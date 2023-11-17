@php use App\Models\SyncOrdersContacts\OrderMsOrderAmo; @endphp
@extends('adminlte::page')

@if (isset($entity)  && $entity!='')
    @section('title',  __('entity.'.$entity))
@endif
@section('content_header')
    <h1>
        Синхронизациа Заказов
    </h1>
@stop
@section('content')
    <div class="card-body table-responsive p-0" style="height:840px; overflow-y: scroll;">
        <table class="table table-head-fixed text-nowrap ">
            <thead>
            <tr>
                <th>Название мс</th>
                <th>№(мс)</th>
                <th>Название амо</th>
                <th>№(амо)</th>
                <th>Бюджет амо</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            @foreach ($orders as $order)
                <tbody>
                <tr>
                    <td class="project-actions text-left">
                        <div>
                            <span>{{$order->name}}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>{{  $order->id}}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>{{ $order->orderAmo?$order->orderAmo->name : ''}}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>{{  $order->orderAmo?$order->orderAmo->id:''}}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>{{$order->orderAmo?$order->orderAmo->price:""}}</span>
                        </div>
                    </td>
                    <td class="project-actions text-right">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </symbol>
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </symbol>
                        </svg>
                        @if($order->orderAmo)
                                @if( OrderMsOrderAmo::query()->where('order_ms_id',$order->id)->first()->is_manual)
                                <div class="alert alert-success d-flex align-items-center" role="alert">

                                    <svg class="bi flex-shrink-0 me-2" width="24" height="20" role="img"
                                         aria-label="Success:">
                                        <use xlink:href="#check-circle-fill"/>
                                    </svg>
                                    <div>
                                        <span>Ручной связь</span>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success d-flex align-items-center" role="alert">

                                    <svg class="bi flex-shrink-0 me-2" width="24" height="20" role="img"
                                         aria-label="Success:">
                                        <use xlink:href="#check-circle-fill"/>
                                    </svg>
                                    <div>
                                        <span>Связанный </span>
                                    </div>
                                </div>

                                @endif

                        @else
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="20" role="img"
                                     aria-label="Warning:">
                                    <use xlink:href="#exclamation-triangle-fill"/>
                                </svg>
                                <div>
                                    <span>Не Связаны</span>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center">
                            <a class="btn btn-info btn-sm " href="{{route($urlEdit,['id'=>$order->id])}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                                {{__("label.edit")}}
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            @endforeach
        </table>
        <div class="cont">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@stop
<style>
    #manual{
        width: 90px;
        margin-right:5px;
        /*padding-left: px;*/
    }
    .cont nav div div {
        padding: 0 20px;
    }

    .cont nav div div p {
        font-weight: 500;
        color: black !important;
        font-size: 18px !important;
    }

    .pagination li {
        margin-right: 10px;
    }
</style>
