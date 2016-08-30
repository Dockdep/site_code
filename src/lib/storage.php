<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace 
{
    /**
     * storage
     *
     * @author      Jane Bezmaternykh
     * @version     1.0.20131017
     */
    class storage
    {
        /////////////////////////////////////////////////////////////////////////////

        protected       $default_storage_id     = 1;

        /////////////////////////////////////////////////////////////////////////////
        
        /**
         * storage::mkdir()
         *
         * @author      Jane Bezmaternykh
         * @version     1.0.20131017
         *
         * @param     string      $type
         * @param     string      $filename
         * @return    boolean      
         */
        public function mkdir( $type, $filename )
        {
            // TODO: chmod 777 for all dirs
            mkdir( STORAGE_PATH.$type.'/'.substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.$filename, 0777, true );

            return true;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * storage::imageAutoRotate()
         *
         * @author      Jane Bezmaternykh
         * @version     1.0.20131017
         *
         * @param     string      $filepath
         * @return    boolean
         */
        public function imageAutoRotate( $filepath )
        {
            system( '/usr/bin/convert -auto-orient '.$filepath.' '.$filepath );

            return true;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * storage::getPhotoPath()
         *
         * @author      Jane Bezmaternykh
         * @version     1.0.20131017
         *
         * @param     string      $type
         * @param     string      $filename
         * @param     string      $name
         * @return    string
         */
        public function getPhotoPath( $type, $filename, $name = 'group' )
        {
            return STORAGE_PATH.$type.'/'.substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.$filename.'/'.$name.'.jpg';
        }

        public function getPricePath( $type, $filename, $name)
        {
            return STORAGE_PATH.$type.'/'.substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.$filename.'/'.$name.'.xls';
        }


        public function getEmailTemplatePath( $type, $filename)
        {
            return STORAGE_PATH.$type.'/'.substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.$filename.'/';
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * storage::getPhotoURL()
         *
         * @author      Jane Bezmaternykh
         * @version     1.0.20131017
         *
         * @param     string      $filename
         * @param     string      $type
         * @param     string      $name
         * @return    string
         */
        public function getPhotoURL( $filename, $type, $name = 'group' )
        {
            return
                \config::get('global#domains/storage/').
                $type.'/'.
                substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.
                $filename.'/'.$name.'.jpg';
        }

        public function getPhotoURLDev( $filename, $type, $name = 'group' )
        {
            return
                \config::get('global#domains/devstorage/').
                $type.'/'.
                substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.
                $filename.'/'.$name.'.jpg';
        }

        public function getPriceURLDev( $filename, $type, $name = 'group' )
        {
            return
                \config::get('global#domains/devstorage/').
                $type.'/'.
                substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.
                $filename.'/'.$name.'.xls';
        }

        public function getPriceURL( $filename, $type, $name = 'group' )
        {
            return
                \config::get('global#domains/storage/').
                $type.'/'.
                substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.
                $filename.'/'.$name.'.xls';
        }

        public function getOrderBlank() {
            return \config::get('global#domains/storage/')
            . \config::get('global#storage/order_blank/');
        }

        public function getEmailTemplateURL( $type, $filename )
        {
            return
                \config::get('global#domains/storage/').
                $type.'/'.
                substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.
                $filename.'/';
        }

        public function getBanerURL( $filename )
        {
            return
                \config::get('global#domains/storage/')."cat/".$filename;

        }



        /**
         * storage::imageResizeWithCrop()
         *
         * @author      Jane Bezmaternykh
         * @version     1.0.20131115
         *
         * @param     array       $params
         * @param     string      $filename
         * @param     string      $type
         * @return    boolean
         */
        public function imageResizeWithCrop( $params, $filename, $type = 'group' )
        {
            if( empty( $params ) )
            {
                $filepath_origin  = $this->getPhotoPath( $type, $filename, 'original' );

                if( !file_exists( $filepath_origin ) )
                {
                    return false;
                }

                foreach( \config::get('global#storage/'.$type) as $image_name => $size )
                {
                    if( substr( $image_name, -1 ) == 'x' )
                    {
                        system( '/usr/bin/convert '.$filepath_origin.' -resize '.$size['width'].'x'.$size['height'].' '.$this->getPhotoPath( $type, $filename, $image_name ) );
                    }
                    else
                    {
                        // -gravity Center
                        system( '/usr/bin/convert '.$filepath_origin.' -resize '.$size['width'].'^x'.$size['height'].' -gravity Center -crop '.$size['width'].'x'.$size['height'].'+0+0 '.$this->getPhotoPath( $type, $filename, $image_name ) );
                    }
                }
            }
            else
            {
                $filepath_origin  = $this->getImagePath( $filename, $params['type'], $params['original'] );

                $width            = $params['coords']['x2'] - $params['coords']['x1'];
                $height           = $params['coords']['y2'] - $params['coords']['y1'];

                if( !file_exists($filepath_origin) )
                {
                    return false;
                }

                system( '/usr/bin/convert '.$filepath_origin.' -crop '.$width*$params['k'].'x'.$height*$params['k'].'+'.$params['coords']['x1']*$params['k'].'+'.$params['coords']['y1']*$params['k'].' +repage -resize '.$params['width'].'x'.$params['height'].' '.$this->getImagePath( $filename, $params['type'], $params['width'].'x'.$params['height'] ) );
            }
            return true;
        }


        public function imageCut($file, $type = 'dealers', $size = 160) {

            $filepath = $this->getPhotoPath( $type, $file, 'original' );
            $newfilepath = $this->getPhotoPath( $type, $file, $size . 'x' );
            list($orig_width, $orig_height) = getimagesize($filepath);
            $width = $orig_width;
            $height = $orig_height;

            if($width > $height) {
                $y = 0;
                $x = ($width - $height) / 2;
                $smallestSide = $height;
            } else {
                $x = 0;
                $y = ($height - $width) / 2;
                $smallestSide = $width;
            }

            if($width != $size && $height != $size) {

                $image_p = imagecreatetruecolor($size, $size);
                $image = imagecreatefromjpeg($filepath);
                imagecopyresampled($image_p, $image, 0, 0, $x, $y,
                    $size, $size, $smallestSide, $smallestSide);
                imagejpeg($image_p, $newfilepath);

            } else {
                copy($filepath, $newfilepath);
            }

        }
        /////////////////////////////////////////////////////////////////////////////

        /**
         * storage::getFilePath()
         *
         * @author      Andrey Starchenko
         * @version     1.0.1
         *
         * @param     string      $filename
         * @param     string      $folder
         * @param     string      $format
         * @return    string
         */
        public function getFilePath( $filename, $folder, $format = "mp4" )
        {
            return STORAGE_PATH.$folder.'/'.substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.
                        substr($filename, 3, 1).'/'.$filename.'/original.'.$format;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * storage::getFileURL()
         *
         * @author      Andrey Starchenko
         * @version     1.0.1
         *
         * @param     string      $filename
         * @param     string      $folder
         * @param     string      $format
         * @return    string
         */
        public function getFileURL( $filename, $folder, $format = "mp4" )
        {
            return
                \config::get('global#domains/storage/'.$this->default_storage_id).
                $folder.'/'.substr($filename, 0, 1).'/'.substr($filename, 1, 1).'/'.substr($filename, 2, 1).'/'.substr($filename, 3, 1).'/'.
                $filename.'/original.'.$format;
        }

        /////////////////////////////////////////////////////////////////////////////

            /**
            * storage::getVideoThumbnail()
            *
            * @author      Andrey Starchenko
            * @version     1.0.1
            *
            * @param     string      $filename
            * @param     string      $folder
            * @param     string      $size
            * @param     array       $format
            * @return    string
            */
           public function createVideoThumbnail( $filename, $folder, $format = array("mp4", "jpg"), $size = "320*240" )
	        {
                if ( !empty($filename) )
                    {

                   $filepath_vid = $this->getFilePath($filename, $folder, $format[0]);
                    $filepath_img   = $this->getFilePath($filename, $folder, $format[1]);

                   system("ffmpeg -i ".$filepath_vid." -y -f image2 -ss 5 -sameq -t 0.001 -s ".$size." ".$filepath_img,$rerturn);
                   return true;

                    } else {

                  return false;

                }
           }


        /////////////////////////////////////////////////////////////////////////////
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
