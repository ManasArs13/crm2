<?php

namespace App\Console\Commands;

use App\Models\ContactAmo;
use App\Models\ContactMs;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SyncContactMsAmo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-contact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $contactAmos = ContactAmo::get();

        foreach ($contactAmos as $contactAmo) {

            $contactMS = ContactMs::where('phone_norm', $contactAmo->phone_norm)->first();

            if ($contactMS) {

                $accessToken = json_decode(file_get_contents(base_path('token_amocrm_widget.json')), true)['accessToken'];

                $customFieldUpdate = [
                    "field_id" => 604475,
                    "field_name" => "Cсылка на контрагента в моем складе",
                    "field_code" => null,
                    "field_type" => "url",
                    "values" => [
                        [
                            "value" => "https://api.moysklad.ru/#company/edit?id=" . $contactMS->id
                        ]
                    ]
                ];
                $customFieldUpdate2 = [
                    "field_id" => 604457,
                    "field_name" => "Ид контрагента в  моем складе",
                    "field_code" => null,
                    "field_type" => "text",
                    "values" => [
                        [
                            "value" => $contactMS->id
                        ]
                    ]
                ];


                $client = new Client([
                    'base_uri' => 'https://euroblock.amocrm.ru/api/v4/',
                    'headers' => [
                        'Authorization' => "Bearer $accessToken",
                        'Content-Type' => 'application/json',
                    ],
                ]);

                try {
                    $response = $client->patch("contacts/$contactAmo->id", [
                        'json' => ['custom_fields_values' => [$customFieldUpdate, $customFieldUpdate2]],
                    ]);

                    $contactAmo->contact_ms_id = $contactMS->id;
                    $contactAmo->contact_ms_link = 'https://api.moysklad.ru/#company/edit?id=' . $contactMS->id;
                    $contactAmo->save();

                    return $response->getStatusCode() === 200
                        ? 'Custom field updated successfully.'
                        : 'Error updating custom field.';
                } catch (RequestException  $e) {
                    info($e->getMessage());
                    return false;
                }
            }
        }
    }
}
