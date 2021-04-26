<div class="box"> 
    <div class="box-body">
        @if($model->exists)
        <div class="div-form" data-api="{{ route('api.admin.pages.update', $model->getKey())}}" data-route="{{ route('admin.pages.index')}}" data-method="PUT">
        @else
        <div class="div-form" data-api="{{ route('api.admin.pages.store')}}" data-route="{{ route('admin.pages.index')}}" data-method="POST">
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
                                {!! Form::label( $locale.'_title', 'Page Title '.'('.$locale.')') !!}
                                {{ Form::text($locale.'_title', $model->translate($locale) ? $model->translate($locale)->title : ''  ,array('class' => 'form-control', 'placeholder'=>'Title')) }}
                            </div>  
                            <div class="form-group">
                                {{ Form::label($locale.'_body', 'Page Body '.'('.$locale.')') }}
                                {{ Form::textarea($locale.'_body', $model->translate($locale) ? $model->translate($locale)->body : '' ,array('class' => 'form-control ck-editor', 'placeholder'=>'Body')) }}
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
        @if($model->exists)
            @include('admin.page.partials.asset', compact($model))
        @endif
    </div> 
</div>