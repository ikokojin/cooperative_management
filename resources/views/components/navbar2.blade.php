<nav id="dashboard-nav"
    class="tw:flex justify-content-between align-items-center tw:w-[100%] tw:h-[80px] tw:bg-[#ffffff]">
    <div class="nav-logo">
        {{-- <h2 class="m-0" style="font-size: 25px">LOGO</h2> --}}
        <!-- <img src="images/logo2.png" width="50px" height="50px" style="border-radius: 50%" alt="">
        <h3>KPMPCATS</h3> -->
        {{-- <h2 class="mw-100 m-0" style="font-size: 14px; width: 200px;">Kingsland Pala-Pala MPC & Transport Service
        </h2> --}}

        <!-- <div class="nav-menu">
            <i class="fa fa-bars" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu1"
                aria-controls="staticBackdrop"></i>
        </div> -->

        <!-- <i class="fa fa-bars" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu1"
                aria-controls="staticBackdrop"></i> -->
        <button class="collapse-button" onclick="toggleSidebar()">
            <i class="fa fa-bars"></i>
        </button>

        <!-- <h5>Good day, {{ $username }} <span>Here's your overview</span></h5> -->
    </div>

    <!-- <div class="nav-list nav-list2">
        <ul class="tw:flex tw:gap-x-[4rem] m-0 p-0">
            <li class="tw:list-none">
                <a href="{{ route("MemberPortal") }}"
                    class="tw:no-underline tw:text-[15.5px] text-decoration-none">Home</a>
            </li>

            <li class="tw:list-none">
                <a href="{{ route("LoanApplication") }}"
                    class="tw:no-underline tw:text-[15.5px] text-decoration-none">Loan Application</a>
            </li>

            <li class="tw:list-none">
                <a href="{{ route("LoanStatus") }}"
                    class="tw:no-underline tw:text-[15.5px] text-decoration-none">Loan
                    Status</a>
            </li>

            <li class="tw:list-none">
                <a href="{{ route("ShareCapitalMember") }}"
                    class="tw:no-underline tw:text-[15.5px] text-decoration-none">Share Capital</a>
            </li>

            <li class="tw:list-none">
                <a href="{{ route("savings.index") }}"
                    class="tw:no-underline tw:text-[15.5px] text-decoration-none">Savings</a>
            </li>
        </ul>
    </div> -->

    <div class="nav-menu">
        <i class="fa fa-bars" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu2"
            aria-controls="staticBackdrop"></i>
    </div>

    <div class="nav-acc2" id="nav-acc2">
        <ul class="m-0 p-0">
            <div class="nb-notif-wrap">
                <button type="button" onclick="toggleNavNotif(event)"
                    style="background:none; border:none; cursor:pointer; position:relative; padding:4px; display:flex; align-items:center;">
                    <i class="fa-solid fa-bell" style="font-size: 17px; color: var(--muted);"></i>
                    @if($navNotifications->count() > 0)
                        <span
                            style="position:absolute; top:-4px; right:-4px; background:#dc2626; color:#fff; font-size:10px; font-weight:700; min-width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center; padding:0 3px; line-height:1;">
                            {{ $navNotifications->count() }}
                        </span>
                    @endif
                </button>

                <div id="nb-notif-panel">
                    <div
                        style="padding:14px 16px; border-bottom:1px solid #f0f0f0; font-weight:700; font-size:14px; color:#1a1a1a;">
                        Notifications
                    </div>
                    <div style="max-height:360px; overflow-y: scroll;">
                        @forelse($navNotifications as $n)
                            <div style="display:flex; gap:10px; padding:12px 16px; border-bottom:1px solid #f5f5f5;">
                                <div
                                    style="width:32px; height:32px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; background: {{ $n['color'] === 'red' ? '#fee2e2' : ($n['color'] === 'gold' ? '#fef3c7' : '#d1fae5') }};">
                                    <i class="fa-solid {{ $n['icon'] }}"
                                        style="font-size:13px; color: {{ $n['color'] === 'red' ? '#dc2626' : ($n['color'] === 'gold' ? '#b45309' : '#059669') }};"></i>
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <p style="margin:0; font-size:13px; font-weight:600; color:#1a1a1a;">{{ $n['title'] }}
                                    </p>
                                    <p style="margin:2px 0 0; font-size:12px; color:#666; line-height:1.4;">
                                        {{ $n['message'] }}</p>
                                    <p style="margin:4px 0 0; font-size:11px; color:#999;">{{ $n['time'] }}</p>
                                </div>
                            </div>
                        @empty
                            <div style="padding:30px 16px; text-align:center; color:#999; font-size:13px;">
                                <i class="fa-regular fa-bell-slash"
                                    style="font-size:20px; display:block; margin-bottom:8px; opacity:0.5;"></i>
                                No notifications right now.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <script>
                function toggleNavNotif(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const panel = document.getElementById('nb-notif-panel');
                    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
                }

                document.addEventListener('click', function (e) {
                    const panel = document.getElementById('nb-notif-panel');
                    const wrap = document.querySelector('.nb-notif-wrap');
                    if (panel && wrap && !wrap.contains(e.target) && panel.style.display === 'block') {
                        panel.style.display = 'none';
                    }
                });
            </script>
            @if(auth()->user()?->isAlliedWorker())
            <li class="tw:list-none" style="align-self:center; margin-right:12px;">
                <button type="button" onclick="openAwSwitch()"
                    style="background:#1D4ED8; color:#fff; border:none; border-radius:8px; padding:9px 15px; font-size:13px; font-weight:600; cursor:pointer;">
                    <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right:6px;"></i>Switch to Allied Worker
                </button>
            </li>
            @endif
            <li>
                <a href="#" onclick="toggleDropdown(event)"
                    class="tw:flex tw:justify-center tw:items-center tw:gap-x-[0.7rem] position-relative">
                    <div class="first-last">
                        <p>{{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}</p>
                    </div>
                    <div class="name-email">
                        <p>
                            {{ auth()->user()->first_name ?? '' }}
                            <!-- {{ auth()->user()->last_name ?? '' }} -->
                        </p>
                        <!-- <p>
                            {{ auth()->user()->email ?? '' }}
                        </p> -->
                    </div>

                </a>
                <!-- @if ($username)
                    @php
                        $userId = Auth::id();
                        $navOtherinfo = \App\Models\Otherinfo_tbl::where('user_id', $userId)->first();
                        $navMembergovernIds = \App\Models\Membergovern_ids_tbl::where('user_id', $userId)->first();
                        $navMissingCount = 0;
                        if ($navOtherinfo && empty($navOtherinfo->contact_no))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->present_address))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->permanent_address))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->date_of_birth))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->place_of_birth))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->sex))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->civil_status))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->citizenship))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->blood_type))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->height))
                            $navMissingCount++;
                        if ($navOtherinfo && empty($navOtherinfo->weight))
                            $navMissingCount++;
                        if ($navMembergovernIds && empty($navMembergovernIds->sss_id))
                            $navMissingCount++;
                        if ($navMembergovernIds && empty($navMembergovernIds->philhealth_id))
                            $navMissingCount++;
                        if ($navMembergovernIds && empty($navMembergovernIds->pagibig_id))
                            $navMissingCount++;
                        if ($navMembergovernIds && empty($navMembergovernIds->tin_id))
                            $navMissingCount++;
                    @endphp
                    <a href="#" onclick="toggleDropdown(event)"
                        class="tw:flex tw:justify-center tw:items-center tw:gap-x-[0.7rem] position-relative">
                        <div class="first-last">
                            <p>{{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}</p>
                        </div>
                        <p style="margin: 0">
                            {{ auth()->user()->first_name ?? '' }}
                        </p>
                        @if($navMissingCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 12px; padding: 4px 8px;">
                                {{ $navMissingCount }}
                            </span>
                        @endif
                        <i class="fa fa-chevron-down"></i>
                    </a>
                @endif -->

                <ul>
                    @if($email)
                        <li>
                            <div class="card-icon">
                                <p>{{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}</p>
                            </div>
                            <p>{{ $email }}</p>
                        </li>
                    @endif
                    <hr>
                    <li style="position: relative;">
                        <div class="card-icon"><i class="fa fa-user"></i></div>
                        <a href="{{ route('ProfileMember') }}">Profile</a>
                        @if($navMissingCount > 0)
                            <span class="start-50 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 12px; padding: 4px 8px;">
                                {{ $navMissingCount }}
                            </span>
                        @endif
                    </li>
                    <li>
                        <div class="card-icon"><i class="fa fa-lock"></i></div>
                        <a href="#">Reset Password</a>
                    </li>
                    <li>
                        <div class="card-icon"><i class="fa fa-sign-out"></i></div>
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <script>
        function toggleDropdown(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('nav-acc2').classList.toggle('open');
        }

        // document.addEventListener('click', function (e) {
        //     const wrap = document.getElementById('nav-acc2');
        //     if (!wrap.contains(e.target)) {
        //         wrap.classList.remove('open');
        //     }
        // });
    </script>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const rightbar = document.querySelector('.rightbar');

            sidebar.classList.toggle('collapsed');
            rightbar.classList.toggle('expanded');
        }
    </script>

    @if(auth()->user()?->isAlliedWorker())
    <div id="awSwitchModal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:14px; padding:24px; width:94%; max-width:400px; box-shadow:0 10px 40px rgba(0,0,0,0.2);">
            <h3 style="margin:0 0 4px; font-size:17px; color:#1a1a1a;">Switch to Allied Worker</h3>
            <p style="margin:0 0 18px; font-size:13px; color:#666;">Confirm your password to work as an Allied Worker. Your member account stays intact.</p>
            <form action="{{ route('allied-workers.switch-to-aw') }}" method="POST">
                @csrf
                <input type="password" name="password" required placeholder="Enter your password"
                    style="width:100%; padding:11px 13px; border:1px solid #ddd; border-radius:8px; font-size:14px; margin-bottom:14px;">
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="closeAwSwitch()" style="padding:9px 14px; border:1px solid #ddd; border-radius:8px; background:#fff; color:#333; font-size:13px; cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:9px 16px; border:none; border-radius:8px; background:#1D4ED8; color:#fff; font-size:13px; font-weight:600; cursor:pointer;">Switch Mode</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openAwSwitch() { document.getElementById('awSwitchModal').style.display = 'flex'; }
        function closeAwSwitch() { document.getElementById('awSwitchModal').style.display = 'none'; }
    </script>
    @endif

</nav>
