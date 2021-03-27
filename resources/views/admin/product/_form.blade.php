<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.products.update', $model->getKey())}}" data-route="{{ route('admin.products.index')}}" data-method="PUT">
        @else
        <div class="div-form" data-api="{{ route('api.admin.products.store')}}" data-route="{{ route('admin.products.index')}}" data-method="POST">
        @endif
            <div class="form-group">
                {{ Form::label('name', 'Product Name') }}
                {{ Form::text('name', $model->name ,array('class' => 'form-control', 'placeholder'=>'Product Name')) }}
            </div>  
            <div class="form-group">
                {{ Form::label('description', 'Product Description') }}
                {{ Form::textarea('description', $model->description ,array('class' => 'form-control', 'placeholder'=>'Product Description')) }}
            </div>
            <div class="form-group">
                {{ Form::label('category', 'Product Category') }}
                {{ Form::select('category_id', $dataCategories, $model->category_id, ['id'=> 'category', 'class'=>'form-control select2']) }}
            </div>  
            <div class="form-group">
                <button class="btn btn-submit btn-primary" type="submit">
                    <i class="fa fa-save"></i>
                    Submit
                </button>
            </div>
        </div>
        @if($model->exists)
            @include('admin.product.partials.asset', compact($model))
        @endif
    </div> 
</div>