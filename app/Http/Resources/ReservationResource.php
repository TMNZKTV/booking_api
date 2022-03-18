<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name'=>$this->name,
            'conflict'=>$this->conflict,
            'visit_type'=>$this->visit_type,
            'phone'=>$this->phone,
            'note'=>$this->note,
            'date'=>$this->date,
            'table_id'=>$this->table_id,
            'place_id'=>$this->place_id,
            'prepayment'=>$this->prepayment,
            'amount'=>$this->amount,
            'from'=>$this->from,
            'to'=>$this->to,
            'arrived'=>$this->arrived,
            'late'=>$this->late,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'responsible_email'=>$this->responsible_email,
            'responsible_name'=>$this->responsible_name
        ];
    }

}
