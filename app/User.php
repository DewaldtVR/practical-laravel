<?php

namespace App;

use App\Classes\Thunder\FieldSet;
use App\Classes\Thunder\Validators\Utils;
use App\Models\Client;
use App\Models\Contact;
use App\Models\KycFile;
use App\Models\RelatedParty;
use App\Models\Userright;
use App\Models\Userrole;
use App\Notifications\UserCreated;
use App\Observers\UserCreatedObserver;
use App\Traits\ModelConvention;
use App\Traits\ThunderModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, ModelConvention, ThunderModel, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'usertypeid', 'countryid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updatedbyid'
    ];

    public $descriptor = "name";

//    protected static function boot()
//    {
//        parent::boot(); // TODO: Change the autogenerated stub
//        User::observe(UserCreatedObserver::class);
//    }

    public function modelMeta(FieldSet $fieldSet)
    {
        $fieldSet->text('name', 'Name')
            ->required()
            ->canFilter(true);

        $fieldSet->text('email', 'Email address')
            ->canFilter(true)
            ->required("Enter a valid email address")
            ->pattern("Invalid email address", Utils::EMAIL_REGEX);

        $fieldSet->dateTime('created_at', 'Created Date')
            ->canAddEdit(false);

        $fieldSet->dateTime('deleted_at', "Deactivated Date")
            ->canAddEdit(false);

        $fieldSet->text('employee_no', "Employee Number")
            ->canAddEdit(True);

    }

    public function roles()
    {
        return $this->belongsToMany(Userrole::class, 'user_userrole');
    }

    public function rights()
    {
        return $this->belongsToMany(Userright::class, 'user_userright');
    }

    public function client()
    {
        return $this->hasMany(Client::class);
    }
    public function relatedparty()
    {
        return $this->hasMany(Contact::class);
    }

    public function hasRight($right_slug)
    {
        if ($this->rights->contains('rightslug', $right_slug))
            return true;
        else {
            foreach ($this->roles as $role) {
                if ($role->hasRight($right_slug))
                    return true;
            }
        }
        return false;
    }
    public function hasRole($rolename)
    {
        if ($this->roles->has('rolename', $rolename))
            return true;
        else
            return false;
    }

    public function hasAnyRight($right_slug_array)
    {
        foreach ($right_slug_array as $right_slug) {
            if ($this->hasRight($right_slug))
                return true;
        }
        return false;
    }

    public function getHeaders(){
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * @param $slugOrArray
     * @return Builder|static
     */
    public static function withRights($slugOrArray)
    {

        if (!is_array($slugOrArray))
            $slugOrArray = [$slugOrArray];

        return User::whereHas('rights', function ($query) use ($slugOrArray) {
            $query->whereIn('rightslug', $slugOrArray);
        })->orWhereHas('roles', function ($query) use ($slugOrArray) {
            $query->join('userrole_userright', 'userrole_userright.userroleid', '=', 'user_userrole.userroleid')
                ->join('userright', 'userrole_userright.userrightid', '=', 'userright.userrightid')
                ->whereIn('rightslug', $slugOrArray);
        });
    }

    /**
     * @param $slugOrArray
     * @return Builder|static
     */
    public static function withoutRights($slugOrArray)
    {
        if (!is_array($slugOrArray))
            $slugOrArray = [$slugOrArray];

        return User::whereDoesntHave('rights', function ($query) use ($slugOrArray) {
            $query->whereIn('rightslug', $slugOrArray);
        })->whereDoesntHave('roles', function ($query) use ($slugOrArray) {
            $query->join('userrole_userright', 'userrole_userright.userroleid', '=', 'user_userrole.userroleid')
                ->join('userright', 'userrole_userright.userrightid', '=', 'userright.userrightid')
                ->whereIn('rightslug', $slugOrArray);
        });
    }

  
}
