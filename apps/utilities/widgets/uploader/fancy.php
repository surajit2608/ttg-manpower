@section('styles')
@parent
<link rel="stylesheet" href="<%SITE_URL%>/assets/css/cropper.min.css?v=<%ASSETS_V%>" />
<style type="text/css">
  .fancy-upload {
    position: relative;
    margin-top: 0.5rem;
  }

  .fancy-container {
    display: flex;
    overflow: hidden;
    flex-wrap: nowrap;
    position: relative;
  }

  .fancy-preview {
    display: flex;
    min-width: 100%;
    align-items: stretch;
  }

  .preview-wrapper {
    flex: 0.8;
    overflow: hidden;
    border: 1px solid #ddd;
    box-sizing: border-box;
    border-radius: 0.25rem;
  }

  .preview-wrapper.full {
    flex: 1;
  }

  .preview-img {
    display: block;
    max-width: 100%;
    border-radius: 0.25rem;
  }

  .preview-btns {
    flex: 0.2;
    min-width: 205px;
    margin-left: 1rem;
    margin-bottom: 1rem;
    box-sizing: border-box;
  }

  .crop-btns {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .cropped-img {
    width: 200px;
    height: 200px;
    overflow: hidden;
    margin-bottom: 1rem;
    border-radius: 0.25rem;
    border: 1px solid #ddd;
    box-sizing: border-box;
  }

  .cropped-inputs {
    flex: 1;
    padding: 1rem 0 1rem 1rem;
  }

  .prev-next-btn {
    position: absolute;
  }

  .prev-btn {
    left: 1rem;
  }

  .next-btn {
    right: 1rem;
  }

  input[type="file"].fancy-uploader {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    width: 100%;
    height: 100%;
    cursor: pointer;
    position: absolute;
    opacity: 0 !important;
  }

  #wdg-bar {
    top: 55%;
    left: 50%;
    height: 8px;
    width: 400px;
    position: fixed;
    z-index: 9999999;
    text-align: center;
    transform: translateX(-50%);
  }

  #wdg-progress {
    top: 0;
    left: 0;
    width: 0;
    bottom: 0;
    position: absolute;
    border-radius: 5px;
    background-color: #4b4848;
  }

  #wdg-percent {
    top: 25px;
    left: 50%;
    color: #ffffff;
    padding: 2px 5px;
    position: absolute;
    border-radius: 5px;
    background-color: #4b4848;
    transform: translateX(-50%);
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.2);
  }

  @media only screen and (max-width: 767px) {
    .fancy-preview {
      flex-direction: column;
    }

    .preview-wrapper {
      margin-bottom: 1rem;
    }

    .preview-btns {
      margin-left: 0;
      display: flex;
    }

  }
</style>
@endsection


