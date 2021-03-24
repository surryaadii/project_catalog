<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.roles.update', $model->getKey())}}" data-route="{{ route('admin.roles.index')}}" data-method="PUT">
        @else
        <div class="div-form" data-api="{{ route('api.admin.roles.store')}}" data-route="{{ route('admin.roles.index')}}" data-method="POST">
        @endif
            <div class="form-group">
                {{ Form::label('name', 'Role Name') }}
                {{ Form::text('name', $model->name ,array('class' => 'form-control', 'placeholder'=>'Role Name')) }}
            </div>  
            <div class="form-group">
            <button class="btn btn-submit btn-primary" type="submit">
                <i class="fa fa-save"></i>
                Submit
            </button>
            </div>
        </div>
    </div> 
</div>