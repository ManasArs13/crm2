@extends('adminlte::page')

@if (isset($entity) && $entity!='')
@section('title', __('entity.'.$entity))
@endif

@section('content_header')
<h1>
    @if (isset($entity) && $entity!='')
    {{ __('entity.'.$entity)}}
    @endif
</h1>
@stop

@section('content')
<div class="card">

    <div class="card-header d-flex align-items-center justify-content-between">

        <div class="d-flex flex-grow-1">
            <div class="card-tools mx-1">
                @if(url()->current() == route('supplies.index'))
                <a href="{{ route('supplies.index') }}" class="btn btn-info">Общая таблица</a>
                @else
                <a href="{{ route('supplies.index') }}" class="btn btn-primary">Общая таблица</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('supplies.products'))
                <a href="{{ route('supplies.products') }}" class="btn btn-info">Связь (продукты)</a>
                @else
                <a href="{{ route('supplies.products') }}" class="btn btn-primary">Связь (продукты)</a>
                @endif
            </div>
        </div>

    </div>

    <div class="card-body px-0 pt-0 pb-2 wrapper mb-2" style="overflow-x: scroll;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>
                        {{__("column.id")}}
                    </th>
                    <th>
                        {{__("column.supply")}}
                    </th>
                    <th>
                        {{__("column.product_id")}}
                    </th>
                    <th>
                        {{__("column.quantity")}}
                    </th>
                    <th>
                        {{__("column.price")}}
                    </th>
                    <th>
                        {{__("column.created_at")}}
                    </th>
                    <th>
                        {{__("column.updated_at")}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($supply_products as $product)
                <tr>
                    <td>
                        {{ $product->id}}
                    </td>
                    <td>
                        @if($product->supply)
                        <a href="{{ route('supplies.show', ['supply' => $product->supply_id]) }}">
                            {{ $product->supply->name}}
                        </a>
                        @else
                        {{ __('column.no')}}
                        @endif
                    </td>
                    <td>
                        @if($product->products)
                        <a href="{{ route('products.show', ['product' => $product->product_id]) }}">
                            {{ $product->products->name}}
                        </a>
                        @else
                        {{ __('column.no')}}
                        @endif
                    </td>
                    <td>
                        {{ $product->quantity}}
                    </td>
                    <td>
                        {{ $product->price}}
                    </td>
                    <td>
                        {{ $product->created_at}}
                    </td>
                    <td>
                        {{ $product->updated_at}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cont m-3">
            {{ $supply_products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@stop

@section('js')
@stop
@include('Dashboard.components.style')