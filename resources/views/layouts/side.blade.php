@guest

@else
<aside class="left-sidebar bg-sidebar">
  <div id="sidebar" class="sidebar sidebar-with-footer">
    <!-- Aplication Brand -->
    <div class="app-brand">
      <a href="{{ route('home') }}">
        <svg
          class="brand-icon"
          xmlns="http://www.w3.org/2000/svg"
          preserveAspectRatio="xMidYMid"
          width="30"
          height="33"
          viewBox="0 0 30 33"
        >
          <g fill="none" fill-rule="evenodd">
            <path
              class="logo-fill-blue"
              fill="#7DBCFF"
              d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
            />
            <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
          </g>
        </svg>
        <span class="brand-name text-truncate">Inventory</span>
      </a>
    </div>
    <!-- begin sidebar scrollbar -->
    <div class="sidebar-scrollbar">

      <!-- sidebar menu -->
      <ul class="nav sidebar-inner" id="sidebar-menu">
        
        <li  class="has-sub {{ set_active('home')}} expand" >
          <a class="sidenav-item-link" href="{{ route('home') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span class="nav-text">Dashboard</span> 
          </a>
        </li>
          
        <!-- <li  class="has-sub" >
          <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#app"
            aria-expanded="false" aria-controls="app">
            <i class="mdi mdi-pencil-box-multiple"></i>
            <span class="nav-text">Transaksi</span> <b class="caret"></b>
          </a>
          <ul  class="collapse"  id="app" data-parent="#sidebar-menu">
            <div class="sub-menu">   
              <li >
                <a class="sidenav-item-link" href="#">
                  <span class="nav-text">Pembelian</span>
                  
                </a>
              </li>
              <li >
                <a class="sidenav-item-link" href="#">
                  <span class="nav-text">Penjualan</span>
                </a>
              </li> 
            </div>
          </ul>
        </li> -->

        <!-- <li  class="has-sub {{ set_active('transaksi.index') }}" >
          <a class="sidenav-item-link" href="{{ route('transaksi.index') }}">
            <i class="mdi mdi-pencil-box-multiple"></i>
            <span class="nav-text">Transaksi</span> <b class="caret"></b>
          </a>
        </li> -->
        @if (Auth::user()->level !== 'gudang') 
        <li  class="has-sub {{ set_active(['item.index', 'supplier.index']) }}" >
          <a class="sidenav-item-link" href="#"  data-toggle="collapse" data-target="#app"
            aria-expanded="false" aria-controls="app">
            <i class="mdi mdi-folder-multiple-outline"></i>
            <span class="nav-text">Master Data</span> <b class="caret"></b>
          </a>
          <ul  class="collapse"  id="app" data-parent="#sidebar-menu">
            <div class="sub-menu"> 
             <li class="{{ set_active('item.index') }}">
                <a class="sidenav-item-link" href="{{ route('item.index') }}">
                  <i class="mdi mdi-folder-multiple-outline mr-1"></i>
                  <span class="nav-text">Data Barang</span>
                </a>
              </li>

              <li class="{{ set_active('supplier.index') }}">
               
                <a class="sidenav-item-link" href="{{ route('supplier.index') }}">
                   <i class="mdi mdi-account-switch mr-1"></i>
                  <span class="nav-text">Data Supplier</span>
                  
                </a>
              </li>

            </div>
          </ul>
        </li>
        @endif

        <li  class="has-sub {{ set_active(['penjualan.index', 'pembelian.index']) }}" >
          <a class="sidenav-item-link" href="#"  data-toggle="collapse" data-target="#detail"
            aria-expanded="false" aria-controls="app">
            <i class="mdi mdi-folder-multiple-outline"></i>
            <span class="nav-text">Transaksi</span> <b class="caret"></b>
          </a>
          <ul  class="collapse"  id="detail" data-parent="#sidebar-menu">
            <div class="sub-menu"> 
            <!--  <li class="{{ set_active('item.index') }}">
                <a class="sidenav-item-link" href="{{ route('item.index') }}">
                  <i class="mdi mdi-folder-multiple-outline mr-1"></i>
                  <span class="nav-text">Data Barang</span>
                </a>
              </li> -->

              <li class="{{ set_active('pembelian.index') }}">
               
                <a class="sidenav-item-link" href="{{ route('pembelian.index') }}">
                   <i class="mdi mdi-cart mr-1"></i>
                  <span class="nav-text">Data Pembelian</span>
                  
                </a>
              </li>
              <li class="{{ set_active('penjualan.index') }}">
               
                <a class="sidenav-item-link" href="{{ route('penjualan.index') }}">
                    <i class="mdi mdi-sale mr-1"></i>
                  <span class="nav-text">Data Penjualan</span>
                </a>
              </li> 
            </div>
          </ul>
        </li>
        @if (Auth::user()->level === 'pemilik') 
        <li  class="has-sub {{ set_active('user.index') }}" >
          <a class="sidenav-item-link" href="{{ route('user.index') }}">
            <i class="mdi mdi-diamond-stone"></i>
            <span class="nav-text">Pengguna</span> <b class="caret"></b>
          </a>
        </li>
        @endif

        <li  class="has-sub {{ set_active('sampah.index') }}" >
          <a class="sidenav-item-link" href="{{ route('sampah.index') }}">
            <i class="mdi mdi-email-mark-as-unread"></i>
            <span class="nav-text">Sampah</span> <b class="caret"></b>
          </a>
        </li>
           
      </ul>

    </div>
  <!--   <div class="sidebar-footer">
      <hr class="separator mb-0" />
      <div class="sidebar-footer-content">
        <h6 class="text-uppercase">
          Cpu Uses <span class="float-right">40%</span>
        </h6>
        <div class="progress progress-xs">
          <div
            class="progress-bar active"
            style="width: 40%;"
            role="progressbar"
          ></div>
        </div>
        <h6 class="text-uppercase">
          Memory Uses <span class="float-right">65%</span>
        </h6>
        <div class="progress progress-xs">
          <div
            class="progress-bar progress-bar-warning"
            style="width: 65%;"
            role="progressbar"
          ></div>
        </div>
      </div>
    </div> -->

  </div>
</aside>
@endguest