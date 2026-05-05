<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            {{-- <span class="app-brand-logo demo">
                <img src="/fms/public/sneat/assets/img/fathania.png" alt="Logo"width="50">
            </span> --}}
            <span class="app-brand-text demo menu-text fw-bolder ms-2">SiPAM</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    @php
        $role = auth()->user()->role->name ?? null;
    @endphp

    <ul class="menu-inner py-1">

        <!-- Home -->
        <li class="menu-item @yield('home_active')">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Home</div>
            </a>
        </li>

        <!-- Transaksi -->
        <li class="menu-item @yield('transaksi_active')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>Transaksi</div>
            </a>
            <ul class="menu-sub">

                @if (in_array($role, ['Ketua Paguyuban', 'PJ Air & Sampah', 'Admin Air & Sampah', 'Bendahara Paguyuban', 'IT']))
                    <li class="menu-item @yield('payment_active')">
                        <a href="{{ route('payment.index') }}" class="menu-link">
                            <div>Pembayaran</div>
                        </a>
                    </li>
                @endif

            </ul>
        </li>

        <li class="menu-item @yield('laporan_active')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div>Laporan</div>
            </a>
            <ul class="menu-sub">

                {{-- BUKU BESAR (Owner) --}}
                {{-- @if (in_array($role, ['Owner']))
                    <li class="menu-item @yield('ledger_active')">
                        <a href="{{ route('ledger.index') }}" class="menu-link">
                            <div>Buku Besar</div>
                        </a>
                    </li>
                @endif --}}

            </ul>
        </li>

        <!-- Master -->
        <li class="menu-item @yield('master_active')">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-folder"></i>
                <div>Master</div>
            </a>
            <ul class="menu-sub">

                @if ($role === 'IT')
                    <li class="menu-item @yield('user_active')">
                        <a href="{{ route('user.index') }}" class="menu-link">
                            <div>User</div>
                        </a>
                    </li>
                @endif

                @if (in_array($role, ['Ketua Paguyuban', 'Sekretaris Paguyuban', 'IT']))
                    <li class="menu-item @yield('resident_active')">
                        <a href="{{ route('resident.index') }}" class="menu-link">
                            <div>Warga</div>
                        </a>
                    </li>
                @endif

                @if (in_array($role, ['Ketua Paguyuban', 'Bendahara Paguyuban', 'IT']))
                    <li class="menu-item @yield('gateway_active')">
                        <a href="{{ route('gateway.index') }}" class="menu-link">
                            <div>Gateway</div>
                        </a>
                    </li>
                @endif

            </ul>
        </li>

    </ul>
</aside>
