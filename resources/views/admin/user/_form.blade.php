<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.users.update', $model->getKey())}}" data-route="{{ route('admin.users.index')}}" data-method="PUT">
        @else
        <div class="div-form" data-api="{{ route('api.admin.users.store')}}" data-route="{{ route('admin.users.index')}}" data-method="POST">
        @endif
            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', $model->name ,array('class' => 'form-control', 'placeholder'=>'Name')) }}
            </div>  
             <div class="form-group">
                {{ Form::label('email', 'Email') }}
                {{ Form::text('email', $model->email ,array('class' => 'form-control', 'placeholder'=>'Email' )) }}
            </div> 
            <div class="form-group">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password' ,array('class' => 'form-control', 'placeholder'=>'Password' )) }}
            </div>
            <div class="form-group">
                {{ Form::label('password_confirmation', 'Password Confirmation') }}
                {{ Form::password('password_confirmation' ,array('class' => 'form-control', 'placeholder'=>'Password Confirmation' )) }}
            </div>
            <div class="form-group">
                <label>Roles</label>
                @foreach($roles as $id => $role)
                    <div>
                        <label>
                        {{ Form::checkbox('role[]', $id, in_array($id, $model->roles->pluck('id')->toArray()), array('id' => $role, 'class' => 'form-checkbox')) }}
                        {{ Form::label($role, $role) }}
                        </label>
                    </div>
                @endforeach
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