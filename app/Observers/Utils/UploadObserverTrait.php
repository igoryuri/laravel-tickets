<?php

namespace App\Observers\Utils;

use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadObserverTrait
{
    protected function createFile($model)
    {
        $field = $this->field;
        $ext = $this->ext;
        if (is_a($model->$field, UploadedFile::class) and $model->$field->isValid() and in_array($model->$field->extension(), $ext)) {
            $this->upload($model);
        }
    }

    protected function updateFile($model)
    {
        $field = $this->field;
        $ext = $this->ext;
        if (is_a($model->$field, UploadedFile::class) and $model->$field->isValid() and in_array($model->$field->extension(), $ext)) {
            $previous_file = $model->getOriginal($field);
            $this->upload($model);
            $this->removeFile($previous_file);
        }
    }

    protected function removeFile($file)
    {
        $prefix = Storage::disk(config('filesystems.default'))->getDriver()->getAdapter()->getPathPrefix();
        $file = $prefix . $this->path . '/' . $file;
        if (file_exists($file) and !is_dir($file)) {
            unlink($file);
        }
    }

    protected function upload($model)
    {
        $last_id = Ticket::all()->last();
        $id = (int)$last_id['id'] + 1;
        $field = $this->field;
        $path = $this->path . $id . "/";
        $extention = $model->$field->extension();
        $name = bin2hex(openssl_random_pseudo_bytes(8));
        $name = $name . '.' . $extention;
        $model->$field->storeAs($path, $name);
        $model->$field = $name;
    }
}
