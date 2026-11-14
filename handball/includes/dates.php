<?php
declare(strict_types=1);

const WEEKDAYS = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
const WEEKDAYS_SHORT = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];
const MONTHS = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
const MONTHS_SHORT = ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'];

// Training days use ISO numbering (1 = Monday) so the week view can sort by key.
const TRAINING_DAYS = [1 => 'Montag', 2 => 'Dienstag', 3 => 'Mittwoch', 4 => 'Donnerstag', 5 => 'Freitag'];
const TRAINING_DAYS_SHORT = [1 => 'Mo', 2 => 'Di', 3 => 'Mi', 4 => 'Do', 5 => 'Fr'];

function local_date(string $value): DateTimeImmutable
{
    return new DateTimeImmutable($value, new DateTimeZone(TIMEZONE));
}

function now(): DateTimeImmutable
{
    return new DateTimeImmutable('now', new DateTimeZone(TIMEZONE));
}

function today(): DateTimeImmutable
{
    return now()->setTime(0, 0);
}

function date_short(DateTimeInterface $date): string
{
    return $date->format('d.m.Y');
}

function date_day_month(DateTimeInterface $date): string
{
    return $date->format('d.m.');
}

function date_long(DateTimeInterface $date): string
{
    return $date->format('j') . '. ' . MONTHS[(int) $date->format('n') - 1] . ' ' . $date->format('Y');
}

function date_with_weekday(DateTimeInterface $date): string
{
    return WEEKDAYS[(int) $date->format('w')] . ', ' . date_long($date);
}

function time_label(DateTimeInterface $date): string
{
    return $date->format('H:i') . ' Uhr';
}

function month_short(DateTimeInterface $date): string
{
    return MONTHS_SHORT[(int) $date->format('n') - 1];
}
