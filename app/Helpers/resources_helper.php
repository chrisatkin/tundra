<?php

// Ported from application/helpers/resources_helper.php -- same function names/signatures
// so views port with minimal changes. CI4's base_url() replaces the old
// get_instance()->config->slash_item('base_url') lookup.

if (! function_exists('basedir')) {
    function basedir(string $typeDir): string
    {
        return base_url('assets/' . $typeDir);
    }
}

if (! function_exists('get_image')) {
    function get_image($fileName, $imgAlt = '', $imgClass = '', $title = ''): string
    {
        $fileDir = basedir('art/');
        $htmlStr = '';

        if (is_array($fileName)) {
            foreach ($fileName as $imgArr) {
                $imageFile = $fileDir . $imgArr[0];
                $htmlStr .= '<img ';
                if (! empty($imgArr[2])) {
                    $htmlStr .= 'class="' . $imgArr[2] . '" ';
                }
                $htmlStr .= 'src="' . $imageFile . '" alt="';
                if (! empty($imgArr[1])) {
                    $htmlStr .= $imgArr[1];
                }
                $htmlStr .= '" />' . "\n";
            }
        } else {
            $imageFile = $fileDir . $fileName;
            $htmlStr .= '<img ';
            if (! empty($imgClass)) {
                $htmlStr .= 'class="' . $imgClass . '" ';
            }
            $htmlStr .= 'src="' . $imageFile . '" alt="' . $imgAlt . '" title="' . $title . '" />';
        }

        return $htmlStr;
    }
}

if (! function_exists('get_style')) {
    function get_style($fileName, string $mediaType = 'screen'): string
    {
        $fileDir = basedir('styles/');
        $htmlStr = '';

        if (is_array($fileName)) {
            foreach ($fileName as $styleArr) {
                $styleFile = $fileDir . $styleArr[0];
                $htmlStr .= '<link rel="stylesheet" type="text/css" href="' . $styleFile . '" media="';
                $htmlStr .= ! empty($styleArr[1]) ? $styleArr[1] : $mediaType;
                $htmlStr .= '" />' . "\n";
            }
        } else {
            $styleFile = $fileDir . $fileName;
            $htmlStr = '<link rel="stylesheet" type="text/css" href="' . $styleFile . '" media="' . $mediaType . '" />' . "\n";
        }

        return $htmlStr;
    }
}

if (! function_exists('get_script')) {
    function get_script($fileName): string
    {
        $fileDir = basedir('scripts/');
        $htmlStr = '';

        if (is_array($fileName)) {
            foreach ($fileName as $jsFile) {
                $scriptFile = $fileDir . $jsFile;
                $htmlStr .= '<script type="text/javascript" src="' . $scriptFile . '"></script>' . "\n";
            }
        } else {
            $scriptFile = $fileDir . $fileName;
            $htmlStr = '<script type="text/javascript" src="' . $scriptFile . '"></script>' . "\n";
        }

        return $htmlStr;
    }
}
