<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.categories.update', $model->getKey())}}" data-route="{{ route('admin.categories.index')}}" data-method="PUT">
        @else
        <div class="div-form" data-api="{{ route('api.admin.categories.store')}}" data-route="{{ route('admin.categories.index')}}" data-method="POST">
        @endif
        @if($model->exists)
            <div class="box box-success collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Of Sub Category</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul>
                        @foreach($model->childrenRecursive as $child)
                            <li>
                                {{$child->name}}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="form-group">
                <button class="btn btn-primary add-btn-input" type="submit">
                    <i class="fa fa-save"></i>
                    Add More Sub Category
                </button>
                <div class="sub-categories add-input-wrapper">
                </div>
            </div>
        @endif
            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', $model->name ,array('class' => 'form-control', 'placeholder'=>'Name')) }}
            </div>  
            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::text('description', $model->description ,array('class' => 'form-control', 'placeholder'=>'Description')) }}
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