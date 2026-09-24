<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <link rel="stylesheet" href="css_folder/faqs.css">
    <link rel="stylesheet" href="css_folder/loading.css">

    {{-- bootstrap and tailwind link --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- font awesome cdn link --}}
    <link rel="stylesheet" href="font-awesome-icon/css/all.min.css">
</head>

<body>
    <div class="container-fluid p-0 m-0">
        @include("components.offcanvas")
        @include("components.sidebar")
        <div class="rightbar">
            @include("components.navbar2")
            @include("components.footer")

            <div class="main-parent">
                <main>
                    <h2>Frequently Asked Questions</h2>

                    <div style="max-width:760px; margin-top:1.2rem;">
                        @foreach ($faqs as $section)
                            <h4 style="margin:1.5rem 0 0.6rem; font-size:15px; color:#1a1a1a;">{{ $section['category'] }}
                            </h4>
                            <div style="border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                                @foreach ($section['items'] as $i => $item)
                                    <details style="border-bottom:{{ !$loop->last ? '1px solid #eee' : 'none' }};">
                                        <summary
                                            style="padding:12px 16px; cursor:pointer; font-weight:600; font-size:13.5px; color:#1a1a1a;">
                                            {{ $item['q'] }}
                                        </summary>
                                        <p style="padding:0 16px 14px; margin:0; font-size:13px; color:#555; line-height:1.6;">
                                            {{ $item['a'] }}
                                        </p>
                                    </details>
                                @endforeach
                            </div>
                        @endforeach

                        {{-- Didn't find what you're looking for? --}}
                        <div
                            style="margin-top:1.5rem; padding:14px 16px; background:#f7f7f8; border-radius:10px; font-size:13px; color:#555; display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap;">
                            <span>
                                Didn't find what you're looking for? Send our team a message directly.
                            </span>
                            <button type="button" class="btn-report-problem" data-bs-toggle="modal"
                                data-bs-target="#reportProblemModal"
                                style="display:inline-flex; align-items:center; gap:8px; padding:9px 16px; background:#1E2A4A; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer;">
                                <i class="fa-solid fa-flag"></i>
                                <span>Report a Problem</span>
                            </button>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Report a Problem Modal -->
    <div id="reportProblemModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none;">
                <div class="modal-header" style="border-bottom:1px solid #e5e7eb; padding:1.1rem 1.4rem;">
                    <h5 class="modal-title" style="font-size:15px; font-weight:700; color:#111827;">
                        Report a Problem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('support.report.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body"
                        style="padding:1.2rem 1.4rem; display:flex; flex-direction:column; gap:12px;">

                        @if (session('report_success'))
                            <div
                                style="background:#e7f6ec; border:1px solid #b7e4c3; color:#1a7f37; border-radius:8px; padding:10px 12px; font-size:12.5px;">
                                {{ session('report_success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div
                                style="background:#fef2f2; border:1px solid #fca5a5; color:#b91c1c; border-radius:8px; padding:10px 12px; font-size:12.5px;">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div>
                            <label
                                style="font-size:12px; text-transform:uppercase; font-weight:600; color:#888; display:block; margin-bottom:6px;">Category</label>
                            <select name="category" id="reportCategorySelect" required class="form-select"
                                style="border-radius:10px; border:1.5px solid #e0e0e0; height:44px; font-size:14px;">
                                <option value="" disabled selected>Select a category</option>
                                <option value="Balance Discrepancy">Balance Discrepancy</option>
                                <option value="Loan Requirement">Loan Requirement</option>
                                <option value="Payment Reflection">Payment Reflection</option>
                                <option value="Rejected / Invalid Deposit">Rejected / Invalid Deposit</option>
                                <option value="Other">Other</option>
                            </select>

                            {{-- Shown only when "Other" is selected --}}
                            <input type="text" name="category_other" id="reportCategoryOther" maxlength="80"
                                placeholder="Please specify your category"
                                style="display:none; width:100%; margin-top:8px; padding:10px 12px; border-radius:10px; border:1.5px solid #e0e0e0; font-size:14px; box-sizing:border-box;">
                        </div>

                        <div>
                            <label
                                style="font-size:12px; text-transform:uppercase; font-weight:600; color:#888; display:block; margin-bottom:6px;">Subject</label>
                            <input type="text" name="subject" required maxlength="150"
                                placeholder="Short summary of the issue"
                                style="width:100%; padding:10px 12px; border-radius:10px; border:1.5px solid #e0e0e0; font-size:14px; box-sizing:border-box;">
                        </div>

                        <div>
                            <label
                                style="font-size:12px; text-transform:uppercase; font-weight:600; color:#888; display:block; margin-bottom:6px;">Details</label>
                            <textarea name="message" required maxlength="2000" rows="4"
                                placeholder="Describe what happened, including the reference number if it's about a transaction"
                                style="width:100%; padding:10px 12px; border-radius:10px; border:1.5px solid #e0e0e0; font-size:14px; box-sizing:border-box; resize:vertical;"></textarea>
                        </div>

                        <div>
                            <label
                                style="font-size:12px; text-transform:uppercase; font-weight:600; color:#888; display:block; margin-bottom:6px;">Attach
                                Screenshot <span style="color:#bbb; text-transform:none;">(optional)</span></label>
                            <input type="file" name="proof" accept="image/png,image/jpeg,image/jpg" class="form-control"
                                style="border-radius:10px; font-size: 14px;">
                        </div>

                    </div>
                    <div class="modal-footer"
                        style="background:#f8f9fa; border-top:1px solid rgba(0,0,0,0.1); padding:1rem 1.4rem;">
                        <button type="submit"
                            style="width:100%; padding:0.75rem; background:var(--teal, #1E2A4A); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer;">
                            <i class="fa fa-paper-plane" style="margin-right:6px;"></i> Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Re-open the modal if the submit failed validation, so the error is visible --}}
    @if ($errors->any())
        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('reportProblemModal');
                if (el && window.bootstrap) {
                    window.bootstrap.Modal.getOrCreateInstance(el).show();
                }
            });
        </script>
    @endif

    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('DOMContentLoaded', function () {
            var select = document.getElementById('reportCategorySelect');
            var other = document.getElementById('reportCategoryOther');
            if (!select || !other) return;

            select.addEventListener('change', function () {
                var isOther = select.value === 'Other';
                other.style.display = isOther ? 'block' : 'none';
                other.required = isOther;   // only required when visible
                if (isOther) {
                    other.focus();
                } else {
                    other.value = '';
                }
            });
        });
    </script>

    {{-- Toast after submitting a report --}}
    @if (session('report_success'))
        <div class="toast-message" id="reportToast" role="status" style="width:320px;">
            <i class="fa-solid fa-circle-check"></i>
            <p>{{ session('report_success') }}</p>
        </div>

        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('DOMContentLoaded', function () {
                var toast = document.getElementById('reportToast');
                if (!toast) return;
                setTimeout(function () {
                    toast.classList.add('hide');
                    setTimeout(function () { toast.remove(); }, 400);
                }, 4000);
            });
        </script>
    @endif
</body>

</html>