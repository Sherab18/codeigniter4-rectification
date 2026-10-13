<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
About Us | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<style>
    :root {
        --primary: #0d6efd;
        --secondary: #198754;
        --accent: #d63384;
        --dark: #0d3b66;
        --light: #f8f9fa;
    }

    .section-header {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2.5rem;
    }

    .section-header h3 {
        font-weight: 700;
        color: var(--dark);
        letter-spacing: 0.5px;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 2px;
    }

    .background-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .background-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .timeline-border {
        border-left: 4px solid var(--primary);
        padding-left: 2rem;
        position: relative;
    }

    .timeline-border::before {
        content: '';
        position: absolute;
        left: -2px;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(to bottom, var(--primary), var(--secondary));
        z-index: -1;
    }

    .timeline-item {
        margin-bottom: 1.8rem;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -2.6rem;
        top: 8px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: white;
        border: 3px solid var(--primary);
    }

    .role-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .role-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }

    .role-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 28px;
        background: white;
        color: var(--primary);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .role-content {
        padding: 1.8rem;
        text-align: center;
    }

    .role-content p {
        color: #f0f5f5;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .bg-primary-gradient {
        background: linear-gradient(135deg, var(--primary), #0b5ed7);
    }

    .bg-secondary-gradient {
        background: linear-gradient(135deg, var(--secondary), #157347);
    }

    .bg-accent-gradient {
        background: linear-gradient(135deg, var(--accent), #aa2b6d);
    }

    .bg-dark-gradient {
        background: linear-gradient(135deg, var(--dark), #0a2d50);
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
        margin: 4rem 0;
    }

    .container-custom {
        max-width: 1200px;
    }

    @media (max-width: 768px) {
        .timeline-border {
            padding-left: 1.5rem;
        }

        .timeline-item::before {
            left: -1.9rem;
        }
    }
</style>

<main>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container container-custom py-5">
                    <section class="background-section mb-6">
                        <div class="section-header text-center">
                            <h3>Background</h3>
                        </div>

                        <div class="card background-card shadow-lg">
                            <div class="card-body p-4 p-lg-5">
                                <div class="timeline-border">
                                    <div class="timeline-item">
                                        <p>Established in accordance with the <strong class="text-primary">Economic Development Policy</strong> of the Kingdom of Bhutan 2010, Bhutan Power System Operator (BPSO) is entrusted to coordinate and regulate power system operation, outages, and manage/monitor export and import of power for the overall reliability and security of electricity supply.</p>
                                    </div>

                                    <div class="timeline-item">
                                        <p>Initially known as the National Load Dispatch Centre (NLDC), BPSO was inaugurated by Hon'ble Lyonpo Yeshi Zimba on 17th December 2011 and licensed by Electricity Regulatory Authority (ERA) on 1st July 2014 for the operation of Bhutan's power system.</p>
                                    </div>

                                    <div class="timeline-item">
                                        <p>Since 1st July 2022, BPSO has been under the <strong class ="text-primary">Ministry of Economic Affairs (MoEA)</strong>, with its main control centre at Thimphu, backup Control Centre at Malbase, and Eastern Data Centre (EDC) at Tintibi substation.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="section-divider"></div>

                    <section class="roles-section mb-6">
                        <div class="section-header text-center">
                            <h3>Roles & Responsibilities</h3>
                        </div>

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-primary-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-shield-check"></i>
                                            </div>
                                            <p>Ensuring the safety and stability of the grid to prevent outages and ensure reliable power supply.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-secondary-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-lightning-charge"></i>
                                            </div>
                                            <p>Maintaining a balance between electricity generation and consumption to avoid overloading or shortages.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-accent-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-diagram-3"></i>
                                            </div>
                                            <p>Ensuring fair and non-discriminatory dispatch of generation installations across the grid.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-dark-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-gear"></i>
                                            </div>
                                            <p>Coordinating transmission and generation outages, including black start procedures.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-primary-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-graph-up"></i>
                                            </div>
                                            <p>Monitoring power system performance and ensuring compliance with grid standards.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-secondary-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-globe"></i>
                                            </div>
                                            <p>Facilitating the export and import of electricity.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-accent-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-calendar-event"></i>
                                            </div>
                                            <p>Scheduling electricity distribution within the country and across borders.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-dark-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-bar-chart"></i>
                                            </div>
                                            <p>Forecasting generation requirements and national loads to ensure adequate supply.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-primary-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-database"></i>
                                            </div>
                                            <p>Maintaining the accuracy for operation and decision making.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="role-card shadow-sm">
                                    <div class="bg-secondary-gradient">
                                        <div class="role-content">
                                            <div class="role-icon">
                                                <i class="bi bi-shield-lock"></i>
                                            </div>
                                            <p>Performing additional energy security-related functions as prescribed by the Ministry.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main><br>

<?= $this->endSection() ?>