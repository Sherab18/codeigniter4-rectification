<style>
    .energy-marquee-text-container {
        overflow: hidden;
        width: 100%;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 6px;
        padding: 10px 0;
        margin: 1.5rem 0;
        white-space: nowrap;
        box-sizing: border-box;
    }

    .marquee-text-track {
        display: inline-block;
        padding-left: 100%;
        animation: scrollText 25s linear infinite;
        font-size: 1rem;
        font-weight: 500;
    }

    .energy-marquee-text-container:hover .marquee-text-track {
        animation-play-state: paused;
    }

    @keyframes scrollText {
        0% { transform: translate3d(0, 0, 0); }
        100% { transform: translate3d(-100%, 0, 0); }
    }

    .marquee-divider {
        margin: 0 25px;
        color: #6c757d;
        font-weight: 300;
    }
    
    .text-success-custom { color: #198754; }
    .text-warning-custom { color: #ffc107; background: #212529; padding: 2px 6px; border-radius: 4px; }
    .text-info-custom { color: #0dcaf0; background: #212529; padding: 2px 6px; border-radius: 4px; }
    .text-danger-custom { color: #dc3545; }
</style>

<div class="energy-marquee-text-container">
    <div class="marquee-text-track">
        <?php if (!empty($energy)): ?>
            
            <span class="text-dark fw-bold">
                <i class="bi bi-calendar-event me-1"></i>Energy Data for: 
                <u><?= date('F j, Y', strtotime($energy['r_date'])) ?></u>
            </span>
            
            <span class="marquee-divider">|</span>

            <span class="text-success-custom">
                <i class="bi bi-lightning-charge me-1"></i>Generation: <strong><?= number_format($energy['generation_mwh'], 0) ?> MWh</strong>
            </span>
            
            <span class="marquee-divider">|</span>
            
            <span>
                <i class="bi bi-graph-up text-warning me-1"></i>Peak Demand: <strong class="text-warning-custom"><?= number_format($energy['peak_demand_mw'], 0) ?> MW</strong>
            </span>
            
            <span class="marquee-divider">|</span>
            
            <span>
                <i class="bi bi-plug text-info me-1"></i>Energy Met: <strong class="text-info-custom"><?= number_format($energy['energy_met_mwh'], 0) ?> MWh</strong>
            </span>
            
            <span class="marquee-divider">|</span>
            
            <span class="text-danger-custom">
                <i class="bi bi-box-arrow-up-right me-1"></i>Energy Export to India: <strong><?= number_format($energy['energy_export_mwh'], 0) ?> MWh</strong>
            </span>

        <?php endif; ?>
    </div>
</div>