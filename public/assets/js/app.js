
var $App = {};
$App.$data = {};
$App.$events = {};
$App.$computed = {};


$App.$root = new $View();


var $Data = {};

$Data.set = $App.$root.set.bind($App.$root);
$Data.get = $App.$root.get.bind($App.$root);

$Data.increment = $App.$root.add.bind($App.$root);
$Data.decrement = $App.$root.subtract.bind($App.$root);

$Data.pop = $App.$root.pop.bind($App.$root);
$Data.push = $App.$root.push.bind($App.$root);
$Data.merge = $App.$root.merge.bind($App.$root);

$Data.sort = $App.$root.sort.bind($App.$root);
$Data.shift = $App.$root.shift.bind($App.$root);
$Data.unshift = $App.$root.unshift.bind($App.$root);
$Data.splice = $App.$root.splice.bind($App.$root);
$Data.observe = $App.$root.observe.bind($App.$root);
$Data.toggle = $App.$root.toggle.bind($App.$root);


var $Event = {};

$Event.on = $App.$root.on.bind($App.$root);
$Event.off = $App.$root.off.bind($App.$root);
$Event.once = $App.$root.once.bind($App.$root);
$Event.fire = $App.$root.fire.bind($App.$root);


$View.prototype.increment = $View.prototype.add;
$View.prototype.decrement = $View.prototype.subtract;


$View.prototype.trigger = function(key){
  var self = this;
  return function(){self.fire(key)};
};


$App.$tags = {};
$App.$components = {};
$App.$components_events = {};
$App.$components_observe = {};


var $Tag = function(key, template){

  $App.$component = key;
  $App.$components_events[key] = {};
  $App.$components_observe[key] = {};

  $App.$components[key] = $View.extend({
    template: template,
    data: {
      $:false,
    },
    computed: {

    },
    oninit: function(){
      this.name = key;

      if(this.get('id')){
        $App.$tags[this.get('id')] = this;
      }

      for (var evt in $App.$components_events[key]){
        this.on(evt, $App.$components_events[key][evt]);
      }

      for (var observe in $App.$components_observe[key]){
        this.observe(observe, $App.$components_observe[key][observe]);
      }

      this.fire('init');
    },
    onrender: function(){
      this.fire('render');
    },
    onunrender: function(){
      this.fire('unrender');
    },
  });
};


$Tag.on = function(key, event){
  $App.$components_events[$App.$component][key] = event;
};

$Tag.observe = function(key, event){
  $App.$components_observe[$App.$component][key] = event;
};

$Tag.get = function(key){
  return $App.$tags[key]
};






var $Api = {};

$Api.count = 0;
$Api.hasUrl = {};
$Api.$request = {};
$Api.$requests = [];
$Api.$timer = false;


$Api.send = function(success){

  // if($Api.hasUrl[$Api.$request.url]){
  //   return;
  // }

  $Api.count += 1;

  $Api.hasUrl[$Api.$request.url] = true;

  if(!success){
    success = function(){};
  }

  $Api.$request.success = success;

  if($Api.$request.method == 'UPLOAD'){
    return $Api.send_upload(success);
  }

  if($Api.$request.method == 'GET'){
    $Api.$request.params = '';
  }else{
    $Api.$request.params = JSON.stringify($Api.$request.params);
  }

  $Event.fire('api.init', $Api.$request);

  var xhr = new XMLHttpRequest();
  xhr.success = $Api.$request.success;
  xhr.onload = function(){
    $Api.count -= 1;
    if (xhr.status === 200){
      try{
        var response = JSON.parse(xhr.responseText);
        $Event.fire('api.success', response);
        xhr.success(response);
      }catch(e){
        $Event.fire('api.error', {});
      }
    }else{
      $Event.fire('api.error', {});
    }
    if($Api.count == 0){
      $Event.fire('api.finished', {});
    }
    $Event.fire('api.serverlogged',  response['Console-Log-Server']);
    // $Event.fire('api.serverlogged',  xhr.getResponseHeader('Console-Log-Server'));
  };

  clearTimeout($Api.timer);
  $Api.timer = setTimeout(function(){
    $Api.hasUrl = {};
  }, 1000);

  xhr.open($Api.$request.method, $Api.$request.url);
  for(var key in $Api.$request.headers){
    xhr.setRequestHeader(key, $Api.$request.headers[key]);
  }
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  xhr.send($Api.$request.params);
};


