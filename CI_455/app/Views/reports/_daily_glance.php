<?php
/**
 * "BPSO Daily System at a Glance" dashboard (self-contained: own CSS + inline SVG icons,
 * does not depend on Bootstrap's grid or on icon fonts).
 *
 * Expects: $summary (array from DailyReportParser), optional $prevSummary.
 * Include with:  <?= $this->include('reports/_daily_glance') ?>
 */
if (empty($summary)) {
    return;
}

// ---- Header logos ----------------------------------------------------------------------------
// Looked up in your public folder: <public>/assets/img/glance/bpso-logo.png and bhutan-emblem.png
// (small crops from the reference image - overwrite them with your original, higher-resolution files).
// A logo that is missing is simply left out.
$logoDir   = 'assets/img/glance/';
$logoLeft  = is_file(FCPATH . $logoDir . 'bpso-logo.png')      ? base_url($logoDir . 'bpso-logo.png')      : '';
$logoRight = is_file(FCPATH . $logoDir . 'bhutan-emblem.png')  ? base_url($logoDir . 'bhutan-emblem.png')  : '';
// ---------------------------------------------------------------------------------------------

$fmt  = fn($v, $d = 2) => ($v === null || $v === '') ? '—' : number_format((float) $v, $d);
$sign = fn($v) => $v === null ? '—' : (($v < 0 ? '−' : '+') . number_format(abs($v), 2));

$cur    = $summary['current']      ?? [];
$eve    = $summary['prev_evening'] ?? [];
$en     = $summary['energy']       ?? [];
$ncpl   = $summary['ncpl']         ?? [];
$plants = $summary['plants']       ?? [];
$alerts = $summary['alerts']       ?? [];

$reportTs  = !empty($summary['report_date']) ? strtotime($summary['report_date']) : null;
$dateLabel = $reportTs ? date('d M Y', $reportTs) : '';
$prevLabel = $reportTs ? date('d M Y', strtotime('-1 day', $reportTs)) : '';

