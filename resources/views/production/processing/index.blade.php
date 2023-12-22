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

    <div class="card-body px-0 py-2 wrapper mb-2" style="overflow-x: scroll;">
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
                    <th>
                        {{__("column.description")}}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($processings as $processing)
                <tr>
                    <th>
                        <a href="{{ route('processings.show', ['processing' => $processing->id]) }}">
                        {{ $processing->id}}
                        </a>
                    </th>
                    <th>
                        {{ $processing->name}}
                    </th>
                    <th>
                        {{ $processing->moment}}
                    </th>
                    <th>
                        @if($processing->tech_chart)
                        {{ $processing->tech_chart->name}}
                        @else
                        {{ __('column.no')}}
                        @endif
                    </th>
                    <th>
                        {{ $processing->quantity}}
                    </th>
                    <th>
                        {{ $processing->hours}}
                    </th>
                    <th>
                        {{ $processing->cycles}}
                    </th>
                    <th>
                        {{ $processing->defective}}
                    </th>
                    <th>
                        {{ $processing->description}}
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="cont m-3">
            {{ $processings->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@stop

@section('js')
@stop
@include('Dashboard.components.style')