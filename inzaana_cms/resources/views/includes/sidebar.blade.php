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
              <p>{{ Auth::user()->name }}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search-btn" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <!--<li class="header">MAIN NAVIGATION</li>-->
            <li class="active treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-list"></i>
                <span>Categories <small class="label bg-green">{{ Inzaana\Category::count() }}</small></span> 
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ route('user::categories') }}"><i class="fa fa-plus"></i> Add New Category</a></li>
                <li><a href="{{ route('user::categories') }}"><i class="fa fa-list-ol"></i> List All Categories</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cubes"></i> <span>Products <small class="label bg-green">{{ Auth::user()->products->count() }}</small></span> 
                <i class="fa fa-angle-left pull-right"></i>
              </a>
                <ul class="treeview-menu">
                <li><a href="/products"><i class="fa fa-plus"></i> Add New Product</a></li>
                <li><a href="/products"><i class="fa  fa-filter"></i> Filter Tags</a></li>
                <li><a href="/products"><i class="fa  fa-list-ol"></i> List All Products</a></li>
                <li><a href="/products"><i class="fa  fa-angle-double-down"></i> Low Stock Products</a></li>
                <li><a href="/products"><i class="fa  fa-diamond"></i> Brands <small class="label bg-green">300</small></a></li>
                <li><a href="/products"><i class="fa  fa-comments"></i> Reviews <small class="label bg-green">5</small></a></li>
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
                <span>Orders <small class="label bg-green">200</small></span> 
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
                <span>Customers <small class="label bg-green">700</small></span> 
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
                  <span>Coupons <small class="label bg-blue">700</small></span> 
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
                </i> <span> Pages <small class="label bg-green">13</small></span> 
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
                <li><a href="#"><i class="fa fa-magnet"></i> Modules</a></li>
                <li><a href="#"><i class="fa fa-ship"></i> Shipping</a></li>
                <li><a href="#"><i class="fa fa-credit-card"></i> Payments</a></li>
                <li><a href="#"><i class="fa fa-reorder"></i> Order Totals</a></li>
                <li><a href="#"><i class="fa fa-bicycle"></i> Product Feeds</a></li>
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
                <i class="fa fa-cog"></i> <span>System</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="#"><i class="fa fa-recycle"></i> Clear Cache(s) <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> All (Less Images)</a></li>
                    <li><a href="#"><i class="fa fa-image"></i> All (Plus Images)</a></li>
                    <li><a href="#"><i class="fa fa-asterisk"></i> VQMod Cache</a></li>
                    <li><a href="#"><i class="fa fa-file-image-o"></i> Image Cache</a></li>
                    <li><a href="#"><i class="fa fa-cogs"></i> System Cache</a></li>
                    <li><a href="#"><i class="fa fa-arrows-h"></i> Minify Cache</a></li>
                    <li><a href="#"><i class="fa fa-search-plus"></i> SEO cache</a></li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
                <li><a href="#"><i class="fa fa-link"></i> SEO URL</a></li>
                <li><a href="#"><i class="fa fa-clock-o"></i> Timeslot</a></li>
                <li>
                    <a href="#"><i class="fa fa-image"></i> Design <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-link"></i> Footer links</a></li>
                    <li><a href="#"><i class="fa fa-desktop"></i> Layouts <small class="label bg-green">12</small></a></li>
                    <li><a href="#"><i class="fa fa-square"></i> Banners <small class="label bg-green">2</small></a></li>
                    <li><a href="#"><i class="fa fa-stop"></i> Sliders <small class="label bg-green">6</small></a></li>
                  </ul>
                </li>
                  <li><a href="#"><i class="fa fa-bug"></i> Error Logs</a></li>
                  <li><a href="#"><i class="fa fa-suitcase"></i> Backup/Restore</a></li>
                  <li>
                      <a href="#"><i class="fa fa-exchange"></i> Export/Import <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-user-md"></i> Master</a></li>
                    <li><a href="#"><i class="fa fa-database"></i> Stock Data </a></li>
                  </ul>
                  </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-line-chart"></i> <span>Reports</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> ADV Orders & Profit</a></li>
                <li>
                  <a href="#"><i class="fa fa-cart-plus"></i> Sales <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-shopping-cart"></i> Orders</a></li>
                    <li><a href="#"><i class="fa fa-money"></i> Tax</a></li>
                    <li><a href="#"><i class="fa fa-ship"></i> Shipping</a></li>
                    <li><a href="#"><i class="fa fa-hand-o-down"></i> Returns</a></li>
                    <li><a href="#"><i class="fa fa-barcode"></i> Coupons</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#"><i class="fa fa-cubes"></i> Products <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-desktop"></i> Viewed</a></li>
                    <li><a href="#"><i class="fa fa-credit-card"></i> Purchased</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#"><i class="fa fa-users"></i> Customers <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-shopping-cart"></i> Orders</a></li>
                    <li><a href="#"><i class="fa fa-usd"></i> Reward Points</a></li>
                    <li><a href="#"><i class="fa fa-google-wallet"></i> Wallet</a></li>
                  </ul>
                </li>
                <li>
                  <a href="#"><i class="fa  fa-user-plus"></i> Affiliates <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-star-half-empty"></i> Commission</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class=" treeview">
      			  <a href="{{ route('user::templates') }}">
        				<span>Template View</span>
        				<i class="fa fa-angle-left pull-right"></i>
      			  </a>
      			  <ul class="treeview-menu">
      				  @include('editor.template-list-view')
      			  </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>