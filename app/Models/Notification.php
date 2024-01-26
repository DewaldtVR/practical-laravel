<?php

namespace App\Models;

use App\Classes\Thunder\FieldSet;
use App\Traits\ThunderModel;
use App\User;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class Notification extends Model
{
    protected $primaryKey = "_id";
    protected $collection = "notifications";

    protected $date = ["_created", "dateSent", "dateToBeSent"];

    public $recordDescriptor = "message";

    use ThunderModel;

    public function modelMeta(FieldSet $fieldSet)
    {
        $fieldSet->text("title", "Title")
            ->required()
            ->canFilter(true);

        $fieldSet->text("message", "Message")
            ->required();

        $fieldSet->date("dateSent", "Date Sent")
            ->canFilter(true)
            ->canAddEdit(true);

        $fieldSet->date("dateToBeSent", "Date To Be Sent")
            ->canFilter(true)
            ->canAddEdit(false);

        $fieldSet->date("_created", "Created")
            ->canFilter(true)
            ->canAddEdit(false);
    }

    public function recipientDocument()
    {
        return $this->embedsOne(Appuser::class, 'recipient');
    }

    public function updateRecipient()
    {
        $recipient = Appuser::find($this->recipient['id']);
        $this->recipientDocument()
            ->create([
                "_id" => $recipient->_id,
                "firebaseTokenId" => $recipient->firebase_devicetoken
            ]);
    }
}
