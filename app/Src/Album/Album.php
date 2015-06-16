<?php namespace App\Src\Album;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Meta\CountableTrait;
use Carbon\Carbon;

class Album extends BaseModel
{

    use LocaleTrait;

    use CountableTrait;

    protected $table = 'albums';

    public $morphClass = 'Album';

    protected $guarded = ['id'];

    protected $localeStrings = ['name', 'description'];


    public function category()
    {
        return $this->belongsTo('App\Src\Category\Category', 'category_id');
    }

    public function tracks()
    {
        return $this->morphMany('App\Src\Track\Track', 'trackeable');
    }

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }

    public function recentTracks()
    {
        return $this->tracks()->latest()->take(5);
    }

    public function photos()
    {
        return $this->morphMany('App\Src\Photo\Photo', 'imageable');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Src\Photo\Photo', 'imageable')->where('thumbnail', 1);
    }

    /**
     * @param string $timeSpan
     * @param int $paginate
     * @return mixed Get The Votes That are
     * Get The Votes That are
     */
    public function getTopAlbums($timeSpan = 'all', $paginate = 10)
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
            ->selectRaw('albums.*, count(*) as aggregate, meta_id, meta_type')
            ->join('metas', 'albums.id', '=', 'metas.meta_id')
            ->where('meta_type', 'Album')
            ->where('metas.created_at', '>', $date)
            ->groupBy('meta_id')
            ->orderBy('aggregate', 'DESC')
            ->orderBy('metas.created_at', 'DESC')
            ->paginate($paginate);
    }

}
