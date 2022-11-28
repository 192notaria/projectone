/**
 * ==================
 * Single File Upload
 * ==================
*/

// We register the plugins required to do
// image previews, cropping, resizing, etc.
FilePond.registerPlugin(
  FilePondPluginFileValidateType,
  FilePondPluginImageExifOrientation,
  FilePondPluginImagePreview,
  FilePondPluginImageCrop,
  FilePondPluginImageResize,
  FilePondPluginImageTransform,
//   FilePondPluginImageEdit
);

// Select the file input and use
// create() to turn it into a pond



/**
 * ====================
 * Multiple File Upload
 * ====================
*/

// We want to preview images, so we register
// the Image Preview plugin, We also register
// exif orientation (to correct mobile image
// orientation) and size validation, to prevent
// large files from being added
FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginFileValidateSize,
    // FilePondPluginImageEdit
);

  // Select the file input and use
  // create() to turn it into a pond
var multifiles = FilePond.create(
    document.querySelector('.file-upload-multiple')
  );
