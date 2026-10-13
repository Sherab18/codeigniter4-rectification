<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Adds columns that hold the figures extracted from a daily report.
 * ASSUMPTION: the table behind ReportModel is called `reports` - change if not.
 * Or run the equivalent SQL by hand:
 *   ALTER TABLE reports ADD COLUMN report_date DATE NULL, ADD COLUMN summary_json MEDIUMTEXT NULL;
 */
class AddSummaryToReports extends Migration
{
    private string $table = 'reports';

    public function up()
    {
        $this->forge->addColumn($this->table, [
            'report_date'  => ['type' => 'DATE', 'null' => true, 'after' => 'upload_date'],
            'summary_json' => ['type' => 'MEDIUMTEXT', 'null' => true, 'after' => 'report_date'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn($this->table, ['report_date', 'summary_json']);
    }
}
