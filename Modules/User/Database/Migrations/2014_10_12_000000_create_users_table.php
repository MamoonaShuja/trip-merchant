<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->uuid("user_uuid")->index("user_uuid")->unique("user_uuid");
            $table->string("slug")->index("idx_user-slug")->unique("uidx_user-slug");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("contact")->nullable();
            $table->string("dob")->nullable();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            $table->string("province")->nullable();
            $table->string("email")->index("idx_user-email")->unique("uidx_user-email");
            $table->timestamp("email_verified_at")->nullable();
            $table->string('organization_name')->nullable();
            $table->string('website')->index("idx_supplier-website")->unique("idx_supplier-website")->nullable();
            $table->text('message')->nullable();
            $table->text('supplier_bio')->nullable()->comment("Bio or About info for supplier");
            $table->string('no_of_employees')->index("idx_orgnization-employee-count")->nullable();
            $table->string('organization_code')->index("idx_organization-unique-code")->unique("idx_organization-unique-code")->nullable();
            $table->string('domain')->index("idx_organization-domain")->unique("idx_organization-domain")->nullable();
            $table->boolean('is_approved')->index("idx_organization-supplier-approval");
            $table->text('admin_message')->nullable()->comment('message that could be sent to a user when their request is unapproved by an admin:');
            $table->string("password");
            $table->foreignId("role_id");
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreignId("organization_id")->nullable();
            $table->foreign('organization_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
