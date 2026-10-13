<?php
// Combined, clean data array
$slides = [
    [
        'image' => 'Wangchu.png',
        'title' => 'Upcoming Hydropower Projects',
        'description' => 'Upcoming hydropower projects, ensuring sustainable energy solutions for the nation.',
        'active' => True,
    ],
    [
        'image' => 'Dorjilung.png',
        'title' => 'Upcoming Hydropower Projects',
        'description' => 'Upcoming hydropower projects, ensuring sustainable energy solutions for the nation.',
        'active' => False,
    ],
    [
        'image' => 'Jomori.png',
        'title' => 'Upcoming Hydropower Projects',
        'description' => 'Upcoming hydropower projects, ensuring sustainable energy solutions for the nation.',
        'active' => False,
    ],
    [
        'image' => 'Khorlochu.png',
        'title' => 'Upcoming Hydropower Projects',
        'description' => 'Upcoming hydropower projects, ensuring sustainable energy solutions for the nation.',
        'active' => False,
    ],
    [
        'image' => '4thfoundation.png',
        'title' => 'BPSO 4th Foundation Day Celebration',
        'description' => 'BPSO 4th Foundation Day, led by the CEO, embarked on a spiritual journey to Tashigang Goenpa in Hongtsho, Thimphu.',
        'active' => False,
    ],

    [
        'image' => 'newoffice.jpeg',
        'title' => 'Inauguration of New Office.',
        'description' => 'The BPSO new office has been inaugurated to accommodate the growing needs of our organization.',
        'active' => False,
    ],
    [
        'image' => 'mousigned.jpeg',
        'title' => 'Signed Memorandum of Understanding (MoU) between BPC and BPSO on 31th December, 2025.',
        'description' => 'The Memorandum of Understanding (MoU) was signed between Bhutan Power Corporation Limited (BPC) and Bhutan Power System Operator (BPSO) to formalize cooperation and coordination in the power sector. The MoU defines the roles, responsibilities, and collaborative framework between the two organizations to ensure reliable, secure, and efficient operation of the national power system.',
        'active' => false,
    ],

];

// Initialize counter for modal IDs
$modal_id_counter = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* --- Default Styles (For Desktop/Tablet/Large Screens) --- */
        .carousel-inner {
            height: 500px;
            /* Standard height for larger screens */
        }

        /* New style for better image control - remains the same */
        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* --- Mobile-Specific Styles (Media Query) --- */
        /* Targets screens up to 576px wide (typical small phone size) */
        @media (max-width: 576px) {
            .carousel-inner {
                height: 300px;
                /* Reduced height for better mobile viewing */
            }
        }

        /* Optional: Target screens up to 768px wide (smaller tablets/landscape phones) */
        @media (max-width: 768px) {
            /* You can set a middle ground height here if 300px is too small for a tablet */
            /* .carousel-inner {
                height: 400px; 
            } */
        }
    </style>
</head>

<body>

    <section id="bpso_event" class="carousel slide my-5" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-indicators">
            <?php foreach ($slides as $i => $slide): ?>
                <button type="button" data-bs-target="#bpso_event" data-bs-slide-to="<?= $i ?>" class="<?= $slide['active'] ? 'active' : '' ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner rounded">
            <?php foreach ($slides as $slide): ?>
                <?php $modalId = "myModal" . $modal_id_counter++; ?>
                <div class="carousel-item <?= $slide['active'] ? 'active' : '' ?>">
                    <img
                        src="<?= base_url() ?>/assets/carousel/<?= esc($slide['image']) ?>"
                        class="d-block w-100 object-fit-cover"
                        alt="<?= esc($slide['title']) ?>"
                        data-bs-toggle="modal"
                        data-bs-target="#<?= $modalId ?>">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded">
                        <h5><?= esc($slide['title']) ?></h5>
                        <p><?= esc($slide['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#bpso_event" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bpso_event" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <?php $modal_id_counter = 1; // Reset counter for modals
    foreach ($slides as $slide): ?>
        <div class="modal" id="<?= "myModal" . $modal_id_counter++ ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?= esc($slide['title']) ?></h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="<?= base_url() ?>/assets/carousel/<?= esc($slide['image']) ?>" class="img-fluid mb-3" alt="<?= esc($slide['title']) ?>">
                        <p><?= esc($slide['description']) ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</body>

</html>