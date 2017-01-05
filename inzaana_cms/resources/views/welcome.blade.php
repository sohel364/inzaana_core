<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.

                    <form action="/products/import/csv" method="POST" enctype="multipart/form-data" id="js-upload-form">

                        {!! csrf_field() !!}
                        
                        <input type="file" name="csv" id="csv" multiple>
                        <button type="submit" class="btn btn-primary btn-flat">Upload Files</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>