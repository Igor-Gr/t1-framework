<?php

namespace Elision\Web;


use Elision\Core\Config;

class Images
{

    /**
     * Принимает директорию в которую хотим сохранить изображение
     * вида './files/имя ихображения', сохранит изображение в папку files
     * (принимаемое значение обязательно должно идти от корня сайта ./)
     * Вторым не обязательным параметром принимает false если передано то,
     * вернет путь к изображению относительно корня сайта (./), есле не передано
     * то вернёт  абсолютный путь ('http://site/...')
     *
     * Сохраняет изображение в узазаной директории
     *
     * Возвращает путь к сохраненой картинке. (это и есть эта картинка)
     *
     * @param string $uploadDir
     * @return bool|string|void
     */
    public static function uploadImage($uploadDir, $bool = null)
    {
        $files = $_FILES;
        if (empty($_FILES['image']['name'])) return;
        
        $file = $files['image']['name'];
        $uploadFile = $uploadDir . $file;

        if (move_uploaded_file($files['image']['tmp_name'], $uploadFile)) {
            if ($bool === false) {
                return $uploadFile;
            } else {
                return Config::getConfig()->url . substr($uploadFile, 2);
            }
        }
        return false;

    }

    /**
     * Принимает путь к изменяемому изображению, имя изменённого изображения,
     * желаемую ширину, высоты, и не обязательный параметр булево значения по умочанию true,
     * это значет что изображения измениться с сохранением пропрций, если передать false,
     * то сохранения пропорция не будет высота и ширина станут ровно такими какие вы указали
     * 
     * Изменет размеры изображения
     * 
     * @param string $filename
     * @param string $newImgName
     * @param integer $w
     * @param integer $h
     * @param bool $bool
     * @return bool
     */
    public static function resizeImg($filename, $newImgName, $w, $h, $bool = true)
    {
        // Имя файла с масштабируемым изображением
        $filename = $filename;
        // Имя файла с уменьшенной копией.
        $newImgName = $newImgName;
        // определим коэффициент сжатия изображения, которое будем генерить
        $ratio = $w/$h;
        // получим размеры исходного изображения
        $size_img = getimagesize($filename);
        // получим коэффициент сжатия исходного изображения
        $src_ratio=$size_img[0]/$size_img[1];

        // узнаем формат изображения (png, jpg и т.д.)
        $format = substr($size_img['mime'], strpos($size_img['mime'], "/") + 1);
        // создаем переменную для функции всех форматов
        $icfunc = 'imagecreatefrom'.$format;

        if ($bool === true) {
            // Здесь вычисляем размеры уменьшенной копии, чтобы при масштабировании сохранились
            // пропорции исходного изображения
            if ($ratio<$src_ratio)
            {
                $h = $w/$src_ratio;
            }
            else
            {
                $w = $h*$src_ratio;
            }
        }
        
        // создадим пустое изображение по заданным размерам
        $dest_img = imagecreatetruecolor($w, $h);
        // создаем создаем изображение из файла
        $src_img = $icfunc($filename);

        // масштабируем изображение     функцией imagecopyresampled()
        // $dest_img - уменьшенная копия
        // $src_img - исходной изображение
        // $w - ширина уменьшенной копии
        // $h - высота уменьшенной копии
        // $size_img[0] - ширина исходного изображения
        // $size_img[1] - высота исходного изображения
        imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);
        // сохраняем уменьшенную копию в файл


        imagejpeg($dest_img, $newImgName);
        // чистим память от созданных изображений
        imagedestroy($dest_img);
        imagedestroy($src_img);
        return true;
    }

    /**
     * Принимает изображение на которое хотим приклеять(путь к нему), изображение которое прклеиваем(или часть которого приклеиваем),
     * имя получаемого в итоге изображения, координата Х и координата Y на которые помещаеться копируемое изображение,
     * координата Х и координата Y копируемого изображения с которых берем копируемую часть и высота и ширина копируемой части
     * 
     * Склеивает два изображения в одно (накладыват одно изображение на другое)
     *
     * @param $img
     * @param $joinedImg
     * @param $newImageName
     * @param $img_x
     * @param $img_y
     * @param $joinedImg_x
     * @param $joinedImg_y
     * @param $joinedImg_w
     * @param $joinedImg_h
     * @return bool
     */
    public static function joinImg($img, $joinedImg, $newImageName, $img_x, $img_y, $joinedImg_x, $joinedImg_y, $joinedImg_w, $joinedImg_h)
    {
        // получим размеры исходного изображения 
        $size_img = getimagesize($img);
        // узнаем формат изображения (png, jpg и т.д.)
        $format = substr($size_img['mime'], strpos($size_img['mime'], "/") + 1);
        // создаем переменную для функции всех форматов
        $icfunc = 'imagecreatefrom'.$format;
        
        $dst_img = $icfunc($img);
        // сделать универсальным
        $src_img = imagecreatefromjpeg($joinedImg);

        // настройка прозрачности и фильтров
        imagealphablending($dst_img, false);
        imagesavealpha($dst_img, true);

        imagecopymerge($dst_img, $src_img, $img_x, $img_y, $joinedImg_x, $joinedImg_y, $joinedImg_w, $joinedImg_h, 100);
        
        imagejpeg($dst_img, $newImageName);
        // чистим память от созданных изображений
        imagedestroy($dst_img);
        imagedestroy($src_img);

        return true;
    }
}