<?php

namespace App\Models;

use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $subtitle
 * @property string $content_raw
 * @property string $content_html
 * @property string $page_image
 * @property string $meta_description
 * @property int $is_draft
 * @property string $layout
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $published_at
 * @property-read mixed $content
 * @property-read mixed $publish_data
 * @property-read mixed $publish_time
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereContentHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereContentRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereIsDraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePageImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{

    protected $fillable = [
        'title','subtitle','content_raw','page_image','meta_description','layout','is_draft','published_at'
    ];

    protected $dates = ['published_at'];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if(! $this->exists)
        {
            $this->attributes['slug'] = str_slug($value);
        }
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','post_tag_pivot');
    }

    protected function setUniqueSlug($title,$extra)
    {
        $slug = str_slug($title.'-'.$extra);

        if(static::whereSlug($slug)->exists())
        {
            $this->setUniqueSlug($title,$extra + 1);
            return;
        }

        $this->attributes['slug'] = $slug;
    }

    public function setContentRawAttribute($value)
    {
        $markdown = new Markdowner();

        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = $markdown->toHTML($value);
    }

    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if(count($tags))
        {
            $this->tags()->sync(Tag::whereIn('tag',$tags)->lists('id')->all());
            return;
        }

        $this->tags()->detach();
    }

    public function getPublishDataAttribute($value)
    {
        return $this->published_at->format('M-j-Y');
    }

    public function getPublishTimeAttribute($value)
    {
        return $this->publishe_at->format('g:i A');
    }

    public function getContentAttribute($value)
    {
        return $this->content_raw;
    }
}
