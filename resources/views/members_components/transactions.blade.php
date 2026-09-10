<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>

    {{-- AOS animation link css --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- css link --}}
    <link rel="stylesheet" href="css_folder/transactions.css">
    <link rel="stylesheet" href="css_folder/loading.css">

    {{-- bootstrap and tailwind link --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/csp-events.js') }}"></script>

    {{-- font awesome cdn link --}}
    <link rel="stylesheet" href="font-awesome-icon/css/all.min.css">
</head>

<body>
    <div class="container-fluid p-0 m-0">
        @include("components.sidebar")

        <div class="rightbar">
            @include("components.navbar2")

            <div class="main-parent">
                <div class="main-header">
                    <h3>Transactions</h3>
                    <p>Every entry posted to your share capital, savings and loan accounts</p>
                </div>

                <div class="main-body">
                    <div class="card-box-parent">
                        <div class="card-box">
                            <div class="card-header">
                                <div class="sum-label">Total Deposits</div>
                                <div class="sum-icon"><i class="fa fa-wallet"></i></div>
                            </div>
                            <div class="card-body">
                                <div class="sum-value">₱{{ number_format($totalDeposits, 2) }}</div>
                                <div class="sum-stat"></div>
                            </div>
                            <span>Total amount deposited</span>
                        </div>

                        <div class="card-box">
                            <div class="card-header">
                                <div class="sum-label">Total Repayments</div>
                                <div class="sum-icon"><i class="fa fa-money-bill-transfer"></i></div>
                            </div>
                            <div class="card-body">
                                <div class="sum-value">₱{{ number_format($totalRepayments, 2) }}</div>
                                <div class="sum-stat"></div>
                            </div>
                            <span>Total loan repayments made</span>
                        </div>

                        <div class="card-box">
                            <div class="card-header">
                                <div class="sum-label">Transact this month</div>
                                <div class="sum-icon"><i class="fa fa-receipt"></i></div>
                            </div>
                            <div class="card-body">
                                <div class="sum-value">₱{{ number_format($transactThisMonth, 2) }}</div>
                                <div class="sum-stat"></div>
                            </div>
                            <span>Transactions recorded</span>
                        </div>

                        <div class="card-box">
                            <div class="card-header">
                                <div class="sum-label">Net Change</div>
                                <div class="sum-icon"><i class="fa fa-chart-line"></i></div>
                            </div>
                            <div class="card-body">
                                <div class="sum-value">₱{{ number_format($netChange, 2) }}</div>
                                <div class="sum-stat"></div>
                            </div>
                            <span>Overall balance change</span>
                        </div>
                    </div>

                    <div class="filters">
                        <div class="tab-group">
                            <a href="{{ route('transactions', array_merge(request()->except('type', 'page'), ['type' => 'all'])) }}"
                                class="tab {{ $type === 'all' ? 'active' : '' }}">All</a>
                            <a href="{{ route('transactions', array_merge(request()->except('type', 'page'), ['type' => 'share_capital'])) }}"
                                class="tab {{ $type === 'share_capital' ? 'active' : '' }}">Share Capital</a>
                            <a href="{{ route('transactions', array_merge(request()->except('type', 'page'), ['type' => 'savings'])) }}"
                                class="tab {{ $type === 'savings' ? 'active' : '' }}">Savings</a>
                            <a href="{{ route('transactions', array_merge(request()->except('type', 'page'), ['type' => 'loans'])) }}"
                                class="tab {{ $type === 'loans' ? 'active' : '' }}">Loans</a>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('transactions') }}" class="toolbar" id="tx-filter-form">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Search by description or reference no.">
                        </div>
                        <input type="date" class="filter-select" name="date" value="{{ $date }}"
                            data-action="tx-submit-filter">
                        <select class="filter-select " name="status"
                            data-action="tx-submit-filter">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All statuses</option>
                            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </form>

                    <div class="ledger-page overflow-x-auto">
                        <div class="table-scroll-wrapper">
                            <table class="tx-table table table-scroll m-0">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Reference No.</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="num">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $tx)
                                        <tr>
                                            <td>
                                                <div class="tx-desc-cell">
                                                    <div class="tx-icon {{ $tx['icon'] }}"><i
                                                            class="fa-solid {{ $tx['icon_fa'] }}"></i></div>
                                                    <div class="tx-desc">
                                                        <strong>{{ $tx['title'] }}</strong>
                                                        <span>{{ $tx['subtitle'] }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="tx-ref">{{ $tx['reference_no'] }}</td>
                                            <td class="tx-date">{{ $tx['date_display'] }}<br>{{ $tx['time_display'] }}</td>
                                            <td><span
                                                    class="status-chip {{ $tx['status_class'] }}">{{ $tx['status_label'] }}</span>
                                            </td>
                                            <td class="tx-amt {{ $tx['amount'] >= 0 ? 'up' : 'down' }}">
                                                {{ $tx['amount'] >= 0 ? '+' : '-' }}₱{{ number_format(abs($tx['amount']), 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5"
                                                style="text-align:center; color:#aaa; padding:2rem; font-size:13px;">
                                                <i class="fa fa-inbox"
                                                    style="font-size:24px; display:block; margin-bottom:8px;"></i>
                                                No transactions found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            <span>Showing {{ $transactions->lastItem() ?? 0 }} of
                                {{ $transactions->total() }} transactions</span>
                            <div class="page-btns">
                                @if($transactions->onFirstPage())
                                    <span class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i></span>
                                @else
                                    <a href="{{ $transactions->previousPageUrl() }}" class="page-btn"><i
                                            class="fa-solid fa-chevron-left"></i></a>
                                @endif

                                @foreach(range(1, $transactions->lastPage()) as $p)
                                    <a href="{{ $transactions->url($p) }}"
                                        class="page-btn {{ $p === $transactions->currentPage() ? 'active' : '' }}">{{ $p }}</a>
                                @endforeach

                                @if($transactions->hasMorePages())
                                    <a href="{{ $transactions->nextPageUrl() }}" class="page-btn"><i
                                            class="fa-solid fa-chevron-right"></i></a>
                                @else
                                    <span class="page-btn disabled"><i class="fa-solid fa-chevron-right"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ csp_nonce() }}">
        (function () {
            var A = window.CSP_actions;
            if (!A) return;
            A.register('tx-submit-filter', function (e, el) { document.getElementById('tx-filter-form').submit(); });
        })();

        const searchInput = document.querySelector('.search-box input[name="search"]');
        const filterForm = document.getElementById('tx-filter-form');
        let searchDebounce;

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(searchDebounce);
                searchDebounce = setTimeout(() => filterForm.submit(), 500);
            });

            // restore cursor/focus after the reload triggered by typing
            if (searchInput.value) {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }
        }
    </script>

</body>

</html>