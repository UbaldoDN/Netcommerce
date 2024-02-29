<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company = Company::with(['tasks.user']);
        if ($request->name) {
            $company = Company::with(['tasks.user'])->where('name', 'like', "%{$request->name}%");
        }

        return response()->json($company->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        return response()->json(Company::create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company = Company::with(['tasks.user'])->find($company->id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->all());
        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(true, 204);
    }
}
