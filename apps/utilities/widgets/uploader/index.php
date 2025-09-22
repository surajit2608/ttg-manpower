@section('styles')
@parent
<style type="text/css">
  .wdg-upload {
    width: 100%;
    display: flex;
    overflow: hidden;
    border-radius: 0.25rem;
    flex-direction: column;
  }

  .wdg-upload .btn.btn-upload {
    margin: 0;
    text-align: center;
    align-self: stretch;
    font-size: 1rem !important;
    padding: 0.5rem 1rem !important;
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
  }

  .wdg-upload .btn.btn-upload.btn-trash {
    padding: 0.7rem;
    border-radius: 0;
    align-self: stretch;
    align-items: center;
  }

  .wdg-upload .controls {
    border-radius: 0.25rem 0 0 0.25rem;
  }

  .wdg-upload.preview .controls {
    border-radius: 0 0 0 0.25rem;
  }

  .wdg-upload.preview .btn.btn-upload {
    border-radius: 0 0 0.25rem 0;
  }

  .doc-preview {
    display: flex;
    height: 200px;
    max-width: 100%;
    overflow: hidden;
    align-items: center;
    border: 1px solid #ddd;
    justify-content: center;
    background-color: #fefefe;
    border-radius: 0.25rem 0.25rem 0 0;
  }

  .doc-preview span {
    font-size: 1.5rem;
  }

  .doc-input {
    display: flex;
    align-items: stretch;
  }

  .doc-input .controls {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  .wdg-upload.preview .doc-input {
    margin-top: -1px;
  }
</style>
@endsection


@section('markups')
@parent
<script id="upload.tpl" type="text/template">
  <div class="wdg-upload {{class}}" class-preview="{{preview}}">
    {{#if preview}}
      <div class="doc-preview">
        {{#if value}}
          <img src="/uploads/{{$.value}}" alt="Preview" />
        {{else}}
          <span>Preview</span>
        {{/if}}
      </div>
    {{/if}}
    <div class="doc-input">
      <div class="controls" style="{{style}}">
        {{#if value}}
          <a class="short-text" href="<%FULL_URL%>{{value.indexOf('/uploads/') === 0 ? value : '/uploads/'+value}}" target="_blank"><%FULL_URL%>{{value.indexOf('/uploads/') === 0 ? value : '/uploads/'+value}}</a>
        {{else}}
          No File Selected
        {{/if}}
      </div>
      {{#if value && !disabled}}
        <a class="btn btn-trash btn-icon btn-upload" on-click="onPressTrash">
          <i class="icon-close" style="margin:0"></i>
        </a>
      {{/if}}
      {{#if !disabled}}
        <label class="btn btn-save btn-upload" style="{{buttonStyle}}">
          <input type="file" accept="{{allowed}}" on-change="onChangeBrowseFile" disabled="{{disabled}}" />
          <i class="icon-plus-circle"></i> Browse & Upload
        </label>
      {{/if}}
    </div>
  </div>
</script>
@endsection


@section('scripts')
@parent
<script type="text/javascript">
  $Tag('upload', '#upload.tpl');

  $Tag.on('init', function() {
    var self = this;
    var value = self.get('value') || '';
    self.set('$.value', value);
    self.set('$.name', value.split('/').pop());
  });

  $Tag.on('onPressTrash', function() {
    var self = this;

    var params = {
      file: self.get('value'),
    };
    $Api.post('<%SITE_URL%>/common/api/upload/unlink').params(params).send(function(res) {
      self.set('value', null);
      self.set('$.name', null);
      self.set('$.value', null);
    });
  });

  $Tag.on('onChangeBrowseFile', function(e) {
    var self = this;

    var maxFileSize = self.get('size'); // in MB
    var fileSize;

    if (isIE() && isIE() < 10) {
      var filePath = e.node.value;
      if (filePath != '') {
        var AxFSObj = new ActiveXObject("Scripting.FileSystemObject");
        var AxFSObjFile = AxFSObj.getFile(filePath);
        fileSize = AxFSObjFile.size / 1024 / 1024; // in MB
      }
    } else {
      if (e.node.value != '') {
        for (var key in e.node.files) {
          fileSize += e.node.files[key].size / 1024 / 1024; // in MB
        }
      }
    }

    if (fileSize > maxFileSize) {
      $Event.fire('message.show', {
        type: 'error',
        text: 'Attachments are too big, ' + maxFileSize + ' mb is allowed',
      });
      return;
    }

    var data = new FormData();
    for (var key in e.node.files) {
      data.append(key, e.node.files[key]);
    }

    data.append('allowed', self.get('allowed'));

    $.ajax({
      data: data,
      type: 'POST',
      cache: false,
      dataType: 'json',
      processData: false,
      contentType: false,
      url: '/common/api/upload/files',
      beforeSend: function() {
        $Event.fire('api.init');
      },
      success: function(res, textStatus, jqXHR) {
        if (typeof res.events['message.show'] !== 'undefined') {
          this.fire('error');
          $Event.fire('message.show', res.events['message.show']);
          return;
        }

        if (typeof res.data.files[0] !== 'undefined') {
          self.set('value', res.data.files[0].url);
          self.set('$.name', res.data.files[0].name);
          self.set('$.value', res.data.files[0].url);
          self.fire('upload', self, res.data.files);
        } else {
          var reader = new FileReader();
          reader.onload = function(e) {
            self.set('value', e.target.result);
            self.set('$.name', e.target.result);
            self.set('$.value', e.target.result);
          };
          reader.readAsDataURL(e.node.files[0]);
          self.fire('upload', self, e.node.files);
        }

        e.node.value = '';
        $Event.fire('api.finished');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        e.node.value = '';
        $Event.fire('api.error');
        $Event.fire('message.show', {
          type: 'error',
          text: textStatus
        });
      }
    });
  });
</script>
@endsection