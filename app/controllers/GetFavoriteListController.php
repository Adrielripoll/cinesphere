<?php
namespace app\controllers;

use app\database\Connection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetFavoriteListController {
    
    private $conn;

    public function __construct(){
        $this->conn = Connection::connection();
    }

    public function execute(Request $request, Response $response){

        $sql_list = mysqli_query($this->conn, "SELECT * FROM favorites");

        if(mysqli_num_rows($sql_list) > 0){
            while($rows = mysqli_fetch_assoc($sql_list)){
                $result[] = $rows;
            }
        } else {
            $result = array();
        }

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}