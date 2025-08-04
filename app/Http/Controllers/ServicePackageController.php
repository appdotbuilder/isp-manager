<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicePackageRequest;
use App\Http\Requests\UpdateServicePackageRequest;
use App\Models\ServicePackage;
use Inertia\Inertia;

class ServicePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = ServicePackage::latest()->paginate(10);
        
        return Inertia::render('service-packages/index', [
            'packages' => $packages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('service-packages/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicePackageRequest $request)
    {
        $package = ServicePackage::create($request->validated());

        return redirect()->route('service-packages.show', $package)
            ->with('success', 'Service package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServicePackage $servicePackage)
    {
        $servicePackage->load('customers');
        
        return Inertia::render('service-packages/show', [
            'package' => $servicePackage
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServicePackage $servicePackage)
    {
        return Inertia::render('service-packages/edit', [
            'package' => $servicePackage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServicePackageRequest $request, ServicePackage $servicePackage)
    {
        $servicePackage->update($request->validated());

        return redirect()->route('service-packages.show', $servicePackage)
            ->with('success', 'Service package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServicePackage $servicePackage)
    {
        $servicePackage->delete();

        return redirect()->route('service-packages.index')
            ->with('success', 'Service package deleted successfully.');
    }
}