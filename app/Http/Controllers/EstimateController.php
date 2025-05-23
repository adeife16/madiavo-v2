<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EstimateRequest;
use App\Models\Estimate;
use App\Services\EstimateService;

class EstimateController extends Controller
{
    public function index()
    {
        return response()->json(Estimate::with(['client', 'saleAgent'])->latest()->paginate(20));
    }

    public function store(EstimateRequest $request, EstimateService $service)
    {
        $estimate = $service->create($request->validated());
        return response()->json($estimate, 201);
    }

    public function show(Estimate $estimate)
    {
        return response()->json($estimate->load(['client', 'saleAgent']));
    }

    public function update(EstimateRequest $request, Estimate $estimate, EstimateService $service)
    {
        $estimate = $service->update($estimate, $request->validated());
        return response()->json($estimate);
    }

    public function destroy(Estimate $estimate)
    {
        $estimate->delete();
        return response()->noContent();
    }
}
