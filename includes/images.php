<?php
/**
 * Bild-Optimierung mit GD-Library.
 */

define('MAX_WIDTH', 1200);
define('THUMB_WIDTH', 400);
define('JPEG_QUALITY', 82);

function optimiere_bild(array $upload_datei, string $dateiname): string {
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    $tmp = $upload_datei['tmp_name'];
    $img = bild_laden($tmp);
    if (!$img) {
        return '';
    }

    // EXIF-Rotation korrigieren (nur bei JPEG)
    $img = exif_korrigieren($tmp, $img);

    // Hauptbild: max MAX_WIDTH breit
    $img = bild_skalieren($img, MAX_WIDTH);

    // Speichern als optimiertes JPEG
    $name = pathinfo($dateiname, PATHINFO_FILENAME);
    $optimierter_name = $name . '.jpg';
    $pfad = UPLOAD_DIR . '/' . $optimierter_name;
    imagejpeg($img, $pfad, JPEG_QUALITY);

    // Thumbnail erstellen
    $thumb = bild_skalieren($img, THUMB_WIDTH);
    $thumb_pfad = UPLOAD_DIR . '/' . $name . '_thumb.jpg';
    imagejpeg($thumb, $thumb_pfad, 75);

    imagedestroy($img);
    imagedestroy($thumb);

    return $optimierter_name;
}

function optimiere_bestehende_bilder(): void {
    if (!is_dir(IMAGE_DIR)) {
        return;
    }
    foreach (scandir(IMAGE_DIR) as $datei) {
        $ext = strtolower(pathinfo($datei, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            continue;
        }
        $name = pathinfo($datei, PATHINFO_FILENAME);
        $thumb_pfad = IMAGE_DIR . '/' . $name . '_thumb.jpg';
        if (file_exists($thumb_pfad)) {
            continue;
        }
        $img = bild_laden(IMAGE_DIR . '/' . $datei);
        if (!$img) {
            continue;
        }
        $img = exif_korrigieren(IMAGE_DIR . '/' . $datei, $img);
        $img = bild_skalieren($img, THUMB_WIDTH);
        imagejpeg($img, $thumb_pfad, 75);
        imagedestroy($img);
    }
}

function bild_laden(string $pfad) {
    $info = @getimagesize($pfad);
    if (!$info) {
        return false;
    }
    switch ($info[2]) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($pfad);
        case IMAGETYPE_PNG:
            $img = imagecreatefrompng($pfad);
            // PNG: Transparenz in weiss umwandeln
            $rgb = imagecreatetruecolor(imagesx($img), imagesy($img));
            imagefill($rgb, 0, 0, imagecolorallocate($rgb, 255, 255, 255));
            imagecopy($rgb, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
            imagedestroy($img);
            return $rgb;
        default:
            return false;
    }
}

function exif_korrigieren(string $pfad, $img) {
    if (!function_exists('exif_read_data')) {
        return $img;
    }
    $ext = strtolower(pathinfo($pfad, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg'])) {
        return $img;
    }
    $exif = @exif_read_data($pfad);
    if (!$exif || empty($exif['Orientation'])) {
        return $img;
    }
    switch ($exif['Orientation']) {
        case 3:
            return imagerotate($img, 180, 0);
        case 6:
            return imagerotate($img, -90, 0);
        case 8:
            return imagerotate($img, 90, 0);
        default:
            return $img;
    }
}

function bild_skalieren($img, int $max_breite) {
    $breite = imagesx($img);
    $hoehe = imagesy($img);
    if ($breite <= $max_breite) {
        // Kopie erstellen statt Referenz
        $kopie = imagecreatetruecolor($breite, $hoehe);
        imagecopy($kopie, $img, 0, 0, 0, 0, $breite, $hoehe);
        return $kopie;
    }
    $neue_breite = $max_breite;
    $neue_hoehe = intval($hoehe * ($max_breite / $breite));
    $neu = imagecreatetruecolor($neue_breite, $neue_hoehe);
    imagecopyresampled($neu, $img, 0, 0, 0, 0, $neue_breite, $neue_hoehe, $breite, $hoehe);
    return $neu;
}
