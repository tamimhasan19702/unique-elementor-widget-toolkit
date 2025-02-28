/** @format */

!(function (e) {
  "function" == typeof define && define.amd
    ? define([], e)
    : "undefined" != typeof module && null !== module && module.exports
    ? (module.exports = e)
    : e();
})(function () {
  var e = Object.assign || (window.jQuery && jQuery.extend),
    t = 8,
    n =
      window.requestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.mozRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      window.msRequestAnimationFrame ||
      function (e, t) {
        return window.setTimeout(function () {
          e();
        }, 25);
      };
  !(function () {
    if ("function" == typeof window.CustomEvent) return !1;
    function e(e, t) {
      t = t || { bubbles: !1, cancelable: !1, detail: void 0 };
      var n = document.createEvent("CustomEvent");
      return n.initCustomEvent(e, t.bubbles, t.cancelable, t.detail), n;
    }
    (e.prototype = window.Event.prototype), (window.CustomEvent = e);
  })();
  var i = { textarea: !0, input: !0, select: !0, button: !0 },
    o = { move: "mousemove", cancel: "mouseup dragstart", end: "mouseup" },
    a = { move: "touchmove", cancel: "touchend", end: "touchend" },
    c = /\s+/,
    r = { bubbles: !0, cancelable: !0 },
    u = "function" == typeof Symbol ? Symbol("events") : {};
  function s(e) {
    return e[u] || (e[u] = {});
  }
  function d(e, t, n, i, o) {
    t = t.split(c);
    var a,
      r = s(e),
      u = t.length;
    function d(e) {
      n(e, i);
    }
    for (; u--; )
      (r[(a = t[u])] || (r[a] = [])).push([n, d]), e.addEventListener(a, d);
  }
  function f(e, t, n, i) {
    t = t.split(c);
    var o,
      a,
      r,
      u = s(e),
      d = t.length;
    if (u)
      for (; d--; )
        if ((a = u[(o = t[d])]))
          for (r = a.length; r--; )
            a[r][0] === n &&
              (e.removeEventListener(o, a[r][1]), a.splice(r, 1));
  }
  function v(t, n, i) {
    var o = new CustomEvent(n, r);
    i && e(o, i), t.dispatchEvent(o);
  }
  function p(e) {
    var t = e,
      i = !1,
      o = !1;
    function a(e) {
      i ? (t(), n(a), (o = !0), (i = !1)) : (o = !1);
    }
    (this.kick = function (e) {
      (i = !0), o || a();
    }),
      (this.end = function (e) {
        var n = t;
        e &&
          (o
            ? ((t = i
                ? function () {
                    n(), e();
                  }
                : e),
              (i = !0))
            : e());
      });
  }
  function m() {}
  function l(e) {
    e.preventDefault();
  }
  function h(e, t) {
    var n, i;
    if (e.identifiedTouch) return e.identifiedTouch(t);
    for (n = -1, i = e.length; ++n < i; )
      if (e[n].identifier === t) return e[n];
  }
  function g(e, t) {
    var n = h(e.changedTouches, t.identifier);
    if (n && (n.pageX !== t.pageX || n.pageY !== t.pageY)) return n;
  }
  function w(e, t) {
    b(e, t, e, X);
  }
  function Y(e, t) {
    X();
  }
  function X() {
    f(document, o.move, w), f(document, o.cancel, Y);
  }
  function y(e) {
    f(document, a.move, e.touchmove), f(document, a.cancel, e.touchend);
  }
  function b(e, n, i, o) {
    var a = i.pageX - n.pageX,
      c = i.pageY - n.pageY;
    a * a + c * c < t * t ||
      (function (e, t, n, i, o, a) {
        var c = e.targetTouches,
          r = e.timeStamp - t.timeStamp,
          u = {
            altKey: e.altKey,
            ctrlKey: e.ctrlKey,
            shiftKey: e.shiftKey,
            startX: t.pageX,
            startY: t.pageY,
            distX: i,
            distY: o,
            deltaX: i,
            deltaY: o,
            pageX: n.pageX,
            pageY: n.pageY,
            velocityX: i / r,
            velocityY: o / r,
            identifier: t.identifier,
            targetTouches: c,
            finger: c ? c.length : 1,
            enableMove: function () {
              (this.moveEnabled = !0),
                (this.enableMove = m),
                e.preventDefault();
            },
          };
        v(t.target, "movestart", u), a(t);
      })(e, n, i, a, c, o);
  }
  function T(e, t) {
    var n = t.timer;
    (t.touch = e), (t.timeStamp = e.timeStamp), n.kick();
  }
  function C(e, t) {
    var n = t.target,
      i = t.event,
      a = t.timer;
    f(document, o.move, T),
      f(document, o.end, C),
      x(n, i, a, function () {
        setTimeout(function () {
          f(n, "click", l);
        }, 0);
      });
  }
  function x(e, t, n, i) {
    n.end(function () {
      return v(e, "moveend", t), i && i();
    });
  }
  if (
    (d(document, "mousedown", function (e) {
      (function (e) {
        return 1 === e.which && !e.ctrlKey && !e.altKey;
      })(e) &&
        ((function (e) {
          return !!i[e.target.tagName.toLowerCase()];
        })(e) ||
          (d(document, o.move, w, e), d(document, o.cancel, Y, e)));
    }),
    d(document, "touchstart", function (e) {
      if (!i[e.target.tagName.toLowerCase()]) {
        var t = e.changedTouches[0],
          n = {
            target: t.target,
            pageX: t.pageX,
            pageY: t.pageY,
            identifier: t.identifier,
            touchmove: function (e, t) {
              !(function (e, t) {
                var n = g(e, t);
                n && b(e, t, n, y);
              })(e, t);
            },
            touchend: function (e, t) {
              !(function (e, t) {
                h(e.changedTouches, t.identifier) && y(t);
              })(e, t);
            },
          };
        d(document, a.move, n.touchmove, n),
          d(document, a.cancel, n.touchend, n);
      }
    }),
    d(document, "movestart", function (e) {
      if (!e.defaultPrevented && e.moveEnabled) {
        var t = {
            startX: e.startX,
            startY: e.startY,
            pageX: e.pageX,
            pageY: e.pageY,
            distX: e.distX,
            distY: e.distY,
            deltaX: e.deltaX,
            deltaY: e.deltaY,
            velocityX: e.velocityX,
            velocityY: e.velocityY,
            identifier: e.identifier,
            targetTouches: e.targetTouches,
            finger: e.finger,
          },
          n = {
            target: e.target,
            event: t,
            timer: new p(function (e) {
              (function (e, t, n) {
                var i = n - e.timeStamp;
                (e.distX = t.pageX - e.startX),
                  (e.distY = t.pageY - e.startY),
                  (e.deltaX = t.pageX - e.pageX),
                  (e.deltaY = t.pageY - e.pageY),
                  (e.velocityX = 0.3 * e.velocityX + (0.7 * e.deltaX) / i),
                  (e.velocityY = 0.3 * e.velocityY + (0.7 * e.deltaY) / i),
                  (e.pageX = t.pageX),
                  (e.pageY = t.pageY);
              })(t, n.touch, n.timeStamp),
                v(n.target, "move", t);
            }),
            touch: void 0,
            timeStamp: e.timeStamp,
          };
        void 0 === e.identifier
          ? (d(e.target, "click", l),
            d(document, o.move, T, n),
            d(document, o.end, C, n))
          : ((n.activeTouchmove = function (e, t) {
              !(function (e, t) {
                var n = t.event,
                  i = t.timer,
                  o = g(e, n);
                o &&
                  (e.preventDefault(),
                  (n.targetTouches = e.targetTouches),
                  (t.touch = o),
                  (t.timeStamp = e.timeStamp),
                  i.kick());
              })(e, t);
            }),
            (n.activeTouchend = function (e, t) {
              !(function (e, t) {
                var n = t.target,
                  i = t.event,
                  o = t.timer;
                h(e.changedTouches, i.identifier) &&
                  ((function (e) {
                    f(document, a.move, e.activeTouchmove),
                      f(document, a.end, e.activeTouchend);
                  })(t),
                  x(n, i, o));
              })(e, t);
            }),
            d(document, a.move, n.activeTouchmove, n),
            d(document, a.end, n.activeTouchend, n));
      }
    }),
    window.jQuery)
  ) {
    var _ =
      "startX startY pageX pageY distX distY deltaX deltaY velocityX velocityY".split(
        " "
      );
    (jQuery.event.special.movestart = {
      setup: function () {
        return d(this, "movestart", E), !1;
      },
      teardown: function () {
        return f(this, "movestart", E), !1;
      },
      add: j,
    }),
      (jQuery.event.special.move = {
        setup: function () {
          return d(this, "movestart", S), !1;
        },
        teardown: function () {
          return f(this, "movestart", S), !1;
        },
        add: j,
      }),
      (jQuery.event.special.moveend = {
        setup: function () {
          return d(this, "movestart", k), !1;
        },
        teardown: function () {
          return f(this, "movestart", k), !1;
        },
        add: j,
      });
  }
  function E(e) {
    e.enableMove();
  }
  function S(e) {
    e.enableMove();
  }
  function k(e) {
    e.enableMove();
  }
  function j(e) {
    var t = e.handler;
    e.handler = function (e) {
      for (var n, i = _.length; i--; ) e[(n = _[i])] = e.originalEvent[n];
      t.apply(this, arguments);
    };
  }
}),
  (function (e) {
    e.fn.uewtkCompare = function (t) {
      return (
        (t = e.extend(
          {
            default_offset_pct: 0.5,
            orientation: "horizontal",
            move_on_hover: !1,
            is_wiggle: !1,
            wiggle_timeout: 1e3,
          },
          t
        )),
        this.each(function () {
          var n = t.default_offset_pct,
            i = e(this),
            o = t.orientation,
            a = "vertical" === o ? "down" : "left",
            c = "vertical" === o ? "up" : "right",
            r = t.move_on_hover,
            u = t.is_wiggle,
            s = t.wiggle_timeout;
          i.wrap(
            "<div class='uewtk-compare-wrapper uewtk-compare-" + o + "'></div>"
          );
          var d = i.find("img:first"),
            f = i.find("img:last");
          i.append("<div class='uewtk-compare-handle'></div>");
          var v = i.find(".uewtk-compare-handle");
          v.append("<span class='uewtk-compare-" + a + "-arrow'></span>"),
            v.append("<span class='uewtk-compare-" + c + "-arrow'></span>"),
            i.addClass("uewtk-compare-container"),
            d.addClass("uewtk-compare-before"),
            f.addClass("uewtk-compare-after");
          var p = function (e) {
            var t = (function (e) {
              var t = d.width(),
                n = d.height();
              return {
                w: t + "px",
                h: n + "px",
                wp: 100 * e,
                cw: e * t + "px",
                ch: e * n + "px",
              };
            })(e);
            v.css(
              "vertical" === o ? "top" : "left",
              "vertical" === o ? t.ch : t.cw
            ),
              (function (e) {
                "vertical" === o
                  ? (d.css("clip", "rect(0," + e.w + "," + e.ch + ",0)"),
                    i.css("height", e.h))
                  : "sides" === o
                  ? (d.css(
                      "clip-path",
                      "polygon(0 100%, 0 0," +
                        (e.wp - 10) +
                        "% 0%," +
                        (e.wp + 10) +
                        "% 100%)"
                    ),
                    i.css("height", e.h))
                  : "sides-right" === o
                  ? (d.css(
                      "clip-path",
                      "polygon(0 100%, 0 0," +
                        (e.wp + 10) +
                        "% 0%," +
                        (e.wp - 10) +
                        "% 100%)"
                    ),
                    i.css("height", e.h))
                  : (d.css("clip", "rect(0," + e.cw + "," + e.h + ",0)"),
                    i.css("height", e.h));
              })(t);
          };
          e(window).on("resize.uewtkCompare", function (e) {
            p(n);
          });
          var m = 0,
            l = 0;
          v.on("movestart", function (e) {
            ((e.distX > e.distY && e.distX < -e.distY) ||
              (e.distX < e.distY && e.distX > -e.distY)) &&
            "vertical" !== o
              ? e.preventDefault()
              : ((e.distX < e.distY && e.distX < -e.distY) ||
                  (e.distX > e.distY && e.distX > -e.distY)) &&
                "vertical" === o &&
                e.preventDefault(),
              i.addClass("active"),
              (m = i.offset().left),
              (offsetY = i.offset().top),
              (l = d.width()),
              (imgHeight = d.height());
          }),
            v.on("moveend", function (e) {
              r || i.removeClass("active");
            }),
            v.on("move", function (e) {
              i.hasClass("active") &&
                ((n =
                  "vertical" === o
                    ? (e.pageY - offsetY) / imgHeight
                    : (e.pageX - m) / l) < 0 && (n = 0),
                n > 1 && (n = 1),
                p(n));
            }),
            i.find("img").on("mousedown", function (e) {
              e.preventDefault();
            }),
            r &&
              (i.on("mouseenter", function (e) {
                i.addClass("active"),
                  (m = i.offset().left),
                  (offsetY = i.offset().top),
                  (l = d.width()),
                  (imgHeight = d.height());
              }),
              i.on("mouseleave", function (e) {
                i.removeClass("active");
              }),
              i.on("mousemove", function (e) {
                i.hasClass("active") &&
                  ((n =
                    "vertical" === o
                      ? (e.pageY - offsetY) / imgHeight
                      : (e.pageX - m) / l) < 0 && (n = 0),
                  n > 1 && (n = 1),
                  p(n));
              })),
            e(window).trigger("resize.uewtkCompare"),
            u &&
              setTimeout(function () {
                var e = t.default_offset_pct,
                  n = 0,
                  o = 0,
                  a = 1,
                  c = setInterval(function () {
                    i.hasClass("active") && clearInterval(c),
                      n > 0.06 && (a = -1),
                      n < -0.06 && (a = 1),
                      (n += 0.012 * a),
                      (pct = n + e),
                      pct < 0 && (pct = 0),
                      pct > 1 && (pct = 1),
                      p(pct),
                      0 == n.toFixed(2) && o++,
                      o > 2 && clearInterval(c);
                  }, 50);
              }, s),
            v.on("touchmove", function (e) {
              e.preventDefault();
            });
        })
      );
    };
  })(jQuery);