$Api.send_upload = function(success){
  $Api.$loading = true;
  var form = document.getElementById('form-file-upload');
  if(!form){
    return;
  }
  form.attrs('action', $Api.$request.url);
  $Event.fire('api.init', $Api.$request);
  form.submit();
};



$Api.get = function(url){
  $Api.$request.url = url;
  $Api.$request.method = 'GET';
  return $Api;
};

$Api.post = function(url){
  $Api.$request.url = url;
  $Api.$request.method = 'POST';
  return $Api;
};

$Api.patch = function(url){
  $Api.$request.url = url;
  $Api.$request.method = 'PATCH';
  return $Api;
};

$Api.delete = function(url){
  $Api.$request.url = url;
  $Api.$request.method = 'DELETE';
  return $Api;
};

$Api.upload = function(url){
  $Api.$request.url = url;
  $Api.$request.method = 'UPLOAD';
  return $Api;
};

$Api.params = function(params){
  $Api.$request.params = params;
  if($Api.$request.method != 'GET' && $Api.$request.method != 'UPLOAD'){
    return $Api;
  }
  if($Api.$request.url.indexOf('?') == -1){
    $Api.$request.url += '?';
  }else{
    $Api.$request.url += '&';
  }
  $Api.$request.url += $Api.encode($Api.$request.params);
  return $Api;
};

$Api.headers = function(headers){
  $Api.$request.headers = headers;
  return $Api;
}

$Api.encode = function(params){
  return Object.keys($Api.$request.params).map(function(key) {
    return encodeURIComponent(key) + '=' + encodeURIComponent($Api.$request.params[key]);
  }).join('&');
};



document.addEventListener('DOMContentLoaded', function(){

  $App.$root.components = $App.$components;

  setTimeout(function(){
    $App.$root.render('#app');
    $App.$root.resetTemplate("#app.tpl");
    $Event.fire('page.load');
  }, 300);

  setTimeout(function(){
    $Event.fire('init');
    $Event.fire('page.init');
  }, 600);

  document.body.addEventListener('click', function(e){
    $Event.fire('body.clicked');
  });


});





