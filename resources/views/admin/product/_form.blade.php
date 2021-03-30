<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.products.update', $model->getKey())}}" data-route="{{ route('admin.products.index')}}" data-method="PUT">
        @else
        <div class="div-form" data-api="{{ route('api.admin.products.store')}}" data-route="{{ route('admin.products.index')}}" data-method="POST">
        @endif
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach(config('translatable.locales') as $key => $locale)
                        <li class="@if($key == 0) active @endif">
                            <a href="#tab_{{$locale}}" data-toggle="tab">{{strtoupper($locale)}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach(config('translatable.locales') as $key => $locale)
                        <div class="tab-pane @if($key == 0) active @endif" id="tab_{{$locale}}">
                            <div class="form-group">
                                {!! Form::label( $locale.'_name', 'Product Name '.'('.$locale.')') !!}
                                {{ Form::text($locale.'_name', $model->translate($locale) ? $model->translate($locale)->name : ''  ,array('class' => 'form-control', 'placeholder'=>'Product Name')) }}
                            </div>  
                            <div class="form-group">
                                {{ Form::label($locale.'_description', 'Product Description '.'('.$locale.')') }}
                                {{ Form::textarea($locale.'_description', $model->translate($locale) ? $model->translate($locale)->description : '' ,array('class' => 'form-control', 'placeholder'=>'Product Description')) }}
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    @endforeach
                </div>
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