<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.imagesize.php
 * Type:     function
 * Name:     imagesize
 * Purpose:  resizes and caches an image
 * Version:  1.03
 * Creator:  Eli Van Zoeren - eli@newmediacampaigns.com
 * -------------------------------------------------------------
 *
 * Copyright (c) 2009 New Media Campaigns
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

// {imagesize src=$imageUrl [width=200] [height=100] [crop=true] [bw=true] [colorize="#ff0000"] [radius=10] [forcepng=true] [background='#000000'] [alt='Alternate Text'] [title='Image Title'] [class='className'] [id='idName'] [style='inline styles']}





function remoteFileData2($f) {
    $h = get_headers($f, 1);
    if (stristr($h[0], '200')) {
        foreach($h as $k=>$v) {
            if(strtolower(trim($k))=="last-modified") return strtotime($v);
        }
    }
}



function smarty_function_imagesize2($params, &$smarty)
{

    global $actWatermark;

    require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/phpthumb/ThumbLib.inc.php');

    $params['src'] = preg_replace('/\?.*/', '', $params['src']);

    if (preg_match('/https?:\/\//', $params['src'])) {

            $fileName = basename($params['src']);

            $thumbImg = '';
            $path = '/media/images/properties/';

            if ($params['path'] != '') {
                $path = $params['path'];
            }

            $pathInfo = pathinfo($params['src']);
            $paths['filePath'] = $pathInfo['dirname'];
            $paths['fileExt'] = $pathInfo['extension'];
            $paths['fileBasename'] = $pathInfo['filename'] ? $pathInfo['filename'] : substr($fileName ,0,strrpos($fileName ,'.'));
            $paths['fileSrc'] = $path . '' . $fileName;
            $paths['cachePath'] = $path. 'thumbnails/';



            $rep = array('stream.asp?pic=', '&width=large', ' ', '%');

            $cachedName = str_replace($rep, '', md5($params['src'])) . '_' . $params['width'] . 'x' . $params['height'];
            $cachedName .= '.' . str_replace($rep, '', $paths['fileExt']);
            $cachedPath = $paths['cachePath'] . $cachedName;

            $noImagePath = $_SERVER["DOCUMENT_ROOT"] . '/media/images/website/no-image.png';
            $noImageTime = @filemtime($noImagePath);

            $cacheTime = @filemtime($_SERVER["DOCUMENT_ROOT"] . $cachedPath);



            if (preg_match('/https?:\/\//', $params['src'])) {

                if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath)) {

                    if (getImageSize($params['src'])) {

                        $imageTime = @filemtime(remoteFileData2($params['src']));

                        if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath) || $imageTime > $cacheTime) {

                            $thumbImg = str_replace(' ', '%20', $params['src']);

                        }

                    } else {

                        if (!is_file($noImagePath) || $noImageTime > $cacheTime) {

                            $thumbImg = $noImagePath;

                        }

                    }

                }

            } else {

                if (file_exists($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc'])) {

                    $imageTime = @filemtime($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);

                    if (!is_file($_SERVER["DOCUMENT_ROOT"] . $cachedPath) || $imageTime > $cacheTime) {

                            // read EXIF header from uploaded file
                        $exif = exif_read_data($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);

                        //fix the Orientation if EXIF data exist
                        if(!empty($exif['Orientation'])) {
                            $source = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);
                            switch($exif['Orientation']) {
                                case 8:
                                     $rotate = imagerotate($source,90,0);
                                    break;
                                case 3:
                                     $rotate = imagerotate($source,180,0);
                                    break;
                                case 6:
                                     $rotate = imagerotate($source,-90,0);
                                    break;
                            }
                            if ($rotate != '') {
                                imagejpeg($rotate,$_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc']);
                            }
                        }

                        $thumbImg = $_SERVER["DOCUMENT_ROOT"] . $paths['fileSrc'];

                    }

                } else {

                    if (!is_file($noImagePath) || $noImageTime > $cacheTime) {

                        $thumbImg = $noImagePath;

                    }

                }

            }

            if ($thumbImg != '') {

                $thumb = PhpThumbFactory::create($thumbImg, array('jpegQuality'=>70));
                $thumb->adaptiveResize($params['width'], $params['height']);

                if (!preg_match('/no-image/', $params['src']) && $actWatermark == 1 || ($actWatermark == 2 && $params['watermark'] == 1) ) {
                    $watermark = PhpThumbFactory::create($_SERVER["DOCUMENT_ROOT"] . '/media/images/website/watermark.png', array('jpegQuality'=>70));
                    $thumb->addWatermark($watermark, 'center', 50, 0, 0);
                }

                $thumb->save($_SERVER["DOCUMENT_ROOT"] . $cachedPath);

            }

            return $cachedPath;



    }


    // Make sure they passed a source file
    if (!$params['src']) return '<!-- Imagesizer Error: You must specify a source image -->';

    // Get various paths and urls for the image
    if (!$paths = getImagePath2($params['src'], $smarty)) return false;

    // Make sure it's a file-type we can deal with
    if (!in_array(strtolower($paths['fileExt']), array('gif','jpeg','jpg','png'))) return '<!-- Imagesizer Error: Invalid file type -->';

    // Calculate the final dimensions
    $width = $params['width'];
    $height = $params['height'];

        // echo "<hr>";
        // print_r($paths);
        // echo "<hr>";

    // Do the actual resizing and cache the result
    if (!$finalImage = resizeAndCache2($paths, $params)) return '<!-- Imagesizer Error: Could not resize the image -->';

    $alt = 'img'; if(isset($params['alt'])) $alt = $params['alt'];
    // Build the options for the img tag
    $opts = 'alt="'.$alt.'"';
    $opts .= ( isset($params['class']) ) ? ' class="'.$params['class'].'"' : '';
    $opts .= ( isset($params['id']) ) ? ' id="'.$params['id'].'"' : '';
    $opts .= ( isset($params['title']) ) ? ' title="'.$params['title'].'"' : '';
    $opts .= ( isset($params['style']) ) ? ' style="'.$params['style'].'"' : '';

    // Output the tag
    return $finalImage;
}


