<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // Expense ID: A unique identifier for each expense entry
            $table->string('slug'); // Slug
            $table->date('expense_date'); // Expense Date: The date when the expense was incurred
            $table->string('expense_category'); // Expense Category: The category of the expense
            $table->text('expense_description')->nullable(); // Expense Description: A brief description of the expense
            $table->decimal('expense_amount', 10, 2); // Expense Amount: The amount when the expense was incurred
            $table->unsignedBigInteger('store_id'); // Foreign key to stores table
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade'); // Foreign key constraint
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
