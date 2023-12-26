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
                @if(url()->current() == route('processings.index'))
                <a href="{{ route('processings.index') }}" class="btn btn-info">Общая таблица</a>
                @else
                <a href="{{ route('processings.index') }}" class="btn btn-primary">Общая таблица</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('processings.products'))
                <a href="{{ route('processings.products') }}" class="btn btn-info">Связь (продукты)</a>
                @else
                <a href="{{ route('processings.products') }}" class="btn btn-primary">Связь (продукты)</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('processings.materials'))
                <a href="{{ route('processings.materials') }}" class="btn btn-info">Связь (материалы)</a>
                @else
                <a href="{{ route('processings.materials') }}" class="btn btn-primary">Связь (материалы)</a>
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
                        {{__("column.processing")}}
                    </th>
                    <th>
                        {{__("column.product_id")}}
                    </th>
                    <th>
                        {{__("column.quantity")}}
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
                @foreach($processing_products as $product)
                <tr>
                    <th>
                        {{ $product->id}}
                    </th>
                    <th>
                        <a href="{{ route('processings.show', ['processing' => $product->processing_id]) }}">
                            {{ $product->processing_id}}
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('products.show', ['product' => $product->product_id]) }}">
                            {{ $product->product_id}}
                        </a>
                    </th>
                    <th>
                        {{ $product->quantity}}
                    </th>
                    <th>
                        {{ $product->created_at}}
                    </th>
                    <th>
                        {{ $product->updated_at}}
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cont m-3">
            {{ $processing_products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@stop

@section('js')
@stop
@include('Dashboard.components.style')