(function (main) {
  'use strict';

  var fecha = {};
  var token = /d{1,4}|M{1,4}|YY(?:YY)?|S{1,3}|Do|ZZ|([HhMsDm])\1?|[aA]|"[^"]*"|'[^']*'/g;
  var twoDigits = /\d\d?/;
  var threeDigits = /\d{3}/;
  var fourDigits = /\d{4}/;
  var word = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i;
  var literal = /\[([^]*?)\]/gm;
  var noop = function () {
  };

  function shorten(arr, sLen) {
    var newArr = [];
    for (var i = 0, len = arr.length; i < len; i++) {
      newArr.push(arr[i].substr(0, sLen));
    }
    return newArr;
  }

  function monthUpdate(arrName) {
    return function (d, v, i18n) {
      var index = i18n[arrName].indexOf(v.charAt(0).toUpperCase() + v.substr(1).toLowerCase());
      if (~index) {
        d.month = index;
      }
    };
  }

  function pad(val, len) {
    val = String(val);
    len = len || 2;
    while (val.length < len) {
      val = '0' + val;
    }
    return val;
  }

  var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  var monthNamesShort = shorten(monthNames, 3);
  var dayNamesShort = shorten(dayNames, 3);
  fecha.i18n = {
    dayNamesShort: dayNamesShort,
    dayNames: dayNames,
    monthNamesShort: monthNamesShort,
    monthNames: monthNames,
    amPm: ['am', 'pm'],
    DoFn: function DoFn(D) {
      return D + ['th', 'st', 'nd', 'rd'][D % 10 > 3 ? 0 : (D - D % 10 !== 10) * D % 10];
    }
  };

  var formatFlags = {
    D: function(dateObj) {
      return dateObj.getDate();
    },
    DD: function(dateObj) {
      return pad(dateObj.getDate());
    },
    Do: function(dateObj, i18n) {
      return i18n.DoFn(dateObj.getDate());
    },
    d: function(dateObj) {
      return dateObj.getDay();
    },
    dd: function(dateObj) {
      return pad(dateObj.getDay());
    },
    ddd: function(dateObj, i18n) {
      return i18n.dayNamesShort[dateObj.getDay()];
    },
    dddd: function(dateObj, i18n) {
      return i18n.dayNames[dateObj.getDay()];
    },
    M: function(dateObj) {
      return dateObj.getMonth() + 1;
    },
    MM: function(dateObj) {
      return pad(dateObj.getMonth() + 1);
    },
    MMM: function(dateObj, i18n) {
      return i18n.monthNamesShort[dateObj.getMonth()];
    },
    MMMM: function(dateObj, i18n) {
      return i18n.monthNames[dateObj.getMonth()];
    },
    YY: function(dateObj) {
      return String(dateObj.getFullYear()).substr(2);
    },
    YYYY: function(dateObj) {
      return dateObj.getFullYear();
    },
    h: function(dateObj) {
      return dateObj.getHours() % 12 || 12;
    },
    hh: function(dateObj) {
      return pad(dateObj.getHours() % 12 || 12);
    },
    H: function(dateObj) {
      return dateObj.getHours();
    },
    HH: function(dateObj) {
      return pad(dateObj.getHours());
    },
    m: function(dateObj) {
      return dateObj.getMinutes();
    },
    mm: function(dateObj) {
      return pad(dateObj.getMinutes());
    },
    s: function(dateObj) {
      return dateObj.getSeconds();
    },
    ss: function(dateObj) {
      return pad(dateObj.getSeconds());
    },
    S: function(dateObj) {
      return Math.round(dateObj.getMilliseconds() / 100);
    },
    SS: function(dateObj) {
      return pad(Math.round(dateObj.getMilliseconds() / 10), 2);
    },
    SSS: function(dateObj) {
      return pad(dateObj.getMilliseconds(), 3);
    },
    a: function(dateObj, i18n) {
      return dateObj.getHours() < 12 ? i18n.amPm[0] : i18n.amPm[1];
    },
    A: function(dateObj, i18n) {
      return dateObj.getHours() < 12 ? i18n.amPm[0].toUpperCase() : i18n.amPm[1].toUpperCase();
    },
    ZZ: function(dateObj) {
      var o = dateObj.getTimezoneOffset();
      return (o > 0 ? '-' : '+') + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4);
    }
  };

  var parseFlags = {
    D: [twoDigits, function (d, v) {
      d.day = v;
    }],
    Do: [new RegExp(twoDigits.source + word.source), function (d, v) {
      d.day = parseInt(v, 10);
    }],
    M: [twoDigits, function (d, v) {
      d.month = v - 1;
    }],
    YY: [twoDigits, function (d, v) {
      var da = new Date(), cent = +('' + da.getFullYear()).substr(0, 2);
      d.year = '' + (v > 68 ? cent - 1 : cent) + v;
    }],
    h: [twoDigits, function (d, v) {
      d.hour = v;
    }],
    m: [twoDigits, function (d, v) {
      d.minute = v;
    }],
    s: [twoDigits, function (d, v) {
      d.second = v;
    }],
    YYYY: [fourDigits, function (d, v) {
      d.year = v;
    }],
    S: [/\d/, function (d, v) {
      d.millisecond = v * 100;
    }],
    SS: [/\d{2}/, function (d, v) {
      d.millisecond = v * 10;
    }],
    SSS: [threeDigits, function (d, v) {
      d.millisecond = v;
    }],
    d: [twoDigits, noop],
    ddd: [word, noop],
    MMM: [word, monthUpdate('monthNamesShort')],
    MMMM: [word, monthUpdate('monthNames')],
    a: [word, function (d, v, i18n) {
      var val = v.toLowerCase();
      if (val === i18n.amPm[0]) {
        d.isPm = false;
      } else if (val === i18n.amPm[1]) {
        d.isPm = true;
      }
    }],
    ZZ: [/[\+\-]\d\d:?\d\d/, function (d, v) {
      var parts = (v + '').match(/([\+\-]|\d\d)/gi), minutes;

      if (parts) {
        minutes = +(parts[1] * 60) + parseInt(parts[2], 10);
        d.timezoneOffset = parts[0] === '+' ? minutes : -minutes;
      }
    }]
  };
  parseFlags.dd = parseFlags.d;
  parseFlags.dddd = parseFlags.ddd;
  parseFlags.DD = parseFlags.D;
  parseFlags.mm = parseFlags.m;
  parseFlags.hh = parseFlags.H = parseFlags.HH = parseFlags.h;
  parseFlags.MM = parseFlags.M;
  parseFlags.ss = parseFlags.s;
  parseFlags.A = parseFlags.a;


  // Some common format strings
  fecha.masks = {
    default: 'ddd MMM DD YYYY HH:mm:ss',
    shortDate: 'M/D/YY',
    mediumDate: 'MMM D, YYYY',
    longDate: 'MMMM D, YYYY',
    fullDate: 'dddd, MMMM D, YYYY',
    shortTime: 'HH:mm',
    mediumTime: 'HH:mm:ss',
    longTime: 'HH:mm:ss.SSS'
  };

  /***
  * Format a date
  * @method format
  * @param {Date|number} dateObj
  * @param {string} mask Format of the date, i.e. 'mm-dd-yy' or 'shortDate'
  */
  fecha.format = function (dateObj, mask, i18nSettings) {
    var i18n = i18nSettings || fecha.i18n;

    if (typeof dateObj === 'number') {
      dateObj = new Date(dateObj);
    }

    if (Object.prototype.toString.call(dateObj) !== '[object Date]' || isNaN(dateObj.getTime())) {
      throw new Error('Invalid Date in fecha.format');
    }

    mask = fecha.masks[mask] || mask || fecha.masks['default'];

    var literals = [];

    // Make literals inactive by replacing them with ??
    mask = mask.replace(literal, function($0, $1) {
      literals.push($1);
      return '??';
    });
    // $Apply formatting rules
    mask = mask.replace(token, function ($0) {
      return $0 in formatFlags ? formatFlags[$0](dateObj, i18n) : $0.slice(1, $0.length - 1);
    });
    // Inline literal values back into the formatted value
    return mask.replace(/\?\?/g, function() {
      return literals.shift();
    });
  };

  /**
  * Parse a date string into an object, changes - into /
  * @method parse
  * @param {string} dateStr Date string
  * @param {string} format Date parse format
  * @returns {Date|boolean}
  */
  fecha.parse = function (dateStr, format, i18nSettings) {
    var i18n = i18nSettings || fecha.i18n;

    if (typeof format !== 'string') {
      throw new Error('Invalid format in fecha.parse');
    }

    format = fecha.masks[format] || format;

    // Avoid regular expression denial of service, fail early for really long strings
    // https://www.owasp.org/index.php/Regular_expression_Denial_of_Service_-_ReDoS
    if (dateStr.length > 1000) {
      return false;
    }

    var isValid = true;
    var dateInfo = {};
    format.replace(token, function ($0) {
      if (parseFlags[$0]) {
        var info = parseFlags[$0];
        var index = dateStr.search(info[0]);
        if (!~index) {
          isValid = false;
        } else {
          dateStr.replace(info[0], function (result) {
            info[1](dateInfo, result, i18n);
            dateStr = dateStr.substr(index + result.length);
            return result;
          });
        }
      }

      return parseFlags[$0] ? '' : $0.slice(1, $0.length - 1);
    });

    if (!isValid) {
      return false;
    }

    var today = new Date();
    if (dateInfo.isPm === true && dateInfo.hour != null && +dateInfo.hour !== 12) {
      dateInfo.hour = +dateInfo.hour + 12;
    } else if (dateInfo.isPm === false && +dateInfo.hour === 12) {
      dateInfo.hour = 0;
    }

    var date;
    if (dateInfo.timezoneOffset != null) {
      dateInfo.minute = +(dateInfo.minute || 0) - +dateInfo.timezoneOffset;
      date = new Date(Date.UTC(dateInfo.year || today.getFullYear(), dateInfo.month || 0, dateInfo.day || 1,
      dateInfo.hour || 0, dateInfo.minute || 0, dateInfo.second || 0, dateInfo.millisecond || 0));
    } else {
      date = new Date(dateInfo.year || today.getFullYear(), dateInfo.month || 0, dateInfo.day || 1,
      dateInfo.hour || 0, dateInfo.minute || 0, dateInfo.second || 0, dateInfo.millisecond || 0);
    }
    return date;
  };

  /* istanbul ignore next */
  if (typeof module !== 'undefined' && module.exports) {
    module.exports = fecha;
  } else if (typeof define === 'function' && define.amd) {
    define(function () {
      return fecha;
    });
  } else {
    main.fecha = fecha;
  }
})(this);


