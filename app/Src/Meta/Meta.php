<?php namespace App\Src\Meta;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Meta extends BaseModel
{

    protected $table = 'metas';

    protected $guarded = ['id'];


    public $types = [
        'album'    => 'App\Src\Album\Album',
        'category' => 'App\Src\Category\Category',
        'track'    => 'App\Src\Track\Track',
    ];

    public function meta()
    {
        return $this->morphTo();
    }

    public function getMetaTypeAttribute($type)
    {
        $type = strtolower($type);

        return array_get($this->types, $type, $type);
    }


    public function scopeOfType($query, $type)
    {
        return $query->where('meta_type', $type);
    }

    //select count(*) as total_count,id, meta_id, meta_type from metas WHERE meta_type='Track' group by meta_id  ORDER BY total_count DESC;
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

        return DB::table('metas')
            ->select(DB::raw('count(*) as total_count, id, meta_id, meta_type'))
            ->where('meta_type', 'Track')
            ->where('created_at', '>', $date)
            ->groupBy('meta_id')
            ->orderBy('total_count', 'DESC')
            ->get();
    }

}
