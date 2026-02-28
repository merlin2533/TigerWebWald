<?php
/**
 * EntenbachTigeR - Admin-Bereich.
 */

error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/images.php';

// Datenbank automatisch erstellen falls Tabellen fehlen
db_auto_init();

$aktion = $_GET['aktion'] ?? 'dashboard';

// Login braucht keine Auth-Pruefung
if ($aktion === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $benutzer = $_POST['benutzername'] ?? '';
        $passwort = $_POST['passwort'] ?? '';

        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM admin WHERE benutzername = ?');
        $stmt->execute([$benutzer]);
        $admin = $stmt->fetch();

        if ($admin && passwort_verifizieren($passwort, $admin['passwort_hash'], $admin['id'])) {
            $_SESSION['admin_eingeloggt'] = true;
            flash('Erfolgreich eingeloggt!', 'erfolg');
            header('Location: /admin');
            exit;
        } else {
            flash('Falscher Benutzername oder Passwort.', 'fehler');
        }
    }
    require __DIR__ . '/templates/admin/login.php';
    exit;
}

// Logout
if ($aktion === 'logout') {
    unset($_SESSION['admin_eingeloggt']);
    flash('Abgemeldet.', 'info');
    header('Location: /');
    exit;
}

// Ab hier: Auth erforderlich
admin_erforderlich();

