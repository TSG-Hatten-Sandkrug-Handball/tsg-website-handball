# Redirects on the club website

The old handball pages live on `www.tsg-hatten-sandkrug.de/handball/…` (TYPO3).
Once the new site is live on its subdomain, these addresses must redirect
permanently (HTTP 301) to the new pages for at least two years (Lastenheft chapter 4).
This happens on the **club website**, not in this repository – either in the TYPO3
redirects module or in the `.htaccess` of the main domain.

Replace `https://handball.tsg-hatten-sandkrug.de` with the final subdomain.

| Old address (www.tsg-hatten-sandkrug.de) | New address (subdomain) |
| --- | --- |
| `/handball/` | `/` |
| `/handball/neuigkeiten/` | `/neuigkeiten/` |
| `/handball/veranstaltungen/` | `/termine/` |
| `/handball/foerderkreis/` | `/foerderkreis/` |
| `/handball/service/` | `/service/` |
| `/handball/tickets/`, `/handball/hallenheft/` | `/heimspiele/` |
| `/handball/abteilungsinfos/` | `/abteilung/` |
| `/handball/turnier/` | `/kids-cup/` |
| `/handball/trainer/` | `/uebungsleiter/` |
| `/handball/schiedsrichter/` | `/schiedsrichter/` |
| `/handball/1-herren/` | `/1-herren/` |
| `/handball/2-herren/`, `/damen/`, `/maennliche-…/`, `/weibliche-…/` | `/mannschaften/<same name>/` |
| `/handball/weibliche-d-jugend/` | `/mannschaften/weibliche-d-jugend-1/` |
| `/handball/minis/` | `/mannschaften/minis-sandkrug/` |
| `/handball/f-jugend/` | `/mannschaften/minis-kirchhatten/` |

Before launch, export the full list of old handball URLs from TYPO3 and compare it
with this table (W-01); anything without a match goes to the closest parent page.

## .htaccess snippet for the main domain

Place these rules **before** the TYPO3 rewrite rules. Documents under `/fileadmin`
are not redirected, the new site links to them directly (R-06).

```apache
RewriteEngine On
RewriteRule ^handball/?$ https://handball.tsg-hatten-sandkrug.de/ [R=301,L,QSD]
RewriteRule ^handball/veranstaltungen/?$ https://handball.tsg-hatten-sandkrug.de/termine/ [R=301,L,QSD]
RewriteRule ^handball/(tickets|hallenheft)/?$ https://handball.tsg-hatten-sandkrug.de/heimspiele/ [R=301,L,QSD]
RewriteRule ^handball/abteilungsinfos/?$ https://handball.tsg-hatten-sandkrug.de/abteilung/ [R=301,L,QSD]
RewriteRule ^handball/turnier/?$ https://handball.tsg-hatten-sandkrug.de/kids-cup/ [R=301,L,QSD]
RewriteRule ^handball/trainer/?$ https://handball.tsg-hatten-sandkrug.de/uebungsleiter/ [R=301,L,QSD]
RewriteRule ^handball/minis/?$ https://handball.tsg-hatten-sandkrug.de/mannschaften/minis-sandkrug/ [R=301,L,QSD]
RewriteRule ^handball/f-jugend/?$ https://handball.tsg-hatten-sandkrug.de/mannschaften/minis-kirchhatten/ [R=301,L,QSD]
RewriteRule ^handball/weibliche-d-jugend/?$ https://handball.tsg-hatten-sandkrug.de/mannschaften/weibliche-d-jugend-1/ [R=301,L,QSD]
RewriteRule ^handball/(2-herren|damen|maennliche-[a-e]-jugend|weibliche-[b-e]-jugend(-[12])?)/?$ https://handball.tsg-hatten-sandkrug.de/mannschaften/$1/ [R=301,L,QSD]
RewriteRule ^handball/(neuigkeiten|foerderkreis|service|schiedsrichter|1-herren)/?$ https://handball.tsg-hatten-sandkrug.de/$1/ [R=301,L,QSD]
```

The menu item *Sportarten › Handball* on the club website (R-02) then simply links
to the subdomain.