Date.prototype.format = function(format){
  return fecha.format(this, format);
};

Date.prototype.parse = function(string){
  return fecha.parse(string, 'YYYY-MM-DD');
};



if (!Element.prototype.scrollIntoViewIfNeeded) {
  Element.prototype.scrollIntoViewIfNeeded = function (centerIfNeeded) {
    centerIfNeeded = arguments.length === 0 ? true : !!centerIfNeeded;

    var parent = this.parentNode,
    parentComputedStyle = window.getComputedStyle(parent, null),
    parentBorderTopWidth = parseInt(parentComputedStyle.getPropertyValue('border-top-width')),
    parentBorderLeftWidth = parseInt(parentComputedStyle.getPropertyValue('border-left-width')),
    overTop = this.offsetTop - parent.offsetTop < parent.scrollTop,
    overBottom = (this.offsetTop - parent.offsetTop + this.clientHeight - parentBorderTopWidth) > (parent.scrollTop + parent.clientHeight),
    overLeft = this.offsetLeft - parent.offsetLeft < parent.scrollLeft,
    overRight = (this.offsetLeft - parent.offsetLeft + this.clientWidth - parentBorderLeftWidth) > (parent.scrollLeft + parent.clientWidth),
    alignWithTop = overTop && !overBottom;

    if ((overTop || overBottom) && centerIfNeeded) {
      parent.scrollTop = this.offsetTop - parent.offsetTop - parent.clientHeight / 2 - parentBorderTopWidth + this.clientHeight / 2;
    }

    if ((overLeft || overRight) && centerIfNeeded) {
      parent.scrollLeft = this.offsetLeft - parent.offsetLeft - parent.clientWidth / 2 - parentBorderLeftWidth + this.clientWidth / 2;
    }

    if ((overTop || overBottom || overLeft || overRight) && !centerIfNeeded) {
      this.scrollIntoView(alignWithTop);
    }
  };
}

