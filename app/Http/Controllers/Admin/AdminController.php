<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminLog;
use App\Models\Item;
use App\Models\Student;
use App\Models\Claim;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->with('error', 'Invalid admin credentials.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login.form');
    }

    public function dashboard()
    {
        $totalUsers = Student::count();
        $totalLostItems = Item::where('type', 'lost')->count();
        $totalFoundItems = Item::where('type', 'found')->count();

        $typeCounts = Item::where('status', '!=', 'Archived')
    ->selectRaw('type, COUNT(*) as count')
    ->groupBy('type')
    ->pluck('count', 'type');


        return view('admin.dashboard', compact(
    'totalUsers',
    'totalLostItems',
    'totalFoundItems',
    'typeCounts' // ✅ updated variable name
));

    }

    public function moderationPage()
    {
        $allItems = Item::all();
        return view('admin.moderation', compact('allItems'));
    }

    public function claimsPage()
    {
        $claims = Claim::where('status', 'Pending')->with(['fromStudent', 'toStudent', 'item'])->get();
        return view('admin.claims', compact('claims'));
    }

    public function reportsPage()
    {
        $activityLogs = AdminLog::latest()->take(20)->get();
        return view('admin.reports', compact('activityLogs'));
    }

    public function moderate(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'action' => 'required|in:approve,flag,delete',
        ]);

        $item = Item::findOrFail($request->item_id);
        $adminId = Auth::guard('admin')->id();

        switch ($request->action) {
            case 'approve':
                $item->status = 'approved';
                break;
            case 'flag':
                $item->status = 'flagged';
                break;
            case 'delete':
                $item->delete();
                break;
        }

        $item->save();

        AdminLog::create([
            'admin_id' => $adminId,
            'item_id' => $item->id,
            'action' => $request->action,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->back()->with('status', 'Item ' . $request->action . ' successfully.');
    }

    public function moderateClaim(Request $request)
    {
        $request->validate([
            'claim_id' => 'required|exists:claims,id',
            'action' => 'required|in:approve,reject',
        ]);

        $claim = Claim::findOrFail($request->claim_id);

        switch ($request->action) {
            case 'approve':
                $claim->status = 'Approved';
                break;
            case 'reject':
                $claim->status = 'Rejected';
                break;
        }

        $claim->save();

        AdminLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'item_id' => $claim->item_id,
            'action' => "Moderated claim #{$claim->id} ({$request->action})"
        ]);

        return redirect()->back()->with('status', 'Claim ' . $request->action . ' successfully.');
    }

    public function getItemDetails($id)
    {
        $item = Item::find($id);

        if (! $item) {
            return response()->json(['error' => 'Item not found.'], 404);
        }

        return response()->json([
            'id' => $item->id,
            'type' => $item->type,
            'description' => $item->description,
            'image' => asset('storage/' . $item->pic),
            'created_at' => $item->created_at->diffForHumans(),
            'is_approved' => $item->is_approved ?? null,
            'is_flagged' => $item->is_flagged ?? null,
        ]);
    }
    public function claims(Request $request)
{
    $query = Claim::with(['item', 'fromStudent', 'toStudent']);

    if ($request->has('status') && $request->status !== 'all') {
        $query->where('status', ucfirst($request->status));
    }

    if ($request->has('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('claimed_by', 'like', '%' . $request->search . '%')
              ->orWhereHas('item', function ($q2) use ($request) {
                  $q2->where('description', 'like', '%' . $request->search . '%');
              });
        });
    }

    $claims = $query->latest()->paginate(6);

    return view('admin\claims', compact('claims'));
}


}
