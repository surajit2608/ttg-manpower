@section('styles')
@parent
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/dracula.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/material.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/hint/show-hint.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/lint/lint.min.css" />
<style media="screen">
  #mirror-editor {
    margin: 0;
    padding: 0;
    width: 100%;
    overflow: hidden;
  }
</style>
@endsection


@section('markups')
@parent
<script id="editor-mirror.tpl" type="text/template">
  <textarea id="mirror-editor">{{value}}</textarea>
</script>
@endsection


@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>

<!-- Mode Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/php/php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js"></script>

<!-- Extra Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/edit/closebrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/edit/matchbrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/edit/closetag.min.js"></script>

<!-- Hint Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/hint/show-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/hint/xml-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/hint/css-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/hint/html-hint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/hint/javascript-hint.min.js"></script>

<!-- Lint Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/lint/lint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/lint/javascript-lint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/lint/css-lint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/lint/html-lint.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/addon/lint/json-lint.min.js"></script>

<script>
  $Tag('editor-mirror', '#editor-mirror.tpl');

  $Tag.on('render', function() {
    var self = this;
    clearTimeout(self.timeout);
    self.timeout = setTimeout(() => {
      var size = self.get('size') || [],
        value = self.get('value') || '',
        theme = self.get('theme') || 'default',
        mode = self.get('language') || 'htmlmixed';

      var editorEl = self.el.querySelector('#mirror-editor');
      self.editor = CodeMirror.fromTextArea(editorEl, {
        tabSize: 2,
        mode: mode,
        theme: theme,
        lineNumbers: true,
        lineWrapping: true,
        matchBrackets: true,
        autoCloseTags: true,
        styleActiveLine: true,
        indentUnit: 4,
        autoCloseBrackets: true,
        indentWithTabs: true,
        extraKeys: {
          "Ctrl-Space": "autocomplete",
        },
      });

      if (Array.isArray(size) && size.length >= 2) {
        self.editor.setSize(size[0], size[1])
      }

      self.editor.on('changes', () => {
        self.set('value', self.editor.getValue());
      });
    }, 200);
  });

  $Tag.observe('value', function(value) {
    if (!this.editor) return;
    if (value == this.editor.getValue()) return;
    this.editor.setValue(value);
  });

  $Tag.observe('theme', function(theme) {
    if (!this.editor) return;
    if (!theme) theme = 'default';
    this.editor.setOption("theme", theme);
  });

  $Tag.observe('language', function(language) {
    if (!this.editor) return;
    if (!language) language = 'htmlmixed';
    this.editor.setOption("mode", language);
  });

  $Tag.observe('size', function(size) {
    if (!this.editor) return;
    if (Array.isArray(size) && size.length >= 2) {
      this.editor.setSize(size[0], size[1])
    }
  });
</script>
@endsection