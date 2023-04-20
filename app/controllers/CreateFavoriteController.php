<?php

namespace app\controllers;

use app\database\Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateFavoriteController {

    private $conn;

    public function __construct()
    {   
        $this->conn = Connection::connection();
    }

    public function execute(Request $request, Response $response){

        $body = $request->getBody()->getContents();
        $data = json_decode($body);

        $movieId = $data->movieId;
        $imageUrl = $data->imageUrl;
        $cast = $data->cast;
        $movieTitle = $data->movieTitle;
        $movieRelease = $data->movieRelease;

        $sqlMovie = mysqli_query($this->conn, "SELECT movieId FROM favorites WHERE movieId='$movieId'");

        if(mysqli_num_rows($sqlMovie) > 0){
            $response->getBody()->write(json_encode(array("message" => "Filme já incluso na lista de favoritos")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
        } 

        mysqli_query($this->conn, "INSERT INTO favorites (movieId, imageUrl, cast, movieTitle, movieRelease) 
            VALUES ('$movieId', '$imageUrl', '$cast', '$movieTitle', '$movieRelease')");

        if (mysqli_error($this->conn)) {
            echo mysqli_error($this->conn);
            $response->getBody()->write(json_encode(array("message" => "Erro! tente novamente mais tarde.")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }

        mysqli_close($this->conn);

        $response->getBody()->write(json_encode(array("message" => "Filme adicionado com sucesso")));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}