<?php

namespace App\Models;

use App\Classes\Thunder\FieldSet;
use App\Classes\Thunder\Validators\Utils;
use App\Traits\ModelConvention;
use App\Traits\ThunderModel;
use App\Models\Client;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use ModelConvention;
    use ThunderModel;
    protected $fillable = ["name", "surname", "email"];
    public $descriptor = 'name';

    public function modelMeta(FieldSet $fieldSet)
    {
        $fieldSet->select("client", "Client")
            ->canAddEdit(false)
            ->canFilter(true);

        $fieldSet->select("user", "Created By")
            ->canAddEdit(false)
            ->canListView(false)
            ->canFilter(true);    

        $fieldSet->text("name", "Name")
            ->canFilter(true)
            ->required();

        $fieldSet->text("surname", "Surname")
            ->required()
            ->canFilter(true)
            ->canAddEdit(true);

        $fieldSet->text("email", "Email Address")
            ->required()
            ->pattern("Invalid email address", Utils::EMAIL_REGEX)
            ->canFilter(true)
            ->canAddEdit(true);

    }
    public function client()
    {
        return $this->belongsTo(Client::class,"clientid");
    }
     public function user()
    {
        return $this->belongsTo(User::class,'userid');
    }
}
