@extends('adminlte::page')

@if (isset($entity) && $entity != '')
    @section('title', __('entity.' . $entity))
@endif

@section('content_header')
    <h1>
        @if (isset($entity) && $entity != '')
            {{ __('entity.' . $entity) }}
        @endif
    </h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between ">
                    <form method="get" action="{{ route($urlFilter) }}">
                        @csrf
                        <div class="d-flex justify-content-between gap-1" style="margin-top: 8px">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    колонки
                                </button>
                                <div class="dropdown-menu dropend" aria-labelledby="dropdownMenuButton">
                                    <div class="container-fluid">
                                        <div class="row row-cols-3">
                                            <div class="col" style="width: 60rem">
                                                <label class="dropdown-item ">
                                                    <input type="checkbox" id="change_all">
                                                    Выбрать все
                                                </label>
                                            </div>
                                            @foreach ($resColumnsAll as $key => $column)
                                                <div class="col" style="width: 60rem">
                                                    <label class="dropdown-item ">
                                                        <input name="columns[]" class="columns_all" type="checkbox"
                                                            value="{{ $key }}">
                                                        {{ $column }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown mx-1">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    фильтр
                                </button>
                                <div class="dropdown-menu dropend" style="width: 60rem"
                                    aria-labelledby="dropdownMenuButton1">
                                    <div class="container-fluid">                               
                                            @foreach ($filters as $filter)
                                                <div class="row row-cols-3">
                                                    <div class="col">
                                                        <label class="dropdown-item ">
                                                            {{ $filter['name_rus'] }}
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <span class="input-group-text" style="border-top-right-radius: 0;border-bottom-right-radius: 0;">от</span>
                                                            <input name="filters[{{ $filter['name']}}][min]" type="{{ $filter['type'] }}" min="{{ $filter['min'] }}"
                                                                max="{{ $filter['max'] }}" value="{{ $filter['min'] }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group">
                                                            <span class="input-group-text" style="border-top-right-radius: 0;border-bottom-right-radius: 0;">до</span>
                                                            <input name="filters[{{ $filter['name']}}][max]" type="{{ $filter['type'] }}" min="{{ $filter['min'] }}"
                                                                max="{{ $filter['max'] }}" value="{{ $filter['max'] }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button class="btn btn-success w-100" type="submit">
                                    поиск
                                </button>
                            </div>

                        </div>
                    </form>
                    @if (isset($urlCreate) && $urlCreate != '')
                        <div class="card-tools w-75 justify-content-end d-flex">
                            <a href="{{ route($urlCreate) }}" class="btn btn-primary">{{ __('label.create') }}</a>
                        </div>
                    @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height:820px; overflow-y: scroll;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                @foreach ($resColumns as $key => $column)
                                    @if ($key === 'remainder')
                                        <th>{{ $column }}</th>
                                    @elseif(isset($orderBy) && $orderBy == 'desc')
                                        <th class="th"><a
                                                href="{{ route($urlFilter, ['column' => $key, 'orderBy' => 'desc', 'resColumns' => $resColumns, 'type' => request()->type ?? null]) }}"
                                                style="color: black">{{ $column }}</a>
                                            @if (isset($selectColumn) && $selectColumn == $key && $orderBy == 'desc')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                                </svg>
                                            @endif
                                        </th>
                                    @else
                                        <th class="th"><a
                                                href="{{ route($urlFilter, ['column' => $key, 'orderBy' => 'asc', 'resColumns' => $resColumns, 'type' => request()->type ?? null]) }}"
                                                style="color: black">{{ $column }}</a>
                                            @if (isset($selectColumn) && $selectColumn == $key && $orderBy == 'asc')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                                </svg>
                                            @endif
                                        </th>
                                    @endif
                                @endforeach
                                @if (isset($needMenuForItem) && $needMenuForItem)
                                    <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entityItems as $entityItem)
                                <tr>
                                    @foreach ($resColumns as $column => $title)
                                        <td>
                                            @if (preg_match('/_id\z/u', $column))
                                                @php
                                                    $column = substr($column, 0, -3);
                                                @endphp
                                                @if ($column == 'status_ms')
                                                    @switch($entityItem->$column->name)
                                                        @case('[DN] Подтвержден')
                                                            <div id="status"
                                                                style="border:solid #3ce0af;background-color: #b5f8e3">
                                                                <span>{{ $entityItem->$column->name }}</span>
                                                            </div>
                                                        @break

                                                        @case('На брони')
                                                            <div id="status"
                                                                style="border:solid #5b35a0;background-color: #ae96e3">
                                                                <span>{{ $entityItem->$column->name }}</span>
                                                            </div>
                                                        @break

                                                        @case('[C] Отменен')
                                                            <div id="status"
                                                                style="border:solid red;background-color: #f3a3a3">
                                                                <span>{{ $entityItem->$column->name }}</span>
                                                            </div>
                                                        @break

                                                        @case('Думают')
                                                            <div id="status"
                                                                style="border:solid blue;background-color: #6f6ffd">
                                                                <span>{{ $entityItem->$column->name }}</span>
                                                            </div>
                                                        @break

                                                        @case('[DD] Отгружен с долгом')
                                                            <div id="status"
                                                                style="border:solid orange;background-color: #e5bf7e">
                                                                <span>{{ $entityItem->$column->name }}</span>
                                                            </div>
                                                        @break

                                                        @case('[DF] Отгружен и закрыт')
                                                            <div id="status"
                                                                style="border:solid green;background-color: #55c455">
                                                                <span>{{ $entityItem->$column->name }}</span>
                                                            </div>
                                                        @break

                                                        @case('[N] Новый')
                                                            <div id="status"
                                                                style="border:solid yellow;background-color: #f5f590">
                                                                <span>{{ $entityItem->$column->name }}</span>
                                                            </div>
                                                        @break

                                                        @default
                                                            {{ $entityItem->$column->name }}
                                                    @endswitch
                                                @elseif($entityItem->$column != null)
                                                    {{ $entityItem->$column->name }}
                                                @endif
                                            @elseif($column == 'remainder')
                                                @if ($entityItem->residual_norm !== 0 && $entityItem->residual_norm !== null && $entityItem->type !== 'не выбрано')
                                                    {{ round(($entityItem->residual / $entityItem->residual_norm) * 100) }}
                                                    %
                                                @else
                                                    {{ null }}
                                                @endif
                                            @elseif(preg_match('/_link/u', $column) && $entityItem->$column !== null && $entityItem->$column !== '')
                                                <a href="{{ $entityItem->$column }}" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-box-arrow-in-up-right"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z">
                                                        </path>
                                                        <path fill-rule="evenodd"
                                                            d="M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @else
                                                {{ $entityItem->$column }}
                                            @endif
                                        </td>
                                    @endforeach

                                    @if (isset($needMenuForItem) && $needMenuForItem)
                                        <td class="project-actions text-right">
                                            @if (isset($urlShow) && $urlShow != '')
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route($urlShow, $entityItem->id) }}">
                                                    <i class="fas fa-folder">
                                                    </i>
                                                    {{ __('label.view') }}
                                                </a>
                                            @endif
                                            @if (isset($urlEdit) && $urlEdit != '')
                                                <a class="btn btn-info btn-sm"
                                                    href="{{ route($urlEdit, $entityItem->id) }}">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    {{ __('label.edit') }}
                                                </a>
                                            @endif
                                            @if (isset($urlDelete) && $urlDelete != '')
                                                <form action="{{ route($urlDelete, $entityItem->id) }}" method="Post"
                                                    style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        href="{{ route($urlDelete, $entityItem->id) }}">
                                                        <i class="fas fa-trash"></i>
                                                        {{ __('label.delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="cont">
                        {{ $entityItems->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <script>
        let elements = document.querySelectorAll('.dropdown-item')
        elements.forEach((item) => {
            item.addEventListener('click', (e) => {
                e.stopPropagation()
            })
        })

        document.addEventListener("DOMContentLoaded", function(event) {
            var checkboxAll = document.querySelector("#change_all");
            checkboxAll.addEventListener('change', function() {
                let inputs = document.querySelectorAll(".columns_all")

                if (this.checked) {
                    inputs.forEach(element => {
                        element.checked = true
                    });
                } else {
                    inputs.forEach(element => {
                        element.checked = false
                    });
                }
            });

        });
    </script>
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
