@extends('Layout.index')

@section('title', 'Users Management')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">System <span class="text-orange-500">Users</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Control system access, roles, and administrative permissions.</p>
        </div>
        <a href="{{ route('user.create') }}" class="btn-premium">
            <i class="fas fa-user-plus"></i>
            <span>Create User</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="p-4 bg-orange-500/10 border border-orange-500/20 text-orange-500 rounded-xl text-xs font-bold">
            <i class="fas fa-check-circle mr-1"></i>{{ session('success') }}
        </div>
    @endif

    <!-- User Table -->
    <div class="premium-card overflow-hidden stagger-2">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">User Identity</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Role</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Status</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Activity</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($users as $user)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white font-bold shadow-md shadow-orange-500/20 overflow-hidden">
                                        @if($user->photo)
                                            <img src="{{ cloudinary_url($user->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-center">
                                @if($user->role === 'manager')
                                    <span class="px-2 py-1 rounded-md bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[10px] font-extrabold uppercase">
                                        Manager
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-md bg-slate-500/10 text-slate-600 dark:text-slate-400 text-[10px] font-extrabold uppercase">
                                        Cashier
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-8 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Active</span>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-center text-[10px] font-bold text-slate-400 uppercase">
                                {{ $user->updated_at->diffForHumans() }}
                            </td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('user.edit', $user->id) }}" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form id="delete-user-form-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteUser({{ $user->id }})" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                                No staff members registered.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function confirmDeleteUser(id) {
    Swal.fire({ icon:'error', title:'Delete Staff Member?', text:'This user will be permanently removed from the system.', showCancelButton:true, confirmButtonText:'Delete', cancelButtonText:'Cancel' }).then((r) => { if(r.isConfirmed) document.getElementById('delete-user-form-'+id).submit(); });
}
</script>
@endsection
