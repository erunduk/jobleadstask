<?php

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use App\Models\County;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with random data.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        factory(App\Models\User::class, 1)->create();
        $this->generateTaxes();
        factory(App\Models\State::class, 5)->create()->each(
            function ($state) use ($faker) {
                $models = factory(App\Models\County::class, rand(5, 7))->make();
                foreach ($models as $model) {
                    $county = $state->counties()->save($model);
                    $rates = $this->generateCountyRates(
                        $county,
                        $faker
                    );
                    $this->generateCountyPayments(
                        $county,
                        $faker,
                        $rates
                    );
                }
            }
        );
    }

    /**
     * Seed the county's tax rates records into database.
     *
     * @return void
     */
    private function generateCountyRates(County $county, Faker $faker)
    {
        $rates = [];
        $disabled = rand(1, 4);
        for ($i = 1; $i <= 4; $i++) {
            if ($i == $disabled) {
                // This county does not collect this random tax
                continue;
            }

            // Greater TAX ID should have more chances for higher tax rate.
            $rates[$i] = $faker->randomFloat(2, 0.05 * $i, 0.01 * $i);

            DB::table('taxes_rates')->insert([
                'tax_id' => $i,
                'rate' => $rates[$i],
                'county_id' => $county->id,
            ]);
        }
        return $rates;
    }

    /**
     * Seed the county's payments records into database.
     *
     * @return void
     */
    private function generateCountyPayments(County $county, Faker $faker, array $rates)
    {
        for ($i = 0; $i < 15; $i++) {
            foreach ($rates as $tax_id => $rate) {
                DB::table('payments')->insert([
                    'date' => date('Y-m-d', time() - 60 * 60 * 24 * $i),
                    'amount' => $faker->randomFloat(2, 100, 100000) * $rate,
                    'county_id' => $county->id,
                    'tax_id' => $tax_id,
                ]);
            }
        }
    }

    /**
     * Seed the taxes records into database.
     *
     * @return void
     */
    private function generateTaxes()
    {
        DB::table('taxes')->insert([
            'name' => 'Estate Buyer',
        ]);
        DB::table('taxes')->insert([
            'name' => 'Military',
        ]);
        DB::table('taxes')->insert([
            'name' => 'Estate Seller',
        ]);
        DB::table('taxes')->insert([
            'name' => 'VAT',
        ]);
    }
}
