<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create(['name' => 'Chris Breuer', 'email' => 'chris@ordern.co']);
        factory(App\User::class)->create(['name' => 'Nikola Gavric', 'email' => 'nikola@ordern.co']);
        factory(App\User::class)->create(['name' => 'Mohamed Benhida', 'email' => 'mohamed@ordern.co', 'is_admin' => true]);

        factory(App\Customer::class, 1000)->create()->each(function ($customer) {
            $customer->update([
                'company_id' => factory(App\Company::class)->create()->id,
                'sales_rep_id' => random_int(1, 2),
            ]);

            $customer->interactions()->saveMany(factory(App\Interaction::class, 500)->make());
        });
    }
}
