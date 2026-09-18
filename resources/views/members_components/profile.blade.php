<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <!-- <div class="member member-id">
                                        <span>Tax ID</span>
                                        <strong>••• •• 7742</strong>
                                    </div> -->
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

                <div class="main-personal-card"
                    style="margin-top: 1.5rem; border: 1px solid #fecaca; background: #fef2f2; padding: 20px; border-radius: 12px; display:flex; justify-content:space-between; align-items:center; gap: 16px;">
                    <div stlye="width: 100%;">
                        <h4 style="color: #dc2626; margin: 0 0 5px; font-size: 20px; font-weight: 600;">Leave the
                            Cooperative?</h4>
                        <p style="color: #1e293b; margin: 0; font-size: 14.5px; width: 100%; max-width: 500px;">If you
                            wish to resign, submit a
                            resignation request. A 60-day holding period applies for share capital withdrawal.</p>
                    </div>
                    <div stlye="width: 100%;">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#profileResignModal"
                            style="background: #dc2626; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px; white-space: nowrap; font-size: 14.5px;">
                            <i class="fa fa-sign-out-alt"></i>
                            <span>Request Resignation</span>
                        </button>
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

                        @php
                            $docFields = [
                                'sss_id' => ['label' => 'SSS ID', 'value' => $membergovernIds->sss_id ?? null],
                                'philhealth_id' => ['label' => 'PhilHealth ID', 'value' => $membergovernIds->philhealth_id ?? null],
                                'pagibig_id' => ['label' => 'Pag-IBIG ID', 'value' => $membergovernIds->pagibig_id ?? null],
                                'tin_id' => ['label' => 'TIN ID', 'value' => $membergovernIds->tin_id ?? null],
                            ];
                        @endphp

                        @foreach($docFields as $fieldName => $doc)
                            <div class="sm-field">
                                <label class="sm-label">{{ $doc['label'] }}</label>
                                <label for="upload_{{ $fieldName }}" class="doc-upload-box" id="uploadBox_{{ $fieldName }}">
                                    <div class="doc-upload-icon"><i class="fa fa-cloud-upload-alt"></i></div>
                                    <div class="doc-upload-text">
                                        <span class="doc-upload-title" id="uploadTitle_{{ $fieldName }}">
                                            {{ $doc['value'] ? 'Replace file' : 'Click to upload' }}
                                        </span>
                                        <span class="doc-upload-sub" id="uploadSub_{{ $fieldName }}">
                                            {{ $doc['value'] ? 'A file is already on record' : 'JPG or PNG, max 2MB' }}
                                        </span>
                                    </div>
                                </label>
                                <input type="file" id="upload_{{ $fieldName }}" name="{{ $fieldName }}"
                                    class="doc-upload-input" accept="image/*"
                                    onchange="handleDocUploadChange('{{ $fieldName }}', this)">
                            </div>
                        @endforeach

                        <button type="submit" class="sm-btn-confirm"><i class="fa fa-check"></i> Confirm
                            Changes</button>
                        <button type="button" class="sm-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .doc-upload-input {
            display: none;
        }

        .doc-upload-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border: 1.5px dashed #d1d5db;
            border-radius: 10px;
            cursor: pointer;
            background: #f9fafb;
            transition: border-color .15s, background .15s;
        }

        .doc-upload-box:hover {
            border-color: #1E2A4A;
            background: #f3f4f6;
        }

        .doc-upload-box.has-file {
            border-style: solid;
            border-color: #16a34a;
            background: #f0fdf4;
        }

        .doc-upload-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 8px;
            background: #eef1f7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1E2A4A;
            font-size: 14px;
        }

        .doc-upload-box.has-file .doc-upload-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .doc-upload-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .doc-upload-title {
            font-size: 13.5px;
            font-weight: 600;
            color: #111827;
        }

        .doc-upload-sub {
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <script nonce="{{ csp_nonce() }}">
        function handleDocUploadChange(fieldName, input) {
            const box = document.getElementById('uploadBox_' + fieldName);
            const title = document.getElementById('uploadTitle_' + fieldName);
            const sub = document.getElementById('uploadSub_' + fieldName);

            if (input.files && input.files.length > 0) {
                const file = input.files[0];
                box.classList.add('has-file');
                title.textContent = 'File selected';
                sub.textContent = file.name;
            } else {
                box.classList.remove('has-file');
                title.textContent = 'Click to upload';
                sub.textContent = 'JPG or PNG, max 2MB';
            }
        }
    </script>

    {{-- AOS animation link js --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script nonce="{{ csp_nonce() }}">
        AOS.init();
    </script>
</body>

{{-- Reset Password Modal --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content sm-modal-content">
            <div class="modal-header sm-modal-header">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div class="sm-modal-icon"><i class="fa fa-lock"></i></div>
                    <div>
                        <h5 class="sm-modal-title">Reset Password</h5>
                        <p class="sm-modal-subtitle">Enter your current password and choose a new one</p>
                    </div>
                </div>
                <button type="button" class="sm-modal-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body sm-modal-body">
                <form id="resetPasswordForm">
                    @csrf
                    <div class="sm-field">
                        <label class="sm-label">Current Password</label>
                        <div class="password-input-wrap">
                            <input type="password" class="sm-input" id="current_password" name="current_password"
                                required>
                            <button type="button" class="password-toggle-btn" data-toggle-target="current_password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <small class="sm-error-text" id="current_password_error"></small>
                    </div>
                    <div class="sm-field">
                        <label class="sm-label">New Password</label>
                        <div class="password-input-wrap">
                            <input type="password" class="sm-input" id="new_password" name="new_password" minlength="8"
                                required>
                            <button type="button" class="password-toggle-btn" data-toggle-target="new_password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <small class="sm-hint-text">Minimum 8 characters</small>
                    </div>
                    <div class="sm-field">
                        <label class="sm-label">Confirm New Password</label>
                        <div class="password-input-wrap">
                            <input type="password" class="sm-input" id="new_password_confirmation"
                                name="new_password_confirmation" minlength="8" required>
                            <button type="button" class="password-toggle-btn"
                                data-toggle-target="new_password_confirmation">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                        <small class="sm-error-text" id="confirm_password_error"></small>
                    </div>

                    <button type="submit" class="sm-btn-confirm" id="resetPasswordSubmitBtn">
                        <i class="fa fa-check"></i> Update Password
                    </button>
                    <button type="button" class="sm-btn-cancel" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .password-input-wrap {
        position: relative;
    }

    .password-input-wrap .sm-input {
        padding-right: 40px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 14px;
    }

    .password-toggle-btn:hover {
        color: #374151;
    }

    .sm-error-text {
        color: #dc2626;
        font-size: 12px;
        display: block;
        margin-top: 4px;
        min-height: 14px;
    }

    .sm-hint-text {
        color: #6b7280;
        font-size: 12px;
        display: block;
        margin-top: 4px;
    }
</style>

<script nonce="{{ csp_nonce() }}">
    document.querySelectorAll('.password-toggle-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = btn.getAttribute('data-toggle-target');
            const input = document.getElementById(targetId);
            const icon = btn.querySelector('i');

            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    document.getElementById('resetPasswordForm')?.addEventListener('submit', async function (e) {
        e.preventDefault();

        const currentPasswordError = document.getElementById('current_password_error');
        const confirmPasswordError = document.getElementById('confirm_password_error');
        currentPasswordError.textContent = '';
        confirmPasswordError.textContent = '';

        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;

        if (newPassword !== confirmPassword) {
            confirmPasswordError.textContent = 'Passwords do not match.';
            return;
        }

        const submitBtn = document.getElementById('resetPasswordSubmitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';

        try {
            const response = await fetch('{{ route("ChangePassword") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        || document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    current_password: document.getElementById('current_password').value,
                    new_password: newPassword,
                    new_password_confirmation: confirmPassword,
                }),
            });

            const data = await response.json();

            if (data.success) {
                const modalEl = document.getElementById('resetPasswordModal');
                bootstrap.Modal.getInstance(modalEl)?.hide();
                document.getElementById('resetPasswordForm').reset();
                showProfileToast(data.message || 'Password updated successfully.');
            } else {
                currentPasswordError.textContent = data.message || 'Something went wrong.';
            }
        } catch (err) {
            currentPasswordError.textContent = 'Something went wrong. Please try again.';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });

    function showProfileToast(message) {
        const existing = document.getElementById('profileToast');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.id = 'profileToast';
        toast.innerHTML = `<i class="fa fa-check-circle"></i><div><p>${message}</p></div>`;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('hide');
            toast.addEventListener('animationend', () => toast.remove());
        }, 3000);
    }
</script>

{{-- Resignation Modal --}}
<div class="modal fade" id="profileResignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="border-bottom: 1px solid #e5e7eb;">
                <h5 class="modal-title" style="font-weight: 700; color: #111827;">Request Resignation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('resignation.request') }}" style="padding: 24px;">
                @csrf
                <p style="font-size: 14px; color: #6b7280; margin-bottom: 20px;">Please select your preference for your
                    share capital:</p>
                <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:24px;">
                    <label class="resign-option"
                        style="display:flex; align-items:center; gap:12px; padding:14px 16px; border:2px solid #e5e7eb; border-radius:10px; cursor:pointer;">
                        <input type="radio" name="withdraw_share_capital" value="1" style="accent-color:#1E2A4A;"
                            required>
                        <div>
                            <strong style="display:block; color:#111827; font-size:15px;">Withdraw Share
                                Capital</strong>
                            <span style="font-size:13px; color:#6b7280;">I want my share capital paid out after 60
                                days</span>
                        </div>
                    </label>
                    <label class="resign-option"
                        style="display:flex; align-items:center; gap:12px; padding:14px 16px; border:2px solid #e5e7eb; border-radius:10px; cursor:pointer;">
                        <input type="radio" name="withdraw_share_capital" value="0" style="accent-color:#1E2A4A;"
                            required>
                        <div>
                            <strong style="display:block; color:#111827; font-size:15px;">Leave Share Capital</strong>
                            <span style="font-size:13px; color:#6b7280;">I leave my share capital with the
                                cooperative</span>
                        </div>
                    </label>
                </div>
                <div style="display:flex; gap:12px;">
                    <button type="button" data-bs-dismiss="modal"
                        style="flex:1; padding:12px; background:#f3f4f6; color:#374151; border:none; border-radius:8px; cursor:pointer; font-weight:600;">Cancel</button>
                    <button type="submit"
                        style="flex:1; padding:12px; background:#dc2626; color:#fff; border:none; border-radius:8px; cursor:pointer; font-weight:600;"
                        onclick="return confirm('Are you sure you want to submit a resignation request? This action will be reviewed by admin.');">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="toast-message" id="profileToast">
        <i class="fa fa-check-circle"></i>
        <div>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    <script nonce="{{ csp_nonce() }}">
        setTimeout(() => {
            const msg = document.getElementById('profileToast');
            if (msg) {
                msg.classList.add('hide');
                msg.addEventListener('animationend', () => msg.remove());
            }
        }, 3000);
    </script>
@endif

<style>
    .toast-message {
        position: fixed;
        right: 20px;
        top: 20px;
        padding: 1rem 1.5rem;
        color: #16a34a;
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
        border: 1px solid #E2E8E5;
        width: 280px;
        display: flex;
        align-items: center;
        border-radius: 10px;
        gap: 1rem;
        z-index: 99999;
        overflow: hidden;
        animation: toastSlideIn .4s cubic-bezier(.22, 1, .36, 1) forwards;
    }

    .toast-message::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        background-color: #16a34a;
        width: 5px;
    }

    .toast-message p {
        margin: 0;
        font-weight: 600;
        color: #111827;
        font-size: 13.5px;
    }

    .toast-message.hide {
        animation: toastFadeOut .4s ease-in forwards;
    }

    @keyframes toastSlideIn {
        from {
            opacity: 0;
            transform: translateX(60px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes toastFadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(60px);
        }
    }
</style>

</html>