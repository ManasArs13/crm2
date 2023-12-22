@extends('adminlte::page')

@if (isset($entity) && $entity!='')
@section('title', __('entity.'.$entity) . $processing->name)
@endif

@section('content_header')
<h1>
    @if (isset($entity) && $entity!='')
    {{ __('entity.'.$entity)}} {{ $processing->name}}
    @endif
</h1>
@stop

@section('content')

<div class="col-12 mb-5">

    <div class="card">
        <div class="card-header">
            <h5> от {{ $processing->moment}}</h5>
        </div>
        <div class="card-body">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>
                            {{__("column.id")}}
                        </th>
                        <th>
                            {{__("column.tech_chart")}}
                        </th>
                        <th>
                            {{__("column.quantity")}}
                        </th>
                        <th>
                            {{__("column.hours")}}
                        </th>
                        <th>
                            {{__("column.cycles")}}
                        </th>
                        <th>
                            {{__("column.defective")}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $processing->id}}
                        </td>
                        <td>
                            @if($processing->tech_chart)
                            {{ $processing->tech_chart->name}}
                            @else
                            {{ __('column.no')}}
                            @endif
                        </td>
                        <td>
                            {{ $processing->quantity}}
                        </td>
                        <td>
                            {{ $processing->hours}}
                        </td>
                        <td>
                            {{ $processing->cycles}}
                        </td>
                        <td>
                            {{ $processing->defective}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            {{__("column.description")}} :
                            @if($processing->description)
                            {{ $processing->description}}
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
                    @foreach($processing->products as $product)
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
                    @foreach($processing->materials as $product)
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