// Figure out various urls and paths that we will need later on
function getImagePath2($fileUrl, $smarty)
{
    // Store the image url
    $paths['fileUrl'] = $fileUrl;

    // The name of the file: image.jpg
    $paths['fileName'] = basename($fileUrl);

    // The paths to the document we are working with
    $scriptName = '/' . $_SERVER['SCRIPT_NAME'];
    $paths['docPath'] = removeFileFromPath2(removeDoubleSlashes2(str_replace($_SERVER['QUERY_STRING'],'',str_replace($_SERVER['SCRIPT_NAME'],'',$_SERVER['SCRIPT_FILENAME']) . '' . $_SERVER['REQUEST_URI'])));
    $paths['docPath'] = $_SERVER["DOCUMENT_ROOT"] . '' . $paths['fileUrl'];



    // The relative path to the document
    $docUri = ($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : dirname($_SERVER['SCRIPT_NAME']);
    $docUri = removeDoubleSlashes2('/' . $docUri . '/');
    // If we've got an absolute image url...make it relative!
    $fileUri = str_replace('http://'.$_SERVER['HTTP_HOST'], '', $fileUrl);
    $fileUri = str_replace('https://'.$_SERVER['HTTP_HOST'], '', $fileUri);
    if (substr($fileUri, 0, 1) == DIRECTORY_SEPARATOR)
    {
        $docSegments = explode(DIRECTORY_SEPARATOR, $docUri);
        $fileSegments = explode(DIRECTORY_SEPARATOR, $fileUri);

        // Cycle through the url segments, working back from the current url to the image url
        while ( count($docSegments) || count($fileSegments) )
        {
            $docSegment = array_shift($docSegments);
            $fileSegment = array_shift($fileSegments);

            if ( ($docSegment != $fileSegment) || $up) {
              // $up = ($docSegment) ? '/' : '';
              $up = '';
              $relativeUri = $up . $relativeUri . $fileSegment . '/';
            }
        }

        $fileUrl = rtrim($relativeUri,'/');
    }

// [fileUrl] => /media/images/news/p17k6g0v6sqi86t82h81cre1ohqa.jpg
// [fileName] => p17k6g0v6sqi86t82h81cre1ohqa.jpg
// [docPath] => /Volumes/Datos/Websites/lidonworldtravel/public_html/noticias/
// [filePath] => /Volumes/Datos/Websites/lidonworldtravel/public_html/media/images/news
// [fileExt] => jpg [fileBasename] => p17k6g0v6sqi86t82h81cre1ohqa
// [fileSrc] => /Volumes/Datos/Websites/lidonworldtravel/public_html/media/images/news/p17k6g0v6sqi86t82h81cre1ohqa.jpg
// [cachePath] => /Volumes/Datos/Websites/lidonworldtravel/public_html/media/images/news/thumbnails/ [cacheUrl] => /media/images/news/thumbnails/ )

    // Get the actual path to the file on the server
    $filePath = $_SERVER["DOCUMENT_ROOT"] .  '/' . $fileUrl;

   // Make sure there is actually an image at that path
    if (!is_readable($filePath))
    {
      echo "<!-- <hr>Imagesizer Error: Could not find the file {$filePath} -->";
      return false;
    }

    // Calculate all the other paths we will need
    $pathInfo = pathinfo($filePath);
    $paths['filePath'] = $pathInfo['dirname'];
    $paths['fileExt'] = $pathInfo['extension'];
    $paths['fileBasename'] = $pathInfo['filename'] ? $pathInfo['filename'] : substr($paths['fileName'],0,strrpos($paths['fileName'],'.'));
    $paths['fileSrc'] = removeDoubleSlashes2($paths['filePath'] . '/' . $paths['fileName']);
    $paths['cachePath'] = removeDoubleSlashes2($paths['filePath'] . '/thumbnails/');

    // Make sure the cache folder exists
    if(!is_dir($paths['cachePath']))
    {
        // Try to create it
            if (!@mkdir($paths['cachePath'], 0777))
            {
              echo "<!-- Imagesizer Error: Could not create cache directory. Please create {$paths['cachePath']} manually and try again. -->";
              return false;
            }

            // Make sure it's really writable
            if (!is_writable($paths['cachePath']))
            {
              echo '<!-- Imagesizer Error: The cache directory is not writeable -->';
              return false;
            }
    }

    // The url to the cached image
    $paths['cacheUrl'] = removeDoubleSlashes2('/' . get_absolute_path2($docUri . '/' . dirname($fileUrl)));

    $paths['cacheUrl'] = '/'.get_absolute_path2( str_replace($paths['fileBasename'].'.'.$paths['fileExt'],'', $fileUrl) ) . '/thumbnails/';

    return $paths;
}


// Figure out what the final size of the image should be,
// based on the inputs from the user
function getNewSize2($params, $paths)
{
    // Get the size and ratio of the original image
    list($oldWidth, $oldHeight) = getimagesize($paths['fileSrc']);

    // Store the target dimensions for convenience
    $width = $params['width'];
    $height = $params['height'];

    // Figure out what to do based on the new and old sizes
    if (($oldWidth <= $width) && ($oldHeight <= $height) || (!$width && !$height))
    {
        // The image is already smaller than the requested sizes
        $newWidth = $oldWidth;
        $newHeight = $oldHeight;
    }
    elseif ($width && !$height)
    {
        // Resize based on the width
        if ($width > $oldWidth) $width = $oldWidth;
        $newWidth = $width;
        $newHeight = floor( $oldHeight * ($width / $oldWidth) );
    }
    elseif ($height && !$width)
    {
        // Resize based on the height
        if ($height > $oldHeight) $height = $oldHeight;
        $newHeight = $height;
        $newWidth = floor( $oldWidth * ($height / $oldHeight) );
    }
    else
    {
        // If they specified both, we need to decide whether to crop it
        if ($params['crop'])
        {
            // Crop it to the exact dimensions
            $newWidth = ($width > $oldWidth) ? $oldWidth : $width;
            $newHeight = ($height > $oldHeight) ? $oldHeight : $height;
            $crop = true;
        }
        else
        {
            // Resize to fit within the box

            // First based on the width
            if ($width > $oldWidth) $width = $oldWidth;
            $newWidth = $width;
            $newHeight = floor( $oldHeight * ($width / $oldWidth) );

            // Then based on height
            if ($newHeight > $height)
            {
                $newWidth = floor( $newWidth * ($height / $newHeight) );
                $newHeight = $height;
            }
        }
    }

    return array($newWidth, $newHeight, $crop);
}


// Actually resize the image and save it to the
// cache folder. Return the new filename.
function resizeAndCache2($paths, $params)
{
    global $actWatermark;
    // Target dimensions
    $width = $params['width'];
    $height = $params['height'];

    // Original dimensions
    list($oldWidth, $oldHeight, $imgType) = getimagesize($paths['fileSrc']);

    // Don't resize if we don't need to
    // if ( ($width >= $oldWidth) && ($height >= $oldHeight) && !$params['bw'] && !$params['radius'] && !($actWatermark == 2 && $params['watermark'] != '')) return $paths['fileUrl'];

    // Create a name and path for the cached file
    if (($actWatermark == 1 && $width > 100) || ($actWatermark == 2 && $params['watermark'] == 1)) {
        $cachedName = $paths['fileBasename'] . '_w_' . $width . 'x' . $height;
    } else {
       if ( ($width >= $oldWidth) && ($height >= $oldHeight) && !isset($params['bw']) && !isset($params['radius']) ) return $paths['fileUrl'];
        $cachedName = $paths['fileBasename'] . '_' . $width . 'x' . $height;
    }
    $cachedName .= '.' . $paths['fileExt'];
    $cachedPath = $paths['cachePath'] . $cachedName;
    $cachedUrl = $paths['cacheUrl'] . $cachedName;

    // Unless there's already a cached version, create one
    $imageTime = @filemtime($paths['fileSrc']);
    $cacheTime = @filemtime($cachedPath);

    if (!is_file($cachedPath) || $imageTime > $cacheTime ) {

        $thumb = PhpThumbFactory::create($paths['fileSrc'], array('jpegQuality'=>70));
        $thumb->adaptiveResize($width, $height);

        if ( ($actWatermark == 1 || ($actWatermark == 2 && $params['watermark'] == 1)) && $width > 100) {
            $watermark = PhpThumbFactory::create($_SERVER["DOCUMENT_ROOT"] . '/media/images/website/watermark.png', array('jpegQuality'=>70));
            $thumb->addWatermark($watermark, 'center', 50, 0, 0);
        }

        $thumb->save($cachedPath);

    }

    return $cachedUrl;
}


// Just like it says on the box
function removeDoubleSlashes2($str)
{
    return str_replace(array('//', '\\', '\\\\'), '/', $str);
}


// Removes any .php file from the end of a path
function removeFileFromPath2($path)
{
    $segments = explode(DIRECTORY_SEPARATOR, $path);
    $lastSegment = end($segments);

    if (strpos($lastSegment, '.php'))
    {
        array_pop($segments);
    }

    return implode('/', $segments);
}


// Resolves /../ in paths. From the PHP docs.
function get_absolute_path2($path) {
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    return implode('/', $absolutes);
}


?>