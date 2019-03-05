<?php
/**
 * Template Name: Get Photos Page
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

    <form action="" method="post">
      <input type="text" name="imagecode" />
    </form>

			<?php
        $imagecode = $_POST['imagecode'];
        if ($imagecode) {
          $folder = $_SERVER['DOCUMENT_ROOT'].'/wp-content/gallery/test/';
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
            // Echo out a sample image
            echo '<img src="' . $src . '">';
          } else {
            echo 'Sorry, this code is not valid.';
          }
        }
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
