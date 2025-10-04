<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'name', 'phone', 'password', 'email', 'address', 'pincode',
        'state', 'cin_no', 'BankName', 'BankACNo','BankIFSC', 'upiId', 
        'qrCodeUpload', 'join_date','expiry_date','status'
    ];


    public function canIntroducePlan($targetPlanId)
    {
        $myPlanRank = DB::table('plan_name_master')
            ->where('id', $this->select_plan_id)
            ->value('plan_rank');

        $targetPlanRank = DB::table('plan_name_master')
            ->where('id', $targetPlanId)
            ->value('plan_rank');

        return $myPlanRank >= $targetPlanRank;
    }



}