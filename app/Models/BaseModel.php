<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\LogObserver;

/**
 * App\Models\BaseModel
 *
 * @mixin Model
 */
class BaseModel extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if( $this->timestamps )
            $this->fillable = array_merge($this->fillable, $this->logCol());
    }

    public static function boot()
    {
        parent::boot();
        static::observe(LogObserver::class);
    }

    public function logCol(){
        return $this->timestamps ?
            [
                'created_at',
                'created_by',
                'updated_at',
                'updated_by',
                'deleted_at',
                'deleted_by',
            ] : [];
    }
}
