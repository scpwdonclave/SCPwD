<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tp_id')->unique();
            
            /* Basic Registration */
            $table->string('spoc_name');
            $table->string('email')->unique();
            $table->string('spoc_mobile')->unique();
            $table->string('password');
            $table->string('incorp_doc');
            /* End Basic Registration */

            /* Full Registration */
            /* General Details */
            $table->string('org_name')->default('No Data');
            $table->string('org_type')->default('No Data');
            $table->string('estab_year')->default('No Data');
            $table->string('landline')->nullable();
            $table->string('website')->nullable();
            /* End General Details */
            
            /* CEO/MD/Head of the Organization Details */
            $table->string('ceo_name')->nullable();
            $table->string('ceo_email')->nullable();
            $table->string('ceo_mobile')->nullable();
            /* End CEO/MD/Head of the Organization Details */

            /* Authorized Signatory Info */
            $table->string('signatory_name')->nullable();
            $table->string('signatory_email')->nullable();
            $table->string('signatory_mobile')->nullable();
            /* End Authorized Signatory Info */

            /* Address of the Organization */
            $table->text('org_address')->default('No Data');
            $table->text('landmark')->default('No Data');
            $table->string('addr_proof')->default('No Data');
            $table->string('addr_doc')->default('No Data');
            $table->string('city')->default('No Data');
            $table->string('block')->default('No Data');
            $table->string('pin')->default('No Data');
            $table->string('state_district')->default('No Data');
            $table->string('parliament')->default('No Data');
            /* End Address of the Organization */

            /* Financial Information */
            $table->string('pan')->default('No Data');
            $table->string('pan_doc')->default('No Data');
            $table->string('gst')->nullable();
            $table->string('gst_doc')->nullable();
            $table->string('ca1_doc')->nullable();
            $table->string('ca1_year')->nullable();
            $table->string('ca2_doc')->nullable();
            $table->string('ca2_year')->nullable();
            $table->string('ca3_doc')->nullable();
            $table->string('ca3_year')->nullable();
            $table->string('ca4_doc')->nullable();
            $table->string('ca4_year')->nullable();
            /* End Financial Information */

            /* Proposal Informatoin */
            $table->string('offer')->default('No Data');
            $table->string('offer_date')->default('No Data');
            $table->string('offer_doc')->default('No Data');
            $table->string('sanction')->default('No Data');
            $table->string('sanction_date')->default('No Data');
            $table->string('sanction_doc')->default('No Data');
            /* End Proposal Informatoin */
            /* End Full Registration */
            
            /* Flag Secion */
            $table->boolean('status')->default(1)->comment = 'Active or Deactive';
            $table->boolean('complete_profile')->default(0)->comment = 'Profile is Completed';
            $table->boolean('pending_verify')->nullable()->comment = 'Completed Profile Verification';
            /* End Flag Secion */
            
            $table->rememberToken();
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
        Schema::drop('partners');
    }
}
