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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">

                <div class="d-flex flex-grow-1">
                    <div class="card-tools mx-2">
                        @if(url()->current() == route('residual.blocksMaterials'))
                        <a href="{{ route('residual.blocksMaterials') }}" class="btn btn-info">{{__("column.blocks_materials")}}</a>
                        @else
                        <a href="{{ route('residual.blocksMaterials') }}" class="btn btn-primary">{{__("column.blocks_materials")}}</a>
                        @endif
                    </div>
                    <div class="card-tools mx-2">
                        @if(url()->current() == route('residual.blocksCategories'))
                        <a href="{{ route('residual.blocksCategories') }}" class="btn btn-info">{{__("column.blocks_categories")}}</a>
                        @else
                        <a href="{{ route('residual.blocksCategories') }}" class="btn btn-primary">{{__("column.blocks_categories")}}</a>
                        @endif
                    </div>
                    <div class="card-tools mx-2">
                        @if(url()->current() == route('residual.blocksProducts'))
                        <a href="{{ route('residual.blocksProducts') }}" class="btn btn-info">{{__("column.blocks_products")}}</a>
                        @else
                        <a href="{{ route('residual.blocksProducts') }}" class="btn btn-primary">{{__("column.blocks_products")}}</a>
                        @endif
                    </div>
                    <div class="card-tools mx-2">
                        @if(url()->current() == route('residual.concretesMaterials'))
                        <a href="{{ route('residual.concretesMaterials') }}" class="btn btn-info">{{__("column.concretes_materials")}}</a>
                        @else
                        <a href="{{ route('residual.concretesMaterials') }}" class="btn btn-primary">{{__("column.concretes_materials")}}</a>
                        @endif
                    </div>
                </div>
                <div class="d-flex">
                    <div class="card-tools mx-2">
                        @if(url()->current() == route('residual'))
                        <a href="{{ route('residual') }}" class="btn btn-info">{{__("column.all")}}</a>
                        @else
                        <a href="{{ route('residual') }}" class="btn btn-primary">{{__("column.all")}}</a>
                        @endif
                    </div>
                </div>

            </div>



        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <th>
                            {{ $product->name}}
                        </th>
                        <th>
                            @if($product->residual_norm !== 0
                            && $product->residual_norm !== null)
                            
                            <div @if (round(($product->residual /$product->residual_norm ) * 100) <= 30)
                             class="bg-success" 
                             @elseif(round(($product->residual /$product->residual_norm ) * 100) > 30 && round(($product->residual /$product->residual_norm ) * 100) <= 70) 
                             class="bg-warning"
                             @else 
                             class="bg-success" 
                             @endif>
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
                            @if($product->min_balance_mc)
                            {{ $product->min_balance_mc }}
                            @else
                            {{ __("column.no") }}
                            @endif
                        </th>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="cont">

            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
</div>
@stop

@section('js')
@stop
<style>
    .cont nav div div {
        padding: 0 20px;
    }

    .cont nav div div p {
        font-weight: 500;
        color: black !important;
        font-size: 18px !important;
    }

    .pagination li {
        margin-right: 10px;
    }

    #submit {
        height: 38px;
        margin-left: 10px;
    }

    #status {
        width: auto;
        height: 40px;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>