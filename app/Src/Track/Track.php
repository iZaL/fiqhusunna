<?php namespace App\Src\Track;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Meta\CountableTrait;
use App\Src\Meta\DownloadableTrait;
use Carbon\Carbon;

class Track extends BaseModel
{

    use LocaleTrait;

    use CountableTrait;

    use DownloadableTrait;

    protected $table = 'tracks';

    public $morphClass = 'Track';

    protected $localeStrings = ['name', 'description'];

    public $types = [
        'album'    => 'App\Src\Album\Album',
        'category' => 'App\Src\Category\Category',
    ];

    protected $guarded = ['id'];

    public function trackeable()
    {
        return $this->morphTo();
    }

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }

    public function topTracks()
    {
        return $this->morphOne('App\Src\Meta\Meta',
            'meta')->selectRaw('meta_id, count(*) as count')->groupBy('meta_id')->orderBy('count', 'desc')->limit(1);
    }

    public function downloads()
    {
        return $this->morphMany('App\Src\Meta\Download', 'downloadable');
    }

    public function getTrackeableTypeAttribute($type)
    {
        $type = strtolower($type);

        return array_get($this->types, $type, $type);
    }

    /**
     * @param string $timeSpan
     * @param int $paginate
     * @return mixed Get The Votes That are
     * Get The Votes That are
     */
    public function getTopTracks($timeSpan = 'all', $paginate = 10)
    {
        switch ($timeSpan) {
            case 'all':
                $date = '0000';
                break;
            case 'today':
                $date = Carbon::yesterday();
                break;
            case 'this-month':
                $date = new Carbon('last month');
                break;
            default:
                $date = '0000';
                break;
        }

        return $this
            ->selectRaw('tracks.*, count(*) as track_count, meta_id, meta_type')
            ->join('metas', 'tracks.id', '=', 'metas.meta_id')
            ->where('meta_type', 'Track')
            ->where('metas.created_at', '>', $date)
            ->groupBy('meta_id')
            ->orderBy('track_count', 'DESC')
            ->orderBy('metas.created_at', 'DESC')
            ->paginate($paginate);
    }


    public function getSizeAttribute($bytes)
    {

        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function setTrackeableTypeAttribute($value)
    {
        $this->attributes['trackeable_type'] = ucfirst($value);
    }

    public function setSlugAttribute($value)
    {
        return $this->attributes['slug'] = slug(tidify($value));
    }

    /**
     * Get the Clean Name For Track (Strip Extensions, and Secure)
     * @param $value
     * @return string
     */
    public function setNameArAttribute($value)
    {
        return $this->attributes['name_ar'] = tidify($value);
    }


}
