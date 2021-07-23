<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {

        // require_once '/path/to/MailchimpMarketing/vendor/autoload.php';

        // $client = new MailchimpMarketing\ApiClient();
        // $client->setConfig([
        //     'apiKey' => 'YOUR_API_KEY',
        //     'server' => 'YOUR_SERVER_PREFIX',
        // ]);

        // $response = $client->lists->getAllLists();
        // print_r($response);



        echo "IN"; die;

        return response()->json([

            'users' => \App\User::latest()->get()

        ], Response::HTTP_OK);

    }
}
