(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _vendor_friendsofsymfony_jsrouting_bundle_Resources_public_js_router_min_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js */ "./vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js");
/* harmony import */ var _vendor_friendsofsymfony_jsrouting_bundle_Resources_public_js_router_min_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_vendor_friendsofsymfony_jsrouting_bundle_Resources_public_js_router_min_js__WEBPACK_IMPORTED_MODULE_0__);
var routes = __webpack_require__(/*! ../public/js/fos_js_routes.json */ "./public/js/fos_js_routes.json");

_vendor_friendsofsymfony_jsrouting_bundle_Resources_public_js_router_min_js__WEBPACK_IMPORTED_MODULE_0___default().setRoutingData(routes);
window.Routing = (_vendor_friendsofsymfony_jsrouting_bundle_Resources_public_js_router_min_js__WEBPACK_IMPORTED_MODULE_0___default());

/***/ }),

/***/ "./vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js":
/*!************************************************************************************!*\
  !*** ./vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js ***!
  \************************************************************************************/
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
__webpack_require__(/*! core-js/modules/es.object.freeze.js */ "./node_modules/core-js/modules/es.object.freeze.js");
__webpack_require__(/*! core-js/modules/es.regexp.constructor.js */ "./node_modules/core-js/modules/es.regexp.constructor.js");
__webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
__webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ "./node_modules/core-js/modules/es.regexp.to-string.js");
__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
__webpack_require__(/*! core-js/modules/es.object.assign.js */ "./node_modules/core-js/modules/es.object.assign.js");
__webpack_require__(/*! core-js/modules/es.array.is-array.js */ "./node_modules/core-js/modules/es.array.is-array.js");
__webpack_require__(/*! core-js/modules/es.array.index-of.js */ "./node_modules/core-js/modules/es.array.index-of.js");
__webpack_require__(/*! core-js/modules/es.object.keys.js */ "./node_modules/core-js/modules/es.object.keys.js");
__webpack_require__(/*! core-js/modules/es.array.join.js */ "./node_modules/core-js/modules/es.array.join.js");
__webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
__webpack_require__(/*! core-js/modules/es.symbol.js */ "./node_modules/core-js/modules/es.symbol.js");
__webpack_require__(/*! core-js/modules/es.symbol.description.js */ "./node_modules/core-js/modules/es.symbol.description.js");
__webpack_require__(/*! core-js/modules/es.symbol.iterator.js */ "./node_modules/core-js/modules/es.symbol.iterator.js");
__webpack_require__(/*! core-js/modules/es.array.iterator.js */ "./node_modules/core-js/modules/es.array.iterator.js");
__webpack_require__(/*! core-js/modules/es.string.iterator.js */ "./node_modules/core-js/modules/es.string.iterator.js");
__webpack_require__(/*! core-js/modules/web.dom-collections.iterator.js */ "./node_modules/core-js/modules/web.dom-collections.iterator.js");
!function (e) {
  (t = {}).__esModule = !0, t.Routing = t.Router = void 0, o = function () {
    function l(e, t) {
      this.context_ = e || {
        base_url: "",
        prefix: "",
        host: "",
        port: "",
        scheme: "",
        locale: ""
      }, this.setRoutes(t || {});
    }
    return l.getInstance = function () {
      return t.Routing;
    }, l.setData = function (e) {
      l.getInstance().setRoutingData(e);
    }, l.prototype.setRoutingData = function (e) {
      this.setBaseUrl(e.base_url), this.setRoutes(e.routes), void 0 !== e.prefix && this.setPrefix(e.prefix), void 0 !== e.port && this.setPort(e.port), void 0 !== e.locale && this.setLocale(e.locale), this.setHost(e.host), void 0 !== e.scheme && this.setScheme(e.scheme);
    }, l.prototype.setRoutes = function (e) {
      this.routes_ = Object.freeze(e);
    }, l.prototype.getRoutes = function () {
      return this.routes_;
    }, l.prototype.setBaseUrl = function (e) {
      this.context_.base_url = e;
    }, l.prototype.getBaseUrl = function () {
      return this.context_.base_url;
    }, l.prototype.setPrefix = function (e) {
      this.context_.prefix = e;
    }, l.prototype.setScheme = function (e) {
      this.context_.scheme = e;
    }, l.prototype.getScheme = function () {
      return this.context_.scheme;
    }, l.prototype.setHost = function (e) {
      this.context_.host = e;
    }, l.prototype.getHost = function () {
      return this.context_.host;
    }, l.prototype.setPort = function (e) {
      this.context_.port = e;
    }, l.prototype.getPort = function () {
      return this.context_.port;
    }, l.prototype.setLocale = function (e) {
      this.context_.locale = e;
    }, l.prototype.getLocale = function () {
      return this.context_.locale;
    }, l.prototype.buildQueryParams = function (o, e, n) {
      var t,
        r = this,
        s = new RegExp(/\[\]$/);
      if (e instanceof Array) e.forEach(function (e, t) {
        s.test(o) ? n(o, e) : r.buildQueryParams(o + "[" + ("object" == _typeof(e) ? t : "") + "]", e, n);
      });else if ("object" == _typeof(e)) for (t in e) this.buildQueryParams(o + "[" + t + "]", e[t], n);else n(o, e);
    }, l.prototype.getRoute = function (e) {
      var t,
        o = [this.context_.prefix + e, e + "." + this.context_.locale, this.context_.prefix + e + "." + this.context_.locale, e];
      for (t in o) if (o[t] in this.routes_) return this.routes_[o[t]];
      throw new Error('The route "' + e + '" does not exist.');
    }, l.prototype.generate = function (r, e, p) {
      var t,
        s = this.getRoute(r),
        i = e || {},
        u = Object.assign({}, i),
        c = "",
        a = !0,
        o = "",
        e = void 0 === this.getPort() || null === this.getPort() ? "" : this.getPort();
      if (s.tokens.forEach(function (e) {
        if ("text" === e[0] && "string" == typeof e[1]) return c = l.encodePathComponent(e[1]) + c, void (a = !1);
        if ("variable" !== e[0]) throw new Error('The token type "' + e[0] + '" is not supported.');
        6 === e.length && !0 === e[5] && (a = !1);
        var t = s.defaults && !Array.isArray(s.defaults) && "string" == typeof e[3] && e[3] in s.defaults;
        if (!1 === a || !t || "string" == typeof e[3] && e[3] in i && !Array.isArray(s.defaults) && i[e[3]] != s.defaults[e[3]]) {
          var o,
            n = void 0;
          if ("string" == typeof e[3] && e[3] in i) n = i[e[3]], delete u[e[3]];else {
            if ("string" != typeof e[3] || !t || Array.isArray(s.defaults)) {
              if (a) return;
              throw new Error('The route "' + r + '" requires the parameter "' + e[3] + '".');
            }
            n = s.defaults[e[3]];
          }
          (!0 === n || !1 === n || "" === n) && a || (o = l.encodePathComponent(n), c = e[1] + (o = "null" === o && null === n ? "" : o) + c), a = !1;
        } else t && "string" == typeof e[3] && e[3] in u && delete u[e[3]];
      }), "" === c && (c = "/"), s.hosttokens.forEach(function (e) {
        var t;
        "text" !== e[0] ? "variable" === e[0] && (e[3] in i ? (t = i[e[3]], delete u[e[3]]) : s.defaults && !Array.isArray(s.defaults) && e[3] in s.defaults && (t = s.defaults[e[3]]), o = e[1] + t + o) : o = e[1] + o;
      }), c = this.context_.base_url + c, s.requirements && "_scheme" in s.requirements && this.getScheme() != s.requirements._scheme ? (t = o || this.getHost(), c = s.requirements._scheme + "://" + t + (-1 < t.indexOf(":" + e) || "" === e ? "" : ":" + e) + c) : void 0 !== s.schemes && void 0 !== s.schemes[0] && this.getScheme() !== s.schemes[0] ? (t = o || this.getHost(), c = s.schemes[0] + "://" + t + (-1 < t.indexOf(":" + e) || "" === e ? "" : ":" + e) + c) : o && this.getHost() !== o + (-1 < o.indexOf(":" + e) || "" === e ? "" : ":" + e) ? c = this.getScheme() + "://" + o + (-1 < o.indexOf(":" + e) || "" === e ? "" : ":" + e) + c : !0 === p && (c = this.getScheme() + "://" + this.getHost() + (-1 < this.getHost().indexOf(":" + e) || "" === e ? "" : ":" + e) + c), 0 < Object.keys(u).length) {
        var f = function f(e, t) {
          t = null === (t = "function" == typeof t ? t() : t) ? "" : t, h.push(l.encodeQueryComponent(e) + "=" + l.encodeQueryComponent(t));
        };
        var n,
          h = [];
        for (n in u) u.hasOwnProperty(n) && this.buildQueryParams(n, u[n], f);
        c = c + "?" + h.join("&");
      }
      return c;
    }, l.customEncodeURIComponent = function (e) {
      return encodeURIComponent(e).replace(/%2F/g, "/").replace(/%40/g, "@").replace(/%3A/g, ":").replace(/%21/g, "!").replace(/%3B/g, ";").replace(/%2C/g, ",").replace(/%2A/g, "*").replace(/\(/g, "%28").replace(/\)/g, "%29").replace(/'/g, "%27");
    }, l.encodePathComponent = function (e) {
      return l.customEncodeURIComponent(e).replace(/%3D/g, "=").replace(/%2B/g, "+").replace(/%21/g, "!").replace(/%7C/g, "|");
    }, l.encodeQueryComponent = function (e) {
      return l.customEncodeURIComponent(e).replace(/%3F/g, "?");
    }, l;
  }(), t.Router = o, t.Routing = new o(), t["default"] = t.Routing;
  var t,
    o = {
      Router: t.Router,
      Routing: t.Routing
    };
   true ? !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (o.Routing),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : 0;
}(this);

/***/ }),

