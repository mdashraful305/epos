<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameIsActiveToStatusInProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('is_active', 'status');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });

        // Update existing records
        DB::table('products')->where('status', true)->update(['status' => 'active']);
        DB::table('products')->where('status', false)->update(['status' => 'inactive']);
    }

    public function down()
    {
        // Revert existing records
        DB::table('products')->where('status', 'active')->update(['status' => true]);
        DB::table('products')->where('status', 'inactive')->update(['status' => false]);

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('status', 'is_active');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });
    }
}
