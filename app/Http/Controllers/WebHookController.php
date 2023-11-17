<?php

namespace App\Http\Controllers;


use App\Http\Requests\WebHookRequest;
use App\Models\ContactAmo;
use App\Models\Option;
use App\Services\Api\AmoService;
use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebHookController extends Controller
{
    public function handleWebHook(WebHookRequest $request, AmoService $amoService): void
    {
          if (!isset($request['contacts']['delete'])){
              Artisan::call('app:import-contacts-amo');
              Artisan::call('app:update-contacts-amo');
              Option::query()
                  ->where('code',AmoService::LAST_DATE_CODE)
                  ->update(['value'=>Carbon::now()->subHours( 2 )]);
          }else{
              $deleted =  $this->deleted($request['contacts']['delete'][0]['id']);
              $deleted && ContactAmo::query()->where('id',$request['contacts']['delete'][0]['id'])->delete();
          }
    }

    /**
     * @param $id
     * @return PromiseInterface|Response
     */
    public function deleted($id): PromiseInterface|Response
    {
        $token =  json_decode(file_get_contents(base_path('token_amocrm_widget.json')), true)['accessToken'];
      return Http::withHeaders([
          'Authorization' => 'Bearer ' . $token,
      ])->get('https://euroblock.amocrm.ru/api/v4/contacts/'.$id);

    }

}
