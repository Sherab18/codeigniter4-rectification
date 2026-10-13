<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Technical Papers | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .technical-papers {
        background-color: #f8f9fa;
        padding: 2rem 0;
    }

    .paper-header {
        background: linear-gradient(135deg, #007bff, #00bcd4);
        color: white;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .paper-table {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .paper-table th {
        background-color: #f1f7fd;
        font-weight: 600;
        color: #2c3e50;
    }

    .paper-table tr:hover {
        background-color: #f8f9fa;
    }

    .paper-link {
        color: #007bff;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .paper-link:hover {
        color: #0056b3;
        text-decoration: none;
    }

    .paper-link i {
        margin-right: 5px;
    }

    .table-responsive {
        border-radius: 8px;
    }
</style>

<main class="technical-papers">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="paper-header text-center">
                    <h2><i class="fas fa-file-alt me-2"></i>Technical Papers</h2>
                    <p class="mb-0">Published research by our BPSO Employee</p>
                </div>

                <div class="paper-table">
                    <div class="table-responsive">
                        <table id="papersTable" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Authors</th>
                                    <th>Conference/Publication</th>
                                    <th>Year</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Var Compensation Sizing and Placement to Enhance Voltage Profile and Reduce Losses in Bhutan Grid</td>
                                    <td>Samten, Tempa Sangay, Sandip Rai</td>
                                    <td>2025 IEEE PES GTD Grand International Conference and Exposition Asia (GTD Asia), Bangkok, Thailand.</td>
                                    <td>November,2025</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/11313247" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Literature Review on Modeling of Integrated T&D System using Dynamic Phasor Technique</td>
                                    <td>Ugyen Chophel</td>
                                    <td>Vol. 8 No. 1 (2025): Zorig Melong|A Technical Journal of Science Engineering and Technology </td>
                                    <td>20-06-2025</td>
                                    <td><a href="https://doi.org/10.17102/zmv8.i1.010" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Communication Facilities in Bhutan’s Power Sector: Overview, Implementation, and Challenges</td>
                                    <td>Ugyen Chophel, Karma Tshomo, Ngawang Tenzin</td>
                                    <td> 2025 International Conference on Power, Energy and Innovations (ICPEI), Pattaya, Thailand</td>
                                    <td>15-17 October 2025</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/11282609" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Analysis of Bhutan Power Systems using PSS®E Software</td>
                                    <td>Kinley Jamtsho, Dawa Chhoedron, Ugyen Chophel, Samten</td>
                                    <td>Vol. 8 No. 2 (2025): Zorig Melong|A Technical Journal of Science Engineering and Technology</td>
                                    <td>17-08-2025</td>
                                    <td><a href="https://doi.org/10.17102/zmv8.i2.018" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Impact Assessment of Renewable Energy Integration: A Case Study on Sephu Solar PV Plant Integration</td>
                                    <td>Samten, Dawa Gyeltshen, Kinley Jamtsho</td>
                                    <td>Vol. 8 No. 2 (2025): Zorig Melong|A Technical Journal of Science Engineering and Technology</td>
                                    <td>17-08-2025</td>
                                    <td><a href="https://doi.org/10.17102/zmv8.i2.001" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Contingency Ranking and Analysis of Bhutan Network using Performance Index: Case Studies</td>
                                    <td>Samten, Ugyen Chophel, Bhimla Rai, Ugyen Tshering</td>
                                    <td>Hua Hin, Thailand, Volume 2943, 2025 13th International Electrical Engineering Congress (iEECON)</td>
                                    <td>2025</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/10987741" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Transforming Power System Operations: A Case Study of SCADA/EMS in Bhutan</td>
                                    <td>Ugyen Chophel, Samten, Kinley Yangden, Karma Tshomo</td>
                                    <td>Bali, Indonesia, Volume 2943, 5th International Conference on Power, Energy, and Electrical Engineering (PEEE 2024)</td>
                                    <td>2025</td>
                                    <td><a href="https://iopscience.iop.org/article/10.1088/1742-6596/2943/1/012001" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Dynamic Modeling and Analysis of Bhutan Power Systems with PSSE Software</td>
                                    <td>Samten, Ugyen Chophel, Dawa Gyeltshen, Karma Dema, Kinzang Wangmo</td>
                                    <td>Kathmandu, Nepal, 2024 IEEE/International Conference on Power System Technology (PowerCon)</td>
                                    <td>2025</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/10870541" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Voltage Stability and Transfer Limit Analysis in Bhutan Power System Using P-V Curve Approach</td>
                                    <td>Samten, Ugyen Chophel, Dawa Gyeltshen, Sherub</td>
                                    <td>Pattaya, Thailand, 2024 IEEE/IAS Industrial and Commercial Power System Asia (I&CPS Asia)</td>
                                    <td>2024</td>
                                    <td><a href="https://doi.org/10.1109/ICPSAsia61913.2024.10761922" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Investigation of ToU and V2G to Accommodate High EV Penetrations in Power Distribution Grid</td>
                                    <td>Ugyen Chophel, Wijarn Wangdee</td>
                                    <td>Chiang Mai, Thailand, IEEE Transportation Electrification Conference and Expo, Asia-Pacific (ITEC Asia-Pacific)</td>
                                    <td>2023</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/10372236" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Addressing Under-Voltage Issues through Shunt Capacitor Installation</td>
                                    <td>Samten, Ugyen Chophel</td>
                                    <td>International Journal of Scientific Research and Engineering Development</td>
                                    <td>2023</td>
                                    <td><a href="http://www.ijsred.com/volume6/issue2/IJSRED-V6I2P81.pdf" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>Investigation of Lightning Overvoltage on 220 kV Transmission Lines in Bhutan Using ATP-EMTP</td>
                                    <td>Samten, Thanapong Suwanasri, Cattareeya Suwanasri, Nattapon Panmala</td>
                                    <td>Phrachuap Khirikhan, Thailand, International Conference on Power, Energy and Innovations (ICPEI)</td>
                                    <td>2023</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/10473853" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>Practical Experience on WAMS Technology Implementation in Bhutan Power System</td>
                                    <td>Ugyen Chophel, Samten</td>
                                    <td>Pattaya Chonburi, Thailand, International Conference on Power, Energy and Innovations (ICPEI)</td>
                                    <td>2022</td>
                                    <td><a href="https://ieeexplore.ieee.org/abstract/document/9986911" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td>Frequency-dependent impedance of transformer in mesh network for converter-driven stability analysis</td>
                                    <td>Dawa Gyeltshen, Viswaja Yellisetti, Albert Moser, Nisai Fuengwarodsakul</td>
                                    <td>Pattaya Chonburi, Thailand, International Conference on Power, Energy and Innovations (ICPEI)</td>
                                    <td>2022</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/9986807" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                                <tr>
                                    <td>15</td>
                                    <td>A simulation setup for analyzing mitigation methods for reducing the impact of extensive EV penetration in the distribution network</td>
                                    <td>Ugyen Chophel, Charukeshi Joglekar, Ferdinanda Ponci, Wijarn Wangdee, Antonello Monti</td>
                                    <td>Espoo, Finland, IEEE PES Innovative Smart Grid Technologies Europe (ISGT Europe)</td>
                                    <td>2021</td>
                                    <td><a href="https://ieeexplore.ieee.org/document/9640005" target="_blank" rel="noopener noreferrer" class="paper-link"><i class="fas fa-external-link-alt"></i>View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><br>

<script>
    $(document).ready(function() {
        $('#papersTable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search papers...",
            },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100]
        });
    });
</script>

<?= $this->endSection() ?>