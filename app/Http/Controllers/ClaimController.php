<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Student;
use App\Models\Claim;
use Illuminate\Support\Facades\Session;

class ClaimController extends Controller
{
public function index()
{
    if (!session('student')) {
        return redirect('/');
    }

    $student = session('student');
    $email = $student['email'] ?? null;

    $claimsQuery = Claim::where(function ($query) use ($email) {
        $query->where('claimed_to', $email)
              ->orWhere('claimed_by', $email);
    });

    // ✅ Allow only admins to see archived items
    $isAdmin = session('admin') || auth('admin')->check();

    if (!$isAdmin) {
        $claimsQuery->whereHas('item', function ($q) {
            $q->where('status', '!=', 'Archived');
        });
    }

    $claims = $claimsQuery->get();

    return view('claim')->with('claims', $claims);
}

public function claim()
{
    if (!session('student')) {
        return redirect('/');
    }

    $picName = basename(url()->current());
    $studentEmail = session('student')['email'];

    // 🔍 Retrieve fresh item object
    $item = Item::where('pic', $picName)->first();

    if (!$item || !$item->id) {
        \Log::error("Item not found or no ID for pic: $picName");
        return back()->withErrors(['Item not found']);
    }

    // 🧠 Check for existing claim
    $existingClaim = Claim::where('pic', $picName)
        ->where('claimed_by', $studentEmail)
        ->first();

    if ($item->status === 'Pending') {
        $item->update(['status' => 'Unresolved']);
        if ($existingClaim) {
            $existingClaim->delete();
        }
    } else {
        $item->update(['status' => 'Pending']);

        if ($existingClaim) {
            $existingClaim->update([
                'item_id' => $item->id,
                'claimed_to' => $item->from,
                'status' => 'Pending'
            ]);
        } else {
            Claim::create([
                'item_id'    => $item->id,   // 🔒 guaranteed not null
                'claimed_by' => $studentEmail,
                'claimed_to' => $item->from,
                'pic'        => $item->pic,
                'status'     => 'Pending'
            ]);
        }
    }

    return redirect()->back();
}

    public function approve($item_id)
{
    if (!session('student')) return redirect('/');

    $studentEmail = session('student')['email'];
    $item = Item::find($item_id);

    if (!$item || $item->from !== $studentEmail) {
        return redirect()->back()->withErrors(['Unauthorized']);
    }

    // Archive item
    $item->status = 'Archived';
    $item->save();

    return redirect('/claim')->with('success', 'Claim approved and item archived.');
}

    public function reject($item_id)
{
    if (!session('student')) return redirect('/');

    $studentEmail = session('student')['email'];
    $item = Item::find($item_id);

    if (!$item || $item->from !== $studentEmail) {
        return redirect()->back()->withErrors(['Unauthorized']);
    }

    // Set item as unresolved and delete claim
    $item->status = 'Unresolved';
    $item->save();

    Claim::where('item_id', $item_id)->delete();

    return redirect('/claim')->with('success', 'Claim rejected.');
}

   public function initiate(Request $request, $itemId)
{
    $student = Session::get('student');

    if (! $student) {
        return redirect('/')->withErrors('You must be logged in.');
    }

    $item = Item::findOrFail($itemId);

    if ($item->status !== 'Unresolved') {
        return back()->withErrors('This item cannot be claimed.');
    }

    // ✅ Use email instead of student ID
    Claim::create([
        'item_id'    => $item->id,
        'claimed_by' => $student['email'], // your current session email
        'claimed_to' => $item->from,        // email of the item owner
        'status'     => 'Pending',
    ]);

    return redirect()->route('claims.index')->with('success', 'Claim submitted successfully.');
}




    public function delete()
    {
        if (!session('student')) {
            return redirect('/');
        }

        // Future deletion logic here...
        return redirect('/claim');
    }
}
