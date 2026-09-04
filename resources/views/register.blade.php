<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Apply for Membership</title>
    <link rel="icon" href="images/websitelogo.png" type="image/png">

    {{-- css link --}}
    <link rel="stylesheet" href="css_folder/register.css">

    {{-- bootstrap and tailwind link --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- font awesome cdn link --}}
    <link rel="stylesheet" href="font-awesome-icon/css/all.min.css">
</head>

<body>

    <div class="container-fluid">

        <div class="sidebar">
            <div class="sidebar-nav">
                <div class="nav-tag">Member Application</div>

                <h2>Join the <b>Cooperative</b></h2>

                <p>Complete the steps below to become a registered KPMPCATS member.</p>
            </div>

            <div class="stepper">
                <div class="step active">
                    <div class="step-left">
                        <div class="circle">01</div>
                        {{-- <div class="connector"></div> --}}
                    </div>
                    <div class="label">
                        <p class="title">Terms &amp; Agreement</p>
                        <p class="sub">Read and accept cooperative terms</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-left">
                        <div class="circle">02</div>
                        {{-- <div class="connector"></div> --}}
                    </div>
                    <div class="label">
                        <p class="title">Personal Data</p>
                        <p class="sub">Your name, contact &amp; address</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-left">
                        <div class="circle">03</div>
                        {{-- <div class="connector"></div> --}}
                    </div>
                    <div class="label">
                        <p class="title">Other Information</p>
                        <p class="sub">Membership type &amp; employment</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-left">
                        <div class="circle">04</div>
                        {{-- <div class="connector"></div> --}}
                    </div>
                    <div class="label">
                        <p class="title">Review &amp; Submit</p>
                        <p class="sub">Confirm and finalize application</p>
                    </div>
                </div>
            </div>

            <hr style="margin-top: 5rem; color: #FFFFFF4D;">

            <div class="form-acc">
                <label>Already a member? <a href="{{ route("LoginPage") }}" id="signin-link">Sign in here</a></label>
                <label>Need help? <button>Contact Support</button></label>
            </div>
        </div>

        <div class="rightbar">

            <nav>
                <div class="nav-logo">
                    {{-- <img src="../images/logo2.png" alt=""> --}}
                    <div class="nav-text">
                        {{-- <h2 class="fw-bold">Membership Application Form</h2> --}}
                        <div class="nav-side">
                            <img src="images/logo2.png" alt="">
                            <h2>KPMPCATS</h2>
                        </div>

                        <a href="{{ route("index") }}">
                            <i class="fa fa-chevron-left"></i>
                            <p>Back to Home</p>
                        </a>
                        {{-- <p>Ready to become part of something special? We can't wait to welcome you.</p> --}}
                    </div>
                </div>
            </nav>

            {{-- <h2>Terms & <b>Agreement</b></h2>

            <p>Please read the following terms carefully before proceeding.</p> --}}

            <div class="main">
                <form action="{{ route("registration") }}" id="form" method="post" class="needs-validation" novalidate
                    enctype="multipart/form-data">
                    @csrf

                    {{-- <div class="tw:flex tw:justify-center tw:items-center line">
                        <hr class="tw:w-[20%] border-2">
                    </div> --}}

                    <div class="choose-type">
                        <div class="choose">
                            <div class="back">
                                <a href="{{ route('LoginPage') }}"><i class="fa fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="form-box">

                        <!-- Form -->
                        <div class="card-box">

                            <!-- Step 1 -->
                            <div class="form-step active">

                                <div class="form-step-nav">
                                    {{-- <div class="header-track">
                                        <span>Step 1 of 4</span>
                                    </div> --}}

                                    <h2>Terms & <b>Agreement</b></h2>

                                    <p>Please read the following terms carefully before proceeding.</p>
                                </div>

                                <div class="line-agreement"></div>

                                <div class="form-step-header">
                                    <h3>Cooperative Membership Terms</h3>
                                    <p>KPMPCATS — Authorized Share Capital Agreement</p>
                                </div>
                                <div class="form-step-body">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <label class="lh-lg mt-3">The Undersigned hereby subscribed and agreed to
                                                take
                                                100
                                                share of the KPMPCATS authorized Share Capital with a par value of One
                                                Hundred
                                                Pesos
                                                (Php100.00) per share amounting to Ten Thousand (P10,000.00) Pesos
                                                payable
                                                that
                                                was
                                                scheduled within two (2) years, and agrees to pay atleast 25% as initial
                                                payment
                                                of
                                                subscription within a Membership Fee of Two Thousand (P2,000.00)
                                                Pesos.</label>

                                            <label class="lh-lg mt-4">The undersigned agrees further to pay Fifty
                                                Thousand
                                                (P50,000.00) Pesos (For Tourist Unit) as entrance fee for my vehicle and
                                                Mobilization Fee of Three Thousand (P3,000.00) of the Transport /
                                                Vehicle
                                                Operation
                                                of KPMPCATS.</label>

                                            <label class="lh-lg mt-4">The undersigned further pledge to undertake
                                                Regular
                                                Savings
                                                and / or Contributions to the Caplital Build-Up of the Cooperative or to
                                                its
                                                Programs and Services.</label>

                                            <label class="mt-4">Declaration and Agreement</label>

                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" name="agree1"
                                                    id="checkboxDefault1" required>
                                                <label class="form-check-label" for="checkboxDefault1">
                                                    I hereby certify that the foregoing statements are true and correct
                                                    to
                                                    the
                                                    best
                                                    of my knowledge. I understand that any false information may result
                                                    in
                                                    the
                                                    cancellation of my membership.
                                                </label>
                                            </div>

                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" name="agree2"
                                                    id="checkboxDefault2" required>
                                                <label class="form-check-label" for="checkboxDefault2">
                                                    I agree to abide by the Constitution and By-Laws of the Cooperative
                                                    and
                                                    to
                                                    accept the rights, responsibilities, and obligations of membership.
                                                    I
                                                    understand
                                                    that my application is subject to approval by the Board of
                                                    Directors.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            @include('membership_components.personal_data')

                            <!-- Step 3 -->
                            @include('membership_components.other_information')

                            {{-- Step 4 --}}
                            @include('membership_components.review_submit')

                            <!-- <div class="line-agreement"></div> -->

                            <!-- Buttons -->
                            <div class="actions">
                                <button type="button" class="btn-prev" onclick="prevStep()" style="display:none;">
                                    <i class="fa fa-chevron-left"></i>
                                    <span>Previous</span>
                                </button>
                                <button type="button" class="btn-next" onclick="nextStep()">
                                    <span>Next Step</span>
                                    <i class="fa fa-chevron-right"></i>
                                </button>
                                <button type="submit" class="btn-submit" style="display:none;">Submit</button>
                            </div>

                        </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ── Toggle password visibility ─────────────────────────────────────── --}}
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

    {{-- ── Membership type toggle ──────────────────────────────────────────── --}}
    <script>
        const select_type = document.getElementById("select_type");

        select_type.addEventListener("change", function () {
            const driver_operator = document.querySelector(".driver-operator");
            if (this.value === "Driver" || this.value === "Investor Associate") {
                driver_operator.style.display = "none";
            } else {
                driver_operator.style.display = "block";
            }
        });
    </script>

    {{-- ── JS files ────────────────────────────────────────────────────────── --}}
    <script src="js_folder/otherinfo_form.js"></script>
    <script src="js_folder/vehicle_form.js"></script>
    <script src="js_folder/display_form.js"></script>
    <script src="js_folder/card_form.js"></script>
    <script src="js_folder/picture_display.js"></script>
    <script src="js_folder/signature_pad.umd.min.js"></script>

    {{-- ── Animate card-box on load ────────────────────────────────────────── --}}
    <script>
        window.addEventListener('load', function () {
            const cardBox = document.querySelector('.card-box');
            cardBox.style.animation = 'none';
            cardBox.offsetHeight;
            cardBox.style.animation = '';
        });
    </script>

    {{-- ── Clear saved registration data when leaving to the Login page ───── --}}
    {{-- This makes sure the form always starts fresh (Step 1, blank fields) --}}
    {{-- the next time anyone opens /register-page on this browser/tab. --}}
    <script>
        document.getElementById('signin-link')?.addEventListener('click', function () {
            if (typeof window.clearAllRegistrationData === 'function') {
                window.clearAllRegistrationData();
            }
        });
    </script>

    {{-- ── Success modal (shown after successful registration) ────────────── --}}
    @if (session("success"))
        <button id="triggerModal" data-bs-toggle="modal" data-bs-target="#successModal" style="display:none;"></button>

        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 16px;">

                    <div class="modal-header d-flex flex-column align-items-center text-center py-4"
                        style="background: #ffffff; border-bottom: 1px solid var(--line);">
                        <div class="d-flex justify-content-center align-items-center mb-3"
                            style="width: 72px; height: 72px; border-radius: 50%; background-color: var(--teal);">
                            <i class="fa fa-check" style="font-size: 32px; color: #ffffff;"></i>
                        </div>
                        <h4 class="modal-title fw-bold mb-1" style="color: #1a1a1a;">Registration Successful!</h4>
                        <p class="mb-0" style="opacity: 0.85; font-size: 0.9rem; color: var(--muted)">Your application has been
                            submitted</p>
                    </div>

                    <div class="modal-body text-center px-4 py-4">
                        <p class="fw-semibold mb-2" style="color: var(--teal); font-size: 1rem;">
                            {{ session("success") }}
                        </p>
                        <hr style="border-color: #e9ecef;">
                        <div class="d-flex align-items-start gap-3 text-start mt-3 p-3 rounded-3"
                            style="background: #EDF0F5; border: 1px solid var(--border);">
                            <i class="fa fa-envelope mt-1" style="color: var(--teal); font-size: 1.1rem;"></i>
                            <p class="mb-0" style="color: var(--teal); font-size: 0.9rem; line-height: 1.6;">
                                You will receive an <strong>email notification</strong> once your application
                                has been reviewed and approved by the Board of Directors. Please check your Gmail inbox.
                            </p>
                        </div>
                        <div class="d-flex align-items-start gap-3 text-start mt-3 p-3 rounded-3"
                            style="background: var(--gold-pale); border: 1px solid #F5D9A8;">
                            <i class="fa fa-clock mt-1" style="color: var(--gold); font-size: 1.1rem;"></i>
                            <p class="mb-0" style="color: #6b4f18; font-size: 0.9rem; line-height: 1.6;">
                                Processing may take a few business days. Please be patient while we review your membership
                                application.
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn px-5 py-2 fw-semibold text-white" data-bs-dismiss="modal"
                            style="background: var(--teal); border-radius: 50px; border: none; font-size: 1rem; letter-spacing: 0.5px;">
                            OK, Got it!
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <script>
            window.addEventListener('load', function () {
                document.getElementById('triggerModal').click();
                document.getElementById('successModal').addEventListener('hidden.bs.modal', function () {
                    window.location.href = "{{ route('LoginPage') }}";
                });
            });
        </script>
    @endif

</body>

</html>