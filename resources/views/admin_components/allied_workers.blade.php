@extends('layouts.admin')

@section('title', 'Allied Workers - CoopAdmin')

@section('content')
    <div class="mb-6">
        <nav class="text-sm text-gray-500">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary-600">
                        <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                    </a>
                </li>
                <li class="flex items-center">
                    <i data-lucide="chevron-right" class="w-4 h-4 mx-2 text-gray-400"></i>
                    <span class="text-gray-900 font-medium">Allied Workers</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Allied Workers</h1>
        <p class="text-sm text-gray-500">Promote existing members to staff roles on the same account (no duplicate accounts).</p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700">
            <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-lg border border-danger-200 bg-danger-50 px-4 py-3 text-sm text-danger-700">
            <i data-lucide="alert-circle" class="w-4 h-4 inline-block mr-2"></i>{{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-danger-200 bg-danger-50 px-4 py-3 text-sm text-danger-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Current Allied Workers -->
    <div class="card p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Current Allied Workers</h2>
                <p class="text-sm text-gray-500">Members currently holding an Allied Worker role.</p>
            </div>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Role</th>
                        <th>Mode</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alliedWorkers as $aw)
                    <tr>
                        <td>
                            <span class="text-sm font-medium text-gray-900">{{ $aw->first_name }} {{ $aw->last_name }}</span>
                            <span class="text-xs text-gray-400 block">{{ $aw->email }}</span>
                        </td>
                        <td>
                            @php $awRole = $systemRoles->merge($activeRoles)->firstWhere('slug', $aw->role); @endphp
                            <span class="badge badge-info">{{ $awRole?->name ?? $aw->role }}</span>
                        </td>
                        <td>
                            <span class="text-xs font-medium text-primary-700 bg-primary-50 px-2 py-1 rounded-full">Member / Allied Worker</span>
                        </td>
                        <td>
                            <button onclick="openRevoke({{ $aw->id }}, '{{ addslashes($aw->first_name.' '.$aw->last_name) }}')"
                                class="px-3 py-1.5 text-xs font-medium text-danger-600 bg-danger-50 rounded-lg hover:bg-danger-100 transition-colors">
                                Revoke
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">No Allied Workers yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Promote form -->
    <div class="card p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Promote a Member</h2>
        <p class="text-sm text-gray-500 mb-4">Choose an existing member and assign a custom staff role. The member keeps their existing account and member portal; they can switch to Allied Worker mode with their own password.</p>
        <form action="{{ route('allied-workers.promote') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Member <span class="text-red-500">*</span></label>
                    <select name="member_id" class="input" required>
                        <option value="">Select member</option>
                        @foreach($candidates as $m)
                        <option value="{{ $m->id }}">{{ $m->first_name }} {{ $m->last_name }} ({{ $m->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Allied Worker Role <span class="text-red-500">*</span></label>
                    <select name="role" class="input" required>
                        <option value="">Select role</option>
                        @foreach($activeRoles as $r)
                        <option value="{{ $r->slug }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Document <span class="text-red-500">*</span></label>
                    <input type="file" name="id_document" accept=".jpg,.jpeg,.png,.pdf" class="input" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                <input type="text" name="reason" class="input" placeholder="Optional note for the promotion">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    Promote to Allied Worker
                </button>
            </div>
        </form>
    </div>

    <!-- History -->
    <div class="card p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Assignment History</h2>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Role Change</th>
                        <th>Status</th>
                        <th>Assigned By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $h)
                    <tr>
                        <td>
                            <span class="text-sm font-medium text-gray-900">{{ $h->user?->first_name }} {{ $h->user?->last_name }}</span>
                        </td>
                        <td>
                            <span class="text-xs text-gray-500">{{ $h->previous_role }} → <strong>{{ $h->new_role }}</strong></span>
                        </td>
                        <td>
                            @if($h->status === 'active')
                            <span class="badge badge-primary">Active</span>
                            @else
                            <span class="badge badge-danger">Revoked</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-sm text-gray-500">{{ $h->assigner?->first_name }} {{ $h->assigner?->last_name }}</span>
                        </td>
                        <td>
                            <span class="text-sm text-gray-500">{{ $h->created_at?->format('M d, Y') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">No assignment history.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Manage Roles -->
    <div class="card p-6 mt-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Manage Roles</h2>
                <p class="text-sm text-gray-500">Create and delete custom roles. The General Manager holds full access (system roles cannot be removed)</p>
            </div>
        </div>

        <form id="createRoleForm" class="mb-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="role_name_input" class="input" placeholder="e.g. Staff" required oninput="generateRoleSlug(this.value)">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="slug" id="role_slug_hidden">
                        <code id="role_slug_preview" class="text-xs bg-gray-100 px-3 py-2 rounded flex-1 text-gray-500 min-h-[38px] flex items-center">—</code>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                    <input type="text" name="description" class="input" placeholder="Describe this role's responsibilities" required>
                </div>
            </div>

            <div class="mt-4 mb-4">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">Sidebar Access Permissions</h3>
                <p class="text-xs text-gray-500 mb-2">Check the sidebar sections this role grants access to. Leave all unchecked for no sidebar access. Settings and Finance are sensitive, but the Main Admin / General Manager may delegate them to custom roles. Savings and Share Capital are managed inside Finance.</p>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
                    @php
                        $sidebarMenus = [
                            'dashboard'           => ['label' => 'Dashboard',               'icon' => 'layout-dashboard'],
                            'members'             => ['label' => 'Accounts',                'icon' => 'users'],
                            'lendings'            => ['label' => 'Loans',                   'icon' => 'banknote'],
                            'payments'            => ['label' => 'Payments',                'icon' => 'credit-card'],
                            'finance'             => ['label' => 'Finance',                 'icon' => 'wallet'],
                            'reports'             => ['label' => 'Reports',                 'icon' => 'bar-chart-3'],
                            'seminars'            => ['label' => 'Seminar',                 'icon' => 'graduation-cap'],
                            'audit-logs'          => ['label' => 'Audit Logs',              'icon' => 'history'],
                            'officers-committees' => ['label' => 'Officers & Committees',   'icon' => 'briefcase'],
                            'settings'            => ['label' => 'Settings',                'icon' => 'settings'],
                        ];
                    @endphp
                    @foreach($sidebarMenus as $key => $menu)
                    <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors group">
                        <input type="checkbox" name="sidebar_permissions[]" value="{{ $key }}"
                            class="role-perm-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm font-medium text-gray-800 group-hover:text-primary-600 transition-colors">{{ $menu['label'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Create Role
                </button>
            </div>
        </form>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Sidebar Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td><span class="text-sm font-medium text-gray-900">{{ $role->name }}</span></td>
                        <td><span class="text-sm text-gray-500">{{ $role->description ?? '—' }}</span></td>
                        <td>
                            @if($role->is_system)
                            <span class="badge badge-primary">System</span>
                            @else
                            <span class="badge badge-info">Custom</span>
                            @endif
                        </td>
                        <td>
                            @if(is_null($role->sidebar_permissions))
                            <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">Full Access</span>
                            @elseif(empty($role->sidebar_permissions))
                            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-full">No Access</span>
                            @else
                            <div class="flex flex-wrap gap-1">
                                @foreach($role->sidebar_permissions as $perm)
                                <span class="text-xs bg-primary-50 text-primary-700 px-1.5 py-0.5 rounded">{{ $perm }}</span>
                                @endforeach
                            </div>
                            @endif
                        </td>
                        <td>
                            @if(!$role->is_system)
                            <div class="flex items-center gap-2">
                                <button onclick="openEditRole({{ $role->id }}, '{{ addslashes($role->name) }}', '{{ addslashes($role->description ?? '') }}', {{ json_encode($role->sidebar_permissions ?? []) }})"
                                    class="px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                                    Edit
                                </button>
                                <button onclick="confirmDeleteRole({{ $role->id }}, '{{ addslashes($role->name) }}')"
                                    class="px-3 py-1.5 text-xs font-medium text-danger-600 bg-danger-50 rounded-lg hover:bg-danger-100 transition-colors">
                                    Delete
                                </button>
                            </div>
                            @else
                            <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">No roles found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit role modal -->
    <div id="editRoleModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Edit Role</h3>
            <p class="text-sm text-gray-500 mb-4">Update the role's name, description and sidebar access permissions.</p>

            <form id="editRoleForm">
                @csrf
                <input type="hidden" name="id" id="edit_role_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_role_name_input" class="input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                        <input type="text" name="description" id="edit_role_description_input" class="input" required>
                    </div>
                </div>

                <div class="mt-4 mb-4">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Sidebar Access Permissions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($sidebarMenus as $key => $menu)
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="checkbox" name="sidebar_permissions[]" value="{{ $key }}" id="edit_perm_{{ $key }}"
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm font-medium text-gray-700">{{ $menu['label'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeEditRole()" class="btn btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Role</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Revoke modal -->
    <div id="revokeModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Revoke Allied Worker</h3>
            <p class="text-sm text-gray-500 mb-4">Revoke <strong id="revokeName"></strong> back to a regular member? Their account will be preserved.</p>
            <form action="{{ route('allied-workers.revoke') }}" method="POST">
                @csrf
                <input type="hidden" name="member_id" id="revokeMemberId">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                    <input type="text" name="reason" class="input" placeholder="Optional reason">
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRevoke()" class="btn btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-danger">Revoke</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRevoke(id, name) {
            document.getElementById('revokeMemberId').value = id;
            document.getElementById('revokeName').textContent = name;
            document.getElementById('revokeModal').classList.remove('hidden');
            document.getElementById('revokeModal').classList.add('flex');
        }
        function closeRevoke() {
            document.getElementById('revokeModal').classList.add('hidden');
            document.getElementById('revokeModal').classList.remove('flex');
        }

        // Role Management
        function generateRoleSlug(name) {
            const slug = name.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('role_slug_hidden').value = slug;
            document.getElementById('role_slug_preview').textContent = slug || '—';
        }

        document.getElementById('createRoleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const nameInput = document.getElementById('role_name_input');
            const slugHidden = document.getElementById('role_slug_hidden');
            if (!slugHidden.value && nameInput.value) {
                generateRoleSlug(nameInput.value);
            }
            if (!slugHidden.value) {
                showToast('Error', 'Please enter a role name.', 'error');
                return;
            }
            const formData = new FormData(this);

            fetch('{{ route('roles.store') }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Success', data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error', data.message, 'error');
                }
            })
            .catch(err => showToast('Error', 'Failed to create role', 'error'));
        });

        function confirmDeleteRole(id, name) {
            if (!confirm(`Delete role "${name}"? Users assigned this role will need to be reassigned.`)) return;

            const formData = new FormData();
            formData.append('id', id);

            fetch('{{ route('roles.delete') }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Success', data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error', data.message, 'error');
                }
            })
            .catch(() => showToast('Error', 'Failed to delete role', 'error'));
        }

        function openEditRole(id, name, desc, perms) {
            document.getElementById('edit_role_id').value = id;
            document.getElementById('edit_role_name_input').value = name;
            document.getElementById('edit_role_description_input').value = desc || '';
            document.querySelectorAll('#editRoleModal input[name="sidebar_permissions[]"]').forEach(cb => {
                cb.checked = (Array.isArray(perms) ? perms : []).includes(cb.value);
            });
            document.getElementById('editRoleModal').classList.remove('hidden');
            document.getElementById('editRoleModal').classList.add('flex');
        }

        function closeEditRole() {
            document.getElementById('editRoleModal').classList.add('hidden');
            document.getElementById('editRoleModal').classList.remove('flex');
        }

        const editRoleForm = document.getElementById('editRoleForm');
        if (editRoleForm) {
            editRoleForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('{{ route('roles.update') }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('Success', data.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast('Error', data.message, 'error');
                    }
                })
                .catch(() => showToast('Error', 'Failed to update role', 'error'));
            });
        }
    </script>
@endsection
