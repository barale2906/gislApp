<?php

namespace Database\Seeders;

use App\Models\Financiera\Librodiario;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class LibrodiarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = 0;

        if(($handle = fopen(public_path() . '/csv/librodiario.csv', 'r')) !== false) {

                while(($data = fgetcsv($handle, 26000, ';')) !== false) {

                    $row++;

                    try {

                        Librodiario::create([
                            'banco_id'=>$data[0],
                            'concepto_id'=>$data[1],
                            'fecha'=>$data[2],
                            'valor'=>$data[3],
                            'saldo'=>$data[4],
                            'tipo'=>$data[5],
                            'comentario'=>$data[6],
                            'status'=>$data[7],
                        ]);



                    }catch(Exception $exception){
                        Log::info('Line: ' . $row . ' librodiario with error: ' . $exception->getMessage());
                    }

                }
        }

        fclose($handle);
    }
}
