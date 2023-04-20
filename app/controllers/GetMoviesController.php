<?php
namespace app\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetMoviesController {

    public function execute(Request $request, Response $response, array $args){
        $page = $args["page"] ?? '1';

        $endpoint = 'https://moviesdatabase.p.rapidapi.com/titles?titleType=movie&list=most_pop_movies&endYear=2023&startYear=1950&sort=year.decr&page='.$page;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-RapidAPI-Key: 48bffc306cmsh266cc1cb6ed6f5dp195516jsn51b23591e1c5',
                'X-RapidAPI-Host: moviesdatabase.p.rapidapi.com'
            ),
        ));

        $rapidResponse = curl_exec($curl);

        curl_close($curl);

        $dados = json_decode($rapidResponse);

        foreach($dados->results as $result){
            $movieId = $result->id;
            $imageUrl= $result->primaryImage->url;
            $cast = $result->primaryImage->caption->plainText;
            $title = $result->titleText->text;
            $day = $result->releaseDate->day;
            $month = $result->releaseDate->month;
            $year = $result->releaseDate->year;
            $release = $year.'-'.$month.'-'.$day;

            $json[] = array("movieId" => $movieId, "imageUrl" => $imageUrl, "cast" => $cast, "title" => $title, "release" => $release); 
        }

        $response->getBody()->write(json_encode($json));
        return $response->withHeader('Content-type', 'application/json'); 
    }
}