$delta = null;
if (!empty($prevSummary['current']) && isset($cur['gen'])) {
    $p = $prevSummary['current'];
    $delta = [
        'gen'    => isset($p['gen'])    && isset($cur['gen'])    ? $cur['gen']    - $p['gen']    : null,
        'load'   => isset($p['load'])   && isset($cur['load'])   ? $cur['load']   - $p['load']   : null,
        'export' => isset($p['export']) && isset($cur['export']) ? $cur['export'] - $p['export'] : null,
    ];
}
$maxPlant = $plants ? max(array_column($plants, 'mw')) : 1;
$ico = fn(string $id, string $cls = '') => '<svg class="bg-ico ' . $cls . '" aria-hidden="true"><use href="#bg-' . $id . '"/></svg>';
?>
<style>
    .bg-wrap { --navy:#14306b; --blue:#1d4b8c; --green:#0f7a3a; --orange:#e06a1b; --line:#cfe0f1;
        font-family: Georgia, 'DejaVu Serif', 'Times New Roman', serif; color:#1b2b3c; background:#eaf2fa;
        border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(10,40,90,.12); margin:0; width:100%; line-height:1.25; }
    .bg-wrap *, .bg-wrap *::before, .bg-wrap *::after { box-sizing:border-box; }
    .bg-ico { width:1em; height:1em; fill:currentColor; flex:none; vertical-align:-.12em; }

    /* header */
    .bg-head { position:relative; container-type:inline-size; display:grid; grid-template-columns:minmax(0,1fr) auto minmax(0,1fr); align-items:center; gap:1rem;
        padding:1.1rem 1.4rem 3.2rem; background:linear-gradient(180deg,#f3f8fd 0%,#d9e8f6 100%); overflow:hidden; min-height:150px; }
    .bg-head .hills { position:absolute; left:0; right:0; bottom:0; width:100%; height:62px; display:block; }
    .bg-org { position:relative; z-index:1; display:flex; align-items:center; gap:.7rem; font-weight:700; font-size:clamp(.75rem,1.45cqw,1rem); color:var(--navy); }
    .bg-org.right { justify-content:flex-end; text-align:left; }
    .bg-org img { height:clamp(56px,7cqw,92px); width:auto; background:#fff; padding:4px; border-radius:6px; box-shadow:0 1px 4px rgba(10,40,90,.2); }
    .bg-title { position:relative; z-index:1; text-align:center; }
    .bg-title h2 { margin:0; font-weight:800; color:var(--navy); font-size:clamp(1.35rem,3.1cqw,2.6rem); letter-spacing:.2px; white-space:nowrap; }
    .bg-title p { margin:.25rem 0 0; font-size:clamp(.95rem,1.9cqw,1.45rem); color:#111; letter-spacing:.06em; }

    /* grid */
    .bg-body { padding:.9rem; display:grid; gap:.9rem; }
    .bg-row1 { display:grid; gap:.9rem; grid-template-columns:1.32fr 1.18fr 1fr; }
    .bg-row2 { display:grid; gap:.9rem; grid-template-columns:1.2fr 1fr .85fr; }
    @media (max-width:1100px) { .bg-row1, .bg-row2 { grid-template-columns:1fr 1fr; } }
    @media (max-width:720px)  {
        .bg-row1, .bg-row2 { grid-template-columns:minmax(0,1fr); }
        .bg-head { grid-template-columns:minmax(0,1fr); text-align:center; padding-bottom:3rem; }
        .bg-org, .bg-org.right { justify-content:center; text-align:center; flex-wrap:wrap; }
        .bg-title h2 { white-space:normal; font-size:1.5rem; }
        .bg-card .bg-ph, .bg-card .bg-pr { grid-template-columns:1.4rem minmax(0,1fr) 5.4rem; }
        .bg-card .bg-pr .bar, .bg-card .bg-ph span:nth-child(3) { display:none; }
        .bg-card .bg-ph { white-space:normal; }
    }

    .bg-card { container-type:inline-size; background:#fff; border:1.5px solid var(--line); border-radius:14px; overflow:hidden; display:flex; flex-direction:column; min-width:0; }
    .bg-card > h3 { margin:0; padding:.7rem 1rem; min-height:3.6rem; font-size:clamp(.85rem,4.4cqw,1.1rem); text-wrap:balance; font-weight:700; display:flex; align-items:center; gap:.6rem; }
    .bg-card.cur   > h3 { background:linear-gradient(180deg,#245aa3,#173f78); color:#fff; justify-content:center; letter-spacing:0; }
    .bg-card.prev  { border-color:#f3c9a6; background:#fffaf5; }
    .bg-card.prev  > h3 { background:linear-gradient(180deg,#ec7a2a,#d4600f); color:#fff; justify-content:center; letter-spacing:0; }
    .bg-card.chg   > h3, .bg-card.top > h3, .bg-card.ncpl > h3 { background:#d9e8f7; color:var(--navy); }
    .bg-card.attn  { border-color:#f4c7c7; background:#fff9f9; }
    .bg-card.attn  > h3 { background:#fde6e6; color:#b3202a; }
    .bg-card > h3 .bg-ico { font-size:1.6em; }
    .bg-card .sub { font-weight:400; font-size:.78rem; display:block; color:#33475b; }

    /* three metrics */
    .bg-metrics { display:grid; grid-template-columns:repeat(3,1fr); flex:1; }
    .bg-m { container-type:inline-size; text-align:center; padding:.9rem .3rem .8rem; border-right:1px solid #dbe6f1; display:flex; flex-direction:column; align-items:center; justify-content:space-between; gap:.25rem; min-width:0; }
    .bg-m:last-child { border-right:0; }
    .prev .bg-m { border-color:#f1dccb; }
    .bg-m .lbl { font-weight:700; font-size:clamp(.78rem,10.5cqw,.98rem); color:#1b2b3c; text-wrap:balance; line-height:1.15; }
    .bg-m .pic { font-size:clamp(1.6rem,25cqw,3rem); line-height:1; display:flex; align-items:center; gap:.15rem; }
    .bg-m .pic .bg-ico.arrow { font-size:.75em; }
    .bg-m .val { font-weight:800; font-size:clamp(.95rem,17cqw,1.7rem); white-space:nowrap; letter-spacing:.01em; }
    .bg-m .unit { font-weight:700; font-size:clamp(.75rem,10cqw,1rem); }
    .t-gen { color:var(--blue); } .t-load { color:var(--green); } .t-exp { color:var(--orange); }
    .t-down { color:var(--navy); } .t-up { color:var(--green); }
    .bg-m .tri { font-size:clamp(1.4rem,22cqw,2.4rem); }
    .bg-nodata { text-align:center; font-size:.8rem; color:#5b6b7b; padding:0 .5rem .6rem; }

    /* top plants */
    .bg-plants { padding:.2rem 0 .6rem; flex:1; }
    .bg-ph, .bg-pr { display:grid; grid-template-columns:1.6rem minmax(10rem,1.3fr) 1.5fr 7.6rem; align-items:center; gap:.5rem; padding:.38rem 1rem; }
    .bg-ph { white-space:nowrap; font-weight:700; border-bottom:1px solid #dfe9f3; font-size:.88rem; }
    .bg-ph span:last-child, .bg-pr .v { text-align:right; }
    .bg-pr { border-bottom:1px solid #edf3f9; font-size:.95rem; }
    .bg-pr .bar { background:#e6eff8; height:1.15rem; border-radius:4px; overflow:hidden; }
    .bg-pr .bar i { display:block; height:100%; background:linear-gradient(90deg,#4f94da,#66aaee); border-radius:4px; }
    .bg-pr .v { font-weight:800; color:var(--navy); }
    .bg-empty { padding:1.2rem 1rem; color:#5b6b7b; font-size:.92rem; }

    /* alerts */
    .bg-alerts { margin:0; padding:.35rem 0 .6rem; list-style:none; flex:1; }
    .bg-alerts li { display:flex; gap:.65rem; padding:.42rem 1rem; font-size:.9rem; }
    .bg-alerts li::before { content:''; flex:none; width:.7rem; height:.7rem; margin-top:.35rem; border-radius:50%; background:#d62839; box-shadow:0 0 0 3px #fbd5d9; }
    .bg-alerts b { color:#111; }

    /* national peak */
    .bg-ncpl-body { container-type:inline-size; flex:1; display:flex; flex-direction:column; justify-content:center; gap:1rem; padding:1rem 1.2rem 1.4rem; position:relative;
        background:linear-gradient(180deg,#fff 40%,#eef5fc 100%); }
    .bg-ncpl-val { text-align:center; font-weight:800; font-size:clamp(1.3rem,13cqw,2.8rem); color:#3b1d83; white-space:nowrap; }
    .bg-ncpl-on { background:#e3edf8; border-radius:10px; text-align:center; padding:.7rem; font-weight:700; color:var(--navy); position:relative; z-index:1; }
    .bg-ncpl-body .mtn { position:absolute; left:0; right:0; bottom:0; height:70px; width:100%; opacity:.55; }

    /* energy strip */
    .bg-strip { background:#e7f3e9; border:1.5px solid #cfe5d3; border-radius:14px; overflow:hidden; }
    .bg-strip > h3 { margin:0; padding:.7rem 1rem 0; font-size:clamp(.95rem,1.3vw,1.15rem); color:#14532d; display:flex; align-items:center; gap:.6rem; }
    .bg-strip > h3 .bg-ico { font-size:1.6em; }
    .bg-sg { display:grid; grid-template-columns:repeat(5,1fr); }
    @media (max-width:900px) { .bg-sg { grid-template-columns:repeat(2,1fr); } }
    .bg-s { container-type:inline-size; display:flex; align-items:center; justify-content:center; gap:.7rem; padding:.9rem .6rem; border-right:1px solid #cfe3d3; min-width:0; }
    .bg-s:last-child { border-right:0; }
    .bg-s .pic { font-size:clamp(1.4rem,13cqw,2.6rem); display:flex; align-items:center; }
    .bg-s .txt { text-align:center; }
    .bg-s .l { font-size:clamp(.7rem,6.2cqw,.9rem); color:#1f3a28; }
    .bg-s .v { font-weight:800; font-size:clamp(.9rem,8.6cqw,1.5rem); color:var(--navy); white-space:nowrap; }

    .bg-foot { display:flex; flex-wrap:wrap; justify-content:space-between; gap:.4rem 1rem; padding:.7rem 1.3rem; border-top:1px solid #c5d3e2; font-size:.8rem; color:#22344a; background:#f3f8fd; }
    .bg-foot em { color:#44566b; } .bg-foot .tag { font-weight:700; color:var(--navy); letter-spacing:.03em; }
</style>

<!-- icon sprite -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="bg-factory" viewBox="0 0 48 48"><path d="M4 43V21l11 6v-6l11 6v-6l11 6V9h7v34z"/><rect x="9" y="33" width="4" height="4" fill="#fff"/><rect x="18" y="33" width="4" height="4" fill="#fff"/><rect x="27" y="33" width="4" height="4" fill="#fff"/></symbol>
    <symbol id="bg-bolt" viewBox="0 0 48 48"><path d="M30 2 13 27h10l-5 19 20-27H27z"/></symbol>
    <symbol id="bg-house" viewBox="0 0 48 48"><path d="M24 4 2 24h6v19h12V30h8v13h12V24h6z"/></symbol>
    <symbol id="bg-tower" viewBox="0 0 48 48"><path d="M24 3v7M12 10h24M15 10l9 13 9-13M16 23h16M19 23 8 45M29 23l11 22M12 36h24M8 45h32" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></symbol>
    <symbol id="bg-arrow-r" viewBox="0 0 48 48"><path d="M3 18h25v-8l17 14-17 14v-8H3z"/></symbol>
    <symbol id="bg-arrow-l" viewBox="0 0 48 48"><path d="M45 18H20v-8L3 24l17 14v-8h25z"/></symbol>
    <symbol id="bg-gear" viewBox="0 0 48 48"><path d="M20 3h8l1.4 6.1a15.5 15.5 0 0 1 4.3 1.8l5.3-3.3 5.7 5.7-3.3 5.3a15.5 15.5 0 0 1 1.8 4.3L45 20v8l-6.1 1.4a15.5 15.5 0 0 1-1.8 4.3l3.3 5.3-5.7 5.7-5.3-3.3a15.5 15.5 0 0 1-4.3 1.8L28 45h-8l-1.4-6.1a15.5 15.5 0 0 1-4.3-1.8l-5.3 3.3-5.7-5.7 3.3-5.3A15.5 15.5 0 0 1 9.1 29.4L3 28v-8l6.1-1.4a15.5 15.5 0 0 1 1.8-4.3L7.6 9l5.7-5.7 5.3 3.3a15.5 15.5 0 0 1 4.3-1.8zM24 17a7 7 0 1 0 0 14 7 7 0 0 0 0-14z" fill-rule="evenodd"/></symbol>
    <symbol id="bg-bars" viewBox="0 0 48 48"><rect x="5" y="26" width="9" height="17" rx="1.5"/><rect x="19" y="14" width="9" height="29" rx="1.5"/><rect x="33" y="4" width="9" height="39" rx="1.5"/></symbol>
    <symbol id="bg-warn" viewBox="0 0 48 48"><path d="M24 4 2 44h44z"/><rect x="22" y="17" width="4" height="14" fill="#fff"/><circle cx="24" cy="36.5" r="2.6" fill="#fff"/></symbol>
    <symbol id="bg-peak" viewBox="0 0 48 48"><path d="M1 43 17 14l8 12 5-7 17 24z"/><path d="m17 14 4 7-4-2-4 2z" fill="#fff"/></symbol>
    <symbol id="bg-swap" viewBox="0 0 48 48"><path d="M3 15h27v-7l15 10-15 10v-7H3zM45 33H18v-7L3 36l15 10v-7h27z"/></symbol>
    <symbol id="bg-tri-down" viewBox="0 0 48 48"><path d="M3 8h42L24 42z"/></symbol>
    <symbol id="bg-tri-up" viewBox="0 0 48 48"><path d="M3 40h42L24 6z"/></symbol>
</svg>

<section class="bg-wrap" aria-label="BPSO Daily System at a Glance">
    <header class="bg-head">
        <div class="bg-org">
            <?php if ($logoLeft): ?><img src="<?= esc($logoLeft) ?>" alt="BPSO logo"><?php endif; ?>
            <span>Bhutan Power System Operator</span>
        </div>
        <div class="bg-title">
            <h2>BPSO Daily System at a Glance</h2>
            <p><?= esc($dateLabel) ?> Snapshot</p>
        </div>
        <div class="bg-org right">
            <?php if ($logoRight): ?><img src="<?= esc($logoRight) ?>" alt="Royal Government of Bhutan"><?php endif; ?>
            <span>Ministry of Energy and Natural Resources<br><span style="font-weight:400">Royal Government of Bhutan</span></span>
        </div>
        <svg class="hills" viewBox="0 0 1100 62" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 62V38l70-18 55 16 90-30 80 34 110-28 95 22 120-34 90 30 100-20 85 26 105-30 100 28V62z" fill="#b9cfe3"/>
            <path d="M0 62V48l90-14 70 12 120-22 90 18 140-16 100 14 110-20 120 20 110-12 150 8V62z" fill="#7ea98a"/>
            <path d="M0 62V54l140-8 150 6 170-8 180 6 180-5 140 4 140-3V62z" fill="#4c8a63"/>
        </svg>
    </header>

    <div class="bg-body">
        <div class="bg-row1">
            <!-- Current day 09:00 -->
            <article class="bg-card cur">
                <h3><?= $ico('bars') ?> Current Day | 09:00 hrs | <?= esc($dateLabel) ?></h3>
                <div class="bg-metrics">
                    <div class="bg-m"><span class="lbl">Total Generation</span><span class="pic t-gen"><?= $ico('factory') ?><?= $ico('bolt') ?></span><span class="val t-gen"><?= $fmt($cur['gen'] ?? null) ?></span><span class="unit">MW</span></div>
                    <div class="bg-m"><span class="lbl">Domestic Load</span><span class="pic t-load"><?= $ico('house') ?></span><span class="val t-load"><?= $fmt($cur['load'] ?? null) ?></span><span class="unit">MW</span></div>
                    <div class="bg-m"><span class="lbl">Net Export</span><span class="pic t-exp"><?= $ico('tower') ?><?= $ico('arrow-r', 'arrow') ?></span><span class="val t-exp"><?= $fmt($cur['export'] ?? null) ?></span><span class="unit">MW</span></div>
                </div>
            </article>

            <!-- Previous day evening 19:00 -->
            <article class="bg-card prev">
                <h3>Previous Day Evening | 19:00 hrs | <?= esc($prevLabel) ?></h3>
                <div class="bg-metrics">
                    <div class="bg-m"><span class="lbl">Total Generation</span><span class="pic t-gen"><?= $ico('factory') ?><?= $ico('bolt') ?></span><span class="val t-gen"><?= $fmt($eve['gen'] ?? null) ?></span><span class="unit">MW</span></div>
                    <div class="bg-m"><span class="lbl">Domestic Load</span><span class="pic t-load"><?= $ico('house') ?></span><span class="val t-load"><?= $fmt($eve['load'] ?? null) ?></span><span class="unit">MW</span></div>
                    <div class="bg-m"><span class="lbl">Net Export</span><span class="pic t-exp"><?= $ico('tower') ?><?= $ico('arrow-r', 'arrow') ?></span><span class="val t-exp"><?= $fmt($eve['export'] ?? null) ?></span><span class="unit">MW</span></div>
                </div>
            </article>

            <!-- Change vs previous day -->
            <article class="bg-card chg">
                <h3><?= $ico('gear') ?> <span>Change Vs Previous Day<span class="sub"><?= esc($dateLabel) ?> 09:00 vs <?= esc($prevLabel) ?> 09:00</span></span></h3>
                <div class="bg-metrics">
                    <?php foreach (['gen' => 'Generation', 'load' => 'Load', 'export' => 'Net Export'] as $k => $label):
                        $d = $delta[$k] ?? null;
                        $up = $d !== null && $d >= 0; ?>
                        <div class="bg-m">
                            <span class="lbl"><?= $label ?></span>
                            <span class="tri <?= $up ? 't-up' : 't-down' ?>"><?= $ico($up ? 'tri-up' : 'tri-down') ?></span>
                            <span class="val <?= $up ? 't-up' : 't-down' ?>"><?= $sign($d) ?></span>
                            <span class="unit">MW</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($delta === null): ?>
                    <div class="bg-nodata">Previous day's report (<?= esc($prevLabel) ?>) has not been uploaded.</div>
                <?php endif; ?>
            </article>
        </div>

        <div class="bg-row2">
            <!-- Top plants -->
            <article class="bg-card top">
                <h3><?= $ico('bars') ?> Top Generating Plants at 09:00</h3>
                <div class="bg-plants">
                    <?php if ($plants): ?>
                        <div class="bg-ph"><span>#</span><span>Plant</span><span></span><span>Generation (MW)</span></div>
                        <?php foreach ($plants as $i => $pl): ?>
                            <div class="bg-pr">
                                <span><?= $i + 1 ?></span>
                                <span><?= esc($pl['name']) ?></span>
                                <span class="bar"><i style="width:<?= max(2, round($pl['mw'] / $maxPlant * 100)) ?>%"></i></span>
                                <span class="v"><?= $fmt($pl['mw']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="bg-empty">No plant data extracted.</div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Operational attention -->
            <article class="bg-card attn">
                <h3><?= $ico('warn') ?> Operational Attention</h3>
                <?php if ($alerts): ?>
                    <ul class="bg-alerts">
                        <?php foreach ($alerts as $a):
                            $parts = explode(': ', $a, 2); ?>
                            <li><span><?php if (count($parts) === 2): ?><b><?= esc($parts[0]) ?>:</b> <?= esc($parts[1]) ?><?php else: ?><?= esc($a) ?><?php endif; ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="bg-empty">No operational alerts reported.</div>
                <?php endif; ?>
            </article>

            <!-- National coincidental peak -->
            <article class="bg-card ncpl">
                <h3><?= $ico('peak') ?> National Coincidental Peak Load</h3>
                <div class="bg-ncpl-body">
                    <div class="bg-ncpl-val"><?= $fmt($ncpl['mw'] ?? null) ?> MW</div>
                    <?php if (!empty($ncpl['recorded_on'])): ?>
                        <div class="bg-ncpl-on">Recorded on:<br><?= esc($ncpl['recorded_on']) ?></div>
                    <?php endif; ?>
                    <svg class="mtn" viewBox="0 0 400 70" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0 70V44l50-24 40 20 60-34 70 40 50-22 70 30 60-16v32z" fill="#b9cfe3"/>
                        <path d="M0 70V56l80-14 70 12 90-18 80 14 80-8v28z" fill="#8fb79b"/>
                    </svg>
                </div>
            </article>
        </div>

        <!-- Previous day energy statistics -->
        <section class="bg-strip">
            <h3><?= $ico('bars') ?> Previous Day Energy Statistics | <?= esc($prevLabel) ?></h3>
            <div class="bg-sg">
                <div class="bg-s"><span class="pic t-gen"><?= $ico('gear') ?></span><div class="txt"><div class="l">Total Energy Generation</div><div class="v"><?= $fmt($en['gen_mu'] ?? null) ?> MU</div></div></div>
                <div class="bg-s"><span class="pic t-load"><?= $ico('house') ?></span><div class="txt"><div class="l">Domestic Energy Met</div><div class="v"><?= $fmt($en['met_mu'] ?? null) ?> MU</div></div></div>
                <div class="bg-s"><span class="pic t-exp"><?= $ico('tower') ?><?= $ico('arrow-r', 'arrow') ?></span><div class="txt"><div class="l">Net Energy Export</div><div class="v"><?= $fmt($en['export_mu'] ?? null) ?> MU</div></div></div>
                <div class="bg-s"><span class="pic t-exp"><?= $ico('tower') ?><?= $ico('arrow-l', 'arrow') ?></span><div class="txt"><div class="l">Net Energy Import</div><div class="v"><?= $fmt($en['import_mu'] ?? null) ?> MU</div></div></div>
                <div class="bg-s"><span class="pic t-gen"><?= $ico('swap') ?></span><div class="txt"><div class="l">Peak Cross-Border Transfer</div><div class="v"><?= $fmt($en['peak_xb_mw'] ?? null) ?> MW</div></div></div>
            </div>
        </section>
    </div>

    <footer class="bg-foot">
        <span><strong>Source:</strong> BPSO Daily Load-Generation Balance Report</span>
        <em>For quick management and operational briefing</em>
        <span class="tag">RELIABLE POWER | SUSTAINABLE BHUTAN</span>
    </footer>
</section>
