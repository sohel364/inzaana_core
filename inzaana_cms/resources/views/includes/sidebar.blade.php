<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-list"></i>
                <span>Categories</span> <small class="label bg-green">120</small>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-plus"></i> Add New Category</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> List All Categories</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i> <span>Products</span> <small class="label bg-green">1717</small>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
                <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-plus"></i> Add New Product</a></li>
                <li><a href="#"><i class="fa  fa-filter"></i> Filter Tags</a></li>
                <li><a href="#"><i class="fa  fa-list-ol"></i> List All Products</a></li>
                <li><a href="#"><i class="fa  fa-angle-double-down"></i> Low Stock Products</a></li>
                <li><a href="#"><i class="fa  fa-diamond"></i> Brands <small class="label bg-green">300</small></a></li>
                <li><a href="#"><i class="fa  fa-comments"></i> Reviews <small class="label bg-green">5</small></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-question-circle"></i>
                <span>FAQ</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/charts/chartjs.html"><i class="fa fa-question"></i> FAQ</a></li>
                <li><a href="pages/charts/morris.html"><i class="fa fa-list-ol"></i> FAQ Category</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Orders</span> <small class="label bg-green">200</small>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-list-ol"></i> List All Order</a></li>
                <li><a href="#"><i class="fa fa-paper-plane"></i> Processing Orders <small class="label bg-orange">35</small></a></li>
                <li><a href="#"><i class="fa fa-check"></i> Complete Orders <small class="label bg-green">20</small></a></li>
                <li><a href="#"><i class="fa fa-exclamation-triangle"></i> Returns <small class="label bg-red">5</small></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> 
                <span>Customers</span> <small class="label bg-green">700</small>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-check-square"></i> Registered Customer</a></li>
                <li><a href="#"><i class="fa fa-users"></i> Customer Groups <small class="label bg-orange">3</small></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-barcode"></i> 
                  <span>Coupons</span> <small class="label bg-blue">700</small>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-plus-square"></i> Add New Coupons</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> List All Coupons</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-sliders"></i> <span>Taxes</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
                
                <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-list-ol"></i> Text Categories <small class="label bg-orange">3</small></a></li>
                <li><a href="#"><i class="fa fa-money"></i> Tex Rates <small class="label bg-red">3</small></a></li>
                </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-globe"></i> <span> Localisation</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
                <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-map-marker"></i> Locations</a></li>
                <li><a href="#"><i class="fa fa-language"></i> Languages <small class="label bg-green">2</small></a></li>
                <li><a href="#"><i class="fa fa-money"></i> Currencies <small class="label bg-green">2</small></a></li>
                <li><a href="#"><i class="fa fa-pie-chart"></i> Stock Statuses <small class="label bg-orange">5</small></a></li>
                <li><a href="#"><i class="fa fa-cart-arrow-down"></i> Order Statuses <small class="label bg-blue">15</small></a></li>
                </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-file"></i> <span>Promotional Pages</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-plus"></i> Add New Page</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> List All Pages</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-file-code-o">
                </i> <span> Pages</span> <small class="label bg-green">13</small>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-plus"></i> Add New Page</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> List All Pages</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-plug">
                </i> <span>  Extensions</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-plus"></i> Modules</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> Shipping</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> Payments</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> Order Totals</a></li>
                <li><a href="#"><i class="fa fa-list-ol"></i> Product Feeds</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cart-plus">
                </i> <span> Sales</span> 
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-envelope-o"></i> Mail</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-user-secret">
                </i> <span> Authority</span> 
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-user"></i> Authority <small class="label bg-red">3</small> </a></li>
                <li><a href="#"><i class="fa fa-group"></i> Authority Groups <small class="label bg-red">7</small></a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cube">
                </i> <span>  Inventory & Stock Manager</span> 
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-sitemap"></i> Manage Inventory</a></li>
                <li><a href="#"><i class="fa fa-angle-double-down"></i> Low Stock Products</a></li>
                <li><a href="#"><i class="fa fa-barcode"></i> Barcode Generator</a></li>
                <li><a href="#"><i class="fa fa-cart-plus"></i> Purchase Orders</a></li>
                <li><a href="#"><i class="fa fa-bar-chart"></i> Statistics</a></li>
                <li><a href="#"><i class="fa fa-history"></i> History</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-desktop">
                </i> <span> Point Of Sale</span> 
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle"></i> POS</a></li>
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Multilevel</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                    <li>
                      <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                      <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
              </ul>
            </li>
            <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>