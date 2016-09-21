<?php
function ozh_is_blacklisted($url) {
    /*
    $parsed = parse_url($url);
    if(!isset($parsed['host'])){
        return 'malformed';
    }
       
    // Remove www. from domain (but not from www.com)
    $parsed['host'] = preg_replace( '/^www\.(.+\.)/i', '$1', $parsed['host'] );
    */
    
    // The 3 major blacklists
    $blacklists = array(
        /*
        "access.redhawk.org",
        "b.barracudacentral.org",
        "bl.csma.biz",
        "bl.emailbasura.org",
        "bl.spamcannibal.org",
        "bl.spamcop.net",
        "bl.technovision.dk",
        "blackholes.five-ten-sg.com",
        "blackholes.wirehub.net",
        "blacklist.sci.kun.nl",
        "block.dnsbl.sorbs.net",
        "blocked.hilli.dk",
        "bogons.cymru.com",
        "cart00ney.surriel.com",
        "cbl.abuseat.org",
        "dev.null.dk",
        "dialup.blacklist.jippg.org",
        "dialups.mail-abuse.org",
        "dialups.visi.com",
        "dnsbl.ahbl.org",
        "dnsbl.antispam.or.id",
        "dnsbl.cyberlogic.net",
        "dnsbl.kempt.net",
        "dnsbl.njabl.org",
        "dnsbl.sorbs.net",
        "dnsbl-1.uceprotect.net",
        "dnsbl-2.uceprotect.net",
        "dnsbl-3.uceprotect.net",
        "duinv.aupads.org",
        "dul.dnsbl.sorbs.net",
        "dul.ru",
        "escalations.dnsbl.sorbs.net",
        "hil.habeas.com",
        "http.dnsbl.sorbs.net",
        "intruders.docs.uu.se",
        "ips.backscatterer.org",
        "korea.services.net",
        "mail-abuse.blacklist.jippg.org",
        "misc.dnsbl.sorbs.net",
        "msgid.bl.gweep.ca",
        "new.dnsbl.sorbs.net",
        "no-more-funn.moensted.dk",
        "old.dnsbl.sorbs.net",
        "pbl.spamhaus.org",
        "proxy.bl.gweep.ca",
        "psbl.surriel.com",
        "pss.spambusters.org.ar",
        "rbl.schulte.org",
        "rbl.snark.net",
        "recent.dnsbl.sorbs.net",
        "relays.bl.gweep.ca",
        "relays.bl.kundenserver.de",
        "relays.mail-abuse.org",
        "relays.nether.net",
        "rsbl.aupads.org",
        "sbl.spamhaus.org",
        "smtp.dnsbl.sorbs.net",
        "socks.dnsbl.sorbs.net",
        "spam.dnsbl.sorbs.net",
        "spam.olsentech.net",
        "spamguard.leadmon.net",
        "spamsources.fabel.dk",
        "tor.ahbl.org",
        "web.dnsbl.sorbs.net",
        "whois.rfc-ignorant.org",
        "xbl.spamhaus.org",
        "zen.spamhaus.org",
        "zombie.dnsbl.sorbs.net",
        "bl.tiopan.com",
        "dnsbl.abuse.ch",
        "tor.dnsbl.sectoor.de",
        "ubl.unsubscore.com",
        "cblless.anti-spam.org.cn",
        "dnsbl.tornevall.org",
        "dnsbl.anticaptcha.net",
        "dnsbl.dronebl.org",
        
        "zen.spamhaus.org",
        "cbl.abuseat.org",
        "bad.psky.me",
        "b.barracudacentral.org",
        "bl.spamcop.net",
        */
        
        "dbl.spamhaus.org",
        "pbl.spamhaus.org",
        "sbl.spamhaus.org",
        "xbl.spamhaus.org",
        "zen.spamhaus.org",
    );
   
    // Check against each black list, exit if blacklisted
    foreach($blacklists as $blacklist) {
        $ip = gethostbyname($url);
        // $domain = $parsed['host'] . '.' . $blacklist . '.';
        $domain = implode(".", array_reverse(explode(".", $ip))) . ".". $blacklist;
        print $domain."<br />";
        $record = dns_get_record($domain);
        if(count($record)>0){
            $check[$blacklist] = "×";
            // return true;
        } else {
            $check[$blacklist] = "○";
        }
    }
   
    // All clear, probably not spam
    return $check;
}

$urls = [
    "01cas.info",
    "acti0nneededtoday.com",
    "zyouhoukan.xsrv.jp",
    "aufeminin.com",
    "cri.univ-tlse1.fr",
];

foreach($urls as $url){
    $checks[$url] = ozh_is_blacklisted($url);
}
?>
<table border="1">
<?php
foreach($checks as $domain => $check){
    print "<tr>";
    print "<td>".$domain."</td>";
    foreach($check as $uri => $chk){
        print "<td>".$uri.":".$chk."</td>";
    }
    print "</tr>";
}
?>
<table>