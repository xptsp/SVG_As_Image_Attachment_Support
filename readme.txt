[hr]
[center][color=red][size=16pt][b]SVG AS IMAGE ATTACHMENT SUPPORT v1.0.1[/b][/size][/color]
[url=http://www.simplemachines.org/community/index.php?action=profile;u=253913][b]By Dougiefresh[/b][/url] -> [url=http://custom.simplemachines.org/mods/index.php?mod=4085]Link to Mod[/url]
[/center]
[hr]

[color=blue][b][size=12pt][u]Introduction[/u][/size][/b][/color]
This mod allows the forum to properly process a SVG file so that it is displayed as an image beneath the post, complete with original image dimensions and size, instead showing of a download-only link for the SVG file.  It will also attempt to convert the SVG image to either a PNG image, provided that the PNG function and the ImageMagic extensions are installed.  If the PNG functions aren't available, then it will convert it to a JPEG image.

Upon install, this mod attempts to change any existing SVG file attachments so that they can be viewed.

Upon uninstall, this mod removes the image dimensions from SVG images in order to prevent SVG thumbnails from being shown at full size.

[color=blue][b][size=12pt][u]Admin Settings[/u][/size][/b][/color]
There are two new buttons under [b]Admin[/b] -> [b]Forum[/b] -> [b]Attachments and Avatars[/b] -> [b]File Maintenance[/b], at the bottom of the page under [b]SVG Attachments[/b].

The 1st button will populate existing SVG files that don't have image dimensions and mime-type data in the attachments table, while the 2nd button removes the image dimensions from the attachments table.

[color=blue][b][size=12pt][u]Compatibility Notes[/u][/size][/b][/color]
This mod was tested on SMF 2.0.11, but should work on SMF 2.0 and up.  SMF 1.x is not and will not be supported.

[url=http://custom.simplemachines.org/mods/index.php?mod=1974]PM Attachments[/url] should be installed prior to this mod being installed if you want SVG attachments to show up properly.

[color=blue][b][size=12pt][u]Changelog[/u][/size][/b][/color]
The changelog has been removed and can be seen at [url=http://www.xptsp.com/board/index.php?topic=658.msg969#msg969]XPtsp.com[/url].

[color=blue][b][size=12pt][u]License[/u][/size][/b][/color]
Copyright (c) 2016, Douglas Orend
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