Element.prototype.attrs = function(key, value){
  if(arguments.length==1){
    return this.getAttribute(key);
  }

  this.setAttribute(key, value);
};



(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
  typeof define === 'function' && define.amd ? define(['exports'], factory) :
  factory(global.$View.events)
}(this, function (exports) { 'use strict';

// TODO can we just declare the keydowhHandler once? using `this`?
function makeKeyDefinition(code) {
  return function (node, fire) {
    function keydownHandler(event) {
      var which = event.which || event.keyCode;

      if (which === code) {
        event.preventDefault();

        fire({
          node: node,
          original: event
        });
      }
    }

    node.addEventListener('keydown', keydownHandler, false);

    return {
      teardown: function teardown() {
        node.removeEventListener('keydown', keydownHandler, false);
      }
    };
  };
}

var tab = makeKeyDefinition(9);
var enter = makeKeyDefinition(13);
var space = makeKeyDefinition(32);
var ractive_events_keys__escape = makeKeyDefinition(27);


var uparrow = makeKeyDefinition(38);
var downarrow = makeKeyDefinition(40);
var leftarrow = makeKeyDefinition(37);
var rightarrow = makeKeyDefinition(39);

exports.tab = tab;
exports.enter = enter;
exports.space = space;
exports.escape = ractive_events_keys__escape;

exports.uparrow = uparrow;
exports.downarrow = downarrow;
exports.leftarrow = leftarrow;
exports.rightarrow = rightarrow;


}));







//
