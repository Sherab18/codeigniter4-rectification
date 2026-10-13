<?php

namespace App\Libraries;

/**
 * Extracts the "System at a Glance" figures from the BPSO "LGBR Daily Report"
 * (Load-Generation Balance Report, Excel -> PDF, 2 pages: 09:00 hrs and previous day 19:00 hrs).
 *
 * The PDF is read with `pdftotext -layout` (package poppler-utils), because the layout
 * mode keeps each table row on one line:
 *      sudo apt install poppler-utils
 * TXT files produced by `pdftotext -layout` are also accepted.
 *
 * Scanned (image-only) PDFs and JPG/PNG files contain no text and are not supported.
 */
class DailyReportParser
{
    private const N = '-?[\d,]+(?:\.\d+)?';

    /** name printed under the plant in the report => name shown on the dashboard */
    private const DISPLAY = [
        'Punatsangchhu'         => 'Punatsangchhu-II',
        'Sephu Solar Plant'     => 'Sephu Solar',
        'Burgangchhu Small HP'  => 'Burgangchhu',
    ];

    public function parseFile(string $fullPath): ?array
    {
        $text = $this->extractText($fullPath);
        if ($text === null || trim($text) === '') {
            return null;
        }
        $summary = $this->parse($text);
        if ($summary === null) {
            log_message('error', 'DailyReportParser: text extracted but report layout not recognised: ' . basename($fullPath));
        }
        return $summary;
    }

    private function extractText(string $fullPath): ?string
    {
        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

        if ($ext === 'txt') {
            return file_get_contents($fullPath) ?: null;
        }
        if ($ext !== 'pdf') {
            return null;
        }
        if (!function_exists('shell_exec')) {
            log_message('error', 'DailyReportParser: shell_exec is disabled in php.ini (disable_functions).');
            return null;
        }
        // XAMPP/LAMPP sets LD_LIBRARY_PATH to its own bundled libraries, which breaks
        // system programs such as pdftotext, so it is cleared for this one command.
        $lastErr = '';
        foreach (['/usr/bin/pdftotext', '/usr/local/bin/pdftotext', 'pdftotext'] as $bin) {
            $cmd = 'env -u LD_LIBRARY_PATH ' . escapeshellarg($bin) . ' -layout -enc UTF-8 ' . escapeshellarg($fullPath) . ' -';
            $out = shell_exec($cmd . ' 2>/dev/null');
            if (is_string($out) && trim($out) !== '') {
                return $out;
            }
            $err = shell_exec($cmd . ' 2>&1 >/dev/null');
            $lastErr = trim((string) $err) ?: $lastErr;
        }
        log_message('error', 'DailyReportParser: pdftotext produced no text. Error output: ' . ($lastErr !== '' ? substr($lastErr, 0, 300) : '(none - command may not be runnable from PHP)'));
        return null;
    }

    public function parse(string $text): ?array
    {
        $current = $evening = null;

        foreach (preg_split('/\f/', $text) as $page) {
            if (!preg_match('/Details\s+([A-Z][a-z]+ \d{1,2}, \d{4})\s+(\d{1,2}):\d{2}/', $page, $m)) {
                continue;
            }
            $hour = (int) $m[2];
            if ($hour < 12 && $current === null) {
                $current = ['page' => $page, 'date' => $m[1]];
            } elseif ($hour >= 12 && $evening === null) {
                $evening = ['page' => $page, 'date' => $m[1]];
            }
        }
        if ($current === null) {
            return null;
        }

        $table = $this->readTable($current['page']);
        $cur   = $this->summaryRow($current['page']);
        if ($cur === null && empty($table['plants'])) {
            return null;
        }

        $dt = \DateTime::createFromFormat('F j, Y', $current['date']);

        // Plants: biggest first, top 6
        $plants = [];
        foreach ($table['plants'] as $name => $mw) {
            if ($mw > 0) {
                $plants[] = ['name' => self::DISPLAY[$name] ?? $name, 'mw' => round($mw, 2)];
            }
        }
        usort($plants, fn($a, $b) => $b['mw'] <=> $a['mw']);

        // Operational attention
        $alerts = [];
        foreach ($table['remarks'] as $name => $frags) {
            $msg = trim(preg_replace('/\s+/', ' ', implode(' ', $frags)));
            if ($msg === '' || (preg_match('/in service/i', $msg) && !preg_match('/trip|shut|standby|inspection/i', $msg))) {
                continue;
            }
            $alerts[] = (self::DISPLAY[$name] ?? $name) . ': ' . $msg;
        }

        return [
            'report_date'  => $dt ? $dt->format('Y-m-d') : null,
            'current'      => $cur ?? ['gen' => null, 'load' => null, 'export' => null],
            'prev_evening' => $evening ? ($this->summaryRow($evening['page']) ?? ['gen' => null, 'load' => null, 'export' => null])
                                       : ['gen' => null, 'load' => null, 'export' => null],
            'plants'       => array_slice($plants, 0, 6),
            'alerts'       => array_slice($alerts, 0, 6),
            'ncpl'         => $this->peak($current['page']),
            'energy'       => $this->energy($text),
        ];
    }

