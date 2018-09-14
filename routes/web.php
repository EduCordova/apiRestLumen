<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/users/login',['uses'=>'UserController@getToken']);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->get('/ping',function() {
//     return response()->json(['ack'=>time()]);
// });

// //recibe 1 digito o mas!! como ID
// $router->get('/authors/{id:\d+}',[
//     'as' => 'author.list',
//     'uses' => 'AutorController@show'
// ]);

$router->get('/inkey',function(){
    return str_random(32);
});
$router->group(['prefix'=>'api'],function() use ($router)
{
    $router->get('authors',['uses'=>'AuthorController@showAllAuthors']);
    $router->get('authors/{id}',['uses'=>'AuthorController@showOneAuthor']);
    $router->post('authors',['uses'=>'AuthorController@create']);
    $router->put('authors/{id}',['uses'=>'AuthorController@update']);
    $router->delete('authors/{id}',['uses'=>'AuthorController@delete']);
});


$router->group(['middleware'=> ['auth']], function() use ($router)
{
    $router->get('/users', ['uses'=>'UserController@index']);
    $router->post('/users', ['uses'=>'UserController@createUser']);
    $router->put('/users/{id}', ['uses'=>'UserController@updateUser']);
    $router->delete('/users/{id}', ['uses'=>'UserController@deleteUser']);
});