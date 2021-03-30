<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.categories.update', $model->getKey())}}" data-route="{{ route('admin.categories.index')}}" data-method="PUT">
        @else
        <div class="div-form" data-api="{{ route('api.admin.categories.store')}}" data-route="{{ route('admin.categories.index')}}" data-method="POST">
        @endif
        @if($model->exists)
            <div class="box box-success expanded-box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Of Sub Category</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="list-sub-category">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            @foreach(config('translatable.locales') as $key => $locale)
                                <li class="@if($key == 0) active @endif">
                                    <a href="#tab_list_{{$locale}}" data-toggle="tab">{{strtoupper($locale)}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach(config('translatable.locales') as $key => $locale)
                                <div class="tab-pane @if($key == 0) active @endif" id="tab_list_{{$locale}}">
                                    <ul>
                                        @if(count($model->childrenRecursive) > 0)
                                            @foreach($model->childrenRecursive as $child)
                                                <li>
                                                    {{$child->translate($locale)->name}}
                                                </li>
                                            @endforeach
                                        @else
                                            <p>No Sub Category</p>
                                        @endif
                                    </ul>
                                </div>
                                <!-- /.tab-pane -->
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="form-group">
                <button class="btn btn-primary add-btn-input" type="submit">
                    <i class="fa fa-save"></i>
                    Add More Sub Category
                </button>
            </div>
                <div class="sub-categories add-input-wrapper hidden">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            @foreach(config('translatable.locales') as $key => $locale)
                                <li class="@if($key == 0) active @endif">
                                    <a href="#tab_createsub_{{$locale}}" data-toggle="tab">{{strtoupper($locale)}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach(config('translatable.locales') as $key => $locale)    
                                <div class="tab-pane @if($key == 0) active @endif" id="tab_createsub_{{$locale}}">
                                </div>
                            @endforeach
                            <!-- /.tab-pane -->
                        </div>
                    </div>
                </div>
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
                                {!! Form::label( $locale.'_name', 'Category Name '.'('.$locale.')') !!}
                                {{ Form::text($locale.'_name', $model->translate($locale) ? $model->translate($locale)->name : ''  ,array('class' => 'form-control', 'placeholder'=>'Category Name')) }}
                            </div>  
                            <div class="form-group">
                                {{ Form::label($locale.'_description', 'Category Description '.'('.$locale.')') }}
                                {{ Form::textarea($locale.'_description', $model->translate($locale) ? $model->translate($locale)->description : '' ,array('class' => 'form-control', 'placeholder'=>'Category Description')) }}
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    @endforeach
                </div>
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