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
                        {{__("column.name")}}
                    </th>
                    <th>
                        {{__("column.date_plan")}}
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
                    <th>
                        {{__("column.description")}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($supplies as $supply)
                <tr>
                    <td>
                        <a href="{{ route('supplies.show', ['supply' => $supply->id]) }}">
                            {{ $supply->id}}
                        </a>
                    </td>
                    <td>
                        {{ $supply->name}}
                    </td>
                    <td>
                        {{ $supply->moment}}
                    </td>
                    <td>
                        <a href="{{ route('contact_ms.show', ['contact_m' => $supply->contact_ms->id]) }}">
                            {{ $supply->contact_ms->name}}
                        </a>
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
                    <td>
                        {{ $supply->description}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cont m-3">
            {{ $supplies->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@stop

@section('js')
@stop
@include('Dashboard.components.style')