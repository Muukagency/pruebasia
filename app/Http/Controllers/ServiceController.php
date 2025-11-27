<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::paginate();
        return view('services.index', compact('services'));
    }

    public function create(): View
    {
        return view('services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'is_active' => 'boolean'
        ]);
        Service::create($data);
        return redirect()->route('services.index')->with('success', 'Servicio creado.');
    }

    public function edit(Service $service): View
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'is_active' => 'boolean'
        ]);
        $service->update($data);
        return redirect()->route('services.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Servicio eliminado.');
    }
}
