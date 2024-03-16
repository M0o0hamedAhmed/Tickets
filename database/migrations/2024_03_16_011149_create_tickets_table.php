<?php

use App\Enums\TicketSubTypeEnum;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('client_id')->nullable()->references('id')->on('users');
            $table->string('subject',256);
            $table->string('message',1024);
            $table->tinyInteger('type');//0 => Normal , 1 => transfer, 2 => complain
            $table->tinyInteger('sub_type')->default(TicketSubTypeEnum::WAITING->value);//0 => Open , 1 => waiting, 2 => closed
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
