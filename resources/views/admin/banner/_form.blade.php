<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.banner.update', $model->getKey())}}" data-route="{{ route('admin.banners.index')}}" data-method="PATCH">
        @else
        <div class="div-form" data-api="{{ route('api.admin.banner.store')}}" data-route="{{ route('admin.banners.index')}}" data-method="POST">
        @endif
            <div class="form-group">
                {{ Form::label('key', 'Key Page') }}
                {{ Form::text('key', $model->key ,array('class' => 'form-control', 'placeholder'=>'Key', 'disabled'=>'disabled')) }}
            </div>
            <div class="form-group">
                {{ Form::label('banner_page', 'Banner Page') }}
                {{ Form::text('banner_page', $model->banner_page ,array('class' => 'form-control', 'placeholder'=>'Banner Page')) }}
            </div>  
            <div class="form-group">
            <button class="btn btn-submit btn-primary" type="submit">
                <i class="fa fa-save"></i>
                Submit
            </button>
            </div>
        </div>
        @if($model->exists)
            @include('admin.banner.partials.asset', compact($model))
        @endif
    </div> 
</div>