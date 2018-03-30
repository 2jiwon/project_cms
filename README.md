# project_cms
Building a blog system from Udemy's PHP course

## Turning on some important features

Check some settings in your php.ini file.
- display_errors: On
- output_buffering: 4096

Then restart your server.

## Adding assets & setting structures

This lecture actually skipped all the html, css and bootstrap,
because they are another programming area, not the parts of PHP.

1. Download CMS_TEMPLATE.zip, unzip the file.
2. The initial structure of CMS_TEMPLATE

```shell
$ tree -L 2
```
├── admin
│   ├── css
│   ├── font-awesome
│   ├── fonts
│   ├── index.html
│   └── js
├── css
│   ├── blog-home.css
│   ├── blog-post.css
│   ├── bootstrap.css
│   └── bootstrap.min.css
├── fonts
│   ├── glyphicons-halflings-regular.eot
│   ├── glyphicons-halflings-regular.svg
│   ├── glyphicons-halflings-regular.ttf
│   ├── glyphicons-halflings-regular.woff
│   └── glyphicons-halflings-regular.woff2
├── index.html
├── js
│   ├── bootstrap.js
│   ├── bootstrap.min.js
│   └── jquery.js
└── post.html

3. Make **_images_** directory in the template root directory.
4. Move to admin directory, make another **_images_** directory 
   Then Move to the root directory, again.
5. Change the file names **_.html_** -> **_.php._**

