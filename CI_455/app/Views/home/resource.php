<style>
    .professional-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
        font-family: 'Montserrat', sans-serif;
    }

    .resource-grid {
        display: grid;
        /* Forces 4 equal columns in one row */
        grid-template-columns: repeat(4, 1fr); 
        gap: 20px;
        margin-top: 40px;
    }

    .resource-item {
        background: white;
        border-radius: 12px;
        padding: 30px 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        cursor: pointer;
        border-top: 5px solid #3498db;
    }

    .resource-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .resource-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(52, 152, 219, 0.1);
    }

    .resource-icon i {
        font-size: 2.5rem;
        color: #3498db;
    }

    .resource-content h3 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .resource-content small {
        color: #7f8c8d;
        font-size: 0.85rem;
        line-height: 1.4;
        display: block;
        margin-bottom: 15px;
    }

    .resource-action {
        margin-top: auto;
        color: #3498db;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Responsive: 2 columns on tablets, 1 on mobile */
    @media (max-width: 992px) { .resource-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .resource-grid { grid-template-columns: 1fr; } }
</style>

<div class="professional-container">
    <div class="resource-grid">
        <div class="resource-item" onclick="location.href='<?= base_url('publicdata/report_public') ?>'">
            <div class="resource-icon"><i class="fas fa-chart-line"></i></div>
            <div class="resource-content">
                <h3>Reports</h3>
                <small>Daily and annual performance analytics.</small>
                <div class="resource-action">View reports <i class="fas fa-arrow-right"></i></div>
            </div>
        </div>

        <div class="resource-item" onclick="location.href='<?= base_url('home/documents') ?>'">
            <div class="resource-icon"><i class="fas fa-file-contract"></i></div>
            <div class="resource-content">
                <h3>Documents</h3>
                <small>External guidelines and reference materials.</small>
                <div class="resource-action">Explore docs <i class="fas fa-arrow-right"></i></div>
            </div>
        </div>

        <div class="resource-item" onclick="location.href='<?= base_url('home/internal_documents') ?>'">
            <div class="resource-icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="resource-content">
                <h3>Forms</h3>
                <small>Internal templates and procedural documents.</small>
                <div class="resource-action">Access forms <i class="fas fa-arrow-right"></i></div>
            </div>
        </div>

        <div class="resource-item" onclick="location.href='<?= base_url('publicdata/cod_public') ?>'">
            <div class="resource-icon"><i class="fas fa-industry"></i></div>
            <div class="resource-content">
                <h3>Plant CODs</h3>
                <small>Official Commercial Operation Date certificates.</small>
                <div class="resource-action">Access CODs <i class="fas fa-arrow-right"></i></div>
            </div>
        </div>
    </div>
</div>