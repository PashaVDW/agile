<?php

namespace App\Http\Controllers;

use App\Http\Requests\SponsorRequest;
use App\Services\SponsorService;

class SponsorController extends Controller
{
    private SponsorService $sponsorService;
    private $types = ['active', 'inactive'];

    public function __construct(SponsorService $sponsorService)
    {
        $this->sponsorService = $sponsorService;
    }

    public function index()
    {
       $sponsors = $this->sponsorService->getSponsors();
       return view('sponsors.index', ['sponsors' => $sponsors, 'types' => $this->types]);
    }

    public function create()
    {
        return view('sponsors.show', ['types' => $this->types]);
    }

    public function store(SponsorRequest $request)
    {
        $this->sponsorService->storeSponsor($request);
        return to_route('sponsors.index');
    }

    public function sponsor($id)
    {
        $sponsor = $this->sponsorService->getSponsor($id);
        return view('sponsors.show', ['sponsor' => $sponsor, 'types' => $this->types]);
    }

    public function update(SponsorRequest $request, $id)
    {
        $this->sponsorService->updateSponsor($request, $id);
        return to_route('sponsors.index');
    }

    public function delete($id)
    {
        $this->sponsorService->deleteSponsor($id);
        return to_route('sponsors.index');
    }
}
