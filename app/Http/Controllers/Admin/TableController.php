<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TableStatus;
use App\Enums\TableLocations;
use App\Http\Controllers\Controller;
use App\Http\Requests\TableStoreRequest;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::all();
        return view('admin.tables.index', ['tables' => $tables]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tableStatus = TableStatus::cases();
        $tableLocations = TableLocations::cases();

        return view('admin.tables.create', compact('tableStatus', 'tableLocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TableStoreRequest $request)
    {
        Table::create([
            'name' => $request->name,
            'guest_num' => $request->guest_num,
            'status' => $request->status,
            'location' => $request->location,
        ]);

        return to_route('admin.tables.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        $tableStatus = TableStatus::cases();
        $tableLocations = TableLocations::cases();

        return view('admin.tables.edit', compact('table', 'tableStatus', 'tableLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TableStoreRequest $request, Table $table)
    {
        $table->update($request->validated());

        return to_route('admin.tables.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->back();
    }
}
