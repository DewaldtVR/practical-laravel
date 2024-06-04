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

    protected $fillable = ["name", "clientCode", "contact"];
    public $descriptor = "name";
    protected $appends = ['contacts_count'];

    public function modelMeta(FieldSet $fieldSet)
    {      
        $fieldSet->select("user", "User")   
            ->canAddEdit(false)
            ->canFilter(true)
            ->canListView(false);
            
        $fieldSet->text("name", "Client Name")
            ->canFilter(true)
            ->required();

        $fieldSet->text("clientCode", "Client Code")
            ->canFilter(true)
            ->canAddEdit(false)
            ->canListView(true)
            ->required();

        $fieldSet->text("contacts_count", "No of Contacts")
            ->canListView(true)
            ->canFilter(true)
            ->canAddEdit(false);

    }
    public function user()
    {
        return $this->belongsTo(User::class,'userid');
    }
    public function getContactsCountAttribute()
    {
        return $this->contact()->count();
    }

    public function contact()
    {
        return $this->hasMany(Contact::class)
            ->select([
                "contactid",
                "clientid",
                "name",
                "surname",
                "email"
            ]);

    }
}
