/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 1 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(19)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 3 */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global, setImmediate) {/*!
 * Vue.js v2.5.17
 * (c) 2014-2018 Evan You
 * Released under the MIT License.
 */


/*  */

var emptyObject = Object.freeze({});

// these helpers produces better vm code in JS engines due to their
// explicitness and function inlining
function isUndef (v) {
  return v === undefined || v === null
}

function isDef (v) {
  return v !== undefined && v !== null
}

function isTrue (v) {
  return v === true
}

function isFalse (v) {
  return v === false
}

/**
 * Check if value is primitive
 */
function isPrimitive (value) {
  return (
    typeof value === 'string' ||
    typeof value === 'number' ||
    // $flow-disable-line
    typeof value === 'symbol' ||
    typeof value === 'boolean'
  )
}

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 */
function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

/**
 * Get the raw type string of a value e.g. [object Object]
 */
var _toString = Object.prototype.toString;

function toRawType (value) {
  return _toString.call(value).slice(8, -1)
}

/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 */
function isPlainObject (obj) {
  return _toString.call(obj) === '[object Object]'
}

function isRegExp (v) {
  return _toString.call(v) === '[object RegExp]'
}

/**
 * Check if val is a valid array index.
 */
function isValidArrayIndex (val) {
  var n = parseFloat(String(val));
  return n >= 0 && Math.floor(n) === n && isFinite(val)
}

/**
 * Convert a value to a string that is actually rendered.
 */
function toString (val) {
  return val == null
    ? ''
    : typeof val === 'object'
      ? JSON.stringify(val, null, 2)
      : String(val)
}

/**
 * Convert a input value to a number for persistence.
 * If the conversion fails, return original string.
 */
function toNumber (val) {
  var n = parseFloat(val);
  return isNaN(n) ? val : n
}

/**
 * Make a map and return a function for checking if a key
 * is in that map.
 */
function makeMap (
  str,
  expectsLowerCase
) {
  var map = Object.create(null);
  var list = str.split(',');
  for (var i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase
    ? function (val) { return map[val.toLowerCase()]; }
    : function (val) { return map[val]; }
}

/**
 * Check if a tag is a built-in tag.
 */
var isBuiltInTag = makeMap('slot,component', true);

/**
 * Check if a attribute is a reserved attribute.
 */
var isReservedAttribute = makeMap('key,ref,slot,slot-scope,is');

/**
 * Remove an item from an array
 */
function remove (arr, item) {
  if (arr.length) {
    var index = arr.indexOf(item);
    if (index > -1) {
      return arr.splice(index, 1)
    }
  }
}

/**
 * Check whether the object has the property.
 */
var hasOwnProperty = Object.prototype.hasOwnProperty;
function hasOwn (obj, key) {
  return hasOwnProperty.call(obj, key)
}

/**
 * Create a cached version of a pure function.
 */
function cached (fn) {
  var cache = Object.create(null);
  return (function cachedFn (str) {
    var hit = cache[str];
    return hit || (cache[str] = fn(str))
  })
}

/**
 * Camelize a hyphen-delimited string.
 */
var camelizeRE = /-(\w)/g;
var camelize = cached(function (str) {
  return str.replace(camelizeRE, function (_, c) { return c ? c.toUpperCase() : ''; })
});

/**
 * Capitalize a string.
 */
var capitalize = cached(function (str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
});

/**
 * Hyphenate a camelCase string.
 */
var hyphenateRE = /\B([A-Z])/g;
var hyphenate = cached(function (str) {
  return str.replace(hyphenateRE, '-$1').toLowerCase()
});

/**
 * Simple bind polyfill for environments that do not support it... e.g.
 * PhantomJS 1.x. Technically we don't need this anymore since native bind is
 * now more performant in most browsers, but removing it would be breaking for
 * code that was able to run in PhantomJS 1.x, so this must be kept for
 * backwards compatibility.
 */

/* istanbul ignore next */
function polyfillBind (fn, ctx) {
  function boundFn (a) {
    var l = arguments.length;
    return l
      ? l > 1
        ? fn.apply(ctx, arguments)
        : fn.call(ctx, a)
      : fn.call(ctx)
  }

  boundFn._length = fn.length;
  return boundFn
}

function nativeBind (fn, ctx) {
  return fn.bind(ctx)
}

var bind = Function.prototype.bind
  ? nativeBind
  : polyfillBind;

/**
 * Convert an Array-like object to a real Array.
 */
function toArray (list, start) {
  start = start || 0;
  var i = list.length - start;
  var ret = new Array(i);
  while (i--) {
    ret[i] = list[i + start];
  }
  return ret
}

/**
 * Mix properties into target object.
 */
function extend (to, _from) {
  for (var key in _from) {
    to[key] = _from[key];
  }
  return to
}

/**
 * Merge an Array of Objects into a single Object.
 */
function toObject (arr) {
  var res = {};
  for (var i = 0; i < arr.length; i++) {
    if (arr[i]) {
      extend(res, arr[i]);
    }
  }
  return res
}

/**
 * Perform no operation.
 * Stubbing args to make Flow happy without leaving useless transpiled code
 * with ...rest (https://flow.org/blog/2017/05/07/Strict-Function-Call-Arity/)
 */
function noop (a, b, c) {}

/**
 * Always return false.
 */
var no = function (a, b, c) { return false; };

/**
 * Return same value
 */
var identity = function (_) { return _; };

/**
 * Generate a static keys string from compiler modules.
 */
function genStaticKeys (modules) {
  return modules.reduce(function (keys, m) {
    return keys.concat(m.staticKeys || [])
  }, []).join(',')
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
function looseEqual (a, b) {
  if (a === b) { return true }
  var isObjectA = isObject(a);
  var isObjectB = isObject(b);
  if (isObjectA && isObjectB) {
    try {
      var isArrayA = Array.isArray(a);
      var isArrayB = Array.isArray(b);
      if (isArrayA && isArrayB) {
        return a.length === b.length && a.every(function (e, i) {
          return looseEqual(e, b[i])
        })
      } else if (!isArrayA && !isArrayB) {
        var keysA = Object.keys(a);
        var keysB = Object.keys(b);
        return keysA.length === keysB.length && keysA.every(function (key) {
          return looseEqual(a[key], b[key])
        })
      } else {
        /* istanbul ignore next */
        return false
      }
    } catch (e) {
      /* istanbul ignore next */
      return false
    }
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}

function looseIndexOf (arr, val) {
  for (var i = 0; i < arr.length; i++) {
    if (looseEqual(arr[i], val)) { return i }
  }
  return -1
}

/**
 * Ensure a function is called only once.
 */
function once (fn) {
  var called = false;
  return function () {
    if (!called) {
      called = true;
      fn.apply(this, arguments);
    }
  }
}

var SSR_ATTR = 'data-server-rendered';

var ASSET_TYPES = [
  'component',
  'directive',
  'filter'
];

var LIFECYCLE_HOOKS = [
  'beforeCreate',
  'created',
  'beforeMount',
  'mounted',
  'beforeUpdate',
  'updated',
  'beforeDestroy',
  'destroyed',
  'activated',
  'deactivated',
  'errorCaptured'
];

/*  */

var config = ({
  /**
   * Option merge strategies (used in core/util/options)
   */
  // $flow-disable-line
  optionMergeStrategies: Object.create(null),

  /**
   * Whether to suppress warnings.
   */
  silent: false,

  /**
   * Show production mode tip message on boot?
   */
  productionTip: "development" !== 'production',

  /**
   * Whether to enable devtools
   */
  devtools: "development" !== 'production',

  /**
   * Whether to record perf
   */
  performance: false,

  /**
   * Error handler for watcher errors
   */
  errorHandler: null,

  /**
   * Warn handler for watcher warns
   */
  warnHandler: null,

  /**
   * Ignore certain custom elements
   */
  ignoredElements: [],

  /**
   * Custom user key aliases for v-on
   */
  // $flow-disable-line
  keyCodes: Object.create(null),

  /**
   * Check if a tag is reserved so that it cannot be registered as a
   * component. This is platform-dependent and may be overwritten.
   */
  isReservedTag: no,

  /**
   * Check if an attribute is reserved so that it cannot be used as a component
   * prop. This is platform-dependent and may be overwritten.
   */
  isReservedAttr: no,

  /**
   * Check if a tag is an unknown element.
   * Platform-dependent.
   */
  isUnknownElement: no,

  /**
   * Get the namespace of an element
   */
  getTagNamespace: noop,

  /**
   * Parse the real tag name for the specific platform.
   */
  parsePlatformTagName: identity,

  /**
   * Check if an attribute must be bound using property, e.g. value
   * Platform-dependent.
   */
  mustUseProp: no,

  /**
   * Exposed for legacy reasons
   */
  _lifecycleHooks: LIFECYCLE_HOOKS
})

/*  */

/**
 * Check if a string starts with $ or _
 */
function isReserved (str) {
  var c = (str + '').charCodeAt(0);
  return c === 0x24 || c === 0x5F
}

/**
 * Define a property.
 */
function def (obj, key, val, enumerable) {
  Object.defineProperty(obj, key, {
    value: val,
    enumerable: !!enumerable,
    writable: true,
    configurable: true
  });
}

/**
 * Parse simple path.
 */
var bailRE = /[^\w.$]/;
function parsePath (path) {
  if (bailRE.test(path)) {
    return
  }
  var segments = path.split('.');
  return function (obj) {
    for (var i = 0; i < segments.length; i++) {
      if (!obj) { return }
      obj = obj[segments[i]];
    }
    return obj
  }
}

/*  */

// can we use __proto__?
var hasProto = '__proto__' in {};

// Browser environment sniffing
var inBrowser = typeof window !== 'undefined';
var inWeex = typeof WXEnvironment !== 'undefined' && !!WXEnvironment.platform;
var weexPlatform = inWeex && WXEnvironment.platform.toLowerCase();
var UA = inBrowser && window.navigator.userAgent.toLowerCase();
var isIE = UA && /msie|trident/.test(UA);
var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
var isEdge = UA && UA.indexOf('edge/') > 0;
var isAndroid = (UA && UA.indexOf('android') > 0) || (weexPlatform === 'android');
var isIOS = (UA && /iphone|ipad|ipod|ios/.test(UA)) || (weexPlatform === 'ios');
var isChrome = UA && /chrome\/\d+/.test(UA) && !isEdge;

// Firefox has a "watch" function on Object.prototype...
var nativeWatch = ({}).watch;

var supportsPassive = false;
if (inBrowser) {
  try {
    var opts = {};
    Object.defineProperty(opts, 'passive', ({
      get: function get () {
        /* istanbul ignore next */
        supportsPassive = true;
      }
    })); // https://github.com/facebook/flow/issues/285
    window.addEventListener('test-passive', null, opts);
  } catch (e) {}
}

// this needs to be lazy-evaled because vue may be required before
// vue-server-renderer can set VUE_ENV
var _isServer;
var isServerRendering = function () {
  if (_isServer === undefined) {
    /* istanbul ignore if */
    if (!inBrowser && !inWeex && typeof global !== 'undefined') {
      // detect presence of vue-server-renderer and avoid
      // Webpack shimming the process
      _isServer = global['process'].env.VUE_ENV === 'server';
    } else {
      _isServer = false;
    }
  }
  return _isServer
};

// detect devtools
var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

/* istanbul ignore next */
function isNative (Ctor) {
  return typeof Ctor === 'function' && /native code/.test(Ctor.toString())
}

var hasSymbol =
  typeof Symbol !== 'undefined' && isNative(Symbol) &&
  typeof Reflect !== 'undefined' && isNative(Reflect.ownKeys);

var _Set;
/* istanbul ignore if */ // $flow-disable-line
if (typeof Set !== 'undefined' && isNative(Set)) {
  // use native Set when available.
  _Set = Set;
} else {
  // a non-standard Set polyfill that only works with primitive keys.
  _Set = (function () {
    function Set () {
      this.set = Object.create(null);
    }
    Set.prototype.has = function has (key) {
      return this.set[key] === true
    };
    Set.prototype.add = function add (key) {
      this.set[key] = true;
    };
    Set.prototype.clear = function clear () {
      this.set = Object.create(null);
    };

    return Set;
  }());
}

/*  */

var warn = noop;
var tip = noop;
var generateComponentTrace = (noop); // work around flow check
var formatComponentName = (noop);

if (true) {
  var hasConsole = typeof console !== 'undefined';
  var classifyRE = /(?:^|[-_])(\w)/g;
  var classify = function (str) { return str
    .replace(classifyRE, function (c) { return c.toUpperCase(); })
    .replace(/[-_]/g, ''); };

  warn = function (msg, vm) {
    var trace = vm ? generateComponentTrace(vm) : '';

    if (config.warnHandler) {
      config.warnHandler.call(null, msg, vm, trace);
    } else if (hasConsole && (!config.silent)) {
      console.error(("[Vue warn]: " + msg + trace));
    }
  };

  tip = function (msg, vm) {
    if (hasConsole && (!config.silent)) {
      console.warn("[Vue tip]: " + msg + (
        vm ? generateComponentTrace(vm) : ''
      ));
    }
  };

  formatComponentName = function (vm, includeFile) {
    if (vm.$root === vm) {
      return '<Root>'
    }
    var options = typeof vm === 'function' && vm.cid != null
      ? vm.options
      : vm._isVue
        ? vm.$options || vm.constructor.options
        : vm || {};
    var name = options.name || options._componentTag;
    var file = options.__file;
    if (!name && file) {
      var match = file.match(/([^/\\]+)\.vue$/);
      name = match && match[1];
    }

    return (
      (name ? ("<" + (classify(name)) + ">") : "<Anonymous>") +
      (file && includeFile !== false ? (" at " + file) : '')
    )
  };

  var repeat = function (str, n) {
    var res = '';
    while (n) {
      if (n % 2 === 1) { res += str; }
      if (n > 1) { str += str; }
      n >>= 1;
    }
    return res
  };

  generateComponentTrace = function (vm) {
    if (vm._isVue && vm.$parent) {
      var tree = [];
      var currentRecursiveSequence = 0;
      while (vm) {
        if (tree.length > 0) {
          var last = tree[tree.length - 1];
          if (last.constructor === vm.constructor) {
            currentRecursiveSequence++;
            vm = vm.$parent;
            continue
          } else if (currentRecursiveSequence > 0) {
            tree[tree.length - 1] = [last, currentRecursiveSequence];
            currentRecursiveSequence = 0;
          }
        }
        tree.push(vm);
        vm = vm.$parent;
      }
      return '\n\nfound in\n\n' + tree
        .map(function (vm, i) { return ("" + (i === 0 ? '---> ' : repeat(' ', 5 + i * 2)) + (Array.isArray(vm)
            ? ((formatComponentName(vm[0])) + "... (" + (vm[1]) + " recursive calls)")
            : formatComponentName(vm))); })
        .join('\n')
    } else {
      return ("\n\n(found in " + (formatComponentName(vm)) + ")")
    }
  };
}

/*  */


var uid = 0;

/**
 * A dep is an observable that can have multiple
 * directives subscribing to it.
 */
var Dep = function Dep () {
  this.id = uid++;
  this.subs = [];
};

Dep.prototype.addSub = function addSub (sub) {
  this.subs.push(sub);
};

Dep.prototype.removeSub = function removeSub (sub) {
  remove(this.subs, sub);
};

Dep.prototype.depend = function depend () {
  if (Dep.target) {
    Dep.target.addDep(this);
  }
};

Dep.prototype.notify = function notify () {
  // stabilize the subscriber list first
  var subs = this.subs.slice();
  for (var i = 0, l = subs.length; i < l; i++) {
    subs[i].update();
  }
};

// the current target watcher being evaluated.
// this is globally unique because there could be only one
// watcher being evaluated at any time.
Dep.target = null;
var targetStack = [];

function pushTarget (_target) {
  if (Dep.target) { targetStack.push(Dep.target); }
  Dep.target = _target;
}

function popTarget () {
  Dep.target = targetStack.pop();
}

/*  */

var VNode = function VNode (
  tag,
  data,
  children,
  text,
  elm,
  context,
  componentOptions,
  asyncFactory
) {
  this.tag = tag;
  this.data = data;
  this.children = children;
  this.text = text;
  this.elm = elm;
  this.ns = undefined;
  this.context = context;
  this.fnContext = undefined;
  this.fnOptions = undefined;
  this.fnScopeId = undefined;
  this.key = data && data.key;
  this.componentOptions = componentOptions;
  this.componentInstance = undefined;
  this.parent = undefined;
  this.raw = false;
  this.isStatic = false;
  this.isRootInsert = true;
  this.isComment = false;
  this.isCloned = false;
  this.isOnce = false;
  this.asyncFactory = asyncFactory;
  this.asyncMeta = undefined;
  this.isAsyncPlaceholder = false;
};

var prototypeAccessors = { child: { configurable: true } };

// DEPRECATED: alias for componentInstance for backwards compat.
/* istanbul ignore next */
prototypeAccessors.child.get = function () {
  return this.componentInstance
};

Object.defineProperties( VNode.prototype, prototypeAccessors );

var createEmptyVNode = function (text) {
  if ( text === void 0 ) text = '';

  var node = new VNode();
  node.text = text;
  node.isComment = true;
  return node
};

function createTextVNode (val) {
  return new VNode(undefined, undefined, undefined, String(val))
}

// optimized shallow clone
// used for static nodes and slot nodes because they may be reused across
// multiple renders, cloning them avoids errors when DOM manipulations rely
// on their elm reference.
function cloneVNode (vnode) {
  var cloned = new VNode(
    vnode.tag,
    vnode.data,
    vnode.children,
    vnode.text,
    vnode.elm,
    vnode.context,
    vnode.componentOptions,
    vnode.asyncFactory
  );
  cloned.ns = vnode.ns;
  cloned.isStatic = vnode.isStatic;
  cloned.key = vnode.key;
  cloned.isComment = vnode.isComment;
  cloned.fnContext = vnode.fnContext;
  cloned.fnOptions = vnode.fnOptions;
  cloned.fnScopeId = vnode.fnScopeId;
  cloned.isCloned = true;
  return cloned
}

/*
 * not type checking this file because flow doesn't play well with
 * dynamically accessing methods on Array prototype
 */

var arrayProto = Array.prototype;
var arrayMethods = Object.create(arrayProto);

var methodsToPatch = [
  'push',
  'pop',
  'shift',
  'unshift',
  'splice',
  'sort',
  'reverse'
];

/**
 * Intercept mutating methods and emit events
 */
methodsToPatch.forEach(function (method) {
  // cache original method
  var original = arrayProto[method];
  def(arrayMethods, method, function mutator () {
    var args = [], len = arguments.length;
    while ( len-- ) args[ len ] = arguments[ len ];

    var result = original.apply(this, args);
    var ob = this.__ob__;
    var inserted;
    switch (method) {
      case 'push':
      case 'unshift':
        inserted = args;
        break
      case 'splice':
        inserted = args.slice(2);
        break
    }
    if (inserted) { ob.observeArray(inserted); }
    // notify change
    ob.dep.notify();
    return result
  });
});

/*  */

var arrayKeys = Object.getOwnPropertyNames(arrayMethods);

/**
 * In some cases we may want to disable observation inside a component's
 * update computation.
 */
var shouldObserve = true;

function toggleObserving (value) {
  shouldObserve = value;
}

/**
 * Observer class that is attached to each observed
 * object. Once attached, the observer converts the target
 * object's property keys into getter/setters that
 * collect dependencies and dispatch updates.
 */
var Observer = function Observer (value) {
  this.value = value;
  this.dep = new Dep();
  this.vmCount = 0;
  def(value, '__ob__', this);
  if (Array.isArray(value)) {
    var augment = hasProto
      ? protoAugment
      : copyAugment;
    augment(value, arrayMethods, arrayKeys);
    this.observeArray(value);
  } else {
    this.walk(value);
  }
};

/**
 * Walk through each property and convert them into
 * getter/setters. This method should only be called when
 * value type is Object.
 */
Observer.prototype.walk = function walk (obj) {
  var keys = Object.keys(obj);
  for (var i = 0; i < keys.length; i++) {
    defineReactive(obj, keys[i]);
  }
};

/**
 * Observe a list of Array items.
 */
Observer.prototype.observeArray = function observeArray (items) {
  for (var i = 0, l = items.length; i < l; i++) {
    observe(items[i]);
  }
};

// helpers

/**
 * Augment an target Object or Array by intercepting
 * the prototype chain using __proto__
 */
function protoAugment (target, src, keys) {
  /* eslint-disable no-proto */
  target.__proto__ = src;
  /* eslint-enable no-proto */
}

/**
 * Augment an target Object or Array by defining
 * hidden properties.
 */
/* istanbul ignore next */
function copyAugment (target, src, keys) {
  for (var i = 0, l = keys.length; i < l; i++) {
    var key = keys[i];
    def(target, key, src[key]);
  }
}

/**
 * Attempt to create an observer instance for a value,
 * returns the new observer if successfully observed,
 * or the existing observer if the value already has one.
 */
function observe (value, asRootData) {
  if (!isObject(value) || value instanceof VNode) {
    return
  }
  var ob;
  if (hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
    ob = value.__ob__;
  } else if (
    shouldObserve &&
    !isServerRendering() &&
    (Array.isArray(value) || isPlainObject(value)) &&
    Object.isExtensible(value) &&
    !value._isVue
  ) {
    ob = new Observer(value);
  }
  if (asRootData && ob) {
    ob.vmCount++;
  }
  return ob
}

/**
 * Define a reactive property on an Object.
 */
function defineReactive (
  obj,
  key,
  val,
  customSetter,
  shallow
) {
  var dep = new Dep();

  var property = Object.getOwnPropertyDescriptor(obj, key);
  if (property && property.configurable === false) {
    return
  }

  // cater for pre-defined getter/setters
  var getter = property && property.get;
  if (!getter && arguments.length === 2) {
    val = obj[key];
  }
  var setter = property && property.set;

  var childOb = !shallow && observe(val);
  Object.defineProperty(obj, key, {
    enumerable: true,
    configurable: true,
    get: function reactiveGetter () {
      var value = getter ? getter.call(obj) : val;
      if (Dep.target) {
        dep.depend();
        if (childOb) {
          childOb.dep.depend();
          if (Array.isArray(value)) {
            dependArray(value);
          }
        }
      }
      return value
    },
    set: function reactiveSetter (newVal) {
      var value = getter ? getter.call(obj) : val;
      /* eslint-disable no-self-compare */
      if (newVal === value || (newVal !== newVal && value !== value)) {
        return
      }
      /* eslint-enable no-self-compare */
      if ("development" !== 'production' && customSetter) {
        customSetter();
      }
      if (setter) {
        setter.call(obj, newVal);
      } else {
        val = newVal;
      }
      childOb = !shallow && observe(newVal);
      dep.notify();
    }
  });
}

/**
 * Set a property on an object. Adds the new property and
 * triggers change notification if the property doesn't
 * already exist.
 */
function set (target, key, val) {
  if ("development" !== 'production' &&
    (isUndef(target) || isPrimitive(target))
  ) {
    warn(("Cannot set reactive property on undefined, null, or primitive value: " + ((target))));
  }
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.length = Math.max(target.length, key);
    target.splice(key, 1, val);
    return val
  }
  if (key in target && !(key in Object.prototype)) {
    target[key] = val;
    return val
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    "development" !== 'production' && warn(
      'Avoid adding reactive properties to a Vue instance or its root $data ' +
      'at runtime - declare it upfront in the data option.'
    );
    return val
  }
  if (!ob) {
    target[key] = val;
    return val
  }
  defineReactive(ob.value, key, val);
  ob.dep.notify();
  return val
}

/**
 * Delete a property and trigger change if necessary.
 */
function del (target, key) {
  if ("development" !== 'production' &&
    (isUndef(target) || isPrimitive(target))
  ) {
    warn(("Cannot delete reactive property on undefined, null, or primitive value: " + ((target))));
  }
  if (Array.isArray(target) && isValidArrayIndex(key)) {
    target.splice(key, 1);
    return
  }
  var ob = (target).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    "development" !== 'production' && warn(
      'Avoid deleting properties on a Vue instance or its root $data ' +
      '- just set it to null.'
    );
    return
  }
  if (!hasOwn(target, key)) {
    return
  }
  delete target[key];
  if (!ob) {
    return
  }
  ob.dep.notify();
}

/**
 * Collect dependencies on array elements when the array is touched, since
 * we cannot intercept array element access like property getters.
 */
function dependArray (value) {
  for (var e = (void 0), i = 0, l = value.length; i < l; i++) {
    e = value[i];
    e && e.__ob__ && e.__ob__.dep.depend();
    if (Array.isArray(e)) {
      dependArray(e);
    }
  }
}

/*  */

/**
 * Option overwriting strategies are functions that handle
 * how to merge a parent option value and a child option
 * value into the final value.
 */
var strats = config.optionMergeStrategies;

/**
 * Options with restrictions
 */
if (true) {
  strats.el = strats.propsData = function (parent, child, vm, key) {
    if (!vm) {
      warn(
        "option \"" + key + "\" can only be used during instance " +
        'creation with the `new` keyword.'
      );
    }
    return defaultStrat(parent, child)
  };
}

/**
 * Helper that recursively merges two data objects together.
 */
function mergeData (to, from) {
  if (!from) { return to }
  var key, toVal, fromVal;
  var keys = Object.keys(from);
  for (var i = 0; i < keys.length; i++) {
    key = keys[i];
    toVal = to[key];
    fromVal = from[key];
    if (!hasOwn(to, key)) {
      set(to, key, fromVal);
    } else if (isPlainObject(toVal) && isPlainObject(fromVal)) {
      mergeData(toVal, fromVal);
    }
  }
  return to
}

/**
 * Data
 */
function mergeDataOrFn (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    // in a Vue.extend merge, both should be functions
    if (!childVal) {
      return parentVal
    }
    if (!parentVal) {
      return childVal
    }
    // when parentVal & childVal are both present,
    // we need to return a function that returns the
    // merged result of both functions... no need to
    // check if parentVal is a function here because
    // it has to be a function to pass previous merges.
    return function mergedDataFn () {
      return mergeData(
        typeof childVal === 'function' ? childVal.call(this, this) : childVal,
        typeof parentVal === 'function' ? parentVal.call(this, this) : parentVal
      )
    }
  } else {
    return function mergedInstanceDataFn () {
      // instance merge
      var instanceData = typeof childVal === 'function'
        ? childVal.call(vm, vm)
        : childVal;
      var defaultData = typeof parentVal === 'function'
        ? parentVal.call(vm, vm)
        : parentVal;
      if (instanceData) {
        return mergeData(instanceData, defaultData)
      } else {
        return defaultData
      }
    }
  }
}

strats.data = function (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    if (childVal && typeof childVal !== 'function') {
      "development" !== 'production' && warn(
        'The "data" option should be a function ' +
        'that returns a per-instance value in component ' +
        'definitions.',
        vm
      );

      return parentVal
    }
    return mergeDataOrFn(parentVal, childVal)
  }

  return mergeDataOrFn(parentVal, childVal, vm)
};

/**
 * Hooks and props are merged as arrays.
 */
function mergeHook (
  parentVal,
  childVal
) {
  return childVal
    ? parentVal
      ? parentVal.concat(childVal)
      : Array.isArray(childVal)
        ? childVal
        : [childVal]
    : parentVal
}

LIFECYCLE_HOOKS.forEach(function (hook) {
  strats[hook] = mergeHook;
});

/**
 * Assets
 *
 * When a vm is present (instance creation), we need to do
 * a three-way merge between constructor options, instance
 * options and parent options.
 */
function mergeAssets (
  parentVal,
  childVal,
  vm,
  key
) {
  var res = Object.create(parentVal || null);
  if (childVal) {
    "development" !== 'production' && assertObjectType(key, childVal, vm);
    return extend(res, childVal)
  } else {
    return res
  }
}

ASSET_TYPES.forEach(function (type) {
  strats[type + 's'] = mergeAssets;
});

/**
 * Watchers.
 *
 * Watchers hashes should not overwrite one
 * another, so we merge them as arrays.
 */
strats.watch = function (
  parentVal,
  childVal,
  vm,
  key
) {
  // work around Firefox's Object.prototype.watch...
  if (parentVal === nativeWatch) { parentVal = undefined; }
  if (childVal === nativeWatch) { childVal = undefined; }
  /* istanbul ignore if */
  if (!childVal) { return Object.create(parentVal || null) }
  if (true) {
    assertObjectType(key, childVal, vm);
  }
  if (!parentVal) { return childVal }
  var ret = {};
  extend(ret, parentVal);
  for (var key$1 in childVal) {
    var parent = ret[key$1];
    var child = childVal[key$1];
    if (parent && !Array.isArray(parent)) {
      parent = [parent];
    }
    ret[key$1] = parent
      ? parent.concat(child)
      : Array.isArray(child) ? child : [child];
  }
  return ret
};

/**
 * Other object hashes.
 */
strats.props =
strats.methods =
strats.inject =
strats.computed = function (
  parentVal,
  childVal,
  vm,
  key
) {
  if (childVal && "development" !== 'production') {
    assertObjectType(key, childVal, vm);
  }
  if (!parentVal) { return childVal }
  var ret = Object.create(null);
  extend(ret, parentVal);
  if (childVal) { extend(ret, childVal); }
  return ret
};
strats.provide = mergeDataOrFn;

/**
 * Default strategy.
 */
var defaultStrat = function (parentVal, childVal) {
  return childVal === undefined
    ? parentVal
    : childVal
};

/**
 * Validate component names
 */
function checkComponents (options) {
  for (var key in options.components) {
    validateComponentName(key);
  }
}

function validateComponentName (name) {
  if (!/^[a-zA-Z][\w-]*$/.test(name)) {
    warn(
      'Invalid component name: "' + name + '". Component names ' +
      'can only contain alphanumeric characters and the hyphen, ' +
      'and must start with a letter.'
    );
  }
  if (isBuiltInTag(name) || config.isReservedTag(name)) {
    warn(
      'Do not use built-in or reserved HTML elements as component ' +
      'id: ' + name
    );
  }
}

/**
 * Ensure all props option syntax are normalized into the
 * Object-based format.
 */
function normalizeProps (options, vm) {
  var props = options.props;
  if (!props) { return }
  var res = {};
  var i, val, name;
  if (Array.isArray(props)) {
    i = props.length;
    while (i--) {
      val = props[i];
      if (typeof val === 'string') {
        name = camelize(val);
        res[name] = { type: null };
      } else if (true) {
        warn('props must be strings when using array syntax.');
      }
    }
  } else if (isPlainObject(props)) {
    for (var key in props) {
      val = props[key];
      name = camelize(key);
      res[name] = isPlainObject(val)
        ? val
        : { type: val };
    }
  } else if (true) {
    warn(
      "Invalid value for option \"props\": expected an Array or an Object, " +
      "but got " + (toRawType(props)) + ".",
      vm
    );
  }
  options.props = res;
}

/**
 * Normalize all injections into Object-based format
 */
function normalizeInject (options, vm) {
  var inject = options.inject;
  if (!inject) { return }
  var normalized = options.inject = {};
  if (Array.isArray(inject)) {
    for (var i = 0; i < inject.length; i++) {
      normalized[inject[i]] = { from: inject[i] };
    }
  } else if (isPlainObject(inject)) {
    for (var key in inject) {
      var val = inject[key];
      normalized[key] = isPlainObject(val)
        ? extend({ from: key }, val)
        : { from: val };
    }
  } else if (true) {
    warn(
      "Invalid value for option \"inject\": expected an Array or an Object, " +
      "but got " + (toRawType(inject)) + ".",
      vm
    );
  }
}

/**
 * Normalize raw function directives into object format.
 */
function normalizeDirectives (options) {
  var dirs = options.directives;
  if (dirs) {
    for (var key in dirs) {
      var def = dirs[key];
      if (typeof def === 'function') {
        dirs[key] = { bind: def, update: def };
      }
    }
  }
}

function assertObjectType (name, value, vm) {
  if (!isPlainObject(value)) {
    warn(
      "Invalid value for option \"" + name + "\": expected an Object, " +
      "but got " + (toRawType(value)) + ".",
      vm
    );
  }
}

/**
 * Merge two option objects into a new one.
 * Core utility used in both instantiation and inheritance.
 */
function mergeOptions (
  parent,
  child,
  vm
) {
  if (true) {
    checkComponents(child);
  }

  if (typeof child === 'function') {
    child = child.options;
  }

  normalizeProps(child, vm);
  normalizeInject(child, vm);
  normalizeDirectives(child);
  var extendsFrom = child.extends;
  if (extendsFrom) {
    parent = mergeOptions(parent, extendsFrom, vm);
  }
  if (child.mixins) {
    for (var i = 0, l = child.mixins.length; i < l; i++) {
      parent = mergeOptions(parent, child.mixins[i], vm);
    }
  }
  var options = {};
  var key;
  for (key in parent) {
    mergeField(key);
  }
  for (key in child) {
    if (!hasOwn(parent, key)) {
      mergeField(key);
    }
  }
  function mergeField (key) {
    var strat = strats[key] || defaultStrat;
    options[key] = strat(parent[key], child[key], vm, key);
  }
  return options
}

/**
 * Resolve an asset.
 * This function is used because child instances need access
 * to assets defined in its ancestor chain.
 */
function resolveAsset (
  options,
  type,
  id,
  warnMissing
) {
  /* istanbul ignore if */
  if (typeof id !== 'string') {
    return
  }
  var assets = options[type];
  // check local registration variations first
  if (hasOwn(assets, id)) { return assets[id] }
  var camelizedId = camelize(id);
  if (hasOwn(assets, camelizedId)) { return assets[camelizedId] }
  var PascalCaseId = capitalize(camelizedId);
  if (hasOwn(assets, PascalCaseId)) { return assets[PascalCaseId] }
  // fallback to prototype chain
  var res = assets[id] || assets[camelizedId] || assets[PascalCaseId];
  if ("development" !== 'production' && warnMissing && !res) {
    warn(
      'Failed to resolve ' + type.slice(0, -1) + ': ' + id,
      options
    );
  }
  return res
}

/*  */

function validateProp (
  key,
  propOptions,
  propsData,
  vm
) {
  var prop = propOptions[key];
  var absent = !hasOwn(propsData, key);
  var value = propsData[key];
  // boolean casting
  var booleanIndex = getTypeIndex(Boolean, prop.type);
  if (booleanIndex > -1) {
    if (absent && !hasOwn(prop, 'default')) {
      value = false;
    } else if (value === '' || value === hyphenate(key)) {
      // only cast empty string / same name to boolean if
      // boolean has higher priority
      var stringIndex = getTypeIndex(String, prop.type);
      if (stringIndex < 0 || booleanIndex < stringIndex) {
        value = true;
      }
    }
  }
  // check default value
  if (value === undefined) {
    value = getPropDefaultValue(vm, prop, key);
    // since the default value is a fresh copy,
    // make sure to observe it.
    var prevShouldObserve = shouldObserve;
    toggleObserving(true);
    observe(value);
    toggleObserving(prevShouldObserve);
  }
  if (
    true
  ) {
    assertProp(prop, key, value, vm, absent);
  }
  return value
}

/**
 * Get the default value of a prop.
 */
function getPropDefaultValue (vm, prop, key) {
  // no default, return undefined
  if (!hasOwn(prop, 'default')) {
    return undefined
  }
  var def = prop.default;
  // warn against non-factory defaults for Object & Array
  if ("development" !== 'production' && isObject(def)) {
    warn(
      'Invalid default value for prop "' + key + '": ' +
      'Props with type Object/Array must use a factory function ' +
      'to return the default value.',
      vm
    );
  }
  // the raw prop value was also undefined from previous render,
  // return previous default value to avoid unnecessary watcher trigger
  if (vm && vm.$options.propsData &&
    vm.$options.propsData[key] === undefined &&
    vm._props[key] !== undefined
  ) {
    return vm._props[key]
  }
  // call factory function for non-Function types
  // a value is Function if its prototype is function even across different execution context
  return typeof def === 'function' && getType(prop.type) !== 'Function'
    ? def.call(vm)
    : def
}

/**
 * Assert whether a prop is valid.
 */
function assertProp (
  prop,
  name,
  value,
  vm,
  absent
) {
  if (prop.required && absent) {
    warn(
      'Missing required prop: "' + name + '"',
      vm
    );
    return
  }
  if (value == null && !prop.required) {
    return
  }
  var type = prop.type;
  var valid = !type || type === true;
  var expectedTypes = [];
  if (type) {
    if (!Array.isArray(type)) {
      type = [type];
    }
    for (var i = 0; i < type.length && !valid; i++) {
      var assertedType = assertType(value, type[i]);
      expectedTypes.push(assertedType.expectedType || '');
      valid = assertedType.valid;
    }
  }
  if (!valid) {
    warn(
      "Invalid prop: type check failed for prop \"" + name + "\"." +
      " Expected " + (expectedTypes.map(capitalize).join(', ')) +
      ", got " + (toRawType(value)) + ".",
      vm
    );
    return
  }
  var validator = prop.validator;
  if (validator) {
    if (!validator(value)) {
      warn(
        'Invalid prop: custom validator check failed for prop "' + name + '".',
        vm
      );
    }
  }
}

var simpleCheckRE = /^(String|Number|Boolean|Function|Symbol)$/;

function assertType (value, type) {
  var valid;
  var expectedType = getType(type);
  if (simpleCheckRE.test(expectedType)) {
    var t = typeof value;
    valid = t === expectedType.toLowerCase();
    // for primitive wrapper objects
    if (!valid && t === 'object') {
      valid = value instanceof type;
    }
  } else if (expectedType === 'Object') {
    valid = isPlainObject(value);
  } else if (expectedType === 'Array') {
    valid = Array.isArray(value);
  } else {
    valid = value instanceof type;
  }
  return {
    valid: valid,
    expectedType: expectedType
  }
}

/**
 * Use function string name to check built-in types,
 * because a simple equality check will fail when running
 * across different vms / iframes.
 */
function getType (fn) {
  var match = fn && fn.toString().match(/^\s*function (\w+)/);
  return match ? match[1] : ''
}

function isSameType (a, b) {
  return getType(a) === getType(b)
}

function getTypeIndex (type, expectedTypes) {
  if (!Array.isArray(expectedTypes)) {
    return isSameType(expectedTypes, type) ? 0 : -1
  }
  for (var i = 0, len = expectedTypes.length; i < len; i++) {
    if (isSameType(expectedTypes[i], type)) {
      return i
    }
  }
  return -1
}

/*  */

function handleError (err, vm, info) {
  if (vm) {
    var cur = vm;
    while ((cur = cur.$parent)) {
      var hooks = cur.$options.errorCaptured;
      if (hooks) {
        for (var i = 0; i < hooks.length; i++) {
          try {
            var capture = hooks[i].call(cur, err, vm, info) === false;
            if (capture) { return }
          } catch (e) {
            globalHandleError(e, cur, 'errorCaptured hook');
          }
        }
      }
    }
  }
  globalHandleError(err, vm, info);
}

function globalHandleError (err, vm, info) {
  if (config.errorHandler) {
    try {
      return config.errorHandler.call(null, err, vm, info)
    } catch (e) {
      logError(e, null, 'config.errorHandler');
    }
  }
  logError(err, vm, info);
}

function logError (err, vm, info) {
  if (true) {
    warn(("Error in " + info + ": \"" + (err.toString()) + "\""), vm);
  }
  /* istanbul ignore else */
  if ((inBrowser || inWeex) && typeof console !== 'undefined') {
    console.error(err);
  } else {
    throw err
  }
}

/*  */
/* globals MessageChannel */

var callbacks = [];
var pending = false;

function flushCallbacks () {
  pending = false;
  var copies = callbacks.slice(0);
  callbacks.length = 0;
  for (var i = 0; i < copies.length; i++) {
    copies[i]();
  }
}

// Here we have async deferring wrappers using both microtasks and (macro) tasks.
// In < 2.4 we used microtasks everywhere, but there are some scenarios where
// microtasks have too high a priority and fire in between supposedly
// sequential events (e.g. #4521, #6690) or even between bubbling of the same
// event (#6566). However, using (macro) tasks everywhere also has subtle problems
// when state is changed right before repaint (e.g. #6813, out-in transitions).
// Here we use microtask by default, but expose a way to force (macro) task when
// needed (e.g. in event handlers attached by v-on).
var microTimerFunc;
var macroTimerFunc;
var useMacroTask = false;

// Determine (macro) task defer implementation.
// Technically setImmediate should be the ideal choice, but it's only available
// in IE. The only polyfill that consistently queues the callback after all DOM
// events triggered in the same loop is by using MessageChannel.
/* istanbul ignore if */
if (typeof setImmediate !== 'undefined' && isNative(setImmediate)) {
  macroTimerFunc = function () {
    setImmediate(flushCallbacks);
  };
} else if (typeof MessageChannel !== 'undefined' && (
  isNative(MessageChannel) ||
  // PhantomJS
  MessageChannel.toString() === '[object MessageChannelConstructor]'
)) {
  var channel = new MessageChannel();
  var port = channel.port2;
  channel.port1.onmessage = flushCallbacks;
  macroTimerFunc = function () {
    port.postMessage(1);
  };
} else {
  /* istanbul ignore next */
  macroTimerFunc = function () {
    setTimeout(flushCallbacks, 0);
  };
}

// Determine microtask defer implementation.
/* istanbul ignore next, $flow-disable-line */
if (typeof Promise !== 'undefined' && isNative(Promise)) {
  var p = Promise.resolve();
  microTimerFunc = function () {
    p.then(flushCallbacks);
    // in problematic UIWebViews, Promise.then doesn't completely break, but
    // it can get stuck in a weird state where callbacks are pushed into the
    // microtask queue but the queue isn't being flushed, until the browser
    // needs to do some other work, e.g. handle a timer. Therefore we can
    // "force" the microtask queue to be flushed by adding an empty timer.
    if (isIOS) { setTimeout(noop); }
  };
} else {
  // fallback to macro
  microTimerFunc = macroTimerFunc;
}

/**
 * Wrap a function so that if any code inside triggers state change,
 * the changes are queued using a (macro) task instead of a microtask.
 */
function withMacroTask (fn) {
  return fn._withTask || (fn._withTask = function () {
    useMacroTask = true;
    var res = fn.apply(null, arguments);
    useMacroTask = false;
    return res
  })
}

function nextTick (cb, ctx) {
  var _resolve;
  callbacks.push(function () {
    if (cb) {
      try {
        cb.call(ctx);
      } catch (e) {
        handleError(e, ctx, 'nextTick');
      }
    } else if (_resolve) {
      _resolve(ctx);
    }
  });
  if (!pending) {
    pending = true;
    if (useMacroTask) {
      macroTimerFunc();
    } else {
      microTimerFunc();
    }
  }
  // $flow-disable-line
  if (!cb && typeof Promise !== 'undefined') {
    return new Promise(function (resolve) {
      _resolve = resolve;
    })
  }
}

/*  */

var mark;
var measure;

if (true) {
  var perf = inBrowser && window.performance;
  /* istanbul ignore if */
  if (
    perf &&
    perf.mark &&
    perf.measure &&
    perf.clearMarks &&
    perf.clearMeasures
  ) {
    mark = function (tag) { return perf.mark(tag); };
    measure = function (name, startTag, endTag) {
      perf.measure(name, startTag, endTag);
      perf.clearMarks(startTag);
      perf.clearMarks(endTag);
      perf.clearMeasures(name);
    };
  }
}

/* not type checking this file because flow doesn't play well with Proxy */

var initProxy;

if (true) {
  var allowedGlobals = makeMap(
    'Infinity,undefined,NaN,isFinite,isNaN,' +
    'parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,' +
    'Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,' +
    'require' // for Webpack/Browserify
  );

  var warnNonPresent = function (target, key) {
    warn(
      "Property or method \"" + key + "\" is not defined on the instance but " +
      'referenced during render. Make sure that this property is reactive, ' +
      'either in the data option, or for class-based components, by ' +
      'initializing the property. ' +
      'See: https://vuejs.org/v2/guide/reactivity.html#Declaring-Reactive-Properties.',
      target
    );
  };

  var hasProxy =
    typeof Proxy !== 'undefined' && isNative(Proxy);

  if (hasProxy) {
    var isBuiltInModifier = makeMap('stop,prevent,self,ctrl,shift,alt,meta,exact');
    config.keyCodes = new Proxy(config.keyCodes, {
      set: function set (target, key, value) {
        if (isBuiltInModifier(key)) {
          warn(("Avoid overwriting built-in modifier in config.keyCodes: ." + key));
          return false
        } else {
          target[key] = value;
          return true
        }
      }
    });
  }

  var hasHandler = {
    has: function has (target, key) {
      var has = key in target;
      var isAllowed = allowedGlobals(key) || key.charAt(0) === '_';
      if (!has && !isAllowed) {
        warnNonPresent(target, key);
      }
      return has || !isAllowed
    }
  };

  var getHandler = {
    get: function get (target, key) {
      if (typeof key === 'string' && !(key in target)) {
        warnNonPresent(target, key);
      }
      return target[key]
    }
  };

  initProxy = function initProxy (vm) {
    if (hasProxy) {
      // determine which proxy handler to use
      var options = vm.$options;
      var handlers = options.render && options.render._withStripped
        ? getHandler
        : hasHandler;
      vm._renderProxy = new Proxy(vm, handlers);
    } else {
      vm._renderProxy = vm;
    }
  };
}

/*  */

var seenObjects = new _Set();

/**
 * Recursively traverse an object to evoke all converted
 * getters, so that every nested property inside the object
 * is collected as a "deep" dependency.
 */
function traverse (val) {
  _traverse(val, seenObjects);
  seenObjects.clear();
}

function _traverse (val, seen) {
  var i, keys;
  var isA = Array.isArray(val);
  if ((!isA && !isObject(val)) || Object.isFrozen(val) || val instanceof VNode) {
    return
  }
  if (val.__ob__) {
    var depId = val.__ob__.dep.id;
    if (seen.has(depId)) {
      return
    }
    seen.add(depId);
  }
  if (isA) {
    i = val.length;
    while (i--) { _traverse(val[i], seen); }
  } else {
    keys = Object.keys(val);
    i = keys.length;
    while (i--) { _traverse(val[keys[i]], seen); }
  }
}

/*  */

var normalizeEvent = cached(function (name) {
  var passive = name.charAt(0) === '&';
  name = passive ? name.slice(1) : name;
  var once$$1 = name.charAt(0) === '~'; // Prefixed last, checked first
  name = once$$1 ? name.slice(1) : name;
  var capture = name.charAt(0) === '!';
  name = capture ? name.slice(1) : name;
  return {
    name: name,
    once: once$$1,
    capture: capture,
    passive: passive
  }
});

function createFnInvoker (fns) {
  function invoker () {
    var arguments$1 = arguments;

    var fns = invoker.fns;
    if (Array.isArray(fns)) {
      var cloned = fns.slice();
      for (var i = 0; i < cloned.length; i++) {
        cloned[i].apply(null, arguments$1);
      }
    } else {
      // return handler return value for single handlers
      return fns.apply(null, arguments)
    }
  }
  invoker.fns = fns;
  return invoker
}

function updateListeners (
  on,
  oldOn,
  add,
  remove$$1,
  vm
) {
  var name, def, cur, old, event;
  for (name in on) {
    def = cur = on[name];
    old = oldOn[name];
    event = normalizeEvent(name);
    /* istanbul ignore if */
    if (isUndef(cur)) {
      "development" !== 'production' && warn(
        "Invalid handler for event \"" + (event.name) + "\": got " + String(cur),
        vm
      );
    } else if (isUndef(old)) {
      if (isUndef(cur.fns)) {
        cur = on[name] = createFnInvoker(cur);
      }
      add(event.name, cur, event.once, event.capture, event.passive, event.params);
    } else if (cur !== old) {
      old.fns = cur;
      on[name] = old;
    }
  }
  for (name in oldOn) {
    if (isUndef(on[name])) {
      event = normalizeEvent(name);
      remove$$1(event.name, oldOn[name], event.capture);
    }
  }
}

/*  */

function mergeVNodeHook (def, hookKey, hook) {
  if (def instanceof VNode) {
    def = def.data.hook || (def.data.hook = {});
  }
  var invoker;
  var oldHook = def[hookKey];

  function wrappedHook () {
    hook.apply(this, arguments);
    // important: remove merged hook to ensure it's called only once
    // and prevent memory leak
    remove(invoker.fns, wrappedHook);
  }

  if (isUndef(oldHook)) {
    // no existing hook
    invoker = createFnInvoker([wrappedHook]);
  } else {
    /* istanbul ignore if */
    if (isDef(oldHook.fns) && isTrue(oldHook.merged)) {
      // already a merged invoker
      invoker = oldHook;
      invoker.fns.push(wrappedHook);
    } else {
      // existing plain hook
      invoker = createFnInvoker([oldHook, wrappedHook]);
    }
  }

  invoker.merged = true;
  def[hookKey] = invoker;
}

/*  */

function extractPropsFromVNodeData (
  data,
  Ctor,
  tag
) {
  // we are only extracting raw values here.
  // validation and default values are handled in the child
  // component itself.
  var propOptions = Ctor.options.props;
  if (isUndef(propOptions)) {
    return
  }
  var res = {};
  var attrs = data.attrs;
  var props = data.props;
  if (isDef(attrs) || isDef(props)) {
    for (var key in propOptions) {
      var altKey = hyphenate(key);
      if (true) {
        var keyInLowerCase = key.toLowerCase();
        if (
          key !== keyInLowerCase &&
          attrs && hasOwn(attrs, keyInLowerCase)
        ) {
          tip(
            "Prop \"" + keyInLowerCase + "\" is passed to component " +
            (formatComponentName(tag || Ctor)) + ", but the declared prop name is" +
            " \"" + key + "\". " +
            "Note that HTML attributes are case-insensitive and camelCased " +
            "props need to use their kebab-case equivalents when using in-DOM " +
            "templates. You should probably use \"" + altKey + "\" instead of \"" + key + "\"."
          );
        }
      }
      checkProp(res, props, key, altKey, true) ||
      checkProp(res, attrs, key, altKey, false);
    }
  }
  return res
}

function checkProp (
  res,
  hash,
  key,
  altKey,
  preserve
) {
  if (isDef(hash)) {
    if (hasOwn(hash, key)) {
      res[key] = hash[key];
      if (!preserve) {
        delete hash[key];
      }
      return true
    } else if (hasOwn(hash, altKey)) {
      res[key] = hash[altKey];
      if (!preserve) {
        delete hash[altKey];
      }
      return true
    }
  }
  return false
}

/*  */

// The template compiler attempts to minimize the need for normalization by
// statically analyzing the template at compile time.
//
// For plain HTML markup, normalization can be completely skipped because the
// generated render function is guaranteed to return Array<VNode>. There are
// two cases where extra normalization is needed:

// 1. When the children contains components - because a functional component
// may return an Array instead of a single root. In this case, just a simple
// normalization is needed - if any child is an Array, we flatten the whole
// thing with Array.prototype.concat. It is guaranteed to be only 1-level deep
// because functional components already normalize their own children.
function simpleNormalizeChildren (children) {
  for (var i = 0; i < children.length; i++) {
    if (Array.isArray(children[i])) {
      return Array.prototype.concat.apply([], children)
    }
  }
  return children
}

// 2. When the children contains constructs that always generated nested Arrays,
// e.g. <template>, <slot>, v-for, or when the children is provided by user
// with hand-written render functions / JSX. In such cases a full normalization
// is needed to cater to all possible types of children values.
function normalizeChildren (children) {
  return isPrimitive(children)
    ? [createTextVNode(children)]
    : Array.isArray(children)
      ? normalizeArrayChildren(children)
      : undefined
}

function isTextNode (node) {
  return isDef(node) && isDef(node.text) && isFalse(node.isComment)
}

function normalizeArrayChildren (children, nestedIndex) {
  var res = [];
  var i, c, lastIndex, last;
  for (i = 0; i < children.length; i++) {
    c = children[i];
    if (isUndef(c) || typeof c === 'boolean') { continue }
    lastIndex = res.length - 1;
    last = res[lastIndex];
    //  nested
    if (Array.isArray(c)) {
      if (c.length > 0) {
        c = normalizeArrayChildren(c, ((nestedIndex || '') + "_" + i));
        // merge adjacent text nodes
        if (isTextNode(c[0]) && isTextNode(last)) {
          res[lastIndex] = createTextVNode(last.text + (c[0]).text);
          c.shift();
        }
        res.push.apply(res, c);
      }
    } else if (isPrimitive(c)) {
      if (isTextNode(last)) {
        // merge adjacent text nodes
        // this is necessary for SSR hydration because text nodes are
        // essentially merged when rendered to HTML strings
        res[lastIndex] = createTextVNode(last.text + c);
      } else if (c !== '') {
        // convert primitive to vnode
        res.push(createTextVNode(c));
      }
    } else {
      if (isTextNode(c) && isTextNode(last)) {
        // merge adjacent text nodes
        res[lastIndex] = createTextVNode(last.text + c.text);
      } else {
        // default key for nested array children (likely generated by v-for)
        if (isTrue(children._isVList) &&
          isDef(c.tag) &&
          isUndef(c.key) &&
          isDef(nestedIndex)) {
          c.key = "__vlist" + nestedIndex + "_" + i + "__";
        }
        res.push(c);
      }
    }
  }
  return res
}

/*  */

function ensureCtor (comp, base) {
  if (
    comp.__esModule ||
    (hasSymbol && comp[Symbol.toStringTag] === 'Module')
  ) {
    comp = comp.default;
  }
  return isObject(comp)
    ? base.extend(comp)
    : comp
}

function createAsyncPlaceholder (
  factory,
  data,
  context,
  children,
  tag
) {
  var node = createEmptyVNode();
  node.asyncFactory = factory;
  node.asyncMeta = { data: data, context: context, children: children, tag: tag };
  return node
}

function resolveAsyncComponent (
  factory,
  baseCtor,
  context
) {
  if (isTrue(factory.error) && isDef(factory.errorComp)) {
    return factory.errorComp
  }

  if (isDef(factory.resolved)) {
    return factory.resolved
  }

  if (isTrue(factory.loading) && isDef(factory.loadingComp)) {
    return factory.loadingComp
  }

  if (isDef(factory.contexts)) {
    // already pending
    factory.contexts.push(context);
  } else {
    var contexts = factory.contexts = [context];
    var sync = true;

    var forceRender = function () {
      for (var i = 0, l = contexts.length; i < l; i++) {
        contexts[i].$forceUpdate();
      }
    };

    var resolve = once(function (res) {
      // cache resolved
      factory.resolved = ensureCtor(res, baseCtor);
      // invoke callbacks only if this is not a synchronous resolve
      // (async resolves are shimmed as synchronous during SSR)
      if (!sync) {
        forceRender();
      }
    });

    var reject = once(function (reason) {
      "development" !== 'production' && warn(
        "Failed to resolve async component: " + (String(factory)) +
        (reason ? ("\nReason: " + reason) : '')
      );
      if (isDef(factory.errorComp)) {
        factory.error = true;
        forceRender();
      }
    });

    var res = factory(resolve, reject);

    if (isObject(res)) {
      if (typeof res.then === 'function') {
        // () => Promise
        if (isUndef(factory.resolved)) {
          res.then(resolve, reject);
        }
      } else if (isDef(res.component) && typeof res.component.then === 'function') {
        res.component.then(resolve, reject);

        if (isDef(res.error)) {
          factory.errorComp = ensureCtor(res.error, baseCtor);
        }

        if (isDef(res.loading)) {
          factory.loadingComp = ensureCtor(res.loading, baseCtor);
          if (res.delay === 0) {
            factory.loading = true;
          } else {
            setTimeout(function () {
              if (isUndef(factory.resolved) && isUndef(factory.error)) {
                factory.loading = true;
                forceRender();
              }
            }, res.delay || 200);
          }
        }

        if (isDef(res.timeout)) {
          setTimeout(function () {
            if (isUndef(factory.resolved)) {
              reject(
                 true
                  ? ("timeout (" + (res.timeout) + "ms)")
                  : null
              );
            }
          }, res.timeout);
        }
      }
    }

    sync = false;
    // return in case resolved synchronously
    return factory.loading
      ? factory.loadingComp
      : factory.resolved
  }
}

/*  */

function isAsyncPlaceholder (node) {
  return node.isComment && node.asyncFactory
}

/*  */

function getFirstComponentChild (children) {
  if (Array.isArray(children)) {
    for (var i = 0; i < children.length; i++) {
      var c = children[i];
      if (isDef(c) && (isDef(c.componentOptions) || isAsyncPlaceholder(c))) {
        return c
      }
    }
  }
}

/*  */

/*  */

function initEvents (vm) {
  vm._events = Object.create(null);
  vm._hasHookEvent = false;
  // init parent attached events
  var listeners = vm.$options._parentListeners;
  if (listeners) {
    updateComponentListeners(vm, listeners);
  }
}

var target;

function add (event, fn, once) {
  if (once) {
    target.$once(event, fn);
  } else {
    target.$on(event, fn);
  }
}

function remove$1 (event, fn) {
  target.$off(event, fn);
}

function updateComponentListeners (
  vm,
  listeners,
  oldListeners
) {
  target = vm;
  updateListeners(listeners, oldListeners || {}, add, remove$1, vm);
  target = undefined;
}

function eventsMixin (Vue) {
  var hookRE = /^hook:/;
  Vue.prototype.$on = function (event, fn) {
    var this$1 = this;

    var vm = this;
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        this$1.$on(event[i], fn);
      }
    } else {
      (vm._events[event] || (vm._events[event] = [])).push(fn);
      // optimize hook:event cost by using a boolean flag marked at registration
      // instead of a hash lookup
      if (hookRE.test(event)) {
        vm._hasHookEvent = true;
      }
    }
    return vm
  };

  Vue.prototype.$once = function (event, fn) {
    var vm = this;
    function on () {
      vm.$off(event, on);
      fn.apply(vm, arguments);
    }
    on.fn = fn;
    vm.$on(event, on);
    return vm
  };

  Vue.prototype.$off = function (event, fn) {
    var this$1 = this;

    var vm = this;
    // all
    if (!arguments.length) {
      vm._events = Object.create(null);
      return vm
    }
    // array of events
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        this$1.$off(event[i], fn);
      }
      return vm
    }
    // specific event
    var cbs = vm._events[event];
    if (!cbs) {
      return vm
    }
    if (!fn) {
      vm._events[event] = null;
      return vm
    }
    if (fn) {
      // specific handler
      var cb;
      var i$1 = cbs.length;
      while (i$1--) {
        cb = cbs[i$1];
        if (cb === fn || cb.fn === fn) {
          cbs.splice(i$1, 1);
          break
        }
      }
    }
    return vm
  };

  Vue.prototype.$emit = function (event) {
    var vm = this;
    if (true) {
      var lowerCaseEvent = event.toLowerCase();
      if (lowerCaseEvent !== event && vm._events[lowerCaseEvent]) {
        tip(
          "Event \"" + lowerCaseEvent + "\" is emitted in component " +
          (formatComponentName(vm)) + " but the handler is registered for \"" + event + "\". " +
          "Note that HTML attributes are case-insensitive and you cannot use " +
          "v-on to listen to camelCase events when using in-DOM templates. " +
          "You should probably use \"" + (hyphenate(event)) + "\" instead of \"" + event + "\"."
        );
      }
    }
    var cbs = vm._events[event];
    if (cbs) {
      cbs = cbs.length > 1 ? toArray(cbs) : cbs;
      var args = toArray(arguments, 1);
      for (var i = 0, l = cbs.length; i < l; i++) {
        try {
          cbs[i].apply(vm, args);
        } catch (e) {
          handleError(e, vm, ("event handler for \"" + event + "\""));
        }
      }
    }
    return vm
  };
}

/*  */



/**
 * Runtime helper for resolving raw children VNodes into a slot object.
 */
function resolveSlots (
  children,
  context
) {
  var slots = {};
  if (!children) {
    return slots
  }
  for (var i = 0, l = children.length; i < l; i++) {
    var child = children[i];
    var data = child.data;
    // remove slot attribute if the node is resolved as a Vue slot node
    if (data && data.attrs && data.attrs.slot) {
      delete data.attrs.slot;
    }
    // named slots should only be respected if the vnode was rendered in the
    // same context.
    if ((child.context === context || child.fnContext === context) &&
      data && data.slot != null
    ) {
      var name = data.slot;
      var slot = (slots[name] || (slots[name] = []));
      if (child.tag === 'template') {
        slot.push.apply(slot, child.children || []);
      } else {
        slot.push(child);
      }
    } else {
      (slots.default || (slots.default = [])).push(child);
    }
  }
  // ignore slots that contains only whitespace
  for (var name$1 in slots) {
    if (slots[name$1].every(isWhitespace)) {
      delete slots[name$1];
    }
  }
  return slots
}

function isWhitespace (node) {
  return (node.isComment && !node.asyncFactory) || node.text === ' '
}

function resolveScopedSlots (
  fns, // see flow/vnode
  res
) {
  res = res || {};
  for (var i = 0; i < fns.length; i++) {
    if (Array.isArray(fns[i])) {
      resolveScopedSlots(fns[i], res);
    } else {
      res[fns[i].key] = fns[i].fn;
    }
  }
  return res
}

/*  */

var activeInstance = null;
var isUpdatingChildComponent = false;

function initLifecycle (vm) {
  var options = vm.$options;

  // locate first non-abstract parent
  var parent = options.parent;
  if (parent && !options.abstract) {
    while (parent.$options.abstract && parent.$parent) {
      parent = parent.$parent;
    }
    parent.$children.push(vm);
  }

  vm.$parent = parent;
  vm.$root = parent ? parent.$root : vm;

  vm.$children = [];
  vm.$refs = {};

  vm._watcher = null;
  vm._inactive = null;
  vm._directInactive = false;
  vm._isMounted = false;
  vm._isDestroyed = false;
  vm._isBeingDestroyed = false;
}

function lifecycleMixin (Vue) {
  Vue.prototype._update = function (vnode, hydrating) {
    var vm = this;
    if (vm._isMounted) {
      callHook(vm, 'beforeUpdate');
    }
    var prevEl = vm.$el;
    var prevVnode = vm._vnode;
    var prevActiveInstance = activeInstance;
    activeInstance = vm;
    vm._vnode = vnode;
    // Vue.prototype.__patch__ is injected in entry points
    // based on the rendering backend used.
    if (!prevVnode) {
      // initial render
      vm.$el = vm.__patch__(
        vm.$el, vnode, hydrating, false /* removeOnly */,
        vm.$options._parentElm,
        vm.$options._refElm
      );
      // no need for the ref nodes after initial patch
      // this prevents keeping a detached DOM tree in memory (#5851)
      vm.$options._parentElm = vm.$options._refElm = null;
    } else {
      // updates
      vm.$el = vm.__patch__(prevVnode, vnode);
    }
    activeInstance = prevActiveInstance;
    // update __vue__ reference
    if (prevEl) {
      prevEl.__vue__ = null;
    }
    if (vm.$el) {
      vm.$el.__vue__ = vm;
    }
    // if parent is an HOC, update its $el as well
    if (vm.$vnode && vm.$parent && vm.$vnode === vm.$parent._vnode) {
      vm.$parent.$el = vm.$el;
    }
    // updated hook is called by the scheduler to ensure that children are
    // updated in a parent's updated hook.
  };

  Vue.prototype.$forceUpdate = function () {
    var vm = this;
    if (vm._watcher) {
      vm._watcher.update();
    }
  };

  Vue.prototype.$destroy = function () {
    var vm = this;
    if (vm._isBeingDestroyed) {
      return
    }
    callHook(vm, 'beforeDestroy');
    vm._isBeingDestroyed = true;
    // remove self from parent
    var parent = vm.$parent;
    if (parent && !parent._isBeingDestroyed && !vm.$options.abstract) {
      remove(parent.$children, vm);
    }
    // teardown watchers
    if (vm._watcher) {
      vm._watcher.teardown();
    }
    var i = vm._watchers.length;
    while (i--) {
      vm._watchers[i].teardown();
    }
    // remove reference from data ob
    // frozen object may not have observer.
    if (vm._data.__ob__) {
      vm._data.__ob__.vmCount--;
    }
    // call the last hook...
    vm._isDestroyed = true;
    // invoke destroy hooks on current rendered tree
    vm.__patch__(vm._vnode, null);
    // fire destroyed hook
    callHook(vm, 'destroyed');
    // turn off all instance listeners.
    vm.$off();
    // remove __vue__ reference
    if (vm.$el) {
      vm.$el.__vue__ = null;
    }
    // release circular reference (#6759)
    if (vm.$vnode) {
      vm.$vnode.parent = null;
    }
  };
}

function mountComponent (
  vm,
  el,
  hydrating
) {
  vm.$el = el;
  if (!vm.$options.render) {
    vm.$options.render = createEmptyVNode;
    if (true) {
      /* istanbul ignore if */
      if ((vm.$options.template && vm.$options.template.charAt(0) !== '#') ||
        vm.$options.el || el) {
        warn(
          'You are using the runtime-only build of Vue where the template ' +
          'compiler is not available. Either pre-compile the templates into ' +
          'render functions, or use the compiler-included build.',
          vm
        );
      } else {
        warn(
          'Failed to mount component: template or render function not defined.',
          vm
        );
      }
    }
  }
  callHook(vm, 'beforeMount');

  var updateComponent;
  /* istanbul ignore if */
  if ("development" !== 'production' && config.performance && mark) {
    updateComponent = function () {
      var name = vm._name;
      var id = vm._uid;
      var startTag = "vue-perf-start:" + id;
      var endTag = "vue-perf-end:" + id;

      mark(startTag);
      var vnode = vm._render();
      mark(endTag);
      measure(("vue " + name + " render"), startTag, endTag);

      mark(startTag);
      vm._update(vnode, hydrating);
      mark(endTag);
      measure(("vue " + name + " patch"), startTag, endTag);
    };
  } else {
    updateComponent = function () {
      vm._update(vm._render(), hydrating);
    };
  }

  // we set this to vm._watcher inside the watcher's constructor
  // since the watcher's initial patch may call $forceUpdate (e.g. inside child
  // component's mounted hook), which relies on vm._watcher being already defined
  new Watcher(vm, updateComponent, noop, null, true /* isRenderWatcher */);
  hydrating = false;

  // manually mounted instance, call mounted on self
  // mounted is called for render-created child components in its inserted hook
  if (vm.$vnode == null) {
    vm._isMounted = true;
    callHook(vm, 'mounted');
  }
  return vm
}

function updateChildComponent (
  vm,
  propsData,
  listeners,
  parentVnode,
  renderChildren
) {
  if (true) {
    isUpdatingChildComponent = true;
  }

  // determine whether component has slot children
  // we need to do this before overwriting $options._renderChildren
  var hasChildren = !!(
    renderChildren ||               // has new static slots
    vm.$options._renderChildren ||  // has old static slots
    parentVnode.data.scopedSlots || // has new scoped slots
    vm.$scopedSlots !== emptyObject // has old scoped slots
  );

  vm.$options._parentVnode = parentVnode;
  vm.$vnode = parentVnode; // update vm's placeholder node without re-render

  if (vm._vnode) { // update child tree's parent
    vm._vnode.parent = parentVnode;
  }
  vm.$options._renderChildren = renderChildren;

  // update $attrs and $listeners hash
  // these are also reactive so they may trigger child update if the child
  // used them during render
  vm.$attrs = parentVnode.data.attrs || emptyObject;
  vm.$listeners = listeners || emptyObject;

  // update props
  if (propsData && vm.$options.props) {
    toggleObserving(false);
    var props = vm._props;
    var propKeys = vm.$options._propKeys || [];
    for (var i = 0; i < propKeys.length; i++) {
      var key = propKeys[i];
      var propOptions = vm.$options.props; // wtf flow?
      props[key] = validateProp(key, propOptions, propsData, vm);
    }
    toggleObserving(true);
    // keep a copy of raw propsData
    vm.$options.propsData = propsData;
  }

  // update listeners
  listeners = listeners || emptyObject;
  var oldListeners = vm.$options._parentListeners;
  vm.$options._parentListeners = listeners;
  updateComponentListeners(vm, listeners, oldListeners);

  // resolve slots + force update if has children
  if (hasChildren) {
    vm.$slots = resolveSlots(renderChildren, parentVnode.context);
    vm.$forceUpdate();
  }

  if (true) {
    isUpdatingChildComponent = false;
  }
}

function isInInactiveTree (vm) {
  while (vm && (vm = vm.$parent)) {
    if (vm._inactive) { return true }
  }
  return false
}

function activateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = false;
    if (isInInactiveTree(vm)) {
      return
    }
  } else if (vm._directInactive) {
    return
  }
  if (vm._inactive || vm._inactive === null) {
    vm._inactive = false;
    for (var i = 0; i < vm.$children.length; i++) {
      activateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'activated');
  }
}

function deactivateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = true;
    if (isInInactiveTree(vm)) {
      return
    }
  }
  if (!vm._inactive) {
    vm._inactive = true;
    for (var i = 0; i < vm.$children.length; i++) {
      deactivateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'deactivated');
  }
}

function callHook (vm, hook) {
  // #7573 disable dep collection when invoking lifecycle hooks
  pushTarget();
  var handlers = vm.$options[hook];
  if (handlers) {
    for (var i = 0, j = handlers.length; i < j; i++) {
      try {
        handlers[i].call(vm);
      } catch (e) {
        handleError(e, vm, (hook + " hook"));
      }
    }
  }
  if (vm._hasHookEvent) {
    vm.$emit('hook:' + hook);
  }
  popTarget();
}

/*  */


var MAX_UPDATE_COUNT = 100;

var queue = [];
var activatedChildren = [];
var has = {};
var circular = {};
var waiting = false;
var flushing = false;
var index = 0;

/**
 * Reset the scheduler's state.
 */
function resetSchedulerState () {
  index = queue.length = activatedChildren.length = 0;
  has = {};
  if (true) {
    circular = {};
  }
  waiting = flushing = false;
}

/**
 * Flush both queues and run the watchers.
 */
function flushSchedulerQueue () {
  flushing = true;
  var watcher, id;

  // Sort queue before flush.
  // This ensures that:
  // 1. Components are updated from parent to child. (because parent is always
  //    created before the child)
  // 2. A component's user watchers are run before its render watcher (because
  //    user watchers are created before the render watcher)
  // 3. If a component is destroyed during a parent component's watcher run,
  //    its watchers can be skipped.
  queue.sort(function (a, b) { return a.id - b.id; });

  // do not cache length because more watchers might be pushed
  // as we run existing watchers
  for (index = 0; index < queue.length; index++) {
    watcher = queue[index];
    id = watcher.id;
    has[id] = null;
    watcher.run();
    // in dev build, check and stop circular updates.
    if ("development" !== 'production' && has[id] != null) {
      circular[id] = (circular[id] || 0) + 1;
      if (circular[id] > MAX_UPDATE_COUNT) {
        warn(
          'You may have an infinite update loop ' + (
            watcher.user
              ? ("in watcher with expression \"" + (watcher.expression) + "\"")
              : "in a component render function."
          ),
          watcher.vm
        );
        break
      }
    }
  }

  // keep copies of post queues before resetting state
  var activatedQueue = activatedChildren.slice();
  var updatedQueue = queue.slice();

  resetSchedulerState();

  // call component updated and activated hooks
  callActivatedHooks(activatedQueue);
  callUpdatedHooks(updatedQueue);

  // devtool hook
  /* istanbul ignore if */
  if (devtools && config.devtools) {
    devtools.emit('flush');
  }
}

function callUpdatedHooks (queue) {
  var i = queue.length;
  while (i--) {
    var watcher = queue[i];
    var vm = watcher.vm;
    if (vm._watcher === watcher && vm._isMounted) {
      callHook(vm, 'updated');
    }
  }
}

/**
 * Queue a kept-alive component that was activated during patch.
 * The queue will be processed after the entire tree has been patched.
 */
function queueActivatedComponent (vm) {
  // setting _inactive to false here so that a render function can
  // rely on checking whether it's in an inactive tree (e.g. router-view)
  vm._inactive = false;
  activatedChildren.push(vm);
}

function callActivatedHooks (queue) {
  for (var i = 0; i < queue.length; i++) {
    queue[i]._inactive = true;
    activateChildComponent(queue[i], true /* true */);
  }
}

/**
 * Push a watcher into the watcher queue.
 * Jobs with duplicate IDs will be skipped unless it's
 * pushed when the queue is being flushed.
 */
function queueWatcher (watcher) {
  var id = watcher.id;
  if (has[id] == null) {
    has[id] = true;
    if (!flushing) {
      queue.push(watcher);
    } else {
      // if already flushing, splice the watcher based on its id
      // if already past its id, it will be run next immediately.
      var i = queue.length - 1;
      while (i > index && queue[i].id > watcher.id) {
        i--;
      }
      queue.splice(i + 1, 0, watcher);
    }
    // queue the flush
    if (!waiting) {
      waiting = true;
      nextTick(flushSchedulerQueue);
    }
  }
}

/*  */

var uid$1 = 0;

/**
 * A watcher parses an expression, collects dependencies,
 * and fires callback when the expression value changes.
 * This is used for both the $watch() api and directives.
 */
var Watcher = function Watcher (
  vm,
  expOrFn,
  cb,
  options,
  isRenderWatcher
) {
  this.vm = vm;
  if (isRenderWatcher) {
    vm._watcher = this;
  }
  vm._watchers.push(this);
  // options
  if (options) {
    this.deep = !!options.deep;
    this.user = !!options.user;
    this.lazy = !!options.lazy;
    this.sync = !!options.sync;
  } else {
    this.deep = this.user = this.lazy = this.sync = false;
  }
  this.cb = cb;
  this.id = ++uid$1; // uid for batching
  this.active = true;
  this.dirty = this.lazy; // for lazy watchers
  this.deps = [];
  this.newDeps = [];
  this.depIds = new _Set();
  this.newDepIds = new _Set();
  this.expression =  true
    ? expOrFn.toString()
    : '';
  // parse expression for getter
  if (typeof expOrFn === 'function') {
    this.getter = expOrFn;
  } else {
    this.getter = parsePath(expOrFn);
    if (!this.getter) {
      this.getter = function () {};
      "development" !== 'production' && warn(
        "Failed watching path: \"" + expOrFn + "\" " +
        'Watcher only accepts simple dot-delimited paths. ' +
        'For full control, use a function instead.',
        vm
      );
    }
  }
  this.value = this.lazy
    ? undefined
    : this.get();
};

/**
 * Evaluate the getter, and re-collect dependencies.
 */
Watcher.prototype.get = function get () {
  pushTarget(this);
  var value;
  var vm = this.vm;
  try {
    value = this.getter.call(vm, vm);
  } catch (e) {
    if (this.user) {
      handleError(e, vm, ("getter for watcher \"" + (this.expression) + "\""));
    } else {
      throw e
    }
  } finally {
    // "touch" every property so they are all tracked as
    // dependencies for deep watching
    if (this.deep) {
      traverse(value);
    }
    popTarget();
    this.cleanupDeps();
  }
  return value
};

/**
 * Add a dependency to this directive.
 */
Watcher.prototype.addDep = function addDep (dep) {
  var id = dep.id;
  if (!this.newDepIds.has(id)) {
    this.newDepIds.add(id);
    this.newDeps.push(dep);
    if (!this.depIds.has(id)) {
      dep.addSub(this);
    }
  }
};

/**
 * Clean up for dependency collection.
 */
Watcher.prototype.cleanupDeps = function cleanupDeps () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    var dep = this$1.deps[i];
    if (!this$1.newDepIds.has(dep.id)) {
      dep.removeSub(this$1);
    }
  }
  var tmp = this.depIds;
  this.depIds = this.newDepIds;
  this.newDepIds = tmp;
  this.newDepIds.clear();
  tmp = this.deps;
  this.deps = this.newDeps;
  this.newDeps = tmp;
  this.newDeps.length = 0;
};

/**
 * Subscriber interface.
 * Will be called when a dependency changes.
 */
Watcher.prototype.update = function update () {
  /* istanbul ignore else */
  if (this.lazy) {
    this.dirty = true;
  } else if (this.sync) {
    this.run();
  } else {
    queueWatcher(this);
  }
};

/**
 * Scheduler job interface.
 * Will be called by the scheduler.
 */
Watcher.prototype.run = function run () {
  if (this.active) {
    var value = this.get();
    if (
      value !== this.value ||
      // Deep watchers and watchers on Object/Arrays should fire even
      // when the value is the same, because the value may
      // have mutated.
      isObject(value) ||
      this.deep
    ) {
      // set new value
      var oldValue = this.value;
      this.value = value;
      if (this.user) {
        try {
          this.cb.call(this.vm, value, oldValue);
        } catch (e) {
          handleError(e, this.vm, ("callback for watcher \"" + (this.expression) + "\""));
        }
      } else {
        this.cb.call(this.vm, value, oldValue);
      }
    }
  }
};

/**
 * Evaluate the value of the watcher.
 * This only gets called for lazy watchers.
 */
Watcher.prototype.evaluate = function evaluate () {
  this.value = this.get();
  this.dirty = false;
};

/**
 * Depend on all deps collected by this watcher.
 */
Watcher.prototype.depend = function depend () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    this$1.deps[i].depend();
  }
};

/**
 * Remove self from all dependencies' subscriber list.
 */
Watcher.prototype.teardown = function teardown () {
    var this$1 = this;

  if (this.active) {
    // remove self from vm's watcher list
    // this is a somewhat expensive operation so we skip it
    // if the vm is being destroyed.
    if (!this.vm._isBeingDestroyed) {
      remove(this.vm._watchers, this);
    }
    var i = this.deps.length;
    while (i--) {
      this$1.deps[i].removeSub(this$1);
    }
    this.active = false;
  }
};

/*  */

var sharedPropertyDefinition = {
  enumerable: true,
  configurable: true,
  get: noop,
  set: noop
};

function proxy (target, sourceKey, key) {
  sharedPropertyDefinition.get = function proxyGetter () {
    return this[sourceKey][key]
  };
  sharedPropertyDefinition.set = function proxySetter (val) {
    this[sourceKey][key] = val;
  };
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function initState (vm) {
  vm._watchers = [];
  var opts = vm.$options;
  if (opts.props) { initProps(vm, opts.props); }
  if (opts.methods) { initMethods(vm, opts.methods); }
  if (opts.data) {
    initData(vm);
  } else {
    observe(vm._data = {}, true /* asRootData */);
  }
  if (opts.computed) { initComputed(vm, opts.computed); }
  if (opts.watch && opts.watch !== nativeWatch) {
    initWatch(vm, opts.watch);
  }
}

function initProps (vm, propsOptions) {
  var propsData = vm.$options.propsData || {};
  var props = vm._props = {};
  // cache prop keys so that future props updates can iterate using Array
  // instead of dynamic object key enumeration.
  var keys = vm.$options._propKeys = [];
  var isRoot = !vm.$parent;
  // root instance props should be converted
  if (!isRoot) {
    toggleObserving(false);
  }
  var loop = function ( key ) {
    keys.push(key);
    var value = validateProp(key, propsOptions, propsData, vm);
    /* istanbul ignore else */
    if (true) {
      var hyphenatedKey = hyphenate(key);
      if (isReservedAttribute(hyphenatedKey) ||
          config.isReservedAttr(hyphenatedKey)) {
        warn(
          ("\"" + hyphenatedKey + "\" is a reserved attribute and cannot be used as component prop."),
          vm
        );
      }
      defineReactive(props, key, value, function () {
        if (vm.$parent && !isUpdatingChildComponent) {
          warn(
            "Avoid mutating a prop directly since the value will be " +
            "overwritten whenever the parent component re-renders. " +
            "Instead, use a data or computed property based on the prop's " +
            "value. Prop being mutated: \"" + key + "\"",
            vm
          );
        }
      });
    } else {
      defineReactive(props, key, value);
    }
    // static props are already proxied on the component's prototype
    // during Vue.extend(). We only need to proxy props defined at
    // instantiation here.
    if (!(key in vm)) {
      proxy(vm, "_props", key);
    }
  };

  for (var key in propsOptions) loop( key );
  toggleObserving(true);
}

function initData (vm) {
  var data = vm.$options.data;
  data = vm._data = typeof data === 'function'
    ? getData(data, vm)
    : data || {};
  if (!isPlainObject(data)) {
    data = {};
    "development" !== 'production' && warn(
      'data functions should return an object:\n' +
      'https://vuejs.org/v2/guide/components.html#data-Must-Be-a-Function',
      vm
    );
  }
  // proxy data on instance
  var keys = Object.keys(data);
  var props = vm.$options.props;
  var methods = vm.$options.methods;
  var i = keys.length;
  while (i--) {
    var key = keys[i];
    if (true) {
      if (methods && hasOwn(methods, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a data property."),
          vm
        );
      }
    }
    if (props && hasOwn(props, key)) {
      "development" !== 'production' && warn(
        "The data property \"" + key + "\" is already declared as a prop. " +
        "Use prop default value instead.",
        vm
      );
    } else if (!isReserved(key)) {
      proxy(vm, "_data", key);
    }
  }
  // observe data
  observe(data, true /* asRootData */);
}

function getData (data, vm) {
  // #7573 disable dep collection when invoking data getters
  pushTarget();
  try {
    return data.call(vm, vm)
  } catch (e) {
    handleError(e, vm, "data()");
    return {}
  } finally {
    popTarget();
  }
}

var computedWatcherOptions = { lazy: true };

function initComputed (vm, computed) {
  // $flow-disable-line
  var watchers = vm._computedWatchers = Object.create(null);
  // computed properties are just getters during SSR
  var isSSR = isServerRendering();

  for (var key in computed) {
    var userDef = computed[key];
    var getter = typeof userDef === 'function' ? userDef : userDef.get;
    if ("development" !== 'production' && getter == null) {
      warn(
        ("Getter is missing for computed property \"" + key + "\"."),
        vm
      );
    }

    if (!isSSR) {
      // create internal watcher for the computed property.
      watchers[key] = new Watcher(
        vm,
        getter || noop,
        noop,
        computedWatcherOptions
      );
    }

    // component-defined computed properties are already defined on the
    // component prototype. We only need to define computed properties defined
    // at instantiation here.
    if (!(key in vm)) {
      defineComputed(vm, key, userDef);
    } else if (true) {
      if (key in vm.$data) {
        warn(("The computed property \"" + key + "\" is already defined in data."), vm);
      } else if (vm.$options.props && key in vm.$options.props) {
        warn(("The computed property \"" + key + "\" is already defined as a prop."), vm);
      }
    }
  }
}

function defineComputed (
  target,
  key,
  userDef
) {
  var shouldCache = !isServerRendering();
  if (typeof userDef === 'function') {
    sharedPropertyDefinition.get = shouldCache
      ? createComputedGetter(key)
      : userDef;
    sharedPropertyDefinition.set = noop;
  } else {
    sharedPropertyDefinition.get = userDef.get
      ? shouldCache && userDef.cache !== false
        ? createComputedGetter(key)
        : userDef.get
      : noop;
    sharedPropertyDefinition.set = userDef.set
      ? userDef.set
      : noop;
  }
  if ("development" !== 'production' &&
      sharedPropertyDefinition.set === noop) {
    sharedPropertyDefinition.set = function () {
      warn(
        ("Computed property \"" + key + "\" was assigned to but it has no setter."),
        this
      );
    };
  }
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function createComputedGetter (key) {
  return function computedGetter () {
    var watcher = this._computedWatchers && this._computedWatchers[key];
    if (watcher) {
      if (watcher.dirty) {
        watcher.evaluate();
      }
      if (Dep.target) {
        watcher.depend();
      }
      return watcher.value
    }
  }
}

function initMethods (vm, methods) {
  var props = vm.$options.props;
  for (var key in methods) {
    if (true) {
      if (methods[key] == null) {
        warn(
          "Method \"" + key + "\" has an undefined value in the component definition. " +
          "Did you reference the function correctly?",
          vm
        );
      }
      if (props && hasOwn(props, key)) {
        warn(
          ("Method \"" + key + "\" has already been defined as a prop."),
          vm
        );
      }
      if ((key in vm) && isReserved(key)) {
        warn(
          "Method \"" + key + "\" conflicts with an existing Vue instance method. " +
          "Avoid defining component methods that start with _ or $."
        );
      }
    }
    vm[key] = methods[key] == null ? noop : bind(methods[key], vm);
  }
}

function initWatch (vm, watch) {
  for (var key in watch) {
    var handler = watch[key];
    if (Array.isArray(handler)) {
      for (var i = 0; i < handler.length; i++) {
        createWatcher(vm, key, handler[i]);
      }
    } else {
      createWatcher(vm, key, handler);
    }
  }
}

function createWatcher (
  vm,
  expOrFn,
  handler,
  options
) {
  if (isPlainObject(handler)) {
    options = handler;
    handler = handler.handler;
  }
  if (typeof handler === 'string') {
    handler = vm[handler];
  }
  return vm.$watch(expOrFn, handler, options)
}

function stateMixin (Vue) {
  // flow somehow has problems with directly declared definition object
  // when using Object.defineProperty, so we have to procedurally build up
  // the object here.
  var dataDef = {};
  dataDef.get = function () { return this._data };
  var propsDef = {};
  propsDef.get = function () { return this._props };
  if (true) {
    dataDef.set = function (newData) {
      warn(
        'Avoid replacing instance root $data. ' +
        'Use nested data properties instead.',
        this
      );
    };
    propsDef.set = function () {
      warn("$props is readonly.", this);
    };
  }
  Object.defineProperty(Vue.prototype, '$data', dataDef);
  Object.defineProperty(Vue.prototype, '$props', propsDef);

  Vue.prototype.$set = set;
  Vue.prototype.$delete = del;

  Vue.prototype.$watch = function (
    expOrFn,
    cb,
    options
  ) {
    var vm = this;
    if (isPlainObject(cb)) {
      return createWatcher(vm, expOrFn, cb, options)
    }
    options = options || {};
    options.user = true;
    var watcher = new Watcher(vm, expOrFn, cb, options);
    if (options.immediate) {
      cb.call(vm, watcher.value);
    }
    return function unwatchFn () {
      watcher.teardown();
    }
  };
}

/*  */

function initProvide (vm) {
  var provide = vm.$options.provide;
  if (provide) {
    vm._provided = typeof provide === 'function'
      ? provide.call(vm)
      : provide;
  }
}

function initInjections (vm) {
  var result = resolveInject(vm.$options.inject, vm);
  if (result) {
    toggleObserving(false);
    Object.keys(result).forEach(function (key) {
      /* istanbul ignore else */
      if (true) {
        defineReactive(vm, key, result[key], function () {
          warn(
            "Avoid mutating an injected value directly since the changes will be " +
            "overwritten whenever the provided component re-renders. " +
            "injection being mutated: \"" + key + "\"",
            vm
          );
        });
      } else {
        defineReactive(vm, key, result[key]);
      }
    });
    toggleObserving(true);
  }
}

function resolveInject (inject, vm) {
  if (inject) {
    // inject is :any because flow is not smart enough to figure out cached
    var result = Object.create(null);
    var keys = hasSymbol
      ? Reflect.ownKeys(inject).filter(function (key) {
        /* istanbul ignore next */
        return Object.getOwnPropertyDescriptor(inject, key).enumerable
      })
      : Object.keys(inject);

    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      var provideKey = inject[key].from;
      var source = vm;
      while (source) {
        if (source._provided && hasOwn(source._provided, provideKey)) {
          result[key] = source._provided[provideKey];
          break
        }
        source = source.$parent;
      }
      if (!source) {
        if ('default' in inject[key]) {
          var provideDefault = inject[key].default;
          result[key] = typeof provideDefault === 'function'
            ? provideDefault.call(vm)
            : provideDefault;
        } else if (true) {
          warn(("Injection \"" + key + "\" not found"), vm);
        }
      }
    }
    return result
  }
}

/*  */

/**
 * Runtime helper for rendering v-for lists.
 */
function renderList (
  val,
  render
) {
  var ret, i, l, keys, key;
  if (Array.isArray(val) || typeof val === 'string') {
    ret = new Array(val.length);
    for (i = 0, l = val.length; i < l; i++) {
      ret[i] = render(val[i], i);
    }
  } else if (typeof val === 'number') {
    ret = new Array(val);
    for (i = 0; i < val; i++) {
      ret[i] = render(i + 1, i);
    }
  } else if (isObject(val)) {
    keys = Object.keys(val);
    ret = new Array(keys.length);
    for (i = 0, l = keys.length; i < l; i++) {
      key = keys[i];
      ret[i] = render(val[key], key, i);
    }
  }
  if (isDef(ret)) {
    (ret)._isVList = true;
  }
  return ret
}

/*  */

/**
 * Runtime helper for rendering <slot>
 */
function renderSlot (
  name,
  fallback,
  props,
  bindObject
) {
  var scopedSlotFn = this.$scopedSlots[name];
  var nodes;
  if (scopedSlotFn) { // scoped slot
    props = props || {};
    if (bindObject) {
      if ("development" !== 'production' && !isObject(bindObject)) {
        warn(
          'slot v-bind without argument expects an Object',
          this
        );
      }
      props = extend(extend({}, bindObject), props);
    }
    nodes = scopedSlotFn(props) || fallback;
  } else {
    var slotNodes = this.$slots[name];
    // warn duplicate slot usage
    if (slotNodes) {
      if ("development" !== 'production' && slotNodes._rendered) {
        warn(
          "Duplicate presence of slot \"" + name + "\" found in the same render tree " +
          "- this will likely cause render errors.",
          this
        );
      }
      slotNodes._rendered = true;
    }
    nodes = slotNodes || fallback;
  }

  var target = props && props.slot;
  if (target) {
    return this.$createElement('template', { slot: target }, nodes)
  } else {
    return nodes
  }
}

/*  */

/**
 * Runtime helper for resolving filters
 */
function resolveFilter (id) {
  return resolveAsset(this.$options, 'filters', id, true) || identity
}

/*  */

function isKeyNotMatch (expect, actual) {
  if (Array.isArray(expect)) {
    return expect.indexOf(actual) === -1
  } else {
    return expect !== actual
  }
}

/**
 * Runtime helper for checking keyCodes from config.
 * exposed as Vue.prototype._k
 * passing in eventKeyName as last argument separately for backwards compat
 */
function checkKeyCodes (
  eventKeyCode,
  key,
  builtInKeyCode,
  eventKeyName,
  builtInKeyName
) {
  var mappedKeyCode = config.keyCodes[key] || builtInKeyCode;
  if (builtInKeyName && eventKeyName && !config.keyCodes[key]) {
    return isKeyNotMatch(builtInKeyName, eventKeyName)
  } else if (mappedKeyCode) {
    return isKeyNotMatch(mappedKeyCode, eventKeyCode)
  } else if (eventKeyName) {
    return hyphenate(eventKeyName) !== key
  }
}

/*  */

/**
 * Runtime helper for merging v-bind="object" into a VNode's data.
 */
function bindObjectProps (
  data,
  tag,
  value,
  asProp,
  isSync
) {
  if (value) {
    if (!isObject(value)) {
      "development" !== 'production' && warn(
        'v-bind without argument expects an Object or Array value',
        this
      );
    } else {
      if (Array.isArray(value)) {
        value = toObject(value);
      }
      var hash;
      var loop = function ( key ) {
        if (
          key === 'class' ||
          key === 'style' ||
          isReservedAttribute(key)
        ) {
          hash = data;
        } else {
          var type = data.attrs && data.attrs.type;
          hash = asProp || config.mustUseProp(tag, type, key)
            ? data.domProps || (data.domProps = {})
            : data.attrs || (data.attrs = {});
        }
        if (!(key in hash)) {
          hash[key] = value[key];

          if (isSync) {
            var on = data.on || (data.on = {});
            on[("update:" + key)] = function ($event) {
              value[key] = $event;
            };
          }
        }
      };

      for (var key in value) loop( key );
    }
  }
  return data
}

/*  */

/**
 * Runtime helper for rendering static trees.
 */
function renderStatic (
  index,
  isInFor
) {
  var cached = this._staticTrees || (this._staticTrees = []);
  var tree = cached[index];
  // if has already-rendered static tree and not inside v-for,
  // we can reuse the same tree.
  if (tree && !isInFor) {
    return tree
  }
  // otherwise, render a fresh tree.
  tree = cached[index] = this.$options.staticRenderFns[index].call(
    this._renderProxy,
    null,
    this // for render fns generated for functional component templates
  );
  markStatic(tree, ("__static__" + index), false);
  return tree
}

/**
 * Runtime helper for v-once.
 * Effectively it means marking the node as static with a unique key.
 */
function markOnce (
  tree,
  index,
  key
) {
  markStatic(tree, ("__once__" + index + (key ? ("_" + key) : "")), true);
  return tree
}

function markStatic (
  tree,
  key,
  isOnce
) {
  if (Array.isArray(tree)) {
    for (var i = 0; i < tree.length; i++) {
      if (tree[i] && typeof tree[i] !== 'string') {
        markStaticNode(tree[i], (key + "_" + i), isOnce);
      }
    }
  } else {
    markStaticNode(tree, key, isOnce);
  }
}

function markStaticNode (node, key, isOnce) {
  node.isStatic = true;
  node.key = key;
  node.isOnce = isOnce;
}

/*  */

function bindObjectListeners (data, value) {
  if (value) {
    if (!isPlainObject(value)) {
      "development" !== 'production' && warn(
        'v-on without argument expects an Object value',
        this
      );
    } else {
      var on = data.on = data.on ? extend({}, data.on) : {};
      for (var key in value) {
        var existing = on[key];
        var ours = value[key];
        on[key] = existing ? [].concat(existing, ours) : ours;
      }
    }
  }
  return data
}

/*  */

function installRenderHelpers (target) {
  target._o = markOnce;
  target._n = toNumber;
  target._s = toString;
  target._l = renderList;
  target._t = renderSlot;
  target._q = looseEqual;
  target._i = looseIndexOf;
  target._m = renderStatic;
  target._f = resolveFilter;
  target._k = checkKeyCodes;
  target._b = bindObjectProps;
  target._v = createTextVNode;
  target._e = createEmptyVNode;
  target._u = resolveScopedSlots;
  target._g = bindObjectListeners;
}

/*  */

function FunctionalRenderContext (
  data,
  props,
  children,
  parent,
  Ctor
) {
  var options = Ctor.options;
  // ensure the createElement function in functional components
  // gets a unique context - this is necessary for correct named slot check
  var contextVm;
  if (hasOwn(parent, '_uid')) {
    contextVm = Object.create(parent);
    // $flow-disable-line
    contextVm._original = parent;
  } else {
    // the context vm passed in is a functional context as well.
    // in this case we want to make sure we are able to get a hold to the
    // real context instance.
    contextVm = parent;
    // $flow-disable-line
    parent = parent._original;
  }
  var isCompiled = isTrue(options._compiled);
  var needNormalization = !isCompiled;

  this.data = data;
  this.props = props;
  this.children = children;
  this.parent = parent;
  this.listeners = data.on || emptyObject;
  this.injections = resolveInject(options.inject, parent);
  this.slots = function () { return resolveSlots(children, parent); };

  // support for compiled functional template
  if (isCompiled) {
    // exposing $options for renderStatic()
    this.$options = options;
    // pre-resolve slots for renderSlot()
    this.$slots = this.slots();
    this.$scopedSlots = data.scopedSlots || emptyObject;
  }

  if (options._scopeId) {
    this._c = function (a, b, c, d) {
      var vnode = createElement(contextVm, a, b, c, d, needNormalization);
      if (vnode && !Array.isArray(vnode)) {
        vnode.fnScopeId = options._scopeId;
        vnode.fnContext = parent;
      }
      return vnode
    };
  } else {
    this._c = function (a, b, c, d) { return createElement(contextVm, a, b, c, d, needNormalization); };
  }
}

installRenderHelpers(FunctionalRenderContext.prototype);

function createFunctionalComponent (
  Ctor,
  propsData,
  data,
  contextVm,
  children
) {
  var options = Ctor.options;
  var props = {};
  var propOptions = options.props;
  if (isDef(propOptions)) {
    for (var key in propOptions) {
      props[key] = validateProp(key, propOptions, propsData || emptyObject);
    }
  } else {
    if (isDef(data.attrs)) { mergeProps(props, data.attrs); }
    if (isDef(data.props)) { mergeProps(props, data.props); }
  }

  var renderContext = new FunctionalRenderContext(
    data,
    props,
    children,
    contextVm,
    Ctor
  );

  var vnode = options.render.call(null, renderContext._c, renderContext);

  if (vnode instanceof VNode) {
    return cloneAndMarkFunctionalResult(vnode, data, renderContext.parent, options)
  } else if (Array.isArray(vnode)) {
    var vnodes = normalizeChildren(vnode) || [];
    var res = new Array(vnodes.length);
    for (var i = 0; i < vnodes.length; i++) {
      res[i] = cloneAndMarkFunctionalResult(vnodes[i], data, renderContext.parent, options);
    }
    return res
  }
}

function cloneAndMarkFunctionalResult (vnode, data, contextVm, options) {
  // #7817 clone node before setting fnContext, otherwise if the node is reused
  // (e.g. it was from a cached normal slot) the fnContext causes named slots
  // that should not be matched to match.
  var clone = cloneVNode(vnode);
  clone.fnContext = contextVm;
  clone.fnOptions = options;
  if (data.slot) {
    (clone.data || (clone.data = {})).slot = data.slot;
  }
  return clone
}

function mergeProps (to, from) {
  for (var key in from) {
    to[camelize(key)] = from[key];
  }
}

/*  */




// Register the component hook to weex native render engine.
// The hook will be triggered by native, not javascript.


// Updates the state of the component to weex native render engine.

/*  */

// https://github.com/Hanks10100/weex-native-directive/tree/master/component

// listening on native callback

/*  */

/*  */

// inline hooks to be invoked on component VNodes during patch
var componentVNodeHooks = {
  init: function init (
    vnode,
    hydrating,
    parentElm,
    refElm
  ) {
    if (
      vnode.componentInstance &&
      !vnode.componentInstance._isDestroyed &&
      vnode.data.keepAlive
    ) {
      // kept-alive components, treat as a patch
      var mountedNode = vnode; // work around flow
      componentVNodeHooks.prepatch(mountedNode, mountedNode);
    } else {
      var child = vnode.componentInstance = createComponentInstanceForVnode(
        vnode,
        activeInstance,
        parentElm,
        refElm
      );
      child.$mount(hydrating ? vnode.elm : undefined, hydrating);
    }
  },

  prepatch: function prepatch (oldVnode, vnode) {
    var options = vnode.componentOptions;
    var child = vnode.componentInstance = oldVnode.componentInstance;
    updateChildComponent(
      child,
      options.propsData, // updated props
      options.listeners, // updated listeners
      vnode, // new parent vnode
      options.children // new children
    );
  },

  insert: function insert (vnode) {
    var context = vnode.context;
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isMounted) {
      componentInstance._isMounted = true;
      callHook(componentInstance, 'mounted');
    }
    if (vnode.data.keepAlive) {
      if (context._isMounted) {
        // vue-router#1212
        // During updates, a kept-alive component's child components may
        // change, so directly walking the tree here may call activated hooks
        // on incorrect children. Instead we push them into a queue which will
        // be processed after the whole patch process ended.
        queueActivatedComponent(componentInstance);
      } else {
        activateChildComponent(componentInstance, true /* direct */);
      }
    }
  },

  destroy: function destroy (vnode) {
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isDestroyed) {
      if (!vnode.data.keepAlive) {
        componentInstance.$destroy();
      } else {
        deactivateChildComponent(componentInstance, true /* direct */);
      }
    }
  }
};

var hooksToMerge = Object.keys(componentVNodeHooks);

function createComponent (
  Ctor,
  data,
  context,
  children,
  tag
) {
  if (isUndef(Ctor)) {
    return
  }

  var baseCtor = context.$options._base;

  // plain options object: turn it into a constructor
  if (isObject(Ctor)) {
    Ctor = baseCtor.extend(Ctor);
  }

  // if at this stage it's not a constructor or an async component factory,
  // reject.
  if (typeof Ctor !== 'function') {
    if (true) {
      warn(("Invalid Component definition: " + (String(Ctor))), context);
    }
    return
  }

  // async component
  var asyncFactory;
  if (isUndef(Ctor.cid)) {
    asyncFactory = Ctor;
    Ctor = resolveAsyncComponent(asyncFactory, baseCtor, context);
    if (Ctor === undefined) {
      // return a placeholder node for async component, which is rendered
      // as a comment node but preserves all the raw information for the node.
      // the information will be used for async server-rendering and hydration.
      return createAsyncPlaceholder(
        asyncFactory,
        data,
        context,
        children,
        tag
      )
    }
  }

  data = data || {};

  // resolve constructor options in case global mixins are applied after
  // component constructor creation
  resolveConstructorOptions(Ctor);

  // transform component v-model data into props & events
  if (isDef(data.model)) {
    transformModel(Ctor.options, data);
  }

  // extract props
  var propsData = extractPropsFromVNodeData(data, Ctor, tag);

  // functional component
  if (isTrue(Ctor.options.functional)) {
    return createFunctionalComponent(Ctor, propsData, data, context, children)
  }

  // extract listeners, since these needs to be treated as
  // child component listeners instead of DOM listeners
  var listeners = data.on;
  // replace with listeners with .native modifier
  // so it gets processed during parent component patch.
  data.on = data.nativeOn;

  if (isTrue(Ctor.options.abstract)) {
    // abstract components do not keep anything
    // other than props & listeners & slot

    // work around flow
    var slot = data.slot;
    data = {};
    if (slot) {
      data.slot = slot;
    }
  }

  // install component management hooks onto the placeholder node
  installComponentHooks(data);

  // return a placeholder vnode
  var name = Ctor.options.name || tag;
  var vnode = new VNode(
    ("vue-component-" + (Ctor.cid) + (name ? ("-" + name) : '')),
    data, undefined, undefined, undefined, context,
    { Ctor: Ctor, propsData: propsData, listeners: listeners, tag: tag, children: children },
    asyncFactory
  );

  // Weex specific: invoke recycle-list optimized @render function for
  // extracting cell-slot template.
  // https://github.com/Hanks10100/weex-native-directive/tree/master/component
  /* istanbul ignore if */
  return vnode
}

function createComponentInstanceForVnode (
  vnode, // we know it's MountedComponentVNode but flow doesn't
  parent, // activeInstance in lifecycle state
  parentElm,
  refElm
) {
  var options = {
    _isComponent: true,
    parent: parent,
    _parentVnode: vnode,
    _parentElm: parentElm || null,
    _refElm: refElm || null
  };
  // check inline-template render functions
  var inlineTemplate = vnode.data.inlineTemplate;
  if (isDef(inlineTemplate)) {
    options.render = inlineTemplate.render;
    options.staticRenderFns = inlineTemplate.staticRenderFns;
  }
  return new vnode.componentOptions.Ctor(options)
}

function installComponentHooks (data) {
  var hooks = data.hook || (data.hook = {});
  for (var i = 0; i < hooksToMerge.length; i++) {
    var key = hooksToMerge[i];
    hooks[key] = componentVNodeHooks[key];
  }
}

// transform component v-model info (value and callback) into
// prop and event handler respectively.
function transformModel (options, data) {
  var prop = (options.model && options.model.prop) || 'value';
  var event = (options.model && options.model.event) || 'input';(data.props || (data.props = {}))[prop] = data.model.value;
  var on = data.on || (data.on = {});
  if (isDef(on[event])) {
    on[event] = [data.model.callback].concat(on[event]);
  } else {
    on[event] = data.model.callback;
  }
}

/*  */

var SIMPLE_NORMALIZE = 1;
var ALWAYS_NORMALIZE = 2;

// wrapper function for providing a more flexible interface
// without getting yelled at by flow
function createElement (
  context,
  tag,
  data,
  children,
  normalizationType,
  alwaysNormalize
) {
  if (Array.isArray(data) || isPrimitive(data)) {
    normalizationType = children;
    children = data;
    data = undefined;
  }
  if (isTrue(alwaysNormalize)) {
    normalizationType = ALWAYS_NORMALIZE;
  }
  return _createElement(context, tag, data, children, normalizationType)
}

function _createElement (
  context,
  tag,
  data,
  children,
  normalizationType
) {
  if (isDef(data) && isDef((data).__ob__)) {
    "development" !== 'production' && warn(
      "Avoid using observed data object as vnode data: " + (JSON.stringify(data)) + "\n" +
      'Always create fresh vnode data objects in each render!',
      context
    );
    return createEmptyVNode()
  }
  // object syntax in v-bind
  if (isDef(data) && isDef(data.is)) {
    tag = data.is;
  }
  if (!tag) {
    // in case of component :is set to falsy value
    return createEmptyVNode()
  }
  // warn against non-primitive key
  if ("development" !== 'production' &&
    isDef(data) && isDef(data.key) && !isPrimitive(data.key)
  ) {
    {
      warn(
        'Avoid using non-primitive value as key, ' +
        'use string/number value instead.',
        context
      );
    }
  }
  // support single function children as default scoped slot
  if (Array.isArray(children) &&
    typeof children[0] === 'function'
  ) {
    data = data || {};
    data.scopedSlots = { default: children[0] };
    children.length = 0;
  }
  if (normalizationType === ALWAYS_NORMALIZE) {
    children = normalizeChildren(children);
  } else if (normalizationType === SIMPLE_NORMALIZE) {
    children = simpleNormalizeChildren(children);
  }
  var vnode, ns;
  if (typeof tag === 'string') {
    var Ctor;
    ns = (context.$vnode && context.$vnode.ns) || config.getTagNamespace(tag);
    if (config.isReservedTag(tag)) {
      // platform built-in elements
      vnode = new VNode(
        config.parsePlatformTagName(tag), data, children,
        undefined, undefined, context
      );
    } else if (isDef(Ctor = resolveAsset(context.$options, 'components', tag))) {
      // component
      vnode = createComponent(Ctor, data, context, children, tag);
    } else {
      // unknown or unlisted namespaced elements
      // check at runtime because it may get assigned a namespace when its
      // parent normalizes children
      vnode = new VNode(
        tag, data, children,
        undefined, undefined, context
      );
    }
  } else {
    // direct component options / constructor
    vnode = createComponent(tag, data, context, children);
  }
  if (Array.isArray(vnode)) {
    return vnode
  } else if (isDef(vnode)) {
    if (isDef(ns)) { applyNS(vnode, ns); }
    if (isDef(data)) { registerDeepBindings(data); }
    return vnode
  } else {
    return createEmptyVNode()
  }
}

function applyNS (vnode, ns, force) {
  vnode.ns = ns;
  if (vnode.tag === 'foreignObject') {
    // use default namespace inside foreignObject
    ns = undefined;
    force = true;
  }
  if (isDef(vnode.children)) {
    for (var i = 0, l = vnode.children.length; i < l; i++) {
      var child = vnode.children[i];
      if (isDef(child.tag) && (
        isUndef(child.ns) || (isTrue(force) && child.tag !== 'svg'))) {
        applyNS(child, ns, force);
      }
    }
  }
}

// ref #5318
// necessary to ensure parent re-render when deep bindings like :style and
// :class are used on slot nodes
function registerDeepBindings (data) {
  if (isObject(data.style)) {
    traverse(data.style);
  }
  if (isObject(data.class)) {
    traverse(data.class);
  }
}

/*  */

function initRender (vm) {
  vm._vnode = null; // the root of the child tree
  vm._staticTrees = null; // v-once cached trees
  var options = vm.$options;
  var parentVnode = vm.$vnode = options._parentVnode; // the placeholder node in parent tree
  var renderContext = parentVnode && parentVnode.context;
  vm.$slots = resolveSlots(options._renderChildren, renderContext);
  vm.$scopedSlots = emptyObject;
  // bind the createElement fn to this instance
  // so that we get proper render context inside it.
  // args order: tag, data, children, normalizationType, alwaysNormalize
  // internal version is used by render functions compiled from templates
  vm._c = function (a, b, c, d) { return createElement(vm, a, b, c, d, false); };
  // normalization is always applied for the public version, used in
  // user-written render functions.
  vm.$createElement = function (a, b, c, d) { return createElement(vm, a, b, c, d, true); };

  // $attrs & $listeners are exposed for easier HOC creation.
  // they need to be reactive so that HOCs using them are always updated
  var parentData = parentVnode && parentVnode.data;

  /* istanbul ignore else */
  if (true) {
    defineReactive(vm, '$attrs', parentData && parentData.attrs || emptyObject, function () {
      !isUpdatingChildComponent && warn("$attrs is readonly.", vm);
    }, true);
    defineReactive(vm, '$listeners', options._parentListeners || emptyObject, function () {
      !isUpdatingChildComponent && warn("$listeners is readonly.", vm);
    }, true);
  } else {
    defineReactive(vm, '$attrs', parentData && parentData.attrs || emptyObject, null, true);
    defineReactive(vm, '$listeners', options._parentListeners || emptyObject, null, true);
  }
}

function renderMixin (Vue) {
  // install runtime convenience helpers
  installRenderHelpers(Vue.prototype);

  Vue.prototype.$nextTick = function (fn) {
    return nextTick(fn, this)
  };

  Vue.prototype._render = function () {
    var vm = this;
    var ref = vm.$options;
    var render = ref.render;
    var _parentVnode = ref._parentVnode;

    // reset _rendered flag on slots for duplicate slot check
    if (true) {
      for (var key in vm.$slots) {
        // $flow-disable-line
        vm.$slots[key]._rendered = false;
      }
    }

    if (_parentVnode) {
      vm.$scopedSlots = _parentVnode.data.scopedSlots || emptyObject;
    }

    // set parent vnode. this allows render functions to have access
    // to the data on the placeholder node.
    vm.$vnode = _parentVnode;
    // render self
    var vnode;
    try {
      vnode = render.call(vm._renderProxy, vm.$createElement);
    } catch (e) {
      handleError(e, vm, "render");
      // return error render result,
      // or previous vnode to prevent render error causing blank component
      /* istanbul ignore else */
      if (true) {
        if (vm.$options.renderError) {
          try {
            vnode = vm.$options.renderError.call(vm._renderProxy, vm.$createElement, e);
          } catch (e) {
            handleError(e, vm, "renderError");
            vnode = vm._vnode;
          }
        } else {
          vnode = vm._vnode;
        }
      } else {
        vnode = vm._vnode;
      }
    }
    // return empty vnode in case the render function errored out
    if (!(vnode instanceof VNode)) {
      if ("development" !== 'production' && Array.isArray(vnode)) {
        warn(
          'Multiple root nodes returned from render function. Render function ' +
          'should return a single root node.',
          vm
        );
      }
      vnode = createEmptyVNode();
    }
    // set parent
    vnode.parent = _parentVnode;
    return vnode
  };
}

/*  */

var uid$3 = 0;

function initMixin (Vue) {
  Vue.prototype._init = function (options) {
    var vm = this;
    // a uid
    vm._uid = uid$3++;

    var startTag, endTag;
    /* istanbul ignore if */
    if ("development" !== 'production' && config.performance && mark) {
      startTag = "vue-perf-start:" + (vm._uid);
      endTag = "vue-perf-end:" + (vm._uid);
      mark(startTag);
    }

    // a flag to avoid this being observed
    vm._isVue = true;
    // merge options
    if (options && options._isComponent) {
      // optimize internal component instantiation
      // since dynamic options merging is pretty slow, and none of the
      // internal component options needs special treatment.
      initInternalComponent(vm, options);
    } else {
      vm.$options = mergeOptions(
        resolveConstructorOptions(vm.constructor),
        options || {},
        vm
      );
    }
    /* istanbul ignore else */
    if (true) {
      initProxy(vm);
    } else {
      vm._renderProxy = vm;
    }
    // expose real self
    vm._self = vm;
    initLifecycle(vm);
    initEvents(vm);
    initRender(vm);
    callHook(vm, 'beforeCreate');
    initInjections(vm); // resolve injections before data/props
    initState(vm);
    initProvide(vm); // resolve provide after data/props
    callHook(vm, 'created');

    /* istanbul ignore if */
    if ("development" !== 'production' && config.performance && mark) {
      vm._name = formatComponentName(vm, false);
      mark(endTag);
      measure(("vue " + (vm._name) + " init"), startTag, endTag);
    }

    if (vm.$options.el) {
      vm.$mount(vm.$options.el);
    }
  };
}

function initInternalComponent (vm, options) {
  var opts = vm.$options = Object.create(vm.constructor.options);
  // doing this because it's faster than dynamic enumeration.
  var parentVnode = options._parentVnode;
  opts.parent = options.parent;
  opts._parentVnode = parentVnode;
  opts._parentElm = options._parentElm;
  opts._refElm = options._refElm;

  var vnodeComponentOptions = parentVnode.componentOptions;
  opts.propsData = vnodeComponentOptions.propsData;
  opts._parentListeners = vnodeComponentOptions.listeners;
  opts._renderChildren = vnodeComponentOptions.children;
  opts._componentTag = vnodeComponentOptions.tag;

  if (options.render) {
    opts.render = options.render;
    opts.staticRenderFns = options.staticRenderFns;
  }
}

function resolveConstructorOptions (Ctor) {
  var options = Ctor.options;
  if (Ctor.super) {
    var superOptions = resolveConstructorOptions(Ctor.super);
    var cachedSuperOptions = Ctor.superOptions;
    if (superOptions !== cachedSuperOptions) {
      // super option changed,
      // need to resolve new options.
      Ctor.superOptions = superOptions;
      // check if there are any late-modified/attached options (#4976)
      var modifiedOptions = resolveModifiedOptions(Ctor);
      // update base extend options
      if (modifiedOptions) {
        extend(Ctor.extendOptions, modifiedOptions);
      }
      options = Ctor.options = mergeOptions(superOptions, Ctor.extendOptions);
      if (options.name) {
        options.components[options.name] = Ctor;
      }
    }
  }
  return options
}

function resolveModifiedOptions (Ctor) {
  var modified;
  var latest = Ctor.options;
  var extended = Ctor.extendOptions;
  var sealed = Ctor.sealedOptions;
  for (var key in latest) {
    if (latest[key] !== sealed[key]) {
      if (!modified) { modified = {}; }
      modified[key] = dedupe(latest[key], extended[key], sealed[key]);
    }
  }
  return modified
}

function dedupe (latest, extended, sealed) {
  // compare latest and sealed to ensure lifecycle hooks won't be duplicated
  // between merges
  if (Array.isArray(latest)) {
    var res = [];
    sealed = Array.isArray(sealed) ? sealed : [sealed];
    extended = Array.isArray(extended) ? extended : [extended];
    for (var i = 0; i < latest.length; i++) {
      // push original options and not sealed options to exclude duplicated options
      if (extended.indexOf(latest[i]) >= 0 || sealed.indexOf(latest[i]) < 0) {
        res.push(latest[i]);
      }
    }
    return res
  } else {
    return latest
  }
}

function Vue (options) {
  if ("development" !== 'production' &&
    !(this instanceof Vue)
  ) {
    warn('Vue is a constructor and should be called with the `new` keyword');
  }
  this._init(options);
}

initMixin(Vue);
stateMixin(Vue);
eventsMixin(Vue);
lifecycleMixin(Vue);
renderMixin(Vue);

/*  */

function initUse (Vue) {
  Vue.use = function (plugin) {
    var installedPlugins = (this._installedPlugins || (this._installedPlugins = []));
    if (installedPlugins.indexOf(plugin) > -1) {
      return this
    }

    // additional parameters
    var args = toArray(arguments, 1);
    args.unshift(this);
    if (typeof plugin.install === 'function') {
      plugin.install.apply(plugin, args);
    } else if (typeof plugin === 'function') {
      plugin.apply(null, args);
    }
    installedPlugins.push(plugin);
    return this
  };
}

/*  */

function initMixin$1 (Vue) {
  Vue.mixin = function (mixin) {
    this.options = mergeOptions(this.options, mixin);
    return this
  };
}

/*  */

function initExtend (Vue) {
  /**
   * Each instance constructor, including Vue, has a unique
   * cid. This enables us to create wrapped "child
   * constructors" for prototypal inheritance and cache them.
   */
  Vue.cid = 0;
  var cid = 1;

  /**
   * Class inheritance
   */
  Vue.extend = function (extendOptions) {
    extendOptions = extendOptions || {};
    var Super = this;
    var SuperId = Super.cid;
    var cachedCtors = extendOptions._Ctor || (extendOptions._Ctor = {});
    if (cachedCtors[SuperId]) {
      return cachedCtors[SuperId]
    }

    var name = extendOptions.name || Super.options.name;
    if ("development" !== 'production' && name) {
      validateComponentName(name);
    }

    var Sub = function VueComponent (options) {
      this._init(options);
    };
    Sub.prototype = Object.create(Super.prototype);
    Sub.prototype.constructor = Sub;
    Sub.cid = cid++;
    Sub.options = mergeOptions(
      Super.options,
      extendOptions
    );
    Sub['super'] = Super;

    // For props and computed properties, we define the proxy getters on
    // the Vue instances at extension time, on the extended prototype. This
    // avoids Object.defineProperty calls for each instance created.
    if (Sub.options.props) {
      initProps$1(Sub);
    }
    if (Sub.options.computed) {
      initComputed$1(Sub);
    }

    // allow further extension/mixin/plugin usage
    Sub.extend = Super.extend;
    Sub.mixin = Super.mixin;
    Sub.use = Super.use;

    // create asset registers, so extended classes
    // can have their private assets too.
    ASSET_TYPES.forEach(function (type) {
      Sub[type] = Super[type];
    });
    // enable recursive self-lookup
    if (name) {
      Sub.options.components[name] = Sub;
    }

    // keep a reference to the super options at extension time.
    // later at instantiation we can check if Super's options have
    // been updated.
    Sub.superOptions = Super.options;
    Sub.extendOptions = extendOptions;
    Sub.sealedOptions = extend({}, Sub.options);

    // cache constructor
    cachedCtors[SuperId] = Sub;
    return Sub
  };
}

function initProps$1 (Comp) {
  var props = Comp.options.props;
  for (var key in props) {
    proxy(Comp.prototype, "_props", key);
  }
}

function initComputed$1 (Comp) {
  var computed = Comp.options.computed;
  for (var key in computed) {
    defineComputed(Comp.prototype, key, computed[key]);
  }
}

/*  */

function initAssetRegisters (Vue) {
  /**
   * Create asset registration methods.
   */
  ASSET_TYPES.forEach(function (type) {
    Vue[type] = function (
      id,
      definition
    ) {
      if (!definition) {
        return this.options[type + 's'][id]
      } else {
        /* istanbul ignore if */
        if ("development" !== 'production' && type === 'component') {
          validateComponentName(id);
        }
        if (type === 'component' && isPlainObject(definition)) {
          definition.name = definition.name || id;
          definition = this.options._base.extend(definition);
        }
        if (type === 'directive' && typeof definition === 'function') {
          definition = { bind: definition, update: definition };
        }
        this.options[type + 's'][id] = definition;
        return definition
      }
    };
  });
}

/*  */

function getComponentName (opts) {
  return opts && (opts.Ctor.options.name || opts.tag)
}

function matches (pattern, name) {
  if (Array.isArray(pattern)) {
    return pattern.indexOf(name) > -1
  } else if (typeof pattern === 'string') {
    return pattern.split(',').indexOf(name) > -1
  } else if (isRegExp(pattern)) {
    return pattern.test(name)
  }
  /* istanbul ignore next */
  return false
}

function pruneCache (keepAliveInstance, filter) {
  var cache = keepAliveInstance.cache;
  var keys = keepAliveInstance.keys;
  var _vnode = keepAliveInstance._vnode;
  for (var key in cache) {
    var cachedNode = cache[key];
    if (cachedNode) {
      var name = getComponentName(cachedNode.componentOptions);
      if (name && !filter(name)) {
        pruneCacheEntry(cache, key, keys, _vnode);
      }
    }
  }
}

function pruneCacheEntry (
  cache,
  key,
  keys,
  current
) {
  var cached$$1 = cache[key];
  if (cached$$1 && (!current || cached$$1.tag !== current.tag)) {
    cached$$1.componentInstance.$destroy();
  }
  cache[key] = null;
  remove(keys, key);
}

var patternTypes = [String, RegExp, Array];

var KeepAlive = {
  name: 'keep-alive',
  abstract: true,

  props: {
    include: patternTypes,
    exclude: patternTypes,
    max: [String, Number]
  },

  created: function created () {
    this.cache = Object.create(null);
    this.keys = [];
  },

  destroyed: function destroyed () {
    var this$1 = this;

    for (var key in this$1.cache) {
      pruneCacheEntry(this$1.cache, key, this$1.keys);
    }
  },

  mounted: function mounted () {
    var this$1 = this;

    this.$watch('include', function (val) {
      pruneCache(this$1, function (name) { return matches(val, name); });
    });
    this.$watch('exclude', function (val) {
      pruneCache(this$1, function (name) { return !matches(val, name); });
    });
  },

  render: function render () {
    var slot = this.$slots.default;
    var vnode = getFirstComponentChild(slot);
    var componentOptions = vnode && vnode.componentOptions;
    if (componentOptions) {
      // check pattern
      var name = getComponentName(componentOptions);
      var ref = this;
      var include = ref.include;
      var exclude = ref.exclude;
      if (
        // not included
        (include && (!name || !matches(include, name))) ||
        // excluded
        (exclude && name && matches(exclude, name))
      ) {
        return vnode
      }

      var ref$1 = this;
      var cache = ref$1.cache;
      var keys = ref$1.keys;
      var key = vnode.key == null
        // same constructor may get registered as different local components
        // so cid alone is not enough (#3269)
        ? componentOptions.Ctor.cid + (componentOptions.tag ? ("::" + (componentOptions.tag)) : '')
        : vnode.key;
      if (cache[key]) {
        vnode.componentInstance = cache[key].componentInstance;
        // make current key freshest
        remove(keys, key);
        keys.push(key);
      } else {
        cache[key] = vnode;
        keys.push(key);
        // prune oldest entry
        if (this.max && keys.length > parseInt(this.max)) {
          pruneCacheEntry(cache, keys[0], keys, this._vnode);
        }
      }

      vnode.data.keepAlive = true;
    }
    return vnode || (slot && slot[0])
  }
}

var builtInComponents = {
  KeepAlive: KeepAlive
}

/*  */

function initGlobalAPI (Vue) {
  // config
  var configDef = {};
  configDef.get = function () { return config; };
  if (true) {
    configDef.set = function () {
      warn(
        'Do not replace the Vue.config object, set individual fields instead.'
      );
    };
  }
  Object.defineProperty(Vue, 'config', configDef);

  // exposed util methods.
  // NOTE: these are not considered part of the public API - avoid relying on
  // them unless you are aware of the risk.
  Vue.util = {
    warn: warn,
    extend: extend,
    mergeOptions: mergeOptions,
    defineReactive: defineReactive
  };

  Vue.set = set;
  Vue.delete = del;
  Vue.nextTick = nextTick;

  Vue.options = Object.create(null);
  ASSET_TYPES.forEach(function (type) {
    Vue.options[type + 's'] = Object.create(null);
  });

  // this is used to identify the "base" constructor to extend all plain-object
  // components with in Weex's multi-instance scenarios.
  Vue.options._base = Vue;

  extend(Vue.options.components, builtInComponents);

  initUse(Vue);
  initMixin$1(Vue);
  initExtend(Vue);
  initAssetRegisters(Vue);
}

initGlobalAPI(Vue);

Object.defineProperty(Vue.prototype, '$isServer', {
  get: isServerRendering
});

Object.defineProperty(Vue.prototype, '$ssrContext', {
  get: function get () {
    /* istanbul ignore next */
    return this.$vnode && this.$vnode.ssrContext
  }
});

// expose FunctionalRenderContext for ssr runtime helper installation
Object.defineProperty(Vue, 'FunctionalRenderContext', {
  value: FunctionalRenderContext
});

Vue.version = '2.5.17';

/*  */

// these are reserved for web because they are directly compiled away
// during template compilation
var isReservedAttr = makeMap('style,class');

// attributes that should be using props for binding
var acceptValue = makeMap('input,textarea,option,select,progress');
var mustUseProp = function (tag, type, attr) {
  return (
    (attr === 'value' && acceptValue(tag)) && type !== 'button' ||
    (attr === 'selected' && tag === 'option') ||
    (attr === 'checked' && tag === 'input') ||
    (attr === 'muted' && tag === 'video')
  )
};

var isEnumeratedAttr = makeMap('contenteditable,draggable,spellcheck');

var isBooleanAttr = makeMap(
  'allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,' +
  'default,defaultchecked,defaultmuted,defaultselected,defer,disabled,' +
  'enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,' +
  'muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,' +
  'required,reversed,scoped,seamless,selected,sortable,translate,' +
  'truespeed,typemustmatch,visible'
);

var xlinkNS = 'http://www.w3.org/1999/xlink';

var isXlink = function (name) {
  return name.charAt(5) === ':' && name.slice(0, 5) === 'xlink'
};

var getXlinkProp = function (name) {
  return isXlink(name) ? name.slice(6, name.length) : ''
};

var isFalsyAttrValue = function (val) {
  return val == null || val === false
};

/*  */

function genClassForVnode (vnode) {
  var data = vnode.data;
  var parentNode = vnode;
  var childNode = vnode;
  while (isDef(childNode.componentInstance)) {
    childNode = childNode.componentInstance._vnode;
    if (childNode && childNode.data) {
      data = mergeClassData(childNode.data, data);
    }
  }
  while (isDef(parentNode = parentNode.parent)) {
    if (parentNode && parentNode.data) {
      data = mergeClassData(data, parentNode.data);
    }
  }
  return renderClass(data.staticClass, data.class)
}

function mergeClassData (child, parent) {
  return {
    staticClass: concat(child.staticClass, parent.staticClass),
    class: isDef(child.class)
      ? [child.class, parent.class]
      : parent.class
  }
}

function renderClass (
  staticClass,
  dynamicClass
) {
  if (isDef(staticClass) || isDef(dynamicClass)) {
    return concat(staticClass, stringifyClass(dynamicClass))
  }
  /* istanbul ignore next */
  return ''
}

function concat (a, b) {
  return a ? b ? (a + ' ' + b) : a : (b || '')
}

function stringifyClass (value) {
  if (Array.isArray(value)) {
    return stringifyArray(value)
  }
  if (isObject(value)) {
    return stringifyObject(value)
  }
  if (typeof value === 'string') {
    return value
  }
  /* istanbul ignore next */
  return ''
}

function stringifyArray (value) {
  var res = '';
  var stringified;
  for (var i = 0, l = value.length; i < l; i++) {
    if (isDef(stringified = stringifyClass(value[i])) && stringified !== '') {
      if (res) { res += ' '; }
      res += stringified;
    }
  }
  return res
}

function stringifyObject (value) {
  var res = '';
  for (var key in value) {
    if (value[key]) {
      if (res) { res += ' '; }
      res += key;
    }
  }
  return res
}

/*  */

var namespaceMap = {
  svg: 'http://www.w3.org/2000/svg',
  math: 'http://www.w3.org/1998/Math/MathML'
};

var isHTMLTag = makeMap(
  'html,body,base,head,link,meta,style,title,' +
  'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,' +
  'div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,' +
  'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,' +
  's,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,' +
  'embed,object,param,source,canvas,script,noscript,del,ins,' +
  'caption,col,colgroup,table,thead,tbody,td,th,tr,' +
  'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,' +
  'output,progress,select,textarea,' +
  'details,dialog,menu,menuitem,summary,' +
  'content,element,shadow,template,blockquote,iframe,tfoot'
);

// this map is intentionally selective, only covering SVG elements that may
// contain child elements.
var isSVG = makeMap(
  'svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,' +
  'foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,' +
  'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view',
  true
);

var isPreTag = function (tag) { return tag === 'pre'; };

var isReservedTag = function (tag) {
  return isHTMLTag(tag) || isSVG(tag)
};

function getTagNamespace (tag) {
  if (isSVG(tag)) {
    return 'svg'
  }
  // basic support for MathML
  // note it doesn't support other MathML elements being component roots
  if (tag === 'math') {
    return 'math'
  }
}

var unknownElementCache = Object.create(null);
function isUnknownElement (tag) {
  /* istanbul ignore if */
  if (!inBrowser) {
    return true
  }
  if (isReservedTag(tag)) {
    return false
  }
  tag = tag.toLowerCase();
  /* istanbul ignore if */
  if (unknownElementCache[tag] != null) {
    return unknownElementCache[tag]
  }
  var el = document.createElement(tag);
  if (tag.indexOf('-') > -1) {
    // http://stackoverflow.com/a/28210364/1070244
    return (unknownElementCache[tag] = (
      el.constructor === window.HTMLUnknownElement ||
      el.constructor === window.HTMLElement
    ))
  } else {
    return (unknownElementCache[tag] = /HTMLUnknownElement/.test(el.toString()))
  }
}

var isTextInputType = makeMap('text,number,password,search,email,tel,url');

/*  */

/**
 * Query an element selector if it's not an element already.
 */
function query (el) {
  if (typeof el === 'string') {
    var selected = document.querySelector(el);
    if (!selected) {
      "development" !== 'production' && warn(
        'Cannot find element: ' + el
      );
      return document.createElement('div')
    }
    return selected
  } else {
    return el
  }
}

/*  */

function createElement$1 (tagName, vnode) {
  var elm = document.createElement(tagName);
  if (tagName !== 'select') {
    return elm
  }
  // false or null will remove the attribute but undefined will not
  if (vnode.data && vnode.data.attrs && vnode.data.attrs.multiple !== undefined) {
    elm.setAttribute('multiple', 'multiple');
  }
  return elm
}

function createElementNS (namespace, tagName) {
  return document.createElementNS(namespaceMap[namespace], tagName)
}

function createTextNode (text) {
  return document.createTextNode(text)
}

function createComment (text) {
  return document.createComment(text)
}

function insertBefore (parentNode, newNode, referenceNode) {
  parentNode.insertBefore(newNode, referenceNode);
}

function removeChild (node, child) {
  node.removeChild(child);
}

function appendChild (node, child) {
  node.appendChild(child);
}

function parentNode (node) {
  return node.parentNode
}

function nextSibling (node) {
  return node.nextSibling
}

function tagName (node) {
  return node.tagName
}

function setTextContent (node, text) {
  node.textContent = text;
}

function setStyleScope (node, scopeId) {
  node.setAttribute(scopeId, '');
}


var nodeOps = Object.freeze({
	createElement: createElement$1,
	createElementNS: createElementNS,
	createTextNode: createTextNode,
	createComment: createComment,
	insertBefore: insertBefore,
	removeChild: removeChild,
	appendChild: appendChild,
	parentNode: parentNode,
	nextSibling: nextSibling,
	tagName: tagName,
	setTextContent: setTextContent,
	setStyleScope: setStyleScope
});

/*  */

var ref = {
  create: function create (_, vnode) {
    registerRef(vnode);
  },
  update: function update (oldVnode, vnode) {
    if (oldVnode.data.ref !== vnode.data.ref) {
      registerRef(oldVnode, true);
      registerRef(vnode);
    }
  },
  destroy: function destroy (vnode) {
    registerRef(vnode, true);
  }
}

function registerRef (vnode, isRemoval) {
  var key = vnode.data.ref;
  if (!isDef(key)) { return }

  var vm = vnode.context;
  var ref = vnode.componentInstance || vnode.elm;
  var refs = vm.$refs;
  if (isRemoval) {
    if (Array.isArray(refs[key])) {
      remove(refs[key], ref);
    } else if (refs[key] === ref) {
      refs[key] = undefined;
    }
  } else {
    if (vnode.data.refInFor) {
      if (!Array.isArray(refs[key])) {
        refs[key] = [ref];
      } else if (refs[key].indexOf(ref) < 0) {
        // $flow-disable-line
        refs[key].push(ref);
      }
    } else {
      refs[key] = ref;
    }
  }
}

/**
 * Virtual DOM patching algorithm based on Snabbdom by
 * Simon Friis Vindum (@paldepind)
 * Licensed under the MIT License
 * https://github.com/paldepind/snabbdom/blob/master/LICENSE
 *
 * modified by Evan You (@yyx990803)
 *
 * Not type-checking this because this file is perf-critical and the cost
 * of making flow understand it is not worth it.
 */

var emptyNode = new VNode('', {}, []);

var hooks = ['create', 'activate', 'update', 'remove', 'destroy'];

function sameVnode (a, b) {
  return (
    a.key === b.key && (
      (
        a.tag === b.tag &&
        a.isComment === b.isComment &&
        isDef(a.data) === isDef(b.data) &&
        sameInputType(a, b)
      ) || (
        isTrue(a.isAsyncPlaceholder) &&
        a.asyncFactory === b.asyncFactory &&
        isUndef(b.asyncFactory.error)
      )
    )
  )
}

function sameInputType (a, b) {
  if (a.tag !== 'input') { return true }
  var i;
  var typeA = isDef(i = a.data) && isDef(i = i.attrs) && i.type;
  var typeB = isDef(i = b.data) && isDef(i = i.attrs) && i.type;
  return typeA === typeB || isTextInputType(typeA) && isTextInputType(typeB)
}

function createKeyToOldIdx (children, beginIdx, endIdx) {
  var i, key;
  var map = {};
  for (i = beginIdx; i <= endIdx; ++i) {
    key = children[i].key;
    if (isDef(key)) { map[key] = i; }
  }
  return map
}

function createPatchFunction (backend) {
  var i, j;
  var cbs = {};

  var modules = backend.modules;
  var nodeOps = backend.nodeOps;

  for (i = 0; i < hooks.length; ++i) {
    cbs[hooks[i]] = [];
    for (j = 0; j < modules.length; ++j) {
      if (isDef(modules[j][hooks[i]])) {
        cbs[hooks[i]].push(modules[j][hooks[i]]);
      }
    }
  }

  function emptyNodeAt (elm) {
    return new VNode(nodeOps.tagName(elm).toLowerCase(), {}, [], undefined, elm)
  }

  function createRmCb (childElm, listeners) {
    function remove () {
      if (--remove.listeners === 0) {
        removeNode(childElm);
      }
    }
    remove.listeners = listeners;
    return remove
  }

  function removeNode (el) {
    var parent = nodeOps.parentNode(el);
    // element may have already been removed due to v-html / v-text
    if (isDef(parent)) {
      nodeOps.removeChild(parent, el);
    }
  }

  function isUnknownElement$$1 (vnode, inVPre) {
    return (
      !inVPre &&
      !vnode.ns &&
      !(
        config.ignoredElements.length &&
        config.ignoredElements.some(function (ignore) {
          return isRegExp(ignore)
            ? ignore.test(vnode.tag)
            : ignore === vnode.tag
        })
      ) &&
      config.isUnknownElement(vnode.tag)
    )
  }

  var creatingElmInVPre = 0;

  function createElm (
    vnode,
    insertedVnodeQueue,
    parentElm,
    refElm,
    nested,
    ownerArray,
    index
  ) {
    if (isDef(vnode.elm) && isDef(ownerArray)) {
      // This vnode was used in a previous render!
      // now it's used as a new node, overwriting its elm would cause
      // potential patch errors down the road when it's used as an insertion
      // reference node. Instead, we clone the node on-demand before creating
      // associated DOM element for it.
      vnode = ownerArray[index] = cloneVNode(vnode);
    }

    vnode.isRootInsert = !nested; // for transition enter check
    if (createComponent(vnode, insertedVnodeQueue, parentElm, refElm)) {
      return
    }

    var data = vnode.data;
    var children = vnode.children;
    var tag = vnode.tag;
    if (isDef(tag)) {
      if (true) {
        if (data && data.pre) {
          creatingElmInVPre++;
        }
        if (isUnknownElement$$1(vnode, creatingElmInVPre)) {
          warn(
            'Unknown custom element: <' + tag + '> - did you ' +
            'register the component correctly? For recursive components, ' +
            'make sure to provide the "name" option.',
            vnode.context
          );
        }
      }

      vnode.elm = vnode.ns
        ? nodeOps.createElementNS(vnode.ns, tag)
        : nodeOps.createElement(tag, vnode);
      setScope(vnode);

      /* istanbul ignore if */
      {
        createChildren(vnode, children, insertedVnodeQueue);
        if (isDef(data)) {
          invokeCreateHooks(vnode, insertedVnodeQueue);
        }
        insert(parentElm, vnode.elm, refElm);
      }

      if ("development" !== 'production' && data && data.pre) {
        creatingElmInVPre--;
      }
    } else if (isTrue(vnode.isComment)) {
      vnode.elm = nodeOps.createComment(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    } else {
      vnode.elm = nodeOps.createTextNode(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    }
  }

  function createComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i = vnode.data;
    if (isDef(i)) {
      var isReactivated = isDef(vnode.componentInstance) && i.keepAlive;
      if (isDef(i = i.hook) && isDef(i = i.init)) {
        i(vnode, false /* hydrating */, parentElm, refElm);
      }
      // after calling the init hook, if the vnode is a child component
      // it should've created a child instance and mounted it. the child
      // component also has set the placeholder vnode's elm.
      // in that case we can just return the element and be done.
      if (isDef(vnode.componentInstance)) {
        initComponent(vnode, insertedVnodeQueue);
        if (isTrue(isReactivated)) {
          reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm);
        }
        return true
      }
    }
  }

  function initComponent (vnode, insertedVnodeQueue) {
    if (isDef(vnode.data.pendingInsert)) {
      insertedVnodeQueue.push.apply(insertedVnodeQueue, vnode.data.pendingInsert);
      vnode.data.pendingInsert = null;
    }
    vnode.elm = vnode.componentInstance.$el;
    if (isPatchable(vnode)) {
      invokeCreateHooks(vnode, insertedVnodeQueue);
      setScope(vnode);
    } else {
      // empty component root.
      // skip all element-related modules except for ref (#3455)
      registerRef(vnode);
      // make sure to invoke the insert hook
      insertedVnodeQueue.push(vnode);
    }
  }

  function reactivateComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i;
    // hack for #4339: a reactivated component with inner transition
    // does not trigger because the inner node's created hooks are not called
    // again. It's not ideal to involve module-specific logic in here but
    // there doesn't seem to be a better way to do it.
    var innerNode = vnode;
    while (innerNode.componentInstance) {
      innerNode = innerNode.componentInstance._vnode;
      if (isDef(i = innerNode.data) && isDef(i = i.transition)) {
        for (i = 0; i < cbs.activate.length; ++i) {
          cbs.activate[i](emptyNode, innerNode);
        }
        insertedVnodeQueue.push(innerNode);
        break
      }
    }
    // unlike a newly created component,
    // a reactivated keep-alive component doesn't insert itself
    insert(parentElm, vnode.elm, refElm);
  }

  function insert (parent, elm, ref$$1) {
    if (isDef(parent)) {
      if (isDef(ref$$1)) {
        if (ref$$1.parentNode === parent) {
          nodeOps.insertBefore(parent, elm, ref$$1);
        }
      } else {
        nodeOps.appendChild(parent, elm);
      }
    }
  }

  function createChildren (vnode, children, insertedVnodeQueue) {
    if (Array.isArray(children)) {
      if (true) {
        checkDuplicateKeys(children);
      }
      for (var i = 0; i < children.length; ++i) {
        createElm(children[i], insertedVnodeQueue, vnode.elm, null, true, children, i);
      }
    } else if (isPrimitive(vnode.text)) {
      nodeOps.appendChild(vnode.elm, nodeOps.createTextNode(String(vnode.text)));
    }
  }

  function isPatchable (vnode) {
    while (vnode.componentInstance) {
      vnode = vnode.componentInstance._vnode;
    }
    return isDef(vnode.tag)
  }

  function invokeCreateHooks (vnode, insertedVnodeQueue) {
    for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
      cbs.create[i$1](emptyNode, vnode);
    }
    i = vnode.data.hook; // Reuse variable
    if (isDef(i)) {
      if (isDef(i.create)) { i.create(emptyNode, vnode); }
      if (isDef(i.insert)) { insertedVnodeQueue.push(vnode); }
    }
  }

  // set scope id attribute for scoped CSS.
  // this is implemented as a special case to avoid the overhead
  // of going through the normal attribute patching process.
  function setScope (vnode) {
    var i;
    if (isDef(i = vnode.fnScopeId)) {
      nodeOps.setStyleScope(vnode.elm, i);
    } else {
      var ancestor = vnode;
      while (ancestor) {
        if (isDef(i = ancestor.context) && isDef(i = i.$options._scopeId)) {
          nodeOps.setStyleScope(vnode.elm, i);
        }
        ancestor = ancestor.parent;
      }
    }
    // for slot content they should also get the scopeId from the host instance.
    if (isDef(i = activeInstance) &&
      i !== vnode.context &&
      i !== vnode.fnContext &&
      isDef(i = i.$options._scopeId)
    ) {
      nodeOps.setStyleScope(vnode.elm, i);
    }
  }

  function addVnodes (parentElm, refElm, vnodes, startIdx, endIdx, insertedVnodeQueue) {
    for (; startIdx <= endIdx; ++startIdx) {
      createElm(vnodes[startIdx], insertedVnodeQueue, parentElm, refElm, false, vnodes, startIdx);
    }
  }

  function invokeDestroyHook (vnode) {
    var i, j;
    var data = vnode.data;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.destroy)) { i(vnode); }
      for (i = 0; i < cbs.destroy.length; ++i) { cbs.destroy[i](vnode); }
    }
    if (isDef(i = vnode.children)) {
      for (j = 0; j < vnode.children.length; ++j) {
        invokeDestroyHook(vnode.children[j]);
      }
    }
  }

  function removeVnodes (parentElm, vnodes, startIdx, endIdx) {
    for (; startIdx <= endIdx; ++startIdx) {
      var ch = vnodes[startIdx];
      if (isDef(ch)) {
        if (isDef(ch.tag)) {
          removeAndInvokeRemoveHook(ch);
          invokeDestroyHook(ch);
        } else { // Text node
          removeNode(ch.elm);
        }
      }
    }
  }

  function removeAndInvokeRemoveHook (vnode, rm) {
    if (isDef(rm) || isDef(vnode.data)) {
      var i;
      var listeners = cbs.remove.length + 1;
      if (isDef(rm)) {
        // we have a recursively passed down rm callback
        // increase the listeners count
        rm.listeners += listeners;
      } else {
        // directly removing
        rm = createRmCb(vnode.elm, listeners);
      }
      // recursively invoke hooks on child component root node
      if (isDef(i = vnode.componentInstance) && isDef(i = i._vnode) && isDef(i.data)) {
        removeAndInvokeRemoveHook(i, rm);
      }
      for (i = 0; i < cbs.remove.length; ++i) {
        cbs.remove[i](vnode, rm);
      }
      if (isDef(i = vnode.data.hook) && isDef(i = i.remove)) {
        i(vnode, rm);
      } else {
        rm();
      }
    } else {
      removeNode(vnode.elm);
    }
  }

  function updateChildren (parentElm, oldCh, newCh, insertedVnodeQueue, removeOnly) {
    var oldStartIdx = 0;
    var newStartIdx = 0;
    var oldEndIdx = oldCh.length - 1;
    var oldStartVnode = oldCh[0];
    var oldEndVnode = oldCh[oldEndIdx];
    var newEndIdx = newCh.length - 1;
    var newStartVnode = newCh[0];
    var newEndVnode = newCh[newEndIdx];
    var oldKeyToIdx, idxInOld, vnodeToMove, refElm;

    // removeOnly is a special flag used only by <transition-group>
    // to ensure removed elements stay in correct relative positions
    // during leaving transitions
    var canMove = !removeOnly;

    if (true) {
      checkDuplicateKeys(newCh);
    }

    while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
      if (isUndef(oldStartVnode)) {
        oldStartVnode = oldCh[++oldStartIdx]; // Vnode has been moved left
      } else if (isUndef(oldEndVnode)) {
        oldEndVnode = oldCh[--oldEndIdx];
      } else if (sameVnode(oldStartVnode, newStartVnode)) {
        patchVnode(oldStartVnode, newStartVnode, insertedVnodeQueue);
        oldStartVnode = oldCh[++oldStartIdx];
        newStartVnode = newCh[++newStartIdx];
      } else if (sameVnode(oldEndVnode, newEndVnode)) {
        patchVnode(oldEndVnode, newEndVnode, insertedVnodeQueue);
        oldEndVnode = oldCh[--oldEndIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldStartVnode, newEndVnode)) { // Vnode moved right
        patchVnode(oldStartVnode, newEndVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldStartVnode.elm, nodeOps.nextSibling(oldEndVnode.elm));
        oldStartVnode = oldCh[++oldStartIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldEndVnode, newStartVnode)) { // Vnode moved left
        patchVnode(oldEndVnode, newStartVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldEndVnode.elm, oldStartVnode.elm);
        oldEndVnode = oldCh[--oldEndIdx];
        newStartVnode = newCh[++newStartIdx];
      } else {
        if (isUndef(oldKeyToIdx)) { oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx); }
        idxInOld = isDef(newStartVnode.key)
          ? oldKeyToIdx[newStartVnode.key]
          : findIdxInOld(newStartVnode, oldCh, oldStartIdx, oldEndIdx);
        if (isUndef(idxInOld)) { // New element
          createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
        } else {
          vnodeToMove = oldCh[idxInOld];
          if (sameVnode(vnodeToMove, newStartVnode)) {
            patchVnode(vnodeToMove, newStartVnode, insertedVnodeQueue);
            oldCh[idxInOld] = undefined;
            canMove && nodeOps.insertBefore(parentElm, vnodeToMove.elm, oldStartVnode.elm);
          } else {
            // same key but different element. treat as new element
            createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm, false, newCh, newStartIdx);
          }
        }
        newStartVnode = newCh[++newStartIdx];
      }
    }
    if (oldStartIdx > oldEndIdx) {
      refElm = isUndef(newCh[newEndIdx + 1]) ? null : newCh[newEndIdx + 1].elm;
      addVnodes(parentElm, refElm, newCh, newStartIdx, newEndIdx, insertedVnodeQueue);
    } else if (newStartIdx > newEndIdx) {
      removeVnodes(parentElm, oldCh, oldStartIdx, oldEndIdx);
    }
  }

  function checkDuplicateKeys (children) {
    var seenKeys = {};
    for (var i = 0; i < children.length; i++) {
      var vnode = children[i];
      var key = vnode.key;
      if (isDef(key)) {
        if (seenKeys[key]) {
          warn(
            ("Duplicate keys detected: '" + key + "'. This may cause an update error."),
            vnode.context
          );
        } else {
          seenKeys[key] = true;
        }
      }
    }
  }

  function findIdxInOld (node, oldCh, start, end) {
    for (var i = start; i < end; i++) {
      var c = oldCh[i];
      if (isDef(c) && sameVnode(node, c)) { return i }
    }
  }

  function patchVnode (oldVnode, vnode, insertedVnodeQueue, removeOnly) {
    if (oldVnode === vnode) {
      return
    }

    var elm = vnode.elm = oldVnode.elm;

    if (isTrue(oldVnode.isAsyncPlaceholder)) {
      if (isDef(vnode.asyncFactory.resolved)) {
        hydrate(oldVnode.elm, vnode, insertedVnodeQueue);
      } else {
        vnode.isAsyncPlaceholder = true;
      }
      return
    }

    // reuse element for static trees.
    // note we only do this if the vnode is cloned -
    // if the new node is not cloned it means the render functions have been
    // reset by the hot-reload-api and we need to do a proper re-render.
    if (isTrue(vnode.isStatic) &&
      isTrue(oldVnode.isStatic) &&
      vnode.key === oldVnode.key &&
      (isTrue(vnode.isCloned) || isTrue(vnode.isOnce))
    ) {
      vnode.componentInstance = oldVnode.componentInstance;
      return
    }

    var i;
    var data = vnode.data;
    if (isDef(data) && isDef(i = data.hook) && isDef(i = i.prepatch)) {
      i(oldVnode, vnode);
    }

    var oldCh = oldVnode.children;
    var ch = vnode.children;
    if (isDef(data) && isPatchable(vnode)) {
      for (i = 0; i < cbs.update.length; ++i) { cbs.update[i](oldVnode, vnode); }
      if (isDef(i = data.hook) && isDef(i = i.update)) { i(oldVnode, vnode); }
    }
    if (isUndef(vnode.text)) {
      if (isDef(oldCh) && isDef(ch)) {
        if (oldCh !== ch) { updateChildren(elm, oldCh, ch, insertedVnodeQueue, removeOnly); }
      } else if (isDef(ch)) {
        if (isDef(oldVnode.text)) { nodeOps.setTextContent(elm, ''); }
        addVnodes(elm, null, ch, 0, ch.length - 1, insertedVnodeQueue);
      } else if (isDef(oldCh)) {
        removeVnodes(elm, oldCh, 0, oldCh.length - 1);
      } else if (isDef(oldVnode.text)) {
        nodeOps.setTextContent(elm, '');
      }
    } else if (oldVnode.text !== vnode.text) {
      nodeOps.setTextContent(elm, vnode.text);
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.postpatch)) { i(oldVnode, vnode); }
    }
  }

  function invokeInsertHook (vnode, queue, initial) {
    // delay insert hooks for component root nodes, invoke them after the
    // element is really inserted
    if (isTrue(initial) && isDef(vnode.parent)) {
      vnode.parent.data.pendingInsert = queue;
    } else {
      for (var i = 0; i < queue.length; ++i) {
        queue[i].data.hook.insert(queue[i]);
      }
    }
  }

  var hydrationBailed = false;
  // list of modules that can skip create hook during hydration because they
  // are already rendered on the client or has no need for initialization
  // Note: style is excluded because it relies on initial clone for future
  // deep updates (#7063).
  var isRenderedModule = makeMap('attrs,class,staticClass,staticStyle,key');

  // Note: this is a browser-only function so we can assume elms are DOM nodes.
  function hydrate (elm, vnode, insertedVnodeQueue, inVPre) {
    var i;
    var tag = vnode.tag;
    var data = vnode.data;
    var children = vnode.children;
    inVPre = inVPre || (data && data.pre);
    vnode.elm = elm;

    if (isTrue(vnode.isComment) && isDef(vnode.asyncFactory)) {
      vnode.isAsyncPlaceholder = true;
      return true
    }
    // assert node match
    if (true) {
      if (!assertNodeMatch(elm, vnode, inVPre)) {
        return false
      }
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.init)) { i(vnode, true /* hydrating */); }
      if (isDef(i = vnode.componentInstance)) {
        // child component. it should have hydrated its own tree.
        initComponent(vnode, insertedVnodeQueue);
        return true
      }
    }
    if (isDef(tag)) {
      if (isDef(children)) {
        // empty element, allow client to pick up and populate children
        if (!elm.hasChildNodes()) {
          createChildren(vnode, children, insertedVnodeQueue);
        } else {
          // v-html and domProps: innerHTML
          if (isDef(i = data) && isDef(i = i.domProps) && isDef(i = i.innerHTML)) {
            if (i !== elm.innerHTML) {
              /* istanbul ignore if */
              if ("development" !== 'production' &&
                typeof console !== 'undefined' &&
                !hydrationBailed
              ) {
                hydrationBailed = true;
                console.warn('Parent: ', elm);
                console.warn('server innerHTML: ', i);
                console.warn('client innerHTML: ', elm.innerHTML);
              }
              return false
            }
          } else {
            // iterate and compare children lists
            var childrenMatch = true;
            var childNode = elm.firstChild;
            for (var i$1 = 0; i$1 < children.length; i$1++) {
              if (!childNode || !hydrate(childNode, children[i$1], insertedVnodeQueue, inVPre)) {
                childrenMatch = false;
                break
              }
              childNode = childNode.nextSibling;
            }
            // if childNode is not null, it means the actual childNodes list is
            // longer than the virtual children list.
            if (!childrenMatch || childNode) {
              /* istanbul ignore if */
              if ("development" !== 'production' &&
                typeof console !== 'undefined' &&
                !hydrationBailed
              ) {
                hydrationBailed = true;
                console.warn('Parent: ', elm);
                console.warn('Mismatching childNodes vs. VNodes: ', elm.childNodes, children);
              }
              return false
            }
          }
        }
      }
      if (isDef(data)) {
        var fullInvoke = false;
        for (var key in data) {
          if (!isRenderedModule(key)) {
            fullInvoke = true;
            invokeCreateHooks(vnode, insertedVnodeQueue);
            break
          }
        }
        if (!fullInvoke && data['class']) {
          // ensure collecting deps for deep class bindings for future updates
          traverse(data['class']);
        }
      }
    } else if (elm.data !== vnode.text) {
      elm.data = vnode.text;
    }
    return true
  }

  function assertNodeMatch (node, vnode, inVPre) {
    if (isDef(vnode.tag)) {
      return vnode.tag.indexOf('vue-component') === 0 || (
        !isUnknownElement$$1(vnode, inVPre) &&
        vnode.tag.toLowerCase() === (node.tagName && node.tagName.toLowerCase())
      )
    } else {
      return node.nodeType === (vnode.isComment ? 8 : 3)
    }
  }

  return function patch (oldVnode, vnode, hydrating, removeOnly, parentElm, refElm) {
    if (isUndef(vnode)) {
      if (isDef(oldVnode)) { invokeDestroyHook(oldVnode); }
      return
    }

    var isInitialPatch = false;
    var insertedVnodeQueue = [];

    if (isUndef(oldVnode)) {
      // empty mount (likely as component), create new root element
      isInitialPatch = true;
      createElm(vnode, insertedVnodeQueue, parentElm, refElm);
    } else {
      var isRealElement = isDef(oldVnode.nodeType);
      if (!isRealElement && sameVnode(oldVnode, vnode)) {
        // patch existing root node
        patchVnode(oldVnode, vnode, insertedVnodeQueue, removeOnly);
      } else {
        if (isRealElement) {
          // mounting to a real element
          // check if this is server-rendered content and if we can perform
          // a successful hydration.
          if (oldVnode.nodeType === 1 && oldVnode.hasAttribute(SSR_ATTR)) {
            oldVnode.removeAttribute(SSR_ATTR);
            hydrating = true;
          }
          if (isTrue(hydrating)) {
            if (hydrate(oldVnode, vnode, insertedVnodeQueue)) {
              invokeInsertHook(vnode, insertedVnodeQueue, true);
              return oldVnode
            } else if (true) {
              warn(
                'The client-side rendered virtual DOM tree is not matching ' +
                'server-rendered content. This is likely caused by incorrect ' +
                'HTML markup, for example nesting block-level elements inside ' +
                '<p>, or missing <tbody>. Bailing hydration and performing ' +
                'full client-side render.'
              );
            }
          }
          // either not server-rendered, or hydration failed.
          // create an empty node and replace it
          oldVnode = emptyNodeAt(oldVnode);
        }

        // replacing existing element
        var oldElm = oldVnode.elm;
        var parentElm$1 = nodeOps.parentNode(oldElm);

        // create new node
        createElm(
          vnode,
          insertedVnodeQueue,
          // extremely rare edge case: do not insert if old element is in a
          // leaving transition. Only happens when combining transition +
          // keep-alive + HOCs. (#4590)
          oldElm._leaveCb ? null : parentElm$1,
          nodeOps.nextSibling(oldElm)
        );

        // update parent placeholder node element, recursively
        if (isDef(vnode.parent)) {
          var ancestor = vnode.parent;
          var patchable = isPatchable(vnode);
          while (ancestor) {
            for (var i = 0; i < cbs.destroy.length; ++i) {
              cbs.destroy[i](ancestor);
            }
            ancestor.elm = vnode.elm;
            if (patchable) {
              for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
                cbs.create[i$1](emptyNode, ancestor);
              }
              // #6513
              // invoke insert hooks that may have been merged by create hooks.
              // e.g. for directives that uses the "inserted" hook.
              var insert = ancestor.data.hook.insert;
              if (insert.merged) {
                // start at index 1 to avoid re-invoking component mounted hook
                for (var i$2 = 1; i$2 < insert.fns.length; i$2++) {
                  insert.fns[i$2]();
                }
              }
            } else {
              registerRef(ancestor);
            }
            ancestor = ancestor.parent;
          }
        }

        // destroy old node
        if (isDef(parentElm$1)) {
          removeVnodes(parentElm$1, [oldVnode], 0, 0);
        } else if (isDef(oldVnode.tag)) {
          invokeDestroyHook(oldVnode);
        }
      }
    }

    invokeInsertHook(vnode, insertedVnodeQueue, isInitialPatch);
    return vnode.elm
  }
}

/*  */

var directives = {
  create: updateDirectives,
  update: updateDirectives,
  destroy: function unbindDirectives (vnode) {
    updateDirectives(vnode, emptyNode);
  }
}

function updateDirectives (oldVnode, vnode) {
  if (oldVnode.data.directives || vnode.data.directives) {
    _update(oldVnode, vnode);
  }
}

function _update (oldVnode, vnode) {
  var isCreate = oldVnode === emptyNode;
  var isDestroy = vnode === emptyNode;
  var oldDirs = normalizeDirectives$1(oldVnode.data.directives, oldVnode.context);
  var newDirs = normalizeDirectives$1(vnode.data.directives, vnode.context);

  var dirsWithInsert = [];
  var dirsWithPostpatch = [];

  var key, oldDir, dir;
  for (key in newDirs) {
    oldDir = oldDirs[key];
    dir = newDirs[key];
    if (!oldDir) {
      // new directive, bind
      callHook$1(dir, 'bind', vnode, oldVnode);
      if (dir.def && dir.def.inserted) {
        dirsWithInsert.push(dir);
      }
    } else {
      // existing directive, update
      dir.oldValue = oldDir.value;
      callHook$1(dir, 'update', vnode, oldVnode);
      if (dir.def && dir.def.componentUpdated) {
        dirsWithPostpatch.push(dir);
      }
    }
  }

  if (dirsWithInsert.length) {
    var callInsert = function () {
      for (var i = 0; i < dirsWithInsert.length; i++) {
        callHook$1(dirsWithInsert[i], 'inserted', vnode, oldVnode);
      }
    };
    if (isCreate) {
      mergeVNodeHook(vnode, 'insert', callInsert);
    } else {
      callInsert();
    }
  }

  if (dirsWithPostpatch.length) {
    mergeVNodeHook(vnode, 'postpatch', function () {
      for (var i = 0; i < dirsWithPostpatch.length; i++) {
        callHook$1(dirsWithPostpatch[i], 'componentUpdated', vnode, oldVnode);
      }
    });
  }

  if (!isCreate) {
    for (key in oldDirs) {
      if (!newDirs[key]) {
        // no longer present, unbind
        callHook$1(oldDirs[key], 'unbind', oldVnode, oldVnode, isDestroy);
      }
    }
  }
}

var emptyModifiers = Object.create(null);

function normalizeDirectives$1 (
  dirs,
  vm
) {
  var res = Object.create(null);
  if (!dirs) {
    // $flow-disable-line
    return res
  }
  var i, dir;
  for (i = 0; i < dirs.length; i++) {
    dir = dirs[i];
    if (!dir.modifiers) {
      // $flow-disable-line
      dir.modifiers = emptyModifiers;
    }
    res[getRawDirName(dir)] = dir;
    dir.def = resolveAsset(vm.$options, 'directives', dir.name, true);
  }
  // $flow-disable-line
  return res
}

function getRawDirName (dir) {
  return dir.rawName || ((dir.name) + "." + (Object.keys(dir.modifiers || {}).join('.')))
}

function callHook$1 (dir, hook, vnode, oldVnode, isDestroy) {
  var fn = dir.def && dir.def[hook];
  if (fn) {
    try {
      fn(vnode.elm, dir, vnode, oldVnode, isDestroy);
    } catch (e) {
      handleError(e, vnode.context, ("directive " + (dir.name) + " " + hook + " hook"));
    }
  }
}

var baseModules = [
  ref,
  directives
]

/*  */

function updateAttrs (oldVnode, vnode) {
  var opts = vnode.componentOptions;
  if (isDef(opts) && opts.Ctor.options.inheritAttrs === false) {
    return
  }
  if (isUndef(oldVnode.data.attrs) && isUndef(vnode.data.attrs)) {
    return
  }
  var key, cur, old;
  var elm = vnode.elm;
  var oldAttrs = oldVnode.data.attrs || {};
  var attrs = vnode.data.attrs || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(attrs.__ob__)) {
    attrs = vnode.data.attrs = extend({}, attrs);
  }

  for (key in attrs) {
    cur = attrs[key];
    old = oldAttrs[key];
    if (old !== cur) {
      setAttr(elm, key, cur);
    }
  }
  // #4391: in IE9, setting type can reset value for input[type=radio]
  // #6666: IE/Edge forces progress value down to 1 before setting a max
  /* istanbul ignore if */
  if ((isIE || isEdge) && attrs.value !== oldAttrs.value) {
    setAttr(elm, 'value', attrs.value);
  }
  for (key in oldAttrs) {
    if (isUndef(attrs[key])) {
      if (isXlink(key)) {
        elm.removeAttributeNS(xlinkNS, getXlinkProp(key));
      } else if (!isEnumeratedAttr(key)) {
        elm.removeAttribute(key);
      }
    }
  }
}

function setAttr (el, key, value) {
  if (el.tagName.indexOf('-') > -1) {
    baseSetAttr(el, key, value);
  } else if (isBooleanAttr(key)) {
    // set attribute for blank value
    // e.g. <option disabled>Select one</option>
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      // technically allowfullscreen is a boolean attribute for <iframe>,
      // but Flash expects a value of "true" when used on <embed> tag
      value = key === 'allowfullscreen' && el.tagName === 'EMBED'
        ? 'true'
        : key;
      el.setAttribute(key, value);
    }
  } else if (isEnumeratedAttr(key)) {
    el.setAttribute(key, isFalsyAttrValue(value) || value === 'false' ? 'false' : 'true');
  } else if (isXlink(key)) {
    if (isFalsyAttrValue(value)) {
      el.removeAttributeNS(xlinkNS, getXlinkProp(key));
    } else {
      el.setAttributeNS(xlinkNS, key, value);
    }
  } else {
    baseSetAttr(el, key, value);
  }
}

function baseSetAttr (el, key, value) {
  if (isFalsyAttrValue(value)) {
    el.removeAttribute(key);
  } else {
    // #7138: IE10 & 11 fires input event when setting placeholder on
    // <textarea>... block the first input event and remove the blocker
    // immediately.
    /* istanbul ignore if */
    if (
      isIE && !isIE9 &&
      el.tagName === 'TEXTAREA' &&
      key === 'placeholder' && !el.__ieph
    ) {
      var blocker = function (e) {
        e.stopImmediatePropagation();
        el.removeEventListener('input', blocker);
      };
      el.addEventListener('input', blocker);
      // $flow-disable-line
      el.__ieph = true; /* IE placeholder patched */
    }
    el.setAttribute(key, value);
  }
}

var attrs = {
  create: updateAttrs,
  update: updateAttrs
}

/*  */

function updateClass (oldVnode, vnode) {
  var el = vnode.elm;
  var data = vnode.data;
  var oldData = oldVnode.data;
  if (
    isUndef(data.staticClass) &&
    isUndef(data.class) && (
      isUndef(oldData) || (
        isUndef(oldData.staticClass) &&
        isUndef(oldData.class)
      )
    )
  ) {
    return
  }

  var cls = genClassForVnode(vnode);

  // handle transition classes
  var transitionClass = el._transitionClasses;
  if (isDef(transitionClass)) {
    cls = concat(cls, stringifyClass(transitionClass));
  }

  // set the class
  if (cls !== el._prevClass) {
    el.setAttribute('class', cls);
    el._prevClass = cls;
  }
}

var klass = {
  create: updateClass,
  update: updateClass
}

/*  */

var validDivisionCharRE = /[\w).+\-_$\]]/;

function parseFilters (exp) {
  var inSingle = false;
  var inDouble = false;
  var inTemplateString = false;
  var inRegex = false;
  var curly = 0;
  var square = 0;
  var paren = 0;
  var lastFilterIndex = 0;
  var c, prev, i, expression, filters;

  for (i = 0; i < exp.length; i++) {
    prev = c;
    c = exp.charCodeAt(i);
    if (inSingle) {
      if (c === 0x27 && prev !== 0x5C) { inSingle = false; }
    } else if (inDouble) {
      if (c === 0x22 && prev !== 0x5C) { inDouble = false; }
    } else if (inTemplateString) {
      if (c === 0x60 && prev !== 0x5C) { inTemplateString = false; }
    } else if (inRegex) {
      if (c === 0x2f && prev !== 0x5C) { inRegex = false; }
    } else if (
      c === 0x7C && // pipe
      exp.charCodeAt(i + 1) !== 0x7C &&
      exp.charCodeAt(i - 1) !== 0x7C &&
      !curly && !square && !paren
    ) {
      if (expression === undefined) {
        // first filter, end of expression
        lastFilterIndex = i + 1;
        expression = exp.slice(0, i).trim();
      } else {
        pushFilter();
      }
    } else {
      switch (c) {
        case 0x22: inDouble = true; break         // "
        case 0x27: inSingle = true; break         // '
        case 0x60: inTemplateString = true; break // `
        case 0x28: paren++; break                 // (
        case 0x29: paren--; break                 // )
        case 0x5B: square++; break                // [
        case 0x5D: square--; break                // ]
        case 0x7B: curly++; break                 // {
        case 0x7D: curly--; break                 // }
      }
      if (c === 0x2f) { // /
        var j = i - 1;
        var p = (void 0);
        // find first non-whitespace prev char
        for (; j >= 0; j--) {
          p = exp.charAt(j);
          if (p !== ' ') { break }
        }
        if (!p || !validDivisionCharRE.test(p)) {
          inRegex = true;
        }
      }
    }
  }

  if (expression === undefined) {
    expression = exp.slice(0, i).trim();
  } else if (lastFilterIndex !== 0) {
    pushFilter();
  }

  function pushFilter () {
    (filters || (filters = [])).push(exp.slice(lastFilterIndex, i).trim());
    lastFilterIndex = i + 1;
  }

  if (filters) {
    for (i = 0; i < filters.length; i++) {
      expression = wrapFilter(expression, filters[i]);
    }
  }

  return expression
}

function wrapFilter (exp, filter) {
  var i = filter.indexOf('(');
  if (i < 0) {
    // _f: resolveFilter
    return ("_f(\"" + filter + "\")(" + exp + ")")
  } else {
    var name = filter.slice(0, i);
    var args = filter.slice(i + 1);
    return ("_f(\"" + name + "\")(" + exp + (args !== ')' ? ',' + args : args))
  }
}

/*  */

function baseWarn (msg) {
  console.error(("[Vue compiler]: " + msg));
}

function pluckModuleFunction (
  modules,
  key
) {
  return modules
    ? modules.map(function (m) { return m[key]; }).filter(function (_) { return _; })
    : []
}

function addProp (el, name, value) {
  (el.props || (el.props = [])).push({ name: name, value: value });
  el.plain = false;
}

function addAttr (el, name, value) {
  (el.attrs || (el.attrs = [])).push({ name: name, value: value });
  el.plain = false;
}

// add a raw attr (use this in preTransforms)
function addRawAttr (el, name, value) {
  el.attrsMap[name] = value;
  el.attrsList.push({ name: name, value: value });
}

function addDirective (
  el,
  name,
  rawName,
  value,
  arg,
  modifiers
) {
  (el.directives || (el.directives = [])).push({ name: name, rawName: rawName, value: value, arg: arg, modifiers: modifiers });
  el.plain = false;
}

function addHandler (
  el,
  name,
  value,
  modifiers,
  important,
  warn
) {
  modifiers = modifiers || emptyObject;
  // warn prevent and passive modifier
  /* istanbul ignore if */
  if (
    "development" !== 'production' && warn &&
    modifiers.prevent && modifiers.passive
  ) {
    warn(
      'passive and prevent can\'t be used together. ' +
      'Passive handler can\'t prevent default event.'
    );
  }

  // check capture modifier
  if (modifiers.capture) {
    delete modifiers.capture;
    name = '!' + name; // mark the event as captured
  }
  if (modifiers.once) {
    delete modifiers.once;
    name = '~' + name; // mark the event as once
  }
  /* istanbul ignore if */
  if (modifiers.passive) {
    delete modifiers.passive;
    name = '&' + name; // mark the event as passive
  }

  // normalize click.right and click.middle since they don't actually fire
  // this is technically browser-specific, but at least for now browsers are
  // the only target envs that have right/middle clicks.
  if (name === 'click') {
    if (modifiers.right) {
      name = 'contextmenu';
      delete modifiers.right;
    } else if (modifiers.middle) {
      name = 'mouseup';
    }
  }

  var events;
  if (modifiers.native) {
    delete modifiers.native;
    events = el.nativeEvents || (el.nativeEvents = {});
  } else {
    events = el.events || (el.events = {});
  }

  var newHandler = {
    value: value.trim()
  };
  if (modifiers !== emptyObject) {
    newHandler.modifiers = modifiers;
  }

  var handlers = events[name];
  /* istanbul ignore if */
  if (Array.isArray(handlers)) {
    important ? handlers.unshift(newHandler) : handlers.push(newHandler);
  } else if (handlers) {
    events[name] = important ? [newHandler, handlers] : [handlers, newHandler];
  } else {
    events[name] = newHandler;
  }

  el.plain = false;
}

function getBindingAttr (
  el,
  name,
  getStatic
) {
  var dynamicValue =
    getAndRemoveAttr(el, ':' + name) ||
    getAndRemoveAttr(el, 'v-bind:' + name);
  if (dynamicValue != null) {
    return parseFilters(dynamicValue)
  } else if (getStatic !== false) {
    var staticValue = getAndRemoveAttr(el, name);
    if (staticValue != null) {
      return JSON.stringify(staticValue)
    }
  }
}

// note: this only removes the attr from the Array (attrsList) so that it
// doesn't get processed by processAttrs.
// By default it does NOT remove it from the map (attrsMap) because the map is
// needed during codegen.
function getAndRemoveAttr (
  el,
  name,
  removeFromMap
) {
  var val;
  if ((val = el.attrsMap[name]) != null) {
    var list = el.attrsList;
    for (var i = 0, l = list.length; i < l; i++) {
      if (list[i].name === name) {
        list.splice(i, 1);
        break
      }
    }
  }
  if (removeFromMap) {
    delete el.attrsMap[name];
  }
  return val
}

/*  */

/**
 * Cross-platform code generation for component v-model
 */
function genComponentModel (
  el,
  value,
  modifiers
) {
  var ref = modifiers || {};
  var number = ref.number;
  var trim = ref.trim;

  var baseValueExpression = '$$v';
  var valueExpression = baseValueExpression;
  if (trim) {
    valueExpression =
      "(typeof " + baseValueExpression + " === 'string'" +
      "? " + baseValueExpression + ".trim()" +
      ": " + baseValueExpression + ")";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }
  var assignment = genAssignmentCode(value, valueExpression);

  el.model = {
    value: ("(" + value + ")"),
    expression: ("\"" + value + "\""),
    callback: ("function (" + baseValueExpression + ") {" + assignment + "}")
  };
}

/**
 * Cross-platform codegen helper for generating v-model value assignment code.
 */
function genAssignmentCode (
  value,
  assignment
) {
  var res = parseModel(value);
  if (res.key === null) {
    return (value + "=" + assignment)
  } else {
    return ("$set(" + (res.exp) + ", " + (res.key) + ", " + assignment + ")")
  }
}

/**
 * Parse a v-model expression into a base path and a final key segment.
 * Handles both dot-path and possible square brackets.
 *
 * Possible cases:
 *
 * - test
 * - test[key]
 * - test[test1[key]]
 * - test["a"][key]
 * - xxx.test[a[a].test1[key]]
 * - test.xxx.a["asa"][test1[key]]
 *
 */

var len;
var str;
var chr;
var index$1;
var expressionPos;
var expressionEndPos;



function parseModel (val) {
  // Fix https://github.com/vuejs/vue/pull/7730
  // allow v-model="obj.val " (trailing whitespace)
  val = val.trim();
  len = val.length;

  if (val.indexOf('[') < 0 || val.lastIndexOf(']') < len - 1) {
    index$1 = val.lastIndexOf('.');
    if (index$1 > -1) {
      return {
        exp: val.slice(0, index$1),
        key: '"' + val.slice(index$1 + 1) + '"'
      }
    } else {
      return {
        exp: val,
        key: null
      }
    }
  }

  str = val;
  index$1 = expressionPos = expressionEndPos = 0;

  while (!eof()) {
    chr = next();
    /* istanbul ignore if */
    if (isStringStart(chr)) {
      parseString(chr);
    } else if (chr === 0x5B) {
      parseBracket(chr);
    }
  }

  return {
    exp: val.slice(0, expressionPos),
    key: val.slice(expressionPos + 1, expressionEndPos)
  }
}

function next () {
  return str.charCodeAt(++index$1)
}

function eof () {
  return index$1 >= len
}

function isStringStart (chr) {
  return chr === 0x22 || chr === 0x27
}

function parseBracket (chr) {
  var inBracket = 1;
  expressionPos = index$1;
  while (!eof()) {
    chr = next();
    if (isStringStart(chr)) {
      parseString(chr);
      continue
    }
    if (chr === 0x5B) { inBracket++; }
    if (chr === 0x5D) { inBracket--; }
    if (inBracket === 0) {
      expressionEndPos = index$1;
      break
    }
  }
}

function parseString (chr) {
  var stringQuote = chr;
  while (!eof()) {
    chr = next();
    if (chr === stringQuote) {
      break
    }
  }
}

/*  */

var warn$1;

// in some cases, the event used has to be determined at runtime
// so we used some reserved tokens during compile.
var RANGE_TOKEN = '__r';
var CHECKBOX_RADIO_TOKEN = '__c';

function model (
  el,
  dir,
  _warn
) {
  warn$1 = _warn;
  var value = dir.value;
  var modifiers = dir.modifiers;
  var tag = el.tag;
  var type = el.attrsMap.type;

  if (true) {
    // inputs with type="file" are read only and setting the input's
    // value will throw an error.
    if (tag === 'input' && type === 'file') {
      warn$1(
        "<" + (el.tag) + " v-model=\"" + value + "\" type=\"file\">:\n" +
        "File inputs are read only. Use a v-on:change listener instead."
      );
    }
  }

  if (el.component) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else if (tag === 'select') {
    genSelect(el, value, modifiers);
  } else if (tag === 'input' && type === 'checkbox') {
    genCheckboxModel(el, value, modifiers);
  } else if (tag === 'input' && type === 'radio') {
    genRadioModel(el, value, modifiers);
  } else if (tag === 'input' || tag === 'textarea') {
    genDefaultModel(el, value, modifiers);
  } else if (!config.isReservedTag(tag)) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else if (true) {
    warn$1(
      "<" + (el.tag) + " v-model=\"" + value + "\">: " +
      "v-model is not supported on this element type. " +
      'If you are working with contenteditable, it\'s recommended to ' +
      'wrap a library dedicated for that purpose inside a custom component.'
    );
  }

  // ensure runtime directive metadata
  return true
}

function genCheckboxModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  var trueValueBinding = getBindingAttr(el, 'true-value') || 'true';
  var falseValueBinding = getBindingAttr(el, 'false-value') || 'false';
  addProp(el, 'checked',
    "Array.isArray(" + value + ")" +
    "?_i(" + value + "," + valueBinding + ")>-1" + (
      trueValueBinding === 'true'
        ? (":(" + value + ")")
        : (":_q(" + value + "," + trueValueBinding + ")")
    )
  );
  addHandler(el, 'change',
    "var $$a=" + value + "," +
        '$$el=$event.target,' +
        "$$c=$$el.checked?(" + trueValueBinding + "):(" + falseValueBinding + ");" +
    'if(Array.isArray($$a)){' +
      "var $$v=" + (number ? '_n(' + valueBinding + ')' : valueBinding) + "," +
          '$$i=_i($$a,$$v);' +
      "if($$el.checked){$$i<0&&(" + (genAssignmentCode(value, '$$a.concat([$$v])')) + ")}" +
      "else{$$i>-1&&(" + (genAssignmentCode(value, '$$a.slice(0,$$i).concat($$a.slice($$i+1))')) + ")}" +
    "}else{" + (genAssignmentCode(value, '$$c')) + "}",
    null, true
  );
}

function genRadioModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  valueBinding = number ? ("_n(" + valueBinding + ")") : valueBinding;
  addProp(el, 'checked', ("_q(" + value + "," + valueBinding + ")"));
  addHandler(el, 'change', genAssignmentCode(value, valueBinding), null, true);
}

function genSelect (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var selectedVal = "Array.prototype.filter" +
    ".call($event.target.options,function(o){return o.selected})" +
    ".map(function(o){var val = \"_value\" in o ? o._value : o.value;" +
    "return " + (number ? '_n(val)' : 'val') + "})";

  var assignment = '$event.target.multiple ? $$selectedVal : $$selectedVal[0]';
  var code = "var $$selectedVal = " + selectedVal + ";";
  code = code + " " + (genAssignmentCode(value, assignment));
  addHandler(el, 'change', code, null, true);
}

function genDefaultModel (
  el,
  value,
  modifiers
) {
  var type = el.attrsMap.type;

  // warn if v-bind:value conflicts with v-model
  // except for inputs with v-bind:type
  if (true) {
    var value$1 = el.attrsMap['v-bind:value'] || el.attrsMap[':value'];
    var typeBinding = el.attrsMap['v-bind:type'] || el.attrsMap[':type'];
    if (value$1 && !typeBinding) {
      var binding = el.attrsMap['v-bind:value'] ? 'v-bind:value' : ':value';
      warn$1(
        binding + "=\"" + value$1 + "\" conflicts with v-model on the same element " +
        'because the latter already expands to a value binding internally'
      );
    }
  }

  var ref = modifiers || {};
  var lazy = ref.lazy;
  var number = ref.number;
  var trim = ref.trim;
  var needCompositionGuard = !lazy && type !== 'range';
  var event = lazy
    ? 'change'
    : type === 'range'
      ? RANGE_TOKEN
      : 'input';

  var valueExpression = '$event.target.value';
  if (trim) {
    valueExpression = "$event.target.value.trim()";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }

  var code = genAssignmentCode(value, valueExpression);
  if (needCompositionGuard) {
    code = "if($event.target.composing)return;" + code;
  }

  addProp(el, 'value', ("(" + value + ")"));
  addHandler(el, event, code, null, true);
  if (trim || number) {
    addHandler(el, 'blur', '$forceUpdate()');
  }
}

/*  */

// normalize v-model event tokens that can only be determined at runtime.
// it's important to place the event as the first in the array because
// the whole point is ensuring the v-model callback gets called before
// user-attached handlers.
function normalizeEvents (on) {
  /* istanbul ignore if */
  if (isDef(on[RANGE_TOKEN])) {
    // IE input[type=range] only supports `change` event
    var event = isIE ? 'change' : 'input';
    on[event] = [].concat(on[RANGE_TOKEN], on[event] || []);
    delete on[RANGE_TOKEN];
  }
  // This was originally intended to fix #4521 but no longer necessary
  // after 2.5. Keeping it for backwards compat with generated code from < 2.4
  /* istanbul ignore if */
  if (isDef(on[CHECKBOX_RADIO_TOKEN])) {
    on.change = [].concat(on[CHECKBOX_RADIO_TOKEN], on.change || []);
    delete on[CHECKBOX_RADIO_TOKEN];
  }
}

var target$1;

function createOnceHandler (handler, event, capture) {
  var _target = target$1; // save current target element in closure
  return function onceHandler () {
    var res = handler.apply(null, arguments);
    if (res !== null) {
      remove$2(event, onceHandler, capture, _target);
    }
  }
}

function add$1 (
  event,
  handler,
  once$$1,
  capture,
  passive
) {
  handler = withMacroTask(handler);
  if (once$$1) { handler = createOnceHandler(handler, event, capture); }
  target$1.addEventListener(
    event,
    handler,
    supportsPassive
      ? { capture: capture, passive: passive }
      : capture
  );
}

function remove$2 (
  event,
  handler,
  capture,
  _target
) {
  (_target || target$1).removeEventListener(
    event,
    handler._withTask || handler,
    capture
  );
}

function updateDOMListeners (oldVnode, vnode) {
  if (isUndef(oldVnode.data.on) && isUndef(vnode.data.on)) {
    return
  }
  var on = vnode.data.on || {};
  var oldOn = oldVnode.data.on || {};
  target$1 = vnode.elm;
  normalizeEvents(on);
  updateListeners(on, oldOn, add$1, remove$2, vnode.context);
  target$1 = undefined;
}

var events = {
  create: updateDOMListeners,
  update: updateDOMListeners
}

/*  */

function updateDOMProps (oldVnode, vnode) {
  if (isUndef(oldVnode.data.domProps) && isUndef(vnode.data.domProps)) {
    return
  }
  var key, cur;
  var elm = vnode.elm;
  var oldProps = oldVnode.data.domProps || {};
  var props = vnode.data.domProps || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(props.__ob__)) {
    props = vnode.data.domProps = extend({}, props);
  }

  for (key in oldProps) {
    if (isUndef(props[key])) {
      elm[key] = '';
    }
  }
  for (key in props) {
    cur = props[key];
    // ignore children if the node has textContent or innerHTML,
    // as these will throw away existing DOM nodes and cause removal errors
    // on subsequent patches (#3360)
    if (key === 'textContent' || key === 'innerHTML') {
      if (vnode.children) { vnode.children.length = 0; }
      if (cur === oldProps[key]) { continue }
      // #6601 work around Chrome version <= 55 bug where single textNode
      // replaced by innerHTML/textContent retains its parentNode property
      if (elm.childNodes.length === 1) {
        elm.removeChild(elm.childNodes[0]);
      }
    }

    if (key === 'value') {
      // store value as _value as well since
      // non-string values will be stringified
      elm._value = cur;
      // avoid resetting cursor position when value is the same
      var strCur = isUndef(cur) ? '' : String(cur);
      if (shouldUpdateValue(elm, strCur)) {
        elm.value = strCur;
      }
    } else {
      elm[key] = cur;
    }
  }
}

// check platforms/web/util/attrs.js acceptValue


function shouldUpdateValue (elm, checkVal) {
  return (!elm.composing && (
    elm.tagName === 'OPTION' ||
    isNotInFocusAndDirty(elm, checkVal) ||
    isDirtyWithModifiers(elm, checkVal)
  ))
}

function isNotInFocusAndDirty (elm, checkVal) {
  // return true when textbox (.number and .trim) loses focus and its value is
  // not equal to the updated value
  var notInFocus = true;
  // #6157
  // work around IE bug when accessing document.activeElement in an iframe
  try { notInFocus = document.activeElement !== elm; } catch (e) {}
  return notInFocus && elm.value !== checkVal
}

function isDirtyWithModifiers (elm, newVal) {
  var value = elm.value;
  var modifiers = elm._vModifiers; // injected by v-model runtime
  if (isDef(modifiers)) {
    if (modifiers.lazy) {
      // inputs with lazy should only be updated when not in focus
      return false
    }
    if (modifiers.number) {
      return toNumber(value) !== toNumber(newVal)
    }
    if (modifiers.trim) {
      return value.trim() !== newVal.trim()
    }
  }
  return value !== newVal
}

var domProps = {
  create: updateDOMProps,
  update: updateDOMProps
}

/*  */

var parseStyleText = cached(function (cssText) {
  var res = {};
  var listDelimiter = /;(?![^(]*\))/g;
  var propertyDelimiter = /:(.+)/;
  cssText.split(listDelimiter).forEach(function (item) {
    if (item) {
      var tmp = item.split(propertyDelimiter);
      tmp.length > 1 && (res[tmp[0].trim()] = tmp[1].trim());
    }
  });
  return res
});

// merge static and dynamic style data on the same vnode
function normalizeStyleData (data) {
  var style = normalizeStyleBinding(data.style);
  // static style is pre-processed into an object during compilation
  // and is always a fresh object, so it's safe to merge into it
  return data.staticStyle
    ? extend(data.staticStyle, style)
    : style
}

// normalize possible array / string values into Object
function normalizeStyleBinding (bindingStyle) {
  if (Array.isArray(bindingStyle)) {
    return toObject(bindingStyle)
  }
  if (typeof bindingStyle === 'string') {
    return parseStyleText(bindingStyle)
  }
  return bindingStyle
}

/**
 * parent component style should be after child's
 * so that parent component's style could override it
 */
function getStyle (vnode, checkChild) {
  var res = {};
  var styleData;

  if (checkChild) {
    var childNode = vnode;
    while (childNode.componentInstance) {
      childNode = childNode.componentInstance._vnode;
      if (
        childNode && childNode.data &&
        (styleData = normalizeStyleData(childNode.data))
      ) {
        extend(res, styleData);
      }
    }
  }

  if ((styleData = normalizeStyleData(vnode.data))) {
    extend(res, styleData);
  }

  var parentNode = vnode;
  while ((parentNode = parentNode.parent)) {
    if (parentNode.data && (styleData = normalizeStyleData(parentNode.data))) {
      extend(res, styleData);
    }
  }
  return res
}

/*  */

var cssVarRE = /^--/;
var importantRE = /\s*!important$/;
var setProp = function (el, name, val) {
  /* istanbul ignore if */
  if (cssVarRE.test(name)) {
    el.style.setProperty(name, val);
  } else if (importantRE.test(val)) {
    el.style.setProperty(name, val.replace(importantRE, ''), 'important');
  } else {
    var normalizedName = normalize(name);
    if (Array.isArray(val)) {
      // Support values array created by autoprefixer, e.g.
      // {display: ["-webkit-box", "-ms-flexbox", "flex"]}
      // Set them one by one, and the browser will only set those it can recognize
      for (var i = 0, len = val.length; i < len; i++) {
        el.style[normalizedName] = val[i];
      }
    } else {
      el.style[normalizedName] = val;
    }
  }
};

var vendorNames = ['Webkit', 'Moz', 'ms'];

var emptyStyle;
var normalize = cached(function (prop) {
  emptyStyle = emptyStyle || document.createElement('div').style;
  prop = camelize(prop);
  if (prop !== 'filter' && (prop in emptyStyle)) {
    return prop
  }
  var capName = prop.charAt(0).toUpperCase() + prop.slice(1);
  for (var i = 0; i < vendorNames.length; i++) {
    var name = vendorNames[i] + capName;
    if (name in emptyStyle) {
      return name
    }
  }
});

function updateStyle (oldVnode, vnode) {
  var data = vnode.data;
  var oldData = oldVnode.data;

  if (isUndef(data.staticStyle) && isUndef(data.style) &&
    isUndef(oldData.staticStyle) && isUndef(oldData.style)
  ) {
    return
  }

  var cur, name;
  var el = vnode.elm;
  var oldStaticStyle = oldData.staticStyle;
  var oldStyleBinding = oldData.normalizedStyle || oldData.style || {};

  // if static style exists, stylebinding already merged into it when doing normalizeStyleData
  var oldStyle = oldStaticStyle || oldStyleBinding;

  var style = normalizeStyleBinding(vnode.data.style) || {};

  // store normalized style under a different key for next diff
  // make sure to clone it if it's reactive, since the user likely wants
  // to mutate it.
  vnode.data.normalizedStyle = isDef(style.__ob__)
    ? extend({}, style)
    : style;

  var newStyle = getStyle(vnode, true);

  for (name in oldStyle) {
    if (isUndef(newStyle[name])) {
      setProp(el, name, '');
    }
  }
  for (name in newStyle) {
    cur = newStyle[name];
    if (cur !== oldStyle[name]) {
      // ie9 setting to null has no effect, must use empty string
      setProp(el, name, cur == null ? '' : cur);
    }
  }
}

var style = {
  create: updateStyle,
  update: updateStyle
}

/*  */

/**
 * Add class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function addClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.add(c); });
    } else {
      el.classList.add(cls);
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    if (cur.indexOf(' ' + cls + ' ') < 0) {
      el.setAttribute('class', (cur + cls).trim());
    }
  }
}

/**
 * Remove class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function removeClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.remove(c); });
    } else {
      el.classList.remove(cls);
    }
    if (!el.classList.length) {
      el.removeAttribute('class');
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    var tar = ' ' + cls + ' ';
    while (cur.indexOf(tar) >= 0) {
      cur = cur.replace(tar, ' ');
    }
    cur = cur.trim();
    if (cur) {
      el.setAttribute('class', cur);
    } else {
      el.removeAttribute('class');
    }
  }
}

/*  */

function resolveTransition (def) {
  if (!def) {
    return
  }
  /* istanbul ignore else */
  if (typeof def === 'object') {
    var res = {};
    if (def.css !== false) {
      extend(res, autoCssTransition(def.name || 'v'));
    }
    extend(res, def);
    return res
  } else if (typeof def === 'string') {
    return autoCssTransition(def)
  }
}

var autoCssTransition = cached(function (name) {
  return {
    enterClass: (name + "-enter"),
    enterToClass: (name + "-enter-to"),
    enterActiveClass: (name + "-enter-active"),
    leaveClass: (name + "-leave"),
    leaveToClass: (name + "-leave-to"),
    leaveActiveClass: (name + "-leave-active")
  }
});

var hasTransition = inBrowser && !isIE9;
var TRANSITION = 'transition';
var ANIMATION = 'animation';

// Transition property/event sniffing
var transitionProp = 'transition';
var transitionEndEvent = 'transitionend';
var animationProp = 'animation';
var animationEndEvent = 'animationend';
if (hasTransition) {
  /* istanbul ignore if */
  if (window.ontransitionend === undefined &&
    window.onwebkittransitionend !== undefined
  ) {
    transitionProp = 'WebkitTransition';
    transitionEndEvent = 'webkitTransitionEnd';
  }
  if (window.onanimationend === undefined &&
    window.onwebkitanimationend !== undefined
  ) {
    animationProp = 'WebkitAnimation';
    animationEndEvent = 'webkitAnimationEnd';
  }
}

// binding to window is necessary to make hot reload work in IE in strict mode
var raf = inBrowser
  ? window.requestAnimationFrame
    ? window.requestAnimationFrame.bind(window)
    : setTimeout
  : /* istanbul ignore next */ function (fn) { return fn(); };

function nextFrame (fn) {
  raf(function () {
    raf(fn);
  });
}

function addTransitionClass (el, cls) {
  var transitionClasses = el._transitionClasses || (el._transitionClasses = []);
  if (transitionClasses.indexOf(cls) < 0) {
    transitionClasses.push(cls);
    addClass(el, cls);
  }
}

function removeTransitionClass (el, cls) {
  if (el._transitionClasses) {
    remove(el._transitionClasses, cls);
  }
  removeClass(el, cls);
}

function whenTransitionEnds (
  el,
  expectedType,
  cb
) {
  var ref = getTransitionInfo(el, expectedType);
  var type = ref.type;
  var timeout = ref.timeout;
  var propCount = ref.propCount;
  if (!type) { return cb() }
  var event = type === TRANSITION ? transitionEndEvent : animationEndEvent;
  var ended = 0;
  var end = function () {
    el.removeEventListener(event, onEnd);
    cb();
  };
  var onEnd = function (e) {
    if (e.target === el) {
      if (++ended >= propCount) {
        end();
      }
    }
  };
  setTimeout(function () {
    if (ended < propCount) {
      end();
    }
  }, timeout + 1);
  el.addEventListener(event, onEnd);
}

var transformRE = /\b(transform|all)(,|$)/;

function getTransitionInfo (el, expectedType) {
  var styles = window.getComputedStyle(el);
  var transitionDelays = styles[transitionProp + 'Delay'].split(', ');
  var transitionDurations = styles[transitionProp + 'Duration'].split(', ');
  var transitionTimeout = getTimeout(transitionDelays, transitionDurations);
  var animationDelays = styles[animationProp + 'Delay'].split(', ');
  var animationDurations = styles[animationProp + 'Duration'].split(', ');
  var animationTimeout = getTimeout(animationDelays, animationDurations);

  var type;
  var timeout = 0;
  var propCount = 0;
  /* istanbul ignore if */
  if (expectedType === TRANSITION) {
    if (transitionTimeout > 0) {
      type = TRANSITION;
      timeout = transitionTimeout;
      propCount = transitionDurations.length;
    }
  } else if (expectedType === ANIMATION) {
    if (animationTimeout > 0) {
      type = ANIMATION;
      timeout = animationTimeout;
      propCount = animationDurations.length;
    }
  } else {
    timeout = Math.max(transitionTimeout, animationTimeout);
    type = timeout > 0
      ? transitionTimeout > animationTimeout
        ? TRANSITION
        : ANIMATION
      : null;
    propCount = type
      ? type === TRANSITION
        ? transitionDurations.length
        : animationDurations.length
      : 0;
  }
  var hasTransform =
    type === TRANSITION &&
    transformRE.test(styles[transitionProp + 'Property']);
  return {
    type: type,
    timeout: timeout,
    propCount: propCount,
    hasTransform: hasTransform
  }
}

function getTimeout (delays, durations) {
  /* istanbul ignore next */
  while (delays.length < durations.length) {
    delays = delays.concat(delays);
  }

  return Math.max.apply(null, durations.map(function (d, i) {
    return toMs(d) + toMs(delays[i])
  }))
}

function toMs (s) {
  return Number(s.slice(0, -1)) * 1000
}

/*  */

function enter (vnode, toggleDisplay) {
  var el = vnode.elm;

  // call leave callback now
  if (isDef(el._leaveCb)) {
    el._leaveCb.cancelled = true;
    el._leaveCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data)) {
    return
  }

  /* istanbul ignore if */
  if (isDef(el._enterCb) || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var enterClass = data.enterClass;
  var enterToClass = data.enterToClass;
  var enterActiveClass = data.enterActiveClass;
  var appearClass = data.appearClass;
  var appearToClass = data.appearToClass;
  var appearActiveClass = data.appearActiveClass;
  var beforeEnter = data.beforeEnter;
  var enter = data.enter;
  var afterEnter = data.afterEnter;
  var enterCancelled = data.enterCancelled;
  var beforeAppear = data.beforeAppear;
  var appear = data.appear;
  var afterAppear = data.afterAppear;
  var appearCancelled = data.appearCancelled;
  var duration = data.duration;

  // activeInstance will always be the <transition> component managing this
  // transition. One edge case to check is when the <transition> is placed
  // as the root node of a child component. In that case we need to check
  // <transition>'s parent for appear check.
  var context = activeInstance;
  var transitionNode = activeInstance.$vnode;
  while (transitionNode && transitionNode.parent) {
    transitionNode = transitionNode.parent;
    context = transitionNode.context;
  }

  var isAppear = !context._isMounted || !vnode.isRootInsert;

  if (isAppear && !appear && appear !== '') {
    return
  }

  var startClass = isAppear && appearClass
    ? appearClass
    : enterClass;
  var activeClass = isAppear && appearActiveClass
    ? appearActiveClass
    : enterActiveClass;
  var toClass = isAppear && appearToClass
    ? appearToClass
    : enterToClass;

  var beforeEnterHook = isAppear
    ? (beforeAppear || beforeEnter)
    : beforeEnter;
  var enterHook = isAppear
    ? (typeof appear === 'function' ? appear : enter)
    : enter;
  var afterEnterHook = isAppear
    ? (afterAppear || afterEnter)
    : afterEnter;
  var enterCancelledHook = isAppear
    ? (appearCancelled || enterCancelled)
    : enterCancelled;

  var explicitEnterDuration = toNumber(
    isObject(duration)
      ? duration.enter
      : duration
  );

  if ("development" !== 'production' && explicitEnterDuration != null) {
    checkDuration(explicitEnterDuration, 'enter', vnode);
  }

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(enterHook);

  var cb = el._enterCb = once(function () {
    if (expectsCSS) {
      removeTransitionClass(el, toClass);
      removeTransitionClass(el, activeClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, startClass);
      }
      enterCancelledHook && enterCancelledHook(el);
    } else {
      afterEnterHook && afterEnterHook(el);
    }
    el._enterCb = null;
  });

  if (!vnode.data.show) {
    // remove pending leave element on enter by injecting an insert hook
    mergeVNodeHook(vnode, 'insert', function () {
      var parent = el.parentNode;
      var pendingNode = parent && parent._pending && parent._pending[vnode.key];
      if (pendingNode &&
        pendingNode.tag === vnode.tag &&
        pendingNode.elm._leaveCb
      ) {
        pendingNode.elm._leaveCb();
      }
      enterHook && enterHook(el, cb);
    });
  }

  // start enter transition
  beforeEnterHook && beforeEnterHook(el);
  if (expectsCSS) {
    addTransitionClass(el, startClass);
    addTransitionClass(el, activeClass);
    nextFrame(function () {
      removeTransitionClass(el, startClass);
      if (!cb.cancelled) {
        addTransitionClass(el, toClass);
        if (!userWantsControl) {
          if (isValidDuration(explicitEnterDuration)) {
            setTimeout(cb, explicitEnterDuration);
          } else {
            whenTransitionEnds(el, type, cb);
          }
        }
      }
    });
  }

  if (vnode.data.show) {
    toggleDisplay && toggleDisplay();
    enterHook && enterHook(el, cb);
  }

  if (!expectsCSS && !userWantsControl) {
    cb();
  }
}

function leave (vnode, rm) {
  var el = vnode.elm;

  // call enter callback now
  if (isDef(el._enterCb)) {
    el._enterCb.cancelled = true;
    el._enterCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data) || el.nodeType !== 1) {
    return rm()
  }

  /* istanbul ignore if */
  if (isDef(el._leaveCb)) {
    return
  }

  var css = data.css;
  var type = data.type;
  var leaveClass = data.leaveClass;
  var leaveToClass = data.leaveToClass;
  var leaveActiveClass = data.leaveActiveClass;
  var beforeLeave = data.beforeLeave;
  var leave = data.leave;
  var afterLeave = data.afterLeave;
  var leaveCancelled = data.leaveCancelled;
  var delayLeave = data.delayLeave;
  var duration = data.duration;

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(leave);

  var explicitLeaveDuration = toNumber(
    isObject(duration)
      ? duration.leave
      : duration
  );

  if ("development" !== 'production' && isDef(explicitLeaveDuration)) {
    checkDuration(explicitLeaveDuration, 'leave', vnode);
  }

  var cb = el._leaveCb = once(function () {
    if (el.parentNode && el.parentNode._pending) {
      el.parentNode._pending[vnode.key] = null;
    }
    if (expectsCSS) {
      removeTransitionClass(el, leaveToClass);
      removeTransitionClass(el, leaveActiveClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, leaveClass);
      }
      leaveCancelled && leaveCancelled(el);
    } else {
      rm();
      afterLeave && afterLeave(el);
    }
    el._leaveCb = null;
  });

  if (delayLeave) {
    delayLeave(performLeave);
  } else {
    performLeave();
  }

  function performLeave () {
    // the delayed leave may have already been cancelled
    if (cb.cancelled) {
      return
    }
    // record leaving element
    if (!vnode.data.show) {
      (el.parentNode._pending || (el.parentNode._pending = {}))[(vnode.key)] = vnode;
    }
    beforeLeave && beforeLeave(el);
    if (expectsCSS) {
      addTransitionClass(el, leaveClass);
      addTransitionClass(el, leaveActiveClass);
      nextFrame(function () {
        removeTransitionClass(el, leaveClass);
        if (!cb.cancelled) {
          addTransitionClass(el, leaveToClass);
          if (!userWantsControl) {
            if (isValidDuration(explicitLeaveDuration)) {
              setTimeout(cb, explicitLeaveDuration);
            } else {
              whenTransitionEnds(el, type, cb);
            }
          }
        }
      });
    }
    leave && leave(el, cb);
    if (!expectsCSS && !userWantsControl) {
      cb();
    }
  }
}

// only used in dev mode
function checkDuration (val, name, vnode) {
  if (typeof val !== 'number') {
    warn(
      "<transition> explicit " + name + " duration is not a valid number - " +
      "got " + (JSON.stringify(val)) + ".",
      vnode.context
    );
  } else if (isNaN(val)) {
    warn(
      "<transition> explicit " + name + " duration is NaN - " +
      'the duration expression might be incorrect.',
      vnode.context
    );
  }
}

function isValidDuration (val) {
  return typeof val === 'number' && !isNaN(val)
}

/**
 * Normalize a transition hook's argument length. The hook may be:
 * - a merged hook (invoker) with the original in .fns
 * - a wrapped component method (check ._length)
 * - a plain function (.length)
 */
function getHookArgumentsLength (fn) {
  if (isUndef(fn)) {
    return false
  }
  var invokerFns = fn.fns;
  if (isDef(invokerFns)) {
    // invoker
    return getHookArgumentsLength(
      Array.isArray(invokerFns)
        ? invokerFns[0]
        : invokerFns
    )
  } else {
    return (fn._length || fn.length) > 1
  }
}

function _enter (_, vnode) {
  if (vnode.data.show !== true) {
    enter(vnode);
  }
}

var transition = inBrowser ? {
  create: _enter,
  activate: _enter,
  remove: function remove$$1 (vnode, rm) {
    /* istanbul ignore else */
    if (vnode.data.show !== true) {
      leave(vnode, rm);
    } else {
      rm();
    }
  }
} : {}

var platformModules = [
  attrs,
  klass,
  events,
  domProps,
  style,
  transition
]

/*  */

// the directive module should be applied last, after all
// built-in modules have been applied.
var modules = platformModules.concat(baseModules);

var patch = createPatchFunction({ nodeOps: nodeOps, modules: modules });

/**
 * Not type checking this file because flow doesn't like attaching
 * properties to Elements.
 */

/* istanbul ignore if */
if (isIE9) {
  // http://www.matts411.com/post/internet-explorer-9-oninput/
  document.addEventListener('selectionchange', function () {
    var el = document.activeElement;
    if (el && el.vmodel) {
      trigger(el, 'input');
    }
  });
}

var directive = {
  inserted: function inserted (el, binding, vnode, oldVnode) {
    if (vnode.tag === 'select') {
      // #6903
      if (oldVnode.elm && !oldVnode.elm._vOptions) {
        mergeVNodeHook(vnode, 'postpatch', function () {
          directive.componentUpdated(el, binding, vnode);
        });
      } else {
        setSelected(el, binding, vnode.context);
      }
      el._vOptions = [].map.call(el.options, getValue);
    } else if (vnode.tag === 'textarea' || isTextInputType(el.type)) {
      el._vModifiers = binding.modifiers;
      if (!binding.modifiers.lazy) {
        el.addEventListener('compositionstart', onCompositionStart);
        el.addEventListener('compositionend', onCompositionEnd);
        // Safari < 10.2 & UIWebView doesn't fire compositionend when
        // switching focus before confirming composition choice
        // this also fixes the issue where some browsers e.g. iOS Chrome
        // fires "change" instead of "input" on autocomplete.
        el.addEventListener('change', onCompositionEnd);
        /* istanbul ignore if */
        if (isIE9) {
          el.vmodel = true;
        }
      }
    }
  },

  componentUpdated: function componentUpdated (el, binding, vnode) {
    if (vnode.tag === 'select') {
      setSelected(el, binding, vnode.context);
      // in case the options rendered by v-for have changed,
      // it's possible that the value is out-of-sync with the rendered options.
      // detect such cases and filter out values that no longer has a matching
      // option in the DOM.
      var prevOptions = el._vOptions;
      var curOptions = el._vOptions = [].map.call(el.options, getValue);
      if (curOptions.some(function (o, i) { return !looseEqual(o, prevOptions[i]); })) {
        // trigger change event if
        // no matching option found for at least one value
        var needReset = el.multiple
          ? binding.value.some(function (v) { return hasNoMatchingOption(v, curOptions); })
          : binding.value !== binding.oldValue && hasNoMatchingOption(binding.value, curOptions);
        if (needReset) {
          trigger(el, 'change');
        }
      }
    }
  }
};

function setSelected (el, binding, vm) {
  actuallySetSelected(el, binding, vm);
  /* istanbul ignore if */
  if (isIE || isEdge) {
    setTimeout(function () {
      actuallySetSelected(el, binding, vm);
    }, 0);
  }
}

function actuallySetSelected (el, binding, vm) {
  var value = binding.value;
  var isMultiple = el.multiple;
  if (isMultiple && !Array.isArray(value)) {
    "development" !== 'production' && warn(
      "<select multiple v-model=\"" + (binding.expression) + "\"> " +
      "expects an Array value for its binding, but got " + (Object.prototype.toString.call(value).slice(8, -1)),
      vm
    );
    return
  }
  var selected, option;
  for (var i = 0, l = el.options.length; i < l; i++) {
    option = el.options[i];
    if (isMultiple) {
      selected = looseIndexOf(value, getValue(option)) > -1;
      if (option.selected !== selected) {
        option.selected = selected;
      }
    } else {
      if (looseEqual(getValue(option), value)) {
        if (el.selectedIndex !== i) {
          el.selectedIndex = i;
        }
        return
      }
    }
  }
  if (!isMultiple) {
    el.selectedIndex = -1;
  }
}

function hasNoMatchingOption (value, options) {
  return options.every(function (o) { return !looseEqual(o, value); })
}

function getValue (option) {
  return '_value' in option
    ? option._value
    : option.value
}

function onCompositionStart (e) {
  e.target.composing = true;
}

function onCompositionEnd (e) {
  // prevent triggering an input event for no reason
  if (!e.target.composing) { return }
  e.target.composing = false;
  trigger(e.target, 'input');
}

function trigger (el, type) {
  var e = document.createEvent('HTMLEvents');
  e.initEvent(type, true, true);
  el.dispatchEvent(e);
}

/*  */

// recursively search for possible transition defined inside the component root
function locateNode (vnode) {
  return vnode.componentInstance && (!vnode.data || !vnode.data.transition)
    ? locateNode(vnode.componentInstance._vnode)
    : vnode
}

var show = {
  bind: function bind (el, ref, vnode) {
    var value = ref.value;

    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    var originalDisplay = el.__vOriginalDisplay =
      el.style.display === 'none' ? '' : el.style.display;
    if (value && transition$$1) {
      vnode.data.show = true;
      enter(vnode, function () {
        el.style.display = originalDisplay;
      });
    } else {
      el.style.display = value ? originalDisplay : 'none';
    }
  },

  update: function update (el, ref, vnode) {
    var value = ref.value;
    var oldValue = ref.oldValue;

    /* istanbul ignore if */
    if (!value === !oldValue) { return }
    vnode = locateNode(vnode);
    var transition$$1 = vnode.data && vnode.data.transition;
    if (transition$$1) {
      vnode.data.show = true;
      if (value) {
        enter(vnode, function () {
          el.style.display = el.__vOriginalDisplay;
        });
      } else {
        leave(vnode, function () {
          el.style.display = 'none';
        });
      }
    } else {
      el.style.display = value ? el.__vOriginalDisplay : 'none';
    }
  },

  unbind: function unbind (
    el,
    binding,
    vnode,
    oldVnode,
    isDestroy
  ) {
    if (!isDestroy) {
      el.style.display = el.__vOriginalDisplay;
    }
  }
}

var platformDirectives = {
  model: directive,
  show: show
}

/*  */

// Provides transition support for a single element/component.
// supports transition mode (out-in / in-out)

var transitionProps = {
  name: String,
  appear: Boolean,
  css: Boolean,
  mode: String,
  type: String,
  enterClass: String,
  leaveClass: String,
  enterToClass: String,
  leaveToClass: String,
  enterActiveClass: String,
  leaveActiveClass: String,
  appearClass: String,
  appearActiveClass: String,
  appearToClass: String,
  duration: [Number, String, Object]
};

// in case the child is also an abstract component, e.g. <keep-alive>
// we want to recursively retrieve the real component to be rendered
function getRealChild (vnode) {
  var compOptions = vnode && vnode.componentOptions;
  if (compOptions && compOptions.Ctor.options.abstract) {
    return getRealChild(getFirstComponentChild(compOptions.children))
  } else {
    return vnode
  }
}

function extractTransitionData (comp) {
  var data = {};
  var options = comp.$options;
  // props
  for (var key in options.propsData) {
    data[key] = comp[key];
  }
  // events.
  // extract listeners and pass them directly to the transition methods
  var listeners = options._parentListeners;
  for (var key$1 in listeners) {
    data[camelize(key$1)] = listeners[key$1];
  }
  return data
}

function placeholder (h, rawChild) {
  if (/\d-keep-alive$/.test(rawChild.tag)) {
    return h('keep-alive', {
      props: rawChild.componentOptions.propsData
    })
  }
}

function hasParentTransition (vnode) {
  while ((vnode = vnode.parent)) {
    if (vnode.data.transition) {
      return true
    }
  }
}

function isSameChild (child, oldChild) {
  return oldChild.key === child.key && oldChild.tag === child.tag
}

var Transition = {
  name: 'transition',
  props: transitionProps,
  abstract: true,

  render: function render (h) {
    var this$1 = this;

    var children = this.$slots.default;
    if (!children) {
      return
    }

    // filter out text nodes (possible whitespaces)
    children = children.filter(function (c) { return c.tag || isAsyncPlaceholder(c); });
    /* istanbul ignore if */
    if (!children.length) {
      return
    }

    // warn multiple elements
    if ("development" !== 'production' && children.length > 1) {
      warn(
        '<transition> can only be used on a single element. Use ' +
        '<transition-group> for lists.',
        this.$parent
      );
    }

    var mode = this.mode;

    // warn invalid mode
    if ("development" !== 'production' &&
      mode && mode !== 'in-out' && mode !== 'out-in'
    ) {
      warn(
        'invalid <transition> mode: ' + mode,
        this.$parent
      );
    }

    var rawChild = children[0];

    // if this is a component root node and the component's
    // parent container node also has transition, skip.
    if (hasParentTransition(this.$vnode)) {
      return rawChild
    }

    // apply transition data to child
    // use getRealChild() to ignore abstract components e.g. keep-alive
    var child = getRealChild(rawChild);
    /* istanbul ignore if */
    if (!child) {
      return rawChild
    }

    if (this._leaving) {
      return placeholder(h, rawChild)
    }

    // ensure a key that is unique to the vnode type and to this transition
    // component instance. This key will be used to remove pending leaving nodes
    // during entering.
    var id = "__transition-" + (this._uid) + "-";
    child.key = child.key == null
      ? child.isComment
        ? id + 'comment'
        : id + child.tag
      : isPrimitive(child.key)
        ? (String(child.key).indexOf(id) === 0 ? child.key : id + child.key)
        : child.key;

    var data = (child.data || (child.data = {})).transition = extractTransitionData(this);
    var oldRawChild = this._vnode;
    var oldChild = getRealChild(oldRawChild);

    // mark v-show
    // so that the transition module can hand over the control to the directive
    if (child.data.directives && child.data.directives.some(function (d) { return d.name === 'show'; })) {
      child.data.show = true;
    }

    if (
      oldChild &&
      oldChild.data &&
      !isSameChild(child, oldChild) &&
      !isAsyncPlaceholder(oldChild) &&
      // #6687 component root is a comment node
      !(oldChild.componentInstance && oldChild.componentInstance._vnode.isComment)
    ) {
      // replace old child transition data with fresh one
      // important for dynamic transitions!
      var oldData = oldChild.data.transition = extend({}, data);
      // handle transition mode
      if (mode === 'out-in') {
        // return placeholder node and queue update when leave finishes
        this._leaving = true;
        mergeVNodeHook(oldData, 'afterLeave', function () {
          this$1._leaving = false;
          this$1.$forceUpdate();
        });
        return placeholder(h, rawChild)
      } else if (mode === 'in-out') {
        if (isAsyncPlaceholder(child)) {
          return oldRawChild
        }
        var delayedLeave;
        var performLeave = function () { delayedLeave(); };
        mergeVNodeHook(data, 'afterEnter', performLeave);
        mergeVNodeHook(data, 'enterCancelled', performLeave);
        mergeVNodeHook(oldData, 'delayLeave', function (leave) { delayedLeave = leave; });
      }
    }

    return rawChild
  }
}

/*  */

// Provides transition support for list items.
// supports move transitions using the FLIP technique.

// Because the vdom's children update algorithm is "unstable" - i.e.
// it doesn't guarantee the relative positioning of removed elements,
// we force transition-group to update its children into two passes:
// in the first pass, we remove all nodes that need to be removed,
// triggering their leaving transition; in the second pass, we insert/move
// into the final desired state. This way in the second pass removed
// nodes will remain where they should be.

var props = extend({
  tag: String,
  moveClass: String
}, transitionProps);

delete props.mode;

var TransitionGroup = {
  props: props,

  render: function render (h) {
    var tag = this.tag || this.$vnode.data.tag || 'span';
    var map = Object.create(null);
    var prevChildren = this.prevChildren = this.children;
    var rawChildren = this.$slots.default || [];
    var children = this.children = [];
    var transitionData = extractTransitionData(this);

    for (var i = 0; i < rawChildren.length; i++) {
      var c = rawChildren[i];
      if (c.tag) {
        if (c.key != null && String(c.key).indexOf('__vlist') !== 0) {
          children.push(c);
          map[c.key] = c
          ;(c.data || (c.data = {})).transition = transitionData;
        } else if (true) {
          var opts = c.componentOptions;
          var name = opts ? (opts.Ctor.options.name || opts.tag || '') : c.tag;
          warn(("<transition-group> children must be keyed: <" + name + ">"));
        }
      }
    }

    if (prevChildren) {
      var kept = [];
      var removed = [];
      for (var i$1 = 0; i$1 < prevChildren.length; i$1++) {
        var c$1 = prevChildren[i$1];
        c$1.data.transition = transitionData;
        c$1.data.pos = c$1.elm.getBoundingClientRect();
        if (map[c$1.key]) {
          kept.push(c$1);
        } else {
          removed.push(c$1);
        }
      }
      this.kept = h(tag, null, kept);
      this.removed = removed;
    }

    return h(tag, null, children)
  },

  beforeUpdate: function beforeUpdate () {
    // force removing pass
    this.__patch__(
      this._vnode,
      this.kept,
      false, // hydrating
      true // removeOnly (!important, avoids unnecessary moves)
    );
    this._vnode = this.kept;
  },

  updated: function updated () {
    var children = this.prevChildren;
    var moveClass = this.moveClass || ((this.name || 'v') + '-move');
    if (!children.length || !this.hasMove(children[0].elm, moveClass)) {
      return
    }

    // we divide the work into three loops to avoid mixing DOM reads and writes
    // in each iteration - which helps prevent layout thrashing.
    children.forEach(callPendingCbs);
    children.forEach(recordPosition);
    children.forEach(applyTranslation);

    // force reflow to put everything in position
    // assign to this to avoid being removed in tree-shaking
    // $flow-disable-line
    this._reflow = document.body.offsetHeight;

    children.forEach(function (c) {
      if (c.data.moved) {
        var el = c.elm;
        var s = el.style;
        addTransitionClass(el, moveClass);
        s.transform = s.WebkitTransform = s.transitionDuration = '';
        el.addEventListener(transitionEndEvent, el._moveCb = function cb (e) {
          if (!e || /transform$/.test(e.propertyName)) {
            el.removeEventListener(transitionEndEvent, cb);
            el._moveCb = null;
            removeTransitionClass(el, moveClass);
          }
        });
      }
    });
  },

  methods: {
    hasMove: function hasMove (el, moveClass) {
      /* istanbul ignore if */
      if (!hasTransition) {
        return false
      }
      /* istanbul ignore if */
      if (this._hasMove) {
        return this._hasMove
      }
      // Detect whether an element with the move class applied has
      // CSS transitions. Since the element may be inside an entering
      // transition at this very moment, we make a clone of it and remove
      // all other transition classes applied to ensure only the move class
      // is applied.
      var clone = el.cloneNode();
      if (el._transitionClasses) {
        el._transitionClasses.forEach(function (cls) { removeClass(clone, cls); });
      }
      addClass(clone, moveClass);
      clone.style.display = 'none';
      this.$el.appendChild(clone);
      var info = getTransitionInfo(clone);
      this.$el.removeChild(clone);
      return (this._hasMove = info.hasTransform)
    }
  }
}

function callPendingCbs (c) {
  /* istanbul ignore if */
  if (c.elm._moveCb) {
    c.elm._moveCb();
  }
  /* istanbul ignore if */
  if (c.elm._enterCb) {
    c.elm._enterCb();
  }
}

function recordPosition (c) {
  c.data.newPos = c.elm.getBoundingClientRect();
}

function applyTranslation (c) {
  var oldPos = c.data.pos;
  var newPos = c.data.newPos;
  var dx = oldPos.left - newPos.left;
  var dy = oldPos.top - newPos.top;
  if (dx || dy) {
    c.data.moved = true;
    var s = c.elm.style;
    s.transform = s.WebkitTransform = "translate(" + dx + "px," + dy + "px)";
    s.transitionDuration = '0s';
  }
}

var platformComponents = {
  Transition: Transition,
  TransitionGroup: TransitionGroup
}

/*  */

// install platform specific utils
Vue.config.mustUseProp = mustUseProp;
Vue.config.isReservedTag = isReservedTag;
Vue.config.isReservedAttr = isReservedAttr;
Vue.config.getTagNamespace = getTagNamespace;
Vue.config.isUnknownElement = isUnknownElement;

// install platform runtime directives & components
extend(Vue.options.directives, platformDirectives);
extend(Vue.options.components, platformComponents);

// install platform patch function
Vue.prototype.__patch__ = inBrowser ? patch : noop;

// public mount method
Vue.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && inBrowser ? query(el) : undefined;
  return mountComponent(this, el, hydrating)
};

// devtools global hook
/* istanbul ignore next */
if (inBrowser) {
  setTimeout(function () {
    if (config.devtools) {
      if (devtools) {
        devtools.emit('init', Vue);
      } else if (
        "development" !== 'production' &&
        "development" !== 'test' &&
        isChrome
      ) {
        console[console.info ? 'info' : 'log'](
          'Download the Vue Devtools extension for a better development experience:\n' +
          'https://github.com/vuejs/vue-devtools'
        );
      }
    }
    if ("development" !== 'production' &&
      "development" !== 'test' &&
      config.productionTip !== false &&
      typeof console !== 'undefined'
    ) {
      console[console.info ? 'info' : 'log'](
        "You are running Vue in development mode.\n" +
        "Make sure to turn on production mode when deploying for production.\n" +
        "See more tips at https://vuejs.org/guide/deployment.html"
      );
    }
  }, 0);
}

/*  */

var defaultTagRE = /\{\{((?:.|\n)+?)\}\}/g;
var regexEscapeRE = /[-.*+?^${}()|[\]\/\\]/g;

var buildRegex = cached(function (delimiters) {
  var open = delimiters[0].replace(regexEscapeRE, '\\$&');
  var close = delimiters[1].replace(regexEscapeRE, '\\$&');
  return new RegExp(open + '((?:.|\\n)+?)' + close, 'g')
});



function parseText (
  text,
  delimiters
) {
  var tagRE = delimiters ? buildRegex(delimiters) : defaultTagRE;
  if (!tagRE.test(text)) {
    return
  }
  var tokens = [];
  var rawTokens = [];
  var lastIndex = tagRE.lastIndex = 0;
  var match, index, tokenValue;
  while ((match = tagRE.exec(text))) {
    index = match.index;
    // push text token
    if (index > lastIndex) {
      rawTokens.push(tokenValue = text.slice(lastIndex, index));
      tokens.push(JSON.stringify(tokenValue));
    }
    // tag token
    var exp = parseFilters(match[1].trim());
    tokens.push(("_s(" + exp + ")"));
    rawTokens.push({ '@binding': exp });
    lastIndex = index + match[0].length;
  }
  if (lastIndex < text.length) {
    rawTokens.push(tokenValue = text.slice(lastIndex));
    tokens.push(JSON.stringify(tokenValue));
  }
  return {
    expression: tokens.join('+'),
    tokens: rawTokens
  }
}

/*  */

function transformNode (el, options) {
  var warn = options.warn || baseWarn;
  var staticClass = getAndRemoveAttr(el, 'class');
  if ("development" !== 'production' && staticClass) {
    var res = parseText(staticClass, options.delimiters);
    if (res) {
      warn(
        "class=\"" + staticClass + "\": " +
        'Interpolation inside attributes has been removed. ' +
        'Use v-bind or the colon shorthand instead. For example, ' +
        'instead of <div class="{{ val }}">, use <div :class="val">.'
      );
    }
  }
  if (staticClass) {
    el.staticClass = JSON.stringify(staticClass);
  }
  var classBinding = getBindingAttr(el, 'class', false /* getStatic */);
  if (classBinding) {
    el.classBinding = classBinding;
  }
}

function genData (el) {
  var data = '';
  if (el.staticClass) {
    data += "staticClass:" + (el.staticClass) + ",";
  }
  if (el.classBinding) {
    data += "class:" + (el.classBinding) + ",";
  }
  return data
}

var klass$1 = {
  staticKeys: ['staticClass'],
  transformNode: transformNode,
  genData: genData
}

/*  */

function transformNode$1 (el, options) {
  var warn = options.warn || baseWarn;
  var staticStyle = getAndRemoveAttr(el, 'style');
  if (staticStyle) {
    /* istanbul ignore if */
    if (true) {
      var res = parseText(staticStyle, options.delimiters);
      if (res) {
        warn(
          "style=\"" + staticStyle + "\": " +
          'Interpolation inside attributes has been removed. ' +
          'Use v-bind or the colon shorthand instead. For example, ' +
          'instead of <div style="{{ val }}">, use <div :style="val">.'
        );
      }
    }
    el.staticStyle = JSON.stringify(parseStyleText(staticStyle));
  }

  var styleBinding = getBindingAttr(el, 'style', false /* getStatic */);
  if (styleBinding) {
    el.styleBinding = styleBinding;
  }
}

function genData$1 (el) {
  var data = '';
  if (el.staticStyle) {
    data += "staticStyle:" + (el.staticStyle) + ",";
  }
  if (el.styleBinding) {
    data += "style:(" + (el.styleBinding) + "),";
  }
  return data
}

var style$1 = {
  staticKeys: ['staticStyle'],
  transformNode: transformNode$1,
  genData: genData$1
}

/*  */

var decoder;

var he = {
  decode: function decode (html) {
    decoder = decoder || document.createElement('div');
    decoder.innerHTML = html;
    return decoder.textContent
  }
}

/*  */

var isUnaryTag = makeMap(
  'area,base,br,col,embed,frame,hr,img,input,isindex,keygen,' +
  'link,meta,param,source,track,wbr'
);

// Elements that you can, intentionally, leave open
// (and which close themselves)
var canBeLeftOpenTag = makeMap(
  'colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source'
);

// HTML5 tags https://html.spec.whatwg.org/multipage/indices.html#elements-3
// Phrasing Content https://html.spec.whatwg.org/multipage/dom.html#phrasing-content
var isNonPhrasingTag = makeMap(
  'address,article,aside,base,blockquote,body,caption,col,colgroup,dd,' +
  'details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,' +
  'h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,' +
  'optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,' +
  'title,tr,track'
);

/**
 * Not type-checking this file because it's mostly vendor code.
 */

/*!
 * HTML Parser By John Resig (ejohn.org)
 * Modified by Juriy "kangax" Zaytsev
 * Original code by Erik Arvidsson, Mozilla Public License
 * http://erik.eae.net/simplehtmlparser/simplehtmlparser.js
 */

// Regular Expressions for parsing tags and attributes
var attribute = /^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/;
// could use https://www.w3.org/TR/1999/REC-xml-names-19990114/#NT-QName
// but for Vue templates we can enforce a simple charset
var ncname = '[a-zA-Z_][\\w\\-\\.]*';
var qnameCapture = "((?:" + ncname + "\\:)?" + ncname + ")";
var startTagOpen = new RegExp(("^<" + qnameCapture));
var startTagClose = /^\s*(\/?)>/;
var endTag = new RegExp(("^<\\/" + qnameCapture + "[^>]*>"));
var doctype = /^<!DOCTYPE [^>]+>/i;
// #7298: escape - to avoid being pased as HTML comment when inlined in page
var comment = /^<!\--/;
var conditionalComment = /^<!\[/;

var IS_REGEX_CAPTURING_BROKEN = false;
'x'.replace(/x(.)?/g, function (m, g) {
  IS_REGEX_CAPTURING_BROKEN = g === '';
});

// Special Elements (can contain anything)
var isPlainTextElement = makeMap('script,style,textarea', true);
var reCache = {};

var decodingMap = {
  '&lt;': '<',
  '&gt;': '>',
  '&quot;': '"',
  '&amp;': '&',
  '&#10;': '\n',
  '&#9;': '\t'
};
var encodedAttr = /&(?:lt|gt|quot|amp);/g;
var encodedAttrWithNewLines = /&(?:lt|gt|quot|amp|#10|#9);/g;

// #5992
var isIgnoreNewlineTag = makeMap('pre,textarea', true);
var shouldIgnoreFirstNewline = function (tag, html) { return tag && isIgnoreNewlineTag(tag) && html[0] === '\n'; };

function decodeAttr (value, shouldDecodeNewlines) {
  var re = shouldDecodeNewlines ? encodedAttrWithNewLines : encodedAttr;
  return value.replace(re, function (match) { return decodingMap[match]; })
}

function parseHTML (html, options) {
  var stack = [];
  var expectHTML = options.expectHTML;
  var isUnaryTag$$1 = options.isUnaryTag || no;
  var canBeLeftOpenTag$$1 = options.canBeLeftOpenTag || no;
  var index = 0;
  var last, lastTag;
  while (html) {
    last = html;
    // Make sure we're not in a plaintext content element like script/style
    if (!lastTag || !isPlainTextElement(lastTag)) {
      var textEnd = html.indexOf('<');
      if (textEnd === 0) {
        // Comment:
        if (comment.test(html)) {
          var commentEnd = html.indexOf('-->');

          if (commentEnd >= 0) {
            if (options.shouldKeepComment) {
              options.comment(html.substring(4, commentEnd));
            }
            advance(commentEnd + 3);
            continue
          }
        }

        // http://en.wikipedia.org/wiki/Conditional_comment#Downlevel-revealed_conditional_comment
        if (conditionalComment.test(html)) {
          var conditionalEnd = html.indexOf(']>');

          if (conditionalEnd >= 0) {
            advance(conditionalEnd + 2);
            continue
          }
        }

        // Doctype:
        var doctypeMatch = html.match(doctype);
        if (doctypeMatch) {
          advance(doctypeMatch[0].length);
          continue
        }

        // End tag:
        var endTagMatch = html.match(endTag);
        if (endTagMatch) {
          var curIndex = index;
          advance(endTagMatch[0].length);
          parseEndTag(endTagMatch[1], curIndex, index);
          continue
        }

        // Start tag:
        var startTagMatch = parseStartTag();
        if (startTagMatch) {
          handleStartTag(startTagMatch);
          if (shouldIgnoreFirstNewline(lastTag, html)) {
            advance(1);
          }
          continue
        }
      }

      var text = (void 0), rest = (void 0), next = (void 0);
      if (textEnd >= 0) {
        rest = html.slice(textEnd);
        while (
          !endTag.test(rest) &&
          !startTagOpen.test(rest) &&
          !comment.test(rest) &&
          !conditionalComment.test(rest)
        ) {
          // < in plain text, be forgiving and treat it as text
          next = rest.indexOf('<', 1);
          if (next < 0) { break }
          textEnd += next;
          rest = html.slice(textEnd);
        }
        text = html.substring(0, textEnd);
        advance(textEnd);
      }

      if (textEnd < 0) {
        text = html;
        html = '';
      }

      if (options.chars && text) {
        options.chars(text);
      }
    } else {
      var endTagLength = 0;
      var stackedTag = lastTag.toLowerCase();
      var reStackedTag = reCache[stackedTag] || (reCache[stackedTag] = new RegExp('([\\s\\S]*?)(</' + stackedTag + '[^>]*>)', 'i'));
      var rest$1 = html.replace(reStackedTag, function (all, text, endTag) {
        endTagLength = endTag.length;
        if (!isPlainTextElement(stackedTag) && stackedTag !== 'noscript') {
          text = text
            .replace(/<!\--([\s\S]*?)-->/g, '$1') // #7298
            .replace(/<!\[CDATA\[([\s\S]*?)]]>/g, '$1');
        }
        if (shouldIgnoreFirstNewline(stackedTag, text)) {
          text = text.slice(1);
        }
        if (options.chars) {
          options.chars(text);
        }
        return ''
      });
      index += html.length - rest$1.length;
      html = rest$1;
      parseEndTag(stackedTag, index - endTagLength, index);
    }

    if (html === last) {
      options.chars && options.chars(html);
      if ("development" !== 'production' && !stack.length && options.warn) {
        options.warn(("Mal-formatted tag at end of template: \"" + html + "\""));
      }
      break
    }
  }

  // Clean up any remaining tags
  parseEndTag();

  function advance (n) {
    index += n;
    html = html.substring(n);
  }

  function parseStartTag () {
    var start = html.match(startTagOpen);
    if (start) {
      var match = {
        tagName: start[1],
        attrs: [],
        start: index
      };
      advance(start[0].length);
      var end, attr;
      while (!(end = html.match(startTagClose)) && (attr = html.match(attribute))) {
        advance(attr[0].length);
        match.attrs.push(attr);
      }
      if (end) {
        match.unarySlash = end[1];
        advance(end[0].length);
        match.end = index;
        return match
      }
    }
  }

  function handleStartTag (match) {
    var tagName = match.tagName;
    var unarySlash = match.unarySlash;

    if (expectHTML) {
      if (lastTag === 'p' && isNonPhrasingTag(tagName)) {
        parseEndTag(lastTag);
      }
      if (canBeLeftOpenTag$$1(tagName) && lastTag === tagName) {
        parseEndTag(tagName);
      }
    }

    var unary = isUnaryTag$$1(tagName) || !!unarySlash;

    var l = match.attrs.length;
    var attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      var args = match.attrs[i];
      // hackish work around FF bug https://bugzilla.mozilla.org/show_bug.cgi?id=369778
      if (IS_REGEX_CAPTURING_BROKEN && args[0].indexOf('""') === -1) {
        if (args[3] === '') { delete args[3]; }
        if (args[4] === '') { delete args[4]; }
        if (args[5] === '') { delete args[5]; }
      }
      var value = args[3] || args[4] || args[5] || '';
      var shouldDecodeNewlines = tagName === 'a' && args[1] === 'href'
        ? options.shouldDecodeNewlinesForHref
        : options.shouldDecodeNewlines;
      attrs[i] = {
        name: args[1],
        value: decodeAttr(value, shouldDecodeNewlines)
      };
    }

    if (!unary) {
      stack.push({ tag: tagName, lowerCasedTag: tagName.toLowerCase(), attrs: attrs });
      lastTag = tagName;
    }

    if (options.start) {
      options.start(tagName, attrs, unary, match.start, match.end);
    }
  }

  function parseEndTag (tagName, start, end) {
    var pos, lowerCasedTagName;
    if (start == null) { start = index; }
    if (end == null) { end = index; }

    if (tagName) {
      lowerCasedTagName = tagName.toLowerCase();
    }

    // Find the closest opened tag of the same type
    if (tagName) {
      for (pos = stack.length - 1; pos >= 0; pos--) {
        if (stack[pos].lowerCasedTag === lowerCasedTagName) {
          break
        }
      }
    } else {
      // If no tag name is provided, clean shop
      pos = 0;
    }

    if (pos >= 0) {
      // Close all the open elements, up the stack
      for (var i = stack.length - 1; i >= pos; i--) {
        if ("development" !== 'production' &&
          (i > pos || !tagName) &&
          options.warn
        ) {
          options.warn(
            ("tag <" + (stack[i].tag) + "> has no matching end tag.")
          );
        }
        if (options.end) {
          options.end(stack[i].tag, start, end);
        }
      }

      // Remove the open elements from the stack
      stack.length = pos;
      lastTag = pos && stack[pos - 1].tag;
    } else if (lowerCasedTagName === 'br') {
      if (options.start) {
        options.start(tagName, [], true, start, end);
      }
    } else if (lowerCasedTagName === 'p') {
      if (options.start) {
        options.start(tagName, [], false, start, end);
      }
      if (options.end) {
        options.end(tagName, start, end);
      }
    }
  }
}

/*  */

var onRE = /^@|^v-on:/;
var dirRE = /^v-|^@|^:/;
var forAliasRE = /([^]*?)\s+(?:in|of)\s+([^]*)/;
var forIteratorRE = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/;
var stripParensRE = /^\(|\)$/g;

var argRE = /:(.*)$/;
var bindRE = /^:|^v-bind:/;
var modifierRE = /\.[^.]+/g;

var decodeHTMLCached = cached(he.decode);

// configurable state
var warn$2;
var delimiters;
var transforms;
var preTransforms;
var postTransforms;
var platformIsPreTag;
var platformMustUseProp;
var platformGetTagNamespace;



function createASTElement (
  tag,
  attrs,
  parent
) {
  return {
    type: 1,
    tag: tag,
    attrsList: attrs,
    attrsMap: makeAttrsMap(attrs),
    parent: parent,
    children: []
  }
}

/**
 * Convert HTML string to AST.
 */
function parse (
  template,
  options
) {
  warn$2 = options.warn || baseWarn;

  platformIsPreTag = options.isPreTag || no;
  platformMustUseProp = options.mustUseProp || no;
  platformGetTagNamespace = options.getTagNamespace || no;

  transforms = pluckModuleFunction(options.modules, 'transformNode');
  preTransforms = pluckModuleFunction(options.modules, 'preTransformNode');
  postTransforms = pluckModuleFunction(options.modules, 'postTransformNode');

  delimiters = options.delimiters;

  var stack = [];
  var preserveWhitespace = options.preserveWhitespace !== false;
  var root;
  var currentParent;
  var inVPre = false;
  var inPre = false;
  var warned = false;

  function warnOnce (msg) {
    if (!warned) {
      warned = true;
      warn$2(msg);
    }
  }

  function closeElement (element) {
    // check pre state
    if (element.pre) {
      inVPre = false;
    }
    if (platformIsPreTag(element.tag)) {
      inPre = false;
    }
    // apply post-transforms
    for (var i = 0; i < postTransforms.length; i++) {
      postTransforms[i](element, options);
    }
  }

  parseHTML(template, {
    warn: warn$2,
    expectHTML: options.expectHTML,
    isUnaryTag: options.isUnaryTag,
    canBeLeftOpenTag: options.canBeLeftOpenTag,
    shouldDecodeNewlines: options.shouldDecodeNewlines,
    shouldDecodeNewlinesForHref: options.shouldDecodeNewlinesForHref,
    shouldKeepComment: options.comments,
    start: function start (tag, attrs, unary) {
      // check namespace.
      // inherit parent ns if there is one
      var ns = (currentParent && currentParent.ns) || platformGetTagNamespace(tag);

      // handle IE svg bug
      /* istanbul ignore if */
      if (isIE && ns === 'svg') {
        attrs = guardIESVGBug(attrs);
      }

      var element = createASTElement(tag, attrs, currentParent);
      if (ns) {
        element.ns = ns;
      }

      if (isForbiddenTag(element) && !isServerRendering()) {
        element.forbidden = true;
        "development" !== 'production' && warn$2(
          'Templates should only be responsible for mapping the state to the ' +
          'UI. Avoid placing tags with side-effects in your templates, such as ' +
          "<" + tag + ">" + ', as they will not be parsed.'
        );
      }

      // apply pre-transforms
      for (var i = 0; i < preTransforms.length; i++) {
        element = preTransforms[i](element, options) || element;
      }

      if (!inVPre) {
        processPre(element);
        if (element.pre) {
          inVPre = true;
        }
      }
      if (platformIsPreTag(element.tag)) {
        inPre = true;
      }
      if (inVPre) {
        processRawAttrs(element);
      } else if (!element.processed) {
        // structural directives
        processFor(element);
        processIf(element);
        processOnce(element);
        // element-scope stuff
        processElement(element, options);
      }

      function checkRootConstraints (el) {
        if (true) {
          if (el.tag === 'slot' || el.tag === 'template') {
            warnOnce(
              "Cannot use <" + (el.tag) + "> as component root element because it may " +
              'contain multiple nodes.'
            );
          }
          if (el.attrsMap.hasOwnProperty('v-for')) {
            warnOnce(
              'Cannot use v-for on stateful component root element because ' +
              'it renders multiple elements.'
            );
          }
        }
      }

      // tree management
      if (!root) {
        root = element;
        checkRootConstraints(root);
      } else if (!stack.length) {
        // allow root elements with v-if, v-else-if and v-else
        if (root.if && (element.elseif || element.else)) {
          checkRootConstraints(element);
          addIfCondition(root, {
            exp: element.elseif,
            block: element
          });
        } else if (true) {
          warnOnce(
            "Component template should contain exactly one root element. " +
            "If you are using v-if on multiple elements, " +
            "use v-else-if to chain them instead."
          );
        }
      }
      if (currentParent && !element.forbidden) {
        if (element.elseif || element.else) {
          processIfConditions(element, currentParent);
        } else if (element.slotScope) { // scoped slot
          currentParent.plain = false;
          var name = element.slotTarget || '"default"';(currentParent.scopedSlots || (currentParent.scopedSlots = {}))[name] = element;
        } else {
          currentParent.children.push(element);
          element.parent = currentParent;
        }
      }
      if (!unary) {
        currentParent = element;
        stack.push(element);
      } else {
        closeElement(element);
      }
    },

    end: function end () {
      // remove trailing whitespace
      var element = stack[stack.length - 1];
      var lastNode = element.children[element.children.length - 1];
      if (lastNode && lastNode.type === 3 && lastNode.text === ' ' && !inPre) {
        element.children.pop();
      }
      // pop stack
      stack.length -= 1;
      currentParent = stack[stack.length - 1];
      closeElement(element);
    },

    chars: function chars (text) {
      if (!currentParent) {
        if (true) {
          if (text === template) {
            warnOnce(
              'Component template requires a root element, rather than just text.'
            );
          } else if ((text = text.trim())) {
            warnOnce(
              ("text \"" + text + "\" outside root element will be ignored.")
            );
          }
        }
        return
      }
      // IE textarea placeholder bug
      /* istanbul ignore if */
      if (isIE &&
        currentParent.tag === 'textarea' &&
        currentParent.attrsMap.placeholder === text
      ) {
        return
      }
      var children = currentParent.children;
      text = inPre || text.trim()
        ? isTextTag(currentParent) ? text : decodeHTMLCached(text)
        // only preserve whitespace if its not right after a starting tag
        : preserveWhitespace && children.length ? ' ' : '';
      if (text) {
        var res;
        if (!inVPre && text !== ' ' && (res = parseText(text, delimiters))) {
          children.push({
            type: 2,
            expression: res.expression,
            tokens: res.tokens,
            text: text
          });
        } else if (text !== ' ' || !children.length || children[children.length - 1].text !== ' ') {
          children.push({
            type: 3,
            text: text
          });
        }
      }
    },
    comment: function comment (text) {
      currentParent.children.push({
        type: 3,
        text: text,
        isComment: true
      });
    }
  });
  return root
}

function processPre (el) {
  if (getAndRemoveAttr(el, 'v-pre') != null) {
    el.pre = true;
  }
}

function processRawAttrs (el) {
  var l = el.attrsList.length;
  if (l) {
    var attrs = el.attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      attrs[i] = {
        name: el.attrsList[i].name,
        value: JSON.stringify(el.attrsList[i].value)
      };
    }
  } else if (!el.pre) {
    // non root node in pre blocks with no attributes
    el.plain = true;
  }
}

function processElement (element, options) {
  processKey(element);

  // determine whether this is a plain element after
  // removing structural attributes
  element.plain = !element.key && !element.attrsList.length;

  processRef(element);
  processSlot(element);
  processComponent(element);
  for (var i = 0; i < transforms.length; i++) {
    element = transforms[i](element, options) || element;
  }
  processAttrs(element);
}

function processKey (el) {
  var exp = getBindingAttr(el, 'key');
  if (exp) {
    if ("development" !== 'production' && el.tag === 'template') {
      warn$2("<template> cannot be keyed. Place the key on real elements instead.");
    }
    el.key = exp;
  }
}

function processRef (el) {
  var ref = getBindingAttr(el, 'ref');
  if (ref) {
    el.ref = ref;
    el.refInFor = checkInFor(el);
  }
}

function processFor (el) {
  var exp;
  if ((exp = getAndRemoveAttr(el, 'v-for'))) {
    var res = parseFor(exp);
    if (res) {
      extend(el, res);
    } else if (true) {
      warn$2(
        ("Invalid v-for expression: " + exp)
      );
    }
  }
}



function parseFor (exp) {
  var inMatch = exp.match(forAliasRE);
  if (!inMatch) { return }
  var res = {};
  res.for = inMatch[2].trim();
  var alias = inMatch[1].trim().replace(stripParensRE, '');
  var iteratorMatch = alias.match(forIteratorRE);
  if (iteratorMatch) {
    res.alias = alias.replace(forIteratorRE, '');
    res.iterator1 = iteratorMatch[1].trim();
    if (iteratorMatch[2]) {
      res.iterator2 = iteratorMatch[2].trim();
    }
  } else {
    res.alias = alias;
  }
  return res
}

function processIf (el) {
  var exp = getAndRemoveAttr(el, 'v-if');
  if (exp) {
    el.if = exp;
    addIfCondition(el, {
      exp: exp,
      block: el
    });
  } else {
    if (getAndRemoveAttr(el, 'v-else') != null) {
      el.else = true;
    }
    var elseif = getAndRemoveAttr(el, 'v-else-if');
    if (elseif) {
      el.elseif = elseif;
    }
  }
}

function processIfConditions (el, parent) {
  var prev = findPrevElement(parent.children);
  if (prev && prev.if) {
    addIfCondition(prev, {
      exp: el.elseif,
      block: el
    });
  } else if (true) {
    warn$2(
      "v-" + (el.elseif ? ('else-if="' + el.elseif + '"') : 'else') + " " +
      "used on element <" + (el.tag) + "> without corresponding v-if."
    );
  }
}

function findPrevElement (children) {
  var i = children.length;
  while (i--) {
    if (children[i].type === 1) {
      return children[i]
    } else {
      if ("development" !== 'production' && children[i].text !== ' ') {
        warn$2(
          "text \"" + (children[i].text.trim()) + "\" between v-if and v-else(-if) " +
          "will be ignored."
        );
      }
      children.pop();
    }
  }
}

function addIfCondition (el, condition) {
  if (!el.ifConditions) {
    el.ifConditions = [];
  }
  el.ifConditions.push(condition);
}

function processOnce (el) {
  var once$$1 = getAndRemoveAttr(el, 'v-once');
  if (once$$1 != null) {
    el.once = true;
  }
}

function processSlot (el) {
  if (el.tag === 'slot') {
    el.slotName = getBindingAttr(el, 'name');
    if ("development" !== 'production' && el.key) {
      warn$2(
        "`key` does not work on <slot> because slots are abstract outlets " +
        "and can possibly expand into multiple elements. " +
        "Use the key on a wrapping element instead."
      );
    }
  } else {
    var slotScope;
    if (el.tag === 'template') {
      slotScope = getAndRemoveAttr(el, 'scope');
      /* istanbul ignore if */
      if ("development" !== 'production' && slotScope) {
        warn$2(
          "the \"scope\" attribute for scoped slots have been deprecated and " +
          "replaced by \"slot-scope\" since 2.5. The new \"slot-scope\" attribute " +
          "can also be used on plain elements in addition to <template> to " +
          "denote scoped slots.",
          true
        );
      }
      el.slotScope = slotScope || getAndRemoveAttr(el, 'slot-scope');
    } else if ((slotScope = getAndRemoveAttr(el, 'slot-scope'))) {
      /* istanbul ignore if */
      if ("development" !== 'production' && el.attrsMap['v-for']) {
        warn$2(
          "Ambiguous combined usage of slot-scope and v-for on <" + (el.tag) + "> " +
          "(v-for takes higher priority). Use a wrapper <template> for the " +
          "scoped slot to make it clearer.",
          true
        );
      }
      el.slotScope = slotScope;
    }
    var slotTarget = getBindingAttr(el, 'slot');
    if (slotTarget) {
      el.slotTarget = slotTarget === '""' ? '"default"' : slotTarget;
      // preserve slot as an attribute for native shadow DOM compat
      // only for non-scoped slots.
      if (el.tag !== 'template' && !el.slotScope) {
        addAttr(el, 'slot', slotTarget);
      }
    }
  }
}

function processComponent (el) {
  var binding;
  if ((binding = getBindingAttr(el, 'is'))) {
    el.component = binding;
  }
  if (getAndRemoveAttr(el, 'inline-template') != null) {
    el.inlineTemplate = true;
  }
}

function processAttrs (el) {
  var list = el.attrsList;
  var i, l, name, rawName, value, modifiers, isProp;
  for (i = 0, l = list.length; i < l; i++) {
    name = rawName = list[i].name;
    value = list[i].value;
    if (dirRE.test(name)) {
      // mark element as dynamic
      el.hasBindings = true;
      // modifiers
      modifiers = parseModifiers(name);
      if (modifiers) {
        name = name.replace(modifierRE, '');
      }
      if (bindRE.test(name)) { // v-bind
        name = name.replace(bindRE, '');
        value = parseFilters(value);
        isProp = false;
        if (modifiers) {
          if (modifiers.prop) {
            isProp = true;
            name = camelize(name);
            if (name === 'innerHtml') { name = 'innerHTML'; }
          }
          if (modifiers.camel) {
            name = camelize(name);
          }
          if (modifiers.sync) {
            addHandler(
              el,
              ("update:" + (camelize(name))),
              genAssignmentCode(value, "$event")
            );
          }
        }
        if (isProp || (
          !el.component && platformMustUseProp(el.tag, el.attrsMap.type, name)
        )) {
          addProp(el, name, value);
        } else {
          addAttr(el, name, value);
        }
      } else if (onRE.test(name)) { // v-on
        name = name.replace(onRE, '');
        addHandler(el, name, value, modifiers, false, warn$2);
      } else { // normal directives
        name = name.replace(dirRE, '');
        // parse arg
        var argMatch = name.match(argRE);
        var arg = argMatch && argMatch[1];
        if (arg) {
          name = name.slice(0, -(arg.length + 1));
        }
        addDirective(el, name, rawName, value, arg, modifiers);
        if ("development" !== 'production' && name === 'model') {
          checkForAliasModel(el, value);
        }
      }
    } else {
      // literal attribute
      if (true) {
        var res = parseText(value, delimiters);
        if (res) {
          warn$2(
            name + "=\"" + value + "\": " +
            'Interpolation inside attributes has been removed. ' +
            'Use v-bind or the colon shorthand instead. For example, ' +
            'instead of <div id="{{ val }}">, use <div :id="val">.'
          );
        }
      }
      addAttr(el, name, JSON.stringify(value));
      // #6887 firefox doesn't update muted state if set via attribute
      // even immediately after element creation
      if (!el.component &&
          name === 'muted' &&
          platformMustUseProp(el.tag, el.attrsMap.type, name)) {
        addProp(el, name, 'true');
      }
    }
  }
}

function checkInFor (el) {
  var parent = el;
  while (parent) {
    if (parent.for !== undefined) {
      return true
    }
    parent = parent.parent;
  }
  return false
}

function parseModifiers (name) {
  var match = name.match(modifierRE);
  if (match) {
    var ret = {};
    match.forEach(function (m) { ret[m.slice(1)] = true; });
    return ret
  }
}

function makeAttrsMap (attrs) {
  var map = {};
  for (var i = 0, l = attrs.length; i < l; i++) {
    if (
      "development" !== 'production' &&
      map[attrs[i].name] && !isIE && !isEdge
    ) {
      warn$2('duplicate attribute: ' + attrs[i].name);
    }
    map[attrs[i].name] = attrs[i].value;
  }
  return map
}

// for script (e.g. type="x/template") or style, do not decode content
function isTextTag (el) {
  return el.tag === 'script' || el.tag === 'style'
}

function isForbiddenTag (el) {
  return (
    el.tag === 'style' ||
    (el.tag === 'script' && (
      !el.attrsMap.type ||
      el.attrsMap.type === 'text/javascript'
    ))
  )
}

var ieNSBug = /^xmlns:NS\d+/;
var ieNSPrefix = /^NS\d+:/;

/* istanbul ignore next */
function guardIESVGBug (attrs) {
  var res = [];
  for (var i = 0; i < attrs.length; i++) {
    var attr = attrs[i];
    if (!ieNSBug.test(attr.name)) {
      attr.name = attr.name.replace(ieNSPrefix, '');
      res.push(attr);
    }
  }
  return res
}

function checkForAliasModel (el, value) {
  var _el = el;
  while (_el) {
    if (_el.for && _el.alias === value) {
      warn$2(
        "<" + (el.tag) + " v-model=\"" + value + "\">: " +
        "You are binding v-model directly to a v-for iteration alias. " +
        "This will not be able to modify the v-for source array because " +
        "writing to the alias is like modifying a function local variable. " +
        "Consider using an array of objects and use v-model on an object property instead."
      );
    }
    _el = _el.parent;
  }
}

/*  */

/**
 * Expand input[v-model] with dyanmic type bindings into v-if-else chains
 * Turn this:
 *   <input v-model="data[type]" :type="type">
 * into this:
 *   <input v-if="type === 'checkbox'" type="checkbox" v-model="data[type]">
 *   <input v-else-if="type === 'radio'" type="radio" v-model="data[type]">
 *   <input v-else :type="type" v-model="data[type]">
 */

function preTransformNode (el, options) {
  if (el.tag === 'input') {
    var map = el.attrsMap;
    if (!map['v-model']) {
      return
    }

    var typeBinding;
    if (map[':type'] || map['v-bind:type']) {
      typeBinding = getBindingAttr(el, 'type');
    }
    if (!map.type && !typeBinding && map['v-bind']) {
      typeBinding = "(" + (map['v-bind']) + ").type";
    }

    if (typeBinding) {
      var ifCondition = getAndRemoveAttr(el, 'v-if', true);
      var ifConditionExtra = ifCondition ? ("&&(" + ifCondition + ")") : "";
      var hasElse = getAndRemoveAttr(el, 'v-else', true) != null;
      var elseIfCondition = getAndRemoveAttr(el, 'v-else-if', true);
      // 1. checkbox
      var branch0 = cloneASTElement(el);
      // process for on the main node
      processFor(branch0);
      addRawAttr(branch0, 'type', 'checkbox');
      processElement(branch0, options);
      branch0.processed = true; // prevent it from double-processed
      branch0.if = "(" + typeBinding + ")==='checkbox'" + ifConditionExtra;
      addIfCondition(branch0, {
        exp: branch0.if,
        block: branch0
      });
      // 2. add radio else-if condition
      var branch1 = cloneASTElement(el);
      getAndRemoveAttr(branch1, 'v-for', true);
      addRawAttr(branch1, 'type', 'radio');
      processElement(branch1, options);
      addIfCondition(branch0, {
        exp: "(" + typeBinding + ")==='radio'" + ifConditionExtra,
        block: branch1
      });
      // 3. other
      var branch2 = cloneASTElement(el);
      getAndRemoveAttr(branch2, 'v-for', true);
      addRawAttr(branch2, ':type', typeBinding);
      processElement(branch2, options);
      addIfCondition(branch0, {
        exp: ifCondition,
        block: branch2
      });

      if (hasElse) {
        branch0.else = true;
      } else if (elseIfCondition) {
        branch0.elseif = elseIfCondition;
      }

      return branch0
    }
  }
}

function cloneASTElement (el) {
  return createASTElement(el.tag, el.attrsList.slice(), el.parent)
}

var model$2 = {
  preTransformNode: preTransformNode
}

var modules$1 = [
  klass$1,
  style$1,
  model$2
]

/*  */

function text (el, dir) {
  if (dir.value) {
    addProp(el, 'textContent', ("_s(" + (dir.value) + ")"));
  }
}

/*  */

function html (el, dir) {
  if (dir.value) {
    addProp(el, 'innerHTML', ("_s(" + (dir.value) + ")"));
  }
}

var directives$1 = {
  model: model,
  text: text,
  html: html
}

/*  */

var baseOptions = {
  expectHTML: true,
  modules: modules$1,
  directives: directives$1,
  isPreTag: isPreTag,
  isUnaryTag: isUnaryTag,
  mustUseProp: mustUseProp,
  canBeLeftOpenTag: canBeLeftOpenTag,
  isReservedTag: isReservedTag,
  getTagNamespace: getTagNamespace,
  staticKeys: genStaticKeys(modules$1)
};

/*  */

var isStaticKey;
var isPlatformReservedTag;

var genStaticKeysCached = cached(genStaticKeys$1);

/**
 * Goal of the optimizer: walk the generated template AST tree
 * and detect sub-trees that are purely static, i.e. parts of
 * the DOM that never needs to change.
 *
 * Once we detect these sub-trees, we can:
 *
 * 1. Hoist them into constants, so that we no longer need to
 *    create fresh nodes for them on each re-render;
 * 2. Completely skip them in the patching process.
 */
function optimize (root, options) {
  if (!root) { return }
  isStaticKey = genStaticKeysCached(options.staticKeys || '');
  isPlatformReservedTag = options.isReservedTag || no;
  // first pass: mark all non-static nodes.
  markStatic$1(root);
  // second pass: mark static roots.
  markStaticRoots(root, false);
}

function genStaticKeys$1 (keys) {
  return makeMap(
    'type,tag,attrsList,attrsMap,plain,parent,children,attrs' +
    (keys ? ',' + keys : '')
  )
}

function markStatic$1 (node) {
  node.static = isStatic(node);
  if (node.type === 1) {
    // do not make component slot content static. this avoids
    // 1. components not able to mutate slot nodes
    // 2. static slot content fails for hot-reloading
    if (
      !isPlatformReservedTag(node.tag) &&
      node.tag !== 'slot' &&
      node.attrsMap['inline-template'] == null
    ) {
      return
    }
    for (var i = 0, l = node.children.length; i < l; i++) {
      var child = node.children[i];
      markStatic$1(child);
      if (!child.static) {
        node.static = false;
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        var block = node.ifConditions[i$1].block;
        markStatic$1(block);
        if (!block.static) {
          node.static = false;
        }
      }
    }
  }
}

function markStaticRoots (node, isInFor) {
  if (node.type === 1) {
    if (node.static || node.once) {
      node.staticInFor = isInFor;
    }
    // For a node to qualify as a static root, it should have children that
    // are not just static text. Otherwise the cost of hoisting out will
    // outweigh the benefits and it's better off to just always render it fresh.
    if (node.static && node.children.length && !(
      node.children.length === 1 &&
      node.children[0].type === 3
    )) {
      node.staticRoot = true;
      return
    } else {
      node.staticRoot = false;
    }
    if (node.children) {
      for (var i = 0, l = node.children.length; i < l; i++) {
        markStaticRoots(node.children[i], isInFor || !!node.for);
      }
    }
    if (node.ifConditions) {
      for (var i$1 = 1, l$1 = node.ifConditions.length; i$1 < l$1; i$1++) {
        markStaticRoots(node.ifConditions[i$1].block, isInFor);
      }
    }
  }
}

function isStatic (node) {
  if (node.type === 2) { // expression
    return false
  }
  if (node.type === 3) { // text
    return true
  }
  return !!(node.pre || (
    !node.hasBindings && // no dynamic bindings
    !node.if && !node.for && // not v-if or v-for or v-else
    !isBuiltInTag(node.tag) && // not a built-in
    isPlatformReservedTag(node.tag) && // not a component
    !isDirectChildOfTemplateFor(node) &&
    Object.keys(node).every(isStaticKey)
  ))
}

function isDirectChildOfTemplateFor (node) {
  while (node.parent) {
    node = node.parent;
    if (node.tag !== 'template') {
      return false
    }
    if (node.for) {
      return true
    }
  }
  return false
}

/*  */

var fnExpRE = /^([\w$_]+|\([^)]*?\))\s*=>|^function\s*\(/;
var simplePathRE = /^[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['[^']*?']|\["[^"]*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*$/;

// KeyboardEvent.keyCode aliases
var keyCodes = {
  esc: 27,
  tab: 9,
  enter: 13,
  space: 32,
  up: 38,
  left: 37,
  right: 39,
  down: 40,
  'delete': [8, 46]
};

// KeyboardEvent.key aliases
var keyNames = {
  esc: 'Escape',
  tab: 'Tab',
  enter: 'Enter',
  space: ' ',
  // #7806: IE11 uses key names without `Arrow` prefix for arrow keys.
  up: ['Up', 'ArrowUp'],
  left: ['Left', 'ArrowLeft'],
  right: ['Right', 'ArrowRight'],
  down: ['Down', 'ArrowDown'],
  'delete': ['Backspace', 'Delete']
};

// #4868: modifiers that prevent the execution of the listener
// need to explicitly return null so that we can determine whether to remove
// the listener for .once
var genGuard = function (condition) { return ("if(" + condition + ")return null;"); };

var modifierCode = {
  stop: '$event.stopPropagation();',
  prevent: '$event.preventDefault();',
  self: genGuard("$event.target !== $event.currentTarget"),
  ctrl: genGuard("!$event.ctrlKey"),
  shift: genGuard("!$event.shiftKey"),
  alt: genGuard("!$event.altKey"),
  meta: genGuard("!$event.metaKey"),
  left: genGuard("'button' in $event && $event.button !== 0"),
  middle: genGuard("'button' in $event && $event.button !== 1"),
  right: genGuard("'button' in $event && $event.button !== 2")
};

function genHandlers (
  events,
  isNative,
  warn
) {
  var res = isNative ? 'nativeOn:{' : 'on:{';
  for (var name in events) {
    res += "\"" + name + "\":" + (genHandler(name, events[name])) + ",";
  }
  return res.slice(0, -1) + '}'
}

function genHandler (
  name,
  handler
) {
  if (!handler) {
    return 'function(){}'
  }

  if (Array.isArray(handler)) {
    return ("[" + (handler.map(function (handler) { return genHandler(name, handler); }).join(',')) + "]")
  }

  var isMethodPath = simplePathRE.test(handler.value);
  var isFunctionExpression = fnExpRE.test(handler.value);

  if (!handler.modifiers) {
    if (isMethodPath || isFunctionExpression) {
      return handler.value
    }
    /* istanbul ignore if */
    return ("function($event){" + (handler.value) + "}") // inline statement
  } else {
    var code = '';
    var genModifierCode = '';
    var keys = [];
    for (var key in handler.modifiers) {
      if (modifierCode[key]) {
        genModifierCode += modifierCode[key];
        // left/right
        if (keyCodes[key]) {
          keys.push(key);
        }
      } else if (key === 'exact') {
        var modifiers = (handler.modifiers);
        genModifierCode += genGuard(
          ['ctrl', 'shift', 'alt', 'meta']
            .filter(function (keyModifier) { return !modifiers[keyModifier]; })
            .map(function (keyModifier) { return ("$event." + keyModifier + "Key"); })
            .join('||')
        );
      } else {
        keys.push(key);
      }
    }
    if (keys.length) {
      code += genKeyFilter(keys);
    }
    // Make sure modifiers like prevent and stop get executed after key filtering
    if (genModifierCode) {
      code += genModifierCode;
    }
    var handlerCode = isMethodPath
      ? ("return " + (handler.value) + "($event)")
      : isFunctionExpression
        ? ("return (" + (handler.value) + ")($event)")
        : handler.value;
    /* istanbul ignore if */
    return ("function($event){" + code + handlerCode + "}")
  }
}

function genKeyFilter (keys) {
  return ("if(!('button' in $event)&&" + (keys.map(genFilterCode).join('&&')) + ")return null;")
}

function genFilterCode (key) {
  var keyVal = parseInt(key, 10);
  if (keyVal) {
    return ("$event.keyCode!==" + keyVal)
  }
  var keyCode = keyCodes[key];
  var keyName = keyNames[key];
  return (
    "_k($event.keyCode," +
    (JSON.stringify(key)) + "," +
    (JSON.stringify(keyCode)) + "," +
    "$event.key," +
    "" + (JSON.stringify(keyName)) +
    ")"
  )
}

/*  */

function on (el, dir) {
  if ("development" !== 'production' && dir.modifiers) {
    warn("v-on without argument does not support modifiers.");
  }
  el.wrapListeners = function (code) { return ("_g(" + code + "," + (dir.value) + ")"); };
}

/*  */

function bind$1 (el, dir) {
  el.wrapData = function (code) {
    return ("_b(" + code + ",'" + (el.tag) + "'," + (dir.value) + "," + (dir.modifiers && dir.modifiers.prop ? 'true' : 'false') + (dir.modifiers && dir.modifiers.sync ? ',true' : '') + ")")
  };
}

/*  */

var baseDirectives = {
  on: on,
  bind: bind$1,
  cloak: noop
}

/*  */

var CodegenState = function CodegenState (options) {
  this.options = options;
  this.warn = options.warn || baseWarn;
  this.transforms = pluckModuleFunction(options.modules, 'transformCode');
  this.dataGenFns = pluckModuleFunction(options.modules, 'genData');
  this.directives = extend(extend({}, baseDirectives), options.directives);
  var isReservedTag = options.isReservedTag || no;
  this.maybeComponent = function (el) { return !isReservedTag(el.tag); };
  this.onceId = 0;
  this.staticRenderFns = [];
};



function generate (
  ast,
  options
) {
  var state = new CodegenState(options);
  var code = ast ? genElement(ast, state) : '_c("div")';
  return {
    render: ("with(this){return " + code + "}"),
    staticRenderFns: state.staticRenderFns
  }
}

function genElement (el, state) {
  if (el.staticRoot && !el.staticProcessed) {
    return genStatic(el, state)
  } else if (el.once && !el.onceProcessed) {
    return genOnce(el, state)
  } else if (el.for && !el.forProcessed) {
    return genFor(el, state)
  } else if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.tag === 'template' && !el.slotTarget) {
    return genChildren(el, state) || 'void 0'
  } else if (el.tag === 'slot') {
    return genSlot(el, state)
  } else {
    // component or element
    var code;
    if (el.component) {
      code = genComponent(el.component, el, state);
    } else {
      var data = el.plain ? undefined : genData$2(el, state);

      var children = el.inlineTemplate ? null : genChildren(el, state, true);
      code = "_c('" + (el.tag) + "'" + (data ? ("," + data) : '') + (children ? ("," + children) : '') + ")";
    }
    // module transforms
    for (var i = 0; i < state.transforms.length; i++) {
      code = state.transforms[i](el, code);
    }
    return code
  }
}

// hoist static sub-trees out
function genStatic (el, state) {
  el.staticProcessed = true;
  state.staticRenderFns.push(("with(this){return " + (genElement(el, state)) + "}"));
  return ("_m(" + (state.staticRenderFns.length - 1) + (el.staticInFor ? ',true' : '') + ")")
}

// v-once
function genOnce (el, state) {
  el.onceProcessed = true;
  if (el.if && !el.ifProcessed) {
    return genIf(el, state)
  } else if (el.staticInFor) {
    var key = '';
    var parent = el.parent;
    while (parent) {
      if (parent.for) {
        key = parent.key;
        break
      }
      parent = parent.parent;
    }
    if (!key) {
      "development" !== 'production' && state.warn(
        "v-once can only be used inside v-for that is keyed. "
      );
      return genElement(el, state)
    }
    return ("_o(" + (genElement(el, state)) + "," + (state.onceId++) + "," + key + ")")
  } else {
    return genStatic(el, state)
  }
}

function genIf (
  el,
  state,
  altGen,
  altEmpty
) {
  el.ifProcessed = true; // avoid recursion
  return genIfConditions(el.ifConditions.slice(), state, altGen, altEmpty)
}

function genIfConditions (
  conditions,
  state,
  altGen,
  altEmpty
) {
  if (!conditions.length) {
    return altEmpty || '_e()'
  }

  var condition = conditions.shift();
  if (condition.exp) {
    return ("(" + (condition.exp) + ")?" + (genTernaryExp(condition.block)) + ":" + (genIfConditions(conditions, state, altGen, altEmpty)))
  } else {
    return ("" + (genTernaryExp(condition.block)))
  }

  // v-if with v-once should generate code like (a)?_m(0):_m(1)
  function genTernaryExp (el) {
    return altGen
      ? altGen(el, state)
      : el.once
        ? genOnce(el, state)
        : genElement(el, state)
  }
}

function genFor (
  el,
  state,
  altGen,
  altHelper
) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';

  if ("development" !== 'production' &&
    state.maybeComponent(el) &&
    el.tag !== 'slot' &&
    el.tag !== 'template' &&
    !el.key
  ) {
    state.warn(
      "<" + (el.tag) + " v-for=\"" + alias + " in " + exp + "\">: component lists rendered with " +
      "v-for should have explicit keys. " +
      "See https://vuejs.org/guide/list.html#key for more info.",
      true /* tip */
    );
  }

  el.forProcessed = true; // avoid recursion
  return (altHelper || '_l') + "((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + ((altGen || genElement)(el, state)) +
    '})'
}

function genData$2 (el, state) {
  var data = '{';

  // directives first.
  // directives may mutate the el's other properties before they are generated.
  var dirs = genDirectives(el, state);
  if (dirs) { data += dirs + ','; }

  // key
  if (el.key) {
    data += "key:" + (el.key) + ",";
  }
  // ref
  if (el.ref) {
    data += "ref:" + (el.ref) + ",";
  }
  if (el.refInFor) {
    data += "refInFor:true,";
  }
  // pre
  if (el.pre) {
    data += "pre:true,";
  }
  // record original tag name for components using "is" attribute
  if (el.component) {
    data += "tag:\"" + (el.tag) + "\",";
  }
  // module data generation functions
  for (var i = 0; i < state.dataGenFns.length; i++) {
    data += state.dataGenFns[i](el);
  }
  // attributes
  if (el.attrs) {
    data += "attrs:{" + (genProps(el.attrs)) + "},";
  }
  // DOM props
  if (el.props) {
    data += "domProps:{" + (genProps(el.props)) + "},";
  }
  // event handlers
  if (el.events) {
    data += (genHandlers(el.events, false, state.warn)) + ",";
  }
  if (el.nativeEvents) {
    data += (genHandlers(el.nativeEvents, true, state.warn)) + ",";
  }
  // slot target
  // only for non-scoped slots
  if (el.slotTarget && !el.slotScope) {
    data += "slot:" + (el.slotTarget) + ",";
  }
  // scoped slots
  if (el.scopedSlots) {
    data += (genScopedSlots(el.scopedSlots, state)) + ",";
  }
  // component v-model
  if (el.model) {
    data += "model:{value:" + (el.model.value) + ",callback:" + (el.model.callback) + ",expression:" + (el.model.expression) + "},";
  }
  // inline-template
  if (el.inlineTemplate) {
    var inlineTemplate = genInlineTemplate(el, state);
    if (inlineTemplate) {
      data += inlineTemplate + ",";
    }
  }
  data = data.replace(/,$/, '') + '}';
  // v-bind data wrap
  if (el.wrapData) {
    data = el.wrapData(data);
  }
  // v-on data wrap
  if (el.wrapListeners) {
    data = el.wrapListeners(data);
  }
  return data
}

function genDirectives (el, state) {
  var dirs = el.directives;
  if (!dirs) { return }
  var res = 'directives:[';
  var hasRuntime = false;
  var i, l, dir, needRuntime;
  for (i = 0, l = dirs.length; i < l; i++) {
    dir = dirs[i];
    needRuntime = true;
    var gen = state.directives[dir.name];
    if (gen) {
      // compile-time directive that manipulates AST.
      // returns true if it also needs a runtime counterpart.
      needRuntime = !!gen(el, dir, state.warn);
    }
    if (needRuntime) {
      hasRuntime = true;
      res += "{name:\"" + (dir.name) + "\",rawName:\"" + (dir.rawName) + "\"" + (dir.value ? (",value:(" + (dir.value) + "),expression:" + (JSON.stringify(dir.value))) : '') + (dir.arg ? (",arg:\"" + (dir.arg) + "\"") : '') + (dir.modifiers ? (",modifiers:" + (JSON.stringify(dir.modifiers))) : '') + "},";
    }
  }
  if (hasRuntime) {
    return res.slice(0, -1) + ']'
  }
}

function genInlineTemplate (el, state) {
  var ast = el.children[0];
  if ("development" !== 'production' && (
    el.children.length !== 1 || ast.type !== 1
  )) {
    state.warn('Inline-template components must have exactly one child element.');
  }
  if (ast.type === 1) {
    var inlineRenderFns = generate(ast, state.options);
    return ("inlineTemplate:{render:function(){" + (inlineRenderFns.render) + "},staticRenderFns:[" + (inlineRenderFns.staticRenderFns.map(function (code) { return ("function(){" + code + "}"); }).join(',')) + "]}")
  }
}

function genScopedSlots (
  slots,
  state
) {
  return ("scopedSlots:_u([" + (Object.keys(slots).map(function (key) {
      return genScopedSlot(key, slots[key], state)
    }).join(',')) + "])")
}

function genScopedSlot (
  key,
  el,
  state
) {
  if (el.for && !el.forProcessed) {
    return genForScopedSlot(key, el, state)
  }
  var fn = "function(" + (String(el.slotScope)) + "){" +
    "return " + (el.tag === 'template'
      ? el.if
        ? ((el.if) + "?" + (genChildren(el, state) || 'undefined') + ":undefined")
        : genChildren(el, state) || 'undefined'
      : genElement(el, state)) + "}";
  return ("{key:" + key + ",fn:" + fn + "}")
}

function genForScopedSlot (
  key,
  el,
  state
) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';
  el.forProcessed = true; // avoid recursion
  return "_l((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + (genScopedSlot(key, el, state)) +
    '})'
}

function genChildren (
  el,
  state,
  checkSkip,
  altGenElement,
  altGenNode
) {
  var children = el.children;
  if (children.length) {
    var el$1 = children[0];
    // optimize single v-for
    if (children.length === 1 &&
      el$1.for &&
      el$1.tag !== 'template' &&
      el$1.tag !== 'slot'
    ) {
      return (altGenElement || genElement)(el$1, state)
    }
    var normalizationType = checkSkip
      ? getNormalizationType(children, state.maybeComponent)
      : 0;
    var gen = altGenNode || genNode;
    return ("[" + (children.map(function (c) { return gen(c, state); }).join(',')) + "]" + (normalizationType ? ("," + normalizationType) : ''))
  }
}

// determine the normalization needed for the children array.
// 0: no normalization needed
// 1: simple normalization needed (possible 1-level deep nested array)
// 2: full normalization needed
function getNormalizationType (
  children,
  maybeComponent
) {
  var res = 0;
  for (var i = 0; i < children.length; i++) {
    var el = children[i];
    if (el.type !== 1) {
      continue
    }
    if (needsNormalization(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return needsNormalization(c.block); }))) {
      res = 2;
      break
    }
    if (maybeComponent(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return maybeComponent(c.block); }))) {
      res = 1;
    }
  }
  return res
}

function needsNormalization (el) {
  return el.for !== undefined || el.tag === 'template' || el.tag === 'slot'
}

function genNode (node, state) {
  if (node.type === 1) {
    return genElement(node, state)
  } if (node.type === 3 && node.isComment) {
    return genComment(node)
  } else {
    return genText(node)
  }
}

function genText (text) {
  return ("_v(" + (text.type === 2
    ? text.expression // no need for () because already wrapped in _s()
    : transformSpecialNewlines(JSON.stringify(text.text))) + ")")
}

function genComment (comment) {
  return ("_e(" + (JSON.stringify(comment.text)) + ")")
}

function genSlot (el, state) {
  var slotName = el.slotName || '"default"';
  var children = genChildren(el, state);
  var res = "_t(" + slotName + (children ? ("," + children) : '');
  var attrs = el.attrs && ("{" + (el.attrs.map(function (a) { return ((camelize(a.name)) + ":" + (a.value)); }).join(',')) + "}");
  var bind$$1 = el.attrsMap['v-bind'];
  if ((attrs || bind$$1) && !children) {
    res += ",null";
  }
  if (attrs) {
    res += "," + attrs;
  }
  if (bind$$1) {
    res += (attrs ? '' : ',null') + "," + bind$$1;
  }
  return res + ')'
}

// componentName is el.component, take it as argument to shun flow's pessimistic refinement
function genComponent (
  componentName,
  el,
  state
) {
  var children = el.inlineTemplate ? null : genChildren(el, state, true);
  return ("_c(" + componentName + "," + (genData$2(el, state)) + (children ? ("," + children) : '') + ")")
}

function genProps (props) {
  var res = '';
  for (var i = 0; i < props.length; i++) {
    var prop = props[i];
    /* istanbul ignore if */
    {
      res += "\"" + (prop.name) + "\":" + (transformSpecialNewlines(prop.value)) + ",";
    }
  }
  return res.slice(0, -1)
}

// #3895, #4268
function transformSpecialNewlines (text) {
  return text
    .replace(/\u2028/g, '\\u2028')
    .replace(/\u2029/g, '\\u2029')
}

/*  */

// these keywords should not appear inside expressions, but operators like
// typeof, instanceof and in are allowed
var prohibitedKeywordRE = new RegExp('\\b' + (
  'do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,' +
  'super,throw,while,yield,delete,export,import,return,switch,default,' +
  'extends,finally,continue,debugger,function,arguments'
).split(',').join('\\b|\\b') + '\\b');

// these unary operators should not be used as property/method names
var unaryOperatorsRE = new RegExp('\\b' + (
  'delete,typeof,void'
).split(',').join('\\s*\\([^\\)]*\\)|\\b') + '\\s*\\([^\\)]*\\)');

// strip strings in expressions
var stripStringRE = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;

// detect problematic expressions in a template
function detectErrors (ast) {
  var errors = [];
  if (ast) {
    checkNode(ast, errors);
  }
  return errors
}

function checkNode (node, errors) {
  if (node.type === 1) {
    for (var name in node.attrsMap) {
      if (dirRE.test(name)) {
        var value = node.attrsMap[name];
        if (value) {
          if (name === 'v-for') {
            checkFor(node, ("v-for=\"" + value + "\""), errors);
          } else if (onRE.test(name)) {
            checkEvent(value, (name + "=\"" + value + "\""), errors);
          } else {
            checkExpression(value, (name + "=\"" + value + "\""), errors);
          }
        }
      }
    }
    if (node.children) {
      for (var i = 0; i < node.children.length; i++) {
        checkNode(node.children[i], errors);
      }
    }
  } else if (node.type === 2) {
    checkExpression(node.expression, node.text, errors);
  }
}

function checkEvent (exp, text, errors) {
  var stipped = exp.replace(stripStringRE, '');
  var keywordMatch = stipped.match(unaryOperatorsRE);
  if (keywordMatch && stipped.charAt(keywordMatch.index - 1) !== '$') {
    errors.push(
      "avoid using JavaScript unary operator as property name: " +
      "\"" + (keywordMatch[0]) + "\" in expression " + (text.trim())
    );
  }
  checkExpression(exp, text, errors);
}

function checkFor (node, text, errors) {
  checkExpression(node.for || '', text, errors);
  checkIdentifier(node.alias, 'v-for alias', text, errors);
  checkIdentifier(node.iterator1, 'v-for iterator', text, errors);
  checkIdentifier(node.iterator2, 'v-for iterator', text, errors);
}

function checkIdentifier (
  ident,
  type,
  text,
  errors
) {
  if (typeof ident === 'string') {
    try {
      new Function(("var " + ident + "=_"));
    } catch (e) {
      errors.push(("invalid " + type + " \"" + ident + "\" in expression: " + (text.trim())));
    }
  }
}

function checkExpression (exp, text, errors) {
  try {
    new Function(("return " + exp));
  } catch (e) {
    var keywordMatch = exp.replace(stripStringRE, '').match(prohibitedKeywordRE);
    if (keywordMatch) {
      errors.push(
        "avoid using JavaScript keyword as property name: " +
        "\"" + (keywordMatch[0]) + "\"\n  Raw expression: " + (text.trim())
      );
    } else {
      errors.push(
        "invalid expression: " + (e.message) + " in\n\n" +
        "    " + exp + "\n\n" +
        "  Raw expression: " + (text.trim()) + "\n"
      );
    }
  }
}

/*  */

function createFunction (code, errors) {
  try {
    return new Function(code)
  } catch (err) {
    errors.push({ err: err, code: code });
    return noop
  }
}

function createCompileToFunctionFn (compile) {
  var cache = Object.create(null);

  return function compileToFunctions (
    template,
    options,
    vm
  ) {
    options = extend({}, options);
    var warn$$1 = options.warn || warn;
    delete options.warn;

    /* istanbul ignore if */
    if (true) {
      // detect possible CSP restriction
      try {
        new Function('return 1');
      } catch (e) {
        if (e.toString().match(/unsafe-eval|CSP/)) {
          warn$$1(
            'It seems you are using the standalone build of Vue.js in an ' +
            'environment with Content Security Policy that prohibits unsafe-eval. ' +
            'The template compiler cannot work in this environment. Consider ' +
            'relaxing the policy to allow unsafe-eval or pre-compiling your ' +
            'templates into render functions.'
          );
        }
      }
    }

    // check cache
    var key = options.delimiters
      ? String(options.delimiters) + template
      : template;
    if (cache[key]) {
      return cache[key]
    }

    // compile
    var compiled = compile(template, options);

    // check compilation errors/tips
    if (true) {
      if (compiled.errors && compiled.errors.length) {
        warn$$1(
          "Error compiling template:\n\n" + template + "\n\n" +
          compiled.errors.map(function (e) { return ("- " + e); }).join('\n') + '\n',
          vm
        );
      }
      if (compiled.tips && compiled.tips.length) {
        compiled.tips.forEach(function (msg) { return tip(msg, vm); });
      }
    }

    // turn code into functions
    var res = {};
    var fnGenErrors = [];
    res.render = createFunction(compiled.render, fnGenErrors);
    res.staticRenderFns = compiled.staticRenderFns.map(function (code) {
      return createFunction(code, fnGenErrors)
    });

    // check function generation errors.
    // this should only happen if there is a bug in the compiler itself.
    // mostly for codegen development use
    /* istanbul ignore if */
    if (true) {
      if ((!compiled.errors || !compiled.errors.length) && fnGenErrors.length) {
        warn$$1(
          "Failed to generate render function:\n\n" +
          fnGenErrors.map(function (ref) {
            var err = ref.err;
            var code = ref.code;

            return ((err.toString()) + " in\n\n" + code + "\n");
        }).join('\n'),
          vm
        );
      }
    }

    return (cache[key] = res)
  }
}

/*  */

function createCompilerCreator (baseCompile) {
  return function createCompiler (baseOptions) {
    function compile (
      template,
      options
    ) {
      var finalOptions = Object.create(baseOptions);
      var errors = [];
      var tips = [];
      finalOptions.warn = function (msg, tip) {
        (tip ? tips : errors).push(msg);
      };

      if (options) {
        // merge custom modules
        if (options.modules) {
          finalOptions.modules =
            (baseOptions.modules || []).concat(options.modules);
        }
        // merge custom directives
        if (options.directives) {
          finalOptions.directives = extend(
            Object.create(baseOptions.directives || null),
            options.directives
          );
        }
        // copy other options
        for (var key in options) {
          if (key !== 'modules' && key !== 'directives') {
            finalOptions[key] = options[key];
          }
        }
      }

      var compiled = baseCompile(template, finalOptions);
      if (true) {
        errors.push.apply(errors, detectErrors(compiled.ast));
      }
      compiled.errors = errors;
      compiled.tips = tips;
      return compiled
    }

    return {
      compile: compile,
      compileToFunctions: createCompileToFunctionFn(compile)
    }
  }
}

/*  */

// `createCompilerCreator` allows creating compilers that use alternative
// parser/optimizer/codegen, e.g the SSR optimizing compiler.
// Here we just export a default compiler using the default parts.
var createCompiler = createCompilerCreator(function baseCompile (
  template,
  options
) {
  var ast = parse(template.trim(), options);
  if (options.optimize !== false) {
    optimize(ast, options);
  }
  var code = generate(ast, options);
  return {
    ast: ast,
    render: code.render,
    staticRenderFns: code.staticRenderFns
  }
});

/*  */

var ref$1 = createCompiler(baseOptions);
var compileToFunctions = ref$1.compileToFunctions;

/*  */

// check whether current browser encodes a char inside attribute values
var div;
function getShouldDecode (href) {
  div = div || document.createElement('div');
  div.innerHTML = href ? "<a href=\"\n\"/>" : "<div a=\"\n\"/>";
  return div.innerHTML.indexOf('&#10;') > 0
}

// #3663: IE encodes newlines inside attribute values while other browsers don't
var shouldDecodeNewlines = inBrowser ? getShouldDecode(false) : false;
// #6828: chrome encodes content in a[href]
var shouldDecodeNewlinesForHref = inBrowser ? getShouldDecode(true) : false;

/*  */

var idToTemplate = cached(function (id) {
  var el = query(id);
  return el && el.innerHTML
});

var mount = Vue.prototype.$mount;
Vue.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && query(el);

  /* istanbul ignore if */
  if (el === document.body || el === document.documentElement) {
    "development" !== 'production' && warn(
      "Do not mount Vue to <html> or <body> - mount to normal elements instead."
    );
    return this
  }

  var options = this.$options;
  // resolve template/el and convert to render function
  if (!options.render) {
    var template = options.template;
    if (template) {
      if (typeof template === 'string') {
        if (template.charAt(0) === '#') {
          template = idToTemplate(template);
          /* istanbul ignore if */
          if ("development" !== 'production' && !template) {
            warn(
              ("Template element not found or is empty: " + (options.template)),
              this
            );
          }
        }
      } else if (template.nodeType) {
        template = template.innerHTML;
      } else {
        if (true) {
          warn('invalid template option:' + template, this);
        }
        return this
      }
    } else if (el) {
      template = getOuterHTML(el);
    }
    if (template) {
      /* istanbul ignore if */
      if ("development" !== 'production' && config.performance && mark) {
        mark('compile');
      }

      var ref = compileToFunctions(template, {
        shouldDecodeNewlines: shouldDecodeNewlines,
        shouldDecodeNewlinesForHref: shouldDecodeNewlinesForHref,
        delimiters: options.delimiters,
        comments: options.comments
      }, this);
      var render = ref.render;
      var staticRenderFns = ref.staticRenderFns;
      options.render = render;
      options.staticRenderFns = staticRenderFns;

      /* istanbul ignore if */
      if ("development" !== 'production' && config.performance && mark) {
        mark('compile end');
        measure(("vue " + (this._name) + " compile"), 'compile', 'compile end');
      }
    }
  }
  return mount.call(this, el, hydrating)
};

/**
 * Get outerHTML of elements, taking care
 * of SVG elements in IE as well.
 */
function getOuterHTML (el) {
  if (el.outerHTML) {
    return el.outerHTML
  } else {
    var container = document.createElement('div');
    container.appendChild(el.cloneNode(true));
    return container.innerHTML
  }
}

Vue.compile = compileToFunctions;

module.exports = Vue;

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(3), __webpack_require__(11).setImmediate))

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["vue-tabs"] = factory();
	else
		root["VueTabs"] = factory();
})(typeof self !== 'undefined' ? self : this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__webpack_require__(6)(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),
/* 2 */
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate
    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 3 */
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),
/* 4 */
/***/ (function(module, exports) {

var core = module.exports = { version: '2.5.7' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__(23);
var IE8_DOM_DEFINE = __webpack_require__(24);
var toPrimitive = __webpack_require__(26);
var dP = Object.defineProperty;

exports.f = __webpack_require__(0) ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),
/* 6 */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (global, factory) {
    if (true) {
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [exports, __webpack_require__(8), __webpack_require__(11)], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports !== "undefined") {
        factory(exports, require('./components/Tab'), require('./components/Tabs'));
    } else {
        var mod = {
            exports: {}
        };
        factory(mod.exports, global.Tab, global.Tabs);
        global.index = mod.exports;
    }
})(this, function (exports, _Tab, _Tabs) {
    'use strict';

    Object.defineProperty(exports, "__esModule", {
        value: true
    });
    exports.Tabs = exports.Tab = undefined;

    var _Tab2 = _interopRequireDefault(_Tab);

    var _Tabs2 = _interopRequireDefault(_Tabs);

    function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {
            default: obj
        };
    }

    exports.default = {
        install: function install(Vue) {
            Vue.component('tab', _Tab2.default);
            Vue.component('tabs', _Tabs2.default);
        }
    };
    exports.Tab = _Tab2.default;
    exports.Tabs = _Tabs2.default;
});

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(9),
  /* template */
  __webpack_require__(10),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)

module.exports = Component.exports


/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (global, factory) {
    if (true) {
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [exports], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports !== "undefined") {
        factory(exports);
    } else {
        var mod = {
            exports: {}
        };
        factory(mod.exports);
        global.Tab = mod.exports;
    }
})(this, function (exports) {
    'use strict';

    Object.defineProperty(exports, "__esModule", {
        value: true
    });
    exports.default = {
        props: {
            id: { default: null },
            name: { required: true },
            prefix: { default: '' },
            suffix: { default: '' },
            isDisabled: { default: false }
        },

        data: function data() {
            return {
                isActive: false,
                isVisible: true
            };
        },

        computed: {
            header: function header() {
                return this.prefix + this.name + this.suffix;
            },
            computedId: function computedId() {
                return this.id ? this.id : this.name.toLowerCase().replace(/ /g, '-');
            },
            hash: function hash() {
                if (this.isDisabled) {
                    return '#';
                }

                return '#' + this.computedId;
            }
        }
    };
});

/***/ }),
/* 10 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('section', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.isActive),
      expression: "isActive"
    }],
    staticClass: "tabs-component-panel",
    attrs: {
      "aria-hidden": !_vm.isActive,
      "id": _vm.computedId,
      "role": "tabpanel"
    }
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(2)(
  /* script */
  __webpack_require__(12),
  /* template */
  __webpack_require__(29),
  /* styles */
  null,
  /* scopeId */
  null,
  /* moduleIdentifier (server only) */
  null
)

module.exports = Component.exports


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (global, factory) {
    if (true) {
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [exports, __webpack_require__(13)], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports !== "undefined") {
        factory(exports, require('../expiringStorage'));
    } else {
        var mod = {
            exports: {}
        };
        factory(mod.exports, global.expiringStorage);
        global.Tabs = mod.exports;
    }
})(this, function (exports, _expiringStorage) {
    'use strict';

    Object.defineProperty(exports, "__esModule", {
        value: true
    });

    var _expiringStorage2 = _interopRequireDefault(_expiringStorage);

    function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {
            default: obj
        };
    }

    exports.default = {
        props: {
            cacheLifetime: {
                default: 5
            },
            options: {
                type: Object,
                required: false,
                default: function _default() {
                    return {
                        useUrlFragment: true,
                        defaultTabHash: null
                    };
                }
            }
        },

        data: function data() {
            return {
                tabs: [],
                activeTabHash: '',
                activeTabIndex: 0,
                lastActiveTabHash: ''
            };
        },

        computed: {
            storageKey: function storageKey() {
                return 'vue-tabs-component.cache.' + window.location.host + window.location.pathname;
            }
        },

        created: function created() {
            this.tabs = this.$children;
        },
        mounted: function mounted() {
            var _this = this;

            window.addEventListener('hashchange', function () {
                return _this.selectTab(window.location.hash);
            });

            if (this.findTab(window.location.hash)) {
                this.selectTab(window.location.hash);
                return;
            }

            var previousSelectedTabHash = _expiringStorage2.default.get(this.storageKey);

            if (this.findTab(previousSelectedTabHash)) {
                this.selectTab(previousSelectedTabHash);
                return;
            }

            if (this.options.defaultTabHash !== null && this.findTab("#" + this.options.defaultTabHash)) {
                this.selectTab("#" + this.options.defaultTabHash);
                return;
            }

            if (this.tabs.length) {
                this.selectTab(this.tabs[0].hash);
            }
        },


        methods: {
            findTab: function findTab(hash) {
                return this.tabs.find(function (tab) {
                    return tab.hash === hash;
                });
            },
            selectTab: function selectTab(selectedTabHash, event) {
                // See if we should store the hash in the url fragment.
                if (event && !this.options.useUrlFragment) {
                    event.preventDefault();
                }

                var selectedTab = this.findTab(selectedTabHash);

                if (!selectedTab) {
                    return;
                }

                if (selectedTab.isDisabled) {
                    event.preventDefault();
                    return;
                }

                if (this.lastActiveTabHash === selectedTab.hash) {
                    this.$emit('clicked', { tab: selectedTab });
                    return;
                }

                this.tabs.forEach(function (tab) {
                    tab.isActive = tab.hash === selectedTab.hash;
                });

                this.$emit('changed', { tab: selectedTab });

                this.activeTabHash = selectedTab.hash;
                this.activeTabIndex = this.getTabIndex(selectedTabHash);

                this.lastActiveTabHash = this.activeTabHash = selectedTab.hash;

                _expiringStorage2.default.set(this.storageKey, selectedTab.hash, this.cacheLifetime);
            },
            setTabVisible: function setTabVisible(hash, visible) {
                var tab = this.findTab(hash);

                if (!tab) {
                    return;
                }

                tab.isVisible = visible;

                if (tab.isActive) {
                    // If tab is active, set a different one as active.
                    tab.isActive = visible;

                    this.tabs.every(function (tab, index, array) {
                        if (tab.isVisible) {
                            tab.isActive = true;

                            return false;
                        }

                        return true;
                    });
                }
            },
            getTabIndex: function getTabIndex(hash) {
                var tab = this.findTab(hash);

                return this.tabs.indexOf(tab);
            },
            getTabHash: function getTabHash(index) {
                var _this2 = this;

                var tab = this.tabs.find(function (tab) {
                    return _this2.tabs.indexOf(tab) === index;
                });

                if (!tab) {
                    return;
                }

                return tab.hash;
            },
            getActiveTab: function getActiveTab() {
                return this.findTab(this.activeTabHash);
            },
            getActiveTabIndex: function getActiveTabIndex() {
                return this.getTabIndex(this.activeTabHash);
            }
        }
    };
});

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (global, factory) {
    if (true) {
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [exports, __webpack_require__(14), __webpack_require__(15)], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports !== "undefined") {
        factory(exports, require("babel-runtime/helpers/classCallCheck"), require("babel-runtime/helpers/createClass"));
    } else {
        var mod = {
            exports: {}
        };
        factory(mod.exports, global.classCallCheck, global.createClass);
        global.expiringStorage = mod.exports;
    }
})(this, function (exports, _classCallCheck2, _createClass2) {
    "use strict";

    Object.defineProperty(exports, "__esModule", {
        value: true
    });

    var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

    var _createClass3 = _interopRequireDefault(_createClass2);

    function _interopRequireDefault(obj) {
        return obj && obj.__esModule ? obj : {
            default: obj
        };
    }

    var ExpiringStorage = function () {
        function ExpiringStorage() {
            (0, _classCallCheck3.default)(this, ExpiringStorage);
        }

        (0, _createClass3.default)(ExpiringStorage, [{
            key: "get",
            value: function get(key) {
                var cached = JSON.parse(localStorage.getItem(key));

                if (!cached) {
                    return null;
                }

                var expires = new Date(cached.expires);

                if (expires < new Date()) {
                    localStorage.removeItem(key);
                    return null;
                }

                return cached.value;
            }
        }, {
            key: "set",
            value: function set(key, value, lifeTimeInMinutes) {
                var currentTime = new Date().getTime();

                var expires = new Date(currentTime + lifeTimeInMinutes * 60000);

                localStorage.setItem(key, JSON.stringify({ value: value, expires: expires }));
            }
        }]);
        return ExpiringStorage;
    }();

    exports.default = new ExpiringStorage();
});

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

exports.default = function (instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
};

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

var _defineProperty = __webpack_require__(16);

var _defineProperty2 = _interopRequireDefault(_defineProperty);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = function () {
  function defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      (0, _defineProperty2.default)(target, descriptor.key, descriptor);
    }
  }

  return function (Constructor, protoProps, staticProps) {
    if (protoProps) defineProperties(Constructor.prototype, protoProps);
    if (staticProps) defineProperties(Constructor, staticProps);
    return Constructor;
  };
}();

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(17), __esModule: true };

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(18);
var $Object = __webpack_require__(4).Object;
module.exports = function defineProperty(it, key, desc) {
  return $Object.defineProperty(it, key, desc);
};


/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

var $export = __webpack_require__(19);
// 19.1.2.4 / 15.2.3.6 Object.defineProperty(O, P, Attributes)
$export($export.S + $export.F * !__webpack_require__(0), 'Object', { defineProperty: __webpack_require__(5).f });


/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(3);
var core = __webpack_require__(4);
var ctx = __webpack_require__(20);
var hide = __webpack_require__(22);
var has = __webpack_require__(28);
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var IS_WRAP = type & $export.W;
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE];
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE];
  var key, own, out;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    if (own && has(exports, key)) continue;
    // export native or passed
    out = own ? target[key] : source[key];
    // prevent global pollution for namespaces
    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
    // bind timers to global for call from export context
    : IS_BIND && own ? ctx(out, global)
    // wrap global constructors for prevent change them in library
    : IS_WRAP && target[key] == out ? (function (C) {
      var F = function (a, b, c) {
        if (this instanceof C) {
          switch (arguments.length) {
            case 0: return new C();
            case 1: return new C(a);
            case 2: return new C(a, b);
          } return new C(a, b, c);
        } return C.apply(this, arguments);
      };
      F[PROTOTYPE] = C[PROTOTYPE];
      return F;
    // make static versions for prototype methods
    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
    if (IS_PROTO) {
      (exports.virtual || (exports.virtual = {}))[key] = out;
      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
      if (type & $export.R && expProto && !expProto[key]) hide(expProto, key, out);
    }
  }
};
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

// optional / simple context binding
var aFunction = __webpack_require__(21);
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),
/* 21 */
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__(5);
var createDesc = __webpack_require__(27);
module.exports = __webpack_require__(0) ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(1);
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = !__webpack_require__(0) && !__webpack_require__(6)(function () {
  return Object.defineProperty(__webpack_require__(25)('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(1);
var document = __webpack_require__(3).document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __webpack_require__(1);
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),
/* 27 */
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),
/* 28 */
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),
/* 29 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "tabs-component"
  }, [_c('ul', {
    staticClass: "tabs-component-tabs",
    attrs: {
      "role": "tablist"
    }
  }, _vm._l((_vm.tabs), function(tab, i) {
    return _c('li', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (tab.isVisible),
        expression: "tab.isVisible"
      }],
      key: i,
      staticClass: "tabs-component-tab",
      class: {
        'is-active': tab.isActive, 'is-disabled': tab.isDisabled
      },
      attrs: {
        "role": "presentation"
      }
    }, [_c('a', {
      staticClass: "tabs-component-tab-a",
      attrs: {
        "aria-controls": tab.hash,
        "aria-selected": tab.isActive,
        "href": tab.hash,
        "role": "tab"
      },
      domProps: {
        "innerHTML": _vm._s(tab.header)
      },
      on: {
        "click": function($event) {
          _vm.selectTab(tab.hash, $event)
        }
      }
    })])
  })), _vm._v(" "), _c('div', {
    staticClass: "tabs-component-panels"
  }, [_vm._t("default")], 2)])
},staticRenderFns: []}

/***/ })
/******/ ]);
});

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

!function(t,i){ true?module.exports=i():"function"==typeof define&&define.amd?define([],i):"object"==typeof exports?exports.VueDragResize=i():t.VueDragResize=i()}(window,function(){return function(t){function i(n){if(e[n])return e[n].exports;var o=e[n]={i:n,l:!1,exports:{}};return t[n].call(o.exports,o,o.exports,i),o.l=!0,o.exports}var e={};return i.m=t,i.c=e,i.d=function(t,e,n){i.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:n})},i.r=function(t){Object.defineProperty(t,"__esModule",{value:!0})},i.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,i){return Object.prototype.hasOwnProperty.call(t,i)},i.p="",i(i.s=44)}({0:function(t,i,e){var n=e(16);"string"==typeof n&&(n=[[t.i,n,""]]);var o={};o.transform=void 0;e(5)(n,o);n.locals&&(t.exports=n.locals)},1:function(t,i,e){"use strict";Object.defineProperty(i,"__esModule",{value:!0});var n={y:{t:"top",m:"marginTop",b:"bottom"},x:{l:"left",m:"marginLeft",r:"right"}};i.default={name:"vue-drag-resize",props:{parentScaleX:{type:Number,default:1},parentScaleY:{type:Number,default:1},isActive:{type:Boolean,default:!1},preventActiveBehavior:{type:Boolean,default:!1},isDraggable:{type:Boolean,default:!0},isResizable:{type:Boolean,default:!0},aspectRatio:{type:Boolean,default:!1},parentLimitation:{type:Boolean,default:!1},parentW:{type:Number,default:0,validator:function(t){return t>=0}},parentH:{type:Number,default:0,validator:function(t){return t>=0}},w:{type:Number,default:100,validator:function(t){return t>0}},h:{type:Number,default:100,validator:function(t){return t>0}},minw:{type:Number,default:50,validator:function(t){return t>0}},minh:{type:Number,default:50,validator:function(t){return t>0}},x:{type:Number,default:0,validator:function(t){return"number"==typeof t}},y:{type:Number,default:0,validator:function(t){return"number"==typeof t}},z:{type:[String,Number],default:"auto",validator:function(t){return"string"==typeof t?"auto"===t:t>=0}},dragHandle:{type:String,default:null},dragCancel:{type:String,default:null},sticks:{type:Array,default:function(){return["tl","tm","tr","mr","br","bm","bl","ml"]}},axis:{type:String,default:"both",validator:function(t){return-1!==["x","y","both","none"].indexOf(t)}}},data:function(){return{active:this.isActive,rawWidth:this.w,rawHeight:this.h,rawLeft:this.x,rawTop:this.y,rawRight:null,rawBottom:null,zIndex:this.z,aspectFactor:this.w/this.h,parentWidth:null,parentHeight:null,left:this.x,top:this.y,right:null,bottom:null,minWidth:this.minw,minHeight:this.minh}},created:function(){this.stickDrag=!1,this.bodyDrag=!1,this.stickAxis=null,this.stickStartPos={mouseX:0,mouseY:0,x:0,y:0,w:0,h:0},this.limits={minLeft:null,maxLeft:null,minRight:null,maxRight:null,minTop:null,maxTop:null,minBottom:null,maxBottom:null},this.currentStick=[]},mounted:function(){if(this.parentElement=this.$el.parentNode,this.parentWidth=this.parentW?this.parentW:this.parentElement.clientWidth,this.parentHeight=this.parentH?this.parentH:this.parentElement.clientHeight,this.rawRight=this.parentWidth-this.rawWidth-this.rawLeft,this.rawBottom=this.parentHeight-this.rawHeight-this.rawTop,document.documentElement.addEventListener("mousemove",this.move),document.documentElement.addEventListener("mouseup",this.up),document.documentElement.addEventListener("mouseleave",this.up),document.documentElement.addEventListener("mousedown",this.deselect),document.documentElement.addEventListener("touchmove",this.move,!0),document.documentElement.addEventListener("touchend touchcancel",this.up,!0),document.documentElement.addEventListener("touchstart",this.up,!0),this.dragHandle){var t=Array.prototype.slice.call(this.$el.querySelectorAll(this.dragHandle));for(var i in t)t[i].setAttribute("data-drag-handle",this._uid)}if(this.dragCancel){var e=Array.prototype.slice.call(this.$el.querySelectorAll(this.dragCancel));for(var n in e)e[n].setAttribute("data-drag-cancel",this._uid)}},beforeDestroy:function(){document.documentElement.removeEventListener("mousemove",this.move),document.documentElement.removeEventListener("mouseup",this.up),document.documentElement.removeEventListener("mouseleave",this.up),document.documentElement.removeEventListener("mousedown",this.deselect),document.documentElement.removeEventListener("touchmove",this.move,!0),document.documentElement.removeEventListener("touchend touchcancel",this.up,!0),document.documentElement.removeEventListener("touchstart",this.up,!0)},methods:{deselect:function(){this.preventActiveBehavior||(this.active=!1)},move:function(t){(this.stickDrag||this.bodyDrag)&&(t.stopPropagation(),this.stickDrag&&this.stickMove(t),this.bodyDrag&&this.bodyMove(t))},up:function(t){this.stickDrag&&this.stickUp(t),this.bodyDrag&&this.bodyUp(t)},bodyDown:function(t){var i=t.target||t.srcElement;this.preventActiveBehavior||(this.active=!0),t.button&&0!==t.button||(this.$emit("clicked",t),this.isDraggable&&this.active&&(this.dragHandle&&i.getAttribute("data-drag-handle")!==this._uid.toString()||this.dragCancel&&i.getAttribute("data-drag-cancel")===this._uid.toString()||(this.bodyDrag=!0,this.stickStartPos.mouseX=t.pageX||t.touches[0].pageX,this.stickStartPos.mouseY=t.pageY||t.touches[0].pageY,this.stickStartPos.left=this.left,this.stickStartPos.right=this.right,this.stickStartPos.top=this.top,this.stickStartPos.bottom=this.bottom,this.parentLimitation&&(this.limits=this.calcDragLimitation()))))},calcDragLimitation:function(){var t=this.parentWidth,i=this.parentHeight;return{minLeft:0,maxLeft:t-this.width,minRight:0,maxRight:t-this.width,minTop:0,maxTop:i-this.height,minBottom:0,maxBottom:i-this.height}},bodyMove:function(t){var i=this.stickStartPos,e={x:("y"!==this.axis&&"none"!==this.axis?i.mouseX-(t.pageX||t.touches[0].pageX):0)/this.parentScaleX,y:("x"!==this.axis&&"none"!==this.axis?i.mouseY-(t.pageY||t.touches[0].pageY):0)/this.parentScaleY};this.rawTop=i.top-e.y,this.rawBottom=i.bottom+e.y,this.rawLeft=i.left-e.x,this.rawRight=i.right+e.x,this.$emit("dragging",this.rect)},bodyUp:function(){this.bodyDrag=!1,this.$emit("dragging",this.rect),this.$emit("dragstop",this.rect),this.stickStartPos={mouseX:0,mouseY:0,x:0,y:0,w:0,h:0},this.limits={minLeft:null,maxLeft:null,minRight:null,maxRight:null,minTop:null,maxTop:null,minBottom:null,maxBottom:null}},stickDown:function(t,i){if(this.isResizable&&this.active){switch(this.stickDrag=!0,this.stickStartPos.mouseX=i.pageX||i.touches[0].pageX,this.stickStartPos.mouseY=i.pageY||i.touches[0].pageY,this.stickStartPos.left=this.left,this.stickStartPos.right=this.right,this.stickStartPos.top=this.top,this.stickStartPos.bottom=this.bottom,this.currentStick=t.split(""),this.stickAxis=null,this.currentStick[0]){case"b":case"t":this.stickAxis="y"}switch(this.currentStick[1]){case"r":case"l":this.stickAxis="y"===this.stickAxis?"xy":"x"}this.limits=this.calcResizeLimitation()}},calcResizeLimitation:function(){var t=this.minWidth,i=this.minHeight,e=this.aspectFactor,n=this.width,o=this.height,s=this.bottom,r=this.top,a=this.left,h=this.right,c=this.stickAxis,u=this.parentLimitation?0:null;this.aspectRatio&&(t/i>e?i=t/e:t=e*i);var l={minLeft:u,maxLeft:a+(n-t),minRight:u,maxRight:h+(n-t),minTop:u,maxTop:r+(o-i),minBottom:u,maxBottom:s+(o-i)};if(this.aspectRatio){var m={minLeft:a-Math.min(r,s)*e*2,maxLeft:a+(o-i)/2*e*2,minRight:h-Math.min(r,s)*e*2,maxRight:h+(o-i)/2*e*2,minTop:r-Math.min(a,h)/e*2,maxTop:r+(n-t)/2/e*2,minBottom:s-Math.min(a,h)/e*2,maxBottom:s+(n-t)/2/e*2};"x"===c?l={minLeft:Math.max(l.minLeft,m.minLeft),maxLeft:Math.min(l.maxLeft,m.maxLeft),minRight:Math.max(l.minRight,m.minRight),maxRight:Math.min(l.maxRight,m.maxRight)}:"y"===c&&(l={minTop:Math.max(l.minTop,m.minTop),maxTop:Math.min(l.maxTop,m.maxTop),minBottom:Math.max(l.minBottom,m.minBottom),maxBottom:Math.min(l.maxBottom,m.maxBottom)})}return l},stickMove:function(t){var i=this.stickStartPos,e={x:(i.mouseX-(t.pageX||t.touches[0].pageX))/this.parentScaleX,y:(i.mouseY-(t.pageY||t.touches[0].pageY))/this.parentScaleY};switch(this.currentStick[0]){case"b":this.rawBottom=i.bottom+e.y;break;case"t":this.rawTop=i.top-e.y}switch(this.currentStick[1]){case"r":this.rawRight=i.right+e.x;break;case"l":this.rawLeft=i.left-e.x}this.$emit("resizing",this.rect)},stickUp:function(){this.stickDrag=!1,this.stickStartPos={mouseX:0,mouseY:0,x:0,y:0,w:0,h:0},this.limits={minLeft:null,maxLeft:null,minRight:null,maxRight:null,minTop:null,maxTop:null,minBottom:null,maxBottom:null},this.rawTop=this.top,this.rawBottom=this.bottom,this.rawLeft=this.left,this.rawRight=this.right,this.stickAxis=null,this.$emit("resizing",this.rect),this.$emit("resizestop",this.rect)},aspectRatioCorrection:function(){if(this.aspectRatio){var t=this.bottom,i=this.top,e=this.left,n=this.right,o=this.width,s=this.height,r=this.aspectFactor,a=this.currentStick;if(o/s>r){var h=r*s;"l"===a[1]?this.left=e+o-h:this.right=n+o-h}else{var c=o/r;"t"===a[0]?this.top=i+s-c:this.bottom=t+s-c}}}},computed:{style:function(){return{top:this.top+"px",left:this.left+"px",width:this.width+"px",height:this.height+"px",zIndex:this.zIndex}},vdrStick:function(){var t=this;return function(i){var e={width:8/t.parentScaleX+"px",height:8/t.parentScaleY+"px"};return e[n.y[i[0]]]=8/t.parentScaleX/-2+"px",e[n.x[i[1]]]=8/t.parentScaleX/-2+"px",e}},width:function(){return this.parentWidth-this.left-this.right},height:function(){return this.parentHeight-this.top-this.bottom},rect:function(){return{left:Math.round(this.left),top:Math.round(this.top),width:Math.round(this.width),height:Math.round(this.height)}}},watch:{rawLeft:function(t){var i=this.limits,e=this.stickAxis,n=this.aspectFactor,o=this.aspectRatio,s=this.left,r=this.bottom,a=this.top;if(null!==i.minLeft&&t<i.minLeft?t=i.minLeft:null!==i.maxLeft&&i.maxLeft<t&&(t=i.maxLeft),o&&"x"===e){var h=s-t;this.rawTop=a-h/n/2,this.rawBottom=r-h/n/2}this.left=t},rawRight:function(t){var i=this.limits,e=this.stickAxis,n=this.aspectFactor,o=this.aspectRatio,s=this.right,r=this.bottom,a=this.top;if(null!==i.minRight&&t<i.minRight?t=i.minRight:null!==i.maxRight&&i.maxRight<t&&(t=i.maxRight),o&&"x"===e){var h=s-t;this.rawTop=a-h/n/2,this.rawBottom=r-h/n/2}this.right=t},rawTop:function(t){var i=this.limits,e=this.stickAxis,n=this.aspectFactor,o=this.aspectRatio,s=this.right,r=this.left,a=this.top;if(null!==i.minTop&&t<i.minTop?t=i.minTop:null!==i.maxTop&&i.maxTop<t&&(t=i.maxTop),o&&"y"===e){var h=a-t;this.rawLeft=r-h*n/2,this.rawRight=s-h*n/2}this.top=t},rawBottom:function(t){var i=this.limits,e=this.stickAxis,n=this.aspectFactor,o=this.aspectRatio,s=this.right,r=this.left,a=this.bottom;if(null!==i.minBottom&&t<i.minBottom?t=i.minBottom:null!==i.maxBottom&&i.maxBottom<t&&(t=i.maxBottom),o&&"y"===e){var h=a-t;this.rawLeft=r-h*n/2,this.rawRight=s-h*n/2}this.bottom=t},width:function(){this.aspectRatioCorrection()},height:function(){this.aspectRatioCorrection()},active:function(t){t?this.$emit("activated"):this.$emit("deactivated")},isActive:function(t){this.active=t},z:function(t){(t>=0||"auto"===t)&&(this.zIndex=t)},aspectRatio:function(t){t&&(this.aspectFactor=this.width/this.height)},minw:function(t){t>0&&t<=this.width&&(this.minWidth=t)},minh:function(t){t>0&&t<=this.height&&(this.minHeight=t)},x:function(){if(!this.stickDrag&&!this.bodyDrag){this.parentLimitation&&(this.limits=this.calcDragLimitation());var t=this.x-this.left;this.rawLeft=this.x,this.rawRight=this.right-t}},y:function(){if(!this.stickDrag&&!this.bodyDrag){this.parentLimitation&&(this.limits=this.calcDragLimitation());var t=this.y-this.top;this.rawTop=this.y,this.rawBottom=this.bottom-t}},w:function(){if(!this.stickDrag&&!this.bodyDrag){this.currentStick=["m","r"],this.stickAxis="x",this.parentLimitation&&(this.limits=this.calcResizeLimitation());var t=this.width-this.w;this.rawRight=this.right+t}},h:function(){if(!this.stickDrag&&!this.bodyDrag){this.currentStick=["b","m"],this.stickAxis="y",this.parentLimitation&&(this.limits=this.calcResizeLimitation());var t=this.height-this.h;this.rawBottom=this.bottom+t}},parentW:function(t){this.right=t-this.width-this.left,this.parentWidth=t},parentH:function(t){this.bottom=t-this.height-this.top,this.parentHeight=t}}}},15:function(t,i){t.exports=function(t){var i="undefined"!=typeof window&&window.location;if(!i)throw new Error("fixUrls requires window.location");if(!t||"string"!=typeof t)return t;var e=i.protocol+"//"+i.host,n=e+i.pathname.replace(/\/[^\/]*$/,"/");return t.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,function(t,i){var o=i.trim().replace(/^"(.*)"$/,function(t,i){return i}).replace(/^'(.*)'$/,function(t,i){return i});if(/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(o))return t;var s;return s=0===o.indexOf("//")?o:0===o.indexOf("/")?e+o:n+o.replace(/^\.\//,""),"url("+JSON.stringify(s)+")"})}},16:function(t,i,e){i=t.exports=e(6)(!1),i.push([t.i,'\n.vdr,.vdr.active:before{position:absolute;-webkit-box-sizing:border-box;box-sizing:border-box\n}\n.vdr.active:before{content:"";width:100%;height:100%;top:0;left:0;outline:1px dashed #d6d6d6\n}\n.vdr-stick{-webkit-box-sizing:border-box;box-sizing:border-box;position:absolute;font-size:1px;background:#fff;border:1px solid #6c6c6c;-webkit-box-shadow:0 0 2px #bbb;box-shadow:0 0 2px #bbb\n}\n.inactive .vdr-stick{display:none\n}\n.vdr-stick-br,.vdr-stick-tl{cursor:nwse-resize\n}\n.vdr-stick-bm,.vdr-stick-tm{left:50%;cursor:ns-resize\n}\n.vdr-stick-bl,.vdr-stick-tr{cursor:nesw-resize\n}\n.vdr-stick-ml,.vdr-stick-mr{top:50%;cursor:ew-resize\n}\n.vdr-stick.not-resizable{display:none\n}',""])},17:function(t,i,e){"use strict";var n=e(0),o=e.n(n);o.a},18:function(t,i,e){"use strict";e.r(i);var n=e(4),o=e(2);for(var s in o)"default"!==s&&function(t){e.d(i,t,function(){return o[t]})}(s);var r=(e(17),e(3)),a=Object(r.a)(o.default,n.a,n.b,!1,null,null,null);a.options.__file="src/components/vue-drag-resize.vue",i.default=a.exports},2:function(t,i,e){"use strict";e.r(i);var n=e(1),o=e.n(n);for(var s in n)"default"!==s&&function(t){e.d(i,t,function(){return n[t]})}(s);i.default=o.a},3:function(t,i,e){"use strict";function n(t,i,e,n,o,s,r,a){var h="function"==typeof t?t.options:t;i&&(h.render=i,h.staticRenderFns=e,h._compiled=!0),n&&(h.functional=!0),s&&(h._scopeId="data-v-"+s);var c;if(r?(c=function(t){t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,t||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(r)},h._ssrRegister=c):o&&(c=a?function(){o.call(this,this.$root.$options.shadowRoot)}:o),c)if(h.functional){h._injectStyles=c;var u=h.render;h.render=function(t,i){return c.call(i),u(t,i)}}else{var l=h.beforeCreate;h.beforeCreate=l?[].concat(l,c):[c]}return{exports:t,options:h}}e.d(i,"a",function(){return n})},4:function(t,i,e){"use strict";var n=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("div",{staticClass:"vdr",class:t.active||t.isActive?"active":"inactive",style:t.style,on:{mousedown:function(i){i.stopPropagation(),i.preventDefault(),t.bodyDown(i)},touchstart:function(i){i.stopPropagation(),i.preventDefault(),t.bodyDown(i)}}},[t._t("default"),t._v(" "),t._l(t.sticks,function(i){return e("div",{staticClass:"vdr-stick",class:["vdr-stick-"+i,t.isResizable?"":"not-resizable"],style:t.vdrStick(i),on:{mousedown:function(e){e.stopPropagation(),e.preventDefault(),t.stickDown(i,e)},touchstart:function(e){e.stopPropagation(),e.preventDefault(),t.stickDown(i,e)}}})})],2)},o=[];n._withStripped=!0;e.d(i,"a",function(){return n}),e.d(i,"b",function(){return o})},44:function(t,i,e){"use strict";function n(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(i,"__esModule",{value:!0});var o=e(18);Object.defineProperty(i,"default",{enumerable:!0,get:function(){return n(o).default}})},5:function(t,i,e){function n(t,i){for(var e=0;e<t.length;e++){var n=t[e],o=p[n.id];if(o){o.refs++;for(var s=0;s<o.parts.length;s++)o.parts[s](n.parts[s]);for(;s<n.parts.length;s++)o.parts.push(u(n.parts[s],i))}else{for(var r=[],s=0;s<n.parts.length;s++)r.push(u(n.parts[s],i));p[n.id]={id:n.id,refs:1,parts:r}}}}function o(t,i){for(var e=[],n={},o=0;o<t.length;o++){var s=t[o],r=i.base?s[0]+i.base:s[0],a=s[1],h=s[2],c=s[3],u={css:a,media:h,sourceMap:c};n[r]?n[r].parts.push(u):e.push(n[r]={id:r,parts:[u]})}return e}function s(t,i){var e=v(t.insertInto);if(!e)throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var n=x[x.length-1];if("top"===t.insertAt)n?n.nextSibling?e.insertBefore(i,n.nextSibling):e.appendChild(i):e.insertBefore(i,e.firstChild),x.push(i);else{if("bottom"!==t.insertAt)throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");e.appendChild(i)}}function r(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t);var i=x.indexOf(t);i>=0&&x.splice(i,1)}function a(t){var i=document.createElement("style");return t.attrs.type="text/css",c(i,t.attrs),s(t,i),i}function h(t){var i=document.createElement("link");return t.attrs.type="text/css",t.attrs.rel="stylesheet",c(i,t.attrs),s(t,i),i}function c(t,i){Object.keys(i).forEach(function(e){t.setAttribute(e,i[e])})}function u(t,i){var e,n,o,s;if(i.transform&&t.css){if(!(s=i.transform(t.css)))return function(){};t.css=s}if(i.singleton){var c=b++;e=g||(g=a(i)),n=l.bind(null,e,c,!1),o=l.bind(null,e,c,!0)}else t.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(e=h(i),n=f.bind(null,e,i),o=function(){r(e),e.href&&URL.revokeObjectURL(e.href)}):(e=a(i),n=m.bind(null,e),o=function(){r(e)});return n(t),function(i){if(i){if(i.css===t.css&&i.media===t.media&&i.sourceMap===t.sourceMap)return;n(t=i)}else o()}}function l(t,i,e,n){var o=e?"":n.css;if(t.styleSheet)t.styleSheet.cssText=w(i,o);else{var s=document.createTextNode(o),r=t.childNodes;r[i]&&t.removeChild(r[i]),r.length?t.insertBefore(s,r[i]):t.appendChild(s)}}function m(t,i){var e=i.css,n=i.media;if(n&&t.setAttribute("media",n),t.styleSheet)t.styleSheet.cssText=e;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(e))}}function f(t,i,e){var n=e.css,o=e.sourceMap,s=void 0===i.convertToAbsoluteUrls&&o;(i.convertToAbsoluteUrls||s)&&(n=y(n)),o&&(n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(o))))+" */");var r=new Blob([n],{type:"text/css"}),a=t.href;t.href=URL.createObjectURL(r),a&&URL.revokeObjectURL(a)}var p={},d=function(t){var i;return function(){return void 0===i&&(i=t.apply(this,arguments)),i}}(function(){return window&&document&&document.all&&!window.atob}),v=function(t){var i={};return function(e){return void 0===i[e]&&(i[e]=t.call(this,e)),i[e]}}(function(t){return document.querySelector(t)}),g=null,b=0,x=[],y=e(15);t.exports=function(t,i){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw new Error("The style-loader cannot be used in a non-browser environment");i=i||{},i.attrs="object"==typeof i.attrs?i.attrs:{},i.singleton||(i.singleton=d()),i.insertInto||(i.insertInto="head"),i.insertAt||(i.insertAt="bottom");var e=o(t,i);return n(e,i),function(t){for(var s=[],r=0;r<e.length;r++){var a=e[r],h=p[a.id];h.refs--,s.push(h)}if(t){n(o(t,i),i)}for(var r=0;r<s.length;r++){var h=s[r];if(0===h.refs){for(var c=0;c<h.parts.length;c++)h.parts[c]();delete p[h.id]}}}};var w=function(){var t=[];return function(i,e){return t[i]=e,t.filter(Boolean).join("\n")}}()},6:function(t,i){function e(t,i){var e=t[1]||"",o=t[3];if(!o)return e;if(i&&"function"==typeof btoa){var s=n(o);return[e].concat(o.sources.map(function(t){return"/*# sourceURL="+o.sourceRoot+t+" */"})).concat([s]).join("\n")}return[e].join("\n")}function n(t){return"/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(t))))+" */"}t.exports=function(t){var i=[];return i.toString=function(){return this.map(function(i){var n=e(i,t);return i[2]?"@media "+i[2]+"{"+n+"}":n}).join("")},i.i=function(t,e){"string"==typeof t&&(t=[[null,t,""]]);for(var n={},o=0;o<this.length;o++){var s=this[o][0];"number"==typeof s&&(n[s]=!0)}for(o=0;o<t.length;o++){var r=t[o];"number"==typeof r[0]&&n[r[0]]||(e&&!r[2]?r[2]=e:e&&(r[2]="("+r[2]+") and ("+e+")"),i.push(r))}},i}}})});

/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(21)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(23)
/* template */
var __vue_template__ = __webpack_require__(51)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-295b482a"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/floorview.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-295b482a", Component.options)
  } else {
    hotAPI.reload("data-v-295b482a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

!function(e,t){ true?module.exports=t():"function"==typeof define&&define.amd?define([],t):"object"==typeof exports?exports.VueDragScroll=t():e.VueDragScroll=t()}("undefined"!=typeof self?self:this,function(){return function(e){function t(o){if(n[o])return n[o].exports;var r=n[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,t),r.l=!0,r.exports}var n={};return t.m=e,t.c=n,t.d=function(e,n,o){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:o})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="/dist/",t(t.s=0)}([function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.dragscroll=void 0;var o=n(1),r=function(e){return e&&e.__esModule?e:{default:e}}(o),i={install:function(e,t){var n=Number(e.version.split(".")[0]),o=Number(e.version.split(".")[1]);if(n<2&&o<1)throw new Error("v-dragscroll supports vue version 2.1 and above. You are using Vue@"+e.version+". Please upgrade to the latest version of Vue.");e.directive("dragscroll",r.default)}};"undefined"!=typeof window&&window.Vue&&(window.VueDragscroll=i,window.Vue.use(i)),t.dragscroll=r.default,t.default=i},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=n(2),r=function(e){return e&&e.__esModule?e:{default:e}}(o),i=["mousedown","touchstart"],d=["mousemove","touchmove"],u=["mouseup","touchend"],l=function(e,t,n){var o=function(){var o=void 0,l=void 0,s=void 0,a=!1,c=!1;e.md=function(n){n.preventDefault();var r=n instanceof window.MouseEvent,i=r?n.pageX:n.touches[0].pageX,d=r?n.pageY:n.touches[0].pageY,u=document.elementFromPoint(i-window.pageXOffset,d-window.pageYOffset),a="nochilddrag"===t.arg,f="firstchilddrag"===t.arg,v=u===e,m=u===e.firstChild,p=a?void 0!==u.dataset.dragscroll:void 0===u.dataset.noDragscroll;(v||p&&(!f||m))&&(s=1,o=r?n.clientX:n.touches[0].clientX,l=r?n.clientY:n.touches[0].clientY,"touchstart"===n.type&&(c=!0))},e.mu=function(e){s=0,a&&r.default.emitEvent(n,"dragscrollend"),a=!1,"touchend"===e.type&&!0===c&&(e.target.click(),c=!1)},e.mm=function(i){var d=i instanceof window.MouseEvent,u=void 0,c=void 0,f={};if(s){a||r.default.emitEvent(n,"dragscrollstart"),a=!0;var v=e.scrollLeft+e.clientWidth>=e.scrollWidth||0===e.scrollLeft,m=e.scrollTop+e.clientHeight>=e.scrollHeight||0===e.scrollTop;u=-o+(o=d?i.clientX:i.touches[0].clientX),c=-l+(l=d?i.clientY:i.touches[0].clientY),t.modifiers.x&&(c=-0),t.modifiers.y&&(u=-0),e.scrollLeft-=u,e.scrollTop-=c,e===document.body&&(e.scrollLeft-=u,e.scrollTop-=c),t.modifiers.pass&&(v&&window.scrollBy(-u,0),m&&window.scrollBy(0,-c)),f.deltaX=-u,f.deltaY=-c,r.default.emitEvent(n,"dragscrollmove",f)}},r.default.addEventListeners(e,i,e.md),r.default.addEventListeners(window,u,e.mu),r.default.addEventListeners(window,d,e.mm)};void 0===t.value||!0===t.value?"complete"===document.readyState?o():window.addEventListener("load",o):(t.value&&console.error("The passed value should be either 'undefined', 'true' or 'false'."),r.default.removeEventListeners(e,i,e.md),r.default.removeEventListeners(window,u,e.mu),r.default.removeEventListeners(window,d,e.mm))};t.default={bind:function(e,t,n){l(e,t,n)},update:function(e,t,n,o){t.value!==t.oldValue&&l(e,t,n)},unbind:function(e,t,n){r.default.removeEventListeners(e,i,e.md),r.default.removeEventListeners(window,u,e.mu),r.default.removeEventListeners(window,d,e.mm)}}},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={addEventListeners:function(e,t,n){for(var o=0,r=t.length;o<r;o++)e.addEventListener(t[o],n)},removeEventListeners:function(e,t,n){for(var o=0,r=t.length;o<r;o++)e.removeEventListener(t[o],n)},emitEvent:function(e,t,n){if(e.componentInstance)e.componentInstance.$emit(t,n);else{var o=void 0;"function"==typeof window.CustomEvent?o=new window.CustomEvent(t,{detail:n}):(o=document.createEvent("CustomEvent"),o.initCustomEvent(t,!0,!0,n)),e.elm.dispatchEvent(o)}}}}])});
//# sourceMappingURL=vue-dragscroll.min.js.map

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(10);
module.exports = __webpack_require__(56);


/***/ }),
/* 10 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuedraggable__ = __webpack_require__(53);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vuedraggable___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vuedraggable__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_mouse_menu__ = __webpack_require__(55);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_mouse_menu___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_mouse_menu__);

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = __webpack_require__(4);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', __webpack_require__(14));
Vue.component('prueba', __webpack_require__(16));
Vue.component('floorview', __webpack_require__(7));



new Vue({
  el: '#Vue',
  components: {
    draggable: __WEBPACK_IMPORTED_MODULE_0_vuedraggable___default.a,
    mouseMenu: __WEBPACK_IMPORTED_MODULE_1_vue_mouse_menu___default.a
  }
});

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {var scope = (typeof global !== "undefined" && global) ||
            (typeof self !== "undefined" && self) ||
            window;
var apply = Function.prototype.apply;

// DOM APIs, for completeness

exports.setTimeout = function() {
  return new Timeout(apply.call(setTimeout, scope, arguments), clearTimeout);
};
exports.setInterval = function() {
  return new Timeout(apply.call(setInterval, scope, arguments), clearInterval);
};
exports.clearTimeout =
exports.clearInterval = function(timeout) {
  if (timeout) {
    timeout.close();
  }
};

function Timeout(id, clearFn) {
  this._id = id;
  this._clearFn = clearFn;
}
Timeout.prototype.unref = Timeout.prototype.ref = function() {};
Timeout.prototype.close = function() {
  this._clearFn.call(scope, this._id);
};

// Does not start the time, just sets up the members needed.
exports.enroll = function(item, msecs) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = msecs;
};

exports.unenroll = function(item) {
  clearTimeout(item._idleTimeoutId);
  item._idleTimeout = -1;
};

exports._unrefActive = exports.active = function(item) {
  clearTimeout(item._idleTimeoutId);

  var msecs = item._idleTimeout;
  if (msecs >= 0) {
    item._idleTimeoutId = setTimeout(function onTimeout() {
      if (item._onTimeout)
        item._onTimeout();
    }, msecs);
  }
};

// setimmediate attaches itself to the global object
__webpack_require__(12);
// On some exotic environments, it's not clear which object `setimmediate` was
// able to install onto.  Search each possibility in the same order as the
// `setimmediate` library.
exports.setImmediate = (typeof self !== "undefined" && self.setImmediate) ||
                       (typeof global !== "undefined" && global.setImmediate) ||
                       (this && this.setImmediate);
exports.clearImmediate = (typeof self !== "undefined" && self.clearImmediate) ||
                         (typeof global !== "undefined" && global.clearImmediate) ||
                         (this && this.clearImmediate);

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(3)))

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global, process) {(function (global, undefined) {
    "use strict";

    if (global.setImmediate) {
        return;
    }

    var nextHandle = 1; // Spec says greater than zero
    var tasksByHandle = {};
    var currentlyRunningATask = false;
    var doc = global.document;
    var registerImmediate;

    function setImmediate(callback) {
      // Callback can either be a function or a string
      if (typeof callback !== "function") {
        callback = new Function("" + callback);
      }
      // Copy function arguments
      var args = new Array(arguments.length - 1);
      for (var i = 0; i < args.length; i++) {
          args[i] = arguments[i + 1];
      }
      // Store and register the task
      var task = { callback: callback, args: args };
      tasksByHandle[nextHandle] = task;
      registerImmediate(nextHandle);
      return nextHandle++;
    }

    function clearImmediate(handle) {
        delete tasksByHandle[handle];
    }

    function run(task) {
        var callback = task.callback;
        var args = task.args;
        switch (args.length) {
        case 0:
            callback();
            break;
        case 1:
            callback(args[0]);
            break;
        case 2:
            callback(args[0], args[1]);
            break;
        case 3:
            callback(args[0], args[1], args[2]);
            break;
        default:
            callback.apply(undefined, args);
            break;
        }
    }

    function runIfPresent(handle) {
        // From the spec: "Wait until any invocations of this algorithm started before this one have completed."
        // So if we're currently running a task, we'll need to delay this invocation.
        if (currentlyRunningATask) {
            // Delay by doing a setTimeout. setImmediate was tried instead, but in Firefox 7 it generated a
            // "too much recursion" error.
            setTimeout(runIfPresent, 0, handle);
        } else {
            var task = tasksByHandle[handle];
            if (task) {
                currentlyRunningATask = true;
                try {
                    run(task);
                } finally {
                    clearImmediate(handle);
                    currentlyRunningATask = false;
                }
            }
        }
    }

    function installNextTickImplementation() {
        registerImmediate = function(handle) {
            process.nextTick(function () { runIfPresent(handle); });
        };
    }

    function canUsePostMessage() {
        // The test against `importScripts` prevents this implementation from being installed inside a web worker,
        // where `global.postMessage` means something completely different and can't be used for this purpose.
        if (global.postMessage && !global.importScripts) {
            var postMessageIsAsynchronous = true;
            var oldOnMessage = global.onmessage;
            global.onmessage = function() {
                postMessageIsAsynchronous = false;
            };
            global.postMessage("", "*");
            global.onmessage = oldOnMessage;
            return postMessageIsAsynchronous;
        }
    }

    function installPostMessageImplementation() {
        // Installs an event handler on `global` for the `message` event: see
        // * https://developer.mozilla.org/en/DOM/window.postMessage
        // * http://www.whatwg.org/specs/web-apps/current-work/multipage/comms.html#crossDocumentMessages

        var messagePrefix = "setImmediate$" + Math.random() + "$";
        var onGlobalMessage = function(event) {
            if (event.source === global &&
                typeof event.data === "string" &&
                event.data.indexOf(messagePrefix) === 0) {
                runIfPresent(+event.data.slice(messagePrefix.length));
            }
        };

        if (global.addEventListener) {
            global.addEventListener("message", onGlobalMessage, false);
        } else {
            global.attachEvent("onmessage", onGlobalMessage);
        }

        registerImmediate = function(handle) {
            global.postMessage(messagePrefix + handle, "*");
        };
    }

    function installMessageChannelImplementation() {
        var channel = new MessageChannel();
        channel.port1.onmessage = function(event) {
            var handle = event.data;
            runIfPresent(handle);
        };

        registerImmediate = function(handle) {
            channel.port2.postMessage(handle);
        };
    }

    function installReadyStateChangeImplementation() {
        var html = doc.documentElement;
        registerImmediate = function(handle) {
            // Create a <script> element; its readystatechange event will be fired asynchronously once it is inserted
            // into the document. Do so, thus queuing up the task. Remember to clean up once it's been called.
            var script = doc.createElement("script");
            script.onreadystatechange = function () {
                runIfPresent(handle);
                script.onreadystatechange = null;
                html.removeChild(script);
                script = null;
            };
            html.appendChild(script);
        };
    }

    function installSetTimeoutImplementation() {
        registerImmediate = function(handle) {
            setTimeout(runIfPresent, 0, handle);
        };
    }

    // If supported, we should attach to the prototype of global, since that is where setTimeout et al. live.
    var attachTo = Object.getPrototypeOf && Object.getPrototypeOf(global);
    attachTo = attachTo && attachTo.setTimeout ? attachTo : global;

    // Don't get fooled by e.g. browserify environments.
    if ({}.toString.call(global.process) === "[object process]") {
        // For Node.js before 0.9
        installNextTickImplementation();

    } else if (canUsePostMessage()) {
        // For non-IE10 modern browsers
        installPostMessageImplementation();

    } else if (global.MessageChannel) {
        // For web workers, where supported
        installMessageChannelImplementation();

    } else if (doc && "onreadystatechange" in doc.createElement("script")) {
        // For IE 6–8
        installReadyStateChangeImplementation();

    } else {
        // For older browsers
        installSetTimeoutImplementation();
    }

    attachTo.setImmediate = setImmediate;
    attachTo.clearImmediate = clearImmediate;
}(typeof self === "undefined" ? typeof global === "undefined" ? this : global : self));

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(3), __webpack_require__(13)))

/***/ }),
/* 13 */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = null
/* template */
var __vue_template__ = __webpack_require__(15)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/ExampleComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7168fb6a", Component.options)
  } else {
    hotAPI.reload("data-v-7168fb6a", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _vm._m(0)
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "container" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-md-8 col-md-offset-2" }, [
          _c("div", { staticClass: "panel panel-default" }, [
            _c("div", { staticClass: "panel-heading" }, [
              _vm._v("Example Component")
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "panel-body" }, [
              _vm._v(
                "\n                    I'm an example component!\n                "
              )
            ])
          ])
        ])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7168fb6a", module.exports)
  }
}

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(17)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(20)
/* template */
var __vue_template__ = __webpack_require__(52)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/prueba.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1c755c28", Component.options)
  } else {
    hotAPI.reload("data-v-1c755c28", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(18);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("1b0a2b9a", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1c755c28\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./prueba.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1c755c28\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./prueba.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.letra{\n    z-index: 4;\n}\n.title-card{\n    position: absolute;\n    left: 40px;\n    top: 40px;\n    color: white;\n}\n.card-mio{\n    cursor: pointer;\n    position:relative;\n    opacity: 0.6;\n    width: 120px;\n    height: 120px;\n}\n.card-price{\n    position: absolute;\n    left: 40px;\n    top: 42px;\n    color: white;\n    -webkit-transition: -webkit-transform .2s;\n    transition: -webkit-transform .2s;\n    transition: transform .2s;\n    transition: transform .2s, -webkit-transform .2s;\n}\n.img-card{\n    border-radius: 10px 10px 10px 10px;\n    width: 120px;\n    height: 120px;\n    -webkit-transition: -webkit-transform .2s;\n    transition: -webkit-transform .2s;\n    transition: transform .2s;\n    transition: transform .2s, -webkit-transform .2s;\n}\n.img-card:hover {\n    -webkit-transform: scale(1.5);\n            transform: scale(1.5);\n}\n.card-img-wrap {\n    -webkit-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);\n            box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);\n    border-radius: 10px 10px 10px 10px;\n    overflow: hidden;\n    position: relative;\n}\n.card-img-wrap:after {\n    -webkit-box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);\n            box-shadow: 0px 0px 6px 0px rgba(0,0,0,0.75);\n    content: '';\n    position: absolute;\n    top: 0; left: 0; right: 0; bottom: 0;\n    background: rgba(255,255,255,0.3);\n    opacity: 0;\n    -webkit-transition: opacity .25s;\n    transition: opacity .25s;\n}\n.card-img-wrap img {\n    -webkit-transition: -webkit-transform .25s;\n    transition: -webkit-transform .25s;\n    transition: transform .25s;\n    transition: transform .25s, -webkit-transform .25s;\n    width: 100%;\n}\n.card-img-wrap:hover img {\n    -webkit-transform: scale(1.2);\n            transform: scale(1.2);\n}\n.card-img-wrap:hover:after {\n    opacity: 1;\n}\n.tabs-component {\n    margin: 4em 0;\n}\n.tabs-component-tabs {\n    border: solid 1px #ddd;\n    border-radius: 6px;\n    margin-bottom: 5px;\n}\n@media (min-width: 700px) {\n.tabs-component-tabs {\n        border: 0;\n        -webkit-box-align: stretch;\n            -ms-flex-align: stretch;\n                align-items: stretch;\n        display: -webkit-box;\n        display: -ms-flexbox;\n        display: flex;\n        -webkit-box-pack: start;\n            -ms-flex-pack: start;\n                justify-content: flex-start;\n        margin-bottom: -1px;\n}\n}\n.tabs-component-tab {\n    color: #999;\n    font-size: 14px;\n    font-weight: 600;\n    margin-right: 0;\n    list-style: none;\n}\n.tabs-component-tab:not(:last-child) {\n    border-bottom: dotted 1px #ddd;\n}\n.tabs-component-tab:hover {\n    color: #666;\n}\n.tabs-component-tab.is-active {\n    color: #000;\n}\n.tabs-component-tab.is-disabled * {\n    color: #cdcdcd;\n    cursor: not-allowed !important;\n}\n@media (min-width: 700px) {\n.tabs-component-tab {\n        background-color: #fff;\n        border: solid 1px #ddd;\n        border-radius: 3px 3px 0 0;\n        margin-right: .5em;\n        -webkit-transform: translateY(2px);\n                transform: translateY(2px);\n        -webkit-transition: -webkit-transform .3s ease;\n        transition: -webkit-transform .3s ease;\n        transition: transform .3s ease;\n        transition: transform .3s ease, -webkit-transform .3s ease;\n}\n.tabs-component-tab.is-active {\n        border-bottom: solid 1px #fff;\n        z-index: 2;\n        -webkit-transform: translateY(0);\n                transform: translateY(0);\n}\n}\n.tabs-component-tab-a {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    color: inherit;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    padding: .75em 1em;\n    text-decoration: none;\n}\n.tabs-component-panels {\n    padding: 4em 0;\n}\n@media (min-width: 700px) {\n.tabs-component-panels {\n        border-top-left-radius: 0;\n        background-color: #fff;\n        border: solid 1px #ddd;\n        border-radius: 0 6px 6px 6px;\n        -webkit-box-shadow: 0 0 10px rgba(0, 0, 0, .05);\n                box-shadow: 0 0 10px rgba(0, 0, 0, .05);\n        padding: 4em 2em;\n}\n}\n\n", ""]);

// exports


/***/ }),
/* 19 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),
/* 20 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_drag_resize__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_drag_resize___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_drag_resize__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__floorview__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__floorview___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__floorview__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'prueba',
    components: {
        VueDragResize: __WEBPACK_IMPORTED_MODULE_1_vue_drag_resize___default.a,
        Tabitem: __WEBPACK_IMPORTED_MODULE_2__floorview___default.a,
        Tabs: __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__["Tabs"],
        Tab: __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__["Tab"]
    },
    data: function data() {
        return {
            editar: false,
            objetos: [{
                name: 'mesa',
                img: 'mesao.png',
                width: 100,
                height: 100
            }],
            corotos: [{
                id: 1,
                img: 'mesao.png',
                width: 100,
                height: 100,
                status: true,
                top: 0,
                left: 0
            }],
            areas: [{
                id: 1,
                name: 'principal'
            }, {
                id: 2,
                name: 'afuera'
            }]
        };
    },

    methods: {
        resize: function resize(newRect) {
            this.width = newRect.width;
            this.height = newRect.height;
            this.top = newRect.top;
            this.left = newRect.left;
        },
        nuevocoroto: function nuevocoroto(img) {
            var corot = {
                img: img,
                width: 100,
                height: 100,
                status: true,
                top: 0,
                left: 0
            };
            this.corotos.push(corot);
        }
    },
    mounted: function mounted() {}
});

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(22);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("09c423e2", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-295b482a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./floorview.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-295b482a\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./floorview.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.letra[data-v-295b482a]{\n    z-index: 4;\n}\n.title-card[data-v-295b482a]{\n    position: absolute;\n    left: 15px;\n    top: 55px;\n    color: white;\n}\n.card-mio[data-v-295b482a]{\n    cursor: pointer;\n    position:relative;\n    opacity: 1;\n    width: 120px;\n    height: 120px;\n}\n.card-price[data-v-295b482a]{\n    position: absolute;\n    left: 40px;\n    top: 42px;\n    color: white;\n    -webkit-transition: -webkit-transform .2s;\n    transition: -webkit-transform .2s;\n    transition: transform .2s;\n    transition: transform .2s, -webkit-transform .2s;\n}\n.img-card[data-v-295b482a]{\n    border-radius: 10px 10px 10px 10px;\n    width: 100px;\n    height: 100px;\n    -webkit-transition: -webkit-transform .2s;\n    transition: -webkit-transform .2s;\n    transition: transform .2s;\n    transition: transform .2s, -webkit-transform .2s;\n}\n.img-card[data-v-295b482a]:hover {\n    -webkit-transform: scale(1.5);\n            transform: scale(1.5);\n}\n.card-img-wrap[data-v-295b482a] {\n    border-radius: 10px 10px 10px 10px;\n    overflow: hidden;\n    position: relative;\n}\n.card-img-wrap[data-v-295b482a]:after {\n    content: '';\n    position: absolute;\n    top: 0; left: 0; right: 0; bottom: 0;\n    background: rgba(255,255,255,0.3);\n    opacity: 0;\n    -webkit-transition: opacity .25s;\n    transition: opacity .25s;\n}\n.card-img-wrap img[data-v-295b482a] {\n    -webkit-transition: -webkit-transform .25s;\n    transition: -webkit-transform .25s;\n    transition: transform .25s;\n    transition: transform .25s, -webkit-transform .25s;\n    width: 100%;\n}\n.card-img-wrap:hover img[data-v-295b482a] {\n    -webkit-transform: scale(1.2);\n            transform: scale(1.2);\n}\n.card-img-wrap[data-v-295b482a]:hover:after {\n    opacity: 1;\n}\n.tabs-component[data-v-295b482a] {\n    margin: 4em 0;\n}\n.tabs-component-tabs[data-v-295b482a] {\n    border: solid 1px #ddd;\n    border-radius: 6px;\n    margin-bottom: 5px;\n}\n@media (min-width: 700px) {\n.tabs-component-tabs[data-v-295b482a] {\n        border: 0;\n        -webkit-box-align: stretch;\n            -ms-flex-align: stretch;\n                align-items: stretch;\n        display: -webkit-box;\n        display: -ms-flexbox;\n        display: flex;\n        -webkit-box-pack: start;\n            -ms-flex-pack: start;\n                justify-content: flex-start;\n        margin-bottom: -1px;\n}\n}\n.tabs-component-tab[data-v-295b482a] {\n    color: #999;\n    font-size: 14px;\n    font-weight: 600;\n    margin-right: 0;\n    list-style: none;\n}\n.tabs-component-tab[data-v-295b482a]:not(:last-child) {\n    border-bottom: dotted 1px #ddd;\n}\n.tabs-component-tab[data-v-295b482a]:hover {\n    color: #666;\n}\n.tabs-component-tab.is-active[data-v-295b482a] {\n    color: #000;\n}\n.tabs-component-tab.is-disabled *[data-v-295b482a] {\n    color: #cdcdcd;\n    cursor: not-allowed !important;\n}\n@media (min-width: 700px) {\n.tabs-component-tab[data-v-295b482a] {\n        background-color: #fff;\n        border: solid 1px #ddd;\n        border-radius: 3px 3px 0 0;\n        margin-right: .5em;\n        -webkit-transform: translateY(2px);\n                transform: translateY(2px);\n        -webkit-transition: -webkit-transform .3s ease;\n        transition: -webkit-transform .3s ease;\n        transition: transform .3s ease;\n        transition: transform .3s ease, -webkit-transform .3s ease;\n}\n.tabs-component-tab.is-active[data-v-295b482a] {\n        border-bottom: solid 1px #fff;\n        z-index: 2;\n        -webkit-transform: translateY(0);\n                transform: translateY(0);\n}\n}\n.tabs-component-tab-a[data-v-295b482a] {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    color: inherit;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    padding: .75em 1em;\n    text-decoration: none;\n}\n.tabs-component-panels[data-v-295b482a] {\n    padding: 4em 0;\n}\n@media (min-width: 700px) {\n.tabs-component-panels[data-v-295b482a] {\n        border-top-left-radius: 0;\n        background-color: #fff;\n        border: solid 1px #ddd;\n        border-radius: 0 6px 6px 6px;\n        -webkit-box-shadow: 0 0 10px rgba(0, 0, 0, .05);\n                box-shadow: 0 0 10px rgba(0, 0, 0, .05);\n        padding: 4em 2em;\n}\n}\n.isTrue[data-v-295b482a]{\n    color: red;\n}\n.row-horizon[data-v-295b482a]::-webkit-scrollbar-track\n{\n    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);\n    border-radius: 10px;\n    background-color: #F5F5F5;\n}\n.row-horizon[data-v-295b482a]::-webkit-scrollbar\n{\n    height: 8px;\n    background-color: #F5F5F5;\n}\n.row-horizon[data-v-295b482a]::-webkit-scrollbar-thumb\n{\n    border-radius: 10px;\n    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);\n    background-color: #777979;\n}\n.row-horizon[data-v-295b482a] {\n    overflow-x: scroll;\n    overflow-y: hidden;\n    white-space: nowrap;\n    margin: 0 10px;\n}\n.row-horizon > [class*=\"col-lg\"][data-v-295b482a], .row-horizon > [class*=\"col-md\"][data-v-295b482a], .row-horizon > [class*=\"col-sm\"][data-v-295b482a], .row-horizon > [class*=\"col-xs\"][data-v-295b482a] {\n    float: none;\n    display: inline-block;\n    white-space: normal;\n    vertical-align: top;\n}\n.row-horizon > .col-xs-12[data-v-295b482a] {\n    width: 90%;\n}\n.row-horizon > .col-xs-11[data-v-295b482a] {\n    width: 82.5%;\n}\n.row-horizon > .col-xs-10[data-v-295b482a] {\n    width: 75%;\n}\n.row-horizon > .col-xs-9[data-v-295b482a] {\n    width: 67.5%;\n}\n.row-horizon > .col-xs-8[data-v-295b482a] {\n    width: 60%;\n}\n.row-horizon > .col-xs-7[data-v-295b482a] {\n    width: 52.5%;\n}\n.row-horizon > .col-xs-6[data-v-295b482a] {\n    width: 45%;\n}\n.row-horizon > .col-xs-5[data-v-295b482a] {\n    width: 37.5%;\n}\n.row-horizon > .col-xs-4[data-v-295b482a] {\n    width: 30%;\n}\n.row-horizon > .col-xs-3[data-v-295b482a] {\n    width: 22.5%;\n}\n.row-horizon > .col-xs-2[data-v-295b482a] {\n    width: 15%;\n}\n.row-horizon > .col-xs-1[data-v-295b482a] {\n    width: 7.5%;\n}\n@media (min-width: 768px) {\n.row-horizon > .col-sm-12[data-v-295b482a] {\n        width: 90%;\n}\n.row-horizon > .col-sm-11[data-v-295b482a] {\n        width: 82.5%;\n}\n.row-horizon > .col-sm-10[data-v-295b482a] {\n        width: 75%;\n}\n.row-horizon > .col-sm-9[data-v-295b482a] {\n        width: 67.5%;\n}\n.row-horizon > .col-sm-8[data-v-295b482a] {\n        width: 60%;\n}\n.row-horizon > .col-sm-7[data-v-295b482a] {\n        width: 52.5%;\n}\n.row-horizon > .col-sm-6[data-v-295b482a] {\n        width: 45%;\n}\n.row-horizon > .col-sm-5[data-v-295b482a] {\n        width: 37.5%;\n}\n.row-horizon > .col-sm-4[data-v-295b482a] {\n        width: 30%;\n}\n.row-horizon > .col-sm-3[data-v-295b482a] {\n        width: 22.5%;\n}\n.row-horizon > .col-sm-2[data-v-295b482a] {\n        width: 15%;\n}\n.row-horizon > .col-sm-1[data-v-295b482a] {\n        width: 7.5%;\n}\n}\n@media (min-width: 992px) {\n.row-horizon > .col-md-12[data-v-295b482a] {\n        width: 90%;\n}\n.row-horizon > .col-md-11[data-v-295b482a] {\n        width: 82.5%;\n}\n.row-horizon > .col-md-10[data-v-295b482a] {\n        width: 75%;\n}\n.row-horizon > .col-md-9[data-v-295b482a] {\n        width: 67.5%;\n}\n.row-horizon > .col-md-8[data-v-295b482a] {\n        width: 60%;\n}\n.row-horizon > .col-md-7[data-v-295b482a] {\n        width: 52.5%;\n}\n.row-horizon > .col-md-6[data-v-295b482a] {\n        width: 45%;\n}\n.row-horizon > .col-md-5[data-v-295b482a] {\n        width: 37.5%;\n}\n.row-horizon > .col-md-4[data-v-295b482a] {\n        width: 30%;\n}\n.row-horizon > .col-md-3[data-v-295b482a] {\n        width: 22.5%;\n}\n.row-horizon > .col-md-2[data-v-295b482a] {\n        width: 15%;\n}\n.row-horizon > .col-md-1[data-v-295b482a] {\n        width: 7.5%;\n}\n}\n@media (min-width: 1200px) {\n.row-horizon > .col-lg-12[data-v-295b482a] {\n        width: 90%;\n}\n.row-horizon > .col-lg-11[data-v-295b482a] {\n        width: 82.5%;\n}\n.row-horizon > .col-lg-10[data-v-295b482a] {\n        width: 75%;\n}\n.row-horizon > .col-lg-9[data-v-295b482a] {\n        width: 67.5%;\n}\n.row-horizon > .col-lg-8[data-v-295b482a] {\n        width: 60%;\n}\n.row-horizon > .col-lg-7[data-v-295b482a] {\n        width: 52.5%;\n}\n.row-horizon > .col-lg-6[data-v-295b482a] {\n        width: 45%;\n}\n.row-horizon > .col-lg-5[data-v-295b482a] {\n        width: 37.5%;\n}\n.row-horizon > .col-lg-4[data-v-295b482a] {\n        width: 30%;\n}\n.row-horizon > .col-lg-3[data-v-295b482a] {\n        width: 22.5%;\n}\n.row-horizon > .col-lg-2[data-v-295b482a] {\n        width: 15%;\n}\n.row-horizon > .col-lg-1[data-v-295b482a] {\n        width: 7.5%;\n}\n}\n.categorias[data-v-295b482a]{\n    cursor: pointer;\n    text-align:center;\n    margin:5px 0;\n    padding: 10px 20px;\n    background-color:#E2E2E2;\n    border-radius:3px;\n    color:#6B6B6B;\n    text-transform:uppercase;\n    display:inline-block;\n    font-weight:500;\n    padding-bottom: 7px;\n    border-bottom: 3px solid #6EC89B;\n}\n.selectcategories[data-v-295b482a] {\n    background-color:#6B6B6B !important;\n    color:#E2E2E2 !important;\n    border-bottom: 3px solid #f65e48 !important;\n}\n\n\n", ""]);

// exports


/***/ }),
/* 23 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_drag_resize__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_drag_resize___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_vue_drag_resize__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__itemcoroto__ = __webpack_require__(24);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__itemcoroto___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__itemcoroto__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ordenes__ = __webpack_require__(29);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__ordenes___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__ordenes__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_vue_js_modal__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_vue_js_modal___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_vue_js_modal__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_vue_draggable_resizable__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_vue_draggable_resizable___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_vue_draggable_resizable__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_vue_dragscroll__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_vue_dragscroll___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6_vue_dragscroll__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//








Vue.use(__WEBPACK_IMPORTED_MODULE_6_vue_dragscroll___default.a);
Vue.use(__WEBPACK_IMPORTED_MODULE_4_vue_js_modal___default.a);
Vue.component('vue-draggable-resizable', __WEBPACK_IMPORTED_MODULE_5_vue_draggable_resizable___default.a);

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'Tabitem',
    components: { Tabs: __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__["Tabs"], Tab: __WEBPACK_IMPORTED_MODULE_0_vue_tabs_component__["Tab"], VueDragResize: __WEBPACK_IMPORTED_MODULE_1_vue_drag_resize___default.a, ItemCoroto: __WEBPACK_IMPORTED_MODULE_2__itemcoroto___default.a, ordenes: __WEBPACK_IMPORTED_MODULE_3__ordenes___default.a, vmodal: __WEBPACK_IMPORTED_MODULE_4_vue_js_modal___default.a, VueDraggableResizable: __WEBPACK_IMPORTED_MODULE_5_vue_draggable_resizable___default.a, VueDragscroll: __WEBPACK_IMPORTED_MODULE_6_vue_dragscroll___default.a },
    data: function data() {
        return {
            mesa: 0,
            prueba: false,
            editar: false,
            width: 0,
            height: 0,
            top: 0,
            left: 0,
            x: 0,
            y: 0,
            ver: [],
            nombrearea: '',
            areaid: 0,
            dataareas: [],
            corotos: [],
            objetos: [{
                name: 'mesa',
                img: 'mesa2.png',
                width: 100,
                height: 100
            }, {
                name: 'mesa',
                img: 'mesa4.png',
                width: 100,
                height: 100
            }, {
                name: 'mesa',
                img: 'mesa6.png',
                width: 100,
                height: 100
            }, {
                name: 'mesa',
                img: 'mesa8.png',
                width: 100,
                height: 100
            }, {
                name: 'caja',
                img: 'caja2.png',
                width: 100,
                height: 100
            }, {
                name: 'pared',
                img: 'pared.png',
                width: 100,
                height: 100
            }, {
                name: 'mata',
                img: 'mata.png',
                width: 100,
                height: 100
            }, {
                name: 'puerta',
                img: 'door.png',
                width: 100,
                height: 100
            }],
            bus: new Vue(),
            invitados: 0,
            mesasocupada: []
        };
    },

    methods: {
        continuar: function continuar() {
            var _this = this;

            if (this.invitados <= 0) {
                toastr.warning('ingrese la cantidad de invitados', 'validador');
            } else {
                this.prueba = true;
                var mesa;
                for (var key in this.corotos) {
                    if (this.corotos[key].id == this.mesa) {
                        mesa = this.corotos[key];
                        this.corotos[key].status = 2;
                    }
                }
                // var mesa = {
                //     id:this.mesa,
                //     mesa:mesa,
                //     personas:this.invitados,
                //     active:true
                // };
                // this.mesasocupada.push(mesa);
                axios.post('/mesa/temp/store', {
                    id: this.mesa,
                    personas: this.invitados
                }).then(function (response) {
                    console.log(response);
                    _this.allmesastemp();
                }).catch(function (error) {
                    console.log(error);
                });
                this.$modal.hide('coroto');
                this.invitados = 0;
            }
        },
        allmesastemp: function allmesastemp() {
            var _this2 = this;

            axios.post('/mesa/temp/all').then(function (response) {
                var mesa = response.data;
                for (var key in mesa) {
                    if (mesa[key].coroto_id == _this2.mesa) {
                        var esto = {
                            id: mesa[key].coroto_id,
                            personas: mesa[key].invitados,
                            mesa: {
                                name: mesa[key].name
                            },
                            active: true
                        };
                        _this2.mesasocupada.push(esto);
                    } else {
                        var esto = {
                            id: mesa[key].coroto_id,
                            personas: mesa[key].invitados,
                            mesa: {
                                name: mesa[key].name
                            },
                            active: false
                        };
                        _this2.mesasocupada.push(esto);
                    }
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        aumentar: function aumentar(accion) {
            if (accion == 'mas') {
                this.invitados++;
                if (this.invitados > 14) {
                    this.invitados = 14;
                }
            } else {
                this.invitados = this.invitados - 1;
                if (this.invitados < 0) {
                    this.invitados = 0;
                }
            }
        },
        onResize: function onResize(x, y, width, height) {
            this.x = x;
            this.y = y;
            this.width = width;
            this.height = height;
        },
        onDrag: function onDrag(x, y) {
            this.x = x;
            this.y = y;
        },
        modalcoroto: function modalcoroto(index) {
            this.mesa = this.corotos[index].id;
            if (this.mesasocupada.length >= 1) {
                for (var key in this.mesasocupada) {
                    if (this.mesasocupada[key].id === this.corotos[index].id) {
                        this.prueba = true;
                        break;
                    } else {
                        this.$modal.show('coroto');
                        break;
                    }
                }
            } else {
                this.mesa = this.corotos[index].id;
                this.$modal.show('coroto');
            }
        },
        corotosporarea: function corotosporarea(id) {
            this.areaid = id;
            this.datoscorotos();
        },
        allareas: function allareas() {
            var _this3 = this;

            axios.post('/all/area', {
                nombre: this.nombrearea
            }).then(function (response) {
                console.log(response);
                for (var key in response.data) {
                    var data = {
                        id: response.data[key].id,
                        nombre: response.data[key].nombre,
                        user_id: response.data[key].user_id,
                        active: false
                    };
                    _this3.dataareas.push(data);
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        savearea: function savearea() {
            var _this4 = this;

            axios.post('/save/area', {
                nombre: this.nombrearea
            }).then(function (response) {
                console.log(response);
                toastr.success('Datos Guardados', 'Validador');
                _this4.nombrearea = '';
                _this4.allareas();
            }).catch(function (error) {
                console.log(error);
            });
        },
        openmodal: function openmodal() {
            this.$modal.show('crear');
        },
        prueba1: function prueba1() {
            this.prueba = true;
        },
        prueba2: function prueba2() {
            this.prueba = false;
        },
        organizarmesas: function organizarmesas() {
            var count = 0;
            for (var key in this.corotos) {
                if (this.corotos[key].name == 'mesa') {
                    count++;
                    this.corotos[key].numero = count;
                }
            }
        },
        editar1: function editar1() {
            this.editar = true;
        },
        editar2: function editar2() {
            this.editar = false;
            this.salvar();
        },
        resize: function resize(newRect) {
            this.width = newRect.width;
            this.height = newRect.height;
            this.top = newRect.top;
            this.left = newRect.left;
        },
        nuevocoroto: function nuevocoroto(img, nombre) {
            if (this.areaid == 0) {
                toastr.warning('Por favor Seleccionar un Area o sino Cree un Area', 'Validador');
            } else {
                var count = 1;
                for (var key in this.corotos) {
                    if (nombre == 'mesa') {
                        count++;
                    }
                }
                if (nombre == 'mesa') {
                    var corot = {
                        id: 0,
                        name: 'M' + count,
                        numero: count,
                        img: img,
                        width: 150,
                        height: 150,
                        status: true,
                        top: 0,
                        left: 0
                    };
                    this.corotos.push(corot);
                } else if (nombre == 'pared') {
                    var corot = {
                        id: 0,
                        name: nombre,
                        numero: count,
                        img: img,
                        width: 250,
                        height: 100,
                        status: true,
                        top: 0,
                        left: 0
                    };
                    this.corotos.push(corot);
                } else {
                    var corot = {
                        id: 0,
                        name: nombre,
                        numero: '',
                        img: img,
                        width: 150,
                        height: 150,
                        status: true,
                        top: 0,
                        left: 0
                    };
                    this.corotos.push(corot);
                }
            }
        },
        eliminarcoroto: function eliminarcoroto(i) {
            var _this5 = this;

            console.log(i);
            this.corotos.splice(i.index, 1);
            axios.post('/delete/coroto', {
                id: i.id
            }).then(function (response) {
                console.log(response);
                _this5.datoscorotos();
            }).catch(function (error) {
                console.log(error);
            });
        },
        datoscoroto: function datoscoroto(i) {
            i.top = this.y;
            i.left = this.x;
            i.width = this.width;
            i.height = this.height;
        },
        salvar: function salvar() {
            var _this6 = this;

            this.editar = false;
            axios.post('/save/edit/corotos', {
                corotos: this.corotos,
                area: this.areaid
            }).then(function (response) {
                console.log(response);
                toastr.success('Datos Guardado', 'Validado');
                _this6.corotosporarea(_this6.areaid);
            }).catch(function (error) {
                console.log(error);
            });
        },
        datoscorotos: function datoscorotos() {
            var _this7 = this;

            for (var key in this.dataareas) {
                if (this.dataareas[key].active == true) {
                    this.dataareas[key].active = false;
                }
                if (this.dataareas[key].id == this.areaid) {
                    this.dataareas[key].active = true;
                }
            }
            axios.post('/corotos/all', {
                area: this.areaid
            }).then(function (response) {
                console.log(response.data);
                if (response.data == "['No Data']") {
                    toastr.warning('No hemos encontrado datos');
                    _this7.corotos = [];
                } else {
                    toastr.success('', 'Gestor de datos');
                    _this7.corotos = response.data;
                }
            }).catch(function (error) {
                console.log(error);
                toastr.error('Se ha producido un error');
            });
        }
    },
    mounted: function mounted() {
        // this.datoscorotos();
        this.allareas();
    }
});

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(25)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(27)
/* template */
var __vue_template__ = __webpack_require__(28)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/itemcoroto.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-05d332e4", Component.options)
  } else {
    hotAPI.reload("data-v-05d332e4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(26);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("0743f15d", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-05d332e4\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./itemcoroto.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-05d332e4\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./itemcoroto.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),
/* 27 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'ItemCoroto',
    props: ['index', 'id', 'name', 'numero', 'img', 'status', 'w', 'h', 'y', 'x', 'editar', 'area'],
    components: {},
    data: function data() {
        return {
            editari: false
        };
    },

    methods: {
        eliminarcoroto: function eliminarcoroto(i) {
            this.$emit('eliminarcoroto', {
                index: this.index,
                id: this.id
            });
        }
    },
    computed: {},
    mounted: function mounted() {}
});

/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c(
      "div",
      [
        _c("img", {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.name != "pared",
              expression: "name != 'pared'"
            }
          ],
          attrs: {
            src: "../../../../local/" + _vm.img,
            width: _vm.w,
            height: _vm.h,
            alt: ""
          }
        }),
        _vm._v(" "),
        _vm.name != "caja" &&
        _vm.name != "pared" &&
        _vm.name != "mata" &&
        _vm.name != "puerta"
          ? [
              _vm.numero != 0
                ? [
                    _c(
                      "div",
                      {
                        staticStyle: {
                          position: "absolute",
                          left: "0",
                          top: "0"
                        }
                      },
                      [
                        _vm.status == 1
                          ? _c(
                              "h3",
                              {
                                staticStyle: { color: "#4cd137" },
                                on: {
                                  dblclick: function($event) {
                                    _vm.editari = true
                                  }
                                }
                              },
                              [_vm._v(_vm._s(_vm.name))]
                            )
                          : _vm.status == 2
                          ? _c(
                              "h3",
                              {
                                staticStyle: { color: "orange" },
                                on: {
                                  dblclick: function($event) {
                                    _vm.editari = true
                                  }
                                }
                              },
                              [_vm._v(_vm._s(_vm.name))]
                            )
                          : _c("h3", { staticStyle: { color: "red" } }, [
                              _vm._v(_vm._s(_vm.name))
                            ]),
                        _vm._v(" "),
                        _c(
                          "h3",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: _vm.editari == true,
                                expression: "editari== true"
                              }
                            ],
                            staticStyle: { color: "#4cd137" },
                            on: {
                              keypress: function($event) {
                                if (
                                  !("button" in $event) &&
                                  _vm._k(
                                    $event.keyCode,
                                    "enter",
                                    13,
                                    $event.key,
                                    "Enter"
                                  )
                                ) {
                                  return null
                                }
                                _vm.editari = false
                              }
                            }
                          },
                          [
                            _c("input", {
                              directives: [
                                {
                                  name: "model",
                                  rawName: "v-model",
                                  value: _vm.name,
                                  expression: "name"
                                }
                              ],
                              staticClass: "form-control form-control-sm",
                              staticStyle: {
                                width: "100px",
                                background: "transparent"
                              },
                              attrs: { type: "text", name: "", id: "" },
                              domProps: { value: _vm.name },
                              on: {
                                input: function($event) {
                                  if ($event.target.composing) {
                                    return
                                  }
                                  _vm.name = $event.target.value
                                }
                              }
                            })
                          ]
                        )
                      ]
                    )
                  ]
                : _vm._e()
            ]
          : _vm._e(),
        _vm._v(" "),
        _vm.name == "pared"
          ? [
              _c("div", {
                staticStyle: {
                  background: "grey",
                  "box-shadow": "0px 0px 5px 0px rgba(0,0,0,0.75)"
                },
                style: { height: _vm.h + "px", width: _vm.w + "px" }
              })
            ]
          : _vm._e()
      ],
      2
    ),
    _vm._v(" "),
    _c(
      "h3",
      {
        directives: [
          {
            name: "show",
            rawName: "v-show",
            value: _vm.editar === true,
            expression: "editar === true"
          }
        ],
        staticStyle: {
          position: "absolute",
          right: "2px",
          top: "0px",
          color: "orange",
          cursor: "pointer"
        },
        on: {
          click: function($event) {
            _vm.eliminarcoroto(_vm.index)
          }
        }
      },
      [_vm._v("×")]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-05d332e4", module.exports)
  }
}

/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(30)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(32)
/* template */
var __vue_template__ = __webpack_require__(48)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/ordenes.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ebe03c9e", Component.options)
  } else {
    hotAPI.reload("data-v-ebe03c9e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(31);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("3571488a", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ebe03c9e\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ordenes.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-ebe03c9e\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./ordenes.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.selectcategories {\n    background-color:#6B6B6B !important;\n    color:#E2E2E2 !important;\n    border-bottom: 3px solid #f65e48 !important;\n}\n.categorias{\n    cursor: pointer;\n    text-align:center;\n    margin:5px 0;\n    padding: 10px 20px;\n    background-color:#E2E2E2;\n    border-radius:3px;\n    color:#6B6B6B;\n    text-transform:uppercase;\n    display:inline-block;\n    font-weight:500;\n    padding-bottom: 7px;\n    border-bottom: 3px solid #6EC89B;\n}\n.letra{\n    z-index: 4;\n}\n.title-card{\n    position: absolute;\n    left: 4px;\n    top: 0px;\n    color: #212121;\n}\n.card-mio{\n    cursor: pointer;\n    position:relative;\n    opacity: 1;\n    width: 103px;\n    height: 122px;\n}\n.card-price{\n    position: absolute;\n    left: 30px;\n    top: 84px;\n    color: #212121;\n    -webkit-transition: -webkit-transform .2s;\n    transition: -webkit-transform .2s;\n    transition: transform .2s;\n    transition: transform .2s, -webkit-transform .2s;\n}\n.img-card{\n    border-radius: 10px 10px 10px 10px;\n    width: 100px;\n    height: 100px;\n    -webkit-transition: -webkit-transform .2s;\n    transition: -webkit-transform .2s;\n    transition: transform .2s;\n    transition: transform .2s, -webkit-transform .2s;\n}\n.img-card:hover {\n    -webkit-transform: scale(1.5);\n            transform: scale(1.5);\n}\n.card-img-wrap {\n    border-radius: 10px 10px 10px 10px;\n    overflow: hidden;\n    position: relative;\n    opacity: 0.5;\n}\n.card-img-wrap:after {\n    content: '';\n    position: absolute;\n    top: 0; left: 0; right: 0; bottom: 0;\n    background: rgba(255,255,255,0.3);\n    opacity: 0;\n    -webkit-transition: opacity .25s;\n    transition: opacity .25s;\n}\n.card-img-wrap img {\n    -webkit-transition: -webkit-transform .25s;\n    transition: -webkit-transform .25s;\n    transition: transform .25s;\n    transition: transform .25s, -webkit-transform .25s;\n    width: 100%;\n}\n.card-img-wrap:hover img {\n    -webkit-transform: scale(1.2);\n            transform: scale(1.2);\n}\n.card-img-wrap:hover:after {\n    opacity: 1;\n}\n/*================================================================*/\n.row-horizon::-webkit-scrollbar-track\n{\n    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);\n    border-radius: 10px;\n    background-color: #F5F5F5;\n}\n.row-horizon::-webkit-scrollbar\n{\n    height: 8px;\n    background-color: #F5F5F5;\n}\n.row-horizon::-webkit-scrollbar-thumb\n{\n    border-radius: 10px;\n    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);\n    background-color: #777979;\n}\n.row-horizon {\n    overflow-x: scroll !important;\n    overflow-y: hidden !important;\n    white-space: nowrap !important;\n    margin: 0 10px !important;\n}\n.row-horizon > [class*=\"col-lg\"], .row-horizon > [class*=\"col-md\"], .row-horizon > [class*=\"col-sm\"], .row-horizon > [class*=\"col-xs\"] {\n    float: none;\n    display: inline-block;\n    white-space: normal;\n    vertical-align: top;\n}\n.row-horizon > .col-xs-12 {\n    width: 90%;\n}\n.row-horizon > .col-xs-11 {\n    width: 82.5%;\n}\n.row-horizon > .col-xs-10 {\n    width: 75%;\n}\n.row-horizon > .col-xs-9 {\n    width: 67.5%;\n}\n.row-horizon > .col-xs-8 {\n    width: 60%;\n}\n.row-horizon > .col-xs-7 {\n    width: 52.5%;\n}\n.row-horizon > .col-xs-6 {\n    width: 45%;\n}\n.row-horizon > .col-xs-5 {\n    width: 37.5%;\n}\n.row-horizon > .col-xs-4 {\n    width: 30%;\n}\n.row-horizon > .col-xs-3 {\n    width: 22.5%;\n}\n.row-horizon > .col-xs-2 {\n    width: 15%;\n}\n.row-horizon > .col-xs-1 {\n    width: 7.5%;\n}\n@media (min-width: 768px) {\n.row-horizon > .col-sm-12 {\n        width: 90%;\n}\n.row-horizon > .col-sm-11 {\n        width: 82.5%;\n}\n.row-horizon > .col-sm-10 {\n        width: 75%;\n}\n.row-horizon > .col-sm-9 {\n        width: 67.5%;\n}\n.row-horizon > .col-sm-8 {\n        width: 60%;\n}\n.row-horizon > .col-sm-7 {\n        width: 52.5%;\n}\n.row-horizon > .col-sm-6 {\n        width: 45%;\n}\n.row-horizon > .col-sm-5 {\n        width: 37.5%;\n}\n.row-horizon > .col-sm-4 {\n        width: 30%;\n}\n.row-horizon > .col-sm-3 {\n        width: 22.5%;\n}\n.row-horizon > .col-sm-2 {\n        width: 15%;\n}\n.row-horizon > .col-sm-1 {\n        width: 7.5%;\n}\n}\n@media (min-width: 992px) {\n.row-horizon > .col-md-12 {\n        width: 90%;\n}\n.row-horizon > .col-md-11 {\n        width: 82.5%;\n}\n.row-horizon > .col-md-10 {\n        width: 75%;\n}\n.row-horizon > .col-md-9 {\n        width: 67.5%;\n}\n.row-horizon > .col-md-8 {\n        width: 60%;\n}\n.row-horizon > .col-md-7 {\n        width: 52.5%;\n}\n.row-horizon > .col-md-6 {\n        width: 45%;\n}\n.row-horizon > .col-md-5 {\n        width: 37.5%;\n}\n.row-horizon > .col-md-4 {\n        width: 30%;\n}\n.row-horizon > .col-md-3 {\n        width: 22.5%;\n}\n.row-horizon > .col-md-2 {\n        width: 15%;\n}\n.row-horizon > .col-md-1 {\n        width: 7.5%;\n}\n}\n@media (min-width: 1200px) {\n.row-horizon > .col-lg-12 {\n        width: 90%;\n}\n.row-horizon > .col-lg-11 {\n        width: 82.5%;\n}\n.row-horizon > .col-lg-10 {\n        width: 75%;\n}\n.row-horizon > .col-lg-9 {\n        width: 67.5%;\n}\n.row-horizon > .col-lg-8 {\n        width: 60%;\n}\n.row-horizon > .col-lg-7 {\n        width: 52.5%;\n}\n.row-horizon > .col-lg-6 {\n        width: 45%;\n}\n.row-horizon > .col-lg-5 {\n        width: 37.5%;\n}\n.row-horizon > .col-lg-4 {\n        width: 30%;\n}\n.row-horizon > .col-lg-3 {\n        width: 22.5%;\n}\n.row-horizon > .col-lg-2 {\n        width: 15%;\n}\n.row-horizon > .col-lg-1 {\n        width: 7.5%;\n}\n}\n\n", ""]);

// exports


/***/ }),
/* 32 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__cardproduct__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__cardproduct___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__cardproduct__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__carrito__ = __webpack_require__(38);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__carrito___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__carrito__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_dragscroll__ = __webpack_require__(8);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_vue_dragscroll___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_vue_dragscroll__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




Vue.use(__WEBPACK_IMPORTED_MODULE_2_vue_dragscroll___default.a);
/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'ordenes',
    components: { cardproduct: __WEBPACK_IMPORTED_MODULE_0__cardproduct___default.a, carrito: __WEBPACK_IMPORTED_MODULE_1__carrito___default.a, VueDragscroll: __WEBPACK_IMPORTED_MODULE_2_vue_dragscroll___default.a },
    props: ['mesasocupada', 'mesa'],
    data: function data() {
        return {
            mesasocupadasv2: this.mesasocupada,
            default1: false,
            mesav1: this.mesa,
            categorias: [],
            productos: [],
            buscador: '',
            categoriaselect: {
                'background-color': '#6B6B6B !important',
                'color': '#E2E2E2 !important',
                'border-bottom': '3px solid #f65e48 !important'
            },
            productoselecionado: [],
            bus: new Vue(),
            detalle: [],
            product: ''
        };
    },

    methods: {
        productopormesa: function productopormesa(i) {
            var _this = this;

            for (var key in this.mesasocupadasv2) {
                if (this.mesasocupadasv2[key].active == true) {
                    this.mesasocupadasv2[key].active = false;
                }
            }
            this.mesasocupadasv2[i.index].active = true;
            this.productoselecionado = [];
            axios.post('/buscar/orden/x/mesa', {
                id: i.id
            }).then(function (response) {
                _this.mesav1 = i.id;
                _this.detalle = response['data'];
                for (var key in _this.detalle['detalle']) {
                    for (var o in _this.productos) {
                        if (_this.productos[o].id == _this.detalle['detalle'][key]['product_id']) {
                            var esto = {
                                id: _this.detalle['detalle'][key]['id'],
                                orden: _this.detalle['orden'][0],
                                index: 0,
                                cantidad: _this.detalle['detalle'][key]['cantidad'],
                                mesa: _this.mesav1,
                                total: parseFloat(parseFloat(_this.detalle['detalle'][key]['cantidad']) * parseFloat(_this.productos[o].price)).toFixed(2),
                                producto: _this.productos[o]
                            };
                            _this.productoselecionado.push(esto);
                            break;
                        }
                    }
                }
            }).catch(function (error) {
                console.log(error);
            });
        },
        cambiarcantidad: function cambiarcantidad(i) {
            console.log(i);
            if (i.obt.cantidad === 0) {
                this.productoselecionado.splice(i.obt.index, 1);
                if (this.productoselecionado[i.obt.index]['id'] != 0) {
                    axios.post('/producto/orden/eliminar', {
                        producto: this.productoselecionado[i.obt.index],
                        orden: this.productoselecionado[i.obt.index]['orden']['id'],
                        subtotal: i.subtotal
                    }).then(function (response) {
                        console.log(response);
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            } else {
                this.productoselecionado[i.obt.index].total = parseFloat(this.productoselecionado[i.obt.index].producto.price * i.obt.cantidad).toFixed(2);
                this.productoselecionado[i.obt.index].cantidad = i.obt.cantidad;

                if (this.productoselecionado[i.obt.index]['id'] != 0) {
                    axios.post('/producto/orden/cambiar/cantidad', {
                        producto: this.productoselecionado[i.obt.index],
                        orden: this.productoselecionado[i.obt.index]['orden']['id'],
                        subtotal: i.subtotal
                    }).then(function (response) {
                        console.log(response);
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            }
        },
        productoselect: function productoselect(i) {
            function buscar(prod) {
                return prod.producto.id == i.producto.id;
            }
            if (this.productoselecionado.length === 0) {
                this.productoselecionado.push(i);
            } else {
                if (this.productoselecionado.find(buscar)) {
                    var cont = parseInt(this.productoselecionado.find(buscar).cantidad) + 1;
                    var precio = cont * i.producto.price;
                    this.productoselecionado.map(function (data) {
                        if (data.producto.id === i.producto.id) {
                            data.cantidad = cont;
                            data.total = parseFloat(precio).toFixed(2);
                        }
                        return data;
                    });
                } else {
                    this.productoselecionado.push(i);
                }
            }
        },
        allcategorias: function allcategorias() {
            var _this2 = this;

            axios.post('/all/categories').then(function (response) {
                for (var key in response.data) {
                    var datos = {
                        id: response.data[key].id,
                        nombre: response.data[key].nombre,
                        codigo: response.data[key].codigo,
                        img: response.data[key].img,
                        user_id: response.data[key].user_id,
                        activo: false
                    };
                    _this2.categorias.push(datos);
                }
                _this2.default1 = true;
            }).catch(function (error) {
                console.log(error);
            });
        },
        allproduct: function allproduct() {
            var _this3 = this;

            axios.post('/all/productos').then(function (response) {
                _this3.productos = response.data;
                console.log(response);
            }).catch(function (error) {
                console.log(error);
            });
        },
        volverpantalla: function volverpantalla() {
            this.$emit('prueba', {
                prueba: false
            });
        },
        productocategoria: function productocategoria(id) {
            var _this4 = this;

            for (var key in this.categorias) {
                if (this.categorias[key].id != id) {
                    this.categorias[key].active = false;
                    this.default1 = false;
                }
                if (this.categorias[key].id == id) {
                    this.categorias[key].active = true;
                    this.default1 = false;
                }
            }
            if (id == 0) {
                this.default1 = true;
            }
            axios.post('/productos/categoria/ordenes', {
                id: id
            }).then(function (response) {
                _this4.productos = response.data;
                console.log(response);
            }).catch(function (error) {
                console.log(error);
            });
        },
        buscadorp: function buscadorp() {
            var _this5 = this;

            axios.post('/buscar/producto/ordenes', {
                producto: this.buscador
            }).then(function (response) {
                _this5.productos = response.data;
                console.log(response);
            }).catch(function (error) {
                console.log(error);
            });
        },
        bajarscroll: function bajarscroll() {
            this.bus.$emit('bajar');
        }
    },
    computed: {},
    mounted: function mounted() {
        this.allcategorias();
        this.allproduct();
    }
});

/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(34)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(36)
/* template */
var __vue_template__ = __webpack_require__(37)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/cardproduct.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-08ad17d0", Component.options)
  } else {
    hotAPI.reload("data-v-08ad17d0", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 34 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(35);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("0c205e14", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-08ad17d0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./cardproduct.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-08ad17d0\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./cardproduct.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 35 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),
/* 36 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'cardproduct',
    props: ['producto', 'index', 'id', 'mesa', 'detalle'],
    components: {},
    data: function data() {
        return {
            bus: new Vue()
        };
    },

    methods: {
        productoselect: function productoselect() {
            if (this.detalle.length == 0) {
                this.$emit('productoagregar', {
                    index: this.index,
                    id: 0,
                    orden: {},
                    producto: this.producto,
                    mesa: this.mesa,
                    cantidad: 1,
                    total: parseFloat(this.producto.price).toFixed(2)
                });
                this.$emit('bajarscroll');
            } else {
                this.$emit('productoagregar', {
                    index: this.index,
                    id: 0,
                    orden: this.detalle['orden'][0],
                    producto: this.producto,
                    mesa: this.mesa,
                    cantidad: 1,
                    total: parseFloat(this.producto.price).toFixed(2)
                });
                this.$emit('bajarscroll');
            }
        }
    },
    mounted: function mounted() {}
});

/***/ }),
/* 37 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-md-2" }, [
    _c(
      "div",
      {
        staticClass: "card-mio",
        on: {
          click: function($event) {
            _vm.productoselect()
          }
        }
      },
      [
        _c("p", { staticClass: "title-card letra" }, [
          _vm._v(_vm._s(_vm.producto.name))
        ]),
        _vm._v(" "),
        _c("h6", { staticClass: "card-price letra" }, [
          _vm._v("$" + _vm._s(_vm.producto.price) + ".00")
        ]),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "card-img-wrap",
            staticStyle: { "box-shadow": "0px 0px 6px 0px rgba(0,0,0,0.75)" }
          },
          [
            _c("img", {
              staticClass: "img-card",
              attrs: {
                src: "../../../../imagenes/" + _vm.producto.img,
                alt: ""
              }
            })
          ]
        )
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-08ad17d0", module.exports)
  }
}

/***/ }),
/* 38 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(39)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(41)
/* template */
var __vue_template__ = __webpack_require__(47)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/carrito.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6cf4fc02", Component.options)
  } else {
    hotAPI.reload("data-v-6cf4fc02", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(40);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("4d86fd11", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6cf4fc02\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./carrito.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6cf4fc02\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./carrito.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.table-header h3{\n    font-weight: 700;\n    font-size: 1.1em;\n    margin: 20px 0;\n    text-align: center;\n    text-transform: uppercase;\n}\n.product-details {\n    border: none !important;\n    margin-bottom: 3px !important;\n    color: #81909a !important;\n}\n.nopadding {\n    padding: 0 !important;\n    margin: 0 !important;\n}\n.panel{\n    margin-bottom:20px;\n    background-color:#fff;\n    border:1px solid transparent;\n    border-radius:4px;\n    -webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);\n    box-shadow:0 1px 1px rgba(0,0,0,.05);\n}\n.panel-default {\n    border-color: #ddd;\n}\n.panel-body {\n    padding: 15px;\n}\n.product-details{\n    border: none;\n    margin-bottom: 3px;\n    color: #81909a;\n}\n.product-details input[type=\"text\"]{\n    width: 2.1em;\n    padding: 3px;\n    display: inline;\n    text-align: center;\n    height: 1.8em;\n}\n.delete-product{\n    color: #f65e48;\n    margin-top: 1px;\n}\n.textPD{\n    margin-top: 5px;\n    float: left;\n}\n.subtotal{\n    float: right;\n}\n.Hold {\n    cursor: pointer;\n    text-align: center;\n    margin: 5px 1px;\n    padding: 2px 13px;\n    background-color: #E2E2E2;\n    border-radius: 3px;\n    color: #6B6B6B;\n    text-transform: uppercase;\n    font-size: 20px;\n    display: inline-block;\n    font-weight: 600;\n    padding-bottom: 7px;\n    border-bottom: 3px solid #6EC89B;\n}\n.total-input {\n    border: none;\n    outline: none;\n}\n.whiteBg {\n    background-color: #fff;\n}\n.text-bold {\n    font-weight: 700;\n}\n.light-blue {\n    color: #1abc9c;\n}\n.messageVide {\n    font-size: 30px;\n    width: 100%;\n    background-color: white;\n    padding: 1.5em 0;\n    border-radius: 5px;\n    font-weight: lighter;\n    display: inline-block;\n    text-align: center;\n}\n\n", ""]);

// exports


/***/ }),
/* 41 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__itemcarrito__ = __webpack_require__(42);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__itemcarrito___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__itemcarrito__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'carrito',
    props: ['mesasocupadas', 'mesa', 'productoselecionado', 'bus', 'detalle'],
    components: { itemcarrito: __WEBPACK_IMPORTED_MODULE_0__itemcarrito___default.a },
    data: function data() {
        return {
            invitadott: 0,
            invitadoturno: 1,
            mesav1: this.mesa,
            productos: [],
            productoselecionadov2: this.productoselecionado,
            mesasocupadasv2: this.mesasocupadas
        };
    },

    methods: {
        buscarordenmesa: function buscarordenmesa(i, index) {
            this.$emit('productopormesa', {
                index: index,
                id: i
            });
        },
        cambiarcantidad: function cambiarcantidad(i) {
            this.$emit('cambiarcantidad', { obt: i, subtotal: this.subtotal });
        },
        bajarscroll: function bajarscroll() {
            $("#listacarrito").animate({ scrollTop: $('#listacarrito').prop("scrollHeight") }, 420);
        },
        ordenar: function ordenar() {
            var _this = this;

            if (this.subtotal != 0) {
                axios.post('/ordenar/mesa/store', {
                    productos: this.productoselecionado,
                    mesa: this.mesa,
                    invitados: this.invitadott,
                    subtotal: this.subtotal
                }).then(function (response) {
                    toastr.success('La orden se ha realizado', 'Validador');
                    _this.$emit('volverpant');
                }).catch(function (error) {
                    console.log(error);
                });
            } else {
                toastr.warning('Por Favor Seleccionar los productos', 'Validador');
            }
        }
    },
    computed: {
        cantidaditems: function cantidaditems() {
            return this.productoselecionado.length;
        },
        subtotal: function subtotal() {
            var suma = 0;
            for (var key in this.productoselecionado) {
                suma = parseFloat(parseFloat(suma) + parseFloat(this.productoselecionado[key].total));
            }
            return parseFloat(suma).toFixed(2);
        },
        invitado: function invitado() {
            for (var key in this.mesasocupadasv2) {

                if (this.mesasocupadasv2[key].id == this.mesav1) {
                    this.invitadott = this.mesasocupadasv2[key].personas;
                }
            }
            return this.invitadott;
        }
    },
    watch: {},
    mounted: function mounted() {

        this.bus.$on('bajar', this.bajarscroll);
    }
});

/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(43)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(45)
/* template */
var __vue_template__ = __webpack_require__(46)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/itemcarrito.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-476cb48c", Component.options)
  } else {
    hotAPI.reload("data-v-476cb48c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(44);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("d53a4b38", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-476cb48c\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./itemcarrito.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-476cb48c\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./itemcarrito.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),
/* 45 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'itemcarrito',
    props: ['productoselecionado', 'index'],
    methods: {
        masomenos: function masomenos(accion) {
            if (this.productoselecionado.cantidad == '') {
                accion = 'eliminar';
            }

            if (accion == 'mas') {
                this.productoselecionado.cantidad = parseFloat(this.productoselecionado.cantidad) + 1;
            } else if (accion == 'eliminar') {
                this.productoselecionado.cantidad = 0;
            } else if (accion == 'menos') {
                this.productoselecionado.cantidad = parseFloat(this.productoselecionado.cantidad) - 1;
            }
            this.$emit('cambiarcantidad', { cantidad: this.productoselecionado.cantidad, index: this.index });
        }
    },
    computed: {}
});

/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      staticClass: "panel panel-default product-details",
      staticStyle: { "margin-top": "10px" }
    },
    [
      _c("div", { staticClass: "panel-body" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-5" }, [
            _c("div", { staticClass: "row" }, [
              _c("div", { staticClass: "col-md-2" }, [
                _c(
                  "span",
                  {
                    staticClass: "badge badge-danger",
                    staticStyle: {
                      "border-radius": "50px",
                      "margin-left": "-6px",
                      cursor: "pointer"
                    },
                    on: {
                      click: function($event) {
                        _vm.masomenos("eliminar")
                      }
                    }
                  },
                  [_c("i", { staticClass: "fas fa-times" })]
                )
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-md-10 nopadding" }, [
                _c("span", { staticClass: "textPD" }, [
                  _vm._v(_vm._s(_vm.productoselecionado.producto.name))
                ])
              ])
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2 nopadding" }, [
            _c("div", { staticClass: "text-center" }, [
              _c(
                "span",
                {
                  staticClass: "textPD",
                  staticStyle: { "margin-left": "8px" }
                },
                [
                  _vm._v(
                    _vm._s(
                      parseFloat(
                        _vm.productoselecionado.producto.price
                      ).toFixed(2)
                    )
                  )
                ]
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-3 nopadding" }, [
            _c(
              "div",
              { staticClass: "row", staticStyle: { "margin-left": "10px" } },
              [
                _c(
                  "div",
                  {
                    staticClass: "nopadding",
                    staticStyle: { cursor: "pointer" },
                    on: {
                      click: function($event) {
                        _vm.masomenos("menos")
                      }
                    }
                  },
                  [_vm._m(0)]
                ),
                _vm._v(" "),
                _c("div", { staticClass: "nopadding" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.productoselecionado.cantidad,
                        expression: "productoselecionado.cantidad"
                      }
                    ],
                    staticClass: "form-control form-control-sm",
                    staticStyle: { width: "30px" },
                    attrs: { type: "text", value: "0" },
                    domProps: { value: _vm.productoselecionado.cantidad },
                    on: {
                      blur: _vm.masomenos,
                      input: [
                        function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.$set(
                            _vm.productoselecionado,
                            "cantidad",
                            $event.target.value
                          )
                        },
                        function($event) {
                          if ($event.target !== $event.currentTarget) {
                            return null
                          }
                          return _vm.masomenos($event)
                        }
                      ]
                    }
                  })
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "nopadding",
                    staticStyle: { cursor: "pointer" },
                    on: {
                      click: function($event) {
                        _vm.masomenos("mas")
                      }
                    }
                  },
                  [_vm._m(1)]
                )
              ]
            )
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-2 nopadding" }, [
            _c(
              "span",
              {
                staticClass: "subtotal textPD",
                staticStyle: { "margin-right": "37px" }
              },
              [_vm._v(_vm._s(_vm.productoselecionado.total))]
            )
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "badge badge-pill badge-secondary" }, [
      _c("i", { staticClass: "fas fa-minus" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "badge badge-pill badge-secondary" }, [
      _c("i", { staticClass: "fas fa-plus" })
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-476cb48c", module.exports)
  }
}

/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("div", { staticClass: "col-md-12" }, [
      _c(
        "div",
        { staticClass: "row-horizon" },
        [
          _vm._l(_vm.mesasocupadasv2, function(item, index) {
            return [
              _c(
                "span",
                {
                  staticClass: "categorias",
                  class: { selectcategories: item.active },
                  staticStyle: { "margin-left": "2px", cursor: "pointer" },
                  on: {
                    click: function($event) {
                      _vm.buscarordenmesa(item.id, index)
                    }
                  }
                },
                [_vm._v(_vm._s(item.mesa.name))]
              )
            ]
          })
        ],
        2
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "col-md-12", staticStyle: { "margin-top": "10px" } },
      [
        _c("div", { staticClass: "container" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-12" }, [
              _vm._m(0),
              _vm._v(" "),
              _c("div", { staticClass: "pull-right" }, [
                _c("div", { staticClass: "row" }, [
                  _c("div", { staticClass: "col" }),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-" }, [
                    _c("div", { staticClass: "text-center" }, [
                      _c("div", { staticClass: "row" }, [
                        _vm._m(1),
                        _vm._v(" "),
                        _c("div", { staticClass: "col" }, [
                          _c("h3", { staticStyle: { float: "right" } }, [
                            _vm._v(_vm._s(_vm.invitado))
                          ])
                        ])
                      ])
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col" })
                ])
              ])
            ]),
            _vm._v(" "),
            _vm._m(2),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "col-md-12",
                staticStyle: {
                  height: "530px",
                  "overflow-y": "auto",
                  background: "url('../../../../local/fondo6.png')"
                },
                attrs: { id: "listacarrito" }
              },
              [
                _vm.productoselecionado.length == 0 ? [_vm._m(3)] : _vm._e(),
                _vm._v(" "),
                _vm._l(_vm.productoselecionado, function(item, index) {
                  return [
                    _c("itemcarrito", {
                      attrs: { index: index, productoselecionado: item },
                      on: { cambiarcantidad: _vm.cambiarcantidad }
                    })
                  ]
                })
              ],
              2
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "col-md-12",
                staticStyle: { background: "white" }
              },
              [
                _c(
                  "div",
                  { staticClass: "table-responsive col-sm-12 totalTab" },
                  [
                    _c("table", { staticClass: "table table-sm" }, [
                      _c("tbody", [
                        _c("tr", [
                          _c(
                            "td",
                            { staticClass: "active", attrs: { width: "40%" } },
                            [
                              _vm._v(
                                "\n                                    SubTotal\n                                "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "td",
                            { staticClass: "whiteBg", attrs: { width: "60%" } },
                            [
                              _c("span", { attrs: { id: "Subtot" } }, [
                                _vm._v(
                                  "\n                                        " +
                                    _vm._s(_vm.subtotal) +
                                    "\n                                    "
                                )
                              ]),
                              _vm._v(
                                "\n                                    RD\n                                    "
                              ),
                              _c("span", { staticClass: "float-right" }, [
                                _c("b", { attrs: { id: "ItemsNum" } }, [
                                  _c("span", [
                                    _vm._v(
                                      _vm._s(_vm.cantidaditems) +
                                        "\n                                            "
                                    )
                                  ]),
                                  _vm._v(
                                    " items\n                                        "
                                  )
                                ])
                              ])
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _vm._m(4),
                        _vm._v(" "),
                        _vm._m(5),
                        _vm._v(" "),
                        _vm._m(6)
                      ])
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "col-md-12",
                staticStyle: { "margin-top": "10px" }
              },
              [
                _c("div", { staticClass: "row" }, [
                  _vm._m(7),
                  _vm._v(" "),
                  _c("div", { staticClass: "col" }, [
                    _c(
                      "button",
                      {
                        staticClass: "btn btn-success btn-lg btn-block",
                        attrs: { type: "button" },
                        on: { click: _vm.ordenar }
                      },
                      [
                        _c("i", { staticClass: "fas fa-clipboard-list" }),
                        _vm._v(" Ordenar")
                      ]
                    )
                  ])
                ])
              ]
            )
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "pull-left" }, [
      _c("div", { staticClass: "text-center" }, [
        _c("h4", [_vm._v("Clientes")])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col" }, [
      _c("i", { staticClass: "fas fa-1x fa-users" })
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "col-md-12", staticStyle: { "margin-top": "15px" } },
      [
        _c("div", { staticClass: "container" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-md-5 table-header" }, [
              _c("h5", [_vm._v("Productos")])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-2 table-header" }, [
              _c("h5", [_vm._v("Precio")])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-3 table-header" }, [
              _c("h5", [_vm._v("Cantidad")])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-2 table-header" }, [
              _c("h5", [_vm._v("Total")])
            ])
          ])
        ])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "div",
      { staticClass: "messageVide", staticStyle: { "margin-top": "15px" } },
      [
        _vm._v(
          "\n                            NO HAY PRODUCTOS\n                            "
        ),
        _c("span", [_vm._v("(Seleccionar Producto)")])
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { staticClass: "active" }, [_vm._v("Impuesto IVA")]),
      _vm._v(" "),
      _c("td", { staticClass: "whiteBg" }, [
        _c("input", {
          staticClass: "total-input",
          attrs: {
            type: "text",
            value: "12%",
            placeholder: "N/A",
            maxlength: "8",
            "aria-haspopup": "true",
            role: "textbox"
          }
        }),
        _vm._v(" "),
        _c("span", { staticClass: "float-right" }, [
          _c("b", { attrs: { id: "taxValue" } }, [_vm._v("51.60 RD")])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { staticClass: "active" }, [_vm._v("Descuento")]),
      _vm._v(" "),
      _c("td", { staticClass: "whiteBg" }, [
        _c("input", {
          staticClass: "total-input",
          attrs: {
            type: "text",
            value: "",
            placeholder: "N/A",
            maxlength: "8",
            "aria-haspopup": "true",
            role: "textbox"
          }
        }),
        _vm._v(" "),
        _c("span", { staticClass: "float-right" }, [
          _c("b", { attrs: { id: "RemiseValue" } }, [
            _vm._v(
              "\n                                            RD\n                                        "
            )
          ])
        ])
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("tr", [
      _c("td", { staticClass: "active" }, [_vm._v("Total")]),
      _vm._v(" "),
      _c("td", { staticClass: "whiteBg light-blue text-bold" }, [
        _c("span", { attrs: { id: "total" } }, [
          _vm._v(
            "\n                                        481.60\n                                    "
          )
        ]),
        _vm._v(
          "\n                                    RD\n                                "
        )
      ])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "col" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-danger btn-lg btn-block ",
          attrs: { type: "button" }
        },
        [
          _c("i", { staticClass: "fas fa-times-circle" }),
          _vm._v(" Cancelar Compra")
        ]
      )
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6cf4fc02", module.exports)
  }
}

/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticStyle: { background: "url('../../../../local/fondo6.png')" } },
    [
      _c("div", {}, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-md-12" }, [
            _c(
              "div",
              {
                staticClass: "pull-left",
                staticStyle: {
                  position: "absolute",
                  "z-index": "9999",
                  left: "689px",
                  top: "21px"
                }
              },
              [
                _c("i", {
                  staticClass: "fa fa-arrow-left fa-2x",
                  staticStyle: { cursor: "pointer" },
                  on: { click: _vm.volverpantalla }
                })
              ]
            )
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "col-md-5",
              staticStyle: { height: "900px", background: "#ecf0f1" }
            },
            [
              _c("carrito", {
                attrs: {
                  mesasocupadas: _vm.mesasocupadasv2,
                  mesa: _vm.mesa,
                  productoselecionado: _vm.productoselecionado,
                  bus: _vm.bus,
                  detalle: _vm.detalle
                },
                on: {
                  volverpant: _vm.volverpantalla,
                  cambiarcantidad: _vm.cambiarcantidad,
                  productopormesa: _vm.productopormesa
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "col-md-7",
              staticStyle: { height: "900px", background: "#ecf0f1" }
            },
            [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-12" }, [
                  _c(
                    "div",
                    { staticClass: "row-horizon" },
                    [
                      _c(
                        "span",
                        {
                          staticClass: "categorias",
                          class: { selectcategories: _vm.default1 },
                          on: {
                            click: function($event) {
                              _vm.productocategoria(0)
                            }
                          }
                        },
                        [_c("i", { staticClass: "fas fa-home" })]
                      ),
                      _vm._v(" "),
                      _vm._l(_vm.categorias, function(item, index) {
                        return [
                          _c(
                            "span",
                            {
                              staticClass: "categorias",
                              class: { selectcategories: item.active },
                              staticStyle: {
                                "margin-left": "2px",
                                cursor: "pointer"
                              },
                              on: {
                                click: function($event) {
                                  _vm.productocategoria(item.id)
                                }
                              }
                            },
                            [_vm._v(_vm._s(item.nombre))]
                          )
                        ]
                      })
                    ],
                    2
                  )
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "col-md-12",
                    staticStyle: { "margin-top": "5px" }
                  },
                  [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.buscador,
                          expression: "buscador"
                        }
                      ],
                      staticClass: "form-control form-control-sm",
                      attrs: { type: "text", id: "", placeholder: "Buscador" },
                      domProps: { value: _vm.buscador },
                      on: {
                        input: [
                          function($event) {
                            if ($event.target.composing) {
                              return
                            }
                            _vm.buscador = $event.target.value
                          },
                          function($event) {
                            if ($event.target !== $event.currentTarget) {
                              return null
                            }
                            return _vm.buscadorp($event)
                          }
                        ]
                      }
                    })
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      { name: "dragscroll", rawName: "v-dragscroll" }
                    ],
                    staticClass: "col-md-12",
                    staticStyle: {
                      height: "800px",
                      overflow: "auto",
                      cursor: "-webkit-grab"
                    }
                  },
                  [
                    _c(
                      "div",
                      {
                        staticClass: "row",
                        staticStyle: { "margin-top": "10px" }
                      },
                      [
                        _vm._l(_vm.productos, function(item, index) {
                          return [
                            _c("cardproduct", {
                              key: index,
                              attrs: {
                                index: index,
                                producto: item,
                                mesa: _vm.mesa,
                                detalle: _vm.detalle
                              },
                              on: {
                                productoagregar: _vm.productoselect,
                                bajarscroll: _vm.bajarscroll
                              }
                            })
                          ]
                        })
                      ],
                      2
                    )
                  ]
                )
              ])
            ]
          )
        ])
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-ebe03c9e", module.exports)
  }
}

/***/ }),
/* 49 */
/***/ (function(module, exports, __webpack_require__) {

!function(root, factory) {
     true ? module.exports = factory() : "function" == typeof define && define.amd ? define([], factory) : "object" == typeof exports ? exports["vue-js-modal"] = factory() : root["vue-js-modal"] = factory();
}(this, function() {
    return function(modules) {
        function __webpack_require__(moduleId) {
            if (installedModules[moduleId]) return installedModules[moduleId].exports;
            var module = installedModules[moduleId] = {
                i: moduleId,
                l: !1,
                exports: {}
            };
            return modules[moduleId].call(module.exports, module, module.exports, __webpack_require__), 
            module.l = !0, module.exports;
        }
        var installedModules = {};
        return __webpack_require__.m = modules, __webpack_require__.c = installedModules, 
        __webpack_require__.i = function(value) {
            return value;
        }, __webpack_require__.d = function(exports, name, getter) {
            __webpack_require__.o(exports, name) || Object.defineProperty(exports, name, {
                configurable: !1,
                enumerable: !0,
                get: getter
            });
        }, __webpack_require__.n = function(module) {
            var getter = module && module.__esModule ? function() {
                return module.default;
            } : function() {
                return module;
            };
            return __webpack_require__.d(getter, "a", getter), getter;
        }, __webpack_require__.o = function(object, property) {
            return Object.prototype.hasOwnProperty.call(object, property);
        }, __webpack_require__.p = "/dist/", __webpack_require__(__webpack_require__.s = 4);
    }([ function(module, exports) {
        module.exports = function(rawScriptExports, compiledTemplate, scopeId, cssModules) {
            var esModule, scriptExports = rawScriptExports = rawScriptExports || {}, type = typeof rawScriptExports.default;
            "object" !== type && "function" !== type || (esModule = rawScriptExports, scriptExports = rawScriptExports.default);
            var options = "function" == typeof scriptExports ? scriptExports.options : scriptExports;
            if (compiledTemplate && (options.render = compiledTemplate.render, options.staticRenderFns = compiledTemplate.staticRenderFns), 
            scopeId && (options._scopeId = scopeId), cssModules) {
                var computed = options.computed || (options.computed = {});
                Object.keys(cssModules).forEach(function(key) {
                    var module = cssModules[key];
                    computed[key] = function() {
                        return module;
                    };
                });
            }
            return {
                esModule: esModule,
                exports: scriptExports,
                options: options
            };
        };
    }, function(module, exports, __webpack_require__) {
        "use strict";
        Object.defineProperty(exports, "__esModule", {
            value: !0
        });
        var _extends = Object.assign || function(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
                for (var key in source) Object.prototype.hasOwnProperty.call(source, key) && (target[key] = source[key]);
            }
            return target;
        }, generateId = exports.generateId = function() {
            var index = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 0;
            return function() {
                return (index++).toString();
            };
        }();
        exports.inRange = function(from, to, value) {
            return value < from ? from : value > to ? to : value;
        }, exports.createModalEvent = function() {
            var args = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
            return _extends({
                id: generateId(),
                timestamp: Date.now(),
                canceled: !1
            }, args);
        }, exports.getMutationObserver = function() {
            if ("undefined" != typeof window) for (var prefixes = [ "", "WebKit", "Moz", "O", "Ms" ], i = 0; i < prefixes.length; i++) {
                var name = prefixes[i] + "MutationObserver";
                if (name in window) return window[name];
            }
            return !1;
        };
    }, function(module, exports) {
        module.exports = function() {
            var list = [];
            return list.toString = function() {
                for (var result = [], i = 0; i < this.length; i++) {
                    var item = this[i];
                    item[2] ? result.push("@media " + item[2] + "{" + item[1] + "}") : result.push(item[1]);
                }
                return result.join("");
            }, list.i = function(modules, mediaQuery) {
                "string" == typeof modules && (modules = [ [ null, modules, "" ] ]);
                for (var alreadyImportedModules = {}, i = 0; i < this.length; i++) {
                    var id = this[i][0];
                    "number" == typeof id && (alreadyImportedModules[id] = !0);
                }
                for (i = 0; i < modules.length; i++) {
                    var item = modules[i];
                    "number" == typeof item[0] && alreadyImportedModules[item[0]] || (mediaQuery && !item[2] ? item[2] = mediaQuery : mediaQuery && (item[2] = "(" + item[2] + ") and (" + mediaQuery + ")"), 
                    list.push(item));
                }
            }, list;
        };
    }, function(module, exports, __webpack_require__) {
        function addStylesToDom(styles) {
            for (var i = 0; i < styles.length; i++) {
                var item = styles[i], domStyle = stylesInDom[item.id];
                if (domStyle) {
                    domStyle.refs++;
                    for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j](item.parts[j]);
                    for (;j < item.parts.length; j++) domStyle.parts.push(addStyle(item.parts[j]));
                    domStyle.parts.length > item.parts.length && (domStyle.parts.length = item.parts.length);
                } else {
                    for (var parts = [], j = 0; j < item.parts.length; j++) parts.push(addStyle(item.parts[j]));
                    stylesInDom[item.id] = {
                        id: item.id,
                        refs: 1,
                        parts: parts
                    };
                }
            }
        }
        function createStyleElement() {
            var styleElement = document.createElement("style");
            return styleElement.type = "text/css", head.appendChild(styleElement), styleElement;
        }
        function addStyle(obj) {
            var update, remove, styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]');
            if (styleElement) {
                if (isProduction) return noop;
                styleElement.parentNode.removeChild(styleElement);
            }
            if (isOldIE) {
                var styleIndex = singletonCounter++;
                styleElement = singletonElement || (singletonElement = createStyleElement()), update = applyToSingletonTag.bind(null, styleElement, styleIndex, !1), 
                remove = applyToSingletonTag.bind(null, styleElement, styleIndex, !0);
            } else styleElement = createStyleElement(), update = applyToTag.bind(null, styleElement), 
            remove = function() {
                styleElement.parentNode.removeChild(styleElement);
            };
            return update(obj), function(newObj) {
                if (newObj) {
                    if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) return;
                    update(obj = newObj);
                } else remove();
            };
        }
        function applyToSingletonTag(styleElement, index, remove, obj) {
            var css = remove ? "" : obj.css;
            if (styleElement.styleSheet) styleElement.styleSheet.cssText = replaceText(index, css); else {
                var cssNode = document.createTextNode(css), childNodes = styleElement.childNodes;
                childNodes[index] && styleElement.removeChild(childNodes[index]), childNodes.length ? styleElement.insertBefore(cssNode, childNodes[index]) : styleElement.appendChild(cssNode);
            }
        }
        function applyToTag(styleElement, obj) {
            var css = obj.css, media = obj.media, sourceMap = obj.sourceMap;
            if (media && styleElement.setAttribute("media", media), sourceMap && (css += "\n/*# sourceURL=" + sourceMap.sources[0] + " */", 
            css += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + " */"), 
            styleElement.styleSheet) styleElement.styleSheet.cssText = css; else {
                for (;styleElement.firstChild; ) styleElement.removeChild(styleElement.firstChild);
                styleElement.appendChild(document.createTextNode(css));
            }
        }
        var hasDocument = "undefined" != typeof document;
        if ("undefined" != typeof DEBUG && DEBUG && !hasDocument) throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");
        var listToStyles = __webpack_require__(24), stylesInDom = {}, head = hasDocument && (document.head || document.getElementsByTagName("head")[0]), singletonElement = null, singletonCounter = 0, isProduction = !1, noop = function() {}, isOldIE = "undefined" != typeof navigator && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase());
        module.exports = function(parentId, list, _isProduction) {
            isProduction = _isProduction;
            var styles = listToStyles(parentId, list);
            return addStylesToDom(styles), function(newList) {
                for (var mayRemove = [], i = 0; i < styles.length; i++) {
                    var item = styles[i], domStyle = stylesInDom[item.id];
                    domStyle.refs--, mayRemove.push(domStyle);
                }
                newList ? (styles = listToStyles(parentId, newList), addStylesToDom(styles)) : styles = [];
                for (var i = 0; i < mayRemove.length; i++) {
                    var domStyle = mayRemove[i];
                    if (0 === domStyle.refs) {
                        for (var j = 0; j < domStyle.parts.length; j++) domStyle.parts[j]();
                        delete stylesInDom[domStyle.id];
                    }
                }
            };
        };
        var replaceText = function() {
            var textStore = [];
            return function(index, replacement) {
                return textStore[index] = replacement, textStore.filter(Boolean).join("\n");
            };
        }();
    }, function(module, exports, __webpack_require__) {
        "use strict";
        function _interopRequireDefault(obj) {
            return obj && obj.__esModule ? obj : {
                default: obj
            };
        }
        function getModalsContainer(Vue, options, root) {
            if (!root._dynamicContainer && options.injectModalsContainer) {
                var modalsContainer = document.createElement("div");
                document.body.appendChild(modalsContainer), new Vue({
                    parent: root,
                    render: function(h) {
                        return h(_ModalsContainer2.default);
                    }
                }).$mount(modalsContainer);
            }
            return root._dynamicContainer;
        }
        Object.defineProperty(exports, "__esModule", {
            value: !0
        });
        var _Modal = __webpack_require__(6), _Modal2 = _interopRequireDefault(_Modal), _Dialog = __webpack_require__(5), _Dialog2 = _interopRequireDefault(_Dialog), _ModalsContainer = __webpack_require__(7), _ModalsContainer2 = _interopRequireDefault(_ModalsContainer), Plugin = {
            install: function(Vue) {
                var options = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
                this.installed || (this.installed = !0, this.event = new Vue(), this.rootInstance = null, 
                this.componentName = options.componentName || "Modal", Vue.prototype.$modal = {
                    show: function(modal, paramsOrProps, params) {
                        var events = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : {};
                        if ("string" == typeof modal) return void Plugin.event.$emit("toggle", modal, !0, paramsOrProps);
                        var root = params && params.root ? params.root : Plugin.rootInstance, container = getModalsContainer(Vue, options, root);
                        if (container) return void container.add(modal, paramsOrProps, params, events);
                        console.warn("[vue-js-modal] In order to render dynamic modals, a <modals-container> component must be present on the page");
                    },
                    hide: function(name, params) {
                        Plugin.event.$emit("toggle", name, !1, params);
                    },
                    toggle: function(name, params) {
                        Plugin.event.$emit("toggle", name, void 0, params);
                    }
                }, Vue.component(this.componentName, _Modal2.default), options.dialog && Vue.component("VDialog", _Dialog2.default), 
                options.dynamic && (Vue.component("ModalsContainer", _ModalsContainer2.default), 
                Vue.mixin({
                    beforeMount: function() {
                        null === Plugin.rootInstance && (Plugin.rootInstance = this.$root);
                    }
                })));
            }
        };
        exports.default = Plugin;
    }, function(module, exports, __webpack_require__) {
        __webpack_require__(21);
        var Component = __webpack_require__(0)(__webpack_require__(8), __webpack_require__(18), null, null);
        Component.options.__file = "D:\\Projects\\vue\\vue-js-modal\\src\\Dialog.vue", Component.esModule && Object.keys(Component.esModule).some(function(key) {
            return "default" !== key && "__esModule" !== key;
        }) && console.error("named exports are not supported in *.vue files."), Component.options.functional && console.error("[vue-loader] Dialog.vue: functional components are not supported with templates, they should use render functions."), 
        module.exports = Component.exports;
    }, function(module, exports, __webpack_require__) {
        __webpack_require__(22);
        var Component = __webpack_require__(0)(__webpack_require__(9), __webpack_require__(19), null, null);
        Component.options.__file = "D:\\Projects\\vue\\vue-js-modal\\src\\Modal.vue", Component.esModule && Object.keys(Component.esModule).some(function(key) {
            return "default" !== key && "__esModule" !== key;
        }) && console.error("named exports are not supported in *.vue files."), Component.options.functional && console.error("[vue-loader] Modal.vue: functional components are not supported with templates, they should use render functions."), 
        module.exports = Component.exports;
    }, function(module, exports, __webpack_require__) {
        var Component = __webpack_require__(0)(__webpack_require__(10), __webpack_require__(17), null, null);
        Component.options.__file = "D:\\Projects\\vue\\vue-js-modal\\src\\ModalsContainer.vue", 
        Component.esModule && Object.keys(Component.esModule).some(function(key) {
            return "default" !== key && "__esModule" !== key;
        }) && console.error("named exports are not supported in *.vue files."), Component.options.functional && console.error("[vue-loader] ModalsContainer.vue: functional components are not supported with templates, they should use render functions."), 
        module.exports = Component.exports;
    }, function(module, exports, __webpack_require__) {
        "use strict";
        Object.defineProperty(exports, "__esModule", {
            value: !0
        }), exports.default = {
            name: "VueJsDialog",
            props: {
                width: {
                    type: [ Number, String ],
                    default: 400
                },
                clickToClose: {
                    type: Boolean,
                    default: !0
                },
                transition: {
                    type: String,
                    default: "fade"
                }
            },
            data: function() {
                return {
                    params: {},
                    defaultButtons: [ {
                        title: "CLOSE"
                    } ]
                };
            },
            computed: {
                buttons: function() {
                    return this.params.buttons || this.defaultButtons;
                },
                buttonStyle: function() {
                    return {
                        flex: "1 1 " + 100 / this.buttons.length + "%"
                    };
                }
            },
            methods: {
                beforeOpened: function(event) {
                    window.addEventListener("keyup", this.onKeyUp), this.params = event.params || {}, 
                    this.$emit("before-opened", event);
                },
                beforeClosed: function(event) {
                    window.removeEventListener("keyup", this.onKeyUp), this.params = {}, this.$emit("before-closed", event);
                },
                click: function(i, event) {
                    var source = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : "click", button = this.buttons[i];
                    button && "function" == typeof button.handler ? button.handler(i, event, {
                        source: source
                    }) : this.$modal.hide("dialog");
                },
                onKeyUp: function(event) {
                    if (13 === event.which && this.buttons.length > 0) {
                        var buttonIndex = 1 === this.buttons.length ? 0 : this.buttons.findIndex(function(button) {
                            return button.default;
                        });
                        -1 !== buttonIndex && this.click(buttonIndex, event, "keypress");
                    }
                }
            }
        };
    }, function(module, exports, __webpack_require__) {
        "use strict";
        function _interopRequireDefault(obj) {
            return obj && obj.__esModule ? obj : {
                default: obj
            };
        }
        Object.defineProperty(exports, "__esModule", {
            value: !0
        });
        var _extends = Object.assign || function(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
                for (var key in source) Object.prototype.hasOwnProperty.call(source, key) && (target[key] = source[key]);
            }
            return target;
        }, _index = __webpack_require__(4), _index2 = _interopRequireDefault(_index), _Resizer = __webpack_require__(16), _Resizer2 = _interopRequireDefault(_Resizer), _utils = __webpack_require__(1), _parser = __webpack_require__(12);
        exports.default = {
            name: "VueJsModal",
            props: {
                name: {
                    required: !0,
                    type: String
                },
                delay: {
                    type: Number,
                    default: 0
                },
                resizable: {
                    type: Boolean,
                    default: !1
                },
                adaptive: {
                    type: Boolean,
                    default: !1
                },
                draggable: {
                    type: [ Boolean, String ],
                    default: !1
                },
                scrollable: {
                    type: Boolean,
                    default: !1
                },
                reset: {
                    type: Boolean,
                    default: !1
                },
                overlayTransition: {
                    type: String,
                    default: "overlay-fade"
                },
                transition: {
                    type: String
                },
                clickToClose: {
                    type: Boolean,
                    default: !0
                },
                classes: {
                    type: [ String, Array ],
                    default: "v--modal"
                },
                minWidth: {
                    type: Number,
                    default: 0,
                    validator: function(value) {
                        return value >= 0;
                    }
                },
                minHeight: {
                    type: Number,
                    default: 0,
                    validator: function(value) {
                        return value >= 0;
                    }
                },
                maxWidth: {
                    type: Number,
                    default: 1 / 0
                },
                maxHeight: {
                    type: Number,
                    default: 1 / 0
                },
                width: {
                    type: [ Number, String ],
                    default: 600,
                    validator: _parser.validateNumber
                },
                height: {
                    type: [ Number, String ],
                    default: 300,
                    validator: function(value) {
                        return "auto" === value || (0, _parser.validateNumber)(value);
                    }
                },
                pivotX: {
                    type: Number,
                    default: .5,
                    validator: function(value) {
                        return value >= 0 && value <= 1;
                    }
                },
                pivotY: {
                    type: Number,
                    default: .5,
                    validator: function(value) {
                        return value >= 0 && value <= 1;
                    }
                }
            },
            components: {
                Resizer: _Resizer2.default
            },
            data: function() {
                return {
                    visible: !1,
                    visibility: {
                        modal: !1,
                        overlay: !1
                    },
                    shift: {
                        left: 0,
                        top: 0
                    },
                    modal: {
                        width: 0,
                        widthType: "px",
                        height: 0,
                        heightType: "px",
                        renderedHeight: 0
                    },
                    window: {
                        width: 0,
                        height: 0
                    },
                    mutationObserver: null
                };
            },
            created: function() {
                this.setInitialSize();
            },
            beforeMount: function() {
                var _this = this;
                if (_index2.default.event.$on("toggle", this.handleToggleEvent), window.addEventListener("resize", this.handleWindowResize), 
                this.handleWindowResize(), this.scrollable && !this.isAutoHeight && console.warn('Modal "' + this.name + '" has scrollable flag set to true but height is not "auto" (' + this.height + ")"), 
                this.isAutoHeight) {
                    var MutationObserver = (0, _utils.getMutationObserver)();
                    MutationObserver && (this.mutationObserver = new MutationObserver(function(mutations) {
                        _this.updateRenderedHeight();
                    }));
                }
                this.clickToClose && window.addEventListener("keyup", this.handleEscapeKeyUp);
            },
            beforeDestroy: function() {
                _index2.default.event.$off("toggle", this.handleToggleEvent), window.removeEventListener("resize", this.handleWindowResize), 
                this.clickToClose && window.removeEventListener("keyup", this.handleEscapeKeyUp), 
                this.scrollable && document.body.classList.remove("v--modal-block-scroll");
            },
            computed: {
                isAutoHeight: function() {
                    return "auto" === this.modal.heightType;
                },
                position: function() {
                    var window = this.window, shift = this.shift, pivotX = this.pivotX, pivotY = this.pivotY, trueModalWidth = this.trueModalWidth, trueModalHeight = this.trueModalHeight, maxLeft = window.width - trueModalWidth, maxTop = window.height - trueModalHeight, left = shift.left + pivotX * maxLeft, top = shift.top + pivotY * maxTop;
                    return {
                        left: parseInt((0, _utils.inRange)(0, maxLeft, left)),
                        top: parseInt((0, _utils.inRange)(0, maxTop, top))
                    };
                },
                trueModalWidth: function() {
                    var window = this.window, modal = this.modal, adaptive = this.adaptive, minWidth = this.minWidth, maxWidth = this.maxWidth, value = "%" === modal.widthType ? window.width / 100 * modal.width : modal.width, max = Math.min(window.width, maxWidth);
                    return adaptive ? (0, _utils.inRange)(minWidth, max, value) : value;
                },
                trueModalHeight: function() {
                    var window = this.window, modal = this.modal, isAutoHeight = this.isAutoHeight, adaptive = this.adaptive, maxHeight = this.maxHeight, value = "%" === modal.heightType ? window.height / 100 * modal.height : modal.height;
                    if (isAutoHeight) return this.modal.renderedHeight;
                    var max = Math.min(window.height, maxHeight);
                    return adaptive ? (0, _utils.inRange)(this.minHeight, max, value) : value;
                },
                overlayClass: function() {
                    return {
                        "v--modal-overlay": !0,
                        scrollable: this.scrollable && this.isAutoHeight
                    };
                },
                modalClass: function() {
                    return [ "v--modal-box", this.classes ];
                },
                modalStyle: function() {
                    return {
                        top: this.position.top + "px",
                        left: this.position.left + "px",
                        width: this.trueModalWidth + "px",
                        height: this.isAutoHeight ? "auto" : this.trueModalHeight + "px"
                    };
                }
            },
            watch: {
                visible: function(value) {
                    var _this2 = this;
                    value ? (this.visibility.overlay = !0, setTimeout(function() {
                        _this2.visibility.modal = !0, _this2.$nextTick(function() {
                            _this2.addDraggableListeners(), _this2.callAfterEvent(!0);
                        });
                    }, this.delay)) : (this.visibility.modal = !1, setTimeout(function() {
                        _this2.visibility.overlay = !1, _this2.$nextTick(function() {
                            _this2.removeDraggableListeners(), _this2.callAfterEvent(!1);
                        });
                    }, this.delay));
                }
            },
            methods: {
                handleToggleEvent: function(name, state, params) {
                    if (this.name === name) {
                        var nextState = void 0 === state ? !this.visible : state;
                        this.toggle(nextState, params);
                    }
                },
                setInitialSize: function() {
                    var modal = this.modal, width = (0, _parser.parseNumber)(this.width), height = (0, 
                    _parser.parseNumber)(this.height);
                    modal.width = width.value, modal.widthType = width.type, modal.height = height.value, 
                    modal.heightType = height.type;
                },
                handleEscapeKeyUp: function(event) {
                    27 === event.which && this.visible && this.$modal.hide(this.name);
                },
                handleWindowResize: function() {
                    this.window.width = window.innerWidth, this.window.height = window.innerHeight;
                },
                createModalEvent: function() {
                    var args = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                    return (0, _utils.createModalEvent)(_extends({
                        name: this.name,
                        ref: this.$refs.modal
                    }, args));
                },
                handleModalResize: function(event) {
                    this.modal.widthType = "px", this.modal.width = event.size.width, this.modal.heightType = "px", 
                    this.modal.height = event.size.height;
                    var size = this.modal.size;
                    this.$emit("resize", this.createModalEvent({
                        size: size
                    }));
                },
                toggle: function(nextState, params) {
                    var reset = this.reset, scrollable = this.scrollable, visible = this.visible;
                    if (visible !== nextState) {
                        var beforeEventName = visible ? "before-close" : "before-open";
                        "before-open" === beforeEventName ? (document.activeElement && "BODY" !== document.activeElement.tagName && document.activeElement.blur && document.activeElement.blur(), 
                        reset && (this.setInitialSize(), this.shift.left = 0, this.shift.top = 0), scrollable && document.body.classList.add("v--modal-block-scroll")) : scrollable && document.body.classList.remove("v--modal-block-scroll");
                        var stopEventExecution = !1, stop = function() {
                            stopEventExecution = !0;
                        }, beforeEvent = this.createModalEvent({
                            stop: stop,
                            state: nextState,
                            params: params
                        });
                        this.$emit(beforeEventName, beforeEvent), stopEventExecution || (this.visible = nextState);
                    }
                },
                getDraggableElement: function() {
                    var selector = "string" != typeof this.draggable ? ".v--modal-box" : this.draggable;
                    return selector ? this.$refs.overlay.querySelector(selector) : null;
                },
                handleBackgroundClick: function() {
                    this.clickToClose && this.toggle(!1);
                },
                callAfterEvent: function(state) {
                    state ? this.connectObserver() : this.disconnectObserver();
                    var eventName = state ? "opened" : "closed", event = this.createModalEvent({
                        state: state
                    });
                    this.$emit(eventName, event);
                },
                addDraggableListeners: function() {
                    var _this3 = this;
                    if (this.draggable) {
                        var dragger = this.getDraggableElement();
                        if (dragger) {
                            var startX = 0, startY = 0, cachedShiftX = 0, cachedShiftY = 0, getPosition = function(event) {
                                return event.touches && event.touches.length > 0 ? event.touches[0] : event;
                            }, handleDraggableMousedown = function(event) {
                                var target = event.target;
                                if (!target || "INPUT" !== target.nodeName) {
                                    var _getPosition = getPosition(event), clientX = _getPosition.clientX, clientY = _getPosition.clientY;
                                    document.addEventListener("mousemove", _handleDraggableMousemove), document.addEventListener("touchmove", _handleDraggableMousemove), 
                                    document.addEventListener("mouseup", _handleDraggableMouseup), document.addEventListener("touchend", _handleDraggableMouseup), 
                                    startX = clientX, startY = clientY, cachedShiftX = _this3.shift.left, cachedShiftY = _this3.shift.top;
                                }
                            }, _handleDraggableMousemove = function(event) {
                                var _getPosition2 = getPosition(event), clientX = _getPosition2.clientX, clientY = _getPosition2.clientY;
                                _this3.shift.left = cachedShiftX + clientX - startX, _this3.shift.top = cachedShiftY + clientY - startY, 
                                event.preventDefault();
                            }, _handleDraggableMouseup = function _handleDraggableMouseup(event) {
                                document.removeEventListener("mousemove", _handleDraggableMousemove), document.removeEventListener("touchmove", _handleDraggableMousemove), 
                                document.removeEventListener("mouseup", _handleDraggableMouseup), document.removeEventListener("touchend", _handleDraggableMouseup), 
                                event.preventDefault();
                            };
                            dragger.addEventListener("mousedown", handleDraggableMousedown), dragger.addEventListener("touchstart", handleDraggableMousedown);
                        }
                    }
                },
                removeDraggableListeners: function() {},
                updateRenderedHeight: function() {
                    this.$refs.modal && (this.modal.renderedHeight = this.$refs.modal.getBoundingClientRect().height);
                },
                connectObserver: function() {
                    this.mutationObserver && this.mutationObserver.observe(this.$refs.overlay, {
                        childList: !0,
                        attributes: !0,
                        subtree: !0
                    });
                },
                disconnectObserver: function() {
                    this.mutationObserver && this.mutationObserver.disconnect();
                },
                beforeTransitionEnter: function() {
                    this.connectObserver();
                },
                afterTransitionEnter: function() {},
                afterTransitionLeave: function() {}
            }
        };
    }, function(module, exports, __webpack_require__) {
        "use strict";
        Object.defineProperty(exports, "__esModule", {
            value: !0
        });
        var _extends = Object.assign || function(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = arguments[i];
                for (var key in source) Object.prototype.hasOwnProperty.call(source, key) && (target[key] = source[key]);
            }
            return target;
        }, _utils = __webpack_require__(1);
        exports.default = {
            data: function() {
                return {
                    modals: []
                };
            },
            created: function() {
                this.$root._dynamicContainer = this;
            },
            methods: {
                add: function(component) {
                    var componentAttrs = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}, _this = this, modalAttrs = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {}, modalListeners = arguments[3], id = (0, 
                    _utils.generateId)(), name = modalAttrs.name || "_dynamic_modal_" + id;
                    this.modals.push({
                        id: id,
                        modalAttrs: _extends({}, modalAttrs, {
                            name: name
                        }),
                        modalListeners: modalListeners,
                        component: component,
                        componentAttrs: componentAttrs
                    }), this.$nextTick(function() {
                        _this.$modal.show(name);
                    });
                },
                remove: function(id) {
                    for (var i in this.modals) if (this.modals[i].id === id) return void this.modals.splice(i, 1);
                }
            }
        };
    }, function(module, exports, __webpack_require__) {
        "use strict";
        Object.defineProperty(exports, "__esModule", {
            value: !0
        });
        var _utils = __webpack_require__(1);
        exports.default = {
            name: "VueJsModalResizer",
            props: {
                minHeight: {
                    type: Number,
                    default: 0
                },
                minWidth: {
                    type: Number,
                    default: 0
                }
            },
            data: function() {
                return {
                    clicked: !1,
                    size: {}
                };
            },
            mounted: function() {
                this.$el.addEventListener("mousedown", this.start, !1);
            },
            computed: {
                className: function() {
                    return {
                        "vue-modal-resizer": !0,
                        clicked: this.clicked
                    };
                }
            },
            methods: {
                start: function(event) {
                    this.clicked = !0, window.addEventListener("mousemove", this.mousemove, !1), window.addEventListener("mouseup", this.stop, !1), 
                    event.stopPropagation(), event.preventDefault();
                },
                stop: function() {
                    this.clicked = !1, window.removeEventListener("mousemove", this.mousemove, !1), 
                    window.removeEventListener("mouseup", this.stop, !1), this.$emit("resize-stop", {
                        element: this.$el.parentElement,
                        size: this.size
                    });
                },
                mousemove: function(event) {
                    this.resize(event);
                },
                resize: function(event) {
                    var el = this.$el.parentElement;
                    if (el) {
                        var width = event.clientX - el.offsetLeft, height = event.clientY - el.offsetTop;
                        width = (0, _utils.inRange)(this.minWidth, window.innerWidth, width), height = (0, 
                        _utils.inRange)(this.minHeight, window.innerHeight, height), this.size = {
                            width: width,
                            height: height
                        }, el.style.width = width + "px", el.style.height = height + "px", this.$emit("resize", {
                            element: el,
                            size: this.size
                        });
                    }
                }
            }
        };
    }, function(module, exports, __webpack_require__) {
        "use strict";
        Object.defineProperty(exports, "__esModule", {
            value: !0
        });
        var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(obj) {
            return typeof obj;
        } : function(obj) {
            return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        }, types = [ {
            name: "px",
            regexp: new RegExp("^[-+]?[0-9]*.?[0-9]+px$")
        }, {
            name: "%",
            regexp: new RegExp("^[-+]?[0-9]*.?[0-9]+%$")
        }, {
            name: "px",
            regexp: new RegExp("^[-+]?[0-9]*.?[0-9]+$")
        } ], getType = function(value) {
            if ("auto" === value) return {
                type: value,
                value: 0
            };
            for (var i = 0; i < types.length; i++) {
                var type = types[i];
                if (type.regexp.test(value)) return {
                    type: type.name,
                    value: parseFloat(value)
                };
            }
            return {
                type: "",
                value: value
            };
        }, parseNumber = exports.parseNumber = function(value) {
            switch (void 0 === value ? "undefined" : _typeof(value)) {
              case "number":
                return {
                    type: "px",
                    value: value
                };

              case "string":
                return getType(value);

              default:
                return {
                    type: "",
                    value: value
                };
            }
        };
        exports.validateNumber = function(value) {
            if ("string" == typeof value) {
                var _value = parseNumber(value);
                return ("%" === _value.type || "px" === _value.type) && _value.value > 0;
            }
            return value >= 0;
        };
    }, function(module, exports, __webpack_require__) {
        exports = module.exports = __webpack_require__(2)(), exports.push([ module.i, "\n.vue-dialog div {\r\n  box-sizing: border-box;\n}\n.vue-dialog .dialog-flex {\r\n  width: 100%;\r\n  height: 100%;\n}\n.vue-dialog .dialog-content {\r\n  flex: 1 0 auto;\r\n  width: 100%;\r\n  padding: 15px;\r\n  font-size: 14px;\n}\n.vue-dialog .dialog-c-title {\r\n  font-weight: 600;\r\n  padding-bottom: 15px;\n}\n.vue-dialog .dialog-c-text {\n}\n.vue-dialog .vue-dialog-buttons {\r\n  display: flex;\r\n  flex: 0 1 auto;\r\n  width: 100%;\r\n  border-top: 1px solid #eee;\n}\n.vue-dialog .vue-dialog-buttons-none {\r\n  width: 100%;\r\n  padding-bottom: 15px;\n}\n.vue-dialog-button {\r\n  font-size: 12px !important;\r\n  background: transparent;\r\n  padding: 0;\r\n  margin: 0;\r\n  border: 0;\r\n  cursor: pointer;\r\n  box-sizing: border-box;\r\n  line-height: 40px;\r\n  height: 40px;\r\n  color: inherit;\r\n  font: inherit;\r\n  outline: none;\n}\n.vue-dialog-button:hover {\r\n  background: rgba(0, 0, 0, 0.01);\n}\n.vue-dialog-button:active {\r\n  background: rgba(0, 0, 0, 0.025);\n}\n.vue-dialog-button:not(:first-of-type) {\r\n  border-left: 1px solid #eee;\n}\r\n", "" ]);
    }, function(module, exports, __webpack_require__) {
        exports = module.exports = __webpack_require__(2)(), exports.push([ module.i, "\n.v--modal-block-scroll {\r\n  overflow: hidden;\r\n  width: 100vw;\n}\n.v--modal-overlay {\r\n  position: fixed;\r\n  box-sizing: border-box;\r\n  left: 0;\r\n  top: 0;\r\n  width: 100%;\r\n  height: 100vh;\r\n  background: rgba(0, 0, 0, 0.2);\r\n  z-index: 999;\r\n  opacity: 1;\n}\n.v--modal-overlay.scrollable {\r\n  height: 100%;\r\n  min-height: 100vh;\r\n  overflow-y: auto;\r\n  -webkit-overflow-scrolling: touch;\n}\n.v--modal-overlay .v--modal-background-click {\r\n  min-height: 100%;\r\n  width: 100%;\n}\n.v--modal-overlay .v--modal-box {\r\n  position: relative;\r\n  overflow: hidden;\r\n  box-sizing: border-box;\n}\n.v--modal-overlay.scrollable .v--modal-box {\r\n  margin-bottom: 2px;\n}\n.v--modal {\r\n  background-color: white;\r\n  text-align: left;\r\n  border-radius: 3px;\r\n  box-shadow: 0 20px 60px -2px rgba(27, 33, 58, 0.4);\r\n  padding: 0;\n}\n.v--modal.v--modal-fullscreen {\r\n  width: 100vw;\r\n  height: 100vh;\r\n  margin: 0;\r\n  left: 0;\r\n  top: 0;\n}\n.v--modal-top-right {\r\n  display: block;\r\n  position: absolute;\r\n  right: 0;\r\n  top: 0;\n}\n.overlay-fade-enter-active,\r\n.overlay-fade-leave-active {\r\n  transition: all 0.2s;\n}\n.overlay-fade-enter,\r\n.overlay-fade-leave-active {\r\n  opacity: 0;\n}\n.nice-modal-fade-enter-active,\r\n.nice-modal-fade-leave-active {\r\n  transition: all 0.4s;\n}\n.nice-modal-fade-enter,\r\n.nice-modal-fade-leave-active {\r\n  opacity: 0;\r\n  transform: translateY(-20px);\n}\r\n", "" ]);
    }, function(module, exports, __webpack_require__) {
        exports = module.exports = __webpack_require__(2)(), exports.push([ module.i, "\n.vue-modal-resizer {\r\n  display: block;\r\n  overflow: hidden;\r\n  position: absolute;\r\n  width: 12px;\r\n  height: 12px;\r\n  right: 0;\r\n  bottom: 0;\r\n  z-index: 9999999;\r\n  background: transparent;\r\n  cursor: se-resize;\n}\n.vue-modal-resizer::after {\r\n  display: block;\r\n  position: absolute;\r\n  content: '';\r\n  background: transparent;\r\n  left: 0;\r\n  top: 0;\r\n  width: 0;\r\n  height: 0;\r\n  border-bottom: 10px solid #ddd;\r\n  border-left: 10px solid transparent;\n}\n.vue-modal-resizer.clicked::after {\r\n  border-bottom: 10px solid #369be9;\n}\r\n", "" ]);
    }, function(module, exports, __webpack_require__) {
        __webpack_require__(23);
        var Component = __webpack_require__(0)(__webpack_require__(11), __webpack_require__(20), null, null);
        Component.options.__file = "D:\\Projects\\vue\\vue-js-modal\\src\\Resizer.vue", 
        Component.esModule && Object.keys(Component.esModule).some(function(key) {
            return "default" !== key && "__esModule" !== key;
        }) && console.error("named exports are not supported in *.vue files."), Component.options.functional && console.error("[vue-loader] Resizer.vue: functional components are not supported with templates, they should use render functions."), 
        module.exports = Component.exports;
    }, function(module, exports, __webpack_require__) {
        module.exports = {
            render: function() {
                var _vm = this, _h = _vm.$createElement, _c = _vm._self._c || _h;
                return _c("div", {
                    attrs: {
                        id: "modals-container"
                    }
                }, _vm._l(_vm.modals, function(modal) {
                    return _c("modal", _vm._g(_vm._b({
                        key: modal.id,
                        on: {
                            closed: function($event) {
                                _vm.remove(modal.id);
                            }
                        }
                    }, "modal", modal.modalAttrs, !1), modal.modalListeners), [ _c(modal.component, _vm._g(_vm._b({
                        tag: "component",
                        on: {
                            close: function($event) {
                                _vm.$modal.hide(modal.modalAttrs.name);
                            }
                        }
                    }, "component", modal.componentAttrs, !1), _vm.$listeners)) ], 1);
                }));
            },
            staticRenderFns: []
        }, module.exports.render._withStripped = !0;
    }, function(module, exports, __webpack_require__) {
        module.exports = {
            render: function() {
                var _vm = this, _h = _vm.$createElement, _c = _vm._self._c || _h;
                return _c("modal", {
                    attrs: {
                        name: "dialog",
                        height: "auto",
                        classes: [ "v--modal", "vue-dialog", this.params.class ],
                        width: _vm.width,
                        "pivot-y": .3,
                        adaptive: !0,
                        clickToClose: _vm.clickToClose,
                        transition: _vm.transition
                    },
                    on: {
                        "before-open": _vm.beforeOpened,
                        "before-close": _vm.beforeClosed,
                        opened: function($event) {
                            _vm.$emit("opened", $event);
                        },
                        closed: function($event) {
                            _vm.$emit("closed", $event);
                        }
                    }
                }, [ _c("div", {
                    staticClass: "dialog-content"
                }, [ _vm.params.title ? _c("div", {
                    staticClass: "dialog-c-title",
                    domProps: {
                        innerHTML: _vm._s(_vm.params.title || "")
                    }
                }) : _vm._e(), _vm._v(" "), _vm.params.component ? _c(_vm.params.component, _vm._b({
                    tag: "component"
                }, "component", _vm.params.props, !1)) : _c("div", {
                    staticClass: "dialog-c-text",
                    domProps: {
                        innerHTML: _vm._s(_vm.params.text || "")
                    }
                }) ], 1), _vm._v(" "), _vm.buttons ? _c("div", {
                    staticClass: "vue-dialog-buttons"
                }, _vm._l(_vm.buttons, function(button, i) {
                    return _c("button", {
                        key: i,
                        class: button.class || "vue-dialog-button",
                        style: _vm.buttonStyle,
                        attrs: {
                            type: "button"
                        },
                        domProps: {
                            innerHTML: _vm._s(button.title)
                        },
                        on: {
                            click: function($event) {
                                $event.stopPropagation(), _vm.click(i, $event);
                            }
                        }
                    }, [ _vm._v("\n      " + _vm._s(button.title) + "\n    ") ]);
                })) : _c("div", {
                    staticClass: "vue-dialog-buttons-none"
                }) ]);
            },
            staticRenderFns: []
        }, module.exports.render._withStripped = !0;
    }, function(module, exports, __webpack_require__) {
        module.exports = {
            render: function() {
                var _vm = this, _h = _vm.$createElement, _c = _vm._self._c || _h;
                return _c("transition", {
                    attrs: {
                        name: _vm.overlayTransition
                    }
                }, [ _vm.visibility.overlay ? _c("div", {
                    ref: "overlay",
                    class: _vm.overlayClass,
                    attrs: {
                        "aria-expanded": _vm.visibility.overlay.toString(),
                        "data-modal": _vm.name
                    }
                }, [ _c("div", {
                    staticClass: "v--modal-background-click",
                    on: {
                        mousedown: function($event) {
                            if ($event.target !== $event.currentTarget) return null;
                            _vm.handleBackgroundClick($event);
                        },
                        touchstart: function($event) {
                            if ($event.target !== $event.currentTarget) return null;
                            _vm.handleBackgroundClick($event);
                        }
                    }
                }, [ _c("div", {
                    staticClass: "v--modal-top-right"
                }, [ _vm._t("top-right") ], 2), _vm._v(" "), _c("transition", {
                    attrs: {
                        name: _vm.transition
                    },
                    on: {
                        "before-enter": _vm.beforeTransitionEnter,
                        "after-enter": _vm.afterTransitionEnter,
                        "after-leave": _vm.afterTransitionLeave
                    }
                }, [ _vm.visibility.modal ? _c("div", {
                    ref: "modal",
                    class: _vm.modalClass,
                    style: _vm.modalStyle
                }, [ _vm._t("default"), _vm._v(" "), _vm.resizable && !_vm.isAutoHeight ? _c("resizer", {
                    attrs: {
                        "min-width": _vm.minWidth,
                        "min-height": _vm.minHeight
                    },
                    on: {
                        resize: _vm.handleModalResize
                    }
                }) : _vm._e() ], 2) : _vm._e() ]) ], 1) ]) : _vm._e() ]);
            },
            staticRenderFns: []
        }, module.exports.render._withStripped = !0;
    }, function(module, exports, __webpack_require__) {
        module.exports = {
            render: function() {
                var _vm = this, _h = _vm.$createElement;
                return (_vm._self._c || _h)("div", {
                    class: _vm.className
                });
            },
            staticRenderFns: []
        }, module.exports.render._withStripped = !0;
    }, function(module, exports, __webpack_require__) {
        var content = __webpack_require__(13);
        "string" == typeof content && (content = [ [ module.i, content, "" ] ]), content.locals && (module.exports = content.locals);
        __webpack_require__(3)("237a7ca4", content, !1);
    }, function(module, exports, __webpack_require__) {
        var content = __webpack_require__(14);
        "string" == typeof content && (content = [ [ module.i, content, "" ] ]), content.locals && (module.exports = content.locals);
        __webpack_require__(3)("2790b368", content, !1);
    }, function(module, exports, __webpack_require__) {
        var content = __webpack_require__(15);
        "string" == typeof content && (content = [ [ module.i, content, "" ] ]), content.locals && (module.exports = content.locals);
        __webpack_require__(3)("02ec91af", content, !1);
    }, function(module, exports) {
        module.exports = function(parentId, list) {
            for (var styles = [], newStyles = {}, i = 0; i < list.length; i++) {
                var item = list[i], id = item[0], css = item[1], media = item[2], sourceMap = item[3], part = {
                    id: parentId + ":" + i,
                    css: css,
                    media: media,
                    sourceMap: sourceMap
                };
                newStyles[id] ? newStyles[id].parts.push(part) : styles.push(newStyles[id] = {
                    id: id,
                    parts: [ part ]
                });
            }
            return styles;
        };
    } ]);
});

/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

!function(t,e){ true?module.exports=e():"function"==typeof define&&define.amd?define([],e):"object"==typeof exports?exports.VueDraggableResizable=e():t.VueDraggableResizable=e()}(this,function(){return function(t){function e(i){if(n[i])return n[i].exports;var r=n[i]={i:i,l:!1,exports:{}};return t[i].call(r.exports,r,r.exports,e),r.l=!0,r.exports}var n={};return e.m=t,e.c=n,e.i=function(t){return t},e.d=function(t,n,i){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:i})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=39)}([function(t,e,n){var i=n(34)("wks"),r=n(22),o=n(1).Symbol,s="function"==typeof o;(t.exports=function(t){return i[t]||(i[t]=s&&o[t]||(s?o:r)("Symbol."+t))}).store=i},function(t,e){var n=t.exports="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")();"number"==typeof __g&&(__g=n)},function(t,e,n){t.exports=!n(12)(function(){return 7!=Object.defineProperty({},"a",{get:function(){return 7}}).a})},function(t,e,n){var i=n(5),r=n(32);t.exports=n(2)?function(t,e,n){return i.f(t,e,r(1,n))}:function(t,e,n){return t[e]=n,t}},function(t,e){t.exports=function(t){return"object"==typeof t?null!==t:"function"==typeof t}},function(t,e,n){var i=n(6),r=n(54),o=n(70),s=Object.defineProperty;e.f=n(2)?Object.defineProperty:function(t,e,n){if(i(t),e=o(e,!0),i(n),r)try{return s(t,e,n)}catch(t){}if("get"in n||"set"in n)throw TypeError("Accessors not supported!");return"value"in n&&(t[e]=n.value),t}},function(t,e,n){var i=n(4);t.exports=function(t){if(!i(t))throw TypeError(t+" is not an object!");return t}},function(t,e,n){var i=n(23);t.exports=function(t,e,n){if(i(t),void 0===e)return t;switch(n){case 1:return function(n){return t.call(e,n)};case 2:return function(n,i){return t.call(e,n,i)};case 3:return function(n,i,r){return t.call(e,n,i,r)}}return function(){return t.apply(e,arguments)}}},function(t,e,n){var i=n(1),r=n(11),o=n(7),s=n(3),u=function(t,e,n){var a,c,f,h=t&u.F,l=t&u.G,p=t&u.S,d=t&u.P,m=t&u.B,v=t&u.W,g=l?r:r[e]||(r[e]={}),y=g.prototype,x=l?i:p?i[e]:(i[e]||{}).prototype;l&&(n=e);for(a in n)(c=!h&&x&&void 0!==x[a])&&a in g||(f=c?x[a]:n[a],g[a]=l&&"function"!=typeof x[a]?n[a]:m&&c?o(f,i):v&&x[a]==f?function(t){var e=function(e,n,i){if(this instanceof t){switch(arguments.length){case 0:return new t;case 1:return new t(e);case 2:return new t(e,n)}return new t(e,n,i)}return t.apply(this,arguments)};return e.prototype=t.prototype,e}(f):d&&"function"==typeof f?o(Function.call,f):f,d&&((g.virtual||(g.virtual={}))[a]=f,t&u.R&&y&&!y[a]&&s(y,a,f)))};u.F=1,u.G=2,u.S=4,u.P=8,u.B=16,u.W=32,u.U=64,u.R=128,t.exports=u},function(t,e){var n={}.hasOwnProperty;t.exports=function(t,e){return n.call(t,e)}},function(t,e){t.exports={}},function(t,e){var n=t.exports={version:"2.5.1"};"number"==typeof __e&&(__e=n)},function(t,e){t.exports=function(t){try{return!!t()}catch(t){return!0}}},function(t,e,n){var i=n(7),r=n(57),o=n(55),s=n(6),u=n(21),a=n(71),c={},f={},e=t.exports=function(t,e,n,h,l){var p,d,m,v,g=l?function(){return t}:a(t),y=i(n,h,e?2:1),x=0;if("function"!=typeof g)throw TypeError(t+" is not iterable!");if(o(g)){for(p=u(t.length);p>x;x++)if((v=e?y(s(d=t[x])[0],d[1]):y(t[x]))===c||v===f)return v}else for(m=g.call(t);!(d=m.next()).done;)if((v=r(m,y,d.value,e))===c||v===f)return v};e.BREAK=c,e.RETURN=f},function(t,e){var n={}.toString;t.exports=function(t){return n.call(t).slice(8,-1)}},function(t,e){t.exports=function(t){if(void 0==t)throw TypeError("Can't call method on  "+t);return t}},function(t,e,n){"use strict";var i=n(59),r=n(8),o=n(64),s=n(3),u=n(9),a=n(10),c=n(58),f=n(17),h=n(61),l=n(0)("iterator"),p=!([].keys&&"next"in[].keys()),d=function(){return this};t.exports=function(t,e,n,m,v,g,y){c(n,e,m);var x,b,w,_=function(t){if(!p&&t in M)return M[t];switch(t){case"keys":case"values":return function(){return new n(this,t)}}return function(){return new n(this,t)}},E=e+" Iterator",O="values"==v,S=!1,M=t.prototype,Y=M[l]||M["@@iterator"]||v&&M[v],X=Y||_(v),z=v?O?_("entries"):X:void 0,L="Array"==e?M.entries||Y:Y;if(L&&(w=h(L.call(new t)))!==Object.prototype&&w.next&&(f(w,E,!0),i||u(w,l)||s(w,l,d)),O&&Y&&"values"!==Y.name&&(S=!0,X=function(){return Y.call(this)}),i&&!y||!p&&!S&&M[l]||s(M,l,X),a[e]=X,a[E]=d,v)if(x={values:O?X:_("values"),keys:g?X:_("keys"),entries:z},y)for(b in x)b in M||o(M,b,x[b]);else r(r.P+r.F*(p||S),e,x);return x}},function(t,e,n){var i=n(5).f,r=n(9),o=n(0)("toStringTag");t.exports=function(t,e,n){t&&!r(t=n?t:t.prototype,o)&&i(t,o,{configurable:!0,value:e})}},function(t,e,n){var i=n(34)("keys"),r=n(22);t.exports=function(t){return i[t]||(i[t]=r(t))}},function(t,e){var n=Math.ceil,i=Math.floor;t.exports=function(t){return isNaN(t=+t)?0:(t>0?i:n)(t)}},function(t,e,n){var i=n(28),r=n(15);t.exports=function(t){return i(r(t))}},function(t,e,n){var i=n(19),r=Math.min;t.exports=function(t){return t>0?r(i(t),9007199254740991):0}},function(t,e){var n=0,i=Math.random();t.exports=function(t){return"Symbol(".concat(void 0===t?"":t,")_",(++n+i).toString(36))}},function(t,e){t.exports=function(t){if("function"!=typeof t)throw TypeError(t+" is not a function!");return t}},function(t,e){t.exports=function(t,e,n,i){if(!(t instanceof e)||void 0!==i&&i in t)throw TypeError(n+": incorrect invocation!");return t}},function(t,e,n){var i=n(14),r=n(0)("toStringTag"),o="Arguments"==i(function(){return arguments}()),s=function(t,e){try{return t[e]}catch(t){}};t.exports=function(t){var e,n,u;return void 0===t?"Undefined":null===t?"Null":"string"==typeof(n=s(e=Object(t),r))?n:o?i(e):"Object"==(u=i(e))&&"function"==typeof e.callee?"Arguments":u}},function(t,e,n){var i=n(4),r=n(1).document,o=i(r)&&i(r.createElement);t.exports=function(t){return o?r.createElement(t):{}}},function(t,e){t.exports="constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf".split(",")},function(t,e,n){var i=n(14);t.exports=Object("z").propertyIsEnumerable(0)?Object:function(t){return"String"==i(t)?t.split(""):Object(t)}},function(t,e){t.exports=function(t,e){return{value:e,done:!!t}}},function(t,e,n){var i=n(22)("meta"),r=n(4),o=n(9),s=n(5).f,u=0,a=Object.isExtensible||function(){return!0},c=!n(12)(function(){return a(Object.preventExtensions({}))}),f=function(t){s(t,i,{value:{i:"O"+ ++u,w:{}}})},h=function(t,e){if(!r(t))return"symbol"==typeof t?t:("string"==typeof t?"S":"P")+t;if(!o(t,i)){if(!a(t))return"F";if(!e)return"E";f(t)}return t[i].i},l=function(t,e){if(!o(t,i)){if(!a(t))return!0;if(!e)return!1;f(t)}return t[i].w},p=function(t){return c&&d.NEED&&a(t)&&!o(t,i)&&f(t),t},d=t.exports={KEY:i,NEED:!1,fastKey:h,getWeak:l,onFreeze:p}},function(t,e,n){var i=n(6),r=n(60),o=n(27),s=n(18)("IE_PROTO"),u=function(){},a=function(){var t,e=n(26)("iframe"),i=o.length;for(e.style.display="none",n(53).appendChild(e),e.src="javascript:",t=e.contentWindow.document,t.open(),t.write("<script>document.F=Object<\/script>"),t.close(),a=t.F;i--;)delete a.prototype[o[i]];return a()};t.exports=Object.create||function(t,e){var n;return null!==t?(u.prototype=i(t),n=new u,u.prototype=null,n[s]=t):n=a(),void 0===e?n:r(n,e)}},function(t,e){t.exports=function(t,e){return{enumerable:!(1&t),configurable:!(2&t),writable:!(4&t),value:e}}},function(t,e,n){var i=n(3);t.exports=function(t,e,n){for(var r in e)n&&t[r]?t[r]=e[r]:i(t,r,e[r]);return t}},function(t,e,n){var i=n(1),r=i["__core-js_shared__"]||(i["__core-js_shared__"]={});t.exports=function(t){return r[t]||(r[t]={})}},function(t,e,n){var i=n(15);t.exports=function(t){return Object(i(t))}},function(t,e,n){var i=n(4);t.exports=function(t,e){if(!i(t)||t._t!==e)throw TypeError("Incompatible receiver, "+e+" required!");return t}},function(t,e,n){n(84);var i=n(82)(n(38),n(83),"data-v-2bcd502f",null);i.options.__file="/Applications/mampstack-7.0.26-1/apache2/htdocs/vdr/src/components/vue-draggable-resizable.vue",i.esModule&&Object.keys(i.esModule).some(function(t){return"default"!==t&&"__esModule"!==t})&&console.error("named exports are not supported in *.vue files."),i.options.functional&&console.error("[vue-loader] vue-draggable-resizable.vue: functional components are not supported with templates, they should use render functions."),t.exports=i.exports},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=n(42),r=n.n(i),o=n(40);e.default={replace:!0,name:"VueDraggableResizable",props:{active:{type:Boolean,default:!1},draggable:{type:Boolean,default:!0},resizable:{type:Boolean,default:!0},w:{type:Number,default:200,validator:function(t){return t>0}},h:{type:Number,default:200,validator:function(t){return t>0}},minw:{type:Number,default:50,validator:function(t){return t>=0}},minh:{type:Number,default:50,validator:function(t){return t>=0}},x:{type:Number,default:0,validator:function(t){return"number"==typeof t}},y:{type:Number,default:0,validator:function(t){return"number"==typeof t}},z:{type:[String,Number],default:"auto",validator:function(t){return"string"==typeof t?"auto"===t:t>=0}},handles:{type:Array,default:function(){return["tl","tm","tr","mr","br","bm","bl","ml"]},validator:function(t){var e=new r.a(["tl","tm","tr","mr","br","bm","bl","ml"]);return new r.a(t.filter(function(t){return e.has(t)})).size===t.length}},dragHandle:{type:String,default:null},dragCancel:{type:String,default:null},axis:{type:String,default:"both",validator:function(t){return-1!==["x","y","both"].indexOf(t)}},grid:{type:Array,default:function(){return[1,1]}},parent:{type:Boolean,default:!1},maximize:{type:Boolean,default:!1}},created:function(){this.parentX=0,this.parentW=9999,this.parentY=0,this.parentH=9999,this.mouseX=0,this.mouseY=0,this.lastMouseX=0,this.lastMouseY=0,this.mouseOffX=0,this.mouseOffY=0,this.elmX=0,this.elmY=0,this.elmW=0,this.elmH=0},mounted:function(){document.documentElement.addEventListener("mousemove",this.handleMove,!0),document.documentElement.addEventListener("mousedown",this.deselect,!0),document.documentElement.addEventListener("mouseup",this.handleUp,!0),document.documentElement.addEventListener("touchmove",this.handleMove,!0),document.documentElement.addEventListener("touchend touchcancel",this.deselect,!0),document.documentElement.addEventListener("touchstart",this.handleUp,!0),document.documentElement.addEventListener("touchstart",this.deselect,!0),this.elmX=parseInt(this.$el.style.left),this.elmY=parseInt(this.$el.style.top),this.elmW=this.$el.offsetWidth||this.$el.clientWidth,this.elmH=this.$el.offsetHeight||this.$el.clientHeight,this.reviewDimensions()},beforeDestroy:function(){document.documentElement.removeEventListener("mousemove",this.handleMove,!0),document.documentElement.removeEventListener("mousedown",this.deselect,!0),document.documentElement.removeEventListener("mouseup",this.handleUp,!0),document.documentElement.removeEventListener("touchmove",this.handleMove,!0),document.documentElement.removeEventListener("touchend touchcancel",this.deselect,!0),document.documentElement.removeEventListener("touchstart",this.handleUp,!0),document.documentElement.removeEventListener("touchstart",this.deselect,!0)},data:function(){return{top:this.y,left:this.x,width:this.w,height:this.h,resizing:!1,dragging:!1,enabled:this.active,handle:null,zIndex:this.z}},methods:{reviewDimensions:function(){if(this.minw>this.w&&(this.width=this.minw),this.minh>this.h&&(this.height=this.minh),this.parent){var t=parseInt(this.$el.parentNode.clientWidth,10),e=parseInt(this.$el.parentNode.clientHeight,10);this.parentW=t,this.parentH=e,this.w>this.parentW&&(this.width=t),this.h>this.parentH&&(this.height=e),this.x+this.w>this.parentW&&(this.width=t-this.x),this.y+this.h>this.parentH&&(this.height=e-this.y)}this.elmW=this.width,this.elmH=this.height,this.$emit("resizing",this.left,this.top,this.width,this.height)},elmDown:function(t){var e=t.target||t.srcElement;if(this.$el.contains(e)){if(this.dragHandle&&!n.i(o.a)(e,this.dragHandle,this.$el)||this.dragCancel&&n.i(o.a)(e,this.dragCancel,this.$el))return;this.reviewDimensions(),this.enabled||(this.enabled=!0,this.$emit("activated"),this.$emit("update:active",!0)),this.draggable&&(this.dragging=!0)}},deselect:function(t){-1!==t.type.indexOf("touch")?(this.mouseX=t.changedTouches[0].clientX,this.mouseY=t.changedTouches[0].clientY):(this.mouseX=t.pageX||t.clientX+document.documentElement.scrollLeft,this.mouseY=t.pageY||t.clientY+document.documentElement.scrollTop),this.lastMouseX=this.mouseX,this.lastMouseY=this.mouseY;var e=t.target||t.srcElement,n=new RegExp("handle-([trmbl]{2})","");this.$el.contains(e)||n.test(e.className)||this.enabled&&(this.enabled=!1,this.$emit("deactivated"),this.$emit("update:active",!1))},handleDown:function(t,e){this.handle=t,e.cancelable&&(e.stopPropagation(),e.preventDefault()),this.resizing=!0},fillParent:function(t){var e=this;if(this.parent&&this.resizable&&this.maximize){var n=!1,i=function t(){n||window.requestAnimationFrame(t),"x"===e.axis?e.width===e.parentW&&e.left===e.parentX&&(n=!0):"y"===e.axis?e.height===e.parentH&&e.top===e.parentY&&(n=!0):"both"===e.axis&&e.width===e.parentW&&e.height===e.parentH&&e.top===e.parentY&&e.left===e.parentX&&(n=!0),"x"!==e.axis&&"both"!==e.axis||(e.width<e.parentW&&(e.width++,e.elmW++),e.left>e.parentX&&(e.left--,e.elmX--)),"y"!==e.axis&&"both"!==e.axis||(e.height<e.parentH&&(e.height++,e.elmH++),e.top>e.parentY&&(e.top--,e.elmY--)),e.$emit("resizing",e.left,e.top,e.width,e.height)};window.requestAnimationFrame(i)}},handleMove:function(t){var e=-1!==t.type.indexOf("touchmove");this.mouseX=e?t.touches[0].clientX:t.pageX||t.clientX+document.documentElement.scrollLeft,this.mouseY=e?t.touches[0].clientY:t.pageY||t.clientY+document.documentElement.scrollTop;var n=this.mouseX-this.lastMouseX+this.mouseOffX,i=this.mouseY-this.lastMouseY+this.mouseOffY;this.mouseOffX=this.mouseOffY=0,this.lastMouseX=this.mouseX,this.lastMouseY=this.mouseY;var r=n,o=i;this.resizing?(this.handle.indexOf("t")>=0&&(this.elmH-o<this.minh?this.mouseOffY=o-(i=this.elmH-this.minh):this.parent&&this.elmY+o<this.parentY&&(this.mouseOffY=o-(i=this.parentY-this.elmY)),this.elmY+=i,this.elmH-=i),this.handle.indexOf("b")>=0&&(this.elmH+o<this.minh?this.mouseOffY=o-(i=this.minh-this.elmH):this.parent&&this.elmY+this.elmH+o>this.parentH&&(this.mouseOffY=o-(i=this.parentH-this.elmY-this.elmH)),this.elmH+=i),this.handle.indexOf("l")>=0&&(this.elmW-r<this.minw?this.mouseOffX=r-(n=this.elmW-this.minw):this.parent&&this.elmX+r<this.parentX&&(this.mouseOffX=r-(n=this.parentX-this.elmX)),this.elmX+=n,this.elmW-=n),this.handle.indexOf("r")>=0&&(this.elmW+r<this.minw?this.mouseOffX=r-(n=this.minw-this.elmW):this.parent&&this.elmX+this.elmW+r>this.parentW&&(this.mouseOffX=r-(n=this.parentW-this.elmX-this.elmW)),this.elmW+=n),this.left=Math.round(this.elmX/this.grid[0])*this.grid[0],this.top=Math.round(this.elmY/this.grid[1])*this.grid[1],this.width=Math.round(this.elmW/this.grid[0])*this.grid[0],this.height=Math.round(this.elmH/this.grid[1])*this.grid[1],this.$emit("resizing",this.left,this.top,this.width,this.height)):this.dragging&&(this.parent&&(this.elmX+r<this.parentX?this.mouseOffX=r-(n=this.parentX-this.elmX):this.elmX+this.elmW+r>this.parentW&&(this.mouseOffX=r-(n=this.parentW-this.elmX-this.elmW)),this.elmY+o<this.parentY?this.mouseOffY=o-(i=this.parentY-this.elmY):this.elmY+this.elmH+o>this.parentH&&(this.mouseOffY=o-(i=this.parentH-this.elmY-this.elmH))),this.elmX+=n,this.elmY+=i,"x"!==this.axis&&"both"!==this.axis||(this.left=Math.round(this.elmX/this.grid[0])*this.grid[0]),"y"!==this.axis&&"both"!==this.axis||(this.top=Math.round(this.elmY/this.grid[1])*this.grid[1]),this.$emit("dragging",this.left,this.top))},handleUp:function(t){-1!==t.type.indexOf("touch")&&(this.lastMouseX=t.changedTouches[0].clientX,this.lastMouseY=t.changedTouches[0].clientY),this.handle=null,this.resizing&&(this.resizing=!1,this.$emit("resizestop",this.left,this.top,this.width,this.height)),this.dragging&&(this.dragging=!1,this.$emit("dragstop",this.left,this.top)),this.elmX=this.left,this.elmY=this.top}},computed:{style:function(){return{top:this.top+"px",left:this.left+"px",width:this.width+"px",height:this.height+"px",zIndex:this.zIndex}}},watch:{active:function(t){this.enabled=t},z:function(t){(t>=0||"auto"===t)&&(this.zIndex=t)}}}},function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=n(37),r=n.n(i);n.d(e,"default",function(){return r.a})},function(t,e,n){"use strict";function i(t,e,i){var o=t,s=["matches","webkitMatchesSelector","mozMatchesSelector","msMatchesSelector","oMatchesSelector"].find(function(t){return n.i(r.a)(o[t])});if(!n.i(r.a)(o[s]))return!1;do{if(o[s](e))return!0;if(o===i)return!1;o=o.parentNode}while(o);return!1}e.a=i;var r=n(41)},function(t,e,n){"use strict";function i(t){return"function"==typeof t||"[object Function]"===Object.prototype.toString.call(t)}e.a=i},function(t,e,n){t.exports={default:n(43),__esModule:!0}},function(t,e,n){n(73),n(75),n(79),n(74),n(78),n(77),n(76),t.exports=n(11).Set},function(t,e){t.exports=function(){}},function(t,e,n){var i=n(13);t.exports=function(t,e){var n=[];return i(t,!1,n.push,n,e),n}},function(t,e,n){var i=n(20),r=n(21),o=n(69);t.exports=function(t){return function(e,n,s){var u,a=i(e),c=r(a.length),f=o(s,c);if(t&&n!=n){for(;c>f;)if((u=a[f++])!=u)return!0}else for(;c>f;f++)if((t||f in a)&&a[f]===n)return t||f||0;return!t&&-1}}},function(t,e,n){var i=n(7),r=n(28),o=n(35),s=n(21),u=n(49);t.exports=function(t,e){var n=1==t,a=2==t,c=3==t,f=4==t,h=6==t,l=5==t||h,p=e||u;return function(e,u,d){for(var m,v,g=o(e),y=r(g),x=i(u,d,3),b=s(y.length),w=0,_=n?p(e,b):a?p(e,0):void 0;b>w;w++)if((l||w in y)&&(m=y[w],v=x(m,w,g),t))if(n)_[w]=v;else if(v)switch(t){case 3:return!0;case 5:return m;case 6:return w;case 2:_.push(m)}else if(f)return!1;return h?-1:c||f?f:_}}},function(t,e,n){var i=n(4),r=n(56),o=n(0)("species");t.exports=function(t){var e;return r(t)&&(e=t.constructor,"function"!=typeof e||e!==Array&&!r(e.prototype)||(e=void 0),i(e)&&null===(e=e[o])&&(e=void 0)),void 0===e?Array:e}},function(t,e,n){var i=n(48);t.exports=function(t,e){return new(i(t))(e)}},function(t,e,n){"use strict";var i=n(5).f,r=n(31),o=n(33),s=n(7),u=n(24),a=n(13),c=n(16),f=n(29),h=n(67),l=n(2),p=n(30).fastKey,d=n(36),m=l?"_s":"size",v=function(t,e){var n,i=p(e);if("F"!==i)return t._i[i];for(n=t._f;n;n=n.n)if(n.k==e)return n};t.exports={getConstructor:function(t,e,n,c){var f=t(function(t,i){u(t,f,e,"_i"),t._t=e,t._i=r(null),t._f=void 0,t._l=void 0,t[m]=0,void 0!=i&&a(i,n,t[c],t)});return o(f.prototype,{clear:function(){for(var t=d(this,e),n=t._i,i=t._f;i;i=i.n)i.r=!0,i.p&&(i.p=i.p.n=void 0),delete n[i.i];t._f=t._l=void 0,t[m]=0},delete:function(t){var n=d(this,e),i=v(n,t);if(i){var r=i.n,o=i.p;delete n._i[i.i],i.r=!0,o&&(o.n=r),r&&(r.p=o),n._f==i&&(n._f=r),n._l==i&&(n._l=o),n[m]--}return!!i},forEach:function(t){d(this,e);for(var n,i=s(t,arguments.length>1?arguments[1]:void 0,3);n=n?n.n:this._f;)for(i(n.v,n.k,this);n&&n.r;)n=n.p},has:function(t){return!!v(d(this,e),t)}}),l&&i(f.prototype,"size",{get:function(){return d(this,e)[m]}}),f},def:function(t,e,n){var i,r,o=v(t,e);return o?o.v=n:(t._l=o={i:r=p(e,!0),k:e,v:n,p:i=t._l,n:void 0,r:!1},t._f||(t._f=o),i&&(i.n=o),t[m]++,"F"!==r&&(t._i[r]=o)),t},getEntry:v,setStrong:function(t,e,n){c(t,e,function(t,n){this._t=d(t,e),this._k=n,this._l=void 0},function(){for(var t=this,e=t._k,n=t._l;n&&n.r;)n=n.p;return t._t&&(t._l=n=n?n.n:t._t._f)?"keys"==e?f(0,n.k):"values"==e?f(0,n.v):f(0,[n.k,n.v]):(t._t=void 0,f(1))},n?"entries":"values",!n,!0),h(e)}}},function(t,e,n){var i=n(25),r=n(45);t.exports=function(t){return function(){if(i(this)!=t)throw TypeError(t+"#toJSON isn't generic");return r(this)}}},function(t,e,n){"use strict";var i=n(1),r=n(8),o=n(30),s=n(12),u=n(3),a=n(33),c=n(13),f=n(24),h=n(4),l=n(17),p=n(5).f,d=n(47)(0),m=n(2);t.exports=function(t,e,n,v,g,y){var x=i[t],b=x,w=g?"set":"add",_=b&&b.prototype,E={};return m&&"function"==typeof b&&(y||_.forEach&&!s(function(){(new b).entries().next()}))?(b=e(function(e,n){f(e,b,t,"_c"),e._c=new x,void 0!=n&&c(n,g,e[w],e)}),d("add,clear,delete,forEach,get,has,set,keys,values,entries,toJSON".split(","),function(t){var e="add"==t||"set"==t;t in _&&(!y||"clear"!=t)&&u(b.prototype,t,function(n,i){if(f(this,b,t),!e&&y&&!h(n))return"get"==t&&void 0;var r=this._c[t](0===n?0:n,i);return e?this:r})}),y||p(b.prototype,"size",{get:function(){return this._c.size}})):(b=v.getConstructor(e,t,g,w),a(b.prototype,n),o.NEED=!0),l(b,t),E[t]=b,r(r.G+r.W+r.F,E),y||v.setStrong(b,t,g),b}},function(t,e,n){var i=n(1).document;t.exports=i&&i.documentElement},function(t,e,n){t.exports=!n(2)&&!n(12)(function(){return 7!=Object.defineProperty(n(26)("div"),"a",{get:function(){return 7}}).a})},function(t,e,n){var i=n(10),r=n(0)("iterator"),o=Array.prototype;t.exports=function(t){return void 0!==t&&(i.Array===t||o[r]===t)}},function(t,e,n){var i=n(14);t.exports=Array.isArray||function(t){return"Array"==i(t)}},function(t,e,n){var i=n(6);t.exports=function(t,e,n,r){try{return r?e(i(n)[0],n[1]):e(n)}catch(e){var o=t.return;throw void 0!==o&&i(o.call(t)),e}}},function(t,e,n){"use strict";var i=n(31),r=n(32),o=n(17),s={};n(3)(s,n(0)("iterator"),function(){return this}),t.exports=function(t,e,n){t.prototype=i(s,{next:r(1,n)}),o(t,e+" Iterator")}},function(t,e){t.exports=!0},function(t,e,n){var i=n(5),r=n(6),o=n(63);t.exports=n(2)?Object.defineProperties:function(t,e){r(t);for(var n,s=o(e),u=s.length,a=0;u>a;)i.f(t,n=s[a++],e[n]);return t}},function(t,e,n){var i=n(9),r=n(35),o=n(18)("IE_PROTO"),s=Object.prototype;t.exports=Object.getPrototypeOf||function(t){return t=r(t),i(t,o)?t[o]:"function"==typeof t.constructor&&t instanceof t.constructor?t.constructor.prototype:t instanceof Object?s:null}},function(t,e,n){var i=n(9),r=n(20),o=n(46)(!1),s=n(18)("IE_PROTO");t.exports=function(t,e){var n,u=r(t),a=0,c=[];for(n in u)n!=s&&i(u,n)&&c.push(n);for(;e.length>a;)i(u,n=e[a++])&&(~o(c,n)||c.push(n));return c}},function(t,e,n){var i=n(62),r=n(27);t.exports=Object.keys||function(t){return i(t,r)}},function(t,e,n){t.exports=n(3)},function(t,e,n){"use strict";var i=n(8),r=n(23),o=n(7),s=n(13);t.exports=function(t){i(i.S,t,{from:function(t){var e,n,i,u,a=arguments[1];return r(this),e=void 0!==a,e&&r(a),void 0==t?new this:(n=[],e?(i=0,u=o(a,arguments[2],2),s(t,!1,function(t){n.push(u(t,i++))})):s(t,!1,n.push,n),new this(n))}})}},function(t,e,n){"use strict";var i=n(8);t.exports=function(t){i(i.S,t,{of:function(){for(var t=arguments.length,e=Array(t);t--;)e[t]=arguments[t];return new this(e)}})}},function(t,e,n){"use strict";var i=n(1),r=n(11),o=n(5),s=n(2),u=n(0)("species");t.exports=function(t){var e="function"==typeof r[t]?r[t]:i[t];s&&e&&!e[u]&&o.f(e,u,{configurable:!0,get:function(){return this}})}},function(t,e,n){var i=n(19),r=n(15);t.exports=function(t){return function(e,n){var o,s,u=String(r(e)),a=i(n),c=u.length;return a<0||a>=c?t?"":void 0:(o=u.charCodeAt(a),o<55296||o>56319||a+1===c||(s=u.charCodeAt(a+1))<56320||s>57343?t?u.charAt(a):o:t?u.slice(a,a+2):s-56320+(o-55296<<10)+65536)}}},function(t,e,n){var i=n(19),r=Math.max,o=Math.min;t.exports=function(t,e){return t=i(t),t<0?r(t+e,0):o(t,e)}},function(t,e,n){var i=n(4);t.exports=function(t,e){if(!i(t))return t;var n,r;if(e&&"function"==typeof(n=t.toString)&&!i(r=n.call(t)))return r;if("function"==typeof(n=t.valueOf)&&!i(r=n.call(t)))return r;if(!e&&"function"==typeof(n=t.toString)&&!i(r=n.call(t)))return r;throw TypeError("Can't convert object to primitive value")}},function(t,e,n){var i=n(25),r=n(0)("iterator"),o=n(10);t.exports=n(11).getIteratorMethod=function(t){if(void 0!=t)return t[r]||t["@@iterator"]||o[i(t)]}},function(t,e,n){"use strict";var i=n(44),r=n(29),o=n(10),s=n(20);t.exports=n(16)(Array,"Array",function(t,e){this._t=s(t),this._i=0,this._k=e},function(){var t=this._t,e=this._k,n=this._i++;return!t||n>=t.length?(this._t=void 0,r(1)):"keys"==e?r(0,n):"values"==e?r(0,t[n]):r(0,[n,t[n]])},"values"),o.Arguments=o.Array,i("keys"),i("values"),i("entries")},function(t,e){},function(t,e,n){"use strict";var i=n(50),r=n(36);t.exports=n(52)("Set",function(t){return function(){return t(this,arguments.length>0?arguments[0]:void 0)}},{add:function(t){return i.def(r(this,"Set"),t=0===t?0:t,t)}},i)},function(t,e,n){"use strict";var i=n(68)(!0);n(16)(String,"String",function(t){this._t=String(t),this._i=0},function(){var t,e=this._t,n=this._i;return n>=e.length?{value:void 0,done:!0}:(t=i(e,n),this._i+=t.length,{value:t,done:!1})})},function(t,e,n){n(65)("Set")},function(t,e,n){n(66)("Set")},function(t,e,n){var i=n(8);i(i.P+i.R,"Set",{toJSON:n(51)("Set")})},function(t,e,n){n(72);for(var i=n(1),r=n(3),o=n(10),s=n(0)("toStringTag"),u="CSSRuleList,CSSStyleDeclaration,CSSValueList,ClientRectList,DOMRectList,DOMStringList,DOMTokenList,DataTransferItemList,FileList,HTMLAllCollection,HTMLCollection,HTMLFormElement,HTMLSelectElement,MediaList,MimeTypeArray,NamedNodeMap,NodeList,PaintRequestList,Plugin,PluginArray,SVGLengthList,SVGNumberList,SVGPathSegList,SVGPointList,SVGStringList,SVGTransformList,SourceBufferList,StyleSheetList,TextTrackCueList,TextTrackList,TouchList".split(","),a=0;a<u.length;a++){var c=u[a],f=i[c],h=f&&f.prototype;h&&!h[s]&&r(h,s,c),o[c]=o.Array}},function(t,e,n){e=t.exports=n(81)(),e.push([t.i,"\n.vdr[data-v-2bcd502f] {\n  touch-action: none;\n  position: absolute;\n  box-sizing: border-box;\n}\n.handle[data-v-2bcd502f] {\n  box-sizing: border-box;\n  display: none;\n  position: absolute;\n  width: 10px;\n  height: 10px;\n  font-size: 1px;\n  background: #EEE;\n  border: 1px solid #333;\n}\n.handle-tl[data-v-2bcd502f] {\n  top: -10px;\n  left: -10px;\n  cursor: nw-resize;\n}\n.handle-tm[data-v-2bcd502f] {\n  top: -10px;\n  left: 50%;\n  margin-left: -5px;\n  cursor: n-resize;\n}\n.handle-tr[data-v-2bcd502f] {\n  top: -10px;\n  right: -10px;\n  cursor: ne-resize;\n}\n.handle-ml[data-v-2bcd502f] {\n  top: 50%;\n  margin-top: -5px;\n  left: -10px;\n  cursor: w-resize;\n}\n.handle-mr[data-v-2bcd502f] {\n  top: 50%;\n  margin-top: -5px;\n  right: -10px;\n  cursor: e-resize;\n}\n.handle-bl[data-v-2bcd502f] {\n  bottom: -10px;\n  left: -10px;\n  cursor: sw-resize;\n}\n.handle-bm[data-v-2bcd502f] {\n  bottom: -10px;\n  left: 50%;\n  margin-left: -5px;\n  cursor: s-resize;\n}\n.handle-br[data-v-2bcd502f] {\n  bottom: -10px;\n  right: -10px;\n  cursor: se-resize;\n}\n@media only screen and (max-width: 768px) {\n  /* For mobile phones: */\n[class*=\"handle-\"][data-v-2bcd502f]:before {\n    content: '';\n    left: -10px;\n    right: -10px;\n    bottom: -10px;\n    top: -10px;\n    position: absolute;\n}\n}\n",""])},function(t,e){t.exports=function(){var t=[];return t.toString=function(){for(var t=[],e=0;e<this.length;e++){var n=this[e];n[2]?t.push("@media "+n[2]+"{"+n[1]+"}"):t.push(n[1])}return t.join("")},t.i=function(e,n){"string"==typeof e&&(e=[[null,e,""]]);for(var i={},r=0;r<this.length;r++){var o=this[r][0];"number"==typeof o&&(i[o]=!0)}for(r=0;r<e.length;r++){var s=e[r];"number"==typeof s[0]&&i[s[0]]||(n&&!s[2]?s[2]=n:n&&(s[2]="("+s[2]+") and ("+n+")"),t.push(s))}},t}},function(t,e){t.exports=function(t,e,n,i){var r,o=t=t||{},s=typeof t.default;"object"!==s&&"function"!==s||(r=t,o=t.default);var u="function"==typeof o?o.options:o;if(e&&(u.render=e.render,u.staticRenderFns=e.staticRenderFns),n&&(u._scopeId=n),i){var a=Object.create(u.computed||null);Object.keys(i).forEach(function(t){var e=i[t];a[t]=function(){return e}}),u.computed=a}return{esModule:r,exports:o,options:u}}},function(t,e,n){t.exports={render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"vdr",class:{draggable:t.draggable,resizable:t.resizable,active:t.enabled,dragging:t.dragging,resizing:t.resizing},style:t.style,on:{mousedown:t.elmDown,touchstart:t.elmDown,dblclick:t.fillParent}},[t._l(t.handles,function(e){return t.resizable?n("div",{key:e,staticClass:"handle",class:"handle-"+e,style:{display:t.enabled?"block":"none"},on:{mousedown:function(n){t.handleDown(e,n)},touchstart:function(n){t.handleDown(e,n)}}}):t._e()}),t._v(" "),t._t("default")],2)},staticRenderFns:[]},t.exports.render._withStripped=!0},function(t,e,n){var i=n(80);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);n(85)("4764308c",i,!1)},function(t,e,n){function i(t){for(var e=0;e<t.length;e++){var n=t[e],i=f[n.id];if(i){i.refs++;for(var r=0;r<i.parts.length;r++)i.parts[r](n.parts[r]);for(;r<n.parts.length;r++)i.parts.push(o(n.parts[r]));i.parts.length>n.parts.length&&(i.parts.length=n.parts.length)}else{for(var s=[],r=0;r<n.parts.length;r++)s.push(o(n.parts[r]));f[n.id]={id:n.id,refs:1,parts:s}}}}function r(){var t=document.createElement("style");return t.type="text/css",h.appendChild(t),t}function o(t){var e,n,i=document.querySelector('style[data-vue-ssr-id~="'+t.id+'"]');if(i){if(d)return m;i.parentNode.removeChild(i)}if(v){var o=p++;i=l||(l=r()),e=s.bind(null,i,o,!1),n=s.bind(null,i,o,!0)}else i=r(),e=u.bind(null,i),n=function(){i.parentNode.removeChild(i)};return e(t),function(i){if(i){if(i.css===t.css&&i.media===t.media&&i.sourceMap===t.sourceMap)return;e(t=i)}else n()}}function s(t,e,n,i){var r=n?"":i.css;if(t.styleSheet)t.styleSheet.cssText=g(e,r);else{var o=document.createTextNode(r),s=t.childNodes;s[e]&&t.removeChild(s[e]),s.length?t.insertBefore(o,s[e]):t.appendChild(o)}}function u(t,e){var n=e.css,i=e.media,r=e.sourceMap;if(i&&t.setAttribute("media",i),r&&(n+="\n/*# sourceURL="+r.sources[0]+" */",n+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(r))))+" */"),t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}var a="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!a)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var c=n(86),f={},h=a&&(document.head||document.getElementsByTagName("head")[0]),l=null,p=0,d=!1,m=function(){},v="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());t.exports=function(t,e,n){d=n;var r=c(t,e);return i(r),function(e){for(var n=[],o=0;o<r.length;o++){var s=r[o],u=f[s.id];u.refs--,n.push(u)}e?(r=c(t,e),i(r)):r=[];for(var o=0;o<n.length;o++){var u=n[o];if(0===u.refs){for(var a=0;a<u.parts.length;a++)u.parts[a]();delete f[u.id]}}}};var g=function(){var t=[];return function(e,n){return t[e]=n,t.filter(Boolean).join("\n")}}()},function(t,e){t.exports=function(t,e){for(var n=[],i={},r=0;r<e.length;r++){var o=e[r],s=o[0],u=o[1],a=o[2],c=o[3],f={id:t+":"+r,css:u,media:a,sourceMap:c};i[s]?i[s].parts.push(f):n.push(i[s]={id:s,parts:[f]})}return n}}])});

/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "container-fluid" },
    [
      _vm.prueba == false
        ? _c("div", {}, [
            _c(
              "div",
              {
                staticStyle: {
                  background: "url('../../../../local/fondo6.png')"
                }
              },
              [
                _c("div", { staticClass: "container-fluid" }, [
                  _c("div", { staticClass: "row" }, [
                    _c(
                      "div",
                      {
                        staticClass: "col-md-12",
                        staticStyle: { "margin-bottom": "15px" }
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "row row-horizon" },
                          [
                            _c("div", [
                              _c(
                                "span",
                                {
                                  staticClass: "categorias",
                                  staticStyle: {
                                    "margin-left": "2px",
                                    cursor: "pointer"
                                  },
                                  on: { click: _vm.openmodal }
                                },
                                [_c("i", { staticClass: "fa fa-plus-circle" })]
                              )
                            ]),
                            _vm._v(" "),
                            _vm._l(_vm.dataareas, function(item, index) {
                              return [
                                _c("div", [
                                  _c(
                                    "span",
                                    {
                                      staticClass: "categorias",
                                      class: { selectcategories: item.active },
                                      staticStyle: {
                                        "margin-left": "2px",
                                        cursor: "pointer"
                                      },
                                      on: {
                                        click: function($event) {
                                          _vm.corotosporarea(item.id)
                                        }
                                      }
                                    },
                                    [
                                      _vm._v(
                                        _vm._s(item.nombre) +
                                          "\n                                        "
                                      ),
                                      _vm.areaid != 0
                                        ? [
                                            _vm.editar == false
                                              ? _c("i", {
                                                  staticClass: "fa fa-edit",
                                                  staticStyle: {
                                                    position: "absolute",
                                                    top: "7px"
                                                  },
                                                  on: {
                                                    click: function($event) {
                                                      _vm.editar = true
                                                    }
                                                  }
                                                })
                                              : _c("i", {
                                                  staticClass: "fa fa-save",
                                                  staticStyle: {
                                                    position: "absolute",
                                                    top: "7px"
                                                  },
                                                  on: { click: _vm.salvar }
                                                })
                                          ]
                                        : _vm._e()
                                    ],
                                    2
                                  )
                                ])
                              ]
                            })
                          ],
                          2
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        directives: [
                          { name: "dragscroll", rawName: "v-dragscroll" }
                        ],
                        staticClass: "col-",
                        staticStyle: {
                          "overflow-y": "auto",
                          margin: "0",
                          padding: "0",
                          height: "800px"
                        }
                      },
                      [
                        _c(
                          "div",
                          { staticClass: "container" },
                          [
                            _vm._m(0),
                            _vm._v(" "),
                            _vm._l(_vm.objetos, function(item) {
                              return [
                                _c(
                                  "div",
                                  {
                                    staticClass: "text-center",
                                    staticStyle: { "margin-top": "5px" }
                                  },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass: "card-mio",
                                        on: {
                                          click: function($event) {
                                            _vm.nuevocoroto(item.img, item.name)
                                          }
                                        }
                                      },
                                      [
                                        _c(
                                          "div",
                                          {
                                            staticClass: "card-img-wrap",
                                            staticStyle: {
                                              "box-shadow":
                                                "0px 0px 6px 0px rgba(0,0,0,0.75)"
                                            }
                                          },
                                          [
                                            _c("img", {
                                              staticClass: "img-card",
                                              attrs: {
                                                src:
                                                  "../../../../local/" +
                                                  item.img,
                                                alt: ""
                                              }
                                            })
                                          ]
                                        )
                                      ]
                                    )
                                  ]
                                )
                              ]
                            })
                          ],
                          2
                        )
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass: "col-md-10",
                        staticStyle: {
                          background: "url('../../../../local/wood.png')",
                          height: "800px",
                          "border-radius": "10px 10px 10px 10px"
                        }
                      },
                      [
                        _c("div", {
                          staticClass: "pull-right",
                          staticStyle: { "margin-top": "5px" }
                        }),
                        _vm._v(" "),
                        _vm._l(_vm.corotos, function(item, index) {
                          return [
                            _vm.editar == true
                              ? [
                                  _c(
                                    "vue-draggable-resizable",
                                    {
                                      attrs: {
                                        "drag-handle": ".drag",
                                        x: item.left,
                                        y: item.top,
                                        minw: 10,
                                        minh: 10,
                                        w: item.width,
                                        h: item.height,
                                        parent: true,
                                        resizable: _vm.editar,
                                        draggable: _vm.editar
                                      },
                                      on: {
                                        dragging: [
                                          _vm.onDrag,
                                          function($event) {
                                            _vm.datoscoroto(item)
                                          }
                                        ],
                                        resizing: [
                                          _vm.onResize,
                                          function($event) {
                                            _vm.datoscoroto(item)
                                          }
                                        ],
                                        resizestop: function($event) {
                                          _vm.datoscoroto(item)
                                        },
                                        dragstop: function($event) {
                                          _vm.datoscoroto(item)
                                        }
                                      }
                                    },
                                    [
                                      _c("div", { staticClass: "row" }, [
                                        _c(
                                          "div",
                                          { staticClass: "col-md-12" },
                                          [
                                            _c(
                                              "div",
                                              {
                                                staticClass: "text-center",
                                                staticStyle: {
                                                  "border-radius":
                                                    "10px 10px 10px 10px",
                                                  cursor: "grab",
                                                  "box-shadow":
                                                    "0px 0px 5px 0px rgba(0,0,0,0.75)"
                                                }
                                              },
                                              [
                                                _c(
                                                  "div",
                                                  {
                                                    staticClass: "drag",
                                                    staticStyle: {
                                                      color: "white",
                                                      "font-size": "14px"
                                                    }
                                                  },
                                                  [
                                                    _c("i", {
                                                      staticClass:
                                                        "fa fa-arrows-alt",
                                                      staticStyle: {
                                                        color: "black"
                                                      }
                                                    })
                                                  ]
                                                )
                                              ]
                                            )
                                          ]
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "div",
                                          { staticClass: "col-md-12" },
                                          [
                                            _c("ItemCoroto", {
                                              key: item.id,
                                              attrs: {
                                                name: item.name,
                                                area: _vm.areaid,
                                                numero: item.numero,
                                                editar: _vm.editar,
                                                index: index,
                                                img: item.img,
                                                id: item.id,
                                                status: item.status,
                                                y: item.top,
                                                x: item.left,
                                                w: item.width,
                                                h: item.height
                                              },
                                              on: {
                                                eliminarcoroto:
                                                  _vm.eliminarcoroto
                                              }
                                            })
                                          ],
                                          1
                                        )
                                      ])
                                    ]
                                  )
                                ]
                              : [
                                  item.name === "caja" ||
                                  item.name == "pared" ||
                                  item.name == "mata" ||
                                  item.name == "puerta"
                                    ? [
                                        _c(
                                          "vue-draggable-resizable",
                                          {
                                            attrs: {
                                              x: item.left,
                                              y: item.top,
                                              minh: 10,
                                              minw: 10,
                                              w: item.width,
                                              h: item.height,
                                              parent: true,
                                              resizable: _vm.editar,
                                              draggable: _vm.editar
                                            },
                                            on: {
                                              dragging: [
                                                _vm.onDrag,
                                                function($event) {
                                                  _vm.datoscoroto(item)
                                                }
                                              ],
                                              resizing: [
                                                _vm.onResize,
                                                function($event) {
                                                  _vm.datoscoroto(item)
                                                }
                                              ],
                                              resizestop: function($event) {
                                                _vm.datoscoroto(item)
                                              },
                                              dragstop: function($event) {
                                                _vm.datoscoroto(item)
                                              }
                                            }
                                          },
                                          [
                                            _c(
                                              "div",
                                              {},
                                              [
                                                _c("ItemCoroto", {
                                                  key: item.id,
                                                  attrs: {
                                                    name: item.name,
                                                    area: _vm.areaid,
                                                    numero: item.numero,
                                                    editar: _vm.editar,
                                                    index: index,
                                                    img: item.img,
                                                    id: item.id,
                                                    status: item.status,
                                                    y: item.top,
                                                    x: item.left,
                                                    w: item.width,
                                                    h: item.height
                                                  },
                                                  on: {
                                                    eliminarcoroto:
                                                      _vm.eliminarcoroto
                                                  }
                                                })
                                              ],
                                              1
                                            )
                                          ]
                                        )
                                      ]
                                    : [
                                        _c(
                                          "vue-draggable-resizable",
                                          {
                                            staticStyle: { cursor: "pointer" },
                                            attrs: {
                                              x: item.left,
                                              y: item.top,
                                              minh: 10,
                                              minw: 10,
                                              w: item.width,
                                              h: item.height,
                                              parent: true,
                                              resizable: _vm.editar,
                                              draggable: _vm.editar
                                            },
                                            on: {
                                              activated: function($event) {
                                                _vm.modalcoroto(index)
                                              },
                                              dragging: [
                                                _vm.onDrag,
                                                function($event) {
                                                  _vm.datoscoroto(item)
                                                }
                                              ],
                                              resizing: [
                                                _vm.onResize,
                                                function($event) {
                                                  _vm.datoscoroto(item)
                                                }
                                              ],
                                              resizestop: function($event) {
                                                _vm.datoscoroto(item)
                                              },
                                              dragstop: function($event) {
                                                _vm.datoscoroto(item)
                                              }
                                            }
                                          },
                                          [
                                            _c(
                                              "div",
                                              {},
                                              [
                                                _c("ItemCoroto", {
                                                  key: item.id,
                                                  attrs: {
                                                    name: item.name,
                                                    area: _vm.areaid,
                                                    numero: item.numero,
                                                    editar: _vm.editar,
                                                    index: index,
                                                    img: item.img,
                                                    id: item.id,
                                                    status: item.status,
                                                    y: item.top,
                                                    x: item.left,
                                                    w: item.width,
                                                    h: item.height
                                                  },
                                                  on: {
                                                    eliminarcoroto:
                                                      _vm.eliminarcoroto
                                                  }
                                                })
                                              ],
                                              1
                                            )
                                          ]
                                        )
                                      ]
                                ]
                          ]
                        })
                      ],
                      2
                    )
                  ])
                ])
              ]
            )
          ])
        : _c("ordenes", {
            attrs: { mesasocupada: _vm.mesasocupada, mesa: _vm.mesa },
            on: { prueba: _vm.prueba2 }
          }),
      _vm._v(" "),
      _c("modal", { attrs: { name: "crear", draggable: true, height: 200 } }, [
        _c("div", { staticClass: "container" }, [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              {
                staticClass: "col-md-12",
                staticStyle: { background: "#4272d7" }
              },
              [
                _c("div", { staticClass: "text-center" }, [
                  _c("h2", { staticStyle: { color: "white" } }, [
                    _vm._v("Crear Area")
                  ])
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "col-md-12",
                staticStyle: { "margin-top": "15px" }
              },
              [
                _c("div", { staticClass: "row form-group" }, [
                  _c("div", { staticClass: "col col-md-4" }, [
                    _c("label", { staticClass: " form-control-label" }, [
                      _vm._v("Nombre del area")
                    ])
                  ]),
                  _vm._v(" "),
                  _c("div", { staticClass: "col-12 col-md-8" }, [
                    _c("input", {
                      directives: [
                        {
                          name: "model",
                          rawName: "v-model",
                          value: _vm.nombrearea,
                          expression: "nombrearea"
                        }
                      ],
                      staticClass: "form-control",
                      attrs: { type: "text", maxlength: "15" },
                      domProps: { value: _vm.nombrearea },
                      on: {
                        input: function($event) {
                          if ($event.target.composing) {
                            return
                          }
                          _vm.nombrearea = $event.target.value
                        }
                      }
                    })
                  ])
                ])
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "col-md-12",
                staticStyle: { "margin-top": "15px" }
              },
              [
                _c("div", { staticClass: "text-center" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary",
                      attrs: { type: "button" },
                      on: { click: _vm.savearea }
                    },
                    [_vm._v("Guardar")]
                  )
                ])
              ]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("modal", { attrs: { name: "coroto", draggable: true } }, [
        _c(
          "div",
          { staticClass: "row", staticStyle: { background: "#fafaed" } },
          [
            _c(
              "div",
              {
                staticClass: "col-md-12",
                staticStyle: {
                  "margin-top": "38px",
                  "padding-left": "104px",
                  "padding-right": "104px",
                  "margin-bottom": "10px"
                }
              },
              [
                _c(
                  "div",
                  {
                    staticClass: "text-center",
                    staticStyle: {
                      background: "whitesmoke",
                      "box-shadow": "0px 0px 5px 0px rgba(0,0,0,0.75)",
                      "border-radius": "10px 10px 10px 10px",
                      "margin-bottom": "10px"
                    }
                  },
                  [
                    _c("h3", {}, [_vm._v("Mesa Disponible")]),
                    _vm._v(" "),
                    _c("div", { staticClass: "row" }, [
                      _c(
                        "div",
                        {
                          staticClass: "col-md-12",
                          staticStyle: { "margin-top": "15px" }
                        },
                        [_c("h4", {}, [_vm._v("Cantidad de invitados")])]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-12",
                          staticStyle: { "margin-top": "15px" }
                        },
                        [
                          _c(
                            "div",
                            { staticStyle: { "margin-bottom": "40px" } },
                            [
                              _c("i", {
                                staticClass: "fas fa-2x fa-plus-circle",
                                staticStyle: { cursor: "pointer" },
                                on: {
                                  click: function($event) {
                                    _vm.aumentar("mas")
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c("h3", {}, [_vm._v(_vm._s(_vm.invitados))]),
                              _vm._v(" "),
                              _c("i", {
                                staticClass: "fas fa-2x fa-minus-circle",
                                staticStyle: { cursor: "pointer" },
                                on: {
                                  click: function($event) {
                                    _vm.aumentar("menos")
                                  }
                                }
                              })
                            ]
                          )
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        {
                          staticClass: "col-md-12",
                          staticStyle: { "margin-bottom": "10px" }
                        },
                        [
                          _c("div", { staticClass: "text-center" }, [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-primary btn-sm",
                                attrs: { type: "button" },
                                on: { click: _vm.continuar }
                              },
                              [
                                _vm._v("Continuar "),
                                _c("i", { staticClass: "fas fa-arrow-right" })
                              ]
                            )
                          ])
                        ]
                      )
                    ])
                  ]
                )
              ]
            )
          ]
        )
      ])
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "text-center" }, [
      _c(
        "p",
        {
          staticStyle: {
            color: "#4272d7",
            "font-size": "26px",
            "font-family": "cursive"
          }
        },
        [_c("u", [_vm._v("Objetos")])]
      )
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-295b482a", module.exports)
  }
}

/***/ }),
/* 52 */
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "container", staticStyle: { "margin-top": "-40px" } },
    [
      _c("div", { staticClass: "card" }, [
        _c(
          "div",
          {
            staticClass: "card-body",
            staticStyle: { background: "url('../../../../local/fondo6.png')" }
          },
          [
            _c("div", { staticClass: "container" }, [
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-md-12" }, [
                  _vm.editar == false
                    ? _c(
                        "button",
                        {
                          staticClass: "btn btn-warning btn-sm",
                          on: {
                            click: function($event) {
                              _vm.editar = true
                            }
                          }
                        },
                        [_vm._v("Editar")]
                      )
                    : _c(
                        "button",
                        {
                          staticClass: "btn btn-primary btn-sm",
                          on: {
                            click: function($event) {
                              _vm.editar = false
                            }
                          }
                        },
                        [_vm._v("Editar")]
                      )
                ]),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "col-md-2",
                    staticStyle: {
                      "overflow-y": "auto",
                      margin: "0",
                      padding: "0",
                      height: "800px"
                    }
                  },
                  [
                    _vm._l(_vm.objetos, function(item) {
                      return [
                        _c("div", { staticClass: "text-center" }, [
                          _c(
                            "div",
                            {
                              staticClass: "card-mio",
                              on: {
                                click: function($event) {
                                  _vm.nuevocoroto(item.img)
                                }
                              }
                            },
                            [
                              _c(
                                "h5",
                                {
                                  staticClass: "title-card letra",
                                  staticStyle: { color: "#171a1d" }
                                },
                                [_vm._v(_vm._s(item.name))]
                              ),
                              _vm._v(" "),
                              _c("h6", {
                                staticClass: "card-price letra",
                                staticStyle: { color: "#171a1d" }
                              }),
                              _vm._v(" "),
                              _c(
                                "div",
                                {
                                  staticClass: "card-img-wrap",
                                  staticStyle: {
                                    "box-shadow":
                                      "0px 0px 6px 0px rgba(0,0,0,0.75)"
                                  }
                                },
                                [
                                  _c("img", {
                                    staticClass: "img-card",
                                    attrs: {
                                      src: "../../../../local/" + item.img,
                                      alt: ""
                                    }
                                  })
                                ]
                              )
                            ]
                          )
                        ])
                      ]
                    })
                  ],
                  2
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    staticClass: "col-md-10",
                    staticStyle: {
                      background: "url('../../../../local/fondo7.png')",
                      height: "800px"
                    }
                  },
                  [
                    _vm._l(_vm.corotos, function(item) {
                      return [
                        _c("VueDragResize", {
                          attrs: {
                            parentLimitation: true,
                            aspectRatio: true,
                            isActive: _vm.editar,
                            w: item.width,
                            h: item.height,
                            isResizable: _vm.editar,
                            isDraggable: _vm.editar
                          },
                          on: { resizing: _vm.resize, dragging: _vm.resize }
                        })
                      ]
                    }),
                    _vm._v(" "),
                    _c(
                      "tabs",
                      [
                        _c("tab", { attrs: { name: "Nueva Pestana" } }, [
                          _vm._v(
                            "\n                                sfasfasdf\n                            "
                          )
                        ]),
                        _vm._v(" "),
                        _vm._l(_vm.areas, function(item) {
                          return [
                            _c("tab", { attrs: { name: item.name } }, [
                              _vm._v(
                                "\n                                    First tab content\n                                "
                              )
                            ])
                          ]
                        })
                      ],
                      2
                    )
                  ],
                  2
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", {
              staticClass: "container",
              staticStyle: { "margin-top": "40px" }
            })
          ]
        )
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1c755c28", module.exports)
  }
}

/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

(function () {
  "use strict";

  if (!Array.from) {
    Array.from = function (object) {
      return [].slice.call(object);
    };
  }

  function buildAttribute(object, propName, value) {
    if (value == undefined) {
      return object;
    }
    object = object == null ? {} : object;
    object[propName] = value;
    return object;
  }

  function buildDraggable(Sortable) {
    function removeNode(node) {
      node.parentElement.removeChild(node);
    }

    function insertNodeAt(fatherNode, node, position) {
      var refNode = position === 0 ? fatherNode.children[0] : fatherNode.children[position - 1].nextSibling;
      fatherNode.insertBefore(node, refNode);
    }

    function computeVmIndex(vnodes, element) {
      return vnodes.map(function (elt) {
        return elt.elm;
      }).indexOf(element);
    }

    function _computeIndexes(slots, children, isTransition) {
      if (!slots) {
        return [];
      }

      var elmFromNodes = slots.map(function (elt) {
        return elt.elm;
      });
      var rawIndexes = [].concat(_toConsumableArray(children)).map(function (elt) {
        return elmFromNodes.indexOf(elt);
      });
      return isTransition ? rawIndexes.filter(function (ind) {
        return ind !== -1;
      }) : rawIndexes;
    }

    function emit(evtName, evtData) {
      var _this = this;

      this.$nextTick(function () {
        return _this.$emit(evtName.toLowerCase(), evtData);
      });
    }

    function delegateAndEmit(evtName) {
      var _this2 = this;

      return function (evtData) {
        if (_this2.realList !== null) {
          _this2['onDrag' + evtName](evtData);
        }
        emit.call(_this2, evtName, evtData);
      };
    }

    var eventsListened = ['Start', 'Add', 'Remove', 'Update', 'End'];
    var eventsToEmit = ['Choose', 'Sort', 'Filter', 'Clone'];
    var readonlyProperties = ['Move'].concat(eventsListened, eventsToEmit).map(function (evt) {
      return 'on' + evt;
    });
    var draggingElement = null;

    var props = {
      options: Object,
      list: {
        type: Array,
        required: false,
        default: null
      },
      value: {
        type: Array,
        required: false,
        default: null
      },
      noTransitionOnDrag: {
        type: Boolean,
        default: false
      },
      clone: {
        type: Function,
        default: function _default(original) {
          return original;
        }
      },
      element: {
        type: String,
        default: 'div'
      },
      move: {
        type: Function,
        default: null
      },
      componentData: {
        type: Object,
        required: false,
        default: null
      }
    };

    var draggableComponent = {
      name: 'draggable',

      props: props,

      data: function data() {
        return {
          transitionMode: false,
          noneFunctionalComponentMode: false,
          init: false
        };
      },
      render: function render(h) {
        var slots = this.$slots.default;
        if (slots && slots.length === 1) {
          var child = slots[0];
          if (child.componentOptions && child.componentOptions.tag === "transition-group") {
            this.transitionMode = true;
          }
        }
        var headerOffset = 0;
        var children = slots;
        var _$slots = this.$slots,
            header = _$slots.header,
            footer = _$slots.footer;

        if (header) {
          headerOffset = header.length;
          children = children ? [].concat(_toConsumableArray(header), _toConsumableArray(children)) : [].concat(_toConsumableArray(header));
        }
        if (footer) {
          children = children ? [].concat(_toConsumableArray(children), _toConsumableArray(footer)) : [].concat(_toConsumableArray(footer));
        }
        this.headerOffset = headerOffset;
        var attributes = null;
        var update = function update(name, value) {
          attributes = buildAttribute(attributes, name, value);
        };
        update('attrs', this.$attrs);
        if (this.componentData) {
          var _componentData = this.componentData,
              on = _componentData.on,
              _props = _componentData.props;

          update('on', on);
          update('props', _props);
        }
        return h(this.element, attributes, children);
      },
      mounted: function mounted() {
        var _this3 = this;

        this.noneFunctionalComponentMode = this.element.toLowerCase() !== this.$el.nodeName.toLowerCase();
        if (this.noneFunctionalComponentMode && this.transitionMode) {
          throw new Error('Transition-group inside component is not supported. Please alter element value or remove transition-group. Current element value: ' + this.element);
        }
        var optionsAdded = {};
        eventsListened.forEach(function (elt) {
          optionsAdded['on' + elt] = delegateAndEmit.call(_this3, elt);
        });

        eventsToEmit.forEach(function (elt) {
          optionsAdded['on' + elt] = emit.bind(_this3, elt);
        });

        var options = _extends({}, this.options, optionsAdded, { onMove: function onMove(evt, originalEvent) {
            return _this3.onDragMove(evt, originalEvent);
          } });
        !('draggable' in options) && (options.draggable = '>*');
        this._sortable = new Sortable(this.rootContainer, options);
        this.computeIndexes();
      },
      beforeDestroy: function beforeDestroy() {
        if (this._sortable !== undefined) this._sortable.destroy();
      },


      computed: {
        rootContainer: function rootContainer() {
          return this.transitionMode ? this.$el.children[0] : this.$el;
        },
        isCloning: function isCloning() {
          return !!this.options && !!this.options.group && this.options.group.pull === 'clone';
        },
        realList: function realList() {
          return !!this.list ? this.list : this.value;
        }
      },

      watch: {
        options: {
          handler: function handler(newOptionValue) {
            for (var property in newOptionValue) {
              if (readonlyProperties.indexOf(property) == -1) {
                this._sortable.option(property, newOptionValue[property]);
              }
            }
          },

          deep: true
        },

        realList: function realList() {
          this.computeIndexes();
        }
      },

      methods: {
        getChildrenNodes: function getChildrenNodes() {
          if (!this.init) {
            this.noneFunctionalComponentMode = this.noneFunctionalComponentMode && this.$children.length == 1;
            this.init = true;
          }

          if (this.noneFunctionalComponentMode) {
            return this.$children[0].$slots.default;
          }
          var rawNodes = this.$slots.default;
          return this.transitionMode ? rawNodes[0].child.$slots.default : rawNodes;
        },
        computeIndexes: function computeIndexes() {
          var _this4 = this;

          this.$nextTick(function () {
            _this4.visibleIndexes = _computeIndexes(_this4.getChildrenNodes(), _this4.rootContainer.children, _this4.transitionMode);
          });
        },
        getUnderlyingVm: function getUnderlyingVm(htmlElt) {
          var index = computeVmIndex(this.getChildrenNodes() || [], htmlElt);
          if (index === -1) {
            //Edge case during move callback: related element might be
            //an element different from collection
            return null;
          }
          var element = this.realList[index];
          return { index: index, element: element };
        },
        getUnderlyingPotencialDraggableComponent: function getUnderlyingPotencialDraggableComponent(_ref) {
          var __vue__ = _ref.__vue__;

          if (!__vue__ || !__vue__.$options || __vue__.$options._componentTag !== "transition-group") {
            return __vue__;
          }
          return __vue__.$parent;
        },
        emitChanges: function emitChanges(evt) {
          var _this5 = this;

          this.$nextTick(function () {
            _this5.$emit('change', evt);
          });
        },
        alterList: function alterList(onList) {
          if (!!this.list) {
            onList(this.list);
          } else {
            var newList = [].concat(_toConsumableArray(this.value));
            onList(newList);
            this.$emit('input', newList);
          }
        },
        spliceList: function spliceList() {
          var _arguments = arguments;

          var spliceList = function spliceList(list) {
            return list.splice.apply(list, _arguments);
          };
          this.alterList(spliceList);
        },
        updatePosition: function updatePosition(oldIndex, newIndex) {
          var updatePosition = function updatePosition(list) {
            return list.splice(newIndex, 0, list.splice(oldIndex, 1)[0]);
          };
          this.alterList(updatePosition);
        },
        getRelatedContextFromMoveEvent: function getRelatedContextFromMoveEvent(_ref2) {
          var to = _ref2.to,
              related = _ref2.related;

          var component = this.getUnderlyingPotencialDraggableComponent(to);
          if (!component) {
            return { component: component };
          }
          var list = component.realList;
          var context = { list: list, component: component };
          if (to !== related && list && component.getUnderlyingVm) {
            var destination = component.getUnderlyingVm(related);
            if (destination) {
              return _extends(destination, context);
            }
          }

          return context;
        },
        getVmIndex: function getVmIndex(domIndex) {
          var indexes = this.visibleIndexes;
          var numberIndexes = indexes.length;
          return domIndex > numberIndexes - 1 ? numberIndexes : indexes[domIndex];
        },
        getComponent: function getComponent() {
          return this.$slots.default[0].componentInstance;
        },
        resetTransitionData: function resetTransitionData(index) {
          if (!this.noTransitionOnDrag || !this.transitionMode) {
            return;
          }
          var nodes = this.getChildrenNodes();
          nodes[index].data = null;
          var transitionContainer = this.getComponent();
          transitionContainer.children = [];
          transitionContainer.kept = undefined;
        },
        onDragStart: function onDragStart(evt) {
          this.context = this.getUnderlyingVm(evt.item);
          evt.item._underlying_vm_ = this.clone(this.context.element);
          draggingElement = evt.item;
        },
        onDragAdd: function onDragAdd(evt) {
          this.updateEvenemt(evt);
          var element = evt.item._underlying_vm_;
          if (element === undefined) {
            return;
          }
          removeNode(evt.item);
          var newIndex = this.getVmIndex(evt.newIndex);
          this.spliceList(newIndex, 0, element);
          this.computeIndexes();
          var added = { element: element, newIndex: newIndex };
          this.emitChanges({ added: added });
        },
        onDragRemove: function onDragRemove(evt) {
          this.updateEvenemt(evt);
          insertNodeAt(this.rootContainer, evt.item, evt.oldIndex);
          if (this.isCloning) {
            removeNode(evt.clone);
            return;
          }
          var oldIndex = this.context.index;
          this.spliceList(oldIndex, 1);
          var removed = { element: this.context.element, oldIndex: oldIndex };
          this.resetTransitionData(oldIndex);
          this.emitChanges({ removed: removed });
        },
        onDragUpdate: function onDragUpdate(evt) {
          this.updateEvenemt(evt);
          removeNode(evt.item);
          insertNodeAt(evt.from, evt.item, evt.oldIndex);
          var oldIndex = this.context.index;
          var newIndex = this.getVmIndex(evt.newIndex);
          this.updatePosition(oldIndex, newIndex);
          var moved = { element: this.context.element, oldIndex: oldIndex, newIndex: newIndex };
          this.emitChanges({ moved: moved });
        },
        updateEvenemt: function updateEvenemt(evt) {
          this.updateProperty(evt, 'newIndex');
          this.updateProperty(evt, 'oldIndex');
        },
        updateProperty: function updateProperty(evt, propertyName) {
          evt.hasOwnProperty(propertyName) && (evt[propertyName] += this.headerOffset);
        },
        computeFutureIndex: function computeFutureIndex(relatedContext, evt) {
          if (!relatedContext.element) {
            return 0;
          }
          var domChildren = [].concat(_toConsumableArray(evt.to.children)).filter(function (el) {
            return el.style['display'] !== 'none';
          });
          var currentDOMIndex = domChildren.indexOf(evt.related);
          var currentIndex = relatedContext.component.getVmIndex(currentDOMIndex);
          var draggedInList = domChildren.indexOf(draggingElement) != -1;
          return draggedInList || !evt.willInsertAfter ? currentIndex : currentIndex + 1;
        },
        onDragMove: function onDragMove(evt, originalEvent) {
          var onMove = this.move;
          if (!onMove || !this.realList) {
            return true;
          }

          var relatedContext = this.getRelatedContextFromMoveEvent(evt);
          var draggedContext = this.context;
          var futureIndex = this.computeFutureIndex(relatedContext, evt);
          _extends(draggedContext, { futureIndex: futureIndex });
          _extends(evt, { relatedContext: relatedContext, draggedContext: draggedContext });
          return onMove(evt, originalEvent);
        },
        onDragEnd: function onDragEnd(evt) {
          this.computeIndexes();
          draggingElement = null;
        }
      }
    };
    return draggableComponent;
  }

  if (true) {
    var Sortable = __webpack_require__(54);
    module.exports = buildDraggable(Sortable);
  } else if (typeof define == "function" && define.amd) {
    define(['sortablejs'], function (Sortable) {
      return buildDraggable(Sortable);
    });
  } else if (window && window.Vue && window.Sortable) {
    var draggable = buildDraggable(window.Sortable);
    Vue.component('draggable', draggable);
  }
})();

/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/**!
 * Sortable
 * @author	RubaXa   <trash@rubaxa.org>
 * @license MIT
 */

(function sortableModule(factory) {
	"use strict";

	if (true) {
		!(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	}
	else if (typeof module != "undefined" && typeof module.exports != "undefined") {
		module.exports = factory();
	}
	else {
		/* jshint sub:true */
		window["Sortable"] = factory();
	}
})(function sortableFactory() {
	"use strict";

	if (typeof window === "undefined" || !window.document) {
		return function sortableError() {
			throw new Error("Sortable.js requires a window with a document");
		};
	}

	var dragEl,
		parentEl,
		ghostEl,
		cloneEl,
		rootEl,
		nextEl,
		lastDownEl,

		scrollEl,
		scrollParentEl,
		scrollCustomFn,

		lastEl,
		lastCSS,
		lastParentCSS,

		oldIndex,
		newIndex,

		activeGroup,
		putSortable,

		autoScroll = {},

		tapEvt,
		touchEvt,

		moved,

		/** @const */
		R_SPACE = /\s+/g,
		R_FLOAT = /left|right|inline/,

		expando = 'Sortable' + (new Date).getTime(),

		win = window,
		document = win.document,
		parseInt = win.parseInt,
		setTimeout = win.setTimeout,

		$ = win.jQuery || win.Zepto,
		Polymer = win.Polymer,

		captureMode = false,
		passiveMode = false,

		supportDraggable = ('draggable' in document.createElement('div')),
		supportCssPointerEvents = (function (el) {
			// false when IE11
			if (!!navigator.userAgent.match(/(?:Trident.*rv[ :]?11\.|msie)/i)) {
				return false;
			}
			el = document.createElement('x');
			el.style.cssText = 'pointer-events:auto';
			return el.style.pointerEvents === 'auto';
		})(),

		_silent = false,

		abs = Math.abs,
		min = Math.min,

		savedInputChecked = [],
		touchDragOverListeners = [],

		_autoScroll = _throttle(function (/**Event*/evt, /**Object*/options, /**HTMLElement*/rootEl) {
			// Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=505521
			if (rootEl && options.scroll) {
				var _this = rootEl[expando],
					el,
					rect,
					sens = options.scrollSensitivity,
					speed = options.scrollSpeed,

					x = evt.clientX,
					y = evt.clientY,

					winWidth = window.innerWidth,
					winHeight = window.innerHeight,

					vx,
					vy,

					scrollOffsetX,
					scrollOffsetY
				;

				// Delect scrollEl
				if (scrollParentEl !== rootEl) {
					scrollEl = options.scroll;
					scrollParentEl = rootEl;
					scrollCustomFn = options.scrollFn;

					if (scrollEl === true) {
						scrollEl = rootEl;

						do {
							if ((scrollEl.offsetWidth < scrollEl.scrollWidth) ||
								(scrollEl.offsetHeight < scrollEl.scrollHeight)
							) {
								break;
							}
							/* jshint boss:true */
						} while (scrollEl = scrollEl.parentNode);
					}
				}

				if (scrollEl) {
					el = scrollEl;
					rect = scrollEl.getBoundingClientRect();
					vx = (abs(rect.right - x) <= sens) - (abs(rect.left - x) <= sens);
					vy = (abs(rect.bottom - y) <= sens) - (abs(rect.top - y) <= sens);
				}


				if (!(vx || vy)) {
					vx = (winWidth - x <= sens) - (x <= sens);
					vy = (winHeight - y <= sens) - (y <= sens);

					/* jshint expr:true */
					(vx || vy) && (el = win);
				}


				if (autoScroll.vx !== vx || autoScroll.vy !== vy || autoScroll.el !== el) {
					autoScroll.el = el;
					autoScroll.vx = vx;
					autoScroll.vy = vy;

					clearInterval(autoScroll.pid);

					if (el) {
						autoScroll.pid = setInterval(function () {
							scrollOffsetY = vy ? vy * speed : 0;
							scrollOffsetX = vx ? vx * speed : 0;

							if ('function' === typeof(scrollCustomFn)) {
								return scrollCustomFn.call(_this, scrollOffsetX, scrollOffsetY, evt);
							}

							if (el === win) {
								win.scrollTo(win.pageXOffset + scrollOffsetX, win.pageYOffset + scrollOffsetY);
							} else {
								el.scrollTop += scrollOffsetY;
								el.scrollLeft += scrollOffsetX;
							}
						}, 24);
					}
				}
			}
		}, 30),

		_prepareGroup = function (options) {
			function toFn(value, pull) {
				if (value === void 0 || value === true) {
					value = group.name;
				}

				if (typeof value === 'function') {
					return value;
				} else {
					return function (to, from) {
						var fromGroup = from.options.group.name;

						return pull
							? value
							: value && (value.join
								? value.indexOf(fromGroup) > -1
								: (fromGroup == value)
							);
					};
				}
			}

			var group = {};
			var originalGroup = options.group;

			if (!originalGroup || typeof originalGroup != 'object') {
				originalGroup = {name: originalGroup};
			}

			group.name = originalGroup.name;
			group.checkPull = toFn(originalGroup.pull, true);
			group.checkPut = toFn(originalGroup.put);
			group.revertClone = originalGroup.revertClone;

			options.group = group;
		}
	;

	// Detect support a passive mode
	try {
		window.addEventListener('test', null, Object.defineProperty({}, 'passive', {
			get: function () {
				// `false`, because everything starts to work incorrectly and instead of d'n'd,
				// begins the page has scrolled.
				passiveMode = false;
				captureMode = {
					capture: false,
					passive: passiveMode
				};
			}
		}));
	} catch (err) {}

	/**
	 * @class  Sortable
	 * @param  {HTMLElement}  el
	 * @param  {Object}       [options]
	 */
	function Sortable(el, options) {
		if (!(el && el.nodeType && el.nodeType === 1)) {
			throw 'Sortable: `el` must be HTMLElement, and not ' + {}.toString.call(el);
		}

		this.el = el; // root element
		this.options = options = _extend({}, options);


		// Export instance
		el[expando] = this;

		// Default options
		var defaults = {
			group: Math.random(),
			sort: true,
			disabled: false,
			store: null,
			handle: null,
			scroll: true,
			scrollSensitivity: 30,
			scrollSpeed: 10,
			draggable: /[uo]l/i.test(el.nodeName) ? 'li' : '>*',
			ghostClass: 'sortable-ghost',
			chosenClass: 'sortable-chosen',
			dragClass: 'sortable-drag',
			ignore: 'a, img',
			filter: null,
			preventOnFilter: true,
			animation: 0,
			setData: function (dataTransfer, dragEl) {
				dataTransfer.setData('Text', dragEl.textContent);
			},
			dropBubble: false,
			dragoverBubble: false,
			dataIdAttr: 'data-id',
			delay: 0,
			forceFallback: false,
			fallbackClass: 'sortable-fallback',
			fallbackOnBody: false,
			fallbackTolerance: 0,
			fallbackOffset: {x: 0, y: 0},
			supportPointer: Sortable.supportPointer !== false
		};


		// Set default options
		for (var name in defaults) {
			!(name in options) && (options[name] = defaults[name]);
		}

		_prepareGroup(options);

		// Bind all private methods
		for (var fn in this) {
			if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
				this[fn] = this[fn].bind(this);
			}
		}

		// Setup drag mode
		this.nativeDraggable = options.forceFallback ? false : supportDraggable;

		// Bind events
		_on(el, 'mousedown', this._onTapStart);
		_on(el, 'touchstart', this._onTapStart);
		options.supportPointer && _on(el, 'pointerdown', this._onTapStart);

		if (this.nativeDraggable) {
			_on(el, 'dragover', this);
			_on(el, 'dragenter', this);
		}

		touchDragOverListeners.push(this._onDragOver);

		// Restore sorting
		options.store && this.sort(options.store.get(this));
	}


	Sortable.prototype = /** @lends Sortable.prototype */ {
		constructor: Sortable,

		_onTapStart: function (/** Event|TouchEvent */evt) {
			var _this = this,
				el = this.el,
				options = this.options,
				preventOnFilter = options.preventOnFilter,
				type = evt.type,
				touch = evt.touches && evt.touches[0],
				target = (touch || evt).target,
				originalTarget = evt.target.shadowRoot && (evt.path && evt.path[0]) || target,
				filter = options.filter,
				startIndex;

			_saveInputCheckedState(el);


			// Don't trigger start event when an element is been dragged, otherwise the evt.oldindex always wrong when set option.group.
			if (dragEl) {
				return;
			}

			if (/mousedown|pointerdown/.test(type) && evt.button !== 0 || options.disabled) {
				return; // only left button or enabled
			}

			// cancel dnd if original target is content editable
			if (originalTarget.isContentEditable) {
				return;
			}

			target = _closest(target, options.draggable, el);

			if (!target) {
				return;
			}

			if (lastDownEl === target) {
				// Ignoring duplicate `down`
				return;
			}

			// Get the index of the dragged element within its parent
			startIndex = _index(target, options.draggable);

			// Check filter
			if (typeof filter === 'function') {
				if (filter.call(this, evt, target, this)) {
					_dispatchEvent(_this, originalTarget, 'filter', target, el, el, startIndex);
					preventOnFilter && evt.preventDefault();
					return; // cancel dnd
				}
			}
			else if (filter) {
				filter = filter.split(',').some(function (criteria) {
					criteria = _closest(originalTarget, criteria.trim(), el);

					if (criteria) {
						_dispatchEvent(_this, criteria, 'filter', target, el, el, startIndex);
						return true;
					}
				});

				if (filter) {
					preventOnFilter && evt.preventDefault();
					return; // cancel dnd
				}
			}

			if (options.handle && !_closest(originalTarget, options.handle, el)) {
				return;
			}

			// Prepare `dragstart`
			this._prepareDragStart(evt, touch, target, startIndex);
		},

		_prepareDragStart: function (/** Event */evt, /** Touch */touch, /** HTMLElement */target, /** Number */startIndex) {
			var _this = this,
				el = _this.el,
				options = _this.options,
				ownerDocument = el.ownerDocument,
				dragStartFn;

			if (target && !dragEl && (target.parentNode === el)) {
				tapEvt = evt;

				rootEl = el;
				dragEl = target;
				parentEl = dragEl.parentNode;
				nextEl = dragEl.nextSibling;
				lastDownEl = target;
				activeGroup = options.group;
				oldIndex = startIndex;

				this._lastX = (touch || evt).clientX;
				this._lastY = (touch || evt).clientY;

				dragEl.style['will-change'] = 'all';

				dragStartFn = function () {
					// Delayed drag has been triggered
					// we can re-enable the events: touchmove/mousemove
					_this._disableDelayedDrag();

					// Make the element draggable
					dragEl.draggable = _this.nativeDraggable;

					// Chosen item
					_toggleClass(dragEl, options.chosenClass, true);

					// Bind the events: dragstart/dragend
					_this._triggerDragStart(evt, touch);

					// Drag start event
					_dispatchEvent(_this, rootEl, 'choose', dragEl, rootEl, rootEl, oldIndex);
				};

				// Disable "draggable"
				options.ignore.split(',').forEach(function (criteria) {
					_find(dragEl, criteria.trim(), _disableDraggable);
				});

				_on(ownerDocument, 'mouseup', _this._onDrop);
				_on(ownerDocument, 'touchend', _this._onDrop);
				_on(ownerDocument, 'touchcancel', _this._onDrop);
				_on(ownerDocument, 'selectstart', _this);
				options.supportPointer && _on(ownerDocument, 'pointercancel', _this._onDrop);

				if (options.delay) {
					// If the user moves the pointer or let go the click or touch
					// before the delay has been reached:
					// disable the delayed drag
					_on(ownerDocument, 'mouseup', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchend', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchcancel', _this._disableDelayedDrag);
					_on(ownerDocument, 'mousemove', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchmove', _this._disableDelayedDrag);
					options.supportPointer && _on(ownerDocument, 'pointermove', _this._disableDelayedDrag);

					_this._dragStartTimer = setTimeout(dragStartFn, options.delay);
				} else {
					dragStartFn();
				}


			}
		},

		_disableDelayedDrag: function () {
			var ownerDocument = this.el.ownerDocument;

			clearTimeout(this._dragStartTimer);
			_off(ownerDocument, 'mouseup', this._disableDelayedDrag);
			_off(ownerDocument, 'touchend', this._disableDelayedDrag);
			_off(ownerDocument, 'touchcancel', this._disableDelayedDrag);
			_off(ownerDocument, 'mousemove', this._disableDelayedDrag);
			_off(ownerDocument, 'touchmove', this._disableDelayedDrag);
			_off(ownerDocument, 'pointermove', this._disableDelayedDrag);
		},

		_triggerDragStart: function (/** Event */evt, /** Touch */touch) {
			touch = touch || (evt.pointerType == 'touch' ? evt : null);

			if (touch) {
				// Touch device support
				tapEvt = {
					target: dragEl,
					clientX: touch.clientX,
					clientY: touch.clientY
				};

				this._onDragStart(tapEvt, 'touch');
			}
			else if (!this.nativeDraggable) {
				this._onDragStart(tapEvt, true);
			}
			else {
				_on(dragEl, 'dragend', this);
				_on(rootEl, 'dragstart', this._onDragStart);
			}

			try {
				if (document.selection) {
					// Timeout neccessary for IE9
					_nextTick(function () {
						document.selection.empty();
					});
				} else {
					window.getSelection().removeAllRanges();
				}
			} catch (err) {
			}
		},

		_dragStarted: function () {
			if (rootEl && dragEl) {
				var options = this.options;

				// Apply effect
				_toggleClass(dragEl, options.ghostClass, true);
				_toggleClass(dragEl, options.dragClass, false);

				Sortable.active = this;

				// Drag start event
				_dispatchEvent(this, rootEl, 'start', dragEl, rootEl, rootEl, oldIndex);
			} else {
				this._nulling();
			}
		},

		_emulateDragOver: function () {
			if (touchEvt) {
				if (this._lastX === touchEvt.clientX && this._lastY === touchEvt.clientY) {
					return;
				}

				this._lastX = touchEvt.clientX;
				this._lastY = touchEvt.clientY;

				if (!supportCssPointerEvents) {
					_css(ghostEl, 'display', 'none');
				}

				var target = document.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
				var parent = target;
				var i = touchDragOverListeners.length;

				if (target && target.shadowRoot) {
					target = target.shadowRoot.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
					parent = target;
				}

				if (parent) {
					do {
						if (parent[expando]) {
							while (i--) {
								touchDragOverListeners[i]({
									clientX: touchEvt.clientX,
									clientY: touchEvt.clientY,
									target: target,
									rootEl: parent
								});
							}

							break;
						}

						target = parent; // store last element
					}
					/* jshint boss:true */
					while (parent = parent.parentNode);
				}

				if (!supportCssPointerEvents) {
					_css(ghostEl, 'display', '');
				}
			}
		},


		_onTouchMove: function (/**TouchEvent*/evt) {
			if (tapEvt) {
				var	options = this.options,
					fallbackTolerance = options.fallbackTolerance,
					fallbackOffset = options.fallbackOffset,
					touch = evt.touches ? evt.touches[0] : evt,
					dx = (touch.clientX - tapEvt.clientX) + fallbackOffset.x,
					dy = (touch.clientY - tapEvt.clientY) + fallbackOffset.y,
					translate3d = evt.touches ? 'translate3d(' + dx + 'px,' + dy + 'px,0)' : 'translate(' + dx + 'px,' + dy + 'px)';

				// only set the status to dragging, when we are actually dragging
				if (!Sortable.active) {
					if (fallbackTolerance &&
						min(abs(touch.clientX - this._lastX), abs(touch.clientY - this._lastY)) < fallbackTolerance
					) {
						return;
					}

					this._dragStarted();
				}

				// as well as creating the ghost element on the document body
				this._appendGhost();

				moved = true;
				touchEvt = touch;

				_css(ghostEl, 'webkitTransform', translate3d);
				_css(ghostEl, 'mozTransform', translate3d);
				_css(ghostEl, 'msTransform', translate3d);
				_css(ghostEl, 'transform', translate3d);

				evt.preventDefault();
			}
		},

		_appendGhost: function () {
			if (!ghostEl) {
				var rect = dragEl.getBoundingClientRect(),
					css = _css(dragEl),
					options = this.options,
					ghostRect;

				ghostEl = dragEl.cloneNode(true);

				_toggleClass(ghostEl, options.ghostClass, false);
				_toggleClass(ghostEl, options.fallbackClass, true);
				_toggleClass(ghostEl, options.dragClass, true);

				_css(ghostEl, 'top', rect.top - parseInt(css.marginTop, 10));
				_css(ghostEl, 'left', rect.left - parseInt(css.marginLeft, 10));
				_css(ghostEl, 'width', rect.width);
				_css(ghostEl, 'height', rect.height);
				_css(ghostEl, 'opacity', '0.8');
				_css(ghostEl, 'position', 'fixed');
				_css(ghostEl, 'zIndex', '100000');
				_css(ghostEl, 'pointerEvents', 'none');

				options.fallbackOnBody && document.body.appendChild(ghostEl) || rootEl.appendChild(ghostEl);

				// Fixing dimensions.
				ghostRect = ghostEl.getBoundingClientRect();
				_css(ghostEl, 'width', rect.width * 2 - ghostRect.width);
				_css(ghostEl, 'height', rect.height * 2 - ghostRect.height);
			}
		},

		_onDragStart: function (/**Event*/evt, /**boolean*/useFallback) {
			var _this = this;
			var dataTransfer = evt.dataTransfer;
			var options = _this.options;

			_this._offUpEvents();

			if (activeGroup.checkPull(_this, _this, dragEl, evt)) {
				cloneEl = _clone(dragEl);

				cloneEl.draggable = false;
				cloneEl.style['will-change'] = '';

				_css(cloneEl, 'display', 'none');
				_toggleClass(cloneEl, _this.options.chosenClass, false);

				// #1143: IFrame support workaround
				_this._cloneId = _nextTick(function () {
					rootEl.insertBefore(cloneEl, dragEl);
					_dispatchEvent(_this, rootEl, 'clone', dragEl);
				});
			}

			_toggleClass(dragEl, options.dragClass, true);

			if (useFallback) {
				if (useFallback === 'touch') {
					// Bind touch events
					_on(document, 'touchmove', _this._onTouchMove);
					_on(document, 'touchend', _this._onDrop);
					_on(document, 'touchcancel', _this._onDrop);

					if (options.supportPointer) {
						_on(document, 'pointermove', _this._onTouchMove);
						_on(document, 'pointerup', _this._onDrop);
					}
				} else {
					// Old brwoser
					_on(document, 'mousemove', _this._onTouchMove);
					_on(document, 'mouseup', _this._onDrop);
				}

				_this._loopId = setInterval(_this._emulateDragOver, 50);
			}
			else {
				if (dataTransfer) {
					dataTransfer.effectAllowed = 'move';
					options.setData && options.setData.call(_this, dataTransfer, dragEl);
				}

				_on(document, 'drop', _this);

				// #1143: Бывает элемент с IFrame внутри блокирует `drop`,
				// поэтому если вызвался `mouseover`, значит надо отменять весь d'n'd.
				// Breaking Chrome 62+
				// _on(document, 'mouseover', _this);

				_this._dragStartId = _nextTick(_this._dragStarted);
			}
		},

		_onDragOver: function (/**Event*/evt) {
			var el = this.el,
				target,
				dragRect,
				targetRect,
				revert,
				options = this.options,
				group = options.group,
				activeSortable = Sortable.active,
				isOwner = (activeGroup === group),
				isMovingBetweenSortable = false,
				canSort = options.sort;

			if (evt.preventDefault !== void 0) {
				evt.preventDefault();
				!options.dragoverBubble && evt.stopPropagation();
			}

			if (dragEl.animated) {
				return;
			}

			moved = true;

			if (activeSortable && !options.disabled &&
				(isOwner
					? canSort || (revert = !rootEl.contains(dragEl)) // Reverting item into the original list
					: (
						putSortable === this ||
						(
							(activeSortable.lastPullMode = activeGroup.checkPull(this, activeSortable, dragEl, evt)) &&
							group.checkPut(this, activeSortable, dragEl, evt)
						)
					)
				) &&
				(evt.rootEl === void 0 || evt.rootEl === this.el) // touch fallback
			) {
				// Smart auto-scrolling
				_autoScroll(evt, options, this.el);

				if (_silent) {
					return;
				}

				target = _closest(evt.target, options.draggable, el);
				dragRect = dragEl.getBoundingClientRect();

				if (putSortable !== this) {
					putSortable = this;
					isMovingBetweenSortable = true;
				}

				if (revert) {
					_cloneHide(activeSortable, true);
					parentEl = rootEl; // actualization

					if (cloneEl || nextEl) {
						rootEl.insertBefore(dragEl, cloneEl || nextEl);
					}
					else if (!canSort) {
						rootEl.appendChild(dragEl);
					}

					return;
				}


				if ((el.children.length === 0) || (el.children[0] === ghostEl) ||
					(el === evt.target) && (_ghostIsLast(el, evt))
				) {
					//assign target only if condition is true
					if (el.children.length !== 0 && el.children[0] !== ghostEl && el === evt.target) {
						target = el.lastElementChild;
					}

					if (target) {
						if (target.animated) {
							return;
						}

						targetRect = target.getBoundingClientRect();
					}

					_cloneHide(activeSortable, isOwner);

					if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt) !== false) {
						if (!dragEl.contains(el)) {
							el.appendChild(dragEl);
							parentEl = el; // actualization
						}

						this._animate(dragRect, dragEl);
						target && this._animate(targetRect, target);
					}
				}
				else if (target && !target.animated && target !== dragEl && (target.parentNode[expando] !== void 0)) {
					if (lastEl !== target) {
						lastEl = target;
						lastCSS = _css(target);
						lastParentCSS = _css(target.parentNode);
					}

					targetRect = target.getBoundingClientRect();

					var width = targetRect.right - targetRect.left,
						height = targetRect.bottom - targetRect.top,
						floating = R_FLOAT.test(lastCSS.cssFloat + lastCSS.display)
							|| (lastParentCSS.display == 'flex' && lastParentCSS['flex-direction'].indexOf('row') === 0),
						isWide = (target.offsetWidth > dragEl.offsetWidth),
						isLong = (target.offsetHeight > dragEl.offsetHeight),
						halfway = (floating ? (evt.clientX - targetRect.left) / width : (evt.clientY - targetRect.top) / height) > 0.5,
						nextSibling = target.nextElementSibling,
						after = false
					;

					if (floating) {
						var elTop = dragEl.offsetTop,
							tgTop = target.offsetTop;

						if (elTop === tgTop) {
							after = (target.previousElementSibling === dragEl) && !isWide || halfway && isWide;
						}
						else if (target.previousElementSibling === dragEl || dragEl.previousElementSibling === target) {
							after = (evt.clientY - targetRect.top) / height > 0.5;
						} else {
							after = tgTop > elTop;
						}
						} else if (!isMovingBetweenSortable) {
						after = (nextSibling !== dragEl) && !isLong || halfway && isLong;
					}

					var moveVector = _onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, after);

					if (moveVector !== false) {
						if (moveVector === 1 || moveVector === -1) {
							after = (moveVector === 1);
						}

						_silent = true;
						setTimeout(_unsilent, 30);

						_cloneHide(activeSortable, isOwner);

						if (!dragEl.contains(el)) {
							if (after && !nextSibling) {
								el.appendChild(dragEl);
							} else {
								target.parentNode.insertBefore(dragEl, after ? nextSibling : target);
							}
						}

						parentEl = dragEl.parentNode; // actualization

						this._animate(dragRect, dragEl);
						this._animate(targetRect, target);
					}
				}
			}
		},

		_animate: function (prevRect, target) {
			var ms = this.options.animation;

			if (ms) {
				var currentRect = target.getBoundingClientRect();

				if (prevRect.nodeType === 1) {
					prevRect = prevRect.getBoundingClientRect();
				}

				_css(target, 'transition', 'none');
				_css(target, 'transform', 'translate3d('
					+ (prevRect.left - currentRect.left) + 'px,'
					+ (prevRect.top - currentRect.top) + 'px,0)'
				);

				target.offsetWidth; // repaint

				_css(target, 'transition', 'all ' + ms + 'ms');
				_css(target, 'transform', 'translate3d(0,0,0)');

				clearTimeout(target.animated);
				target.animated = setTimeout(function () {
					_css(target, 'transition', '');
					_css(target, 'transform', '');
					target.animated = false;
				}, ms);
			}
		},

		_offUpEvents: function () {
			var ownerDocument = this.el.ownerDocument;

			_off(document, 'touchmove', this._onTouchMove);
			_off(document, 'pointermove', this._onTouchMove);
			_off(ownerDocument, 'mouseup', this._onDrop);
			_off(ownerDocument, 'touchend', this._onDrop);
			_off(ownerDocument, 'pointerup', this._onDrop);
			_off(ownerDocument, 'touchcancel', this._onDrop);
			_off(ownerDocument, 'pointercancel', this._onDrop);
			_off(ownerDocument, 'selectstart', this);
		},

		_onDrop: function (/**Event*/evt) {
			var el = this.el,
				options = this.options;

			clearInterval(this._loopId);
			clearInterval(autoScroll.pid);
			clearTimeout(this._dragStartTimer);

			_cancelNextTick(this._cloneId);
			_cancelNextTick(this._dragStartId);

			// Unbind events
			_off(document, 'mouseover', this);
			_off(document, 'mousemove', this._onTouchMove);

			if (this.nativeDraggable) {
				_off(document, 'drop', this);
				_off(el, 'dragstart', this._onDragStart);
			}

			this._offUpEvents();

			if (evt) {
				if (moved) {
					evt.preventDefault();
					!options.dropBubble && evt.stopPropagation();
				}

				ghostEl && ghostEl.parentNode && ghostEl.parentNode.removeChild(ghostEl);

				if (rootEl === parentEl || Sortable.active.lastPullMode !== 'clone') {
					// Remove clone
					cloneEl && cloneEl.parentNode && cloneEl.parentNode.removeChild(cloneEl);
				}

				if (dragEl) {
					if (this.nativeDraggable) {
						_off(dragEl, 'dragend', this);
					}

					_disableDraggable(dragEl);
					dragEl.style['will-change'] = '';

					// Remove class's
					_toggleClass(dragEl, this.options.ghostClass, false);
					_toggleClass(dragEl, this.options.chosenClass, false);

					// Drag stop event
					_dispatchEvent(this, rootEl, 'unchoose', dragEl, parentEl, rootEl, oldIndex);

					if (rootEl !== parentEl) {
						newIndex = _index(dragEl, options.draggable);

						if (newIndex >= 0) {
							// Add event
							_dispatchEvent(null, parentEl, 'add', dragEl, parentEl, rootEl, oldIndex, newIndex);

							// Remove event
							_dispatchEvent(this, rootEl, 'remove', dragEl, parentEl, rootEl, oldIndex, newIndex);

							// drag from one list and drop into another
							_dispatchEvent(null, parentEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
							_dispatchEvent(this, rootEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
						}
					}
					else {
						if (dragEl.nextSibling !== nextEl) {
							// Get the index of the dragged element within its parent
							newIndex = _index(dragEl, options.draggable);

							if (newIndex >= 0) {
								// drag & drop within the same list
								_dispatchEvent(this, rootEl, 'update', dragEl, parentEl, rootEl, oldIndex, newIndex);
								_dispatchEvent(this, rootEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
							}
						}
					}

					if (Sortable.active) {
						/* jshint eqnull:true */
						if (newIndex == null || newIndex === -1) {
							newIndex = oldIndex;
						}

						_dispatchEvent(this, rootEl, 'end', dragEl, parentEl, rootEl, oldIndex, newIndex);

						// Save sorting
						this.save();
					}
				}

			}

			this._nulling();
		},

		_nulling: function() {
			rootEl =
			dragEl =
			parentEl =
			ghostEl =
			nextEl =
			cloneEl =
			lastDownEl =

			scrollEl =
			scrollParentEl =

			tapEvt =
			touchEvt =

			moved =
			newIndex =

			lastEl =
			lastCSS =

			putSortable =
			activeGroup =
			Sortable.active = null;

			savedInputChecked.forEach(function (el) {
				el.checked = true;
			});
			savedInputChecked.length = 0;
		},

		handleEvent: function (/**Event*/evt) {
			switch (evt.type) {
				case 'drop':
				case 'dragend':
					this._onDrop(evt);
					break;

				case 'dragover':
				case 'dragenter':
					if (dragEl) {
						this._onDragOver(evt);
						_globalDragOver(evt);
					}
					break;

				case 'mouseover':
					this._onDrop(evt);
					break;

				case 'selectstart':
					evt.preventDefault();
					break;
			}
		},


		/**
		 * Serializes the item into an array of string.
		 * @returns {String[]}
		 */
		toArray: function () {
			var order = [],
				el,
				children = this.el.children,
				i = 0,
				n = children.length,
				options = this.options;

			for (; i < n; i++) {
				el = children[i];
				if (_closest(el, options.draggable, this.el)) {
					order.push(el.getAttribute(options.dataIdAttr) || _generateId(el));
				}
			}

			return order;
		},


		/**
		 * Sorts the elements according to the array.
		 * @param  {String[]}  order  order of the items
		 */
		sort: function (order) {
			var items = {}, rootEl = this.el;

			this.toArray().forEach(function (id, i) {
				var el = rootEl.children[i];

				if (_closest(el, this.options.draggable, rootEl)) {
					items[id] = el;
				}
			}, this);

			order.forEach(function (id) {
				if (items[id]) {
					rootEl.removeChild(items[id]);
					rootEl.appendChild(items[id]);
				}
			});
		},


		/**
		 * Save the current sorting
		 */
		save: function () {
			var store = this.options.store;
			store && store.set(this);
		},


		/**
		 * For each element in the set, get the first element that matches the selector by testing the element itself and traversing up through its ancestors in the DOM tree.
		 * @param   {HTMLElement}  el
		 * @param   {String}       [selector]  default: `options.draggable`
		 * @returns {HTMLElement|null}
		 */
		closest: function (el, selector) {
			return _closest(el, selector || this.options.draggable, this.el);
		},


		/**
		 * Set/get option
		 * @param   {string} name
		 * @param   {*}      [value]
		 * @returns {*}
		 */
		option: function (name, value) {
			var options = this.options;

			if (value === void 0) {
				return options[name];
			} else {
				options[name] = value;

				if (name === 'group') {
					_prepareGroup(options);
				}
			}
		},


		/**
		 * Destroy
		 */
		destroy: function () {
			var el = this.el;

			el[expando] = null;

			_off(el, 'mousedown', this._onTapStart);
			_off(el, 'touchstart', this._onTapStart);
			_off(el, 'pointerdown', this._onTapStart);

			if (this.nativeDraggable) {
				_off(el, 'dragover', this);
				_off(el, 'dragenter', this);
			}

			// Remove draggable attributes
			Array.prototype.forEach.call(el.querySelectorAll('[draggable]'), function (el) {
				el.removeAttribute('draggable');
			});

			touchDragOverListeners.splice(touchDragOverListeners.indexOf(this._onDragOver), 1);

			this._onDrop();

			this.el = el = null;
		}
	};


	function _cloneHide(sortable, state) {
		if (sortable.lastPullMode !== 'clone') {
			state = true;
		}

		if (cloneEl && (cloneEl.state !== state)) {
			_css(cloneEl, 'display', state ? 'none' : '');

			if (!state) {
				if (cloneEl.state) {
					if (sortable.options.group.revertClone) {
						rootEl.insertBefore(cloneEl, nextEl);
						sortable._animate(dragEl, cloneEl);
					} else {
						rootEl.insertBefore(cloneEl, dragEl);
					}
				}
			}

			cloneEl.state = state;
		}
	}


	function _closest(/**HTMLElement*/el, /**String*/selector, /**HTMLElement*/ctx) {
		if (el) {
			ctx = ctx || document;

			do {
				if ((selector === '>*' && el.parentNode === ctx) || _matches(el, selector)) {
					return el;
				}
				/* jshint boss:true */
			} while (el = _getParentOrHost(el));
		}

		return null;
	}


	function _getParentOrHost(el) {
		var parent = el.host;

		return (parent && parent.nodeType) ? parent : el.parentNode;
	}


	function _globalDragOver(/**Event*/evt) {
		if (evt.dataTransfer) {
			evt.dataTransfer.dropEffect = 'move';
		}
		evt.preventDefault();
	}


	function _on(el, event, fn) {
		el.addEventListener(event, fn, captureMode);
	}


	function _off(el, event, fn) {
		el.removeEventListener(event, fn, captureMode);
	}


	function _toggleClass(el, name, state) {
		if (el) {
			if (el.classList) {
				el.classList[state ? 'add' : 'remove'](name);
			}
			else {
				var className = (' ' + el.className + ' ').replace(R_SPACE, ' ').replace(' ' + name + ' ', ' ');
				el.className = (className + (state ? ' ' + name : '')).replace(R_SPACE, ' ');
			}
		}
	}


	function _css(el, prop, val) {
		var style = el && el.style;

		if (style) {
			if (val === void 0) {
				if (document.defaultView && document.defaultView.getComputedStyle) {
					val = document.defaultView.getComputedStyle(el, '');
				}
				else if (el.currentStyle) {
					val = el.currentStyle;
				}

				return prop === void 0 ? val : val[prop];
			}
			else {
				if (!(prop in style)) {
					prop = '-webkit-' + prop;
				}

				style[prop] = val + (typeof val === 'string' ? '' : 'px');
			}
		}
	}


	function _find(ctx, tagName, iterator) {
		if (ctx) {
			var list = ctx.getElementsByTagName(tagName), i = 0, n = list.length;

			if (iterator) {
				for (; i < n; i++) {
					iterator(list[i], i);
				}
			}

			return list;
		}

		return [];
	}



	function _dispatchEvent(sortable, rootEl, name, targetEl, toEl, fromEl, startIndex, newIndex) {
		sortable = (sortable || rootEl[expando]);

		var evt = document.createEvent('Event'),
			options = sortable.options,
			onName = 'on' + name.charAt(0).toUpperCase() + name.substr(1);

		evt.initEvent(name, true, true);

		evt.to = toEl || rootEl;
		evt.from = fromEl || rootEl;
		evt.item = targetEl || rootEl;
		evt.clone = cloneEl;

		evt.oldIndex = startIndex;
		evt.newIndex = newIndex;

		rootEl.dispatchEvent(evt);

		if (options[onName]) {
			options[onName].call(sortable, evt);
		}
	}


	function _onMove(fromEl, toEl, dragEl, dragRect, targetEl, targetRect, originalEvt, willInsertAfter) {
		var evt,
			sortable = fromEl[expando],
			onMoveFn = sortable.options.onMove,
			retVal;

		evt = document.createEvent('Event');
		evt.initEvent('move', true, true);

		evt.to = toEl;
		evt.from = fromEl;
		evt.dragged = dragEl;
		evt.draggedRect = dragRect;
		evt.related = targetEl || toEl;
		evt.relatedRect = targetRect || toEl.getBoundingClientRect();
		evt.willInsertAfter = willInsertAfter;

		fromEl.dispatchEvent(evt);

		if (onMoveFn) {
			retVal = onMoveFn.call(sortable, evt, originalEvt);
		}

		return retVal;
	}


	function _disableDraggable(el) {
		el.draggable = false;
	}


	function _unsilent() {
		_silent = false;
	}


	/** @returns {HTMLElement|false} */
	function _ghostIsLast(el, evt) {
		var lastEl = el.lastElementChild,
			rect = lastEl.getBoundingClientRect();

		// 5 — min delta
		// abs — нельзя добавлять, а то глюки при наведении сверху
		return (evt.clientY - (rect.top + rect.height) > 5) ||
			(evt.clientX - (rect.left + rect.width) > 5);
	}


	/**
	 * Generate id
	 * @param   {HTMLElement} el
	 * @returns {String}
	 * @private
	 */
	function _generateId(el) {
		var str = el.tagName + el.className + el.src + el.href + el.textContent,
			i = str.length,
			sum = 0;

		while (i--) {
			sum += str.charCodeAt(i);
		}

		return sum.toString(36);
	}

	/**
	 * Returns the index of an element within its parent for a selected set of
	 * elements
	 * @param  {HTMLElement} el
	 * @param  {selector} selector
	 * @return {number}
	 */
	function _index(el, selector) {
		var index = 0;

		if (!el || !el.parentNode) {
			return -1;
		}

		while (el && (el = el.previousElementSibling)) {
			if ((el.nodeName.toUpperCase() !== 'TEMPLATE') && (selector === '>*' || _matches(el, selector))) {
				index++;
			}
		}

		return index;
	}

	function _matches(/**HTMLElement*/el, /**String*/selector) {
		if (el) {
			selector = selector.split('.');

			var tag = selector.shift().toUpperCase(),
				re = new RegExp('\\s(' + selector.join('|') + ')(?=\\s)', 'g');

			return (
				(tag === '' || el.nodeName.toUpperCase() == tag) &&
				(!selector.length || ((' ' + el.className + ' ').match(re) || []).length == selector.length)
			);
		}

		return false;
	}

	function _throttle(callback, ms) {
		var args, _this;

		return function () {
			if (args === void 0) {
				args = arguments;
				_this = this;

				setTimeout(function () {
					if (args.length === 1) {
						callback.call(_this, args[0]);
					} else {
						callback.apply(_this, args);
					}

					args = void 0;
				}, ms);
			}
		};
	}

	function _extend(dst, src) {
		if (dst && src) {
			for (var key in src) {
				if (src.hasOwnProperty(key)) {
					dst[key] = src[key];
				}
			}
		}

		return dst;
	}

	function _clone(el) {
		if (Polymer && Polymer.dom) {
			return Polymer.dom(el).cloneNode(true);
		}
		else if ($) {
			return $(el).clone(true)[0];
		}
		else {
			return el.cloneNode(true);
		}
	}

	function _saveInputCheckedState(root) {
		var inputs = root.getElementsByTagName('input');
		var idx = inputs.length;

		while (idx--) {
			var el = inputs[idx];
			el.checked && savedInputChecked.push(el);
		}
	}

	function _nextTick(fn) {
		return setTimeout(fn, 0);
	}

	function _cancelNextTick(id) {
		return clearTimeout(id);
	}

	// Fixed #973:
	_on(document, 'touchmove', function (evt) {
		if (Sortable.active) {
			evt.preventDefault();
		}
	});

	// Export utils
	Sortable.utils = {
		on: _on,
		off: _off,
		css: _css,
		find: _find,
		is: function (el, selector) {
			return !!_closest(el, selector, el);
		},
		extend: _extend,
		throttle: _throttle,
		closest: _closest,
		toggleClass: _toggleClass,
		clone: _clone,
		index: _index,
		nextTick: _nextTick,
		cancelNextTick: _cancelNextTick
	};


	/**
	 * Create sortable instance
	 * @param {HTMLElement}  el
	 * @param {Object}      [options]
	 */
	Sortable.create = function (el, options) {
		return new Sortable(el, options);
	};


	// Export
	Sortable.version = '1.7.0';
	return Sortable;
});


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

(function webpackUniversalModuleDefinition(root, factory) {
	if(true)
		module.exports = factory(__webpack_require__(4));
	else if(typeof define === 'function' && define.amd)
		define(["vue"], factory);
	else if(typeof exports === 'object')
		exports["vue-mouse-menu"] = factory(require("vue"));
	else
		root["vue-mouse-menu"] = factory(root["vue"]);
})(this, function(__WEBPACK_EXTERNAL_MODULE_1__) {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/dist/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(8)

var Component = __webpack_require__(6)(
  /* script */
  __webpack_require__(2),
  /* template */
  __webpack_require__(7),
  /* scopeId */
  "data-v-0af63bc6",
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = __WEBPACK_EXTERNAL_MODULE_1__;

/***/ }),
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  props: ['popItems', 'mouse', 'slotArr'],
  data: function data() {
    return {
      freeStyle: '',
      showPop: false
    };
  },

  watch: {
    mouse: function mouse() {
      var self = this;
      var x = self.mouse[0];
      var y = self.mouse[1];
      if (x === 'close') {
        self.showPop = false;
      } else {
        self.freeStyle = 'left:' + x + 'px; top:' + y + 'px;'; //计算鼠标位置
        self.showPop = true;
      }
    }
  },
  computed: {
    items: function items() {
      return this.popItems;
    }
  },
  created: function created() {
    document.oncontextmenu = preventExplorerMenu;
  },


  methods: {
    listItemClick: function listItemClick(it) {
      var self = this;
      self.$emit('ListItemClick', it);
    }
  },
  mounted: function mounted() {}
});

function preventExplorerMenu() {
  return false;
}

/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__rightMenu_vue__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__rightMenu_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__rightMenu_vue__);


var plugin = {
    install: function install(Vue, options) {
        Vue.component('RightMenu', __WEBPACK_IMPORTED_MODULE_1__rightMenu_vue___default.a);
    }
};

/* harmony default export */ __webpack_exports__["default"] = (plugin);

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(5)();
// imports


// module
exports.push([module.i, ".menu-box[data-v-0af63bc6]{border:1px solid #ddd;width:150px;padding:5px 10px;box-shadow:2px 2px 2px #aaa;position:absolute;z-index:10;background-color:#eee}.menu-box>ul[data-v-0af63bc6]{margin:auto}.menu-box ul li[data-v-0af63bc6]{cursor:pointer;height:30px;line-height:30px;box-sizing:border-box}.menu-box ul li+li[data-v-0af63bc6]{border-top:1px solid #bebebe}.menu-box ul li[data-v-0af63bc6]:hover{background-color:#ddd}.menu-box ul li span[data-v-0af63bc6]{display:inline-block}.menu-box ul li span[data-v-0af63bc6]:first-child{margin-right:5px}", ""]);

// exports


/***/ }),
/* 5 */
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function() {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		var result = [];
		for(var i = 0; i < this.length; i++) {
			var item = this[i];
			if(item[2]) {
				result.push("@media " + item[2] + "{" + item[1] + "}");
			} else {
				result.push(item[1]);
			}
		}
		return result.join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};


/***/ }),
/* 6 */
/***/ (function(module, exports) {

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  scopeId,
  cssModules
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  // inject cssModules
  if (cssModules) {
    var computed = Object.create(options.computed || null)
    Object.keys(cssModules).forEach(function (key) {
      var module = cssModules[key]
      computed[key] = function () { return module }
    })
    options.computed = computed
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),
/* 7 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return (_vm.showPop) ? _c('div', {
    staticClass: "menu-box",
    style: (_vm.freeStyle)
  }, [_c('ul', {
    staticClass: "list-unstyled"
  }, _vm._l((_vm.items), function(item, it) {
    return _c('li', {
      on: {
        "click": function($event) {
          _vm.listItemClick(it)
        }
      }
    }, [_c('span', [_c('i', {
      class: item.class
    })]), _vm._v(" "), _c('span', [_vm._v(_vm._s(item.txt))])])
  }))]) : _vm._e()
},staticRenderFns: []}

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(4);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(9)("e04d30d0", content, true);

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(10)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction) {
  isProduction = _isProduction

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[data-vue-ssr-id~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),
/* 10 */
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ })
/******/ ]);
});
//# sourceMappingURL=index.js.map

/***/ }),
/* 56 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);