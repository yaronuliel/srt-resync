# SRT Subtitles file resync

This utility resyncs a .srt subtitle file to start at a given time

To use it run

```
git clone https://github.com/yaronuliel/srt-resync.git
cd srt-resync
chmod +x ./srt-resync.php
```

And then run

```
./srt-resync.php [start] < input.srt > output.srt
```

Where start is the time of the first subtitle in seconds (e.g. for 00:02:12.032 set `start` to `142.032`) - the rest of the times in the subtitle file will be set according to the offset between the original start time and the new start time
