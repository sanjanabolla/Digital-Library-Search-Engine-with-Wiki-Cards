<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;
use Elastica\Client as ElasticaClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ElasticsearchController extends Controller
{
    public function es(Request $request)
    {
        $client = ClientBuilder::create()->build();
        
        $search = $request->input('search');
        $search = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($search))))));
        if($search == '' || Str::length($search) == 0) {
            if (Auth::check()) 
        {
            return view('index');
        }
        else
        {
            return view('home');
        } 
        }
        $params = [
            'index' => 'webproject2',
            'explain' => true,
            'from' => 0,
            'size' => 500,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $search,
                        'fields' => ['title','$year','abstract','wiki_terms','university','author','degree','program','advisor','$etd_file_id','pdf'],
                    ],
                ],
            ]
        ];
        $results = $client->search($params);
        $count = $results['hits']['total']['value'];
        $response = $results['hits']['hits'];
        //echo "Success";

        if (Auth::check()) 
        {
            return view('serp');
        }
        else
        {
            return view('search');
        }            
    }
    
    public function dissertation_details($id)
    {
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'webproject2',
            'from' => 0,
            'size' => 500,
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $id,
                        'fields' => ['title','$year','abstract','wiki_terms','university','author','degree','program','advisor','$etd_file_id','pdf'],
                    ],
                ],
            ]
        ];

        if (Auth::check()) 
        {
            return view('serp_summary',["id"=>$id])->withquery($params);
        }
        else
        {
            return view('summary',["id"=>$id])->withquery($params);
        }        

    }
    public function pdf($pdfid)
    {
        
        $file = '/Users/sanjanabolla/Downloads/PDF'."/$pdfid";
          
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $file . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile($file);

    }
    public function uploadetd_success()
    {   
        return view('upload_etd')->with('success','Details are indexed');
    }
}   
