<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('products', function (BluePrint $table) {
        //     $table->addColumn('ratings', function () {
        //         return [
        //             'nullable',
        //             'integer|max:5|min:1',

        //         ];
        //     })->nullable()->check('ratings BETWEEN 1 and 5')->default(null);
        // });

        Schema::table('products', function (Blueprint $table) {
            $table->addColumn('integer', 'ratings', [
                'nullable' => true,
                'default' => null,
            ])->check('ratings BETWEEN 1 AND 5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('ratings');
        });
    }
};