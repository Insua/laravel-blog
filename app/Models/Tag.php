<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $tag
 * @property string $title
 * @property string $subtitle
 * @property string $page_image
 * @property string $meta_description
 * @property string $layout
 * @property int $reverse_direction
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag wherePageImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereReverseDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $fillable = [
        'tag','title','subtitle','page_image','meta_description','reverse_direction',
    ];

    /**
     * 定义文章与标签之间多对多关联关系
     */
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post','post_tag_pivot');
    }

    /**
     * Add any tags needed from the list
     */
    public static function addNeededTags(array $tags)
    {
        if(count($tags) === 0)
        {
            return;
        }

        $found = static::whereIn('tag',$tags)->lists('tag')->all();

        foreach(array_diff($tags,$found) as $tag)
        {
            static::create([
                'tag' => $tag,
                'title' => $tag,
                'subtitle' => 'Subtitle for '.$tag,
                'page_image' => '',
                'meta_description' => '',
                'reverse_direction' => false,
            ]);
        }
    }
}
