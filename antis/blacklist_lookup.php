<?php
/*
	IPv4 and IPv6 address  
*/
class Ex_ipversionmismatch extends Exception
{
    public function __construct($message = null, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (!$this->message) {
            $this->message = "Both IPs must be IPv4 or IPv6";
        }
        $this->message = __CLASS__ . " :[{$this->file}:{$this->line}] {$this->message}\n";
    }
}
class Ex_invalidipaddress extends Exception
{
    public function __construct($message = null, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (!$this->message) {
            $this->message = "Requires valid IPv4 or IPv6 address";
        }
        $this->message = __CLASS__ . " :[{$this->file}:{$this->line}] {$this->message}\n";
    }
}
class Ex_invalidipobject extends Exception
{
    public function __construct($message = null, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (!$this->message) {
            $this->message = "Invalid IPObj class";
        }
        $this->message = __CLASS__ . " :[{$this->file}:{$this->line}] {$this->message}\n";
    }
}
class Ex_invalidipv4address extends Exception
{
    public function __construct($message = null, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (!$this->message) {
            $this->message = "Invalid IPv4 Object";
        }
        $this->message = __CLASS__ . " :[{$this->file}:{$this->line}] {$this->message}\n";
    }
}
class Ex_invalidipv6address extends Exception
{
    public function __construct($message = null, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if (!$this->message) {
            $this->message = "Invalid IPv6 Object";
        }
        $this->message = __CLASS__ . " :[{$this->file}:{$this->line}] {$this->message}\n";
    }
}
class IPObj
{
    private $IPv4Value = null;
    private $IPv6Value = null;
    private $IArrValue = [];
    public function __construct($Ip)
    {
        if (filter_var($Ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->IPv4Value = $Ip;
            $this->ipv4tov6($Ip);
        } elseif (filter_var($Ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->IPv6Value = $Ip;
        } else {
            throw new Ex_invalidipaddress("Requires valid IPv4 or IPv6 address ({$Ip})");
        }
        $this->toIntArray();
    }
    public function __destruct()
    {
    }
    public function __toString()
    {
        if (isset($this->IPv4Value)) {
            return $this->IPv4Value;
        }
        return $this->IPv6Value;
    }
    public function _Cmp($IPobj)
    {
        if (!is_a($IPobj, 'IPObj')) {
            throw new Ex_invalidipobject(null);
        }
        if ((isset($this->IPv4Value) && isset($IPobj->IPv4Value)) || (!isset($this->IPv4Value) && !isset($IPobj->IPv4Value))) {
            if ($this->IArrValue != $IPobj->IArrValue) {
                for ($i = 0; $i < 8; $i++) {
                    if ($this->IArrValue[$i] < $IPobj->IArrValue[$i]) {
                        return -1;
                    }
                    if ($this->IArrValue[$i] > $IPobj->IArrValue[$i]) {
                        return 1;
                    }
                }
            }
            return 0;
        } else {
            throw new Ex_ipversionmismatch("Both IPs must be IPv4 or IPv6 ({$this}),({$IPobj})");
        }
    }
    public function _And($IPobj)
    {
        if (!is_a($IPobj, 'IPObj')) {
            throw new Ex_invalidipobject(null);
        }
        if ((isset($this->IPv4Value) && isset($IPobj->IPv4Value)) || (!isset($this->IPv4Value) && !isset($IPobj->IPv4Value))) {
            for ($i = 0; $i < 8; $i++) {
                $arr[] = $this->IArrValue[$i] & $IPobj->IArrValue[$i];
            }
        } else {
            throw new Ex_ipversionmismatch("Both IPs must be IPv4 or IPv6 ({$this}),({$IPobj})");
        }
        return $arr;
    }
    private function ipv4tov6()
    {
        if (!isset($this->IPv4Value)) {
            throw new Ex_invalidipv4address("({$Ip}) Requires valid IPv4 address");
        }
        static $Mask = '::ffff:';
        $Ip = $this->IPv4Value;
        $IPv6 = strpos($Ip, '::') === 0;
        $IPv4 = strpos($Ip, '.') > 0;
        if (!$IPv4 && !$IPv6) {
            throw new Ex_invalidipv4address("({$Ip}) Requires valid IPv4 address");
        }
        if ($IPv6 && $IPv4) {
            $Ip = substr($Ip, strrpos($Ip, ':') + 1);
        } elseif (!$IPv4) {
            return $Ip;
        }
        $Ip = array_pad(explode('.', $Ip), 4, 0);
        if (count($Ip) > 4) {
            throw new Ex_invalidipv4address("({$Ip}) Requires valid IPv4 address");
        }
        for ($i = 0; $i < 4; $i++) {
            if ($Ip[$i] > 255) {
                throw new Ex_invalidipv4address("({$Ip}) Requires valid IPv4 address");
            }
        }
        $Part7 = base_convert($Ip[0] * 256 + $Ip[1], 10, 16);
        $Part8 = base_convert($Ip[2] * 256 + $Ip[3], 10, 16);
        $this->IPv6Value = $Mask . $Part7 . ':' . $Part8;
    }
    private function toIntArray()
    {
        $this->expand();
        $arr = explode(':', $this->IPv6Value);
        if (count($arr) != 8) {
            throw new Ex_invalidipv6address("({$this->IPv6Value}) too short");
        }
        foreach ($arr as $a) {
            $l[] = hexdec($a);
        }
        $this->IArrValue = $l;
    }
    private function expand()
    {
        $Ip = $this->IPv6Value;
        if (strpos($Ip, '::') !== false) {
            $Ip = str_replace('::', str_repeat(':0', 8 - substr_count($Ip, ':')) . ':', $Ip);
        }
        if (strpos($Ip, ':') === 0) {
            $Ip = '0' . $Ip;
        }
        $this->IPv6Value = $Ip;
    }
}
class IpList
{
    private $iplist = [];
    private $ipfile = "";
    public function __construct($list)
    {
        $contents = [];
        $this->ipfile = $list;
        $lines = $this->read($list);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            if ($line[0] == '#') {
                continue;
            }
            $temp = explode("#", $line);
            $line = trim($temp[0]);
            $contents[] = $this->normal($line);
        }
        $this->iplist = $contents;
    }
    public function __destruct()
    {
    }
    public function __toString()
    {
        return implode(' ', $this->iplist);
    }
    public function is_inlist($ip)
    {
        $retval = false;
        foreach ($this->iplist as $ipf) {
            try {
                $retval = $this->ip_in_range($ip, $ipf);
                if ($retval === true) {
                    $this->range = $ipf;
                    break;
                }
            } catch (Ex_ipversionmismatch $e) {
                continue;
            }
        }
        return $retval;
    }
    public function iplist()
    {
        return $this->iplist;
    }
    public function message()
    {
        return $this->range;
    }
    private function read($fname)
    {
        try {
            $file = file($fname, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } catch (Exception $e) {
            throw new Exception("{$fname}: {$e->getmessage()}");
        }
        return $file;
    }
    private function ip_in_range($ip, $range)
    {
        $ipadd = new IPObj($ip);
        if (strpos($range, '/') !== false) {
            list($base, $netmask) = explode('/', $range, 2);
            $ipbase = new IPObj($base);
            if (strpos($netmask, '.') !== false || strpos($netmask, ':') !== false) {
                $netmask = str_replace('*', '0', $netmask);
            } else {
                if (strpos($base, '.') !== false) {
                    $n = $netmask / 8;
                    $m = $netmask % 8;
                    $r = array_pad([], 4, 0);
                    for ($i = 0; $i < $n; $i++) {
                        $r[$i] = 255;
                    }
                    if ($m > 0) {
                        $r[$n] = ~(pow(2, 8 - $m) - 1);
                    }
                    for ($i = 0; $i < count($r); $i++) {
                        $r[$i] = (string) $r[$i];
                    }
                    $netmask = implode('.', $r);
                } else {
                    $n = $netmask / 16;
                    $m = $netmask % 16;
                    $r = array_pad([], 8, 0);
                    for ($i = 0; $i < $n; $i++) {
                        $r[$i] = 0xffff;
                    }
                    if ($m > 0) {
                        $r[$n] = ~(pow(2, 16 - $m) - 1);
                    }
                    for ($i = 0; $i < count($r); $i++) {
                        $r[$i] = dechex($r[$i]);
                    }
                    $netmask = implode(':', $r);
                }
            }
            $ipnetmask = new IPObj($netmask);
            return $ipadd->_And($ipnetmask) == $ipbase->_And($ipnetmask);
        } else {
            if (strpos($range, '*') !== false) {
                $low = str_replace('*', '0', $range);
                $high = str_replace('*', '255', $range);
                $range = $low . '-' . $high;
            }
            if (strpos($range, '-') !== false) {
                list($low, $high) = explode('-', $range, 2);
                $iplow = new IPObj($low);
                $iphigh = new IPObj($high);
                return $ipadd->_Cmp($iplow) != -1 && $ipadd->_Cmp($iphigh) != 1;
            }
        }
        $iprange = new IPObj($range);
        return $ipadd->_Cmp($iprange) == 0;
    }
    private function normal($range)
    {
        return str_replace(' ', '', $range);
    }
}
class IpBlockList
{
    private $statusid = ['negative' => -1, 'neutral' => 0, 'positive' => 1];
    private $whitelist = [];
    private $blacklist = [];
    private $message = null;
    private $status = null;
    public function __construct($whitelistfile = '../antis/whitelist.dat', $blacklistfile = '../antis/blacklist.dat')
    {
        $this->whitelistfile = $whitelistfile;
        $this->blacklistfile = $blacklistfile;
        $this->whitelist = new IpList($whitelistfile);
        $this->blacklist = new IpList($blacklistfile);
    }
    public function __destruct()
    {
    }
    public function ipPass($ip)
    {
        $retval = false;
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            throw new Ex_invalidipaddress('Requires valid IP address ({$ip})');
        }
        if ($this->whitelist->is_inlist($ip)) {
            $retval = true;
            $this->message = "{$ip} is whitelisted by {$this->whitelist->message()}";
            $this->status = $this->statusid['positive'];
        } elseif ($this->blacklist->is_inlist($ip)) {
            $retval = false;
            $this->message = "{$ip} is blacklisted by {$this->blacklist->message()}";
            $this->status = $this->statusid['negative'];
        } else {
            $retval = true;
            $this->message = "{$ip} is unlisted";
            $this->status = $this->statusid['neutral'];
        }
        return $retval;
    }
    public function message()
    {
        return $this->message;
    }
    public function status()
    {
        return $this->status;
    }
    public function append($type, $ip, $comment = "")
    {
        if ($type == 'WHITELIST') {
            $retval = $this->whitelistfile->append($ip, $comment);
        } elseif ($type == 'BLACKLIST') {
            $retval = $this->blacklistfile->append($ip, $comment);
        } else {
            $retval = false;
        }
    }
    public function filename($type, $ip, $comment = "")
    {
        if ($type == 'WHITELIST') {
            $retval = $this->whitelistfile->filename($ip, $comment);
        } elseif ($type == 'BLACKLIST') {
            $retval = $this->blacklistfile->filename($ip, $comment);
        } else {
            $retval = false;
        }
    }
}

?>