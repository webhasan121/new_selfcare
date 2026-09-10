<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('radchecks', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username', 64)->default('')->unique();
            $table->string('attribute', 64)->default('');
            $table->char('op', 2)->default('==');
            $table->string('value', 253)->default('');

            $table->tinyInteger('enablemac');
            $table->string('macaddress', 80)->nullable();
            $table->string('ipaddress', 15)->default('Dynamic');
            $table->boolean('enableuser')->default(true);

            $table->date('expiredate');
            $table->date('expiryextension')->nullable();

            $table->tinyInteger('allow_exp_connect')->default(0);
            $table->integer('expiredchk')->default(1);
            $table->integer('billcycle_id');

            $table->string('packageid', 30);
            $table->integer('sub_package_id')->nullable();
            $table->string('resellerid', 20);
            $table->integer('allowpopid');

            $table->string('clientname', 30);
            $table->date('dob')->nullable();
            $table->string('clientaddress', 100);
            $table->string('clintcontactno', 25);
            $table->string('email', 50)->nullable();

            $table->timestamp('clintcreatedate')->useCurrent();

            $table->string('clientremarks', 200)->nullable();
            $table->integer('tmpdel')->default(0);
            $table->integer('billable')->default(1);
            $table->integer('discount')->default(0);

            $table->string('flat_level', 25)->nullable();
            $table->string('building_num', 15)->nullable();
            $table->string('building_name', 30)->nullable();
            $table->string('road_num', 15)->nullable();
            $table->string('road_name', 50)->nullable();
            $table->string('block_sector', 5)->nullable();
            $table->string('area', 25)->nullable();

            $table->integer('ip_bill')->nullable();
            $table->integer('extra_bill')->nullable();

            $table->decimal('rating', 2, 1)->default(3.0);

            $table->bigInteger('port_id')->nullable();
            $table->integer('investment')->nullable();

            $table->string('nid', 17)->nullable();
            $table->string('passport', 17)->nullable();

            $table->integer('created_by')->nullable();

            $table->string('father', 50)->nullable();
            $table->string('mother', 50)->nullable();

            $table->integer('cable_meter')->nullable();

            $table->string('marketed_by', 50)->nullable();
            $table->unsignedInteger('marketed_by_emp_id')->nullable();

            $table->integer('pop_disable')->default(0);

            $table->string('investment_details', 250)->nullable();

            $table->string('thana', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('client_type', 25)->nullable();

            $table->integer('vat_applicable')->default(0);

            $table->string('from_tg_no', 20)->nullable();
            $table->string('from_cable_id', 20)->nullable();
            $table->string('from_cable_meter', 50)->nullable();
            $table->string('to_cable_id', 20)->nullable();
            $table->string('to_cable_meter', 50)->nullable();

            $table->string('pon_no', 20)->nullable();
            $table->string('onu_mac', 20)->nullable();
            $table->string('vlan_id', 50)->nullable();

            $table->string('from_google_gps', 50)->nullable();
            $table->string('to_google_gps', 50)->nullable();

            $table->string('bill_collect_status', 50)->nullable();
            $table->string('billing_address', 250)->nullable();

            $table->string('connected_by', 50)->nullable();
            $table->string('last_power', 5)->nullable();

            $table->string('alternative_contact', 11)->nullable();

            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_datetime')->nullable();

            $table->integer('deposit')->default(0);

            $table->string('alternative_contact_2', 11)->nullable();
            $table->string('police_station', 35)->nullable();

            $table->integer('connect_via')->default(1);

            $table->integer('olt_number')->nullable();
            $table->string('olt_slot', 4)->nullable();

            $table->string('marketing_method', 50)->nullable();
            $table->string('comments', 250)->nullable();

            $table->string('cable_operator', 150)->nullable();
            $table->string('connected_to', 20)->nullable();
            $table->string('paid_via', 50)->nullable();

            $table->integer('original_package_id')->nullable();
            $table->string('gpon_epon', 4)->nullable();

            $table->string('deposit_remarks', 400)->nullable();

            // Legacy indexes
            $table->index('allowpopid');
            $table->index('resellerid');

            $table->index(
                ['id', 'enableuser', 'tmpdel'],
                'idx_radcheck_customer_state'
            );

            $table->index(
                ['resellerid', 'enableuser', 'tmpdel'],
                'idx_resellerid_enableuser_tmpdel'
            );

            $table->index(
                ['resellerid', 'expiredate', 'enableuser', 'tmpdel'],
                'idx_resellerid_expiredate_enableuser_tmpdel'
            );

            $table->index(
                ['sub_package_id', 'enableuser', 'tmpdel'],
                'idx_sub_package_id_enableuser_tmpdel'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radchecks');
    }
};
