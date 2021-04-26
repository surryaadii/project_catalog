<div class="row">
    <div class="col-xs-12 page-header">
        <!-- PAGE CONTENT BEGINS -->
        <div class="page-title">
            <h4>
                <i class="fa fa-file-text-o"></i> Attachment
            </h4>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->

<form method="post" action="{{ route('api.admin.pages.store_assets', $model->getKey()) }}" enctype="multipart/form-data" class="dropzone well" id="my-dropzone">
    {{ csrf_field() }}
    {{-- <input type="text" name="current_id" value="{{$customer->id}}" class="hidden"> --}}
    <!-- <input type="text" name="current_model" value="customer" class="hidden"> -->
    <div class="fallback">
        <input type="file" name="file" multiple>
    </div>
    <div id="preview-template" class="hide">
        <div class="dz-preview dz-file-preview">
            <div class="dz-image">
                <img data-dz-thumbnail="" />
            </div>

            <div class="dz-details">
                <div class="dz-size">
                    <span data-dz-size=""></span>
                </div>

                <div class="dz-filename">
                    <span data-dz-name=""></span>
                </div>

                <div class="dz-filename">
                    <span></span>
                </div>
            </div>

            <div class="dz-progress">
                <span class="dz-upload" data-dz-uploadprogress=""></span>
            </div>

            <div class="dz-error-message">
                <span data-dz-errormessage=""></span>
            </div>

            <div class="dz-success-mark">
                <span class="fa-stack fa-lg bigger-150">
                    <i class="fa fa-circle fa-stack-2x white"></i>

                    <i class="fa fa-check fa-stack-1x fa-inverse green"></i>
                </span>
            </div>

            <div class="dz-error-mark">
                <span class="fa-stack fa-lg bigger-150">
                    <i class="fa fa-circle fa-stack-2x white"></i>

                    <i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
                </span>
            </div>
        </div>
    </div>
</form>

<div class="col-lg-12">
    <div class="table-responsive p-0">
        <table id="data-table" class="table table-striped table-bordered table-hover" data-api-download="{{ route('api.admin.asset.download')}}" data-api="{{ route('api.admin.pages.assets.index', $model->getKey())}}">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Image</th>
                    <th>File Size</th>
                    <th>Uploaded Time</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- PAGE CONTENT ENDS -->