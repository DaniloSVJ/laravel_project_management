<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectsUsersController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;

Route::get('api/documentation', [SwaggerController::class, 'api'])->name('l5-swagger.api');
Route::get('api/documentation/docs', [SwaggerController::class, 'docs'])->name('l5-swagger.docs');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//SOMENTE O GESTOR E ADMIN
Route::group(['middleware'=>['auth:sanctum','admin_manager']],function () {
    Route::post('/project',[ProjectController::class, 'store']);
    Route::put('/project/{id}',[ProjectController::class, 'update']);
    Route::delete('/project/{id}',[ProjectController::class, 'destroy']);
});

//TODOS PODEM VER O PROJETO,TAREFAS e PROJETO ASSOCIADO, DESDE QUE ESTEJAM LOGADOS 
Route::group(['middleware'=>['auth:sanctum']],function () {
    Route::get('/project',[ProjectController::class, 'index']);
    Route::get('/project/{id}',[ProjectController::class, 'show']);
    Route::get('/projectsusers/{id}',[ProjectController::class, 'showUserProjects']);
    Route::get('/projectsusers',[ProjectController::class, 'allUserProjects']);

    Route::get('/tasks',[TaskController::class, 'index']);
    Route::get('/tasks/{id}',[TaskController::class, 'show']);

    Route::get('/project_user',[ProjectsUsersController::class, 'index']);
    Route::get('/project_user/{id}',[ProjectsUsersController::class, 'show']);
});

//COM EXEÇÃO DO USUÁRIO DEV TODOS OS OUTROS USUÁRIOS DE HIERARQUIA MAIS ALTA PODEM ACESSAR AS ROTAS
Route::group(['middleware'=>['auth:sanctum','admin_manager_tecl']],function () {
    Route::post('/tasks',[TaskController::class, 'store']);
    Route::put('/tasks/{id}',[TaskController::class, 'update']);
    Route::delete('/tasks/{id}',[TaskController::class, 'destroy']);
    
    Route::post('/project_user',[ProjectsUsersController::class, 'store']);
    Route::put('/project_user/{id}',[ProjectsUsersController::class, 'update']);
    Route::delete('/project_user/{id}',[ProjectsUsersController::class, 'destroy']);
    
});



Route::post('/register', [AuthController::class, 'reguser']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