switch ($aktion) {
    case 'dashboard':
        $db = get_db();
        $seiten = $db->query('SELECT DISTINCT seite FROM inhalte ORDER BY seite')->fetchAll();
        $team = get_team();
        require __DIR__ . '/templates/admin/dashboard.php';
        break;

    case 'inhalte':
        $seite = $_GET['seite'] ?? '';
        $db = get_db();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_pruefen()) {
                flash('Ungültige Anfrage.', 'fehler');
            } else {
                foreach ($_POST as $schluessel => $wert) {
                    if ($schluessel === 'csrf_token') continue;
                    $stmt = $db->prepare('UPDATE inhalte SET wert = ? WHERE seite = ? AND schluessel = ?');
                    $stmt->execute([$wert, $seite, $schluessel]);
                }
                flash("Inhalte für '$seite' gespeichert!", 'erfolg');
            }
        }

        $stmt = $db->prepare('SELECT * FROM inhalte WHERE seite = ? ORDER BY id');
        $stmt->execute([$seite]);
        $inhalte = $stmt->fetchAll();
        require __DIR__ . '/templates/admin/inhalte.php';
        break;

    case 'bilder':
        $seite = $_GET['seite'] ?? '';
        $db = get_db();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_pruefen()) {
                flash('Ungültige Anfrage.', 'fehler');
            } else {
                $schluessel = $_POST['schluessel'] ?? '';
                $alt_text = $_POST['alt_text'] ?? '';

                if (!empty($_FILES['bild']['name'])) {
                    $dateiname = optimiere_bild($_FILES['bild'], $_FILES['bild']['name']);
                    if ($dateiname) {
                        $stmt = $db->prepare('INSERT INTO bilder (seite, schluessel, dateiname, alt_text, reihenfolge) VALUES (?, ?, ?, ?, ?)');
                        $stmt->execute([$seite, $schluessel, $dateiname, $alt_text, 99]);
                        flash("Bild '$dateiname' hochgeladen und optimiert!", 'erfolg');
                    }
                }
            }
        }

        $stmt = $db->prepare('SELECT * FROM bilder WHERE seite = ? ORDER BY schluessel, reihenfolge');
        $stmt->execute([$seite]);
        $bilder = $stmt->fetchAll();
        require __DIR__ . '/templates/admin/bilder.php';
        break;

    case 'bild_loeschen':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_pruefen()) {
                flash('Ungültige Anfrage.', 'fehler');
                header('Location: /admin');
                exit;
            }
            $bild_id = intval($_GET['bild_id'] ?? 0);
            $db = get_db();
            $stmt = $db->prepare('SELECT * FROM bilder WHERE id = ?');
            $stmt->execute([$bild_id]);
            $bild = $stmt->fetch();

            if ($bild) {
                $seite = $bild['seite'];
                $stmt = $db->prepare('DELETE FROM bilder WHERE id = ?');
                $stmt->execute([$bild_id]);
                flash('Bild gelöscht.', 'info');
            } else {
                $seite = 'raeumlichkeiten';
            }
            header('Location: /admin/bilder/' . $seite);
            exit;
        }
        break;

    case 'team':
        $db = get_db();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_pruefen()) {
                flash('Ungültige Anfrage.', 'fehler');
            } else {
            $post_aktion = $_POST['aktion'] ?? '';

            if ($post_aktion === 'aktualisieren') {
                foreach ($_POST as $key => $val) {
                    if (strpos($key, 'name_') === 0) {
                        $mid = substr($key, 5);
                        $stmt = $db->prepare('UPDATE team SET name=?, rolle=?, beschreibung=? WHERE id=?');
                        $stmt->execute([
                            $_POST["name_$mid"] ?? '',
                            $_POST["rolle_$mid"] ?? '',
                            $_POST["beschreibung_$mid"] ?? '',
                            $mid,
                        ]);
                    }
                }
                flash('Team aktualisiert!', 'erfolg');
            } elseif ($post_aktion === 'bild_hochladen') {
                $mid = $_POST['mitglied_id'] ?? '';
                if (!empty($_FILES['bild']['name'])) {
                    $dateiname = optimiere_bild($_FILES['bild'], "team_{$mid}_{$_FILES['bild']['name']}");
                    if ($dateiname) {
                        $stmt = $db->prepare('UPDATE team SET bild = ? WHERE id = ?');
                        $stmt->execute([$dateiname, $mid]);
                        flash('Teambild aktualisiert!', 'erfolg');
                    }
                }
            }
            }
        }

        $team = $db->query('SELECT * FROM team ORDER BY reihenfolge')->fetchAll();
        require __DIR__ . '/templates/admin/team.php';
        break;

    case 'alben':
        $seite = $_GET['seite'] ?? '';
        $db = get_db();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_pruefen()) {
                flash('Ungültige Anfrage.', 'fehler');
            } else {
                $post_aktion = $_POST['aktion'] ?? '';

                if ($post_aktion === 'hinzufuegen') {
                    $schluessel = preg_replace('/[^a-z0-9_]/', '', strtolower($_POST['schluessel'] ?? ''));
                    $name = $_POST['name'] ?? '';
                    $beschreibung = $_POST['beschreibung'] ?? '';
                    $reihenfolge = intval($_POST['reihenfolge'] ?? 99);

                    if ($schluessel && $name) {
                        $stmt = $db->prepare('INSERT OR IGNORE INTO alben (seite, schluessel, name, beschreibung, reihenfolge) VALUES (?, ?, ?, ?, ?)');
                        $stmt->execute([$seite, $schluessel, $name, $beschreibung, $reihenfolge]);
                        flash("Album '$name' hinzugefügt!", 'erfolg');
                    }
                } elseif ($post_aktion === 'aktualisieren') {
                    foreach ($_POST as $key => $val) {
                        if (strpos($key, 'name_') === 0) {
                            $aid = substr($key, 5);
                            $stmt = $db->prepare('UPDATE alben SET name=?, beschreibung=?, reihenfolge=? WHERE id=?');
                            $stmt->execute([
                                $_POST["name_$aid"] ?? '',
                                $_POST["beschreibung_$aid"] ?? '',
                                intval($_POST["reihenfolge_$aid"] ?? 0),
                                $aid,
                            ]);
                        }
                    }
                    flash('Alben aktualisiert!', 'erfolg');
                } elseif ($post_aktion === 'loeschen') {
                    $album_id = intval($_POST['album_id'] ?? 0);
                    if ($album_id) {
                        $stmt = $db->prepare('DELETE FROM alben WHERE id = ?');
                        $stmt->execute([$album_id]);
                        flash('Album gelöscht.', 'info');
                    }
                }
            }
        }

        $alben = get_alben($seite);
        require __DIR__ . '/templates/admin/alben.php';
        break;

    case 'passwort':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_pruefen()) {
                flash('Ungültige Anfrage.', 'fehler');
            } else {
                $altes_pw = $_POST['altes_passwort'] ?? '';
                $neues_pw = $_POST['neues_passwort'] ?? '';

                $db = get_db();
                $stmt = $db->prepare('SELECT * FROM admin LIMIT 1');
                $admin = $stmt->fetch();

                if ($admin && passwort_verifizieren($altes_pw, $admin['passwort_hash'], $admin['id']) && $neues_pw) {
                    $neues_hash = password_hash($neues_pw, PASSWORD_DEFAULT);
                    $stmt = $db->prepare('UPDATE admin SET passwort_hash = ? WHERE id = ?');
                    $stmt->execute([$neues_hash, $admin['id']]);
                    flash('Passwort geändert!', 'erfolg');
                } else {
                    flash('Altes Passwort falsch.', 'fehler');
                }
            }
        }
        require __DIR__ . '/templates/admin/passwort.php';
        break;

    default:
        header('Location: /admin');
        exit;
}
