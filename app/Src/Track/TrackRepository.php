<?php namespace App\Src\Track;

use App\Core\BaseRepository;
use Carbon\Carbon;

class TrackRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Track $model
     */
    public function __construct(Track $model)
    {
        $this->model = $model;
    }

    /**
     * @param $timeSpan
     * @return mixed Get The Votes That are
     * Get The Votes That are
     */
    public function getTopTracks($timeSpan = 'any')
    {
        switch ($timeSpan) {
            case 'any':
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

        return $this->model
            ->selectRaw('tracks.*, count(*) as track_count, meta_id, meta_type')
            ->join('metas', 'tracks.id', '=', 'metas.meta_id')
            ->where('meta_type', 'Track')
            ->where('metas.created_at', '>', $date)
            ->groupBy('meta_id')
            ->orderBy('track_count', 'DESC')
            ->orderBy('metas.created_at','DESC')
            ->get();
    }


}