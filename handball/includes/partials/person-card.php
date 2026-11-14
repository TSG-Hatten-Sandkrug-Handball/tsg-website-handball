<?php
/**
 * Name, function and optional e-mail of a person.
 *
 * @var array       $person
 * @var string      $function
 * @var string|null $email    overrides the person's own address
 * @var string|null $variant  null | display (uppercase name) | brand
 * @var string|null $headingLevel h3 (default) or h2
 * @var bool|null   $showEmail    false hides the address
 */
$address = ($showEmail ?? true) ? ($email ?? $person['email']) : null;
$variantClass = isset($variant) ? ' person-card--' . $variant : '';
$heading = $headingLevel ?? 'h3';
?>
<article class="card person-card<?= e($variantClass) ?>">
<?php if (isset($variant) && $variant === 'brand'): ?>
    <p class="card__meta"><?= e($function) ?></p>
    <<?= $heading ?> class="person-card__name"><?= e($person['name']) ?></<?= $heading ?>>
<?php else: ?>
    <<?= $heading ?> class="person-card__name"><?= e($person['name']) ?></<?= $heading ?>>
    <p class="card__meta"><?= e($function) ?></p>
<?php endif; ?>
<?php if ($address !== null): ?>
    <p class="person-card__email"><?= email_link($address) ?></p>
<?php endif; ?>
</article>
