<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahPj extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
                $pj = \App\Models\PersonInCharge::class;
                $location = \App\Models\AssetLocation::class;
        
                $pj::insert(
                    [
                        [
                            'pic_name' => 'Laboratorium Dasar Komputasi',
                            'email' =>'ldkom@gmail.com',
                            'username'=>'ldkom',
                            'password'=>'$2y$10$0DCzU5SPuQ9BRYxJkn0FOuF/HlSb1eqCJ0ondcouVonhEqblVUZKO' //12345
                        ],
                        [
                            'pic_name' => 'Laboratorium of Enterprise Application',
                            'email' =>'lea@gmail.com',
                            'username'=>'lea',
                            'password'=>'$2y$10$0DCzU5SPuQ9BRYxJkn0FOuF/HlSb1eqCJ0ondcouVonhEqblVUZKO' //12345
                        ],
                        [
                            'pic_name' => 'Laboratory of Geographic Information System',
                            'email' =>'lgis@gmail.com',
                            'username'=>'lgis',
                            'password'=>'$2y$10$0DCzU5SPuQ9BRYxJkn0FOuF/HlSb1eqCJ0ondcouVonhEqblVUZKO' //12345
                        ],
                        [
                            'pic_name' => 'Laboratory of Business Intelligence',
                            'email' =>'lbi@gmail.com',
                            'username'=>'lbi',
                            'password'=>'$2y$10$0DCzU5SPuQ9BRYxJkn0FOuF/HlSb1eqCJ0ondcouVonhEqblVUZKO' //12345
                        ],
                        [
                            'pic_name' => 'Himpunan Mahasiswa Sistem Informasi',
                            'email' =>'hmsi@gmail.com',
                            'username'=>'hmsi',
                            'password'=>'$2y$10$0DCzU5SPuQ9BRYxJkn0FOuF/HlSb1eqCJ0ondcouVonhEqblVUZKO' //12345
                        ],
                        
                      
        
                    ]
            );

            $location::insert(
                [
                    [
                        'location_name' => 'Ruang Laboratorium Dasar Komputasi',
                    ],
                    [
                        'location_name' => 'Ruang Laboratorium of Enterprise Application',
                    ],
                    [
                        'location_name' => 'Ruang Laboratory of Geographic Information System',
                    ],
                    [
                        'location_name' => 'Ruang Laboratory of Business Intelligence',
                    ],
                    [
                        'location_name' => 'Ruang Himpunan Mahasiswa Sistem Informasi',
                    ],
                    
                
    
                ]
        );
            }
        


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $pj = \App\Models\AssetType::class;
        $location = \App\Models\AssetLocation::class;
        
        $pj::query()->delete();
        $location::query()->delete();
    }
}
