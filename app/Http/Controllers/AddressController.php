<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = auth()->user()->addresses();

        return ResponseFormatter::success($addresses->pluck('api_response'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(request()->all(), $this->getValidation());

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $address = auth()->user()->addresses()->create($this->preparedData());

        return $this->show($address->uuid);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $address = auth()->user()->addresses()->where('uuid', $uuid)->firstOrFail();

        return ResponseFormatter::success($address->api_response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $validator = \Validator::make(request()->all(), $this->getValidation());

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $address = auth()->user()->addresses()->where('uuid', $uuid)->firstOrFail();
        $address->update($this->preparedData());

        return $this->show($address->uuid);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $address = auth()->user()->addresses()->where('uuid', $uuid)->firstOrFail();
        $address->delete();

        return ResponseFormatter::success(['is_deleted' => true]);
    }

    protected function getValidation()
    {
        return [
            'is_default' => 'required|in:1,0',
            'receiver_name' => 'required|min:2|max:30',
            'receiver_phone' => 'required|min:2|max:30',
            'city_uuid' => 'required|exists:cities,uuid',
            'district' => 'required|min:3|max:50',
            'postal_code' => 'required|numberic|min:5|max:10',
            'detail_address' => 'nullable|max:255',
            'address_note' => 'nullable|max:255',
            'type' => 'required|in:home,office',
        ];
    }

    protected function preparedData()
    {
        $payload = request()->only([
            'is_default',
            'receiver_name',
            'receiver_phone',
            'city_uuid',
            'district',
            'postal_code',
            'detail_address',
            'address_note',
            'type',
        ]);

        $payload['city_id'] = \App\Models\City::where('uuid', $payload['city_uuid']);

        return $payload;
    }
}