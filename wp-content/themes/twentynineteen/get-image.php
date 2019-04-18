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
            max-width: 100%;
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
                                    $imageExtension = pathinfo($image, PATHINFO_EXTENSION);
                                    
                                    $downloadName = $pair[0] . '.' . $imageExtension;
                                    
                                    // Read image path, convert to base64 encoding
                        
                                    $imageData = base64_encode(file_get_contents($image));
                                    // Format the image SRC:  data:{mime};base64,{data};
                                    
                                    $src = 'data:'.mime_content_type($image).';base64,'.$imageData;
                                    $downloadSrc = 'data:application/octet-stream;base64,'.$imageData;
                                    // Echo out a sample
                                    echo '<a id="downloadLink" href="'.$src.'" download="'.$downloadName.'" style="display: block;"><img alt="'.$downloadName.'" src="' . $src . '"/></a>';
                                  } else {
                                    echo '<div class="gi-message">
                                                Sorry, this code is not valid.
                                            </div>';
                                  }
                                }
                			?>
                        </div>
                        <script>
                            function createBlob(dataURI) {
                              // convert base64 to raw binary data held in a string
                              // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
                              var byteString = atob(dataURI.split(',')[1]);
                            
                              // separate out the mime component
                              var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
                            
                              // write the bytes of the string to an ArrayBuffer
                              var ab = new ArrayBuffer(byteString.length);
                            
                              // create a view into the buffer
                              var ia = new Uint8Array(ab);
                            
                              // set the bytes of the buffer to the correct values
                              for (var i = 0; i < byteString.length; i++) {
                                  ia[i] = byteString.charCodeAt(i);
                              }
                            
                              // write the ArrayBuffer to a blob, and you're done
                              var blob = new Blob([ab], {type: mimeString});
                              const url = window.URL.createObjectURL(blob);
                              return url;
                            }
                            var link = document.getElementById('downloadLink');
                            if(link) {
                                link.href = createBlob(link.href);
                            }
                            
                        </script>
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


