<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active ">
          <a href="<?=base_url('home')?>">
            <i class="fa fa-home"></i> <span>HOME</span>
          </a>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-podcast"></i>
            <span>MASTER</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('branch')?>">&nbsp;&nbsp;&nbsp;<i class="fa fa-building"></i> Branch </a></li>
            <li><a href="<?=base_url('product')?>">&nbsp;&nbsp;&nbsp;<i class="fa fa-cart-plus"></i> Product </a></li>
            <li><a href="<?=base_url('customer')?>">&nbsp;&nbsp;&nbsp;<i class="fa fa-users"></i> Customer </a></li>
            <li><a href="<?=base_url('supplier')?>">&nbsp;&nbsp;&nbsp;<i class="fa fa-user-circle"></i> Supplier </a></li>
          </ul>
        </li>
         <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart"></i>
            <span>PURCHASE & SALES</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('purchase')?>">&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o"></i> Purchase</a></li>
            
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>