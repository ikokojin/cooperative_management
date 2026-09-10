<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>

    {{-- AOS animation link css --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- css link --}}
    <link rel="stylesheet" href="css_folder/profile.css">
    <link rel="stylesheet" href="css_folder/loading.css">

    {{-- bootstrap and tailwind link --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- font awesome cdn link --}}
    <link rel="stylesheet" href="font-awesome-icon/css/all.min.css">

    <style>
        .modal-body::-webkit-scrollbar {
            display: none;
        }

        .modal-body {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0 m-0">
        @include("components.sidebar")

        <div class="rightbar">
            @include("components.navbar2")
            <div class="main-parent">
                <div class="main-header">
                    <div>
                        <h3>My Profile</h3>
                        <p>Your Personal, membership and account information</p>
                    </div>
                    <!-- <div>
                        <button>
                            <i class="fa fa-pencil"></i>
                            Edit Profile
                        </button>
                    </div> -->
                </div>

                <div class="main-personal-card">
                    <div class="personal-header">
                        <div class="header-parent">
                            <div class="header-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="header-text">
                                <h5>KPMPCATS</h5>
                                <p>Cooperative Membership</p>
                            </div>
                        </div>
                        <div class="active">
                            Active Member
                        </div>
                    </div>

                    <div class="personal-body">
                        <div class="personal-sub-body">
                            <div class="body-icon">
                                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                            </div>
                            <div class="parent-box">
                                <div class="body-text">
                                    <h2>{{ $user->first_name }}
                                        {{ $user->middle_name ? $user->middle_name . ' ' : '' }}{{ $user->last_name }}
                                    </h2>
                                    <p>{{ $user->role }} · {{ $otherinfo->present_address ?? 'N/A' }}</p>
                                </div>
                                <div class="since-parent">
                                    <div class="member member-no">
                                        <span>Member No</span>
                                        <strong>#48291</strong>
                                    </div>
                                    <div class="member member-since">
                                        <span>Member Since</span>
                                        <strong>{{ $memberSince }}</strong>
                                    </div>
                                    <div class="member member-id">
                                        <span>Tax ID</span>
                                        <strong>••• •• 7742</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="perforation"></div>
                </div>

                <div class="parent-information">
                    <div class="personal-sub-information">
                        <div class="personal-information-1">
                            <div class="personal-information-header">
                                <div class="header-text">
                                    <div class="header-icon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <h4>Personal Information</h4>
                                </div>
                                <div>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editPersonalInfoModal">
                                        Edit
                                    </a>
                                </div>
                            </div>
                            <div class="personal-information-body">
                                <div class="information">
                                    <span>Full name</span>
                                    <strong>{{ $user->first_name }}
                                        {{ $user->middle_name ? $user->middle_name . ' ' : '' }}{{ $user->last_name }}</strong>
                                </div>

                                <div class="information">
                                    <span>Date of Birth</span>
                                    <strong>{{ $otherinfo->date_of_birth ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Sex</span>
                                    <strong>{{ $otherinfo->sex ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Civil Status</span>
                                    <strong>{{ $otherinfo->civil_status ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Mobile Number</span>
                                    <strong>{{ $otherinfo->contact_no ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Email</span>
                                    <strong>{{ $email }}</strong>
                                </div>

                                <div class="information">
                                    <span>Present Address</span>
                                    <strong>{{ $otherinfo->present_address ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Permanent Address</span>
                                    <strong>{{ $otherinfo->permanent_address ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Weight</span>
                                    <strong>{{ $otherinfo->weight ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Height</span>
                                    <strong>{{ $otherinfo->height ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Blood Type</span>
                                    <strong>{{ $otherinfo->blood_type ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Citizenship</span>
                                    <strong>{{ $otherinfo->citizenship ?? 'N/A' }}</strong>
                                </div>
                            </div>
                            <!-- <div class="more-button">
                                <button>
                                    View More
                                    <i class="fa fa-arrow-right"></i>
                                </button>
                            </div> -->
                        </div>

                        <div class="personal-information-1">
                            <div class="personal-information-header">
                                <div class="header-text">
                                    <div class="header-icon">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <h4>Employment & Membership</h4>
                                </div>
                                <div>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editEmploymentModal">
                                        Edit
                                    </a>
                                </div>
                            </div>
                            <div class="personal-information-body">
                                <div class="information">
                                    <span>Role</span>
                                    <strong>{{ $user->role ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Monthly Income</span>
                                    <strong>{{ $savedMonthlyIncome ? '₱' . number_format($savedMonthlyIncome, 2) : 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Member Category</span>
                                    <strong>{{ $otherinfo->membership_category ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Status</span>
                                    <strong>{{ $otherinfo->membership_status ?? 'N/A' }}</strong>
                                </div>

                                {{-- <div class="information">
                                    <span>Employer</span>
                                    <strong>{{ $otherinfo->employer ?? 'N/A' }}</strong>
                                </div>

                                <div class="information">
                                    <span>Standing</span>
                                    <strong>{{ $user->status ?? 'N/A' }}</strong>
                                </div> --}}
                            </div>
                        </div>

                        <div class="personal-information-1">
                            <div class="personal-information-header">
                                <div class="header-text">
                                    <div class="header-icon">
                                        <i class="fa fa-folder-open"></i>
                                    </div>
                                    <h4>Documents on File</h4>
                                </div>
                                <div>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editDocumentsModal">
                                        Edit
                                    </a>
                                </div>
                            </div>
                            <div class="personal-information-body document-body">
                                @php
                                    $docs = [
                                        'SSS ID' => $membergovernIds->sss_id ?? null,
                                        'Philhealth ID' => $membergovernIds->philhealth_id ?? null,
                                        'Pag Ibig ID' => $membergovernIds->pagibig_id ?? null,
                                        'Tin ID' => $membergovernIds->tin_id ?? null,
                                    ];
                                @endphp
                                @foreach($docs as $label => $path)
                                    <div class="doc-row">
                                        <i class="fa fa-file-lines doc-icon"></i>
                                        <div class="doc-name">{{ $label }}</div>
                                        <div class="doc-meta">
                                            {{ $path ? 'Uploaded' . ($membergovernIds->updated_at ? ' ' . $membergovernIds->updated_at->format('M d, Y') : '') : 'Not uploaded' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="personal-sub-information">
                        <div class="personal-information-2">
                            <div class="personal-information-header">
                                <div class="header-text">
                                    <div class="header-icon">
                                        <i class="fa fa-wallet"></i>
                                    </div>
                                    <h4>Account Balance</h4>
                                </div>
                            </div>
                            <div class="personal-information-body-2">
                                <!-- <div class="personal-head">
                                    <p>Description</p>
                                    <p>Balance</p>
                                </div> -->
                                <div class="personal-parent">
                                    <div class="item item-share">
                                        <div class="stat-icon">
                                            <i class="fa fa-layer-group"></i>
                                        </div>
                                        <div class="fw-bold item-value item-value-share">
                                            <span>Share Capital Account</span>
                                            <strong>₱{{ number_format($shareCapitalBalance, 2) }}</strong>
                                        </div>
                                    </div>

                                    <div class="item item-savings">
                                        <div class="stat-icon">
                                            <i class="fa fa-piggy-bank"></i>
                                        </div>
                                        <div class="fw-bold item-value item-category-savings">
                                            <span>Savings Account</span>
                                            <strong>₱{{ number_format($savingsBalance, 2) }}</strong>
                                        </div>
                                    </div>

                                    <div class="item item-loan">
                                        <div class="stat-icon">
                                            <i class="fa fa-hand-holding-dollar"></i>
                                        </div>
                                        <div class="fw-bold item-value item-category-loan">
                                            <span>Loan Balance</span>
                                            <strong>₱{{ number_format($loanBalance, 2) }}</strong>
                                        </div>
                                    </div>

                                    <div class="item item-net">
                                        <div class="fw-bold item-value item-category-net">
                                            <span>Overall</span>
                                        </div>
                                        <div class="stat-delta">₱{{ number_format($overallBalance, 2) }}</div>
                                    </div>
                                </div>
                                <!-- <div class="personal-footer">
                                    <div class="item item-net"> 
                                        <div class="fw-bold item-category-net">
                                            <span>Net Standing</span>

                                            <strong>₱51,930.00</strong>
                                        </div>
                                        <div class="fw-bold item-value-net">₱51,930.00</div>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <div class="personal-information-2">
                            <div class="personal-information-header">
                                <div class="header-text">
                                    <div class="header-icon">
                                        <i class="fa fa-chart-simple"></i>
                                    </div>
                                    <h4>Loan Repayment Progress</h4>
                                </div>
                            </div>
                            <div class="personal-information-body-2">

                                <div class="parent-sub-progress">
                                    @foreach($loansByType as $type => $data)
                                        <a href="{{ route('LoanApplication') }}"
                                            style="text-decoration:none; color:inherit; display:block;">
                                            <div class="progress-repay progress-personal" style="cursor:pointer;">
                                                <div class="progress-header">
                                                    <strong>{{ $type }}</strong>
                                                    <span>₱{{ number_format($data['balance'], 2) }}</span>
                                                </div>
                                                <div class="progress-body">
                                                    <div class="parent-progress">
                                                        <div class="progress" style="width: {{ $data['progress'] }}%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Personal Information Modal --}}
    <div class="modal fade" id="editPersonalInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content sm-modal-content">
                <div class="modal-header sm-modal-header">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="sm-modal-icon"><i class="fa fa-user"></i></div>
                        <div>
                            <h5 class="sm-modal-title">Edit Personal Information</h5>
                            <p class="sm-modal-subtitle">Update your personal and contact details</p>
                        </div>
                    </div>
                    <button type="button" class="sm-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body sm-modal-body" style="max-height: 68vh; overflow-y: auto;">
                    <form action="{{ route('UpdateProfileMember') }}" method="POST" enctype="multipart/form-data"
                        id="personalInfoForm">
                        @csrf
                        <input type="hidden" name="_form" value="personal">

                        <div class="sm-field-row">
                            <div class="sm-field">
                                <label class="sm-label">First Name</label>
                                <input type="text" name="first_name" class="sm-input"
                                    value="{{ $user->first_name ?? '' }}">
                            </div>
                            <div class="sm-field">
                                <label class="sm-label">Middle Name</label>
                                <input type="text" name="middle_name" class="sm-input"
                                    value="{{ $user->middle_name ?? '' }}">
                            </div>
                            <div class="sm-field">
                                <label class="sm-label">Last Name</label>
                                <input type="text" name="last_name" class="sm-input"
                                    value="{{ $user->last_name ?? '' }}">
                            </div>
                        </div>

                        <div class="sm-field-row">
                            <div class="sm-field">
                                <label class="sm-label">Contact Number</label>
                                <input type="text" name="contact_no" class="sm-input"
                                    value="{{ $otherinfo->contact_no ?? '' }}">
                            </div>
                            <div class="sm-field">
                                <label class="sm-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="sm-input"
                                    value="{{ $otherinfo->date_of_birth ?? '' }}">
                            </div>
                            <div class="sm-field">
                                <label class="sm-label">Sex</label>
                                <select name="sex" class="sm-input">
                                    <option value="">Select</option>
                                    <option value="Male" {{ ($otherinfo->sex ?? '') == 'Male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="Female" {{ ($otherinfo->sex ?? '') == 'Female' ? 'selected' : '' }}>
                                        Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm-field-row">
                            <div class="sm-field">
                                <label class="sm-label">Civil Status</label>
                                <select name="civil_status" class="sm-input">
                                    <option value="">Select</option>
                                    <option value="Single" {{ ($otherinfo->civil_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ ($otherinfo->civil_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ ($otherinfo->civil_status ?? '') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Divorced" {{ ($otherinfo->civil_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                </select>
                            </div>
                            <div class="sm-field">
                                <label class="sm-label">Citizenship</label>
                                <input type="text" name="citizenship" class="sm-input"
                                    value="{{ $otherinfo->citizenship ?? '' }}">
                            </div>
                            <div class="sm-field">
                                <label class="sm-label">Blood Type</label>
                                <input type="text" name="blood_type" class="sm-input"
                                    value="{{ $otherinfo->blood_type ?? '' }}">
                            </div>
                        </div>

                        <div class="sm-field-row">
                            <div class="sm-field">
                                <label class="sm-label">Height</label>
                                <input type="text" name="height" class="sm-input"
                                    value="{{ $otherinfo->height ?? '' }}">
                            </div>
                            <div class="sm-field">
                                <label class="sm-label">Weight</label>
                                <input type="text" name="weight" class="sm-input"
                                    value="{{ $otherinfo->weight ?? '' }}">
                            </div>
                        </div>

                        <div class="sm-field">
                            <label class="sm-label">Present Address</label>
                            <textarea name="present_address" class="sm-input"
                                rows="2">{{ $otherinfo->present_address ?? '' }}</textarea>
                        </div>
                        <div class="sm-field">
                            <label class="sm-label">Permanent Address</label>
                            <textarea name="permanent_address" class="sm-input"
                                rows="2">{{ $otherinfo->permanent_address ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="sm-btn-confirm"><i class="fa fa-check"></i> Confirm
                            Changes</button>
                        <button type="button" class="sm-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>

                @if ($errors->any() && old('_form') === 'personal')
                    <div class="alert alert-danger" style="border-radius:10px; font-size:13px; margin-bottom:1rem;">
                        {{ $errors->first() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Edit Employment & Membership Modal --}}
    <div class="modal fade" id="editEmploymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content sm-modal-content">
                <div class="modal-header sm-modal-header">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="sm-modal-icon"><i class="fa fa-briefcase"></i></div>
                        <div>
                            <h5 class="sm-modal-title">Edit Employment & Membership</h5>
                            <p class="sm-modal-subtitle">Update your work and income details</p>
                        </div>
                    </div>
                    <button type="button" class="sm-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body sm-modal-body">
                    <form action="{{ route('UpdateProfileMember') }}" method="POST" id="employmentForm">
                        @csrf
                        <input type="hidden" name="_form" value="employment">

                        <div class="sm-summary-strip">
                            <span class="sm-summary-label">Current Role</span>
                            <span class="sm-summary-value">{{ $user->role ?? 'Member' }}</span>
                        </div>

                        <div class="sm-field">
                            <label class="sm-label">Monthly Income</label>
                            <div style="position:relative;">
                                <span class="sm-input-prefix">₱</span>
                                <input type="number" step="0.01" name="monthly_income"
                                    class="sm-input sm-input-prefixed" value="{{ $savedMonthlyIncome ?? '' }}">
                            </div>
                        </div>

                        <button type="submit" class="sm-btn-confirm"><i class="fa fa-check"></i> Confirm
                            Changes</button>
                        <button type="button" class="sm-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Documents on File Modal --}}
    <div class="modal fade" id="editDocumentsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content sm-modal-content">
                <div class="modal-header sm-modal-header">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="sm-modal-icon"><i class="fa fa-folder-open"></i></div>
                        <div>
                            <h5 class="sm-modal-title">Edit Documents on File</h5>
                            <p class="sm-modal-subtitle">Upload or replace your government IDs</p>
                        </div>
                    </div>
                    <button type="button" class="sm-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body sm-modal-body">
                    <form action="{{ route('UpdateProfileMember') }}" method="POST" enctype="multipart/form-data"
                        id="documentsForm">
                        @csrf
                        <input type="hidden" name="_form" value="documents">

                        <div class="sm-field">
                            <label class="sm-label">SSS ID</label>
                            <input type="file" name="sss_id" class="sm-input" accept="image/*">
                            @if(!empty($membergovernIds->sss_id))<small class="sm-current-file">Current file on
                            record</small>@endif
                        </div>
                        <div class="sm-field">
                            <label class="sm-label">PhilHealth ID</label>
                            <input type="file" name="philhealth_id" class="sm-input" accept="image/*">
                            @if(!empty($membergovernIds->philhealth_id))<small class="sm-current-file">Current file on
                            record</small>@endif
                        </div>
                        <div class="sm-field">
                            <label class="sm-label">Pag-IBIG ID</label>
                            <input type="file" name="pagibig_id" class="sm-input" accept="image/*">
                            @if(!empty($membergovernIds->pagibig_id))<small class="sm-current-file">Current file on
                            record</small>@endif
                        </div>
                        <div class="sm-field">
                            <label class="sm-label">TIN ID</label>
                            <input type="file" name="tin_id" class="sm-input" accept="image/*">
                            @if(!empty($membergovernIds->tin_id))<small class="sm-current-file">Current file on
                            record</small>@endif
                        </div>

                        <button type="submit" class="sm-btn-confirm"><i class="fa fa-check"></i> Confirm
                            Changes</button>
                        <button type="button" class="sm-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- AOS animation link js --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script nonce="{{ csp_nonce() }}">
        AOS.init();
    </script>
</body>

</html>