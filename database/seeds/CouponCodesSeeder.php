<?php

use Illuminate\Database\Seeder;

class CouponCodesSeeder extends Seeder
{
//优惠券
    public function run()
    {
        factory(\App\Models\CouponCode::class, 20)->create();
    }
}
