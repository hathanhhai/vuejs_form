<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Invoice;
class InvoiceTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Factory::create();
        Invoice::truncate();
        \App\InvoiceProduct::truncate();

        foreach (range(1,20)as $i){
            $products = collect();

            foreach (range(1,mt_rand(2,10)) as $item){
                $price = $faker->numberBetween(100,1000);
                $qty = $faker->numberBetween(1,20);
                $products->push(new \App\InvoiceProduct([
                    'name'=>$faker->sentence,
                    'price'=>$price,
                    'qty'=>$qty,
                    'total'=>($price*$qty)
                ]));
            }

            $sub_total = $products->sum('total');
            $discount = $faker->numberBetween(10,20);
            $grandTotal = $sub_total-$discount;

            $invoice = Invoice::create([
                'client'=>$faker->name,
                'client_address'=>$faker->address,
                'title'=>$faker->sentence,
                'invoice_no'=>$faker->numberBetween(1000,4000),
                'invoice_date'=>$faker->date,
                'due_date'=>$faker->date,
                'discount'=>$discount,
                'sub_total'=>$sub_total,
                'grand_total'=>$grandTotal
            ]);

            $invoice->products()->saveMany($products);



        }




    }
}
