<?php

namespace App\Http\Controllers;

use App\services\BoardService;
use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private BoardService $board;
    public function __construct(BoardService $board)
    {
        $this->board = $board;
    }
    public function index(Request $request){

        $boardMembers = $this->board->getEntries($request);
        return view('admin.board.index',['boardMembers'=> $boardMembers ] );

    }
    public function create()
    {
        return view('admin.board.form');
    }

    public function store(Request $request)
    {
        $this->board->store($request);
        return redirect()->route('admin.board.index');
    }

    public function show($id)
    {
        $boardMember = BoardMember::findOrFail($id);
        return view('admin.board.form', compact('boardMember'));
    }

    public function update(Request $request, $id)
    {
        $this->board->update($request, $id);
        return redirect()->route('admin.board.index');
    }


    public function delete($id){
        $this->board->delete($id);
        return redirect()->route('admin.board.index');
    }
}
