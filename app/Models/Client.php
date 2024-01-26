<?php

namespace App\Models;

use App\Classes\Thunder\FieldSet;
use App\Classes\Thunder\Validators\Utils;
use App\Observers\ClientObserver;
use App\Traits\ModelConvention;
use App\Traits\ThunderModel;
use App\Models\Contact;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    use ModelConvention;
    use ThunderModel;

    protected $fillable = ["name", "clientCode", "contacts"];
    public $descriptor = "name";

    public function modelMeta(FieldSet $fieldSet)
    {      

        $fieldSet->text("name", "Client Name")
            ->canFilter(true)
            ->required();

        $fieldSet->text("clientCode", "Client Code")
            ->canFilter(true)
            ->required();

        $fieldSet->select("contacts", "No of Contacts")
            ->required()
            ->canListView(false)
            ->canFilter(true)
            ->canAddEdit(true);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'userid');
    }
    public function contact()
    {
        return $this->hasMany(Contact::class)
            ->select([
                "contactid",
                "name",
                "surname",
                "email"
            ]);

    }
}
