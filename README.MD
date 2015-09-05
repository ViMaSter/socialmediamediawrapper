# Social Media Media Wrapper
<sup>Wait... You typed *media* twice...<sup>  

Place this repository into a subdirectory of your choosing and media files will be wrapped using the templates provided in the `/inc/type`-subdirectory.

### Templates
Variables available (and examples):
* `$absolutePath`: Path before the filename without trailing slash  
  (`http://i.vimaster.de` or `http://vimaster.de/uploads/images`)

* `$filename`: Name of the file requested  
  (`2013-12-09_21-32-51.png` or `movie.mp4`)

* `$canonialURL`: URL referring to this image **using** the wrapper  
  (`http://i.vimaster.de/2013-12-09_21-32-51.png` or `http://vimaster.de/uploads/movies/movie.mp4`)

* `$directURL`: URL referring to this image **not using** the wrapper  
  (`http://i.vimaster.de/direct/2013-12-09_21-32-51.png` or `http://vimaster.de/uploads/movies/direct/movie.mp4`)

### Platforms targeted
* [Open Graph](http://ogp.me/)
* [Twitter Cards](https://dev.twitter.com/cards/)
* [Facebooks implementation of Open Graph](https://developers.facebook.com/tools/debug/og/object/)