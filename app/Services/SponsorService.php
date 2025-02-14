<?php

namespace App\Services;

use App\Http\Requests\SponsorRequest;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Storage;

class SponsorService
{
    public function getSponsors()
    {
        return Sponsor::all();
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
        Sponsor::create($data);
    }

    public function getSponsor($id)
    {
        return Sponsor::find($id);
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
        Sponsor::find($id)->update($data);
    }

    public function deleteSponsor($id)
    {
        Sponsor::destroy($id);
    }
}
