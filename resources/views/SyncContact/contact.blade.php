@extends('adminlte::page')

@if (isset($entity)  && $entity!='')
    @section('title',  __('entity.'.$entity))
@endif
 @php
      $linkMs = 'https://online.moysklad.ru/#company/edit?id=';
      $linkAmo = 'https://euroblock.amocrm.ru/contacts/detail/';
 @endphp
@section('content_header')
    <h1>
        Синхронизациа Контакты
    </h1>
@stop
@section('content')
    <div class="card-body table-responsive p-0" style="height:840px; overflow-y: scroll;">
        <table class="table table-head-fixed text-nowrap ">
            <thead>
            <tr>
                <th>Название мс</th>
                <th>{{__('column.contact_ms_link')}}</th>
                <th>№(мс)</th>
                <th>Название амо</th>
                <th>{{__('column.contact_amo_link')}}</th>
                <th>№(амо)</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            @foreach ($contacts as $contact)
                @if($contact->contactAmo !== null)
                    <tbody>
                <tr>
                    <td class="project-actions text-left">
                        <div>
                            <span>{{$contact->name}}</span>
                        </div>
                    </td>
                    <td>
                            <a href="{{$linkMs.$contact->id}}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-up-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z"></path>
                                    <path fill-rule="evenodd" d="M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z"></path>
                                </svg>
                            </a>
                    </td>
                    <td>
                        <div>
                            <span>{{  $contact->id}}</span>
                        </div>
                    </td>
                    <td>
                        <div>
                            <span>{{$contact->contactAmo->name}}</span>
                        </div>
                    </td>
                    <td >
                        <a href="{{$linkAmo.$contact->contactAmo->id}}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-up-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z"></path>
                                <path fill-rule="evenodd" d="M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z"></path>
                            </svg>
                        </a>
                    </td>
                    <td>
                        <div>
                            <span>{{$contact->contactAmo->id}}</span>
                        </div>
                    </td>
                </tr>
                </tbody>
                @endif
            @endforeach
        </table>
        <div class="cont">
            {{ $contacts->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@stop
<style>
    .cont nav div div{
        padding:  0 20px;
    }
    .cont nav div div p {
        font-weight: 500;
        color: black!important;
        font-size: 18px!important;
    }
    .pagination li {
        margin-right: 10px;
    }
</style>
