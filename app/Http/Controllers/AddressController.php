<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;

class AddressController extends Controller
{
    public function getProvince()
    {
        $provinces = \App\Models\Province::get(['uuid','name']);

        return ResponseFormatter::success($provinces);
    }

    public function getCity()
    {
        $query = \App\Models\City::query();
        if(request()->filled('province_uuid')) {
            $query = $query->where('province_id', function($subQuery){
                $subQuery->from('provinces')->where('uuid', request()->province_uuid)->select('id');
            });
        }

        if(request()->search) {
            $query = $query->where('name', 'LIKE', '%'.request()->search.'%');
        }

        $cities = $query->get();

        return ResponseFormatter::success($cities->pluck('api_response'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = auth()->user()->addresses()->get();

        return ResponseFormatter::success(
            $addresses->map->api_response
        );
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

        $response = \Http::withHeaders([
            'key' => config('services.rajaongkir.api_key')
        ])->get(config('services.rajaongkir.base_url') . '/destination/domestic-destination', [
            'search' => request()->postal_code,
        ]);

        if ($response->object()->meta->code == '404' || !isset($response->object()->data[0])) {
            return ResponseFormatter::error(400, [
                'Kode POS tidak ditemukan!'
            ]);
        }

        $payload = $this->preparedData();
        $payload['rajaongkir_subdistrict_id'] = $response->object()->data[0]->id;

        $address = auth()->user()->addresses()->create($payload);
        $address->refresh();

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

        $response = \Http::withHeaders([
            'key' => config('services.rajaongkir.api_key')
        ])->get(config('services.rajaongkir.base_url') . '/destination/domestic-destination', [
            'search' => request()->postal_code,
        ]);

        if ($response->object()->meta->code == '404' || !isset($response->object()->data[0])) {
            return ResponseFormatter::error(400, [
                'Kode POS tidak ditemukan!'
            ]);
        }

        $payload = $this->preparedData();
        $payload['rajaongkir_subdistrict_id'] = $response->object()->data[0]->id;

        $address->update($payload);
        $address->refresh();

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

    public function setDefault(string $uuid)
    {
        $address = auth()->user()->addresses()->where('uuid', $uuid)->firstOrFail();
        $address->update(['is_default' => true]);

        auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);

        return ResponseFormatter::success(['is_success' => true]);
    }

    protected function getValidation()
    {
        return [
            'is_default' => 'required|in:1,0',
            'receiver_name' => 'required|min:2|max:30',
            'receiver_phone' => 'required|min:2|max:30',
            'city_uuid' => 'required|exists:cities,uuid',
            'district' => 'required|min:3|max:50',
            'postal_code' => 'required|numeric',
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

        $payload['city_id'] = \App\Models\City::where('uuid', $payload['city_uuid'])->firstOrFail()->id;

        if($payload['is_default'] == 1) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        return $payload;
    }
}
