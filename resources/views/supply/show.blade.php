@extends('adminlte::page')

@if (isset($entity) && $entity!='')
@section('title', __('entity.'.$entity) . $supply->name)
@endif

@section('content_header')
<h1>
    @if (isset($entity) && $entity!='')
    {{ __('entity.'.$entity)}} {{ $supply->name}}
    @endif
</h1>
@stop

@section('content')

<div class="col-12 mb-5">

    <div class="card">
        <div class="card-header">
            <h5> от {{ $supply->moment}}</h5>
        </div>
        <div class="card-body">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>
                            {{__("column.id")}}
                        </th>
                        <th>
                            {{__("column.contact_ms_id")}}
                        </th>
                        <th>
                            {{__("column.sum")}}
                        </th>
                        <th>
                            {{__("column.incoming_number")}}
                        </th>
                        <th>
                            {{__("column.incoming_date")}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            {{ $supply->id}}
                        </td>
                        <td>
                            @if($supply->contact_ms)
                            <a href="{{ route('contact_ms.show', ['contact_m' => $supply->contact_ms->id]) }}">
                                {{ $supply->contact_ms->name}}
                            </a>
                            @else
                            {{ __('column.no')}}
                            @endif
                        </td>
                        <td>
                            {{ $supply->sum}}
                        </td>
                        <td>
                            {{ $supply->incoming_number}}
                        </td>
                        <td>
                            {{ $supply->incoming_date}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            {{__("column.description")}} :
                            @if($supply->description)
                            {{ $supply->description}}
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
                            {{__("column.quantity")}}
                        </th>
                        <th>
                            {{__("column.price")}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supply->products as $product)
                    <tr>
                        <td>
                            {{ $product->pivot->id}}
                        </td>
                        <td>
                            <a href="{{ route('products.show', ['product' => $product->id]) }}">
                                {{ $product->name}}
                            </a>
                        </td>
                        <td>
                            {{ $product->pivot->quantity}}
                        </td>
                        <td>
                            {{ $product->pivot->price}}
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