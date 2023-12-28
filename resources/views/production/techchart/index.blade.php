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
                @if(url()->current() == route('techcharts.index'))
                <a href="{{ route('techcharts.index') }}" class="btn btn-info">Общая таблица</a>
                @else
                <a href="{{ route('techcharts.index') }}" class="btn btn-primary">Общая таблица</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('techcharts.products'))
                <a href="{{ route('techcharts.products') }}" class="btn btn-info">Связь (продукты)</a>
                @else
                <a href="{{ route('techcharts.products') }}" class="btn btn-primary">Связь (продукты)</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('techcharts.materials'))
                <a href="{{ route('techcharts.materials') }}" class="btn btn-info">Связь (материалы)</a>
                @else
                <a href="{{ route('techcharts.materials') }}" class="btn btn-primary">Связь (материалы)</a>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body px-0 pb-2 pt-0 wrapper mb-2" style="overflow-x: scroll;">
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
                        {{__("column.price")}}
                    </th>
                    <th>
                        {{__("column.description")}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($techcharts as $techchart)
                <tr>
                    <td>
                        <a href="{{ route('techcharts.show', ['techchart' => $techchart->id]) }}">
                            {{ $techchart->id}}
                        </a>
                    </td>
                    <td>
                        {{ $techchart->name}}
                    </td>
                    <td>
                        {{ $techchart->cost}}
                    </td>
                    <td>
                        {{ $techchart->description}}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@stop

@section('js')
@stop
@include('Dashboard.components.style')