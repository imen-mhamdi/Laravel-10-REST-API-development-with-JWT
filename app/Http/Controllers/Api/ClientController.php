<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $clients = Client::all();

        return response()->json([
            'clients' => $clients
        ]);
    }

    public function show($id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'message' => 'Client not found'
            ], 404);
        }

        return response()->json([
            'client' => $client
        ]);
    }


    public function store(StoreClientRequest $request): JsonResponse
    {
        $clientData = $request->validated();

        // Handle logo upload if exists
        if ($request->hasFile('logo')) {
            $clientData['logo'] = $this->uploadLogo($request);
        }

        $client = Client::create($clientData);

        return response()->json([
            'message' => 'Client created successfully',
            'client' => $client
        ], 201);
    }

    public function update(UpdateClientRequest $request, Client $client): JsonResponse
    {
        $clientData = $request->validated();

        // Handle logo upload if exists
        if ($request->hasFile('logo')) {
            $clientData['logo'] = $this->uploadLogo($request);
        }

        $client->update($clientData);

        return response()->json([
            'message' => 'Client updated successfully',
            'client' => $client
        ]);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'message' => 'Client deleted successfully'
        ]);
    }

    private function uploadLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required|mimes:png,jpg,jpeg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fix the errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $logoFile = $request->file('logo');
        $logoName = time() . '.' . $logoFile->getClientOriginalExtension();
        $logoFile->move(public_path('uploads'), $logoName); // Assurez-vous que 'uploads' est accessible publiquement

        return '/uploads/' . $logoName;
    }

    public function search(Request $request): JsonResponse
    {
        $query = Client::query();

        if ($request->filled('nom')) {
            $query->where('nom', 'LIKE', '%' . $request->nom . '%');
        }

        if ($request->filled('prenom')) {
            $query->where('prenom', 'LIKE', '%' . $request->prenom . '%');
        }

        if ($request->filled('nom_societe')) {
            $query->where('nom_societe', 'LIKE', '%' . $request->nom_societe . '%');
        }

        if ($request->filled('tel1')) {
            $query->where('tel1', 'LIKE', '%' . $request->tel1 . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->filled('adresse')) {
            $query->where('adresse', 'LIKE', '%' . $request->adresse . '%');
        }

        $clients = $query->get();

        return response()->json([
            'clients' => $clients
        ]);
    }
}
