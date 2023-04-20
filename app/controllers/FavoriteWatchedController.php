<?php
namespace app\controllers;

use app\database\Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FavoriteWatchedController {
    private $conn;

    public function __construct(){
        $this->conn = Connection::connection();
    }

    public function execute(Request $request, Response $response, array $args){
        $id = $args['id'];

        $favoriteQuery = "SELECT * FROM favorites WHERE id = '$id'";

        $favorite = mysqli_query($this->conn, $favoriteQuery);

        if(mysqli_num_rows($favorite) == 0){
            $response->getBody()->write(json_encode(array("message" => "Favorito não encontrado")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        $updateFavoriteQuery = "UPDATE favorites SET watched = 1 WHERE id = '$id'";

        mysqli_query($this->conn, $updateFavoriteQuery);

        return $response->withHeader('Content-Type', 'application/json')->withStatus(204);
    }
}