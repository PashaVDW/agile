<?php

namespace App\Services;

use App\Models\BoardMember;
use App\Services\ImageService;
use Illuminate\Http\Request;

class BoardService
{

    public function getEntries(Request $request)
    {
        $query = BoardMember::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $boardMembers = $query->paginate(10);
        return $boardMembers;
    }
    public function store($request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|string',
            'role' => 'required|max:255|string',
            'description' => 'max:255|string',
        ]);
        $validated['image'] = ImageService::storeImage($request,'image','/board') ?? ($validated['image']?? null);

        BoardMember::create($validated);
    }
    public function update($request, $id)
    {
        $board = BoardMember::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255|string',
            'role' => 'required|max:255|string',
            'description' => 'max:255|string',
        ]);

        if ($request->hasFile('image')) {
            $newImage = $request->file('image');
            $newImageHash = md5_file($newImage->getRealPath());

            if($board->image){
                $existingImagePath = public_path($board->image);

                if(file_exists($existingImagePath)){
                    $existingImageHash = md5_file($existingImagePath);
                    if ($newImageHash !== $existingImageHash) {
                        $validated['image'] = ImageService::storeImage($request,'image','/board');
                    }
                }
                else{
                    $validated['image'] = ImageService::storeImage($request,'image','/board');
                }

            }
            else{
                $validated['image'] = ImageService::storeImage($request,'image','/board');
            }

        }


        $board->update($validated);
    }

    public function delete($id)
    {
        $board = BoardMember::findOrFail($id);
        if ($board->image) {
            @unlink(public_path($board->image)); // Delete old image
        }
        $board->delete();
    }
}
