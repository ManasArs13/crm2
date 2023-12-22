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
                    <th>
                    <a href="{{ route('techcharts.show', ['techchart' => $techchart->id]) }}">
                        {{ $techchart->id}}
                    </a>
                    </th>
                    <th>
                        {{ $techchart->name}}
                    </th>
                    <th>
                        {{ $techchart->cost}}
                    </th> 
                    <th>
                        {{ $techchart->description}}
                    </th>
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