@section('markups')
@parent
<script id="fancy-upload.tpl" type="text/template">
  {{#if preview || crop.enable}}
    <div class="fancy-container">
      <div class="fancy-preview">
        <div class="preview-wrapper" class-full="{{!crop.enable}}">
          <img class="preview-img" src="{{$.value.indexOf(uploadUrl)!==-1 ? $.value : uploadUrl+$.value}}" alt="Preview Image" />
        </div>

        {{#if crop.enable}}
          <div class="preview-btns">
            <div class="cropped-img"></div>
            <div class="cropped-inputs">
              <div class="group">
                <label>Width:</label>
                <input-number value="{{$.width}}" min="{{crop.min_width}}" on-change="onChangeWidth" />
              </div>
              <div class="group">
                <label>Height:</label>
                <input-number value="{{$.height}}" min="{{crop.min_height}}" on-change="onChangeHeight" />
              </div>
              <div class="crop-btns">
                <div>
                  {{#if multiple && value.length > 1}}
                    <a class="btn btn-save btn-icon" class-disabled="{{$.index===0}}" on-click="onPrevNext" direction="-1"><i class="icon-angle-left"></i></a>
                    <a class="btn btn-save btn-icon" class-disabled="{{$.index===value.length-1}}" on-click="onPrevNext" direction="+1"><i class="icon-angle-right"></i></a>
                  {{/if}}
                </div>
                <button class="btn btn-save" on-click="onCrop" class-disabled="{{disabled || !$.value}}">Crop</button>
              </div>
            </div>
          </div>
        {{/if}}

        {{#if !crop.enable && multiple && value.length > 1}}
          <a class="btn btn-save btn-icon prev-next-btn prev-btn" class-disabled="{{$.index===0}}" on-click="onPrevNext" direction="-1"><i class="icon-angle-left"></i></a>
          <a class="btn btn-save btn-icon prev-next-btn next-btn" class-disabled="{{$.index===value.length-1}}" on-click="onPrevNext" direction="+1"><i class="icon-angle-right"></i></a>
        {{/if}}
      </div>
    </div>
  {{/if}}

  <div class="fancy-upload {{class}}" class-preview="{{preview}}">
    <input class="fancy-uploader" type="file" accept="{{exts}}" multiple="{{multiple}}" on-change="onChange" disabled="{{disabled}}" title="" />
    {{yield}}
  </div>
</script>
@endsection


@section('scripts')
@parent
<script src="<%SITE_URL%>/assets/js/cropper.min.js?v=<%ASSETS_V%>"></script>
<script type="text/javascript">
  $Tag('fancy-upload', '#fancy-upload.tpl');

  $Tag.on('init', function() {
    this.set('$.index', 0);
    if (!this.get('size'))
      this.set('size', -1);
    if (!this.get('exts'))
      this.set('exts', '*');
    if (!this.get('folder'))
      this.set('folder', 'files');
    if (!this.get('filename'))
      this.set('filename', Date.now());
    if (!this.get('crop'))
      this.set('crop', {});
    if (!this.get('multiple'))
      this.set('multiple', false);
  });

  $Tag.on('render', function() {
    var self = this;

    var crop = self.get('crop');
    if (!crop.enable) return;

    self.croppedDatas = [];
    clearTimeout(self.timeout);
    self.timeout = setTimeout(() => {
      var minWidth = Number(crop.min_width) || 100,
        minHeight = Number(crop.min_height) || 100,
        aspectRatio = Number(crop.aspect_ratio) || 1;
      var prevImg = self.el.querySelector('.preview-img');
      var croppedImg = self.el.querySelector('.cropped-img');
      self.cropper = new Cropper(prevImg, {
        viewMode: 1,
        preview: croppedImg,
        aspectRatio: aspectRatio,
        minCropBoxWidth: minWidth,
        minCropBoxHeight: minHeight,
        initialAspectRatio: aspectRatio,
        ready() {
          self.fire('setDimension');
        },
        cropend() {
          self.fire('setDimension');
          self.fire('updateCroppedData');

          self.cropper.getCroppedCanvas().toBlob((blob) => {
            var files = [];
            var index = self.get('$.index');
            for (var i in self.files) {
              if (i == index) {
                files[i] = blob;
              } else {
                files[i] = self.files[i];
              }
            }
            self.files = files;
          });
        }
      });
    }, 300);
  });

  $Tag.on('updateCroppedData', function() {
    if (!this.cropper) return;

    var index = this.get('$.index');
    this.croppedDatas[index] = this.cropper.getCropBoxData();
  });

  $Tag.on('setDimension', function() {
    var cropBox = this.cropper.getCropBoxData();
    this.set('$.width', Math.round(cropBox.width));
    this.set('$.height', Math.round(cropBox.height));
  })

  $Tag.observe('value', function(value) {
    if (typeof value === 'undefined') {
      return;
    }

    var self = this;
    setTimeout(() => {
      if (!this.get('multiple')) {
        this.set('$.value', value);
      } else {
        var index = this.get('$.index');
        this.set('$.value', value[index]);
      }
    }, 100);
  });

  $Data.set('acceptableTypes', {
    '.mp4': 'video/mp4',
    '.avi': 'video/x-msvideo',
    '.mp3': 'audio/mpeg',
    '.ogg': 'application/ogg',
    '.pdf': 'application/pdf',
    '.doc': 'application/msword',
    '.docx': 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    '.xls': 'application/vnd.ms-excel',
    '.xlsx': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    '.ppt': 'application/vnd.ms-powerpoint',
    '.pptx': 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    '.jpg': 'image/jpeg',
    '.png': 'image/png',
    '.gif': 'image/gif',
    '.jpeg': 'image/jpeg',
  });

  $Tag.on('onChange', async function(e) {
    var self = this;

    if (!e.node.value) {
      return;
    }

    var fileSize = 0;
    var newTypes = [];
    var fileTypes = [];

    var allowSize = self.get('size') || -1;
    var allowType = self.get('exts') || '*';
    var dimension = self.get('dimension') || false;
    var allowTypes = allowType.split(',');
    var acceptableTypes = $Data.get('acceptableTypes');

    for (var type of allowTypes) {
      if (typeof acceptableTypes[type] === 'undefined' || type == '*') {
        continue;
      }
      newTypes.push(acceptableTypes[type]);
    }
    if (newTypes.length) {
      allowTypes = newTypes;
    }

    for (var file of e.node.files) {
      if (dimension) {
        var imgDimension = await getImageDimension(file);
        var imgWidth = imgDimension.width;
        var imgHeight = imgDimension.height;

        var dimensions = dimension.split("x");
        var dWidth = dimensions[0];
        var dHeight = dimensions[1];

        if (imgWidth != dWidth || imgHeight != dHeight) {
          $Event.fire('message.show', {
            type: 'error',
            text: 'File dimension should be "' + dimension + '" for ' + file.name,
          });
          e.node.value = '';
          return;
        }
      }

      fileTypes.push(file.type);
      fileSize += file.size / 1024 / 1024;
    }

    if (allowSize > -1 && fileSize > allowSize) {
      $Event.fire('message.show', {
        type: 'error',
        text: allowSize + ' mb file size is allowed to upload',
      });
      return;
    }

    for (var type of fileTypes) {
      if (allowType != '*' && allowTypes.length && allowTypes.indexOf(type) === -1) {
        $Event.fire('message.show', {
          type: 'error',
          text: 'File type not allowed to upload',
        });
        return;
      }
    }

    self.files = e.node.files;
    self.fire('onUpload', self.files, e);
  });

  $Tag.on('onCrop', function(e) {
    this.fire('onUpload', this.files, e);
  });

  $Tag.on('onUpload', function(files, e) {
    var self = this;

    var data = new FormData();
    var filepath = self.get('folder');
    var filename = self.get('filename');

    for (var key in files) {
      data.append(key, files[key]);
    }
    if (filepath) {
      data.append('filepath', filepath);
    }
    if (filename) {
      data.append('filename', filename);
    }

    $.ajax({
      data: data,
      async: true,
      type: 'POST',
      cache: false,
      timeout: 60000,
      dataType: 'json',
      contentType: false,
      processData: false,
      url: '<%SITE_URL%>/common/api/upload/files',
      xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(evt) {
          if (evt.lengthComputable) {
            var percentComplete = ((evt.loaded / evt.total) * 100);
            var percent = document.getElementById('wdg-percent');
            percent.innerHTML = percentComplete.toFixed(2) + '%';
          }
        }, false);
        return xhr;
      },
      beforeSend: function() {
        $Event.fire('api.init');

        var bar = document.createElement('div');
        bar.id = 'wdg-bar';
        document.getElementsByTagName('body')[0].appendChild(bar);

        var percent = document.createElement('span');
        percent.id = 'wdg-percent';
        percent.innerHTML = '0';
        bar.appendChild(percent);
      },
      success: function(res, textStatus, jqXHR) {
        if (typeof res.events['message.show'] !== 'undefined') {
          $Event.fire('api.error');
          document.getElementById('wdg-bar').remove();
          $Event.fire('message.show', res.events['message.show']);
          return;
        }

        var oldValue = self.get('value');

        $Event.fire('api.finished');
        document.getElementById('wdg-bar').remove();

        if (typeof res.data.files[0] !== 'undefined') {
          if (oldValue) {
            if (!Array.isArray(oldValue)) {
              oldValue = [oldValue];
            }
            var params = {
              files: oldValue
            };
            $Api.post('<%SITE_URL%>/common/api/upload/unlink').params(params).send();
          }

          var newValue = res.data.files;
          if (self.get('multiple')) {
            self.set('value', []);
            for (var value of newValue) {
              self.push('value', value.url);
            }
          } else {
            self.set('value', newValue[0].url);
          }

          if (self.cropper) {
            self.croppedDatas = [];
            var index = self.get('$.index');
            self.cropper.replace(newValue[index].url);
          }
        } else {
          var reader = new FileReader();
          reader.onload = function(e) {
            self.set('value', e.target.result);
          };
          reader.readAsDataURL(files[0]);
        }
        self.fire('upload', self, res);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        e.node.value = '';
        $Event.fire('api.error');
        document.getElementById('wdg-bar').remove();
        $Event.fire('message.show', {
          type: 'error',
          text: textStatus
        });
      }
    });
  });

  $Tag.on('onPrevNext', function(e) {
    var index = this.get('$.index');
    var direction = e.node.attrs('direction');
    var value = this.get('value');
    index += parseInt(direction);

    if (index < 0 || index >= value.length) {
      return;
    }

    this.set('$.index', index);
    this.set('$.value', value[index]);
    if (this.cropper) {
      this.cropper.replace(value[index], true);
      if (this.croppedDatas[index]) {
        this.cropper.setCropBoxData(this.croppedDatas[index]);
        this.fire('setDimension');
      }
    }
  });

  $Tag.on('onChangeWidth', function() {
    if (!this.cropper) return;

    var aspectRatio = Number(this.get('crop.aspect_ratio'));
    width = Number(this.get('$.width')),
      height = width / aspectRatio;

    this.set('$.height', Math.round(height));
    this.cropper.setCropBoxData({
      width: this.get('$.width'),
      height: this.get('$.height'),
    });
    this.fire('updateCroppedData');
  });

  $Tag.on('onChangeHeight', function() {
    if (!this.cropper) return;

    var aspectRatio = Number(this.get('crop.aspect_ratio'));
    height = Number(this.get('$.height')),
      width = height * aspectRatio;
    this.set('$.width', Math.round(width));
    this.cropper.setCropBoxData({
      width: this.get('$.width'),
      height: this.get('$.height'),
    });
    this.fire('updateCroppedData');
  });
</script>
@endsection