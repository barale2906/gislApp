<?php

namespace Database\Seeders;

use App\Models\Financiera\Cartera;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CarteraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/cartera.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        Cartera::create([
                                    'cliente'       =>$data[0],
                                    'nit'           =>$data[1],
                                    'total'         =>$data[2],
                                    'saldo'         =>$data[3],
                                    'descuento'     =>$data[4],
                                    'factura_id'    =>$data[5],
                                    'comentarios'   =>"Genero la factura",
                                    'status'        =>$data[6],
                                ]);



                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' cartera with error: ' . $exception->getMessage());
                    }

                }
        }

        fclose($handle);
    }
}
