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
                @if(url()->current() == route('residual.blocksMaterials'))
                <a href="{{ route('residual.blocksMaterials') }}" class="btn btn-info">{{__("column.blocks_materials")}}</a>
                @else
                <a href="{{ route('residual.blocksMaterials') }}" class="btn btn-primary">{{__("column.blocks_materials")}}</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('residual.blocksCategories'))
                <a href="{{ route('residual.blocksCategories') }}" class="btn btn-info">{{__("column.blocks_categories")}}</a>
                @else
                <a href="{{ route('residual.blocksCategories') }}" class="btn btn-primary">{{__("column.blocks_categories")}}</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('residual.blocksProducts'))
                <a href="{{ route('residual.blocksProducts') }}" class="btn btn-info">{{__("column.blocks_products")}}</a>
                @else
                <a href="{{ route('residual.blocksProducts') }}" class="btn btn-primary">{{__("column.blocks_products")}}</a>
                @endif
            </div>
            <div class="card-tools mx-1">
                @if(url()->current() == route('residual.concretesMaterials'))
                <a href="{{ route('residual.concretesMaterials') }}" class="btn btn-info">{{__("column.concretes_materials")}}</a>
                @else
                <a href="{{ route('residual.concretesMaterials') }}" class="btn btn-primary">{{__("column.concretes_materials")}}</a>
                @endif
            </div>
        </div>
        <div class="d-flex">
            <div class="card-tools mx-1">
                @if(url()->current() == route('residual'))
                <a href="{{ route('residual') }}" class="btn btn-info">{{__("column.all")}}</a>
                @else
                <a href="{{ route('residual') }}" class="btn btn-primary">{{__("column.all")}}</a>
                @endif
            </div>
        </div>

    </div>

    <div class="card-body px-0 py-2 wrapper">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>
                        {{__("column.name")}}
                    </th>
                    <th>
                        {{__("column.status_ms_id")}}
                    </th>
                    <th>
                        {{__("column.residual_norm")}}
                    </th>
                    <th>
                        {{__("column.residual")}}
                    </th>
                    <th>
                        {{__("column.need")}}
                    </th>
                    @if(url()->current() !== route('residual.concretesMaterials') && url()->current() !== route('residual.blocksMaterials'))
                    <th>
                        {{__("column.making_dais")}}
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                @if($product->residual_norm)
                <tr>
                    <th>
                        <a href="{{ route('products.show', ['product' => $product->id]) }}">
                            {{ $product->name}}
                        </a>
                    </th>
                    <th>
                        @if($product->residual_norm !== 0
                        && $product->residual_norm !== null)

                        <div @if (round(($product->residual /$product->residual_norm ) * 100) <= 30) class="td-percent-red" @elseif(round(($product->residual /$product->residual_norm ) * 100) > 30 && round(($product->residual /$product->residual_norm ) * 100) <= 70) class="td-percent-yellow" @else class="td-percent" @endif>
                                    {{round(($product->residual /$product->residual_norm ) * 100)}}%
                        </div>

                        @else
                        {{ __("column.no") }}
                        @endif
                    </th>
                    <th>
                        @if($product->residual_norm)
                        {{ $product->residual_norm }}
                        @else
                        {{ __("column.no") }}
                        @endif
                    </th>
                    <th>
                        @if($product->residual)
                        {{ $product->residual }}
                        @else
                        {{ __("column.no") }}
                        @endif
                    </th>
                    <th>
                        @if($product->residual && $product->residual_norm)
                        @if($product->residual - $product->residual_norm < 0) {{ abs($product->residual - $product->residual_norm) }} @else {{ 0 }} @endif @else {{ __("column.no") }} @endif </th>
                            @if(url()->current() !== route('residual.concretesMaterials') && url()->current() !== route('residual.blocksMaterials'))
                    <th>
                        @if($product->making_day)
                        {{ $product->making_day }}
                        @else
                        @if($product->residual && $product->residual_norm && $product->release)
                        @if($product->residual - $product->residual_norm >= 0)
                        {{ 0 }}
                        @else
                        {{ abs(round((($product->residual - $product->residual_norm ) / $product->release), 0)) }}
                        @endif
                        @else
                        {{ 0 }}
                        @endif
                        @endif
                    </th>
                    @endif
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
@stop
@include('Dashboard.components.style')