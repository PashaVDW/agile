<?php

namespace App\Services;

use App\Http\Requests\SponsorRequest;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Storage;

class SponsorService
{
    public function getSponsors()
    {
        return Sponsor::query()->with('events');
    }

    public function storeSponsor(SponsorRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = 'images/' . $file->getClientOriginalName();
            if (!Storage::disk('public')->exists($filePath)) {
                $filePath = $file->storeAs('images', $file->getClientOriginalName(), 'public');
            }
            $data['image'] = $filePath;
        }
        $sponsor = Sponsor::create($data);

        $sponsor->events()->sync($request->input('events', []));
    }

    public function getSponsor($id)
    {
        return Sponsor::with('events')->find($id);
    }

    public function updateSponsor(SponsorRequest $request, $id)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = 'images/' . $file->getClientOriginalName();
            if (!Storage::disk('public')->exists($filePath)) {
                $filePath = $file->storeAs('images', $file->getClientOriginalName(), 'public');
            }
            $data['image'] = $filePath;
        }
        $sponsor = Sponsor::find($id);
        $sponsor->update($data);
        $sponsor->events()->sync($request->input('events', []));
    }

    public function deleteSponsor($id)
    {
        Sponsor::destroy($id);
    }
}
