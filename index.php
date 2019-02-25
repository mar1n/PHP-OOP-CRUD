<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 03/02/2019
 * Time: 21:34
 */

require 'app/bootstrap.php';
//$config = new App\Config\Settings();
//var_dump($config);
$connectDb = new App\Config\connectDb();
$crud = new App\Config\crud($connectDb);
//$crud->create([['Szymon', 'Tyrul'], ['Adam', 'Ryszard']]);
//$crud->update(["Max" => "Ryszard"]);
//$crud->delete([27, 28]);

var_dump($crud->read("SELECT * from books"));