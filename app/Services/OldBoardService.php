<?php

namespace App\Services;

use App\Http\Requests\BoardMemberRequest;
use App\Http\Requests\OldBoardsRequest;
use App\Models\BoardMember;
use App\Models\OldBoards;
use App\Services\ImageService;
use Illuminate\Http\Request;

class OldBoardService
{

    public function getEntries(Request $request)
    {
        $query = OldBoards::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $boardMembers = $query->paginate(10);
        return $boardMembers;
    }
    public function store(OldBoardsRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = ImageService::storeImage($request,'image','/board') ?? ($validated['image']?? null);

        OldBoards::create($validated);
    }
    public function update(OldBoardsRequest $request, $id)
    {
        $board = OldBoards::findOrFail($id);
        $validated = $request->validated();

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
        $board = OldBoards::findOrFail($id);
        if ($board->image) {
            @unlink(public_path($board->image)); // Delete old image
        }
        $board->delete();
    }
}