    /** "Generation-Load Summary" row: total generation, domestic load, net export (first = this year). */
    private function summaryRow(string $page): ?array
    {
        $pos = stripos($page, 'Generation-Load Summary');
        if ($pos === false) {
            return null;
        }
        $sub = substr($page, $pos);
        $n = self::N;
        if (preg_match('/^[ \t]*1[ \t]+(' . $n . ')[ \t]+(' . $n . ')[ \t]+(' . $n . ')/m', $sub, $m)) {
            return ['gen' => $this->num($m[1]), 'load' => $this->num($m[2]), 'export' => $this->num($m[3])];
        }
        return null;
    }

    private function peak(string $page): array
    {
        $n = self::N;
        if (preg_match('/(\d{2}-[A-Za-z]{3}-\d{2,4})\s+(\d{1,2}:\d{2}:\d{2})\s+(' . $n . ')/', $page, $m)) {
            $d = \DateTime::createFromFormat('d-M-y', $m[1]) ?: \DateTime::createFromFormat('d-M-Y', $m[1]);
            return [
                'mw'          => $this->num($m[3]),
                'recorded_on' => ($d ? $d->format('d M Y') : $m[1]) . ' at ' . $m[2],
            ];
        }
        return ['mw' => null, 'recorded_on' => null];
    }

    /** "Daily Energy (MUs) and Power(MW) Statistics" row (previous day). */
    private function energy(string $text): array
    {
        $empty = ['gen_mu' => null, 'met_mu' => null, 'export_mu' => null, 'import_mu' => null, 'peak_xb_mw' => null];
        $pos = stripos($text, 'Daily Energy (MUs)');
        if ($pos === false) {
            return $empty;
        }
        $n = self::N;
        $re = '/^[ \t]*1[ \t]+(' . $n . ')[ \t]+(' . $n . ')[ \t]+(' . $n . ')[ \t]+(' . $n . ')[ \t]+(' . $n . ')/m';
        if (preg_match($re, substr($text, $pos), $m)) {
            // columns: Total Energy Generation | Daily Energy Met | Net Energy Import | Net Energy Export | Peak Cross-border
            return [
                'gen_mu'     => $this->num($m[1]),
                'met_mu'     => $this->num($m[2]),
                'import_mu'  => $this->num($m[3]),
                'export_mu'  => $this->num($m[4]),
                'peak_xb_mw' => $this->num($m[5]),
            ];
        }
        return $empty;
    }

    /**
     * Reads the plant table. Plant total = the "Total" row of each plant block;
     * the plant name is the "(Name)" printed in the left column; remarks are
     * whatever sits right of the Load (MW) column.
     */
    private function readTable(string $page): array
    {
        $lines = preg_split('/\R/', $page);
        $loadCol = $transCol = null;
        $start = null;
        $end = count($lines);

        foreach ($lines as $i => $l) {
            if ($start === null) {
                if (strpos($l, 'Hydropower Plant') !== false && ($p = strpos($l, 'Load (MW)')) !== false) {
                    $loadCol  = $p;
                    $transCol = strpos($l, 'Transmission') ?: 80;
                    $start    = $i + 1;
                }
            } elseif (stripos($l, 'Generation-Load Summary') !== false) {
                $end = $i;
                break;
            }
        }
        if ($start === null) {
            return ['plants' => [], 'remarks' => []];
        }

        $n = self::N;
        $name = null;
        $buf = [];
        $plants = $remarks = [];

        for ($i = $start; $i < $end; $i++) {
            $line = rtrim($lines[$i]);
            if ($line === '') {
                continue;
            }

            $left = substr($line, 0, max(0, $transCol - 2));
            if (preg_match('/\(([A-Z][A-Za-z ]{2,})\)/', $left, $m)) {
                $name = trim($m[1]);
            }

            // remark text: right of the Load column, minus any leftover numbers
            $frag = strlen($line) > $loadCol + 10 ? substr($line, $loadCol + 10) : '';
            $frag = ltrim($frag);
            while ($frag !== '' && preg_match('/^(?:[\-\d.,]*\d%?|-|%)(?:\s+|$)/', $frag, $mm)) {
                $frag = ltrim(substr($frag, strlen($mm[0])));
            }
            if ($frag !== '') {
                $buf[] = $frag;
            }

            if ($name !== null && preg_match('/^\s*Total\s+(' . $n . ')(?=\s|$)/', $line, $m)) {
                $plants[$name]  = ($plants[$name] ?? 0) + $this->num($m[1]);
                $remarks[$name] = array_merge($remarks[$name] ?? [], $buf);
                $buf = [];
            }
        }

        return ['plants' => $plants, 'remarks' => $remarks];
    }

    private function num(string $s): float
    {
        return (float) str_replace(',', '', $s);
    }
}
