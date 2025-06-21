@php
    use App\Models\Claim;
    use App\Models\Student;

    $student = session('student');
    $auth = Student::where('email', $student['email'])->first();

    // Get the most recent claim involving this student
    $claim = Claim::where('claimed_by', $student['email'])
                ->orWhere('claimed_to', $student['email'])
                ->latest()
                ->first();

    // Determine chat partner's ID
    $targetId = null;
    if ($claim && $auth) {
        $claimedBy = Student::where('email', $claim->claimed_by)->first();
        $claimedTo = Student::where('email', $claim->claimed_to)->first();

        $targetId = $claimedBy && $auth->id === $claimedBy->id
                    ? optional($claimedTo)->id
                    : optional($claimedBy)->id;
    }
@endphp

<div class="flex justify-center space-x-8 py-4 text-white text-xl">
    {{-- Home --}}
    <a href="/home/{{ $student['username'] ?? '' }}" title="Home" class="hover:text-gray-300 transition">
        <i class="fa fa-home"></i>
    </a>

    {{-- Search --}}
    <a href="{{ route('search.page') }}" title="Search Items" class="hover:text-gray-300 transition">
        <i class="fa fa-search"></i>
    </a>

        {{-- Claim Requests --}}
    <a href="/claim" title="Claim Requests" class="hover:text-gray-300 transition">
        <i class="fa fa-bell"></i>
    </a>

    {{-- Profile --}}
    <a href="/profile/{{ $student['username'] ?? '' }}" title="{{ $student['name'] ?? 'Guest' }}" class="hover:text-gray-300 transition">
        <i class="fa fa-user"></i>
    </a>


    {{-- Logout --}}
    <a href="/logout" title="Logout" class="hover:text-gray-300 transition">
        <i class="fa fa-power-off"></i>
    </a>
</div>
