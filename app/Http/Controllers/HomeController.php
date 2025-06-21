<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Item;

// Google Cloud Vision classes
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type as FeatureType;


class HomeController extends Controller
{
    /**
     * Show the student’s homepage with their lost & found items.
     */
    public function index($username)
    {
        if (! Session::has('student')) {
            return redirect('/');
        }

        $student = Session::get('student');
        if (! $student || ! isset($student['email'])) {
            return redirect('/')
                ->withErrors('Session expired or corrupted. Please log in again.');
        }

        $studentModel = Student::where('username', $username)->firstOrFail();

        $lostItems  = Item::where('type', 'lost')
                           ->where('from', $student['email'])
                           ->get();
        $foundItems = Item::where('type', 'found')
                           ->where('from', $student['email'])
                           ->get();

        // Combine lost and found items into one collection for the view
        $items = $foundItems->merge($lostItems);

        $mapItems = Item::whereNotNull('latitude')
                        ->whereNotNull('longitude')
                        ->get();

        return view('home', compact(
            'studentModel',
            'lostItems',
            'foundItems',
            'mapItems',
            'items'
        ));
    }

    /**
     * Handle posting a new lost or found item.
     */
    public function add(Request $request, $username)
    {
        // Validate inputs, including coordinates
        $request->validate([
            'description' => 'required|string|max:255',
            'pic'         => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:10240',
            'type'        => 'required|in:lost,found',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $student = Session::get('student');
        if (! $student) {
            return redirect('/')
                ->withErrors('Student session not found');
        }

        // Increment counter for the type (lost or found)
        $counterField = $request->type;
        $newCount = $student[$counterField] + 1;
        Student::where('email', $student['email'])
               ->update([$counterField => $newCount]);
        Session::put("student.{$counterField}", $newCount);

        // Store uploaded image
        $file     = $request->file('pic');
        $filename = "{$student['username']}-{$request->type}{$newCount}." . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);

        // Run image recognition with Google Vision API
        $imageLabels = $this->recognizeImage(public_path("images/{$filename}"));

        // Prepare data array for insertion
        $data = [
            'from'            => $student['email'],
            'description'     => $request->description,
            'pic'             => $filename,
            'type'            => $request->type,
            'status'          => 'Unresolved',
            'image_labels'    => json_encode($imageLabels),
            'selected_label'  => null,               // newly added column stays null for now
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'created_at'      => now(),
            'updated_at'      => now(),
        ];

        // Use insertGetId to ensure we retrieve the actual auto-increment ID
        $newItemId = Item::insertGetId($data);

        // Redirect back, flashing both the labels and the new item’s ID
        return redirect()
            ->route('home.index', ['username' => $username])
            ->with([
                'image_labels' => $imageLabels,
                'last_item_id' => $newItemId,
            ]);
    }

    /**
     * Recognize image content using Google Vision API
     */
    private function recognizeImage(string $imagePath): array
{
    $client = new ImageAnnotatorClient([
        'credentials' => storage_path('app/neon-essence-457316-i3-c0efd7d28aaa.json'),
    ]);

    $visionImage = (new Image())->setContent(file_get_contents($imagePath));
    $feature     = (new Feature())->setType(FeatureType::LABEL_DETECTION);

    $req = (new AnnotateImageRequest())
        ->setImage($visionImage)
        ->setFeatures([$feature]);

    $batchRes  = $client->batchAnnotateImages([$req]);
    $responses = $batchRes->getResponses();

    $labels = [];
    if (isset($responses[0])) {
        foreach ($responses[0]->getLabelAnnotations() as $label) {
            $labels[] = $label->getDescription();
        }
    }

    $client->close();
    return $labels;
}


    /**
     * Optional searchItems
     */
   public function searchItems(Request $request)
    {
    $searchTerm = strtolower($request->input('search'));

    $query = DB::table('items')
        ->whereRaw('LOWER(JSON_EXTRACT(range_tablets, "$")) LIKE ?', ['%' . $searchTerm . '%']);

    // Only exclude archived items for non-admins
    if (!session()->has('admin')) {
        $query->where('status', '!=', 'Archived');
    }

    $items = $query->get();

    return view('search-results', compact('items'));
    }

    /**
     * Update the selected_label (manual override) for a given item.
     */
    public function updateLabel(Request $request, $id)
    {
        $request->validate([
            'selected_label' => 'required|string|max:255',
        ]);

        $item = Item::findOrFail($id);
        $item->selected_label = $request->input('selected_label');
        $item->save();

        return back()->with('success', 'Label updated.');
    }
}
