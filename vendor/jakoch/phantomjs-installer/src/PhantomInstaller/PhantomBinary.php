<?php

namespace PhantomInstaller;

class PhantomBinary
{
    const BIN = '/Users/itre/ico.com/site/web/app/plugins/proceedings/bin/phantomjs';
    const DIR = '/Users/itre/ico.com/site/web/app/plugins/proceedings/bin';

    public static function getBin() {
        return self::BIN;
    }

    public static function getDir() {
        return self::DIR;
    }
}
