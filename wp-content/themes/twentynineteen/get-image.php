<?php
/**
 * Template Name: Get Photos Page
 */

get_header();
?>

    <style>
        .gi-image-container {
            text-align: center;
            margin: 50px 0;
        }
        .gi-image-container img {
            box-shadow: 0 1px 4px rgba(0,0,0,0.6);
        }
        .gi-message {
            line-height: 300px;
            font-size: 18px;
        }
        .gi-form {
            text-align: center;
        }
        .gi-form .gi-input {
            outline: none;
            font-size: 26px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
            border: solid 1px #c1c1c1;
        }
    </style>
    <div class="x-container max width main">
        <div class="offset cf">
          <div class="<?php x_main_content_class(); ?>" role="main">
            <div class="gi-image-container">
              <?php
                $imagecode = $_POST['imagecode'];
                if ($imagecode) {
                  $folder = $_SERVER['DOCUMENT_ROOT'].'/jinmedia.ca/images/';
                  $myfile = fopen($folder.".codemap", "r") or die("Unable to open file!");
                  $rawMap = fread($myfile,filesize($folder.'.codemap'));
                  fclose($myfile);
                  $map = explode('|', $rawMap);
                  $imageEntry;
                  foreach ($map as $keyval) {
                    $pair = explode(':', $keyval);
                    if($imagecode == $pair[0]){
                      $imageEntry = $pair;
                      break;
                    }
                  }
                  if($pair[1]) {
                    $image = $folder.$pair[1];
                    // Read image path, convert to base64 encoding
                    $imageData = base64_encode(file_get_contents($image));
                    // Format the image SRC:  data:{mime};base64,{data};
                    $src = 'data: '.mime_content_type($image).';base64,'.$imageData;
                    // Echo out a sample 
                    echo '<a href="' . $src . '" download="'.$pair[0].'" target="_blank"><img src="' . $src . '"/>';
                  } else {
                    echo '<div class="gi-message">
                                Sorry, this code is not valid.
                            </div>';
                  }
                }
              ?>
              </div>
                <form class="gi-form" action="" method="post">
                  <?php
                      echo '<p> Enter your code here to view your photo </p><input class="gi-input" type="text" name="imagecode" value="'.$imagecode.'"/>';
                  ?>
                </form>
              </div>
          <?php get_sidebar(); ?>
        </div>
    </div>

<?php get_footer(); ?>

