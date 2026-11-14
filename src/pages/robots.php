<?php
// Generated as robots.txt. Preview builds (--noindex) keep all crawlers out.
// AI crawlers are welcome on the live site so the department can be found and cited.
?>
<?php if (SITE_NOINDEX): ?>
User-agent: *
Disallow: /
<?php else: ?>
User-agent: *
Allow: /

Sitemap: <?= absolute_url('sitemap.xml') ?>

<?php endif; ?>
