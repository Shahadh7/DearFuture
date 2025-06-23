<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreCapsuleRequest;
use App\Http\Requests\UpdateCapsuleRequest;

class CapsuleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Capsule::class, 'capsule');
    }

    public function index(Request $request)
    {
        $query = auth()->user()->capsules()->with('media');

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $capsules = $query->latest()->paginate(12)->withQueryString();

        return Inertia::render('Capsules/Index', [
            'capsules' => $capsules,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Capsules/Create');
    }

    public function store(StoreCapsuleRequest $request)
    {
        $capsule = auth()->user()->capsules()->create($request->validated());

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $capsule->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return redirect()->route('capsules.index')->with('success', 'Capsule created successfully.');
    }

    public function show(Capsule $capsule)
    {
        return Inertia::render('Capsules/Show', [
            'capsule' => $capsule->load('media', 'user'),
        ]);
    }

    public function edit(Capsule $capsule)
    {
        return Inertia::render('Capsules/Edit', [
            'capsule' => $capsule,
        ]);
    }

    public function update(UpdateCapsuleRequest $request, Capsule $capsule)
    {
        $capsule->update($request->validated());

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $capsule->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return redirect()->route('capsules.index')->with('success', 'Capsule updated successfully.');
    }

    public function destroy(Capsule $capsule)
    {
        $capsule->delete();
        return redirect()->route('capsules.index')->with('success', 'Capsule deleted successfully.');
    }

    public function unlock($token)
    {
        $capsule = Capsule::where('delivery_token', $token)
            ->where('status', 'delivered')
            ->firstOrFail();

        return Inertia::render('Capsules/Unlock', [
            'capsule' => $capsule->load('media', 'user'),
        ]);
    }

    public function removeAttachment(Request $request, Capsule $capsule, $mediaId)
    {
        $this->authorize('update', $capsule);

        $media = $capsule->media()->findOrFail($mediaId);
        $media->delete();

        return back()->with('success', 'Attachment removed successfully.');
    }
}
