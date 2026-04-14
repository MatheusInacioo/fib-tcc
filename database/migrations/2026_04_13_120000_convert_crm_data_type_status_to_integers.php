<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Converte colunas legadas string (tipo/status CRM) para inteiros alinhados aos enums.
     */
    public function up(): void
    {
        if (! Schema::hasTable('crm_data') || ! Schema::hasColumn('crm_data', 'type')) {
            return;
        }

        $COLUMN_TYPE = Schema::getColumnType('crm_data', 'type');
        if ($COLUMN_TYPE !== 'string' && $COLUMN_TYPE !== 'text') {
            return;
        }

        Schema::table('crm_data', function (Blueprint $table) {
            $table->unsignedTinyInteger('party_type_tmp')->default(0);
            $table->unsignedTinyInteger('lead_status_tmp')->default(0);
        });

        $TYPE_FROM_LABEL = [
            'Cliente' => 0,
            'Fornecedor' => 1,
        ];
        $STATUS_FROM_LABEL = [
            'Contato' => 0,
            'Negociação' => 1,
            'Assinatura Pendente' => 2,
            'Standby' => 3,
            'Sem Interesse' => 4,
        ];

        foreach (DB::table('crm_data')->cursor() as $ROW) {
            $TYPE_INT = $TYPE_FROM_LABEL[$ROW->type] ?? 0;
            $STATUS_INT = $STATUS_FROM_LABEL[$ROW->status] ?? 0;
            DB::table('crm_data')->where('id', $ROW->id)->update([
                'party_type_tmp' => $TYPE_INT,
                'lead_status_tmp' => $STATUS_INT,
            ]);
        }

        Schema::table('crm_data', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']);
        });

        Schema::table('crm_data', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->default(0)->after('segment');
            $table->unsignedTinyInteger('status')->default(0)->after('type');
        });

        foreach (DB::table('crm_data')->cursor() as $ROW) {
            DB::table('crm_data')->where('id', $ROW->id)->update([
                'type' => $ROW->party_type_tmp,
                'status' => $ROW->lead_status_tmp,
            ]);
        }

        Schema::table('crm_data', function (Blueprint $table) {
            $table->dropColumn(['party_type_tmp', 'lead_status_tmp']);
        });
    }

    /**
     * Reverte para strings (rótulos em português) compatíveis com o schema anterior.
     */
    public function down(): void
    {
        if (! Schema::hasTable('crm_data') || ! Schema::hasColumn('crm_data', 'type')) {
            return;
        }

        $COLUMN_TYPE = Schema::getColumnType('crm_data', 'type');
        if ($COLUMN_TYPE === 'string' || $COLUMN_TYPE === 'text') {
            return;
        }

        Schema::table('crm_data', function (Blueprint $table) {
            $table->string('party_type_tmp')->nullable();
            $table->string('lead_status_tmp')->nullable();
        });

        $TYPE_TO_LABEL = ['0' => 'Cliente', '1' => 'Fornecedor'];
        $STATUS_TO_LABEL = [
            '0' => 'Contato',
            '1' => 'Negociação',
            '2' => 'Assinatura Pendente',
            '3' => 'Standby',
            '4' => 'Sem Interesse',
        ];

        foreach (DB::table('crm_data')->cursor() as $ROW) {
            $TYPE_KEY = (string) (int) $ROW->type;
            $STATUS_KEY = (string) (int) $ROW->status;
            DB::table('crm_data')->where('id', $ROW->id)->update([
                'party_type_tmp' => $TYPE_TO_LABEL[$TYPE_KEY] ?? 'Cliente',
                'lead_status_tmp' => $STATUS_TO_LABEL[$STATUS_KEY] ?? 'Contato',
            ]);
        }

        Schema::table('crm_data', function (Blueprint $table) {
            $table->dropColumn(['type', 'status']);
        });

        Schema::table('crm_data', function (Blueprint $table) {
            $table->string('type')->after('segment');
            $table->string('status')->after('type');
        });

        foreach (DB::table('crm_data')->cursor() as $ROW) {
            DB::table('crm_data')->where('id', $ROW->id)->update([
                'type' => $ROW->party_type_tmp,
                'status' => $ROW->lead_status_tmp,
            ]);
        }

        Schema::table('crm_data', function (Blueprint $table) {
            $table->dropColumn(['party_type_tmp', 'lead_status_tmp']);
        });
    }
};
