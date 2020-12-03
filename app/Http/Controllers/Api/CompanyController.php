<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyItem;
use App\Models\Company;
use Illuminate\Http\Request;
use Storage;

class CompanyController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CompanyCollection(Company::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CompanyRequest  $CompanyRequest
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $url = null;
        if ($request->file('logo')) {
            $image = $request->file('logo');
            $uploadPath = $image->store('company', 'public');
            $url = Storage::disk('public')->url($uploadPath);
        }

        if ($data = Company::create($this->payload($request, $url))) {
            $data->logo = $url;
            return response()->json([
                'message' => 'OK',
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'message' => 'Bad Request',
            'data' => [],
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyItem($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\CompanyRequest  $CompanyRequest
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $url = null;
        if ($request->file('logo')) {
            $image = $request->file('logo');
            $uploadPath = $image->store('company', 'public');
            $url = Storage::disk('public')->url($uploadPath);
        }

        if ($company->update($this->payload($request, $url))) {
            return response()->json([
                'message' => 'OK',
                'data' => $company,
            ], 201);
        }

        return response()->json([
            'message' => 'Bad Request',
            'data' => [],
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $data = $company;
        if ($company->delete()) {
            return response()->json([
                'message' => 'OK',
                'data' => $data,
            ], 200);
        }

        return response()->json([
            'message' => 'Bad Request',
            'data' => [],
        ], 400);
    }

    /**
     * Generate payload
     *
     * @param  App\Http\Requests\CompanyRequest  $request
     * @param  String  $url
     * @return array
     */
    private function payload($request, $url)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'logo' => $url,
            'website' => $request->website,
        ];
    }
}
