<?php

namespace App\Src\Track;

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

    public function author()
    {
        return $this->belongsTo('App\Src\Author\Author');
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
            ->selectRaw('tracks.*, count(*) as aggregate, meta_id, meta_type')
            ->join('metas', 'tracks.id', '=', 'metas.meta_id')
            ->where('meta_type', 'Track')
            ->where('metas.created_at', '>', $date)
            ->groupBy('meta_id')
            ->orderBy('aggregate', 'DESC')
            ->orderBy('metas.created_at', 'DESC')
            ->paginate($paginate);
    }


    public function getSizeAttribute($bytes)
    {
        return convertBytesToHumanReadable($bytes);
    }

    public function setTrackeableTypeAttribute($value)
    {
        $this->attributes['trackeable_type'] = ucfirst($value);
    }

    /**
     * Get the Clean Name For Track (Strip Extensions, and Secure)
     * @param $value
     * @return string
     */
    public function setNameArAttribute($value)
    {
        $this->attributes['name_ar'] = tidify($value);
    }

    public function setRecordDateAttribute($value)
    {
        $this->attributes['record_date'] = Carbon::parse($value);
    }

}
