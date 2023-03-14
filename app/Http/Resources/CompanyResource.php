<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo ? asset('storage/logos/' . $this->logo) : null,
            'website' => $this->website,
        ];
    }
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return new CompanyResource($company);
    }
}