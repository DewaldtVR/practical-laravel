<?php

namespace App\Models;

use App\Traits\ModelConvention;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use ModelConvention;

    protected $fillable = ["context", "message", "type"];

    public static function exception($context, \Exception $exception)
    {
        (new Log)->create([
            "context" => $context,
            "message" => $exception->getMessage(),
            "type" => "error"
        ]);
    }

    public static function log($context, $message)
    {
        (new Log)->create([
            "context" => $context,
            "message" => $message,
            "type" => "log"
        ]);
    }
}
