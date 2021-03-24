<?php

namespace App\Observers;

class LogObserver
{
    
    protected $user_id = null;
    protected $now;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now()->toDateTimeString();
        if( $user = \Auth::user() )
            $this->user_id = $user->getKey();
    }

    public function creating($model)
    {
        if( $model->timestamps ) {
            $model->created_at = $this->now;
            $model->created_by = $this->user_id;
        }
    }

    public function updating($model)
    {
        if( $model->timestamps ) {
            $model->updated_at = $this->now;
            $model->updated_by = $this->user_id;
        }
    }
}
