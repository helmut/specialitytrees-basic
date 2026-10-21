<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    public function getUrl(string $conversion = ''): string
    {
        $base = rtrim(config('filesystems.disks.s3.url', ''), '/');
        $path = $this->model_id . '/' . $this->file_name;

        if ($conversion) {
            // Spatie v7 conversion path: {model_id}/conversions/{file_name}
            $pathInfo = pathinfo($this->file_name);
            $conversionFile = $pathInfo['filename'] . '.jpg';
            $path = $this->model_id . '/conversions/' . $conversionFile;
        }

        return $base ? $base . '/' . $path : $path;
    }

    public function hasGeneratedConversion(string $conversion): bool
    {
        $manipulations = json_decode($this->manipulations ?? '[]', true);
        return is_array($manipulations) && count($manipulations) > 0;
    }
}
