<?php

namespace Modules\FileManager\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\FileManager\App\Helpers\FileManagerHelper;

class File extends Model
{
    use SoftDeletes;

    protected $table = 'files';

    protected $fillable = [
        'id',
        'title',
        'description',
        'slug',
        'ext',
        'file',
        'folder',
        'domain',
        'user_id',
        'folder_id',
        'path',
        'size',
        'is_front',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'path',
        'deleted_at',
        'user_id',
        'description',
        'is_front',
        'created_at',
        'updated_at',
        'folder',
        'domain',
        'file',
        'description',
        'folder_id',
        'is_front',
    ];

    protected $appends = ['src', 'thumbnails'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDist(): string
    {
        return $this->path.'/'.$this->file;
    }

    public function getThumbnailsAttribute(): array
    {
        $thumbsImages = FileManagerHelper::getThumbsImage();
        $thumbs = [];
        foreach ($thumbsImages as $thumbsImage) {
            $slug = $thumbsImage['slug'];
            if (in_array($this->ext, FileManagerHelper::getImagesExt())) {
                $src = config('filemanager.static_url').$this->folder.$this->slug.'_'.$slug.'.'.$this->ext;
            } else {
                $src = $this->getSrcAttribute();
            }
            $thumbs[$slug] = $src;
        }

        return $thumbs;
    }

    public function getSrcAttribute(): string
    {
        return $this->domain.$this->folder.$this->slug.'.'.$this->ext;
    }
}
