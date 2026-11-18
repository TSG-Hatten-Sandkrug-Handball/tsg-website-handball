// Downloads the crests of a team's opponents once into site/assets/img/crests/
// and returns a map "team name → path relative to site/". Crests already on
// disk are not downloaded again, so the daily run only looks up new opponents.
// pruneCrests removes crests no team uses any more, e.g. after a new season.

import { access, mkdir, readdir, rm, writeFile } from 'node:fs/promises';
import { execFile } from 'node:child_process';
import { promisify } from 'node:util';
import { fileURLToPath } from 'node:url';

const run = promisify(execFile);
const CREST_SIZE = 160;

export async function updateCrests({ source, leagues, opponents, previous, siteDir }) {
  const crestDir = new URL('assets/img/crests/', siteDir);
  const crests = {};
  await mkdir(crestDir, { recursive: true });

  for (const team of opponents) {
    if (previous[team] && await exists(new URL(previous[team], siteDir))) {
      crests[team] = previous[team];
      continue;
    }

    try {
      const crest = await findCrest(source, leagues, team);

      if (crest) {
        crests[team] = await saveCrest(crest, crestDir);
      }
    } catch (error) {
      console.error(`          crest of ${team}: ${error.message}`);
    }
  }

  return crests;
}

export async function pruneCrests({ siteDir, usedPaths }) {
  const crestDir = new URL('assets/img/crests/', siteDir);
  const files = await readdir(crestDir).catch(() => []);

  for (const file of files) {
    if (!usedPaths.has(`assets/img/crests/${file}`)) {
      await rm(new URL(file, crestDir));
      console.log(`removed   crest ${file}`);
    }
  }
}

async function findCrest(source, leagues, team) {
  for (const league of leagues) {
    const crest = await source.fetchCrest(league, team);

    if (crest) {
      return crest;
    }
  }

  return null;
}

async function saveCrest(crest, crestDir) {
  const original = new URL(`${crest.id}.original.${crest.extension}`, crestDir);
  const target = new URL(`${crest.id}.png`, crestDir);
  await writeFile(original, crest.data);

  if (await shrink(original, target)) {
    await rm(original);
    return `assets/img/crests/${crest.id}.png`;
  }

  // No image tool available: keep the logo as delivered.
  await rm(target, { force: true });
  const kept = new URL(`${crest.id}.${crest.extension}`, crestDir);
  await rm(kept, { force: true });
  await writeFile(kept, crest.data);
  await rm(original);
  return `assets/img/crests/${crest.id}.${crest.extension}`;
}

// Club logos range from 4 KB to half a megabyte; they are shown at about 56 px.
// ffmpeg (often installed locally) or ImageMagick (on GitHub's runners) scales
// them down to 160 px. Whichever is found first is used.
async function shrink(input, output) {
  const from = fileURLToPath(input);
  const to = fileURLToPath(output);
  const fit = `${CREST_SIZE}x${CREST_SIZE}`;
  const attempts = [
    ['ffmpeg', ['-v', 'error', '-y', '-i', from, '-vf', `scale=${CREST_SIZE}:${CREST_SIZE}:force_original_aspect_ratio=decrease`, '-frames:v', '1', '-update', '1', to]],
    // [0] takes the first frame of animated GIFs.
    ['magick', [`${from}[0]`, '-resize', `${fit}>`, to]],
    ['convert', [`${from}[0]`, '-resize', `${fit}>`, to]],
  ];

  for (const [command, args] of attempts) {
    try {
      await run(command, args);
      return true;
    } catch {
      // Tool missing (or Windows' unrelated convert.exe): try the next one.
    }
  }

  return false;
}

async function exists(file) {
  return access(file).then(() => true, () => false);
}
