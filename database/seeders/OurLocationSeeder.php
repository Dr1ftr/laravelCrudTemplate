<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OurLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now(); // fire now() once, so all rows have the same time (because it's faster)
        
        $template = [ // template for locations, to avoid retyping everything
            "country" => "Nederland",
            "city" => "Utrecht",
            "street" => "Daltonlaan",

            "postal_code" => "3584 BK",

            Location::UPDATED_AT => $now,
            Location::CREATED_AT => $now
        ];

        $locations = [
            array_merge($template, [ // use the template
                "name" => "Met het schuine glazen dak",
                "street_number" => 300,
            ]),
            array_merge($template, [ // use the template
                "name" => "Verbonden met een pad door de lucht",
                "street_number" => 200,
            ]),
            array_merge($template, [ // use the template
                "name" => "Aan de andere kant in de hoek",
                "street_number" => 500,
            ]),
            array_merge($template, [ // use the template
                "name" => "Ergens anders...",

                "street" => "Niels Bohrweg",
                "street_number" => 121,

                "postal_code" => "3542 CA",
            ])
        ];

        Location::insert($locations);
    }
}
