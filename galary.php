<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./main.css">
   
</head>
<body>
     <div class="container">

        <header class="header">
            <h2>welcome to our image galary system</h2>
        </header>

        <div class="content">
            <div class="sorting">
            <div class="input-1">
                    <form method="get">
                        <select name="languages" id="lang">
                            <option value="A-Z">Ascending Order</option>
                            <option value="Z-A">Descending Order</option>
                        </select>
                        <input type="submit" name="submit" value="Submit" />
                        <input class="search" type="text" placeholder="search">
                    </form>
                </div>
                <button id="create" class="create-btn">Create gallery</button>
            </div>
          <div class="image-galary-container">
               <?php
                  include_once 'db_connect.php';

                 if(isset($_GET["submit"])) {
                            // Get the selected sorting order
                            $sortingOrder = $_GET["languages"];
                            
                            // Set the sorting direction for the SQL query
                            $sortingDirection = ($sortingOrder === 'A-Z') ? 'ASC' : 'DESC';

                        $sql = "SELECT * FROM galary ORDER BY titleGalary $sortingDirection";

                        $stmt = mysqli_stmt_init($conn);
                        $stmt_prepare = mysqli_stmt_prepare($stmt, $sql);
                        if ( $stmt_prepare) {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<a href="#">
                                <div style = "background-image: url(images/gallery/'. $row["imageFullNameGalary"].');"></div>
                                <h3>'. $row["titleGalary"].'</h3>
                                <p>'. $row["descGalary"].'</p>';
                            }
                        }else{
                            echo "something went wrong";
                        }
                    }
                ?>
          </div>
        </div>

        <!--  <div class="action">
                        <button>delete</button>
                        <button>edit</button>
                        </div> -->

        <footer class="footer">
            <h2>Made by us</h2>
        </footer>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <a href="#" class="close" id="close-modal">
                <i class="fa fa-times" aria-hidden="true">close</i>
            </a>
            <form  class="modal-form" action="includes/galary-upload.inc.php" method="post" enctype="multipart/form-data">
               
                    <input type="text" class="input" name="filename" placeholder="file Name...">
                
                    <input type="text" class="input" name="filetitle" placeholder="file title...">
               
                    <input type="text" class="input" name="filedesc" placeholder="file description">
              
                    <input type="file" class="input" name="file" placeholder="image..">
               
                  <button type="submit" name = "submit" class="submit-btn">upload</button>
                
            </form>
        </div>
    </div>

    <script>
        var createBtn = document.getElementById("create");
       var closeBtn = document.getElementById("close-modal");

        /* show the modal page */
        createBtn.addEventListener("click", function() {
            var modal = document.getElementById("modal");
           console.log(modal)
            modal.classList.add("visible");
            //console.log("button clicked");
        });

        /* removing modal page */
        function closeModal() {
            var modal = document.getElementById("modal");
            modal.classList.remove("visible");
        };
        closeBtn.addEventListener("click", closeModal);

        function sortImages() {
            var langSelect = document.getElementById("lang");
            var selectedOption = langSelect.options[langSelect.selectedIndex].value;
        
         // Reload the page with the selected sorting option as a parameter
          window.location.href = "galary.php?sort=" + selectedOption;
       }

    </script>
</body>
</html>