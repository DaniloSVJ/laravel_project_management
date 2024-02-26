<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','start_date','term_of_delivery'];
    protected $table = 'project';

    //Observer do delete
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($project) {
            // Criando uma nova atividade antes  registrando a exclusão do projeto
            $activity = new Activity();
            $activity->action = 'delete';
            $activity->description = 'Titulo do Projeto: ' . $project->title.'. Id projeto: '.$project->id;
            $activity->user_id = Auth::id(); // Obtendo o ID do usuário autenticado
            $activity->save();
        });
    }
    public function users()
    {
    
        return $this->belongsToMany(User::class,'user_projects', 'users_id', 'project_id');

    }

}
