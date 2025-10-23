<?php
/**
 * Migration: create_user_identities_table
 *
 * Stores external identity links (Eventbrite) for SSO/OAuth login.
 * Unique constraint on (provider, provider_id) guarantees idempotency.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('user_identities', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('provider', 50);       // e.g., 'eventbrite'
            $t->string('provider_id', 191);   // EB user id
            $t->string('access_token', 255)->nullable();
            $t->string('refresh_token', 255)->nullable();
            $t->timestamp('token_expires_at')->nullable();
            $t->unique(['provider', 'provider_id']);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('user_identities');
    }
};
