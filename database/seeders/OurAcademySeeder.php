<?php

namespace Database\Seeders;

use App\Models\Academy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OurAcademySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now(); // fire now() once, so all rows have the same time (because it's faster)
        
        $template = [ // template for academies, to avoid retyping everything
            Academy::UPDATED_AT => $now,
            Academy::CREATED_AT => $now
        ];

        $academies = [
            array_merge($template, [ // use the template
                "name" => "Software developer",
                "crebo_number" => 25604,
            ]),
            array_merge($template, [ // use the template
                "name" => "Allround medewerker IT systems and devices",
                "crebo_number" => 25605,
            ]),
            array_merge($template, [ // use the template
                "name" => "Medewerker ICT support",
                "crebo_number" => 25607,
            ]),
            array_merge($template, [ // use the template
                "name" => "Expert IT systems and devices",
                "crebo_number" => 25606,
            ])
        ];

        Academy::insert($academies);
    }
}
