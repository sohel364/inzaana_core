@extends('layouts.admin-master') 
@section('title', 'Template View') 
@section('header-style')
 <link href="{{ URL::asset('css/view_template.css') }}" rel="stylesheet" type="text/css">  
@endsection
@section('breadcumb')
<h1>Template
<small>Template View</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Home</a></li>
    <li>Template</li>
    <li class="active">Template view</li>
</ol>
@endsection 

@section('content')

<div class="box box-info">
    <div class="box-header with-border text-center">
        <h1 class="box-title">Pick the website template you love</h1>
    </div>
</div>

<?php
$dirs=scandir("./templates");
for($i=2;$i<sizeof($dirs);$i++)
{       
?>
    <div class="box box-info">
    <div class="box-header with-border text-center">
        <h1 class="box-title ">{{$dirs[$i]}}</h1>
    </div>
<div class="box-body">
      <div class="row">
    <?php 
    $templates=scandir("./templates/$dirs[$i]");    
    for($j=2; $j<sizeof($templates);$j++)
    {
    ?>

    
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="hovereffect">
            <?php 
                $path = "templates/$dirs[$i]/$templates[$j]/preview.jpg"    
            ?>
            
            <img class="img-responsive" src="{{ URL::asset($path) }}">
            <div class="overlay">
                <table id="parent" border="0">
                    <tr>
                        <td id="child" class="text-left"><h2>Price: Free </h2></td>
                        <td id="child" class="text-right"><h2><a class="btn-link" href="">More Info</a></h2></td>
                    </tr>
                </table>
                
                <a class="info btn btn-info btn-flat" href="{{ route('user::templates.editor.browse', [ 'category' => $dirs[$i], 'template'=> $templates[$j] ]) }}">Create Template</a>
                <!-- <a class="info btn btn-info btn-flat" href="#">View</a> -->
            </div>
            <h4>{{ $templates[$j] }}</h4>
              </div>
          </div>
     
    
    <?php 
    }
    ?> 

</div>    
<?php 
}
?>
   </div>
    </div>
@endsection