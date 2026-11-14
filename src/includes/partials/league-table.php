<?php
/**
 * @var array  $rows
 * @var string $own name of our team, highlighted in the table
 */
?>
<div class="league-table">
    <table>
        <caption class="visually-hidden">Tabelle <?= e(team('1-herren')['league']) ?>, Saison <?= e(SEASON_LABEL) ?></caption>
        <thead>
            <tr>
                <th scope="col"><abbr title="Platz">#</abbr></th>
                <th scope="col">Mannschaft</th>
                <th scope="col" class="league-table__number"><abbr title="Spiele">Sp.</abbr></th>
                <th scope="col" class="league-table__number"><abbr title="Tordifferenz">+/-</abbr></th>
                <th scope="col" class="league-table__number"><abbr title="Punkte">Pkt.</abbr></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($rows as $index => $row):
    $isOwn = $row['team'] === $own;
?>
            <tr<?= $isOwn ? ' class="league-table__own"' : '' ?>>
                <td><?= $index + 1 ?></td>
                <th scope="row" class="league-table__team"><?= breakable($row['team']) ?></th>
                <td class="league-table__number"><?= e($row['played']) ?></td>
                <td class="league-table__number"><?= e(($row['diff'] > 0 ? '+' : '') . $row['diff']) ?></td>
                <td class="league-table__number"><?= e($row['points']) ?></td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
</div>
