/** @format */

!(function (t, e, n) {
  "use strict";
  function i(e, o, a) {
    var r = this;
    if (t.data(e, "cubeportfolio"))
      throw new Error(
        "cubeportfolio is already initialized. Destroy it before initialize again!"
      );
    (r.obj = e),
      (r.$obj = t(e)),
      t.data(r.obj, "cubeportfolio", r),
      o &&
        o.sortToPreventGaps !== n &&
        ((o.sortByDimension = o.sortToPreventGaps), delete o.sortToPreventGaps),
      (r.options = t.extend(
        {},
        t.fn.cubeportfolio.options,
        o,
        r.$obj.data("uewtk-options")
      )),
      (r.isAnimating = !0),
      (r.defaultFilter = r.options.defaultFilter),
      (r.registeredEvents = []),
      (r.queue = []),
      (r.addedWrapp = !1),
      t.isFunction(a) && r.registerEvent("initFinish", a, !0);
    var s = r.$obj.children();
    r.$obj.addClass("uewtk"),
      (0 !== s.length && !s.first().hasClass("uewtk-item")) ||
        (r.wrapInner(r.obj, "uewtk-wrapper"), (r.addedWrapp = !0)),
      (r.$ul = r.$obj.children().addClass("uewtk-wrapper")),
      r.wrapInner(r.obj, "uewtk-wrapper-outer"),
      (r.wrapper = r.$obj.children(".uewtk-wrapper-outer")),
      (r.blocks = r.$ul.children(".uewtk-item")),
      (r.blocksOn = r.blocks),
      r.wrapInner(r.blocks, "uewtk-item-wrapper"),
      (r.plugins = {}),
      t.each(i.plugins, function (t, e) {
        var n = e(r);
        n && (r.plugins[t] = n);
      }),
      r.triggerEvent("afterPlugins"),
      (r.removeAttrAfterStoreData = t.Deferred()),
      r.loadImages(r.$obj, r.display);
  }
  t.extend(i.prototype, {
    storeData: function (e, n) {
      var i = this;
      (n = n || 0),
        e.each(function (e, o) {
          var a = t(o),
            r = a.width(),
            s = a.height();
          a.data("uewtk", {
            index: n + e,
            indexInitial: n + e,
            wrapper: a.children(".uewtk-item-wrapper"),
            widthInitial: r,
            heightInitial: s,
            width: r,
            height: s,
            widthAndGap: r + i.options.gapVertical,
            heightAndGap: s + i.options.gapHorizontal,
            left: null,
            leftNew: null,
            top: null,
            topNew: null,
            pack: !1,
          });
        }),
        this.removeAttrAfterStoreData.resolve();
    },
    wrapInner: function (t, i) {
      var o, a, r;
      if (((i = i || ""), !(t.length && t.length < 1)))
        for (t.length === n && (t = [t]), a = t.length - 1; 0 <= a; a--) {
          for (
            o = t[a], (r = e.createElement("div")).setAttribute("class", i);
            o.childNodes.length;

          )
            r.appendChild(o.childNodes[0]);
          o.appendChild(r);
        }
    },
    removeAttrImage: function (t) {
      this.removeAttrAfterStoreData.then(function () {
        t.removeAttribute("width"),
          t.removeAttribute("height"),
          t.removeAttribute("style");
      });
    },
    loadImages: function (e, n) {
      var i = this;
      requestAnimationFrame(function () {
        var o = e.find("img").map(function (e, n) {
            var o;
            return n.hasAttribute("width") && n.hasAttribute("height")
              ? ((n.style.width = n.getAttribute("width") + "px"),
                (n.style.height = n.getAttribute("height") + "px"),
                n.hasAttribute("data-uewtk-src") ||
                  (null === i.checkSrc(n)
                    ? i.removeAttrImage(n)
                    : ((o = t("<img>")).on(
                        "load.uewtk error.uewtk",
                        function () {
                          t(this).off("load.uewtk error.uewtk"),
                            i.removeAttrImage(n);
                        }
                      ),
                      n.srcset
                        ? (o.attr("sizes", n.sizes || "100vw"),
                          o.attr("srcset", n.srcset))
                        : o.attr("src", n.src))),
                null)
              : i.checkSrc(n);
          }),
          a = o.length;
        0 !== a
          ? t.each(o, function (e, o) {
              var r = t("<img>");
              r.on("load.uewtk error.uewtk", function () {
                t(this).off("load.uewtk error.uewtk"), 0 == --a && n.call(i);
              }),
                o.srcset
                  ? (r.attr("sizes", o.sizes), r.attr("srcset", o.srcset))
                  : r.attr("src", o.src);
            })
          : n.call(i);
      });
    },
    checkSrc: function (e) {
      var i = e.srcset,
        o = e.src;
      if ("" === o) return null;
      var a = t("<img>");
      i
        ? (a.attr("sizes", e.sizes || "100vw"), a.attr("srcset", i))
        : a.attr("src", o);
      var r = a[0];
      return r.complete && r.naturalWidth !== n && 0 !== r.naturalWidth
        ? null
        : r;
    },
    display: function () {
      var t = this;
      (t.width = t.$obj.outerWidth()),
        t.triggerEvent("initStartRead"),
        t.triggerEvent("initStartWrite"),
        0 < t.width && (t.storeData(t.blocks), t.layoutAndAdjustment()),
        t.triggerEvent("initEndRead"),
        t.triggerEvent("initEndWrite"),
        t.$obj.addClass("uewtk-ready"),
        t.runQueue("delayFrame", t.delayFrame);
    },
    delayFrame: function () {
      var t = this;
      requestAnimationFrame(function () {
        t.resizeEvent(),
          t.triggerEvent("initFinish"),
          (t.isAnimating = !1),
          t.$obj.trigger("initComplete.uewtk");
      });
    },
    resizeEvent: function () {
      var t = this;
      i.private.resize.initEvent({
        instance: t,
        fn: function () {
          t.triggerEvent("beforeResizeGrid");
          var e = t.$obj.outerWidth();
          e &&
            t.width !== e &&
            ((t.width = e),
            "alignCenter" === t.options.gridAdjustment &&
              (t.wrapper[0].style.maxWidth = ""),
            t.layoutAndAdjustment(),
            t.triggerEvent("resizeGrid")),
            t.triggerEvent("resizeWindow");
        },
      });
    },
    gridAdjust: function () {
      var e = this;
      "responsive" === e.options.gridAdjustment
        ? e.responsiveLayout()
        : (e.blocks.removeAttr("style"),
          e.blocks.each(function (n, i) {
            var o = t(i).data("uewtk"),
              a = i.getBoundingClientRect(),
              r = e.columnWidthTruncate(a.right - a.left),
              s = Math.round(a.bottom - a.top);
            (o.height = s),
              (o.heightAndGap = s + e.options.gapHorizontal),
              (o.width = r),
              (o.widthAndGap = r + e.options.gapVertical);
          }),
          (e.widthAvailable = e.width + e.options.gapVertical)),
        e.triggerEvent("gridAdjust");
    },
    layoutAndAdjustment: function (t) {
      t && (this.width = this.$obj.outerWidth()),
        this.gridAdjust(),
        this.layout();
    },
    layout: function () {
      var e = this;
      e.computeBlocks(e.filterConcat(e.defaultFilter)),
        "slider" === e.options.layoutMode
          ? (e.sliderLayoutReset(), e.sliderLayout())
          : (e.mosaicLayoutReset(), e.mosaicLayout()),
        e.blocksOff.addClass("uewtk-item-off"),
        e.blocksOn.removeClass("uewtk-item-off").each(function (e, n) {
          var i = t(n).data("uewtk");
          (i.left = i.leftNew),
            (i.top = i.topNew),
            (n.style.left = i.left + "px"),
            (n.style.top = i.top + "px");
        }),
        e.resizeMainContainer();
    },
    computeFilter: function (t) {
      this.computeBlocks(t),
        this.mosaicLayoutReset(),
        this.mosaicLayout(),
        this.filterLayout();
    },
    filterLayout: function () {
      this.blocksOff.addClass("uewtk-item-off"),
        this.blocksOn.removeClass("uewtk-item-off").each(function (e, n) {
          var i = t(n).data("uewtk");
          (i.left = i.leftNew),
            (i.top = i.topNew),
            (n.style.left = i.left + "px"),
            (n.style.top = i.top + "px");
        }),
        this.resizeMainContainer(),
        this.filterFinish();
    },
    filterFinish: function () {
      (this.isAnimating = !1),
        this.$obj.trigger("filterComplete.uewtk"),
        this.triggerEvent("filterFinish");
    },
    computeBlocks: function (t) {
      var e = this;
      (e.blocksOnInitial = e.blocksOn),
        (e.blocksOn = e.blocks.filter(t)),
        (e.blocksOff = e.blocks.not(t)),
        e.triggerEvent("computeBlocksFinish", t);
    },
    responsiveLayout: function () {
      var e = this;
      (e.cols =
        e[
          t.isArray(e.options.mediaQueries)
            ? "getColumnsBreakpoints"
            : "getColumnsAuto"
        ]()),
        (e.columnWidth = e.columnWidthTruncate(
          (e.width + e.options.gapVertical) / e.cols
        )),
        (e.widthAvailable = e.columnWidth * e.cols),
        "mosaic" === e.options.layoutMode && e.getMosaicWidthReference(),
        e.blocks.each(function (n, i) {
          var o,
            a = t(i).data("uewtk"),
            r = 1;
          "mosaic" === e.options.layoutMode &&
            (r = e.getColsMosaic(a.widthInitial)),
            (o = e.columnWidth * r - e.options.gapVertical),
            (i.style.width = o + "px"),
            (a.width = o),
            (a.widthAndGap = o + e.options.gapVertical),
            (i.style.height = "");
        });
      var n = [];
      e.blocks.each(function (e, i) {
        t.each(t(i).find("img").filter("[width][height]"), function (e, i) {
          var o = 0;
          t(i)
            .parentsUntil(".uewtk-item")
            .each(function (e, n) {
              var i = t(n).width();
              if (0 < i) return (o = i), !1;
            });
          var a = parseInt(i.getAttribute("width"), 10),
            r = parseInt(i.getAttribute("height"), 10),
            s = parseFloat((a / r).toFixed(10));
          n.push({ el: i, width: o, height: Math.round(o / s) });
        });
      }),
        t.each(n, function (t, e) {
          (e.el.width = e.width),
            (e.el.height = e.height),
            (e.el.style.width = e.width + "px"),
            (e.el.style.height = e.height + "px");
        }),
        e.blocks.each(function (n, i) {
          var o = t(i).data("uewtk"),
            a = i.getBoundingClientRect(),
            r = Math.round(a.bottom - a.top);
          (o.height = r), (o.heightAndGap = r + e.options.gapHorizontal);
        });
    },
    getMosaicWidthReference: function () {
      var e = [];
      this.blocks.each(function (n, i) {
        var o = t(i).data("uewtk");
        e.push(o.widthInitial);
      }),
        e.sort(function (t, e) {
          return t - e;
        }),
        e[0]
          ? (this.mosaicWidthReference = e[0])
          : (this.mosaicWidthReference = this.columnWidth);
    },
    getColsMosaic: function (t) {
      if (t === this.width) return this.cols;
      var e =
        0.79 <= (e = t / this.mosaicWidthReference) % 1
          ? Math.ceil(e)
          : Math.floor(e);
      return Math.min(Math.max(e, 1), this.cols);
    },
    getColumnsAuto: function () {
      if (0 === this.blocks.length) return 1;
      var t =
        this.blocks.first().data("uewtk").widthInitial +
        this.options.gapVertical;
      return Math.max(Math.round(this.width / t), 1);
    },
    getColumnsBreakpoints: function () {
      var e,
        n = window.innerWidth;
      if (document.body.className.match("elementor-editor-active"))
        for (
          var i = document.getElementsByClassName(
              "elementor-preview-responsive-wrapper"
            ),
            o = 0,
            a = i.length;
          o < a;
          o++
        )
          n = i[o].clientWidth;
      return (
        t.each(this.options.mediaQueries, function (t, i) {
          if (n >= i.width) return (e = i), !1;
        }),
        (e =
          e || this.options.mediaQueries[this.options.mediaQueries.length - 1]),
        this.triggerEvent("onMediaQueries", e.options),
        e.cols
      );
    },
    columnWidthTruncate: function (t) {
      return Math.floor(t);
    },
    resizeMainContainer: function () {
      var e,
        o = this,
        a = Math.max(
          o.freeSpaces.slice(-1)[0].topStart - o.options.gapHorizontal,
          0
        );
      "alignCenter" === o.options.gridAdjustment &&
        ((e = 0),
        o.blocksOn.each(function (n, i) {
          var o = t(i).data("uewtk"),
            a = o.left + o.width;
          e < a && (e = a);
        }),
        (o.wrapper[0].style.maxWidth = e + "px")),
        a !== o.height &&
          ((o.obj.style.height = a + "px"),
          o.height !== n &&
            (i.private.modernBrowser
              ? o.$obj.one(i.private.transitionend, function () {
                  o.$obj.trigger("pluginResize.uewtk");
                })
              : o.$obj.trigger("pluginResize.uewtk")),
          (o.height = a)),
        o.triggerEvent("resizeMainContainer");
    },
    filterConcat: function (t) {
      return t.replace(/\|/gi, "");
    },
    pushQueue: function (t, e) {
      (this.queue[t] = this.queue[t] || []), this.queue[t].push(e);
    },
    runQueue: function (e, n) {
      var i = this.queue[e] || [];
      t.when.apply(t, i).then(t.proxy(n, this));
    },
    clearQueue: function (t) {
      this.queue[t] = [];
    },
    registerEvent: function (t, e, n) {
      this.registeredEvents[t] || (this.registeredEvents[t] = []),
        this.registeredEvents[t].push({ func: e, oneTime: n || !1 });
    },
    triggerEvent: function (t, e) {
      var n,
        i,
        o = this;
      if (o.registeredEvents[t])
        for (n = 0, i = o.registeredEvents[t].length; n < i; n++)
          o.registeredEvents[t][n].func.call(o, e),
            o.registeredEvents[t][n].oneTime &&
              (o.registeredEvents[t].splice(n, 1), n--, i--);
    },
    addItems: function (e, n, o) {
      var a = this;
      a.wrapInner(e, "uewtk-item-wrapper"),
        a.$ul[o](
          e.addClass("uewtk-item-loading").css({ top: "100%", left: 0 })
        ),
        i.private.modernBrowser
          ? e.last().one(i.private.animationend, function () {
              a.addItemsFinish(e, n);
            })
          : a.addItemsFinish(e, n),
        a.loadImages(e, function () {
          var n;
          a.$obj.addClass("uewtk-updateItems"),
            "append" === o
              ? (a.storeData(e, a.blocks.length), t.merge(a.blocks, e))
              : (a.storeData(e),
                (n = e.length),
                a.blocks.each(function (e, i) {
                  t(i).data("uewtk").index = n + e;
                }),
                (a.blocks = t.merge(e, a.blocks))),
            a.triggerEvent("addItemsToDOM", e),
            a.triggerEvent("triggerSort"),
            a.layoutAndAdjustment(!0),
            a.elems && i.public.showCounter.call(a.obj, a.elems);
        });
    },
    addItemsFinish: function (e, n) {
      (this.isAnimating = !1),
        this.$obj.removeClass("uewtk-updateItems"),
        e.removeClass("uewtk-item-loading"),
        t.isFunction(n) && n.call(this, e),
        this.$obj.trigger("onAfterLoadMore.uewtk", [e]);
    },
    removeItems: function (e, n) {
      var o = this;
      o.$obj.addClass("uewtk-updateItems"),
        i.private.modernBrowser
          ? e.last().one(i.private.animationend, function () {
              o.removeItemsFinish(e, n);
            })
          : o.removeItemsFinish(e, n),
        e.each(function (e, n) {
          o.blocks.each(function (e, a) {
            var r;
            n === a &&
              ((r = t(a)),
              o.blocks.splice(e, 1),
              i.private.modernBrowser
                ? (r.one(i.private.animationend, function () {
                    r.remove();
                  }),
                  r.addClass("uewtk-removeItem"))
                : r.remove());
          });
        }),
        o.blocks.each(function (e, n) {
          t(n).data("uewtk").index = e;
        }),
        o.triggerEvent("triggerSort"),
        o.layoutAndAdjustment(!0),
        o.elems && i.public.showCounter.call(o.obj, o.elems);
    },
    removeItemsFinish: function (e, n) {
      (this.isAnimating = !1),
        this.$obj.removeClass("uewtk-updateItems"),
        t.isFunction(n) && n.call(this, e);
    },
  }),
    (t.fn.cubeportfolio = function (t, e, n) {
      return this.each(function () {
        if ("object" == typeof t || !t) return i.public.init.call(this, t, e);
        if (i.public[t]) return i.public[t].call(this, e, n);
        throw new Error(
          "Method " + t + " does not exist on jquery.cubeportfolio.js"
        );
      });
    }),
    (i.plugins = {}),
    (t.fn.cubeportfolio.constructor = i);
})(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    t.extend(e.prototype, {
      mosaicLayoutReset: function () {
        var e = this;
        (e.blocksAreSorted = !1),
          e.blocksOn.each(function (n, i) {
            (t(i).data("uewtk").pack = !1),
              e.options.sortByDimension && (i.style.height = "");
          }),
          (e.freeSpaces = [
            {
              leftStart: 0,
              leftEnd: e.widthAvailable,
              topStart: 0,
              topEnd: Math.pow(2, 18),
            },
          ]);
      },
      mosaicLayout: function () {
        for (var t = this, e = 0, n = t.blocksOn.length; e < n; e++) {
          var i = t.getSpaceIndexAndBlock();
          if (null === i)
            return (
              t.mosaicLayoutReset(),
              (t.blocksAreSorted = !0),
              t.sortBlocks(t.blocksOn, "widthAndGap", "heightAndGap", !0),
              void t.mosaicLayout()
            );
          t.generateF1F2(i.spaceIndex, i.dataBlock),
            t.generateG1G2G3G4(i.dataBlock),
            t.cleanFreeSpaces(),
            t.addHeightToBlocks();
        }
        t.blocksAreSorted && t.sortBlocks(t.blocksOn, "topNew", "leftNew");
      },
      getSpaceIndexAndBlock: function () {
        var e = this,
          n = null;
        return (
          t.each(e.freeSpaces, function (i, o) {
            var a = o.leftEnd - o.leftStart,
              r = o.topEnd - o.topStart;
            return (
              e.blocksOn.each(function (e, s) {
                var l = t(s).data("uewtk");
                if (!0 !== l.pack)
                  return l.widthAndGap <= a && l.heightAndGap <= r
                    ? ((l.pack = !0),
                      (n = { spaceIndex: i, dataBlock: l }),
                      (l.leftNew = o.leftStart),
                      (l.topNew = o.topStart),
                      !1)
                    : void 0;
              }),
              !e.blocksAreSorted && e.options.sortByDimension && 0 < i
                ? ((n = null), !1)
                : null === n && void 0
            );
          }),
          n
        );
      },
      generateF1F2: function (t, e) {
        var n = this.freeSpaces[t],
          i = {
            leftStart: n.leftStart + e.widthAndGap,
            leftEnd: n.leftEnd,
            topStart: n.topStart,
            topEnd: n.topEnd,
          },
          o = {
            leftStart: n.leftStart,
            leftEnd: n.leftEnd,
            topStart: n.topStart + e.heightAndGap,
            topEnd: n.topEnd,
          };
        this.freeSpaces.splice(t, 1),
          i.leftStart < i.leftEnd &&
            i.topStart < i.topEnd &&
            (this.freeSpaces.splice(t, 0, i), t++),
          o.leftStart < o.leftEnd &&
            o.topStart < o.topEnd &&
            this.freeSpaces.splice(t, 0, o);
      },
      generateG1G2G3G4: function (e) {
        var n = this,
          i = [];
        t.each(n.freeSpaces, function (t, o) {
          var a = n.intersectSpaces(o, e);
          null !== a
            ? (n.generateG1(o, a, i),
              n.generateG2(o, a, i),
              n.generateG3(o, a, i),
              n.generateG4(o, a, i))
            : i.push(o);
        }),
          (n.freeSpaces = i);
      },
      intersectSpaces: function (t, e) {
        var n = {
          leftStart: e.leftNew,
          leftEnd: e.leftNew + e.widthAndGap,
          topStart: e.topNew,
          topEnd: e.topNew + e.heightAndGap,
        };
        if (
          t.leftStart === n.leftStart &&
          t.leftEnd === n.leftEnd &&
          t.topStart === n.topStart &&
          t.topEnd === n.topEnd
        )
          return null;
        var i = Math.max(t.leftStart, n.leftStart),
          o = Math.min(t.leftEnd, n.leftEnd),
          a = Math.max(t.topStart, n.topStart),
          r = Math.min(t.topEnd, n.topEnd);
        return o <= i || r <= a
          ? null
          : { leftStart: i, leftEnd: o, topStart: a, topEnd: r };
      },
      generateG1: function (t, e, n) {
        t.topStart !== e.topStart &&
          n.push({
            leftStart: t.leftStart,
            leftEnd: t.leftEnd,
            topStart: t.topStart,
            topEnd: e.topStart,
          });
      },
      generateG2: function (t, e, n) {
        t.leftEnd !== e.leftEnd &&
          n.push({
            leftStart: e.leftEnd,
            leftEnd: t.leftEnd,
            topStart: t.topStart,
            topEnd: t.topEnd,
          });
      },
      generateG3: function (t, e, n) {
        t.topEnd !== e.topEnd &&
          n.push({
            leftStart: t.leftStart,
            leftEnd: t.leftEnd,
            topStart: e.topEnd,
            topEnd: t.topEnd,
          });
      },
      generateG4: function (t, e, n) {
        t.leftStart !== e.leftStart &&
          n.push({
            leftStart: t.leftStart,
            leftEnd: e.leftStart,
            topStart: t.topStart,
            topEnd: t.topEnd,
          });
      },
      cleanFreeSpaces: function () {
        this.freeSpaces.sort(function (t, e) {
          return t.topStart > e.topStart
            ? 1
            : t.topStart < e.topStart
            ? -1
            : t.leftStart > e.leftStart
            ? 1
            : t.leftStart < e.leftStart
            ? -1
            : 0;
        }),
          this.correctSubPixelValues(),
          this.removeNonMaximalFreeSpaces();
      },
      correctSubPixelValues: function () {
        for (var t, e, n = 0, i = this.freeSpaces.length - 1; n < i; n++)
          (t = this.freeSpaces[n]),
            (e = this.freeSpaces[n + 1]).topStart - t.topStart <= 1 &&
              (e.topStart = t.topStart);
      },
      removeNonMaximalFreeSpaces: function () {
        var e = this;
        e.uniqueFreeSpaces(),
          (e.freeSpaces = t.map(e.freeSpaces, function (n, i) {
            return (
              t.each(e.freeSpaces, function (t, e) {
                if (i !== t)
                  return e.leftStart <= n.leftStart &&
                    e.leftEnd >= n.leftEnd &&
                    e.topStart <= n.topStart &&
                    e.topEnd >= n.topEnd
                    ? ((n = null), !1)
                    : void 0;
              }),
              n
            );
          }));
      },
      uniqueFreeSpaces: function () {
        var e = [];
        t.each(this.freeSpaces, function (n, i) {
          t.each(e, function (t, e) {
            if (
              e.leftStart === i.leftStart &&
              e.leftEnd === i.leftEnd &&
              e.topStart === i.topStart &&
              e.topEnd === i.topEnd
            )
              return (i = null), !1;
          }),
            null !== i && e.push(i);
        }),
          (this.freeSpaces = e);
      },
      addHeightToBlocks: function () {
        var e = this;
        t.each(e.freeSpaces, function (n, i) {
          e.blocksOn.each(function (n, o) {
            var a = t(o).data("uewtk");
            !0 === a.pack &&
              e.intersectSpaces(i, a) &&
              -1 == i.topStart - a.topNew - a.heightAndGap &&
              (o.style.height = a.height - 1 + "px");
          });
        });
      },
      sortBlocks: function (e, n, i, o) {
        (i = void 0 === i ? "leftNew" : i),
          (o = void 0 === o ? 1 : -1),
          e.sort(function (e, a) {
            var r = t(e).data("uewtk"),
              s = t(a).data("uewtk");
            return r[n] > s[n]
              ? o
              : r[n] < s[n]
              ? -o
              : r[i] > s[i]
              ? o
              : r[i] < s[i]
              ? -o
              : r.index > s.index
              ? o
              : r.index < s.index
              ? -o
              : void 0;
          });
      },
    });
  })(jQuery, (window, document)),
  (jQuery.fn.cubeportfolio.options = {
    filters: "",
    search: "",
    layoutMode: "grid",
    sortByDimension: !1,
    drag: !0,
    auto: !1,
    autoTimeout: 5e3,
    autoPauseOnHover: !0,
    showNavigation: !0,
    showPagination: !0,
    rewindNav: !0,
    scrollByPage: !1,
    defaultFilter: "*",
    filterDeeplinking: !1,
    animationType: "fadeOut",
    gridAdjustment: "responsive",
    mediaQueries: !1,
    gapHorizontal: 10,
    gapVertical: 10,
    caption: "pushTop",
    displayType: "fadeIn",
    displayTypeSpeed: 400,
    lightboxDelegate: ".uewtk-lightbox",
    lightboxGallery: !0,
    lightboxTitleSrc: "data-title",
    lightboxCounter:
      '<div class="uewtk-popup-lightbox-counter">{{current}} of {{total}}</div>',
    singlePageDelegate: ".uewtk-singlePage",
    singlePageDeeplinking: !0,
    singlePageStickyNavigation: !0,
    singlePageCounter:
      '<div class="uewtk-popup-singlePage-counter">{{current}} of {{total}}</div>',
    singlePageAnimation: "left",
    singlePageCallback: null,
    singlePageInlineDelegate: ".uewtk-singlePageInline",
    singlePageInlineDeeplinking: !1,
    singlePageInlinePosition: "top",
    singlePageInlineInFocus: !0,
    singlePageInlineCallback: null,
    plugins: {},
  }),
  (function (t, e, n) {
    "use strict";
    var i = t.fn.cubeportfolio.constructor,
      o = t(e);
    (i.private = {
      publicEvents: function (e, n, i) {
        var a = this;
        (a.events = []),
          (a.initEvent = function (t) {
            0 === a.events.length && a.scrollEvent(), a.events.push(t);
          }),
          (a.destroyEvent = function (n) {
            (a.events = t.map(a.events, function (t, e) {
              if (t.instance !== n) return t;
            })),
              0 === a.events.length && o.off(e);
          }),
          (a.scrollEvent = function () {
            var r;
            o.on(e, function () {
              clearTimeout(r),
                (r = setTimeout(function () {
                  (t.isFunction(i) && i.call(a)) ||
                    t.each(a.events, function (t, e) {
                      e.fn.call(e.instance);
                    });
                }, n));
            });
          });
      },
      checkInstance: function (e) {
        var n = t.data(this, "cubeportfolio");
        if (!n)
          throw new Error(
            "cubeportfolio is not initialized. Initialize it before calling " +
              e +
              " method!"
          );
        return n.triggerEvent("publicMethod"), n;
      },
      browserInfo: function () {
        var t,
          n,
          o = i.private,
          a = navigator.appVersion;
        -1 !== a.indexOf("MSIE 8.")
          ? (o.browser = "ie8")
          : -1 !== a.indexOf("MSIE 9.")
          ? (o.browser = "ie9")
          : -1 !== a.indexOf("MSIE 10.")
          ? (o.browser = "ie10")
          : e.ActiveXObject || "ActiveXObject" in e
          ? (o.browser = "ie11")
          : /android/gi.test(a)
          ? (o.browser = "android")
          : /iphone|ipad|ipod/gi.test(a)
          ? (o.browser = "ios")
          : /chrome/gi.test(a)
          ? (o.browser = "chrome")
          : (o.browser = ""),
          o.styleSupport("perspective"),
          (t = o.styleSupport("transition")),
          (o.transitionend = {
            WebkitTransition: "webkitTransitionEnd",
            transition: "transitionend",
          }[t]),
          (n = o.styleSupport("animation")),
          (o.animationend = {
            WebkitAnimation: "webkitAnimationEnd",
            animation: "animationend",
          }[n]),
          (o.animationDuration = {
            WebkitAnimation: "webkitAnimationDuration",
            animation: "animationDuration",
          }[n]),
          (o.animationDelay = {
            WebkitAnimation: "webkitAnimationDelay",
            animation: "animationDelay",
          }[n]),
          (o.transform = o.styleSupport("transform")),
          t && n && o.transform && (o.modernBrowser = !0);
      },
      styleSupport: function (t) {
        var e,
          i = "Webkit" + t.charAt(0).toUpperCase() + t.slice(1),
          o = n.createElement("div");
        return t in o.style ? (e = t) : i in o.style && (e = i), (o = null), e;
      },
    }),
      i.private.browserInfo(),
      (i.private.resize = new i.private.publicEvents(
        "resize.uewtk",
        50,
        function () {
          if (e.innerHeight == screen.height) return !0;
        }
      ));
  })(jQuery, window, document),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    e.public = {
      init: function (t, n) {
        new e(this, t, n);
      },
      destroy: function (n) {
        var i = e.private.checkInstance.call(this, "destroy");
        i.triggerEvent("beforeDestroy"),
          t.removeData(this, "cubeportfolio"),
          i.blocks.removeData("uewtk"),
          i.$obj.removeClass("uewtk-ready").removeAttr("style"),
          i.$ul.removeClass("uewtk-wrapper"),
          e.private.resize.destroyEvent(i),
          i.$obj.off(".uewtk"),
          i.blocks.removeClass("uewtk-item-off").removeAttr("style"),
          i.blocks.find(".uewtk-item-wrapper").each(function (e, n) {
            var i = t(n),
              o = i.children();
            o.length ? o.unwrap() : i.remove();
          }),
          i.destroySlider && i.destroySlider(),
          i.$ul.unwrap(),
          i.addedWrapp && i.blocks.unwrap(),
          0 === i.blocks.length && i.$ul.remove(),
          t.each(i.plugins, function (t, e) {
            "function" == typeof e.destroy && e.destroy();
          }),
          t.isFunction(n) && n.call(i),
          i.triggerEvent("afterDestroy");
      },
      filter: function (n, i) {
        var o,
          a,
          r = e.private.checkInstance.call(this, "filter");
        if (!r.isAnimating) {
          if (
            ((r.isAnimating = !0),
            t.isFunction(i) && r.registerEvent("filterFinish", i, !0),
            t.isFunction(n))
          ) {
            if (void 0 === (o = n.call(r, r.blocks)))
              throw new Error(
                "When you call cubeportfolio API `filter` method with a param of type function you must return the blocks that will be visible."
              );
          } else
            r.options.filterDeeplinking &&
              ((a = location.href.replace(/#uewtkf=(.*?)([#\?&]|$)/gi, "")),
              (location.href = a + "#uewtkf=" + encodeURIComponent(n)),
              r.singlePage &&
                r.singlePage.url &&
                (r.singlePage.url = location.href)),
              (r.defaultFilter = n),
              (o = r.filterConcat(r.defaultFilter));
          r.triggerEvent("filterStart", o),
            r.singlePageInline && r.singlePageInline.isOpen
              ? r.singlePageInline.close("promise", {
                  callback: function () {
                    r.computeFilter(o);
                  },
                })
              : r.computeFilter(o);
        }
      },
      showCounter: function (n, i) {
        var o = e.private.checkInstance.call(this, "showCounter");
        t.isFunction(i) && o.registerEvent("showCounterFinish", i, !0),
          (o.elems = n).each(function () {
            var e = t(this),
              n = o.blocks.filter(e.data("filter")).length;
            e.find(".uewtk-filter-counter").text(n);
          }),
          o.triggerEvent("showCounterFinish", n);
      },
      appendItems: function (t, n) {
        e.public.append.call(this, t, n);
      },
      append: function (n, i) {
        var o = e.private.checkInstance.call(this, "append"),
          a = t(n).filter(".uewtk-item");
        o.isAnimating || a.length < 1
          ? t.isFunction(i) && i.call(o, a)
          : ((o.isAnimating = !0),
            o.singlePageInline && o.singlePageInline.isOpen
              ? o.singlePageInline.close("promise", {
                  callback: function () {
                    o.addItems(a, i, "append");
                  },
                })
              : o.addItems(a, i, "append"));
      },
      prepend: function (n, i) {
        var o = e.private.checkInstance.call(this, "prepend"),
          a = t(n).filter(".uewtk-item");
        o.isAnimating || a.length < 1
          ? t.isFunction(i) && i.call(o, a)
          : ((o.isAnimating = !0),
            o.singlePageInline && o.singlePageInline.isOpen
              ? o.singlePageInline.close("promise", {
                  callback: function () {
                    o.addItems(a, i, "prepend");
                  },
                })
              : o.addItems(a, i, "prepend"));
      },
      remove: function (n, i) {
        var o = e.private.checkInstance.call(this, "remove"),
          a = t(n).filter(".uewtk-item");
        o.isAnimating || a.length < 1
          ? t.isFunction(i) && i.call(o, a)
          : ((o.isAnimating = !0),
            o.singlePageInline && o.singlePageInline.isOpen
              ? o.singlePageInline.close("promise", {
                  callback: function () {
                    o.removeItems(a, i);
                  },
                })
              : o.removeItems(a, i));
      },
      layout: function (n) {
        var i = e.private.checkInstance.call(this, "layout");
        (i.width = i.$obj.outerWidth()),
          i.isAnimating ||
            i.width <= 0 ||
            ("alignCenter" === i.options.gridAdjustment &&
              (i.wrapper[0].style.maxWidth = ""),
            i.storeData(i.blocks),
            i.layoutAndAdjustment()),
          t.isFunction(n) && n.call(i);
      },
    };
  })(jQuery, (window, document)),
  (function (t, e, n) {
    "use strict";
    var i = t.fn.cubeportfolio.constructor;
    t.extend(i.prototype, {
      updateSliderPagination: function () {
        var e,
          n,
          i = this;
        if (i.options.showPagination) {
          for (
            e = Math.ceil(i.blocksOn.length / i.cols),
              i.navPagination.empty(),
              n = e - 1;
            0 <= n;
            n--
          )
            t("<div/>", {
              class: "uewtk-nav-pagination-item",
              "data-slider-action": "jumpTo",
            }).appendTo(i.navPagination);
          i.navPaginationItems = i.navPagination.children();
        }
        i.enableDisableNavSlider();
      },
      destroySlider: function () {
        var e = this;
        "slider" === e.options.layoutMode &&
          (e.$obj.removeClass("uewtk-mode-slider"),
          e.$ul.removeAttr("style"),
          e.$ul.off(".uewtk"),
          t(n).off(".uewtk"),
          e.options.auto && e.stopSliderAuto());
      },
      nextSlider: function (t) {
        var e = this;
        if (e.isEndSlider()) {
          if (!e.isRewindNav()) return;
          e.sliderActive = 0;
        } else
          e.options.scrollByPage
            ? (e.sliderActive = Math.min(
                e.sliderActive + e.cols,
                e.blocksOn.length - e.cols
              ))
            : (e.sliderActive += 1);
        e.goToSlider();
      },
      prevSlider: function (t) {
        var e = this;
        if (e.isStartSlider()) {
          if (!e.isRewindNav()) return;
          e.sliderActive = e.blocksOn.length - e.cols;
        } else
          e.options.scrollByPage
            ? (e.sliderActive = Math.max(0, e.sliderActive - e.cols))
            : --e.sliderActive;
        e.goToSlider();
      },
      jumpToSlider: function (t) {
        var e = this,
          n = Math.min(t.index() * e.cols, e.blocksOn.length - e.cols);
        n !== e.sliderActive && ((e.sliderActive = n), e.goToSlider());
      },
      jumpDragToSlider: function (t) {
        var e,
          n,
          i = this,
          o = 0 < t,
          a = i.options.scrollByPage
            ? ((e = i.cols * i.columnWidth), i.cols)
            : ((e = i.columnWidth), 1);
        (t = Math.abs(t)),
          (n = Math.floor(t / e) * a),
          20 < t % e && (n += a),
          (i.sliderActive = o
            ? Math.min(i.sliderActive + n, i.blocksOn.length - i.cols)
            : Math.max(0, i.sliderActive - n)),
          i.goToSlider();
      },
      isStartSlider: function () {
        return 0 === this.sliderActive;
      },
      isEndSlider: function () {
        return this.sliderActive + this.cols > this.blocksOn.length - 1;
      },
      goToSlider: function () {
        this.enableDisableNavSlider(), this.updateSliderPosition();
      },
      startSliderAuto: function () {
        var t = this;
        t.isDrag
          ? t.stopSliderAuto()
          : (t.timeout = setTimeout(function () {
              t.nextSlider(), t.startSliderAuto();
            }, t.options.autoTimeout));
      },
      stopSliderAuto: function () {
        clearTimeout(this.timeout);
      },
      enableDisableNavSlider: function () {
        var t,
          e,
          n = this;
        n.isRewindNav() ||
          ((e = n.isStartSlider() ? "addClass" : "removeClass"),
          n.navPrev[e]("uewtk-nav-stop"),
          (e = n.isEndSlider() ? "addClass" : "removeClass"),
          n.navNext[e]("uewtk-nav-stop")),
          n.options.showPagination &&
            ((t = n.options.scrollByPage
              ? Math.ceil(n.sliderActive / n.cols)
              : n.isEndSlider()
              ? n.navPaginationItems.length - 1
              : Math.floor(n.sliderActive / n.cols)),
            n.navPaginationItems
              .removeClass("uewtk-nav-pagination-active")
              .eq(t)
              .addClass("uewtk-nav-pagination-active")),
          n.customPagination &&
            ((t = n.options.scrollByPage
              ? Math.ceil(n.sliderActive / n.cols)
              : n.isEndSlider()
              ? n.customPaginationItems.length - 1
              : Math.floor(n.sliderActive / n.cols)),
            n.customPaginationItems
              .removeClass(n.customPaginationClass)
              .eq(t)
              .addClass(n.customPaginationClass));
      },
      isRewindNav: function () {
        return (
          !this.options.showNavigation ||
          (!(this.blocksOn.length <= this.cols) && !!this.options.rewindNav)
        );
      },
      sliderItemsLength: function () {
        return this.blocksOn.length <= this.cols;
      },
      sliderLayout: function () {
        var e = this;
        e.blocksOn.each(function (n, i) {
          var o = t(i).data("uewtk");
          (o.leftNew = e.columnWidth * n),
            (o.topNew = 0),
            e.sliderFreeSpaces.push({ topStart: o.heightAndGap });
        }),
          e.getFreeSpacesForSlider(),
          e.$ul.width(
            e.columnWidth * e.blocksOn.length - e.options.gapVertical
          );
      },
      getFreeSpacesForSlider: function () {
        var t = this;
        (t.freeSpaces = t.sliderFreeSpaces.slice(
          t.sliderActive,
          t.sliderActive + t.cols
        )),
          t.freeSpaces.sort(function (t, e) {
            return t.topStart > e.topStart
              ? 1
              : t.topStart < e.topStart
              ? -1
              : void 0;
          });
      },
      updateSliderPosition: function () {
        var t = this,
          e = -t.sliderActive * t.columnWidth;
        i.private.modernBrowser
          ? (t.$ul[0].style[i.private.transform] =
              "translate3d(" + e + "px, 0px, 0)")
          : (t.$ul[0].style.left = e + "px"),
          t.getFreeSpacesForSlider(),
          t.resizeMainContainer();
      },
      dragSlider: function () {
        var o,
          a,
          r,
          s,
          l,
          p = this,
          c = t(n),
          d = !1,
          u = {},
          f = !1;
        function g(t) {
          p.$obj.removeClass("uewtk-mode-slider-dragStart"),
            (d = !0),
            0 !== a
              ? (r.one("click.uewtk", function (t) {
                  return !1;
                }),
                requestAnimationFrame(function () {
                  p.jumpDragToSlider(a), p.$ul.one(i.private.transitionend, b);
                }))
              : b.call(p),
            c.off(u.move),
            c.off(u.end);
        }
        function h(t) {
          (8 < (a = o - v(t).x) || a < -8) && t.preventDefault(),
            (p.isDrag = !0);
          var e = s - a;
          a < 0 && a < s
            ? (e = (s - a) / 5)
            : 0 < a && s - a < -l && (e = (l + s - a) / 5 - l),
            i.private.modernBrowser
              ? (p.$ul[0].style[i.private.transform] =
                  "translate3d(" + e + "px, 0px, 0)")
              : (p.$ul[0].style.left = e + "px");
        }
        function b() {
          if (((d = !1), (p.isDrag = !1), p.options.auto)) {
            if (p.mouseIsEntered) return;
            p.startSliderAuto();
          }
        }
        function v(t) {
          return (
            void 0 !== t.originalEvent &&
              void 0 !== t.originalEvent.touches &&
              (t = t.originalEvent.touches[0]),
            { x: t.pageX, y: t.pageY }
          );
        }
        (p.isDrag = !1),
          "ontouchstart" in e ||
          0 < navigator.maxTouchPoints ||
          0 < navigator.msMaxTouchPoints
            ? ((u = {
                start: "touchstart.uewtk",
                move: "touchmove.uewtk",
                end: "touchend.uewtk",
              }),
              (f = !0))
            : (u = {
                start: "mousedown.uewtk",
                move: "mousemove.uewtk",
                end: "mouseup.uewtk",
              }),
          p.$ul.on(u.start, function (e) {
            p.sliderItemsLength() ||
              (f || e.preventDefault(),
              p.options.auto && p.stopSliderAuto(),
              d
                ? t(r).one("click.uewtk", function () {
                    return !1;
                  })
                : ((r = t(e.target)),
                  (o = v(e).x),
                  (a = 0),
                  (s = -p.sliderActive * p.columnWidth),
                  (l = p.columnWidth * (p.blocksOn.length - p.cols)),
                  c.on(u.move, h),
                  c.on(u.end, g),
                  p.$obj.addClass("uewtk-mode-slider-dragStart")));
          });
      },
      sliderLayoutReset: function () {
        (this.freeSpaces = []), (this.sliderFreeSpaces = []);
      },
    });
  })(jQuery, window, document),
  "function" != typeof Object.create &&
    (Object.create = function (t) {
      function e() {}
      return (e.prototype = t), new e();
    }),
  (function () {
    for (
      var t = 0, e = ["moz", "webkit"], n = 0;
      n < e.length && !window.requestAnimationFrame;
      n++
    )
      (window.requestAnimationFrame = window[e[n] + "RequestAnimationFrame"]),
        (window.cancelAnimationFrame =
          window[e[n] + "CancelAnimationFrame"] ||
          window[e[n] + "CancelRequestAnimationFrame"]);
    window.requestAnimationFrame ||
      (window.requestAnimationFrame = function (e, n) {
        var i = new Date().getTime(),
          o = Math.max(0, 16 - (i - t)),
          a = window.setTimeout(function () {
            e(i + o);
          }, o);
        return (t = i + o), a;
      }),
      window.cancelAnimationFrame ||
        (window.cancelAnimationFrame = function (t) {
          clearTimeout(t);
        });
  })(),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(t) {
      ((this.parent = t).filterLayout = this.filterLayout),
        t.registerEvent("computeBlocksFinish", function (e) {
          (t.blocksOn2On = t.blocksOnInitial.filter(e)),
            (t.blocksOn2Off = t.blocksOnInitial.not(e));
        });
    }
    (n.prototype.filterLayout = function () {
      var n = this;
      function i() {
        n.blocks
          .removeClass("uewtk-item-on2off uewtk-item-off2on uewtk-item-on2on")
          .each(function (n, i) {
            var o = t(i).data("uewtk");
            (o.left = o.leftNew),
              (o.top = o.topNew),
              (i.style.left = o.left + "px"),
              (i.style.top = o.top + "px"),
              (i.style[e.private.transform] = "");
          }),
          n.blocksOff.addClass("uewtk-item-off"),
          n.$obj.removeClass("uewtk-animation-" + n.options.animationType),
          n.filterFinish();
      }
      n.$obj.addClass("uewtk-animation-" + n.options.animationType),
        n.blocksOn2On.addClass("uewtk-item-on2on").each(function (n, i) {
          var o = t(i).data("uewtk");
          i.style[e.private.transform] =
            "translate3d(" +
            (o.leftNew - o.left) +
            "px, " +
            (o.topNew - o.top) +
            "px, 0)";
        }),
        n.blocksOn2Off.addClass("uewtk-item-on2off"),
        (n.blocksOff2On = n.blocksOn
          .filter(".uewtk-item-off")
          .removeClass("uewtk-item-off")
          .addClass("uewtk-item-off2on")
          .each(function (e, n) {
            var i = t(n).data("uewtk");
            (n.style.left = i.leftNew + "px"), (n.style.top = i.topNew + "px");
          })),
        n.blocksOn2Off.length
          ? n.blocksOn2Off
              .last()
              .data("uewtk")
              .wrapper.one(e.private.animationend, i)
          : n.blocksOff2On.length
          ? n.blocksOff2On
              .last()
              .data("uewtk")
              .wrapper.one(e.private.animationend, i)
          : n.blocksOn2On.length
          ? n.blocksOn2On.last().one(e.private.transitionend, i)
          : i(),
        n.resizeMainContainer();
    }),
      (n.prototype.destroy = function () {
        var t = this.parent;
        t.$obj.removeClass("uewtk-animation-" + t.options.animationType);
      }),
      (e.plugins.animationClassic = function (i) {
        return !e.private.modernBrowser ||
          t.inArray(i.options.animationType, [
            "boxShadow",
            "fadeOut",
            "flipBottom",
            "flipOut",
            "quicksand",
            "scaleSides",
            "skew",
          ]) < 0
          ? null
          : new n(i);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(t) {
      (this.parent = t).filterLayout = this.filterLayout;
    }
    (n.prototype.filterLayout = function () {
      var n = this,
        i = n.$ul[0].cloneNode(!0);
      function o() {
        n.wrapper[0].removeChild(i),
          "sequentially" === n.options.animationType &&
            n.blocksOn.each(function (n, i) {
              t(i).data("uewtk").wrapper[0].style[e.private.animationDelay] =
                "";
            }),
          n.$obj.removeClass("uewtk-animation-" + n.options.animationType),
          n.filterFinish();
      }
      i.setAttribute("class", "uewtk-wrapper-helper"),
        n.wrapper[0].insertBefore(i, n.$ul[0]),
        requestAnimationFrame(function () {
          n.$obj.addClass("uewtk-animation-" + n.options.animationType),
            n.blocksOff.addClass("uewtk-item-off"),
            n.blocksOn.removeClass("uewtk-item-off").each(function (i, o) {
              var a = t(o).data("uewtk");
              (a.left = a.leftNew),
                (a.top = a.topNew),
                (o.style.left = a.left + "px"),
                (o.style.top = a.top + "px"),
                "sequentially" === n.options.animationType &&
                  (a.wrapper[0].style[e.private.animationDelay] =
                    60 * i + "ms");
            }),
            n.blocksOn.length
              ? n.blocksOn
                  .last()
                  .data("uewtk")
                  .wrapper.one(e.private.animationend, o)
              : n.blocksOnInitial.length
              ? n.blocksOnInitial
                  .last()
                  .data("uewtk")
                  .wrapper.one(e.private.animationend, o)
              : o(),
            n.resizeMainContainer();
        });
    }),
      (n.prototype.destroy = function () {
        var t = this.parent;
        t.$obj.removeClass("uewtk-animation-" + t.options.animationType);
      }),
      (e.plugins.animationClone = function (i) {
        return !e.private.modernBrowser ||
          t.inArray(i.options.animationType, [
            "fadeOutTop",
            "slideLeft",
            "sequentially",
          ]) < 0
          ? null
          : new n(i);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(t) {
      (this.parent = t).filterLayout = this.filterLayout;
    }
    (n.prototype.filterLayout = function () {
      var n = this,
        i = n.$ul.clone(!0, !0);
      i[0].setAttribute("class", "uewtk-wrapper-helper"),
        n.wrapper[0].insertBefore(i[0], n.$ul[0]);
      var o = i.find(".uewtk-item").not(".uewtk-item-off");
      function a() {
        n.wrapper[0].removeChild(i[0]),
          n.$obj.removeClass("uewtk-animation-" + n.options.animationType),
          n.blocks.each(function (n, i) {
            t(i).data("uewtk").wrapper[0].style[e.private.animationDelay] = "";
          }),
          n.filterFinish();
      }
      n.blocksAreSorted && n.sortBlocks(o, "top", "left"),
        o.children(".uewtk-item-wrapper").each(function (t, n) {
          n.style[e.private.animationDelay] = 50 * t + "ms";
        }),
        requestAnimationFrame(function () {
          n.$obj.addClass("uewtk-animation-" + n.options.animationType),
            n.blocksOff.addClass("uewtk-item-off"),
            n.blocksOn.removeClass("uewtk-item-off").each(function (n, i) {
              var o = t(i).data("uewtk");
              (o.left = o.leftNew),
                (o.top = o.topNew),
                (i.style.left = o.left + "px"),
                (i.style.top = o.top + "px"),
                (o.wrapper[0].style[e.private.animationDelay] = 50 * n + "ms");
            });
          var i = n.blocksOn.length,
            r = o.length;
          0 === i && 0 === r
            ? a()
            : i < r
            ? o
                .last()
                .children(".uewtk-item-wrapper")
                .one(e.private.animationend, a)
            : n.blocksOn
                .last()
                .data("uewtk")
                .wrapper.one(e.private.animationend, a),
            n.resizeMainContainer();
        });
    }),
      (n.prototype.destroy = function () {
        var t = this.parent;
        t.$obj.removeClass("uewtk-animation-" + t.options.animationType);
      }),
      (e.plugins.animationCloneDelay = function (i) {
        return !e.private.modernBrowser ||
          t.inArray(i.options.animationType, [
            "3dflip",
            "flipOutDelay",
            "foldLeft",
            "frontRow",
            "rotateRoom",
            "rotateSides",
            "scaleDown",
            "slideDelay",
            "unfold",
          ]) < 0
          ? null
          : new n(i);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(t) {
      (this.parent = t).filterLayout = this.filterLayout;
    }
    (n.prototype.filterLayout = function () {
      var n = this,
        i = n.$ul[0].cloneNode(!0);
      function o() {
        n.wrapper[0].removeChild(i),
          n.$obj.removeClass("uewtk-animation-" + n.options.animationType),
          n.filterFinish();
      }
      i.setAttribute("class", "uewtk-wrapper-helper"),
        n.wrapper[0].insertBefore(i, n.$ul[0]),
        requestAnimationFrame(function () {
          n.$obj.addClass("uewtk-animation-" + n.options.animationType),
            n.blocksOff.addClass("uewtk-item-off"),
            n.blocksOn.removeClass("uewtk-item-off").each(function (e, n) {
              var i = t(n).data("uewtk");
              (i.left = i.leftNew),
                (i.top = i.topNew),
                (n.style.left = i.left + "px"),
                (n.style.top = i.top + "px");
            }),
            n.blocksOn.length
              ? n.$ul.one(e.private.animationend, o)
              : n.blocksOnInitial.length
              ? t(i).one(e.private.animationend, o)
              : o(),
            n.resizeMainContainer();
        });
    }),
      (n.prototype.destroy = function () {
        var t = this.parent;
        t.$obj.removeClass("uewtk-animation-" + t.options.animationType);
      }),
      (e.plugins.animationWrapper = function (i) {
        return !e.private.modernBrowser ||
          t.inArray(i.options.animationType, [
            "bounceBottom",
            "bounceLeft",
            "bounceTop",
            "moveLeft",
          ]) < 0
          ? null
          : new n(i);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(t) {
      var e = this,
        n = t.options;
      (e.parent = t),
        (e.captionOn = n.caption),
        t.registerEvent("onMediaQueries", function (t) {
          t && t.hasOwnProperty("caption")
            ? e.captionOn !== t.caption &&
              (e.destroy(), (e.captionOn = t.caption), e.init())
            : e.captionOn !== n.caption &&
              (e.destroy(), (e.captionOn = n.caption), e.init());
        }),
        e.init();
    }
    (n.prototype.init = function () {
      var t = this;
      "" != t.captionOn &&
        ("expand" === t.captionOn ||
          e.private.modernBrowser ||
          (t.parent.options.caption = t.captionOn = "minimal"),
        t.parent.$obj.addClass(
          "uewtk-caption-active uewtk-caption-" + t.captionOn
        ));
    }),
      (n.prototype.destroy = function () {
        this.parent.$obj.removeClass(
          "uewtk-caption-active uewtk-caption-" + this.captionOn
        );
      }),
      (e.plugins.caption = function (t) {
        return new n(t);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(e) {
      (this.parent = e).registerEvent(
        "initFinish",
        function () {
          e.$obj.on("click.uewtk", ".uewtk-caption-defaultWrap", function (n) {
            var i, o, a, r, s, l;
            n.preventDefault(),
              e.isAnimating ||
                ((e.isAnimating = !0),
                (i = t(this)),
                (o = i.next()),
                (a = i.parent()),
                (l = { position: "relative", height: o.outerHeight(!0) }),
                (s = { position: "relative", height: 0 }),
                e.$obj.addClass("uewtk-caption-expand-active"),
                a.hasClass("uewtk-caption-expand-open") &&
                  ((r = s),
                  (s = l),
                  (l = r),
                  a.removeClass("uewtk-caption-expand-open")),
                o.css(l),
                e.$obj.one("pluginResize.uewtk", function () {
                  (e.isAnimating = !1),
                    e.$obj.removeClass("uewtk-caption-expand-active"),
                    0 === l.height &&
                      (a.removeClass("uewtk-caption-expand-open"),
                      o.attr("style", ""));
                }),
                e.layoutAndAdjustment(!0),
                o.css(s),
                requestAnimationFrame(function () {
                  a.addClass("uewtk-caption-expand-open"),
                    o.css(l),
                    e.triggerEvent("gridAdjust"),
                    e.triggerEvent("resizeGrid");
                }));
          });
        },
        !0
      );
    }
    (n.prototype.destroy = function () {
      this.parent.$obj
        .find(".uewtk-caption-defaultWrap")
        .off("click.uewtk")
        .parent()
        .removeClass("uewtk-caption-expand-active");
    }),
      (e.plugins.captionExpand = function (t) {
        return "expand" !== t.options.caption ? null : new n(t);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(n) {
      n.registerEvent(
        "initEndWrite",
        function () {
          var i;
          n.width <= 0 ||
            ((i = t.Deferred()),
            n.pushQueue("delayFrame", i),
            n.blocksOn.each(function (t, i) {
              i.style[e.private.animationDelay] =
                t * n.options.displayTypeSpeed + "ms";
            }),
            n.$obj.addClass("uewtk-displayType-bottomToTop"),
            n.blocksOn.last().one(e.private.animationend, function () {
              n.$obj.removeClass("uewtk-displayType-bottomToTop"),
                n.blocksOn.each(function (t, n) {
                  n.style[e.private.animationDelay] = "";
                }),
                i.resolve();
            }));
        },
        !0
      );
    }
    e.plugins.displayBottomToTop = function (t) {
      return e.private.modernBrowser &&
        "bottomToTop" === t.options.displayType &&
        0 !== t.blocksOn.length
        ? new n(t)
        : null;
    };
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(n) {
      n.registerEvent(
        "initEndWrite",
        function () {
          var i;
          n.width <= 0 ||
            ((i = t.Deferred()),
            n.pushQueue("delayFrame", i),
            (n.obj.style[e.private.animationDuration] =
              n.options.displayTypeSpeed + "ms"),
            n.$obj.addClass("uewtk-displayType-fadeIn"),
            n.$obj.one(e.private.animationend, function () {
              n.$obj.removeClass("uewtk-displayType-fadeIn"),
                (n.obj.style[e.private.animationDuration] = ""),
                i.resolve();
            }));
        },
        !0
      );
    }
    e.plugins.displayFadeIn = function (t) {
      return !e.private.modernBrowser ||
        ("lazyLoading" !== t.options.displayType &&
          "fadeIn" !== t.options.displayType) ||
        0 === t.blocksOn.length
        ? null
        : new n(t);
    };
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(n) {
      n.registerEvent(
        "initEndWrite",
        function () {
          var i;
          n.width <= 0 ||
            ((i = t.Deferred()),
            n.pushQueue("delayFrame", i),
            (n.obj.style[e.private.animationDuration] =
              n.options.displayTypeSpeed + "ms"),
            n.$obj.addClass("uewtk-displayType-fadeInToTop"),
            n.$obj.one(e.private.animationend, function () {
              n.$obj.removeClass("uewtk-displayType-fadeInToTop"),
                (n.obj.style[e.private.animationDuration] = ""),
                i.resolve();
            }));
        },
        !0
      );
    }
    e.plugins.displayFadeInToTop = function (t) {
      return e.private.modernBrowser &&
        "fadeInToTop" === t.options.displayType &&
        0 !== t.blocksOn.length
        ? new n(t)
        : null;
    };
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(n) {
      n.registerEvent(
        "initEndWrite",
        function () {
          var i;
          n.width <= 0 ||
            ((i = t.Deferred()),
            n.pushQueue("delayFrame", i),
            n.blocksOn.each(function (t, i) {
              i.style[e.private.animationDelay] =
                t * n.options.displayTypeSpeed + "ms";
            }),
            n.$obj.addClass("uewtk-displayType-sequentially"),
            n.blocksOn.last().one(e.private.animationend, function () {
              n.$obj.removeClass("uewtk-displayType-sequentially"),
                n.blocksOn.each(function (t, n) {
                  n.style[e.private.animationDelay] = "";
                }),
                i.resolve();
            }));
        },
        !0
      );
    }
    e.plugins.displaySequentially = function (t) {
      return e.private.modernBrowser &&
        "sequentially" === t.options.displayType &&
        0 !== t.blocksOn.length
        ? new n(t)
        : null;
    };
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(e) {
      var n = this;
      (n.parent = e),
        (n.filters = t(e.options.filters)),
        (n.filterData = []),
        e.registerEvent("afterPlugins", function (t) {
          n.filterFromUrl(), n.registerFilter();
        }),
        e.registerEvent("resetFiltersVisual", function () {
          var i = e.options.defaultFilter.split("|");
          n.filters.each(function (e, n) {
            var o = t(n).find(".uewtk-filter-item");
            o.removeClass("uewtk-filter-item-active"),
              t.each(i, function (t, e) {
                var n = o.filter('[data-filter="' + e + '"]');
                if (n.length)
                  return (
                    n.addClass("uewtk-filter-item-active"), i.splice(t, 1), !1
                  );
              });
          }),
            (e.defaultFilter = e.options.defaultFilter);
        });
    }
    (n.prototype.registerFilter = function () {
      var e = this,
        n = e.parent,
        i = n.defaultFilter.split("|");
      (e.wrap = e.filters.find(".uewtk-l-filters-dropdownWrap").on({
        "mouseover.uewtk": function () {
          t(this).addClass("uewtk-l-filters-dropdownWrap-open");
        },
        "mouseleave.uewtk": function () {
          t(this).removeClass("uewtk-l-filters-dropdownWrap-open");
        },
      })),
        e.filters.each(function (o, a) {
          var r = t(a),
            s = "*",
            l = r.find(".uewtk-filter-item"),
            p = {};
          r.hasClass("uewtk-l-filters-dropdown") &&
            ((p.wrap = r.find(".uewtk-l-filters-dropdownWrap")),
            (p.header = r.find(".uewtk-l-filters-dropdownHeader")),
            (p.headerText = p.header.text())),
            n.$obj.cubeportfolio("showCounter", l),
            t.each(i, function (t, e) {
              if (l.filter('[data-filter="' + e + '"]').length)
                return (s = e), i.splice(t, 1), !1;
            }),
            t.data(a, "filterName", s),
            e.filterData.push(a),
            e.filtersCallback(p, l.filter('[data-filter="' + s + '"]'), l);
          var c = a.getAttribute("data-filter-parent");
          c &&
            (r.removeClass("uewtk-l-subfilters--active"),
            c === e.parent.defaultFilter &&
              r.addClass("uewtk-l-subfilters--active")),
            l.on("click.uewtk", function () {
              var i,
                o,
                r = t(this);
              r.hasClass("uewtk-filter-item-active") ||
                n.isAnimating ||
                (e.filtersCallback(p, r, l),
                t.data(a, "filterName", r.data("filter")),
                (i = t.map(e.filterData, function (n, i) {
                  var o = t(n),
                    a = n.getAttribute("data-filter-parent");
                  a &&
                    (a === t.data(e.filterData[0], "filterName")
                      ? o.addClass("uewtk-l-subfilters--active")
                      : (o.removeClass("uewtk-l-subfilters--active"),
                        t.data(n, "filterName", "*"),
                        o
                          .find(".uewtk-filter-item")
                          .removeClass("uewtk-filter-item-active")));
                  var r = t.data(n, "filterName");
                  return "" !== r && "*" !== r ? r : null;
                })).length < 1 && (i = ["*"]),
                (o = i.join("|")),
                n.defaultFilter !== o && n.$obj.cubeportfolio("filter", o));
            });
        });
    }),
      (n.prototype.filtersCallback = function (e, n, i) {
        t.isEmptyObject(e) ||
          (e.wrap.trigger("mouseleave.uewtk"),
          e.headerText ? (e.headerText = "") : e.header.html(n.html())),
          i.removeClass("uewtk-filter-item-active"),
          n.addClass("uewtk-filter-item-active");
      }),
      (n.prototype.filterFromUrl = function () {
        var t = /#uewtkf=(.*?)([#\?&]|$)/gi.exec(location.href);
        null !== t && (this.parent.defaultFilter = decodeURIComponent(t[1]));
      }),
      (n.prototype.destroy = function () {
        this.filters.find(".uewtk-filter-item").off(".uewtk"),
          this.wrap.off(".uewtk");
      }),
      (e.plugins.filters = function (t) {
        return "" === t.options.filters ? null : new n(t);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    function e(e) {
      var n = e.options.gapVertical,
        i = e.options.gapHorizontal;
      e.registerEvent("onMediaQueries", function (o) {
        (e.options.gapVertical =
          o && o.hasOwnProperty("gapVertical") ? o.gapVertical : n),
          (e.options.gapHorizontal =
            o && o.hasOwnProperty("gapHorizontal") ? o.gapHorizontal : i),
          e.blocks.each(function (n, i) {
            var o = t(i).data("uewtk");
            (o.widthAndGap = o.width + e.options.gapVertical),
              (o.heightAndGap = o.height + e.options.gapHorizontal);
          });
      });
    }
    t.fn.cubeportfolio.constructor.plugins.changeGapOnMediaQueries = function (
      t
    ) {
      return new e(t);
    };
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = {},
      n = t.fn.cubeportfolio.constructor;
    function i(n) {
      var i = this;
      (i.parent = n),
        (i.options = t.extend({}, e, i.parent.options.plugins.inlineSlider)),
        i.runInit(),
        n.registerEvent("addItemsToDOM", function () {
          i.runInit();
        });
    }
    function o(t) {
      var e = this;
      t.hasClass("uewtk-slider-inline-ready") ||
        (t.addClass("uewtk-slider-inline-ready"),
        (e.items = t
          .find(".uewtk-slider-wrapper")
          .children(".uewtk-slider-item")),
        (e.active = e.items.filter(".uewtk-slider-item--active").index()),
        (e.total = e.items.length - 1),
        e.updateLeft(),
        t.find(".uewtk-slider-next").on("click.uewtk", function (t) {
          t.preventDefault(),
            e.active < e.total
              ? (e.active++, e.updateLeft())
              : e.active === e.total && ((e.active = 0), e.updateLeft());
        }),
        t.find(".uewtk-slider-prev").on("click.uewtk", function (t) {
          t.preventDefault(),
            0 < e.active
              ? (e.active--, e.updateLeft())
              : 0 === e.active && ((e.active = e.total), e.updateLeft());
        }));
    }
    (o.prototype.updateLeft = function () {
      var t = this;
      t.items.removeClass("uewtk-slider-item--active"),
        t.items.eq(t.active).addClass("uewtk-slider-item--active"),
        t.items.each(function (e, n) {
          n.style.left = e - t.active + "00%";
        });
    }),
      (i.prototype.runInit = function () {
        var e = this;
        e.parent.$obj
          .find(".uewtk-slider-inline")
          .not(".uewtk-slider-inline-ready")
          .each(function (n, i) {
            var a = t(i),
              r = a.find(".uewtk-slider-item--active").find("img")[0];
            r.hasAttribute("data-uewtk-src")
              ? e.parent.$obj.on("lazyLoad.uewtk", function (t, e) {
                  e.src === r.src && new o(a);
                })
              : new o(a);
          });
      }),
      (i.prototype.destroy = function () {
        this.parent.$obj.find(".uewtk-slider-next").off("click.uewtk"),
          this.parent.$obj.find(".uewtk-slider-prev").off("click.uewtk"),
          this.parent.$obj.off("lazyLoad.uewtk"),
          this.parent.$obj.find(".uewtk-slider-inline").each(function (e, n) {
            var i = t(n);
            i.removeClass("uewtk-slider-inline-ready");
            var o = i.find(".uewtk-slider-item");
            o.removeClass("uewtk-slider-item--active"),
              o.removeAttr("style"),
              o.eq(0).addClass("uewtk-slider-item--active");
          });
      }),
      (n.plugins.inlineSlider = function (t) {
        return new i(t);
      });
  })(jQuery, (window, document)),
  (function (t, e) {
    "use strict";
    var n = { loadingClass: "uewtk-lazyload", threshold: 400 },
      i = t.fn.cubeportfolio.constructor,
      o = t(e);
    function a(e) {
      var o = this;
      (o.parent = e),
        (o.options = t.extend({}, n, o.parent.options.plugins.lazyLoad)),
        e.registerEvent(
          "initFinish",
          function () {
            o.loadImages(),
              e.registerEvent("resizeMainContainer", function () {
                o.loadImages();
              }),
              e.registerEvent("filterFinish", function () {
                o.loadImages();
              }),
              i.private.lazyLoadScroll.initEvent({
                instance: o,
                fn: o.loadImages,
              });
          },
          !0
        );
    }
    (i.private.lazyLoadScroll = new i.private.publicEvents(
      "scroll.uewtklazyLoad",
      50
    )),
      (a.prototype.loadImages = function () {
        var e = this,
          n = e.parent.$obj.find("img").filter("[data-uewtk-src]");
        0 !== n.length &&
          ((e.screenHeight = o.height()),
          n.each(function (n, i) {
            var o,
              a = t(i.parentNode);
            e.isElementInScreen(i)
              ? ((o = i.getAttribute("data-uewtk-src")),
                null === e.parent.checkSrc(t("<img>").attr("src", o))
                  ? (e.removeLazyLoad(i, o),
                    a.removeClass(e.options.loadingClass))
                  : (a.addClass(e.options.loadingClass),
                    t("<img>")
                      .on("load.uewtk error.uewtk", function () {
                        e.removeLazyLoad(i, o, a);
                      })
                      .attr("src", o)))
              : a.addClass(e.options.loadingClass);
          }));
      }),
      (a.prototype.removeLazyLoad = function (e, n, o) {
        var a = this;
        (e.src = n),
          e.removeAttribute("data-uewtk-src"),
          a.parent.removeAttrImage(e),
          a.parent.$obj.trigger("lazyLoad.uewtk", e),
          o &&
            (i.private.modernBrowser
              ? t(e).one(i.private.transitionend, function () {
                  o.removeClass(a.options.loadingClass);
                })
              : o.removeClass(a.options.loadingClass));
      }),
      (a.prototype.isElementInScreen = function (t) {
        var e = t.getBoundingClientRect(),
          n = e.bottom + this.options.threshold,
          i = this.screenHeight + n - (e.top - this.options.threshold);
        return 0 <= n && n <= i;
      }),
      (a.prototype.destroy = function () {
        i.private.lazyLoadScroll.destroyEvent(this);
      }),
      (i.plugins.lazyLoad = function (t) {
        return new a(t);
      });
  })(jQuery, window, document),
  (function (t, e) {
    "use strict";
    var n = { element: "", action: "click", loadItems: 3 },
      i = t.fn.cubeportfolio.constructor;
    function o(e) {
      var i = this;
      (i.parent = e),
        (i.options = t.extend({}, n, i.parent.options.plugins.loadMore)),
        (i.loadMore = t(i.options.element).find(".uewtk-l-loadMore-link")),
        0 !== i.loadMore.length &&
          ((i.loadItems = i.loadMore.find(".uewtk-l-loadMore-loadItems")),
          "0" === i.loadItems.text() &&
            i.loadMore.addClass("uewtk-l-loadMore-stop"),
          e.registerEvent("filterStart", function (t) {
            i.populateItems().then(function () {
              var e = i.items.filter(i.parent.filterConcat(t)).length;
              0 < e
                ? (i.loadMore.removeClass("uewtk-l-loadMore-stop"),
                  i.loadItems.html(e))
                : i.loadMore.addClass("uewtk-l-loadMore-stop");
            });
          }),
          i[i.options.action]());
    }
    (o.prototype.populateItems = function () {
      var e = this;
      return e.items
        ? t.Deferred().resolve()
        : ((e.items = t()),
          t
            .ajax({
              url: e.loadMore.attr("href"),
              type: "GET",
              dataType: "HTML",
            })
            .done(function (n) {
              var i = this.url.split("#");
              n =
                i.length > 1
                  ? jQuery(n)
                      .find(".uewtk-loadMore-" + i.pop())
                      .html()
                  : jQuery(n).find(".uewtk-loadMore-block1").html();
              var o = t
                .map(n.split(/\r?\n/), function (e, n) {
                  return t.trim(e);
                })
                .join("");
              0 !== o.length &&
                t.each(t.parseHTML(o), function (n, i) {
                  t(i).hasClass("uewtk-item")
                    ? (e.items = e.items.add(i))
                    : t.each(i.children, function (n, i) {
                        t(i).hasClass("uewtk-item") &&
                          (e.items = e.items.add(i));
                      });
                });
            })
            .fail(function () {
              (e.items = null),
                e.loadMore.removeClass("uewtk-l-loadMore-loading");
            }));
    }),
      (o.prototype.populateInsertItems = function (e) {
        var n = this,
          i = [],
          o = n.parent.defaultFilter,
          a = 0;
        n.items.each(function (e, r) {
          if (a === n.options.loadItems) return !1;
          (o && "*" !== o && !t(r).filter(n.parent.filterConcat(o)).length) ||
            (i.push(r), (n.items[e] = null), a++);
        }),
          (n.items = n.items.map(function (t, e) {
            return e;
          })),
          0 !== i.length
            ? n.parent.$obj.cubeportfolio("append", i, e)
            : n.loadMore
                .removeClass("uewtk-l-loadMore-loading")
                .addClass("uewtk-l-loadMore-stop");
      }),
      (o.prototype.click = function () {
        var t = this;
        function e() {
          t.loadMore.removeClass("uewtk-l-loadMore-loading");
          var e,
            n = t.parent.defaultFilter;
          0 ===
          (e =
            n && "*" !== n
              ? t.items.filter(t.parent.filterConcat(n)).length
              : t.items.length)
            ? t.loadMore.addClass("uewtk-l-loadMore-stop")
            : t.loadItems.html(e);
        }
        t.loadMore.on("click.uewtk", function (n) {
          n.preventDefault(),
            t.parent.isAnimating ||
              t.loadMore.hasClass("uewtk-l-loadMore-stop") ||
              (t.loadMore.addClass("uewtk-l-loadMore-loading"),
              t.populateItems().then(function () {
                t.populateInsertItems(e);
              }));
        });
      }),
      (o.prototype.auto = function () {
        var n = this,
          o = t(e),
          a = !1;
        function r() {
          var t;
          a ||
            n.loadMore.hasClass("uewtk-l-loadMore-stop") ||
            ((t = n.loadMore.offset().top - 200),
            o.scrollTop() + o.height() < t ||
              ((a = !0),
              n
                .populateItems()
                .then(function () {
                  n.populateInsertItems(s);
                })
                .fail(function () {
                  a = !1;
                })));
        }
        function s() {
          var t,
            e = n.parent.defaultFilter;
          0 ===
          (t =
            e && "*" !== e
              ? n.items.filter(n.parent.filterConcat(e)).length
              : n.items.length)
            ? n.loadMore
                .removeClass("uewtk-l-loadMore-loading")
                .addClass("uewtk-l-loadMore-stop")
            : (n.loadItems.html(t), o.trigger("scroll.loadMore")),
            (a = !1),
            0 === n.items.length &&
              (i.private.loadMoreScroll.destroyEvent(n),
              n.parent.$obj.off("filterComplete.uewtk"));
        }
        (i.private.loadMoreScroll = new i.private.publicEvents(
          "scroll.loadMore",
          100
        )),
          n.parent.$obj.one("initComplete.uewtk", function () {
            n.loadMore
              .addClass("uewtk-l-loadMore-loading")
              .on("click.uewtk", function (t) {
                t.preventDefault();
              }),
              i.private.loadMoreScroll.initEvent({
                instance: n,
                fn: function () {
                  n.parent.isAnimating || r();
                },
              }),
              n.parent.$obj.on("filterComplete.uewtk", function () {
                r();
              }),
              r();
          });
      }),
      (o.prototype.destroy = function () {
        this.loadMore.off(".uewtk"),
          i.private.loadMoreScroll &&
            i.private.loadMoreScroll.destroyEvent(this);
      }),
      (i.plugins.loadMore = function (t) {
        var e = t.options.plugins;
        return (
          t.options.loadMore &&
            (e.loadMore || (e.loadMore = {}),
            (e.loadMore.element = t.options.loadMore)),
          t.options.loadMoreAction &&
            (e.loadMore || (e.loadMore = {}),
            (e.loadMore.action = t.options.loadMoreAction)),
          e.loadMore &&
            void 0 !== e.loadMore.selector &&
            ((e.loadMore.element = e.loadMore.selector),
            delete e.loadMore.selector),
          e.loadMore && e.loadMore.element ? new o(t) : null
        );
      });
  })(jQuery, window, document),
  (function (t, e, n) {
    "use strict";
    var i = t.fn.cubeportfolio.constructor,
      o = { delay: 0 },
      a = {
        init: function (e, i) {
          var a,
            r,
            s,
            l,
            p,
            c,
            d,
            u = this;
          (u.cubeportfolio = e),
            (u.type = i),
            (u.isOpen = !1),
            (u.options = u.cubeportfolio.options),
            "lightbox" === i &&
              (u.cubeportfolio.registerEvent("resizeWindow", function () {
                u.resizeImage();
              }),
              (u.localOptions = t.extend(
                {},
                o,
                u.cubeportfolio.options.plugins.lightbox
              ))),
            "singlePageInline" !== i
              ? (u.createMarkup(),
                "singlePage" === i &&
                  (u.cubeportfolio.registerEvent("resizeWindow", function () {
                    var t;
                    !u.options.singlePageStickyNavigation ||
                      (0 < (t = u.contentWrap[0].clientWidth) &&
                        (u.navigationWrap.width(t), u.navigation.width(t)));
                  }),
                  u.options.singlePageDeeplinking &&
                    ((u.url = location.href),
                    "#" === u.url.slice(-1) && (u.url = u.url.slice(0, -1)),
                    (d = (c = u.url.split("#uewtk=")).shift()),
                    t.each(c, function (e, n) {
                      if (
                        (u.cubeportfolio.blocksOn.each(function (e, i) {
                          var o = t(i).find(
                            u.options.singlePageDelegate + '[href="' + n + '"]'
                          );
                          if (o.length) return (a = o), !1;
                        }),
                        a)
                      )
                        return !1;
                    }),
                    a
                      ? ((u.url = d),
                        (s = (r = a).attr("data-uewtk-singlePage")),
                        (l = []),
                        s
                          ? (l = r
                              .closest(t(".uewtk-item"))
                              .find('[data-uewtk-singlePage="' + s + '"]'))
                          : u.cubeportfolio.blocksOn.each(function (e, n) {
                              var i = t(n);
                              i.not(".uewtk-item-off") &&
                                i
                                  .find(u.options.singlePageDelegate)
                                  .each(function (e, n) {
                                    t(n).attr("data-uewtk-singlePage") ||
                                      l.push(n);
                                  });
                            }),
                        u.openSinglePage(l, a[0]))
                      : c.length &&
                        ((p = n.createElement("a")).setAttribute("href", c[0]),
                        u.openSinglePage([p], p))),
                  (u.localOptions = t.extend(
                    {},
                    o,
                    u.cubeportfolio.options.plugins.singlePage
                  ))))
              : ((u.height = 0),
                u.createMarkupSinglePageInline(),
                u.cubeportfolio.registerEvent("resizeGrid", function () {
                  u.isOpen && u.close();
                }),
                u.options.singlePageInlineDeeplinking &&
                  ((u.url = location.href),
                  "#" === u.url.slice(-1) && (u.url = u.url.slice(0, -1)),
                  (d = (c = u.url.split("#uewtki=")).shift()),
                  t.each(c, function (e, n) {
                    if (
                      (u.cubeportfolio.blocksOn.each(function (e, i) {
                        var o = t(i).find(
                          u.options.singlePageInlineDelegate +
                            '[href="' +
                            n +
                            '"]'
                        );
                        if (o.length) return (a = o), !1;
                      }),
                      a)
                    )
                      return !1;
                  }),
                  a &&
                    u.cubeportfolio.registerEvent(
                      "initFinish",
                      function () {
                        u.openSinglePageInline(u.cubeportfolio.blocksOn, a[0]);
                      },
                      !0
                    )),
                (u.localOptions = t.extend(
                  {},
                  o,
                  u.cubeportfolio.options.plugins.singlePageInline
                )));
        },
        createMarkup: function () {
          var o = this,
            a = "";
          if (
            ("singlePage" === o.type &&
              "left" !== o.options.singlePageAnimation &&
              (a = " uewtk-popup-singlePage-" + o.options.singlePageAnimation),
            (o.wrap = t("<div/>", {
              class: "uewtk-popup-wrap uewtk-popup-" + o.type + a,
              "data-action": "lightbox" === o.type ? "close" : "",
            }).on("click.uewtk", function (e) {
              var n;
              o.stopEvents ||
                ((n = t(e.target).attr("data-action")),
                o[n] && (o[n](), e.preventDefault()));
            })),
            "singlePage" === o.type
              ? ((o.contentWrap = t("<div/>", {
                  class: "uewtk-popup-content-wrap",
                }).appendTo(o.wrap)),
                "ios" === i.private.browser &&
                  o.contentWrap.css("overflow", "auto"),
                (o.content = t("<div/>", {
                  class: "uewtk-popup-content",
                }).appendTo(o.contentWrap)))
              : (o.content = t("<div/>", {
                  class: "uewtk-popup-content",
                }).appendTo(o.wrap)),
            t("<div/>", { class: "uewtk-popup-loadingBox" }).appendTo(o.wrap),
            "ie8" === i.private.browser &&
              (o.bg = t("<div/>", {
                class: "uewtk-popup-ie8bg",
                "data-action": "lightbox" === o.type ? "close" : "",
              }).appendTo(o.wrap)),
            "singlePage" === o.type &&
            !1 === o.options.singlePageStickyNavigation
              ? (o.navigationWrap = t("<div/>", {
                  class: "uewtk-popup-navigation-wrap",
                }).appendTo(o.contentWrap))
              : (o.navigationWrap = t("<div/>", {
                  class: "uewtk-popup-navigation-wrap",
                }).appendTo(o.wrap)),
            (o.navigation = t("<div/>", {
              class: "uewtk-popup-navigation",
            }).appendTo(o.navigationWrap)),
            (o.closeButton = t("<div/>", {
              class: "uewtk-popup-close",
              title: "Close (Esc arrow key)",
              "data-action": "close",
            }).appendTo(o.navigation)),
            (o.nextButton = t("<div/>", {
              class: "uewtk-popup-next",
              title: "Next (Right arrow key)",
              "data-action": "next",
            }).appendTo(o.navigation)),
            (o.prevButton = t("<div/>", {
              class: "uewtk-popup-prev",
              title: "Previous (Left arrow key)",
              "data-action": "prev",
            }).appendTo(o.navigation)),
            "singlePage" === o.type)
          ) {
            o.options.singlePageCounter &&
              ((o.counter = t(o.options.singlePageCounter).appendTo(
                o.navigation
              )),
              o.counter.text("")),
              o.content.on(
                "click.uewtk",
                o.options.singlePageDelegate,
                function (t) {
                  t.preventDefault();
                  for (
                    var e,
                      i,
                      a = o.dataArray.length,
                      r = this.getAttribute("href"),
                      s = 0;
                    s < a;
                    s++
                  )
                    if (o.dataArray[s].url === r) {
                      e = s;
                      break;
                    }
                  void 0 === e
                    ? ((i = n.createElement("a")).setAttribute("href", r),
                      (o.dataArray = [{ url: r, element: i }]),
                      (o.counterTotal = 1),
                      o.nextButton.hide(),
                      o.prevButton.hide(),
                      o.singlePageJumpTo(0))
                    : o.singlePageJumpTo(e - o.current);
                }
              );
            var r = !1;
            try {
              var l = Object.defineProperty({}, "passive", {
                get: function () {
                  r = { passive: !0 };
                },
              });
              e.addEventListener("testPassive", null, l),
                e.removeEventListener("testPassive", null, l);
            } catch (a) {}
            var p =
              "onwheel" in n.createElement("div") ? "wheel" : "mousewheel";
            o.contentWrap[0].addEventListener(
              p,
              function (t) {
                t.stopImmediatePropagation();
              },
              r
            );
          }
          t(n).on("keydown.uewtk", function (t) {
            o.isOpen &&
              (o.stopEvents ||
                (s && t.stopImmediatePropagation(),
                37 === t.keyCode
                  ? o.prev()
                  : 39 === t.keyCode
                  ? o.next()
                  : 27 === t.keyCode && o.close()));
          });
        },
        createMarkupSinglePageInline: function () {
          var e = this;
          (e.wrap = t("<div/>", { class: "uewtk-popup-singlePageInline" }).on(
            "click.uewtk",
            function (n) {
              var i;
              e.stopEvents ||
                ((i = t(n.target).attr("data-action")) &&
                  e[i] &&
                  (e[i](), n.preventDefault()));
            }
          )),
            (e.content = t("<div/>", { class: "uewtk-popup-content" }).appendTo(
              e.wrap
            )),
            (e.navigation = t("<div/>", {
              class: "uewtk-popup-navigation",
            }).appendTo(e.wrap)),
            (e.closeButton = t("<div/>", {
              class: "uewtk-popup-close",
              title: "Close (Esc arrow key)",
              "data-action": "close",
            }).appendTo(e.navigation));
        },
        destroy: function () {
          var e = this,
            i = t("body");
          t(n).off("keydown.uewtk"),
            i.off("click.uewtk", e.options.lightboxDelegate),
            i.off("click.uewtk", e.options.singlePageDelegate),
            e.content.off("click.uewtk", e.options.singlePageDelegate),
            e.cubeportfolio.$obj.off(
              "click.uewtk",
              e.options.singlePageInlineDelegate
            ),
            e.cubeportfolio.$obj.off("click.uewtk", e.options.lightboxDelegate),
            e.cubeportfolio.$obj.off(
              "click.uewtk",
              e.options.singlePageDelegate
            ),
            e.cubeportfolio.$obj.removeClass("uewtk-popup-isOpening"),
            e.cubeportfolio.$obj
              .find(".uewtk-item")
              .removeClass("uewtk-singlePageInline-active"),
            e.wrap.remove();
        },
        openLightbox: function (i, o) {
          var a,
            r,
            l = this,
            p = 0,
            c = [];
          if (!l.isOpen) {
            if (
              ((s = !0),
              (l.isOpen = !0),
              (l.stopEvents = !1),
              (l.dataArray = []),
              (l.current = null) === (a = o.getAttribute("href")))
            )
              throw new Error(
                "HEI! Your clicked element doesn't have a href attribute."
              );
            t.each(i, function (e, n) {
              var i,
                o,
                r = n.getAttribute("href"),
                s = r,
                d = "isImage";
              if (-1 === t.inArray(r, c)) {
                if (a === r) l.current = p;
                else if (!l.options.lightboxGallery) return;
                /youtu\.?be/i.test(r)
                  ? (1 === (o = r.lastIndexOf("v=") + 2) &&
                      (o = r.lastIndexOf("/") + 1),
                    (i = r.substring(o)),
                    /autoplay=/i.test(i) || (i += "&autoplay=1"),
                    (s =
                      "//www.youtube.com/embed/" +
                      (i = i.replace(/\?|&/, "?"))),
                    (d = "isYoutube"))
                  : /vimeo\.com/i.test(r)
                  ? ((i = r.substring(r.lastIndexOf("/") + 1)),
                    /autoplay=/i.test(i) || (i += "&autoplay=1"),
                    (s =
                      "//player.vimeo.com/video/" +
                      (i = i.replace(/\?|&/, "?"))),
                    (d = "isVimeo"))
                  : /www\.ted\.com/i.test(r)
                  ? ((s =
                      "http://embed.ted.com/talks/" +
                      r.substring(r.lastIndexOf("/") + 1) +
                      ".html"),
                    (d = "isTed"))
                  : /soundcloud\.com/i.test(r)
                  ? ((s = r), (d = "isSoundCloud"))
                  : /(\.mp4)|(\.ogg)|(\.ogv)|(\.webm)/i.test(r)
                  ? ((s =
                      -1 !== r.indexOf("|") ? r.split("|") : r.split("%7C")),
                    (d = "isSelfHostedVideo"))
                  : /\.mp3$/i.test(r) && ((s = r), (d = "isSelfHostedAudio")),
                  l.dataArray.push({
                    src: s,
                    title: n.getAttribute(l.options.lightboxTitleSrc),
                    type: d,
                  }),
                  p++;
              }
              c.push(r);
            }),
              (l.counterTotal = l.dataArray.length),
              1 === l.counterTotal
                ? (l.nextButton.hide(),
                  l.prevButton.hide(),
                  (l.dataActionImg = ""))
                : (l.nextButton.show(),
                  l.prevButton.show(),
                  (l.dataActionImg = 'data-action="next"')),
              l.wrap.appendTo(n.body),
              (l.scrollTop = t(e).scrollTop()),
              (l.originalStyle = t("html").attr("style")),
              t("html").css({
                overflow: "hidden",
                marginRight: e.innerWidth - t(n).width(),
              }),
              l.wrap.addClass("uewtk-popup-transitionend"),
              l.wrap.show(),
              (r = l.dataArray[l.current]),
              l[r.type](r);
          }
        },
        openSinglePage: function (o, a) {
          var r,
            s,
            l = this,
            p = 0,
            c = [];
          if (!l.isOpen) {
            if (
              (l.cubeportfolio.singlePageInline &&
                l.cubeportfolio.singlePageInline.isOpen &&
                l.cubeportfolio.singlePageInline.close(),
              (l.isOpen = !0),
              (l.stopEvents = !1),
              (l.dataArray = []),
              (l.current = null) === (r = a.getAttribute("href")))
            )
              throw new Error(
                "HEI! Your clicked element doesn't have a href attribute."
              );
            t.each(o, function (e, n) {
              var i = n.getAttribute("href");
              -1 === t.inArray(i, c) &&
                (r === i && (l.current = p),
                l.dataArray.push({ url: i, element: n }),
                p++),
                c.push(i);
            }),
              (l.counterTotal = l.dataArray.length),
              1 === l.counterTotal
                ? (l.nextButton.hide(), l.prevButton.hide())
                : (l.nextButton.show(), l.prevButton.show()),
              l.wrap.appendTo(n.body),
              (l.scrollTop = t(e).scrollTop()),
              l.contentWrap.scrollTop(0),
              l.wrap.show(),
              (l.finishOpen = 2),
              (l.navigationMobile = t()),
              l.wrap.one(i.private.transitionend, function () {
                t("html").css({
                  overflow: "hidden",
                  marginRight: e.innerWidth - t(n).width(),
                }),
                  l.wrap.addClass("uewtk-popup-transitionend"),
                  l.options.singlePageStickyNavigation &&
                    (l.wrap.addClass("uewtk-popup-singlePage-sticky"),
                    l.navigationWrap.width(l.contentWrap[0].clientWidth)),
                  l.finishOpen--,
                  l.finishOpen <= 0 && l.updateSinglePageIsOpen.call(l);
              }),
              ("ie8" !== i.private.browser && "ie9" !== i.private.browser) ||
                (t("html").css({
                  overflow: "hidden",
                  marginRight: e.innerWidth - t(n).width(),
                }),
                l.wrap.addClass("uewtk-popup-transitionend"),
                l.options.singlePageStickyNavigation &&
                  (l.navigationWrap.width(l.contentWrap[0].clientWidth),
                  setTimeout(function () {
                    l.wrap.addClass("uewtk-popup-singlePage-sticky");
                  }, 1e3)),
                l.finishOpen--),
              l.wrap.addClass("uewtk-popup-loading"),
              l.wrap.offset(),
              l.wrap.addClass("uewtk-popup-singlePage-open"),
              l.options.singlePageDeeplinking &&
                ((l.url = l.url.split("#uewtk=")[0]),
                (location.href =
                  l.url + "#uewtk=" + l.dataArray[l.current].url)),
              t.isFunction(l.options.singlePageCallback) &&
                l.options.singlePageCallback.call(
                  l,
                  l.dataArray[l.current].url,
                  l.dataArray[l.current].element
                ),
              "ios" === i.private.browser &&
                (s = l.contentWrap[0]).addEventListener(
                  "touchstart",
                  function () {
                    var t = s.scrollTop,
                      e = s.scrollHeight,
                      n = t + s.offsetHeight;
                    0 === t
                      ? (s.scrollTop = 1)
                      : n === e && (s.scrollTop = t - 1);
                  }
                );
          }
        },
        openSinglePageInline: function (n, i, o) {
          var a,
            r,
            s,
            l,
            p,
            c,
            d,
            u = this;
          if (
            ((o = o || !1),
            (u.fromOpen = o),
            (u.storeBlocks = n),
            (u.storeCurrentBlock = i),
            u.isOpen)
          )
            return (
              (r = u.cubeportfolio.blocksOn.index(t(i).closest(".uewtk-item"))),
              void (u.dataArray[u.current].url !== i.getAttribute("href") ||
              u.current !== r
                ? u.cubeportfolio.singlePageInline.close("open", {
                    blocks: n,
                    currentBlock: i,
                    fromOpen: !0,
                  })
                : u.close())
            );
          if (
            ((u.isOpen = !0),
            (u.stopEvents = !1),
            (u.dataArray = []),
            (u.current = null) === (a = i.getAttribute("href")))
          )
            throw new Error(
              "HEI! Your clicked element doesn't have a href attribute."
            );
          (s = t(i).closest(".uewtk-item")[0]),
            n.each(function (t, e) {
              s === e && (u.current = t);
            }),
            (u.dataArray[u.current] = { url: a, element: i }),
            t(u.dataArray[u.current].element)
              .parents(".uewtk-item")
              .addClass("uewtk-singlePageInline-active"),
            (u.counterTotal = n.length),
            u.wrap.insertBefore(u.cubeportfolio.wrapper),
            (u.topDifference = 0),
            "top" === u.options.singlePageInlinePosition
              ? ((u.blocksToMove = n), (u.top = 0))
              : "bottom" === u.options.singlePageInlinePosition
              ? ((u.blocksToMove = t()), (u.top = u.cubeportfolio.height))
              : "above" === u.options.singlePageInlinePosition
              ? ((l = t(n[u.current]).data("uewtk").top),
                (u.top = l),
                n.each(function (e, n) {
                  var i = t(n).data("uewtk"),
                    o = i.top,
                    a = o + i.heightAndGap;
                  l <= o ||
                    (a > u.top && ((u.top = a), (u.topDifference = u.top - l)));
                }),
                (u.blocksToMove = t()),
                n.each(function (e, n) {
                  var i;
                  (e === u.current ||
                    (i = t(n).data("uewtk")).top + i.heightAndGap > u.top) &&
                    (u.blocksToMove = u.blocksToMove.add(n));
                }),
                (u.top = Math.max(u.top - u.options.gapHorizontal, 0)))
              : ((p = t(n[u.current]).data("uewtk")),
                (c = p.top + p.heightAndGap),
                (u.top = c),
                (u.blocksToMove = t()),
                n.each(function (e, n) {
                  var i = t(n).data("uewtk"),
                    o = i.top,
                    a = o + i.height;
                  a <= c ||
                    (o >= c - i.height / 2
                      ? (u.blocksToMove = u.blocksToMove.add(n))
                      : c < a &&
                        o < c &&
                        (a > u.top && (u.top = a),
                        a - c > u.topDifference && (u.topDifference = a - c)));
                })),
            (u.wrap[0].style.height = u.wrap.outerHeight(!0) + "px"),
            (u.deferredInline = t.Deferred()),
            u.options.singlePageInlineInFocus
              ? ((u.scrollTop = t(e).scrollTop()),
                (d = u.cubeportfolio.$obj.offset().top + u.top - 100),
                u.scrollTop !== d
                  ? t("html,body")
                      .animate({ scrollTop: d }, 350)
                      .promise()
                      .then(function () {
                        u.resizeSinglePageInline(), u.deferredInline.resolve();
                      })
                  : (u.resizeSinglePageInline(), u.deferredInline.resolve()))
              : (u.resizeSinglePageInline(), u.deferredInline.resolve()),
            u.cubeportfolio.$obj.addClass("uewtk-popup-singlePageInline-open"),
            u.wrap.css({ top: u.top }),
            u.options.singlePageInlineDeeplinking &&
              ((u.url = u.url.split("#uewtki=")[0]),
              (location.href =
                u.url + "#uewtki=" + u.dataArray[u.current].url)),
            t.isFunction(u.options.singlePageInlineCallback) &&
              u.options.singlePageInlineCallback.call(
                u,
                u.dataArray[u.current].url,
                u.dataArray[u.current].element
              );
        },
        resizeSinglePageInline: function () {
          var t = this;
          (t.height =
            0 === t.top || t.top === t.cubeportfolio.height
              ? t.wrap.outerHeight(!0)
              : t.wrap.outerHeight(!0) - t.options.gapHorizontal),
            (t.height += t.topDifference),
            t.storeBlocks.each(function (t, e) {
              i.private.modernBrowser
                ? (e.style[i.private.transform] = "")
                : (e.style.marginTop = "");
            }),
            t.blocksToMove.each(function (e, n) {
              i.private.modernBrowser
                ? (n.style[i.private.transform] =
                    "translate3d(0px, " + t.height + "px, 0)")
                : (n.style.marginTop = t.height + "px");
            }),
            (t.cubeportfolio.obj.style.height =
              t.cubeportfolio.height + t.height + "px");
        },
        revertResizeSinglePageInline: function () {
          (this.deferredInline = t.Deferred()),
            this.storeBlocks.each(function (t, e) {
              i.private.modernBrowser
                ? (e.style[i.private.transform] = "")
                : (e.style.marginTop = "");
            }),
            (this.cubeportfolio.obj.style.height =
              this.cubeportfolio.height + "px");
        },
        appendScriptsToWrap: function (t) {
          var e = this,
            i = 0,
            o = function (a) {
              var r = n.createElement("script"),
                s = a.src;
              (r.type = "text/javascript"),
                r.readyState
                  ? (r.onreadystatechange = function () {
                      ("loaded" != r.readyState &&
                        "complete" != r.readyState) ||
                        ((r.onreadystatechange = null), t[++i] && o(t[i]));
                    })
                  : (r.onload = function () {
                      t[++i] && o(t[i]);
                    }),
                s ? (r.src = s) : (r.text = a.text),
                e.content[0].appendChild(r);
            };
          o(t[0]);
        },
        updateSinglePage: function (e, n, i) {
          var o,
            a = this;
          a.content
            .addClass("uewtk-popup-content")
            .removeClass("uewtk-popup-content-basic"),
            !1 === i &&
              a.content
                .removeClass("uewtk-popup-content")
                .addClass("uewtk-popup-content-basic"),
            a.counter &&
              ((o = t(
                a.getCounterMarkup(
                  a.options.singlePageCounter,
                  a.current + 1,
                  a.counterTotal
                )
              )),
              a.counter.text(o.text())),
            (a.fromAJAX = { html: e, scripts: n }),
            a.finishOpen--,
            a.finishOpen <= 0 && a.updateSinglePageIsOpen.call(a);
        },
        updateSinglePageIsOpen: function () {
          var t,
            e = this;
          e.wrap.addClass("uewtk-popup-ready"),
            e.wrap.removeClass("uewtk-popup-loading"),
            e.content.html(e.fromAJAX.html),
            e.fromAJAX.scripts && e.appendScriptsToWrap(e.fromAJAX.scripts),
            (e.fromAJAX = {}),
            e.cubeportfolio.$obj.trigger("updateSinglePageStart.uewtk"),
            (t = e.content.find(".uewtk-slider")).length
              ? (t.find(".uewtk-slider-item").addClass("uewtk-item"),
                (e.slider = t.cubeportfolio({
                  layoutMode: "slider",
                  mediaQueries: [{ width: 1, cols: 1 }],
                  gapHorizontal: 0,
                  gapVertical: 0,
                  caption: "",
                  coverRatio: "",
                })))
              : (e.slider = null),
            e.checkForSocialLinks(e.content),
            e.cubeportfolio.$obj.trigger("updateSinglePageComplete.uewtk");
        },
        checkForSocialLinks: function (t) {
          this.createFacebookShare(t.find(".uewtk-social-fb")),
            this.createTwitterShare(t.find(".uewtk-social-twitter")),
            this.createGooglePlusShare(t.find(".uewtk-social-googleplus")),
            this.createPinterestShare(t.find(".uewtk-social-pinterest"));
        },
        createFacebookShare: function (t) {
          t.length &&
            !t.attr("onclick") &&
            t.attr(
              "onclick",
              "window.open('http://www.facebook.com/sharer.php?u=" +
                encodeURIComponent(e.location.href) +
                "', '_blank', 'top=100,left=100,toolbar=0,status=0,width=620,height=400'); return false;"
            );
        },
        createTwitterShare: function (t) {
          t.length &&
            !t.attr("onclick") &&
            t.attr(
              "onclick",
              "window.open('https://twitter.com/intent/tweet?source=" +
                encodeURIComponent(e.location.href) +
                "&text=" +
                encodeURIComponent(n.title) +
                "', '_blank', 'top=100,left=100,toolbar=0,status=0,width=620,height=300'); return false;"
            );
        },
        createGooglePlusShare: function (t) {
          t.length &&
            !t.attr("onclick") &&
            t.attr(
              "onclick",
              "window.open('https://plus.google.com/share?url=" +
                encodeURIComponent(e.location.href) +
                "', '_blank', 'top=100,left=100,toolbar=0,status=0,width=620,height=450'); return false;"
            );
        },
        createPinterestShare: function (t) {
          var n, i;
          t.length &&
            !t.attr("onclick") &&
            ((n = ""),
            (i = this.content.find("img")[0]) && (n = i.src),
            t.attr(
              "onclick",
              "window.open('http://pinterest.com/pin/create/button/?url=" +
                encodeURIComponent(e.location.href) +
                "&media=" +
                n +
                "', '_blank', 'top=100,left=100,toolbar=0,status=0,width=620,height=400'); return false;"
            ));
        },
        updateSinglePageInline: function (t, e) {
          var n = this;
          n.content.html(t),
            e && n.appendScriptsToWrap(e),
            n.cubeportfolio.$obj.trigger("updateSinglePageInlineStart.uewtk"),
            0 !== n.localOptions.delay
              ? setTimeout(function () {
                  n.singlePageInlineIsOpen.call(n);
                }, n.localOptions.delay)
              : n.singlePageInlineIsOpen.call(n);
        },
        singlePageInlineIsOpen: function () {
          var t = this;
          function e() {
            t.wrap.addClass("uewtk-popup-singlePageInline-ready"),
              (t.wrap[0].style.height = ""),
              t.resizeSinglePageInline(),
              t.cubeportfolio.$obj.trigger(
                "updateSinglePageInlineComplete.uewtk"
              );
          }
          t.cubeportfolio.loadImages(t.wrap, function () {
            var n = t.content.find(".uewtk-slider");
            n.length
              ? (n.find(".uewtk-slider-item").addClass("uewtk-item"),
                n.one("initComplete.uewtk", function () {
                  t.deferredInline.done(e);
                }),
                n.on("pluginResize.uewtk", function () {
                  t.deferredInline.done(e);
                }),
                (t.slider = n.cubeportfolio({
                  layoutMode: "slider",
                  displayType: "default",
                  mediaQueries: [{ width: 1, cols: 1 }],
                  gapHorizontal: 0,
                  gapVertical: 0,
                  caption: "",
                  coverRatio: "",
                })))
              : ((t.slider = null), t.deferredInline.done(e)),
              t.checkForSocialLinks(t.content);
          });
        },
        isImage: function (e) {
          var n = this;
          new Image(),
            n.tooggleLoading(!0),
            n.cubeportfolio.loadImages(
              t('<div><img src="' + e.src + '"></div>'),
              function () {
                n.updateImagesMarkup(
                  e.src,
                  e.title,
                  n.getCounterMarkup(
                    n.options.lightboxCounter,
                    n.current + 1,
                    n.counterTotal
                  )
                ),
                  n.tooggleLoading(!1);
              }
            );
        },
        isVimeo: function (t) {
          var e = this;
          e.updateVideoMarkup(
            t.src,
            t.title,
            e.getCounterMarkup(
              e.options.lightboxCounter,
              e.current + 1,
              e.counterTotal
            )
          );
        },
        isYoutube: function (t) {
          var e = this;
          e.updateVideoMarkup(
            t.src,
            t.title,
            e.getCounterMarkup(
              e.options.lightboxCounter,
              e.current + 1,
              e.counterTotal
            )
          );
        },
        isTed: function (t) {
          var e = this;
          e.updateVideoMarkup(
            t.src,
            t.title,
            e.getCounterMarkup(
              e.options.lightboxCounter,
              e.current + 1,
              e.counterTotal
            )
          );
        },
        isSoundCloud: function (t) {
          var e = this;
          e.updateVideoMarkup(
            t.src,
            t.title,
            e.getCounterMarkup(
              e.options.lightboxCounter,
              e.current + 1,
              e.counterTotal
            )
          );
        },
        isSelfHostedVideo: function (t) {
          var e = this;
          e.updateSelfHostedVideo(
            t.src,
            t.title,
            e.getCounterMarkup(
              e.options.lightboxCounter,
              e.current + 1,
              e.counterTotal
            )
          );
        },
        isSelfHostedAudio: function (t) {
          var e = this;
          e.updateSelfHostedAudio(
            t.src,
            t.title,
            e.getCounterMarkup(
              e.options.lightboxCounter,
              e.current + 1,
              e.counterTotal
            )
          );
        },
        getCounterMarkup: function (t, e, n) {
          if (!t.length) return "";
          var i = { current: e, total: n };
          return t.replace(/\{\{current}}|\{\{total}}/gi, function (t) {
            return i[t.slice(2, -2)];
          });
        },
        updateSelfHostedVideo: function (t, e, n) {
          this.wrap.addClass("uewtk-popup-lightbox-isIframe");
          for (
            var i =
                '<div class="uewtk-popup-lightbox-iframe"><video controls="controls" height="auto" style="width: 100%">',
              o = 0;
            o < t.length;
            o++
          )
            /(\.mp4)/i.test(t[o])
              ? (i += '<source src="' + t[o] + '" type="video/mp4">')
              : /(\.ogg)|(\.ogv)/i.test(t[o])
              ? (i += '<source src="' + t[o] + '" type="video/ogg">')
              : /(\.webm)/i.test(t[o]) &&
                (i += '<source src="' + t[o] + '" type="video/webm">');
          (i +=
            'Your browser does not support the video tag.</video><div class="uewtk-popup-lightbox-bottom">' +
            (e
              ? '<div class="uewtk-popup-lightbox-title">' + e + "</div>"
              : "") +
            n +
            "</div></div>"),
            this.content.html(i),
            this.wrap.addClass("uewtk-popup-ready"),
            this.preloadNearbyImages();
        },
        updateSelfHostedAudio: function (t, e, n) {
          this.wrap.addClass("uewtk-popup-lightbox-isIframe");
          var i =
            '<div class="uewtk-popup-lightbox-iframe"><div class="uewtk-misc-video"><audio controls="controls" height="auto" style="width: 75%"><source src="' +
            t +
            '" type="audio/mpeg">Your browser does not support the audio tag.</audio></div><div class="uewtk-popup-lightbox-bottom">' +
            (e
              ? '<div class="uewtk-popup-lightbox-title">' + e + "</div>"
              : "") +
            n +
            "</div></div>";
          this.content.html(i),
            this.wrap.addClass("uewtk-popup-ready"),
            this.preloadNearbyImages();
        },
        updateVideoMarkup: function (t, e, n) {
          this.wrap.addClass("uewtk-popup-lightbox-isIframe");
          var i =
            '<div class="uewtk-popup-lightbox-iframe"><iframe src="' +
            t +
            '" frameborder="0" allowfullscreen scrolling="no"></iframe><div class="uewtk-popup-lightbox-bottom">' +
            (e
              ? '<div class="uewtk-popup-lightbox-title">' + e + "</div>"
              : "") +
            n +
            "</div></div>";
          this.content.html(i),
            this.wrap.addClass("uewtk-popup-ready"),
            this.preloadNearbyImages();
        },
        updateImagesMarkup: function (t, e, n) {
          var i = this;
          i.wrap.removeClass("uewtk-popup-lightbox-isIframe");
          var o =
            '<div class="uewtk-popup-lightbox-figure"><img src="' +
            t +
            '" class="uewtk-popup-lightbox-img" ' +
            i.dataActionImg +
            ' /><div class="uewtk-popup-lightbox-bottom">' +
            (e
              ? '<div class="uewtk-popup-lightbox-title">' + e + "</div>"
              : "") +
            n +
            "</div></div>";
          i.content.html(o),
            i.wrap.addClass("uewtk-popup-ready"),
            i.resizeImage(),
            i.preloadNearbyImages();
        },
        next: function () {
          this[this.type + "JumpTo"](1);
        },
        prev: function () {
          this[this.type + "JumpTo"](-1);
        },
        lightboxJumpTo: function (t) {
          var e,
            n = this;
          (n.current = n.getIndex(n.current + t)),
            n[(e = n.dataArray[n.current]).type](e);
        },
        singlePageJumpTo: function (e) {
          var n = this;
          (n.current = n.getIndex(n.current + e)),
            t.isFunction(n.options.singlePageCallback) &&
              (n.resetWrap(),
              n.contentWrap.scrollTop(0),
              n.wrap.addClass("uewtk-popup-loading"),
              n.slider &&
                i.private.resize.destroyEvent(
                  t.data(n.slider[0], "cubeportfolio")
                ),
              n.options.singlePageCallback.call(
                n,
                n.dataArray[n.current].url,
                n.dataArray[n.current].element
              ),
              n.options.singlePageDeeplinking &&
                (location.href =
                  n.url + "#uewtk=" + n.dataArray[n.current].url));
        },
        resetWrap: function () {
          var t = this;
          "singlePage" === t.type &&
            t.options.singlePageDeeplinking &&
            (location.href = t.url + "#"),
            "singlePageInline" === t.type &&
              t.options.singlePageInlineDeeplinking &&
              (location.href = t.url + "#");
        },
        getIndex: function (t) {
          return (t %= this.counterTotal) < 0 && (t = this.counterTotal + t), t;
        },
        close: function (n, o) {
          var a = this;
          function r() {
            a.slider &&
              i.private.resize.destroyEvent(
                t.data(a.slider[0], "cubeportfolio")
              ),
              a.content.html(""),
              a.wrap.detach(),
              a.cubeportfolio.$obj.removeClass(
                "uewtk-popup-singlePageInline-open uewtk-popup-singlePageInline-close"
              ),
              (a.isOpen = !1),
              "promise" === n &&
                t.isFunction(o.callback) &&
                o.callback.call(a.cubeportfolio);
          }
          function l() {
            var i = t(e).scrollTop();
            a.resetWrap(),
              t(e).scrollTop(i),
              a.options.singlePageInlineInFocus && "promise" !== n
                ? t("html,body")
                    .animate({ scrollTop: a.scrollTop }, 350)
                    .promise()
                    .then(function () {
                      r();
                    })
                : r();
          }
          "singlePageInline" === a.type
            ? "open" === n
              ? (a.wrap.removeClass("uewtk-popup-singlePageInline-ready"),
                t(a.dataArray[a.current].element)
                  .closest(".uewtk-item")
                  .removeClass("uewtk-singlePageInline-active"),
                (a.isOpen = !1),
                a.openSinglePageInline(o.blocks, o.currentBlock, o.fromOpen))
              : ((a.height = 0),
                a.revertResizeSinglePageInline(),
                a.wrap.removeClass("uewtk-popup-singlePageInline-ready"),
                a.cubeportfolio.$obj.addClass(
                  "uewtk-popup-singlePageInline-close"
                ),
                a.cubeportfolio.$obj
                  .find(".uewtk-item")
                  .removeClass("uewtk-singlePageInline-active"),
                i.private.modernBrowser
                  ? a.wrap.one(i.private.transitionend, function () {
                      l();
                    })
                  : l())
            : "singlePage" === a.type
            ? (a.resetWrap(),
              (a.stopScroll = !0),
              a.wrap.removeClass(
                "uewtk-popup-ready uewtk-popup-transitionend uewtk-popup-singlePage-open uewtk-popup-singlePage-sticky"
              ),
              t("html").css({ overflow: "", marginRight: "", position: "" }),
              t(e).scrollTop(a.scrollTop),
              ("ie8" !== i.private.browser && "ie9" !== i.private.browser) ||
                (a.slider &&
                  i.private.resize.destroyEvent(
                    t.data(a.slider[0], "cubeportfolio")
                  ),
                a.content.html(""),
                a.wrap.detach(),
                (a.isOpen = !1)),
              a.wrap.one(i.private.transitionend, function () {
                a.slider &&
                  i.private.resize.destroyEvent(
                    t.data(a.slider[0], "cubeportfolio")
                  ),
                  a.content.html(""),
                  a.wrap.detach(),
                  (a.isOpen = !1);
              }))
            : ((s = !1),
              a.originalStyle
                ? t("html").attr("style", a.originalStyle)
                : t("html").css({ overflow: "", marginRight: "" }),
              t(e).scrollTop(a.scrollTop),
              a.slider &&
                i.private.resize.destroyEvent(
                  t.data(a.slider[0], "cubeportfolio")
                ),
              a.content.html(""),
              a.wrap.detach(),
              (a.isOpen = !1));
        },
        tooggleLoading: function (t) {
          (this.stopEvents = t),
            this.wrap[t ? "addClass" : "removeClass"]("uewtk-popup-loading");
        },
        resizeImage: function () {
          var n, i, o;
          this.isOpen &&
            ((i = (n = this.content.find("img")).parent()),
            (o =
              t(e).height() -
              (i.outerHeight(!0) - i.height()) -
              this.content
                .find(".uewtk-popup-lightbox-bottom")
                .outerHeight(!0)),
            n.css("max-height", o + "px"));
        },
        preloadNearbyImages: function () {
          for (
            var t = this,
              e = [
                t.getIndex(t.current + 1),
                t.getIndex(t.current + 2),
                t.getIndex(t.current + 3),
                t.getIndex(t.current - 1),
                t.getIndex(t.current - 2),
                t.getIndex(t.current - 3),
              ],
              n = e.length - 1;
            0 <= n;
            n--
          )
            "isImage" === t.dataArray[e[n]].type &&
              t.cubeportfolio.checkSrc(t.dataArray[e[n]]);
        },
      };
    function r(t) {
      var e = this;
      !1 === (e.parent = t).options.lightboxShowCounter &&
        (t.options.lightboxCounter = ""),
        !1 === t.options.singlePageShowCounter &&
          (t.options.singlePageCounter = ""),
        t.registerEvent(
          "initStartRead",
          function () {
            e.run();
          },
          !0
        );
    }
    var s = !1,
      l = !1,
      p = !1;
    (r.prototype.run = function () {
      var e = this,
        i = e.parent,
        o = t(n.body);
      (i.lightbox = null),
        i.options.lightboxDelegate &&
          !l &&
          ((l = !0),
          (i.lightbox = Object.create(a)),
          i.lightbox.init(i, "lightbox"),
          o.on("click.uewtk", i.options.lightboxDelegate, function (n) {
            n.preventDefault();
            var o = t(this),
              a = o.attr("data-uewtk-lightbox"),
              r = e.detectScope(o),
              s = r.data("cubeportfolio"),
              l = [];
            s
              ? s.blocksOn.each(function (e, n) {
                  var o = t(n);
                  o.not(".uewtk-item-off") &&
                    o.find(i.options.lightboxDelegate).each(function (e, n) {
                      (a && t(n).attr("data-uewtk-lightbox") !== a) ||
                        l.push(n);
                    });
                })
              : (l = a
                  ? r.find(
                      i.options.lightboxDelegate +
                        "[data-uewtk-lightbox=" +
                        a +
                        "]"
                    )
                  : r.find(i.options.lightboxDelegate)),
              i.lightbox.openLightbox(l, o[0]);
          })),
        (i.singlePage = null),
        i.options.singlePageDelegate &&
          !p &&
          ((p = !0),
          (i.singlePage = Object.create(a)),
          i.singlePage.init(i, "singlePage"),
          o.on("click.uewtk", i.options.singlePageDelegate, function (n) {
            n.preventDefault();
            var o = t(this),
              a = o.attr("data-uewtk-singlePage"),
              r = e.detectScope(o),
              s = r.data("cubeportfolio"),
              l = [];
            s
              ? s.blocksOn.each(function (e, n) {
                  var o = t(n);
                  o.not(".uewtk-item-off") &&
                    o.find(i.options.singlePageDelegate).each(function (e, n) {
                      (a && t(n).attr("data-uewtk-singlePage") !== a) ||
                        l.push(n);
                    });
                })
              : (l = a
                  ? r.find(
                      i.options.singlePageDelegate +
                        "[data-uewtk-singlePage=" +
                        a +
                        "]"
                    )
                  : r.find(i.options.singlePageDelegate)),
              i.singlePage.openSinglePage(l, o[0]);
          })),
        (i.singlePageInline = null),
        i.options.singlePageInlineDelegate &&
          ((i.singlePageInline = Object.create(a)),
          i.singlePageInline.init(i, "singlePageInline"),
          i.$obj.on(
            "click.uewtk",
            i.options.singlePageInlineDelegate,
            function (e) {
              e.preventDefault();
              var n = t.data(this, "uewtk-locked"),
                o = t.data(this, "uewtk-locked", +new Date());
              (!n || 300 < o - n) &&
                i.singlePageInline.openSinglePageInline(i.blocksOn, this);
            }
          ));
    }),
      (r.prototype.detectScope = function (e) {
        var i, o, a;
        return (i = e.closest(".uewtk-popup-singlePageInline")).length
          ? (a = e.closest(".uewtk", i[0])).length
            ? a
            : i
          : (o = e.closest(".uewtk-popup-singlePage")).length
          ? (a = e.closest(".uewtk", o[0])).length
            ? a
            : o
          : (a = e.closest(".uewtk")).length
          ? a
          : t(n.body);
      }),
      (r.prototype.destroy = function () {
        var e = this.parent;
        t(n.body).off("click.uewtk"),
          (p = l = !1),
          e.lightbox && e.lightbox.destroy(),
          e.singlePage && e.singlePage.destroy(),
          e.singlePageInline && e.singlePageInline.destroy();
      }),
      (i.plugins.popUp = function (t) {
        return new r(t);
      });
  })(jQuery, window, document),
  (function (t) {
    "use strict";
    var e = t.fn.cubeportfolio.constructor;
    function n(e) {
      var n = this;
      (n.parent = e),
        (n.searchInput = t(e.options.search)),
        n.searchInput.each(function (e, n) {
          var i = (i = n.getAttribute("data-search")) || "*";
          t.data(n, "searchData", { value: n.value, el: i });
        });
      var i = null;
      n.searchInput.on("keyup.uewtk paste.uewtk", function (e) {
        e.preventDefault();
        var o = t(this);
        clearTimeout(i),
          (i = setTimeout(function () {
            n.runEvent.call(n, o);
          }, 350));
      }),
        (n.searchNothing = n.searchInput
          .siblings(".uewtk-search-nothing")
          .detach()),
        (n.searchNothingHeight = null),
        (n.searchNothingHTML = n.searchNothing.html()),
        n.searchInput
          .siblings(".uewtk-search-icon")
          .on("click.uewtk", function (e) {
            e.preventDefault(), n.runEvent.call(n, t(this).prev().val(""));
          });
    }
    (n.prototype.runEvent = function (e) {
      var n = this,
        i = e.val(),
        o = e.data("searchData"),
        a = new RegExp(i, "i");
      o.value === i ||
        n.parent.isAnimating ||
        (0 < (o.value = i).length ? e.attr("value", i) : e.removeAttr("value"),
        n.parent.$obj.cubeportfolio(
          "filter",
          function (e) {
            var r,
              s = e.filter(function (e, n) {
                if (-1 < t(n).find(o.el).text().search(a)) return !0;
              });
            return (
              0 === s.length && n.searchNothing.length
                ? ((r = n.searchNothingHTML.replace("{{query}}", i)),
                  n.searchNothing.html(r),
                  n.searchNothing.appendTo(n.parent.$obj),
                  null === n.searchNothingHeight &&
                    (n.searchNothingHeight = n.searchNothing.outerHeight(!0)),
                  n.parent.registerEvent(
                    "resizeMainContainer",
                    function () {
                      (n.parent.height =
                        n.parent.height + n.searchNothingHeight),
                        (n.parent.obj.style.height = n.parent.height + "px");
                    },
                    !0
                  ))
                : n.searchNothing.detach(),
              n.parent.triggerEvent("resetFiltersVisual"),
              s
            );
          },
          function () {
            e.trigger("keyup.uewtk");
          }
        ));
    }),
      (n.prototype.destroy = function () {
        this.searchInput.off(".uewtk"),
          this.searchInput.next(".uewtk-search-icon").off(".uewtk"),
          this.searchInput.each(function (e, n) {
            t.removeData(n);
          });
      }),
      (e.plugins.search = function (t) {
        return "" === t.options.search ? null : new n(t);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = { pagination: "", paginationClass: "uewtk-pagination-active" },
      n = t.fn.cubeportfolio.constructor;
    function i(n) {
      var i = this;
      (i.parent = n),
        (i.options = t.extend({}, e, i.parent.options.plugins.slider));
      var o = t(i.options.pagination);
      0 < o.length &&
        ((i.parent.customPagination = o),
        (i.parent.customPaginationItems = o.children()),
        (i.parent.customPaginationClass = i.options.paginationClass),
        i.parent.customPaginationItems.on("click.uewtk", function (e) {
          e.preventDefault(),
            e.stopImmediatePropagation(),
            e.stopPropagation(),
            i.parent.sliderStopEvents || i.parent.jumpToSlider(t(this));
        })),
        i.parent.registerEvent(
          "gridAdjust",
          function () {
            i.sliderMarkup.call(i.parent),
              i.parent.registerEvent("gridAdjust", function () {
                i.updateSlider.call(i.parent);
              });
          },
          !0
        );
    }
    (i.prototype.sliderMarkup = function () {
      var e = this;
      (e.sliderStopEvents = !1),
        (e.sliderActive = 0),
        e.$obj.one("initComplete.uewtk", function () {
          e.$obj.addClass("uewtk-mode-slider");
        }),
        (e.nav = t("<div/>", { class: "uewtk-nav" })),
        e.nav.on("click.uewtk", "[data-slider-action]", function (n) {
          var i, o;
          n.preventDefault(),
            n.stopImmediatePropagation(),
            n.stopPropagation(),
            e.sliderStopEvents ||
              ((o = (i = t(this)).attr("data-slider-action")),
              e[o + "Slider"] && e[o + "Slider"](i));
        }),
        e.options.showNavigation &&
          ((e.controls = t("<div/>", { class: "uewtk-nav-controls" })),
          (e.navPrev = t("<div/>", {
            class: "uewtk-nav-prev",
            "data-slider-action": "prev",
          }).appendTo(e.controls)),
          (e.navNext = t("<div/>", {
            class: "uewtk-nav-next",
            "data-slider-action": "next",
          }).appendTo(e.controls)),
          e.controls.appendTo(e.nav)),
        e.options.showPagination &&
          (e.navPagination = t("<div/>", {
            class: "uewtk-nav-pagination",
          }).appendTo(e.nav)),
        (e.controls || e.navPagination) && e.nav.appendTo(e.$obj),
        e.updateSliderPagination(),
        e.options.auto &&
          (e.options.autoPauseOnHover &&
            ((e.mouseIsEntered = !1),
            e.$obj
              .on("mouseenter.uewtk", function (t) {
                (e.mouseIsEntered = !0), e.stopSliderAuto();
              })
              .on("mouseleave.uewtk", function (t) {
                (e.mouseIsEntered = !1), e.startSliderAuto();
              })),
          e.startSliderAuto()),
        e.options.drag && n.private.modernBrowser && e.dragSlider();
    }),
      (i.prototype.updateSlider = function () {
        this.updateSliderPosition(), this.updateSliderPagination();
      }),
      (i.prototype.destroy = function () {
        var t = this;
        t.parent.customPaginationItems &&
          t.parent.customPaginationItems.off(".uewtk"),
          (t.parent.controls || t.parent.navPagination) &&
            (t.parent.nav.off(".uewtk"), t.parent.nav.remove());
      }),
      (n.plugins.slider = function (t) {
        return "slider" !== t.options.layoutMode ? null : new i(t);
      });
  })(jQuery, (window, document)),
  (function (t) {
    "use strict";
    var e = { element: "" },
      n = t.fn.cubeportfolio.constructor;
    function i(n) {
      var i = this;
      (i.parent = n),
        (i.options = t.extend({}, e, i.parent.options.plugins.sort)),
        (i.element = t(i.options.element)),
        0 !== i.element.length &&
          ((i.sort = ""),
          (i.sortBy = "string:asc"),
          i.element.on("click.uewtk", ".uewtk-sort-item", function (e) {
            e.preventDefault(),
              (i.target = e.target),
              t(i.target).hasClass("uewtk-l-dropdown-item--active") ||
                n.isAnimating ||
                (i.processSort(),
                n.$obj.cubeportfolio("filter", n.defaultFilter));
          }),
          n.registerEvent("triggerSort", function () {
            i.target &&
              (i.processSort(),
              n.$obj.cubeportfolio("filter", n.defaultFilter));
          }),
          (i.dropdownWrap = i.element.find(".uewtk-l-dropdown-wrap").on({
            "mouseover.uewtk": function () {
              t(this).addClass("uewtk-l-dropdown-wrap--open");
            },
            "mouseleave.uewtk": function () {
              t(this).removeClass("uewtk-l-dropdown-wrap--open");
            },
          })),
          (i.dropdownHeader = i.element.find(".uewtk-l-dropdown-header")));
    }
    (i.prototype.processSort = function () {
      var e = this,
        n = e.parent,
        i = (c = e.target).hasAttribute("data-sort"),
        o = c.hasAttribute("data-sortBy");
      if (i && o)
        (e.sort = c.getAttribute("data-sort")),
          (e.sortBy = c.getAttribute("data-sortBy"));
      else if (i) e.sort = c.getAttribute("data-sort");
      else {
        if (!o) return;
        e.sortBy = c.getAttribute("data-sortBy");
      }
      var a,
        r,
        s = e.sortBy.split(":"),
        l = "string",
        p = 1;
      "int" === s[0] ? (l = "int") : "float" === s[0] && (l = "float"),
        "desc" === s[1] && (p = -1),
        e.sort
          ? ((a = []),
            n.blocks.each(function (n, i) {
              var o = t(i),
                r = o.find(e.sort).text();
              "int" === l && (r = parseInt(r, 10)),
                "float" === l && (r = parseFloat(r, 10)),
                a.push({ sortText: r, data: o.data("uewtk") });
            }),
            a.sort(function (t, e) {
              var n = t.sortText,
                i = e.sortText;
              return (
                "string" === l &&
                  ((n = n.toUpperCase()), (i = i.toUpperCase())),
                n < i ? -p : i < n ? p : 0
              );
            }),
            t.each(a, function (t, e) {
              e.data.index = t;
            }))
          : ((r = []),
            -1 === p &&
              (n.blocks.each(function (e, n) {
                r.push(t(n).data("uewtk").indexInitial);
              }),
              r.sort(function (t, e) {
                return e - t;
              })),
            n.blocks.each(function (e, n) {
              var i = t(n).data("uewtk");
              i.index = -1 === p ? r[i.indexInitial] : i.indexInitial;
            })),
        n.sortBlocks(n.blocks, "index"),
        e.dropdownWrap.trigger("mouseleave.uewtk");
      var c = t(e.target),
        d = t(e.target).parent();
      d.hasClass("uewtk-l-dropdown-list")
        ? (e.dropdownHeader.html(c.html()),
          c
            .addClass("uewtk-l-dropdown-item--active")
            .siblings(".uewtk-l-dropdown-item")
            .removeClass("uewtk-l-dropdown-item--active"))
        : d.hasClass("uewtk-l-direction") &&
          (0 === c.index()
            ? d
                .addClass("uewtk-l-direction--second")
                .removeClass("uewtk-l-direction--first")
            : d
                .addClass("uewtk-l-direction--first")
                .removeClass("uewtk-l-direction--second"));
    }),
      (i.prototype.destroy = function () {
        this.element.off("click.uewtk");
      }),
      (n.plugins.sort = function (t) {
        return new i(t);
      });
  })(jQuery, (window, document));
