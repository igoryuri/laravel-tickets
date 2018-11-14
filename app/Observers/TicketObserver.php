<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Observers\Utils\UploadObserverTrait;

class TicketObserver
{
    use UploadObserverTrait;

    protected $field = 'image';
    protected $path = 'img/ticket/';
    protected $ext = ['jpg', 'jpeg', 'png', 'pdf'];

    public function creating(Ticket $model)
    {
        $this->createFile($model);
    }
    public function deleting(Ticket $model)
    {
        $this->removeFile($model->image);
    }
    public function updating(Ticket $model)
    {
        $this->updateFile($model);
    }
}
