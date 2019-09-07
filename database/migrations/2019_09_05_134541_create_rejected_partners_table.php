<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRejectedPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejected_partners', function (Blueprint $table) {
            $table->increments('id');
            
            /* Basic Registration */
            $table->string('spoc_name');
            $table->string('email');
            $table->string('spoc_mobile');
            $table->string('password');
            $table->string('incorp_doc');
            /* End Basic Registration */

            /* Full Registration */
            /* General Details */
            $table->string('org_name');
            $table->string('org_type');
            $table->string('estab_year');
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
            $table->text('org_address');
            $table->text('landmark');
            $table->string('addr_proof');
            $table->string('addr_doc');
            $table->string('city');
            $table->string('block');
            $table->string('pin');
            $table->string('state_district');
            $table->string('parliament');
            /* End Address of the Organization */

            /* Financial Information */
            $table->string('pan');
            $table->string('pan_doc');
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
            $table->string('offer');
            $table->string('offer_date');
            $table->string('offer_doc');
            $table->string('sanction');
            $table->string('sanction_date');
            $table->string('sanction_doc');
            /* End Proposal Informatoin */
            /* End Full Registration */
            
            /* Flag Secion */
            $table->text('reason')->comment = 'Reason of Rejection';
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
        Schema::dropIfExists('rejected_partners');
    }
}
