<?php
namespace app\components;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
class CropImage extends Component
{

  public $name = '';
 public function removeBorders($configs)
 {
   //Config of remove
   $image_name   = $configs['source'];
   $path         = $configs['save'];
   $border_color = $configs['borderColor'];
   $accuracy     = $configs['accuracy'];
   $this->name   = $configs['name'];
   if(isset($configs['tolerance'])) {
   $tolerance    = $configs['tolerance'];
   } else {
     $tolerance = 3355443; /// CONST VALUE BETWEEN TWO COLOR DIFFERENCE
   }
   // Get Extension of image and load
 $config = array
 (
     'borders' => array
     (
         'top' => array ('remove' => true, 'color' => $border_color, 'tolerance' => $tolerance), // tolerance like (0xFFFFFF-0xCCCCCC)
         'bottom' => array ('remove' => true, 'color' => $border_color, 'tolerance' => $tolerance),
         'left' => array ('remove' => true, 'color' => $border_color, 'tolerance' => $tolerance),
         'right' => array ('remove' => true, 'color' => $border_color, 'tolerance' => ($tolerance))
     )
 );
 // Check if the file exists
 if (isset ($image_name) && $image_name != '' )
 {
     // Load the image (JPEG assumed in this example)
     $extension__image =  substr(strrchr($image_name, '.'), 1);
     if($extension__image == "png") {
        $im = imagecreatefrompng($image_name);
     } else if ($extension__image =="jpg" || $extension__image == "jpeg") {
        $im = imagecreatefromjpeg($image_name);
     } else {
       echo "Incorrect image extension. Use JPG/JPEG OR PNG";
       die();
     }
     if ($im !== false)
     {
         // Get the image resolution
         $res = array ('x' => (int)imagesx ($im), 'y' => (int)imagesy ($im));
         if ($res['x'] > 0 && $res > 0)
         {
             // Set the initial border for the image
             $crop = array ('top' => 0, 'bottom' => $res['y'], 'left' => 0, 'right' => $res['x']);
             // Check if the top should be cropped
             $acc = 0;
             if (isset ($config['borders']['top']['remove']) && $config['borders']['top']['remove'] === true && isset ($config['borders']['top']['color']) && $config['borders']['top']['color'] != '')
             {
                 // Loop through each pixel until an incorrect color is found
                 $found = false;
                 for ($y = 0; $y < $res['y']; $y++)
                 {
                     for ($x = 0; $x < $res['x']; $x++)
                     {
                         $pixel = imagecolorat ($im, $x, $y);
                         if (($config['borders']['top']['color'] < ($pixel - $config['borders']['top']['tolerance'])) || ($config['borders']['top']['color'] > ($pixel + $config['borders']['top']['tolerance'])))
                         {
                             $crop['top'] = $y;
                             if($acc == $accuracy) {
                               $found = true;
                               break;
                             } else {
                                $acc++;
                             }
                         }
                     }
                     if ($found === true) { break; }
                 }
             }
              $acc = 0;
             // Check if the bottom should be cropped
             if (isset ($config['borders']['bottom']['remove']) && $config['borders']['bottom']['remove'] === true && isset ($config['borders']['bottom']['color']) && $config['borders']['bottom']['color'] != '')
             {
                 // Loop through each pixel until an incorrect color is found
                 $found = false;
                 for ($y = ($res['y'] - 1); $y >= 0; $y--)
                 {
                     for ($x = 0; $x < $res['x']; $x++)
                     {
                         $pixel = imagecolorat ($im, $x, $y);
                         if (($config['borders']['bottom']['color'] < ($pixel - $config['borders']['bottom']['tolerance'])) || ($config['borders']['bottom']['color'] > ($pixel + $config['borders']['bottom']['tolerance'])))
                         {
                             $crop['bottom'] = $y + 1;
                             if($acc == $accuracy) {
                               $found = true;
                               break;
                             } else {
                                $acc++;
                             }
                         }
                     }
                     if ($found === true) { break; }
                 }
             }
             $acc = 0;
             // Check if the left should be cropped
             if (isset ($config['borders']['left']['remove']) && $config['borders']['left']['remove'] === true && isset ($config['borders']['left']['color']) && $config['borders']['left']['color'] != '')
             {
                 // Loop through each pixel until an incorrect color is found
                 $found = false;
                 for ($x = 0; $x < $res['x']; $x++)
                 {
                     for ($y = 0; $y < $res['y']; $y++)
                     {
                         $pixel = imagecolorat ($im, $x, $y);
                         if (($config['borders']['left']['color'] < ($pixel - $config['borders']['left']['tolerance'])) || ($config['borders']['left']['color'] > ($pixel + $config['borders']['left']['tolerance'])))
                         {
                             $crop['left'] = $x;
                             if($acc == $accuracy) {
                               $found = true;
                               break;
                             } else {
                                $acc++;
                             }
                         }
                     }
                     if ($found === true) { break; }
                 }
             }
            $acc = 0;
             // Check if the right should be cropped
             if (isset ($config['borders']['right']['remove']) && $config['borders']['right']['remove'] === true && isset ($config['borders']['right']['color']) && $config['borders']['right']['color'] != '')
             {
                 // Loop through each pixel until an incorrect color is found
                 $found = false;
                 for ($x = ($res['x'] - 1); $x >= 0; $x--)
                 {
                     for ($y = 0; $y < $res['y']; $y++)
                     {
                         $pixel = imagecolorat ($im, $x, $y);
                         if (($config['borders']['right']['color'] < ($pixel - $config['borders']['right']['tolerance'])) || ($config['borders']['right']['color'] > ($pixel + $config['borders']['right']['tolerance'])))
                         {
                             $crop['right'] = $x+1;
                             if($acc == $accuracy) {
                               $found = true;
                               break;
                             } else {
                                $acc++;
                             }
                         }
                     }
                     if ($found === true) {
                       break;
                     }
                 }
             }
             // Create a new image to hold the cropped image
             $newres = array ('x' => ($crop['right'] - $crop['left']), 'y' => ($crop['bottom'] - $crop['top']));
             $newim = imagecreatetruecolor ($newres['x'], $newres['y']);
             if ($newim !== false)
             {
                 // Crop the image to the new image
                 if (imagecopy ($newim, $im, 0, 0, $crop['left'], $crop['top'], $newres['x'], $newres['y']) !== false)
                 {
                     // The cropping was successful, so output the cropped image
                     $image__name = $this->name;//md5(time() . $image_name);
                     if($extension__image == "png") {
                         //header ('Content-Type: image/png');
                        //imagepng($newim);
                         imagepng($newim,$path.$image__name); //.".".$extension__image
                     } else if ($extension__image =="jpg" || $extension__image == "jpeg") {
                         //header("Content-Type: image/jpeg");
                         //imagejpeg($newim);
                         imagejpeg($newim,$path.$image__name); //.".".$extension__image
                     }
                     // Clean up and exit
                     imagedestroy ($im);
                     imagedestroy ($newim);
                     exit ();
                 }
                 else
                 {
                     // The image failed to be cropped, so exit the script
                     die ("Failed to crop the source image");
                 }
             }
             else
             {
                 // The new image failed to be created, so exit the script
                 die ("Unable to create cropped image");
             }
         }
         else
         {
             // The image does not have a valid resolution, so exit the script
             die ("Bad resolution for image");
         }
     }
     else
     {
         // The image could not be opened by GD, so exit the script
         die ("Image could not be opened");
     }
 }
 else
 {
     // The file does not exist, so exit the script
     die ("File not found");
 }
 }
}
