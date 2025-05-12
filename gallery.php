<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nirmiti College | Gallery</title>
    <link rel="shortcut icon" type="images" href="images/logonimriti.PNG">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        .gallery-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .activity-section {
            margin-bottom: 40px;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .activity-caption {
            font-size: 1.5rem;
            color: #0eb582;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .activity-date {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 20px;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            height: 200px;
        }
        
        .gallery-item:hover {
            transform: scale(1.03);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .no-activities {
            text-align: center;
            padding: 50px 0;
            color: #666;
        }
        
        /* Lightbox styles */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .lightbox-content {
            max-width: 90%;
            max-height: 90%;
        }
        
        .lightbox-content img {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
        }
        
        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }
        
        .lightbox-caption {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            color: white;
            text-align: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body>

    <!-- header section starts  -->

    <?php include "common/header.php";?>

    <!-- header section ends -->

    <section class="heading">
        <h3>GALLERY</h3>
        <p> <a href="index.php">HOME >></a> GALLERY </p>
    </section>

    <!-- Gallery section starts -->
    <div class="gallery-container">
        <?php
        // Include database connection
        require_once "admin/db_conn.php";
        
        // Fetch activities from database, grouped by caption
        $sql = "SELECT caption, upload_date, GROUP_CONCAT(image_path ORDER BY id DESC) as images 
                FROM activities 
                GROUP BY caption, upload_date 
                ORDER BY upload_date DESC";
        
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            // Display activities
            while($row = $result->fetch_assoc()) {
                $caption = htmlspecialchars($row['caption']);
                $date = date('F j, Y', strtotime($row['upload_date']));
                $images = explode(',', $row['images']);
                
                echo '<div class="activity-section">';
                echo '<h3 class="activity-caption">' . $caption . '</h3>';
                echo '<p class="activity-date">Posted on: ' . $date . '</p>';
                
                echo '<div class="gallery-grid">';
                foreach($images as $image) {
                    echo '<div class="gallery-item">';
                    echo '<img src="' . htmlspecialchars($image) . '" alt="' . $caption . '" onclick="openLightbox(\'' . htmlspecialchars($image) . '\', \'' . $caption . '\')">';
                    echo '</div>';
                }
                echo '</div>'; // End gallery-grid
                echo '</div>'; // End activity-section
            }
        } else {
            // No activities found
            echo '<div class="no-activities">';
            echo '<h3>No activities to display</h3>';
            echo '<p>Check back later for updates on college activities and events.</p>';
            echo '</div>';
        }
        ?>
    </div>
    <!-- Gallery section ends -->

    <!-- Lightbox for image preview -->
    <div class="lightbox" id="imageLightbox">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <div class="lightbox-content">
            <img id="lightboxImage" src="" alt="">
        </div>
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>

    <!-- footer section starts  -->

    <?php include "common/footer.php";?>

    <!-- footer section ends -->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    
    <script>
        // Lightbox functionality
        function openLightbox(imageSrc, caption) {
            document.getElementById('lightboxImage').src = imageSrc;
            document.getElementById('lightboxCaption').textContent = caption;
            document.getElementById('imageLightbox').style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }
        
        function closeLightbox() {
            document.getElementById('imageLightbox').style.display = 'none';
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
        
        // Close lightbox when clicking outside the image
        document.getElementById('imageLightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
        
        // Close lightbox with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('imageLightbox').style.display === 'flex') {
                closeLightbox();
            }
        });
    </script>
</body>

</html>