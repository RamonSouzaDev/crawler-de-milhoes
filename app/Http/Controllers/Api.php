<?php

namespace App\Http\Controllers;

use DOMDocument;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Api extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $client = new Client();

        $res = $client->request('GET', 'https://pt.wikipedia.org/wiki/Lista_das_maiores_empresas_do_Brasil');

        $valuesCrawled = $res->getBody()->getContents();

        $dom = new DOMDocument();

        libxml_use_internal_errors(true); // suppress HTML5 errors
        $dom->loadHTML($valuesCrawled, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $table = $dom->getElementsByTagName('tbody')->item(0)->getElementsByTagName('tr');

        $dataResponse = [];

        foreach ($table as $index => $td) {  

            if (!$index) {
                continue;
            }

            $valueFromCrawler = str_replace([',', "\n"], ['.', ''], $td->getElementsByTagName('td')->item(4)->nodeValue);

            if ($valueFromCrawler >= $request['search']) {
                $profit = $valueFromCrawler;
            } else {
                continue;
            }

            $companyName = str_replace("\n", '', $td->getElementsByTagName('td')->item(1)->nodeValue);

            $rank = str_replace("\n", '', $td->getElementsByTagName('td')->item(0)->nodeValue);

            $dataResponse[] = [
                'company_name' => $companyName,
                'rank' => $rank,
                'profit' => $profit,
            ];
        }

        $dataResponse = response()->json($dataResponse);

        return $dataResponse;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