/***/ "./public/js/fos_js_routes.json":
/*!**************************************!*\
  !*** ./public/js/fos_js_routes.json ***!
  \**************************************/
/***/ ((module) => {

"use strict";
module.exports = JSON.parse('{"base_url":"","routes":{"app_jeux_gagner":{"tokens":[["variable","/","[^/]++","user",true],["variable","/","[^/]++","jeux",true],["text","/admin/gagner"]],"defaults":[],"requirements":[],"hosttokens":[],"methods":["GET"],"schemes":[]}},"prefix":"","host":"localhost","port":"","scheme":"http","locale":""}');

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_for-each_js-node_modules_core-js_modules_es_arr-36a35c"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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LHdCQUF3QixDQUFDbkUsQ0FBQyxDQUFDLENBQUNxRSxPQUFPLENBQUMsTUFBTSxFQUFDLEdBQUcsQ0FBQztJQUFBLENBQUMsRUFBQ2hFLENBQUM7RUFBQSxDQUFDLEVBQUUsRUFBQ0osQ0FBQyxDQUFDRSxNQUFNLEdBQUNDLENBQUMsRUFBQ0gsQ0FBQyxDQUFDSixPQUFPLEdBQUMsSUFBSU8sQ0FBQyxJQUFDSCxDQUFDLFdBQVEsR0FBQ0EsQ0FBQyxDQUFDSixPQUFPO0VBQUMsSUFBSUksQ0FBQztJQUFDRyxDQUFDLEdBQUM7TUFBQ0QsTUFBTSxFQUFDRixDQUFDLENBQUNFLE1BQU07TUFBQ04sT0FBTyxFQUFDSSxDQUFDLENBQUNKO0lBQU8sQ0FBQztFQUFDLEtBQXFDLEdBQUN5RSxpQ0FBTyxFQUFFLG9DQUFDbEUsQ0FBQyxDQUFDUCxPQUFPO0FBQUE7QUFBQTtBQUFBLGtHQUFDLEdBQUMsQ0FBOEc7QUFBQSxDQUFDLENBQUMsSUFBSSxDQUFDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2FwcC5qcyIsIndlYnBhY2s6Ly8vLi92ZW5kb3IvZnJpZW5kc29mc3ltZm9ueS9qc3JvdXRpbmctYnVuZGxlL1Jlc291cmNlcy9wdWJsaWMvanMvcm91dGVyLm1pbi5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCByb3V0ZXMgPSByZXF1aXJlKCcuLi9wdWJsaWMvanMvZm9zX2pzX3JvdXRlcy5qc29uJyk7XHJcbmltcG9ydCBSb3V0aW5nIGZyb20gJy4uL3ZlbmRvci9mcmllbmRzb2ZzeW1mb255L2pzcm91dGluZy1idW5kbGUvUmVzb3VyY2VzL3B1YmxpYy9qcy9yb3V0ZXIubWluLmpzJztcclxuUm91dGluZy5zZXRSb3V0aW5nRGF0YShyb3V0ZXMpO1xyXG5cclxud2luZG93LlJvdXRpbmcgPSBSb3V0aW5nOyIsIiFmdW5jdGlvbihlKXsodD17fSkuX19lc01vZHVsZT0hMCx0LlJvdXRpbmc9dC5Sb3V0ZXI9dm9pZCAwLG89ZnVuY3Rpb24oKXtmdW5jdGlvbiBsKGUsdCl7dGhpcy5jb250ZXh0Xz1lfHx7YmFzZV91cmw6XCJcIixwcmVmaXg6XCJcIixob3N0OlwiXCIscG9ydDpcIlwiLHNjaGVtZTpcIlwiLGxvY2FsZTpcIlwifSx0aGlzLnNldFJvdXRlcyh0fHx7fSl9cmV0dXJuIGwuZ2V0SW5zdGFuY2U9ZnVuY3Rpb24oKXtyZXR1cm4gdC5Sb3V0aW5nfSxsLnNldERhdGE9ZnVuY3Rpb24oZSl7bC5nZXRJbnN0YW5jZSgpLnNldFJvdXRpbmdEYXRhKGUpfSxsLnByb3RvdHlwZS5zZXRSb3V0aW5nRGF0YT1mdW5jdGlvbihlKXt0aGlzLnNldEJhc2VVcmwoZS5iYXNlX3VybCksdGhpcy5zZXRSb3V0ZXMoZS5yb3V0ZXMpLHZvaWQgMCE9PWUucHJlZml4JiZ0aGlzLnNldFByZWZpeChlLnByZWZpeCksdm9pZCAwIT09ZS5wb3J0JiZ0aGlzLnNldFBvcnQoZS5wb3J0KSx2b2lkIDAhPT1lLmxvY2FsZSYmdGhpcy5zZXRMb2NhbGUoZS5sb2NhbGUpLHRoaXMuc2V0SG9zdChlLmhvc3QpLHZvaWQgMCE9PWUuc2NoZW1lJiZ0aGlzLnNldFNjaGVtZShlLnNjaGVtZSl9LGwucHJvdG90eXBlLnNldFJvdXRlcz1mdW5jdGlvbihlKXt0aGlzLnJvdXRlc189T2JqZWN0LmZyZWV6ZShlKX0sbC5wcm90b3R5cGUuZ2V0Um91dGVzPWZ1bmN0aW9uKCl7cmV0dXJuIHRoaXMucm91dGVzX30sbC5wcm90b3R5cGUuc2V0QmFzZVVybD1mdW5jdGlvbihlKXt0aGlzLmNvbnRleHRfLmJhc2VfdXJsPWV9LGwucHJvdG90eXBlLmdldEJhc2VVcmw9ZnVuY3Rpb24oKXtyZXR1cm4gdGhpcy5jb250ZXh0Xy5iYXNlX3VybH0sbC5wcm90b3R5cGUuc2V0UHJlZml4PWZ1bmN0aW9uKGUpe3RoaXMuY29udGV4dF8ucHJlZml4PWV9LGwucHJvdG90eXBlLnNldFNjaGVtZT1mdW5jdGlvbihlKXt0aGlzLmNvbnRleHRfLnNjaGVtZT1lfSxsLnByb3RvdHlwZS5nZXRTY2hlbWU9ZnVuY3Rpb24oKXtyZXR1cm4gdGhpcy5jb250ZXh0Xy5zY2hlbWV9LGwucHJvdG90eXBlLnNldEhvc3Q9ZnVuY3Rpb24oZSl7dGhpcy5jb250ZXh0Xy5ob3N0PWV9LGwucHJvdG90eXBlLmdldEhvc3Q9ZnVuY3Rpb24oKXtyZXR1cm4gdGhpcy5jb250ZXh0Xy5ob3N0fSxsLnByb3RvdHlwZS5zZXRQb3J0PWZ1bmN0aW9uKGUpe3RoaXMuY29udGV4dF8ucG9ydD1lfSxsLnByb3RvdHlwZS5nZXRQb3J0PWZ1bmN0aW9uKCl7cmV0dXJuIHRoaXMuY29udGV4dF8ucG9ydH0sbC5wcm90b3R5cGUuc2V0TG9jYWxlPWZ1bmN0aW9uKGUpe3RoaXMuY29udGV4dF8ubG9jYWxlPWV9LGwucHJvdG90eXBlLmdldExvY2FsZT1mdW5jdGlvbigpe3JldHVybiB0aGlzLmNvbnRleHRfLmxvY2FsZX0sbC5wcm90b3R5cGUuYnVpbGRRdWVyeVBhcmFtcz1mdW5jdGlvbihvLGUsbil7dmFyIHQscj10aGlzLHM9bmV3IFJlZ0V4cCgvXFxbXFxdJC8pO2lmKGUgaW5zdGFuY2VvZiBBcnJheSllLmZvckVhY2goZnVuY3Rpb24oZSx0KXtzLnRlc3Qobyk/bihvLGUpOnIuYnVpbGRRdWVyeVBhcmFtcyhvK1wiW1wiKyhcIm9iamVjdFwiPT10eXBlb2YgZT90OlwiXCIpK1wiXVwiLGUsbil9KTtlbHNlIGlmKFwib2JqZWN0XCI9PXR5cGVvZiBlKWZvcih0IGluIGUpdGhpcy5idWlsZFF1ZXJ5UGFyYW1zKG8rXCJbXCIrdCtcIl1cIixlW3RdLG4pO2Vsc2UgbihvLGUpfSxsLnByb3RvdHlwZS5nZXRSb3V0ZT1mdW5jdGlvbihlKXt2YXIgdCxvPVt0aGlzLmNvbnRleHRfLnByZWZpeCtlLGUrXCIuXCIrdGhpcy5jb250ZXh0Xy5sb2NhbGUsdGhpcy5jb250ZXh0Xy5wcmVmaXgrZStcIi5cIit0aGlzLmNvbnRleHRfLmxvY2FsZSxlXTtmb3IodCBpbiBvKWlmKG9bdF1pbiB0aGlzLnJvdXRlc18pcmV0dXJuIHRoaXMucm91dGVzX1tvW3RdXTt0aHJvdyBuZXcgRXJyb3IoJ1RoZSByb3V0ZSBcIicrZSsnXCIgZG9lcyBub3QgZXhpc3QuJyl9LGwucHJvdG90eXBlLmdlbmVyYXRlPWZ1bmN0aW9uKHIsZSxwKXt2YXIgdCxzPXRoaXMuZ2V0Um91dGUociksaT1lfHx7fSx1PU9iamVjdC5hc3NpZ24oe30saSksYz1cIlwiLGE9ITAsbz1cIlwiLGU9dm9pZCAwPT09dGhpcy5nZXRQb3J0KCl8fG51bGw9PT10aGlzLmdldFBvcnQoKT9cIlwiOnRoaXMuZ2V0UG9ydCgpO2lmKHMudG9rZW5zLmZvckVhY2goZnVuY3Rpb24oZSl7aWYoXCJ0ZXh0XCI9PT1lWzBdJiZcInN0cmluZ1wiPT10eXBlb2YgZVsxXSlyZXR1cm4gYz1sLmVuY29kZVBhdGhDb21wb25lbnQoZVsxXSkrYyx2b2lkKGE9ITEpO2lmKFwidmFyaWFibGVcIiE9PWVbMF0pdGhyb3cgbmV3IEVycm9yKCdUaGUgdG9rZW4gdHlwZSBcIicrZVswXSsnXCIgaXMgbm90IHN1cHBvcnRlZC4nKTs2PT09ZS5sZW5ndGgmJiEwPT09ZVs1XSYmKGE9ITEpO3ZhciB0PXMuZGVmYXVsdHMmJiFBcnJheS5pc0FycmF5KHMuZGVmYXVsdHMpJiZcInN0cmluZ1wiPT10eXBlb2YgZVszXSYmZVszXWluIHMuZGVmYXVsdHM7aWYoITE9PT1hfHwhdHx8XCJzdHJpbmdcIj09dHlwZW9mIGVbM10mJmVbM11pbiBpJiYhQXJyYXkuaXNBcnJheShzLmRlZmF1bHRzKSYmaVtlWzNdXSE9cy5kZWZhdWx0c1tlWzNdXSl7dmFyIG8sbj12b2lkIDA7aWYoXCJzdHJpbmdcIj09dHlwZW9mIGVbM10mJmVbM11pbiBpKW49aVtlWzNdXSxkZWxldGUgdVtlWzNdXTtlbHNle2lmKFwic3RyaW5nXCIhPXR5cGVvZiBlWzNdfHwhdHx8QXJyYXkuaXNBcnJheShzLmRlZmF1bHRzKSl7aWYoYSlyZXR1cm47dGhyb3cgbmV3IEVycm9yKCdUaGUgcm91dGUgXCInK3IrJ1wiIHJlcXVpcmVzIHRoZSBwYXJhbWV0ZXIgXCInK2VbM10rJ1wiLicpfW49cy5kZWZhdWx0c1tlWzNdXX0oITA9PT1ufHwhMT09PW58fFwiXCI9PT1uKSYmYXx8KG89bC5lbmNvZGVQYXRoQ29tcG9uZW50KG4pLGM9ZVsxXSsobz1cIm51bGxcIj09PW8mJm51bGw9PT1uP1wiXCI6bykrYyksYT0hMX1lbHNlIHQmJlwic3RyaW5nXCI9PXR5cGVvZiBlWzNdJiZlWzNdaW4gdSYmZGVsZXRlIHVbZVszXV19KSxcIlwiPT09YyYmKGM9XCIvXCIpLHMuaG9zdHRva2Vucy5mb3JFYWNoKGZ1bmN0aW9uKGUpe3ZhciB0O1widGV4dFwiIT09ZVswXT9cInZhcmlhYmxlXCI9PT1lWzBdJiYoZVszXWluIGk/KHQ9aVtlWzNdXSxkZWxldGUgdVtlWzNdXSk6cy5kZWZhdWx0cyYmIUFycmF5LmlzQXJyYXkocy5kZWZhdWx0cykmJmVbM11pbiBzLmRlZmF1bHRzJiYodD1zLmRlZmF1bHRzW2VbM11dKSxvPWVbMV0rdCtvKTpvPWVbMV0rb30pLGM9dGhpcy5jb250ZXh0Xy5iYXNlX3VybCtjLHMucmVxdWlyZW1lbnRzJiZcIl9zY2hlbWVcImluIHMucmVxdWlyZW1lbnRzJiZ0aGlzLmdldFNjaGVtZSgpIT1zLnJlcXVpcmVtZW50cy5fc2NoZW1lPyh0PW98fHRoaXMuZ2V0SG9zdCgpLGM9cy5yZXF1aXJlbWVudHMuX3NjaGVtZStcIjovL1wiK3QrKC0xPHQuaW5kZXhPZihcIjpcIitlKXx8XCJcIj09PWU/XCJcIjpcIjpcIitlKStjKTp2b2lkIDAhPT1zLnNjaGVtZXMmJnZvaWQgMCE9PXMuc2NoZW1lc1swXSYmdGhpcy5nZXRTY2hlbWUoKSE9PXMuc2NoZW1lc1swXT8odD1vfHx0aGlzLmdldEhvc3QoKSxjPXMuc2NoZW1lc1swXStcIjovL1wiK3QrKC0xPHQuaW5kZXhPZihcIjpcIitlKXx8XCJcIj09PWU/XCJcIjpcIjpcIitlKStjKTpvJiZ0aGlzLmdldEhvc3QoKSE9PW8rKC0xPG8uaW5kZXhPZihcIjpcIitlKXx8XCJcIj09PWU/XCJcIjpcIjpcIitlKT9jPXRoaXMuZ2V0U2NoZW1lKCkrXCI6Ly9cIitvKygtMTxvLmluZGV4T2YoXCI6XCIrZSl8fFwiXCI9PT1lP1wiXCI6XCI6XCIrZSkrYzohMD09PXAmJihjPXRoaXMuZ2V0U2NoZW1lKCkrXCI6Ly9cIit0aGlzLmdldEhvc3QoKSsoLTE8dGhpcy5nZXRIb3N0KCkuaW5kZXhPZihcIjpcIitlKXx8XCJcIj09PWU/XCJcIjpcIjpcIitlKStjKSwwPE9iamVjdC5rZXlzKHUpLmxlbmd0aCl7ZnVuY3Rpb24gZihlLHQpe3Q9bnVsbD09PSh0PVwiZnVuY3Rpb25cIj09dHlwZW9mIHQ/dCgpOnQpP1wiXCI6dCxoLnB1c2gobC5lbmNvZGVRdWVyeUNvbXBvbmVudChlKStcIj1cIitsLmVuY29kZVF1ZXJ5Q29tcG9uZW50KHQpKX12YXIgbixoPVtdO2ZvcihuIGluIHUpdS5oYXNPd25Qcm9wZXJ0eShuKSYmdGhpcy5idWlsZFF1ZXJ5UGFyYW1zKG4sdVtuXSxmKTtjPWMrXCI/XCIraC5qb2luKFwiJlwiKX1yZXR1cm4gY30sbC5jdXN0b21FbmNvZGVVUklDb21wb25lbnQ9ZnVuY3Rpb24oZSl7cmV0dXJuIGVuY29kZVVSSUNvbXBvbmVudChlKS5yZXBsYWNlKC8lMkYvZyxcIi9cIikucmVwbGFjZSgvJTQwL2csXCJAXCIpLnJlcGxhY2UoLyUzQS9nLFwiOlwiKS5yZXBsYWNlKC8lMjEvZyxcIiFcIikucmVwbGFjZSgvJTNCL2csXCI7XCIpLnJlcGxhY2UoLyUyQy9nLFwiLFwiKS5yZXBsYWNlKC8lMkEvZyxcIipcIikucmVwbGFjZSgvXFwoL2csXCIlMjhcIikucmVwbGFjZSgvXFwpL2csXCIlMjlcIikucmVwbGFjZSgvJy9nLFwiJTI3XCIpfSxsLmVuY29kZVBhdGhDb21wb25lbnQ9ZnVuY3Rpb24oZSl7cmV0dXJuIGwuY3VzdG9tRW5jb2RlVVJJQ29tcG9uZW50KGUpLnJlcGxhY2UoLyUzRC9nLFwiPVwiKS5yZXBsYWNlKC8lMkIvZyxcIitcIikucmVwbGFjZSgvJTIxL2csXCIhXCIpLnJlcGxhY2UoLyU3Qy9nLFwifFwiKX0sbC5lbmNvZGVRdWVyeUNvbXBvbmVudD1mdW5jdGlvbihlKXtyZXR1cm4gbC5jdXN0b21FbmNvZGVVUklDb21wb25lbnQoZSkucmVwbGFjZSgvJTNGL2csXCI/XCIpfSxsfSgpLHQuUm91dGVyPW8sdC5Sb3V0aW5nPW5ldyBvLHQuZGVmYXVsdD10LlJvdXRpbmc7dmFyIHQsbz17Um91dGVyOnQuUm91dGVyLFJvdXRpbmc6dC5Sb3V0aW5nfTtcImZ1bmN0aW9uXCI9PXR5cGVvZiBkZWZpbmUmJmRlZmluZS5hbWQ/ZGVmaW5lKFtdLG8uUm91dGluZyk6XCJvYmplY3RcIj09dHlwZW9mIG1vZHVsZSYmbW9kdWxlLmV4cG9ydHM/bW9kdWxlLmV4cG9ydHM9by5Sb3V0aW5nOihlLlJvdXRpbmc9by5Sb3V0aW5nLGUuZm9zPXtSb3V0ZXI6by5Sb3V0ZXJ9KX0odGhpcyk7Il0sIm5hbWVzIjpbInJvdXRlcyIsInJlcXVpcmUiLCJSb3V0aW5nIiwic2V0Um91dGluZ0RhdGEiLCJ3aW5kb3ciLCJlIiwidCIsIl9fZXNNb2R1bGUiLCJSb3V0ZXIiLCJvIiwibCIsImNvbnRleHRfIiwiYmFzZV91cmwiLCJwcmVmaXgiLCJob3N0IiwicG9ydCIsInNjaGVtZSIsImxvY2FsZSIsInNldFJvdXRlcyIsImdldEluc3RhbmNlIiwic2V0RGF0YSIsInByb3RvdHlwZSIsInNldEJhc2VVcmwiLCJzZXRQcmVmaXgiLCJzZXRQb3J0Iiwic2V0TG9jYWxlIiwic2V0SG9zdCIsInNldFNjaGVtZSIsInJvdXRlc18iLCJPYmplY3QiLCJmcmVlemUiLCJnZXRSb3V0ZXMiLCJnZXRCYXNlVXJsIiwiZ2V0U2NoZW1lIiwiZ2V0SG9zdCIsImdldFBvcnQiLCJnZXRMb2NhbGUiLCJidWlsZFF1ZXJ5UGFyYW1zIiwibiIsInIiLCJzIiwiUmVnRXhwIiwiQXJyYXkiLCJmb3JFYWNoIiwidGVzdCIsIl90eXBlb2YiLCJnZXRSb3V0ZSIsIkVycm9yIiwiZ2VuZXJhdGUiLCJwIiwiaSIsInUiLCJhc3NpZ24iLCJjIiwiYSIsInRva2VucyIsImVuY29kZVBhdGhDb21wb25lbnQiLCJsZW5ndGgiLCJkZWZhdWx0cyIsImlzQXJyYXkiLCJob3N0dG9rZW5zIiwicmVxdWlyZW1lbnRzIiwiX3NjaGVtZSIsImluZGV4T2YiLCJzY2hlbWVzIiwia2V5cyIsImYiLCJoIiwicHVzaCIsImVuY29kZVF1ZXJ5Q29tcG9uZW50IiwiaGFzT3duUHJvcGVydHkiLCJqb2luIiwiY3VzdG9tRW5jb2RlVVJJQ29tcG9uZW50IiwiZW5jb2RlVVJJQ29tcG9uZW50IiwicmVwbGFjZSIsImRlZmluZSIsImFtZCIsIm1vZHVsZSIsImV4cG9ydHMiLCJmb3MiXSwic291cmNlUm9vdCI6IiJ9