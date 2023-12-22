@extends('adminlte::page')

@if (isset($entity) && $entity!='')
@section('title', __('entity.'.$entity) . $tech_chart->name)
@endif

@section('content_header')
<h1>
    @if (isset($entity) && $entity!='')
    {{ __('entity.'.$entity)}} {{ $tech_chart->name}}
    @endif
</h1>
@stop

@section('content')

<div class="col-12 mb-5">

    <div class="card">
        <div class="card-header">
            <h5> обнавлено: {{ $tech_chart->updated_at}}</h5>
        </div>
        <div class="card-body">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>
                            {{__("column.id")}}
                        </th>
                        <th>
                            {{__("column.name")}}
                        </th>
                        <th>
                            {{__("column.price")}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>
                            {{ $tech_chart->id}}
                        </th>
                        <th>
                            {{ $tech_chart->name}}
                        </th>
                        <th>
                            {{ $tech_chart->cost}}
                        </th>
                    </tr>
                    <tr>
                        <td colspan="6">
                            {{__("column.description")}} :
                            @if($tech_chart->description)
                            {{ $tech_chart->description}}
                            @else
                            {{ __('column.no')}}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="card">
        <div class="card-header">
            <h5>
                {{ __('column.productions')}}
            </h5>
        </div>
        <div class="card-body">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>
                            {{__("column.id")}}
                        </th>
                        <th>
                            {{ __("column.product_id")}}
                        </th>
                        <th>
                            {{__("column.name")}}
                        </th>
                        <th>
                            {{__("column.quantity")}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tech_chart->products as $product)
                    <tr>
                        <td>
                            {{ $product->pivot->id}}
                        </td>
                        <td>
                            <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                {{ $product->id}}
                            </a>
                        </td>
                        <td>
                            {{ $product->name}}
                        </td>
                        <td>
                            {{ $product->pivot->quantity}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>
                {{ __('column.materials')}}
            </h5>
        </div>
        <div class="card-body">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>
                            {{__("column.id")}}
                        </th>
                        <th>
                            {{ __("column.product_id")}}
                        </th>
                        <th>
                            {{__("column.name")}}
                        </th>
                        <th>
                            {{__("column.quantity")}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tech_chart->materials as $product)
                    <tr>
                        <td>
                            {{ $product->pivot->id}}
                        </td>
                        <td>
                            <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                {{ $product->id}}
                            </a>
                        </td>
                        <td>
                            {{ $product->name}}
                        </td>
                        <td>
                            {{ $product->pivot->quantity}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
@stop
@include('Dashboard.components.style')