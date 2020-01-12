<?php
namespace src;

use Intervention\Image\Gd\Font;
use Intervention\Image\ImageManagerStatic as Image;

class ChangeImage
{
    protected static $imagePatch;

    public function imageAction($nameFile)
    {
        self::$imagePatch = $_SERVER["DOCUMENT_ROOT"] . "/images/";

        $file = self::$imagePatch . $nameFile;
        $result = self::$imagePatch . "new_" . $nameFile;

        $image = Image::make($file)
            ->rotate(45)
            ->resize(200, null, function ($image) {
                $image->aspectRatio();
            })
            ->save($result, 80);

        self::watermark($image);

        return $image->response("png");
    }

    public static function watermark(\Intervention\Image\Image $image)
    {
        $image->text(
            "loftschool",
            $image->width() / 2,
            $image->height() / 1.5,
            function (Font $font) {
                $font->file(self::$imagePatch . "arial.ttf")->size("14");
                $font->color('#1e2a36');
                $font->align("right");
                $font->valign("center");
            }
        );
    }
}
