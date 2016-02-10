@extends('layouts.user-admin-master')
@section('title', 'User Dashboard')


@section('content')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left mediaCr">
            <div class="page-title titleEx">
              Inzaana
            </div>
            <div class="page-title hidden-xs">
              | My Profile</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">My Profile</li>
          </ol>
          <div class="clearfix">
          </div>
        </div>
        <!--END TITLE & BREADCRUMB PAGE-->
        <!--BEGIN CONTENT-->
        <div class="page-content">         
          <div id="tab-general">
           <div class="row">
            
             <div class="col-md-12 padB10">
                <div class="alert alert-info alert-dismissable text-center WelcomePanel">
                  <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                  Welcome to your Control Panel! We’ve completed some key tasks to help you get started.
                </div>
              </div>
                <div class="col-md-12 padB10 text-right">
                <a class="btn btn-info btn-lg">Balance: 100$</a>
              </div>
            
             <div class="col-lg-6">
                    <div class="panel panel-blue" style="background:#FFF;">
                        <div class="panel-heading">Personal Info</div>
                        <div class="panel-body">
                            <table class="table table-hover">
                             <thead>
                                   <tr>
                                   <th>Name:</th>
                                   <th>Shrabon Mohsin</th>
                                   <th><a href="#">Edit</a> </th>
                               </tr>
                               <tr>
                                   <th>Email:</th>
                                   <th>demo@yourmain.com</th>
                                   <th><a href="#">Edit</a> </th>
                               </tr>
                               <tr>
                                   <th>Phone:</th>
                                   <th>09876544321</th>
                                   <th><a href="#">Edit</a> </th>
                               </tr>
                             </thead>
                            </table>
                        </div>
                    </div>                    
                </div>
            <div class="col-lg-6">
                <div class="panel panel-blue" style="background:#FFF;">
                    <div class="panel-heading">Shipping Info</div>
                    <div class="panel-body">
                        <table class="table table-hover">
                         <thead>
                               <tr>
                               <th>Name:</th>
                               <th>Shrabon Mohsin</th>  
                               <th><a href="#">Edit</a> </th>
                           </tr>
                           <tr>
                               <th>Email:</th>
                               <th>demo@yourmain.com</th>  
                               <th><a href="#">Edit</a> </th>
                           </tr>
                           <tr>
                               <th>Phone:</th>
                               <th>09876544321</th>  
                               <th><a href="#">Edit</a> </th>
                           </tr>
                         </thead>
                        </table>
                    </div>
                </div>               
            </div>
         </div>
           
            <div class="row mbl animatedParent">
             
              
              <!--Card-->
              <div class="col-lg-12">
                <div class=" CardBoard1">
                  <div class="col-md-9 vertical-alignment">
                    <div class="media noMarPad">
                      <div class="media-left media-middle">
                        <a href="#">
                          <span class="fa fa-money cardIcon1" aria-hidden="true"></span>
                        </a>
                      </div>
                      <div class="media-body padL10">
                        <h2 class="media-heading CardHeading">Add a payment method!</h2>
                        <h4 class="padT20 cardPara">You can add a payment method to get paid from your Customers! </h4>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 hoverOff">
                    <div class="form-actions text-right pal ">
                      <button type="submit" class="btn btn-lg btn-info animated fadeIn">
                        Add Payment Method
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!--End of Card-->
              
              <!--Some Usefull link-->
              <div class="col-md-12 WelcomePanelPlus">
                <div class="alert CardPanel">
                  Want some more? See these links to speedup your business!
                </div>
                <div class="useful-link CardPanel">
                  <ul>
                    <li><a href="#">How can i change theme of my sore?</a></li>
                    <li><a href="#">How can i change theme of my sore?</a></li>
                    <li><a href="#">How can i change theme of my sore?</a></li>
                    <li><a href="#">How can i change theme of my sore?</a></li>
                    <li><a href="#">How can i change theme of my sore?</a></li>
                    <li><a href="#">How can i change theme of my sore?</a></li>
                    <li><a href="#">How can i change theme of my sore?</a></li>
                  </ul>
                </div>
              </div>
              <!--End of Some Usefull link-->

            </div>
          </div>
        </div>
        <!--END CONTENT-->
@endsection