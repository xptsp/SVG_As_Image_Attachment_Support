-------

# SVG AS IMAGE ATTACHMENT SUPPORT v1.3

[**By Dougiefresh**](http://www.simplemachines.org/community/index.php?action=profile;u=253913) -> [Link to Mod](http://custom.simplemachines.org/mods/index.php?mod=4085)

-------

## Introduction
This mod allows the forum to properly process a SVG file so that it is displayed as an image beneath the post, complete with original image dimensions and size, instead showing of a download-only link for the SVG file.  It will also attempt to convert the SVG image to either a PNG image, provided that the PNG function and the ImageMagic extensions are installed.  If the PNG functions aren't available, then it will convert it to a JPEG image.

Upon install, this mod attempts to change any existing SVG file attachments so that they can be viewed.

Upon uninstall, this mod removes the image dimensions from SVG images in order to prevent SVG thumbnails from being shown at full size.

## Admin Settings
There are two new buttons under **Admin** -> **Forum** -> **Attachments and Avatars** -> **File Maintenance**, at the bottom of the page under **SVG Attachments**.

The 1st button will populate existing SVG files that don't have image dimensions and mime-type data in the attachments table, while the 2nd button removes the image dimensions from the attachments table.

## Compatibility Notes
This mod was tested on SMF 2.0.11 and SMF 2.1 Beta 3, but should work on SMF 2.0 and up.  SMF 2.1 Beta 2 and SMF 1.x will not be supported.

[PM Attachments](http://custom.simplemachines.org/mods/index.php?mod=1974) should be installed prior to this mod being installed if you want SVG attachments in Personal Messages to show up properly.

## Changelog
The changelog can be viewed at [XPtsp.com](http://www.xptsp.com/board/free-modifications/svg-as-image-attachment-support/?tab=1).

## License
Copyright (c) 2016 - 2018, Douglas Orend

All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
